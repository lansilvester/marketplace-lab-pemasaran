	<!--main area-->
	<main id="main" class="main-site left-sidebar">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="#" class="link">home</a></li>
					<li class="item-link"><span>Product</span></li>
				</ul>
			</div>
			<div class="row">

				<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">

					<div class="banner-shop">
						<a href="#" class="banner-link">
							<figure><img src="assets/images/shop-banner.jpg" alt=""></figure>
						</a>
					</div>

					<div class="wrap-shop-control">

						<h1 class="shop-title">All Producs by <i>' {{ $search }} ' </i></h1>
						<a href="{{ route('product.shop') }}" class="btn btn-outline-primary"><i class="bi bi-x-square"></i> Clear Search</a>
						{{-- <div class="wrap-right">
							<div class="sort-item orderby ">
								<select name="orderby" class="use-chosen" wire:model="sorting">
									<option value="default" selected="selected">Default sorting</option>
									<option value="date">Sort by newness</option>
									<option value="price">Sort by price: low to high</option>
									<option value="price-desc">Sort by price: high to low</option>
								</select>
							</div>
							<div class="sort-item product-per-page">
								<select name="post-per-page" class="use-chosen"  wire:model="pagesize">
									<option value="12" selected="selected">12 per page</option>
									<option value="16">16 per page</option>
									<option value="18">18 per page</option>
									<option value="21">21 per page</option>
									<option value="24">24 per page</option>
									<option value="30">30 per page</option>
									<option value="32">32 per page</option>
								</select>
							</div>
						</div> --}}

					</div>
                    @if($products->count() > 0)
					<div class="row">

						<ul class="product-list grid-products equal-container">
						@foreach($products as $product)
							@if ($product->image !== 'default-product.jpg' && $product->count() > 0 )
							<li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
								<div class="product product-style-3 equal-elem ">
									<div class="product-thumnail">
										<a href="{{ route('product.details',['slug'=>$product->slug]) }}" title="{{ $product->name }}">
											<figure><img src="{{ asset('assets/images/products') }}/{{ $product->image }}" alt="{{ $product->name }}"></figure>
										</a>
									</div>
									<div class="product-info">
										<a href="{{ route('product.details',['slug'=>$product->slug]) }}" class="product-name">
                                            <h4>{{ $product->name }}</h4>
                                        </a>
										<div class="wrap-price">
                                            <span class="product-price">@currency($product->sale_price)</span>
                                        </div>
										<span style="
                                        background:#00b67c;
                                        color:white;
                                        padding:.5em 1em;
                                        line-height:2.5em;
                                        border-radius:5px;
                                        width:100%;
                                        ">Jarak <b>{{ number_format($product->distance, 2) }} Km</b></span>
										<a href="{{ route('product.details',['slug'=>$product->slug]) }}" class="btn add-to-cart"><span>Lihat Detail</span></a>
                                        @php
										$witems = Cart::instance('wishlist')->content()->pluck('id');
										@endphp

										@if(Auth::check())
										<div class="wrap-butons">
											{{-- <a href="#" class="btn add-to-cart" wire:click.prevent="store({{ $product->id }},'{{ $product->name }}', {{ $product->sale_price }})"><i class="fa fa-heart"></i> Tambah ke Wishlist</a> --}}
											@if (Auth::user()->utype == 'USR' && Auth::user()->utype == 'PNJ')
												@if($witems->contains($product->id))
													<a href="#" class="btn add-to-cart" wire:click.prevent="removeFromWishlist({{ $product->id }})"><i class="fa fa-heart fill-heart"></i> &nbsp; Hapus dari Wishlist</a>
												@else
													<a href="#" class="btn add-to-cart" wire:click.prevent="addToWishlist({{ $product->id}},'{{ $product->name }}',{{ $product->sale_price }})"><i class="fa fa-heart"></i> &nbsp; Tambah ke Wishlist</a>
												@endif
											@endif

											<div class="wrap-btn">
												<div class="product-wish">

												</div>
											</div>
										</div>
										@endif

									</div>
								</div>
							</li>
							@endif
							@if($product->image == 'default-product.jpg' && $product->count() == 1)
							<li><p class="text-center" style="padding:20px">Product Kosong</p></li>
							@endif
						@endforeach
						</ul>

					</div>
                    @else
                        <div class="alert alert-warning" style="margin:30px 0">Product <i>{{ $search }}</i> tidak ditemukan</div>
                    @endif
					<div class="wrap-pagination-info">
						{{-- {{$products->links()}} --}}
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
						<div class="widget-content" wire:ignore>
							<ul class="products">
								@foreach ($popular_product as $p_product)
								{{-- @for($i=0; $i <= $p_product->count();$i++) --}}
								<li class="product-item">
									<div class="product product-widget-style">
										<div class="thumbnnail">
											<a href="{{ route('product.details',['slug'=>$p_product->product->slug]) }}" title="">
												<figure><img src="{{ asset('assets/images/products') }}/{{ $p_product->product->image }}" alt="$p_product->name"></figure>
											</a>
										</div>
										<div class="product-info">
											<a href="{{ route('product.details',['slug'=>$p_product->product->slug]) }}" class="product-name"><span>{{ $p_product->product->name }}</span></a>
											<div class="wrap-price"><span class="product-price">@currency($p_product->product->sale_price)</span></div>
										</div>
									</div>
								</li>
								{{-- @endfor --}}
								@endforeach
							</ul>
						</div>
					</div><!-- brand widget-->

				</div><!--end sitebar-->

			</div><!--end row-->

		</div><!--end container-->

	</main>
	<!--main area-->
