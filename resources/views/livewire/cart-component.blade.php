	<main id="main" class="main-site">
		<div class="container">
			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="/" class="link">home</a></li>
					<li class="item-link"><span>Cart</span></li>
				</ul>
			</div>
			<div class=" main-content-area">
				<div class="wrap-iten-in-cart">
					@if(Session::has('success_message'))
					<div class="alert alert-success">
						<strong>Success</strong> {{ Session::get('success_message') }}
					</div>
					@endif
                    @if(Session::has('error_message'))
                    <div class="alert alert-danger">
                        <strong>Error</strong> {{ Session::get('error_message') }}
                    </div>
                    @endif
					@if(Cart::instance('cart')->count() > 0)
					<h3 class="box-title">Products Name</h3>
					<ul class="products-cart">
                        @foreach (Cart::instance('cart')->content() as $item)
                        <a href="{{ route('product.penjual',['penjual'=>$item->model->user->id]) }}">
                            <span class="badge" style="margin:10px 0px; background-color:#008ec6; font-size:1.3em; padding:.3em .6em;"><i class="bi bi-shop"></i> {{ $item->model->user->name }}</span>
                        </a>
                        <li class="pr-cart-item">
                            <div class="product-image">
                                <figure><img src="{{ asset('assets/images/products') }}/{{ $item->model->image }}" alt="{{ $item->model->name }}"></figure>
                            </div>
                            <div class="product-name">
                                <a class="link-to-product" href="{{ route('product.details', ['slug' => $item->model->slug])}}">{{ $item->model->name }}</a>
                            </div>
                            <div class="price-field produtc-price"><p class="price">{{ $item->model->regular_price }}</p></div>
                            <div class="quantity">
                                <div class="quantity-input">
                                    <input type="text" name="product-quatity" value="{{ $item->qty }}" data-max="{{ $item->model->quantity }}" pattern="[0-9]*" >
                                    <a class="btn btn-increase" href="#" wire:click.prevent="increaseQuantity('{{ $item->rowId }}')"
                                       @if($item->qty >= $item->model->quantity) disabled @endif></a>
                                    <a class="btn btn-reduce" href="#" wire:click.prevent="decreaseQuantity('{{ $item->rowId }}')"></a>
                                </div>
                                {{-- <p class="text-center"><a href="#" wire:click.prevent="switchToSaveForLater('{{ $item->rowId }}')">Save For Later</a></p> --}}
                            </div>
                            <div class="price-field sub-total"><p class="price">Rp.{{ $item->subtotal }}</p></div>
                            <div class="delete">
                                <a href="#" class="btn btn-delete" title="" wire:click.prevent="destroy('{{ $item->rowId }}')">
                                    <span>Delete from your cart</span>
                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
					@else
						<div class="alert alert-warning text-center">Kosong</div>
					@endif
				</div>

				<div class="summary">
					<div class="order-summary">
						<h4 class="title-box">Order Summary</h4>
						<p class="summary-info"><span class="title">Subtotal</span><b class="index">Rp. {{ Cart::instance('cart')->subtotal() }}</b></p>
						<p class="summary-info total-info">
							<span class="title">Total</span>
							<b class="index">Rp.{{ Cart::instance('cart')->total() }}</b>
						</p>
					</div>

					<div class="checkout-info">
                        @if (Cart::instance('cart')->count() > 0)
						<a class="btn btn-checkout" href="{{ route('product.checkout') }}">Check out</a>
                        @endif
						<a class="link-to-shop" href="{{ route('product.shop') }}">Continue Shopping<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
					</div>
					<div class="update-clear">
						<a class="btn btn-clear" href="#" wire:click.prevent="destroyAll()">Clear Shopping Cart</a>
						<a class="btn btn-update" href="#">Update Shopping Cart</a>
					</div>
				</div>

			</div>
		</div>

	</main>
