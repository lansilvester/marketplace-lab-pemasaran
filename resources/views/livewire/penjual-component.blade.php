<main id="main" class="main-site left-sidebar" style="min-height: 80vh">
    @php
    $penjual =  $products[0]->user;
    @endphp
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">Home</a></li>
                <li class="item-link"><a href="{{ route('product.shop') }}"><span>Shop</span></a></li>
                <li class="item-link">
                    <span>
                        {{ $penjual->name }}
                    </span>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                <div class="row bg-info" style="padding:20px 0">
                    <div class="col-md-2">
                        <img src="{{ asset('assets/images/profile') }}/{{ $penjual->profile->image }}" alt="">
                    </div>
                    <div class="col-md-6">
                        <h2>{{ $penjual->name }}</h2>
                        <h5>Bergabung Sejak : <i>{{ $penjual->created_at->diffForHumans() }}</i></h5>
                        @if ($penjual->name == 'admin')
                        <h5>Total Product : <i>{{ $penjual->product->count()-1 }}</i></h5>
                        @else
                        <h5>Total Products : <i>{{ $penjual->product->count() }}</i></h5>
                        @endif

                        <a href="https://www.google.com/maps?q={!! $penjual->profile->latitude !!},{!! $penjual->profile->longitude !!}" class="btn btn-primary" target="__blank"><i class="fa fa-map"></i> Map</a>

                    </div>
                    <div class="col-md-4">
                        <h4>
                            <i class="bi bi-telephone"></i> {{ $penjual->profile->mobile }}
                        </h4>
                        <address>
                            <h5>
                                Kode Pos : <b>{{ $penjual->profile->zipcode }}</b>
                            </h4>
                            <h5>

                                {{ $penjual->profile->city }}, {{ $penjual->profile->province }}
                            </h4>
                        </address>
                        <a href="{{ $penjual->profile->facebook }}" style="font-size:2em; color: #074aaf; margin-right:1em" target="__blank"><i class="bi bi-facebook"></i></a>
                        <a href="{{ $penjual->profile->instagram }}" style="font-size:2em; color: #c6018e" target="__blank"><i class="bi bi-instagram"></i></a>

                    </div>
                </div>
                @php
                $product_unggulan = DB::table('products')->where('featured', true)->where('user_id', $penjual->id)->get();
                @endphp
                @if ($product_unggulan->count() > 0)

                <div class="row bg-primary" style="padding:20px; border-radius:1em;box-shadow:5px 5px 20px 10px rgba(0,0,0,.15); margin-top:3em">
                    <h4 style="padding:0px 20px">Produk <span style="background:#fe9000; display:inline-block;padding:.5em; border-radius:1em">Unggulan</span> </h5>
                    <div class="row">
                        @foreach ($product_unggulan as $p_unggulan)
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <img src="{{ asset('assets/images/products') }}/{{ $p_unggulan->image }}" alt="" width="150px">
                            </div>
                            <div class="col-md-6">
                                <h2>{{ $p_unggulan->name }}</h2>
                                <h4 style="color:#ccc">@currency($p_unggulan->sale_price)</h4>
                                {!! $p_unggulan->short_description !!}
                                <a href="{{ route('product.details', ['slug'=>$p_unggulan->slug]) }}" class="btn btn-success">Lihat Product <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="wrap-shop-control">
                    <h1 class="shop-title">All Products</h1>
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
                </style>
                <div class="row">
                    <ul class="product-list grid-products equal-container">
                        @php
                            $witems = Cart::instance('wishlist')->content()->pluck('id');
                        @endphp
                        @foreach($products as $product)
                        @if ($product->image !== 'default-product.jpg' && $product->count() > 0)
                            <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                                <div class="product product-style-3 equal-elem ">
                                    <div class="product-thumnail">
                                        <a href="{{ route('product.details',['slug'=>$product->slug]) }}" title="{{ $product->name }}">
                                            <figure><img src="{{ asset('assets/images/products') }}/{{ $product->image }}" alt="{{ $product->name }}"></figure>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('product.details',['slug'=>$product->slug]) }}" class="product-name"><span style="font-weight: bold; font-size:1.8em; line-height:1.5em">{{ $product->name }}</span></a>
                                        <div class="wrap-price"><span class="product-price">@currency($product->sale_price)</span></div>

                                        {{-- <a href="#" class="btn add-to-cart" wire:click.prevent="store({{ $product->id}},'{{ $product->name }}',{{ $product->sale_price }})">Add To Cart</a> --}}

                                        @if (Auth::check() && Auth::user()->utype == 'USR')
                                            @if(Auth::user()->status === 1)
                                            <div class="product-wish">
                                                @if($witems->contains($product->id))
                                                    <a href="#" wire:click.prevent="removeFromWishlist({{ $product->id }})"><i class="fa fa-heart fill-heart"></i></a>
                                                @else
                                                    <a href="#" wire:click.prevent="addToWishlist({{ $product->id}},'{{ $product->name }}',{{ $product->sale_price }})"><i class="fa fa-heart"></i></a>
                                                @endif
                                            </div>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </li>
                        @endif

                        @if ($product->image == 'default-product.jpg' && $product->count() == 0)
                        <li>
                            <h5 class="text-danger">Tidak ada produk</h5>
                        </li>
                        @endif

                        @endforeach
                    </ul>

                </div>
                <div class="wrap-pagination-info">
                    {{$products->links()}}
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                <div class="widget mercado-widget categories-widget">
                    <h2 class="widget-title">All Categories</h2>
                    <div class="widget-content">
                        <ul class="list-category">
                        @foreach($categories as $category)
                        <li class="category-item has-child-cate">
                            <a href="{{ route('product.category', ['category_slug'=>$category->slug]) }}" class="cate-link">{{ $category->name }}</a>
                        </li>
                        @endforeach
                        </ul>
                    </div>
                </div>

                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title">Popular Products</h2>
                    <div class="widget-content">
                        <ul class="products">
                            @foreach ($popular_products as $pp)

                            <li class="product-item">
                                <div class="product product-widget-style">
                                    <div class="thumbnnail">
                                        <a href="{{ route('product.details', ['slug'=>$pp->product->slug]) }}" title="{{ $pp->product->name }}">
                                            <figure><img src="{{ asset('assets/images/products') }}/{{ $pp->product->image }}" alt=""></figure>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('product.details', ['slug'=>$pp->product->slug]) }}" class="product-name"><span>{{ $pp->product->name }}</span></a>
                                        <div class="wrap-price"><span class="product-price">{{ $pp->product->sale_price }}</span></div>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                {{-- End Popular products --}}
            </div>

        </div>

    </div>

</main>
