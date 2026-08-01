<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Session-backed cart used by the marketplace.
 *
 * This intentionally preserves the small API surface used by the existing
 * Livewire components while removing the unmaintained shopping-cart package.
 */
class Cart
{
    public static function instance(string $name = 'cart'): CartInstance
    {
        return new CartInstance($name);
    }

    public static function add(mixed ...$arguments): CartItem
    {
        return self::instance()->add(...$arguments);
    }
}

class CartInstance
{
    public function __construct(private readonly string $name) {}

    public function add(int|string $id, string $name, int $quantity, float|int|string $price): CartItem
    {
        $items = $this->content();
        $rowId = md5($id.'|'.$this->name);
        $item = $items->get($rowId) ?? new CartItem($rowId, $id, $name, $quantity, (float) $price);

        if ($items->has($rowId)) {
            $item->qty += $quantity;
        }

        $items->put($rowId, $item);
        $this->save($items);

        return $item;
    }

    public function content(): Collection
    {
        return collect(session()->get($this->key(), []))->mapWithKeys(
            fn (CartItem|array $item, string $rowId) => [$rowId => $item instanceof CartItem ? $item : CartItem::fromArray($item)]
        );
    }

    public function get(string $rowId): ?CartItem
    {
        return $this->content()->get($rowId);
    }

    public function update(string $rowId, int $quantity): void
    {
        $items = $this->content();
        $item = $items->get($rowId);

        if (! $item) {
            return;
        }

        if ($quantity <= 0) {
            $items->forget($rowId);
        } else {
            $item->qty = $quantity;
            $items->put($rowId, $item);
        }

        $this->save($items);
    }

    public function remove(string $rowId): void
    {
        $items = $this->content();
        $items->forget($rowId);
        $this->save($items);
    }

    public function destroy(): void
    {
        session()->forget($this->key());
    }

    public function count(): int
    {
        return $this->content()->sum('qty');
    }

    public function subtotal(): string
    {
        return number_format($this->content()->sum(fn (CartItem $item) => $item->price * $item->qty), 2, '.', ',');
    }

    public function total(): string
    {
        return $this->subtotal();
    }

    public function store(string $identifier): void
    {
        session()->put("marketplace.saved-carts.{$identifier}.{$this->name}", $this->content()->map->toArray()->all());
    }

    public function restore(string $identifier): void
    {
        $saved = session()->get("marketplace.saved-carts.{$identifier}.{$this->name}", []);
        $this->save(collect($saved)->mapWithKeys(fn (array $item, string $rowId) => [$rowId => CartItem::fromArray($item)]));
    }

    private function save(Collection $items): void
    {
        session()->put($this->key(), $items->map->toArray()->all());
    }

    private function key(): string
    {
        return "marketplace.cart.{$this->name}";
    }
}

class CartItem
{
    public ?string $modelClass = null;

    public function __construct(
        public readonly string $rowId,
        public readonly int|string $id,
        public readonly string $name,
        public int $qty,
        public readonly float $price,
    ) {
        $this->modelClass = Product::class;
    }

    public function associate(string $modelClass): self
    {
        $this->modelClass = $modelClass;

        return $this;
    }

    public function __get(string $property): mixed
    {
        if ($property === 'model' && $this->modelClass && class_exists($this->modelClass)) {
            return $this->modelClass::find($this->id);
        }

        if (in_array($property, ['total', 'subtotal'])) {
            return $this->price * $this->qty;
        }

        return null;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromArray(array $item): self
    {
        $cartItem = new self($item['rowId'], $item['id'], $item['name'], $item['qty'], (float) $item['price']);
        $cartItem->modelClass = $item['modelClass'] ?? null;

        return $cartItem;
    }
}
