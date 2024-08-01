<main id="main" class="main-site">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Checkout</span></li>
            </ul>
        </div>
        <div class="main-content-area">
            <div class="wrap-iten-in-cart">
                @if(Session::has('message'))
                <div class="alert alert-success">
                    <strong>Success</strong> {{ Session::get('message') }}
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
                    <span class="badge" style="margin:10px 0px; background-color:#008ec6; font-size:1.3em; padding:.3em .6em;"><i class="bi bi-shop"></i> {{ $item->model->user->name }}</span>
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
                                <input type="text" name="product-quatity" value="{{ $item->qty }}" data-max="{{ $item->model->quantity }}" pattern="[0-9]*" disabled>
                            </div>
                        </div>
                        <div class="price-field sub-total"><p class="price">Rp.{{ $item->subtotal }}</p></div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="alert alert-warning text-center">Kosong</div>
                @endif
            </div>

            <div class="summary">
                <div class="order-summary">
                    <p class="summary-info total-info"><span class="title">Total</span><b class="index">Rp.{{ Cart::instance('cart')->total() }}</b></p>
                </div>

                <div class="checkout-info">
                    <form enctype="multipart/form-data" wire:submit.prevent="checkout">
                        <div class="form-group">
                            <label for="images">Upload Bukti Transfer:</label>
                            <input type="file" class="form-control" id="images" wire:model="images" multiple required>
                            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror

                            @if ($imagePreviews)
                                <div class="form-group">
                                    <label for="preview">Preview:</label>
                                    @foreach ($imagePreviews as $preview)
                                        <img src="{{ $preview }}" alt="Preview Image" width="200">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success btn-block mb-3 fw-bold"><i class="fa fa-send"></i> Kirim</button>
                    </form>

                </div>
            </div>
        </div><!--end main content area-->
    </div><!--end container-->
</main>
