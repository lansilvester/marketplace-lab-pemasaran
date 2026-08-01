<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\AdminAddProductComponent;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAddProductFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_product_persists_and_stores_image(): void
    {
        $admin = User::factory()->create();
        $category = Category::factory()->create();
        $dir = public_path('assets/images/products');

        $component = Livewire::actingAs($admin)
            ->test(AdminAddProductComponent::class)
            ->set('name', 'Kopi Arabika')
            ->set('slug', 'kopi-arabika')
            ->set('short_description', 'Kopi premium')
            ->set('description', 'Kopi asli dari dataran tinggi')
            ->set('sale_price', 150000)
            ->set('stock_status', 'instock')
            ->set('featured', 0)
            ->set('quantity', 10)
            ->set('image', UploadedFile::fake()->image('kopi.jpg'))
            ->set('category_id', $category->id)
            ->call('addProduct');

        $component->assertHasNoErrors();

        $product = Product::where('slug', 'kopi-arabika')->first();

        $this->assertNotNull($product);
        $this->assertSame('Kopi Arabika', $product->name);
        $this->assertSame($category->id, $product->category_id);
        $this->assertSame($admin->id, $product->user_id);
        $this->assertFileExists($dir.'/'.$product->image);
    }
}
