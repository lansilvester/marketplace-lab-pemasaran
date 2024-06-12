
<main id="main" class="main-site left-sidebar" style="min-height: 80vh">
    <script>
    </script>
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Wishlist</span></li>
            </ul>
        </div>
        <style>
            .product-wish{
                position: absolute;
                top:10%;
                left:0;
                z-index: 99;
                right: 30px;
                text-align:right;
                padding-top:0;
            }
            .product-wish .fa{
                color:#cbcbcb;
                font-size:32px;
                transition: .15s;

            }
            .product-wish .fa:hover{
                color:#ff7007;
                transform: scale(1.5);
            }
            .fill-heart{
                color: #ff7007 !important;
            }
            #add-wishlist:hover{
                border:none;
            }
        </style>
        <div class="row">
           
            @if (Session::has('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif
            @if(Auth::check())
                @if(Cart::instance('wishlist')->content()->count() > 0)
                <ul class="product-list grid-products equal-container">
                    {{-- {{ dd(Cart::instance('wishlist')->content()) }} --}}
                    @foreach(Cart::instance('wishlist')->content() as $item)
                        
                    <li class="col-lg-3 col-md-6 col-sm-6 col-xs-6 ">
                        <div class="product product-style-3 equal-elem ">
                            <div class="product-thumnail">
                                <a href="{{ route('product.details',['slug'=>$item->model->slug]) }}" title="{{ $item->model->name }}">
                                    <figure><img src="{{ asset('assets/images/products') }}/{{ $item->model->image }}" alt="{{ $item->model->name }}"></figure>
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="{{ route('product.details',['slug'=>$item->model->slug]) }}" class="product-name"><span>{{ $item->model->name }}</span></a>
                                    <div class="wrap-price"><span class="product-price">@currency($item->model->sale_price)</span></div>
                                    {{-- <a href="#" class="btn add-to-cart" wire:click.prevent="moveProductFromWishlistToCart('{{ $item->rowId }}')">Move To Cart</a> --}}
                                    <div class="product-wish">
                                </div>
                                @if (Auth::check())
                                {{-- <b>
                                    @if($review->product_id !== $item->id && $review->product_id !== NULL)
                                    <a href="">Review</a>
                                    @else
                                    <a href="">Edit</a>
                                    @endif
                                </b> --}}
                               
                                <div class="wrap-price"><span class="product-price"><a href="{{ route('user.review',['item_id'=>$item->id]) }}">Review</a></span></div>

                                @else
                                <p>Please login for review</p>
                                @endif
                                    <a href="#" id="add-wishlist" class="btn add-to-cart" wire:click.prevent="removeFromWishlist({{ $item->model->id }})"><i class="fa fa-heart fill-heart"></i> &nbsp; Hapus dari Wishlist</a>
                            
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                    <h4>No item in wishlist</h4>
                @endif

            @else
                <h1 class="text-center">Please Login</h1>
                <a href="" class="btn btn-primary">Login</a>
            @endif
        </div>
    </div>
</main>