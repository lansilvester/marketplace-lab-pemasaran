<main id="main" class="main-site left-sidebar" style="min-height: 80vh">

		<div class="container">

			<div class="wrap-breadcrumb">
				<ul>
					<li class="item-link"><a href="/" class="link">home</a></li>
					<li class="item-link"><span>Shop</span></li>
				</ul>
			</div>
			<div class="row">

				<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
					<div class="wrap-shop-control">
						<h1 class="shop-title">Semua Product</h1>

						<div class="wrap-right">
							<div class="sort-item orderby ">
								<select name="orderby" class="use-chosen" wire:model="sorting">
									<option value="default" selected="selected">Default sorting</option>
									<option value="date">Product Terbaru</option>
									<option value="price">Product Termurah</option>
									<option value="price-desc">Product Termahal</option>
								</select>
							</div>

							<div class="sort-item product-per-page">
								<select name="post-per-page" class="use-chosen" wire:model="pagesize">
									<option value="12" selected="selected">12 per page</option>
									<option value="16">16 per page</option>
									<option value="18">18 per page</option>
									<option value="21">21 per page</option>
									<option value="24">24 per page</option>
									<option value="30">30 per page</option>
									<option value="32">32 per page</option>
								</select>
							</div>

			
						</div>

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
								@if($product->image !== 'default-product.jpg' && $product->count() > 0)
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
												<a href="{{ route('product.penjual', ['penjual'=>$product->user->id]) }}">
													<div style="
														background:#efefef;
														padding:5px;
														border-radius:10px;
													">
													@if($product->user->profile->image)
														<img src="{{ asset('assets/images/profile') }}/{{ $product->user->profile->image }}" width="50px" alt="">
														@else
														
														<img src="https://www.perpustakaan-bi.org/img/user/blank.png" width="50px" alt="">
													@endif	
														<b>{{ $product->user->name }}</b>
													</div>
												</a>

												{{-- <a href="#" class="btn add-to-cart" wire:click.prevent="store({{ $product->id}},'{{ $product->name }}',{{ $product->regular_price }})">Add To Cart</a> --}}
												
												@if (Auth::check() && Auth::user()->utype == 'USR' && Auth::user()->status === 1)
												<div class="product-wish">
													@if($witems->contains($product->id))
														<a href="#" wire:click.prevent="removeFromWishlist({{ $product->id }})"><i class="fa fa-heart fill-heart"></i></a>
													@else
														<a href="#" wire:click.prevent="addToWishlist({{ $product->id}},'{{ $product->name }}',{{ $product->sale_price }})"><i class="fa fa-heart"></i></a>
													@endif
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
								@foreach ($product_populer as $pp)

								<li class="product-item">
									<div class="product product-widget-style">
										<div class="thumbnnail">
											<a href="{{ route('product.details', ['slug'=>$pp->product->slug]) }}" title="{{ $pp->product->name }}">
												<figure><img src="{{ asset('assets/images/products') }}/{{ $pp->product->image }}" alt=""></figure>
											</a>
										</div>
										<div class="product-info">
											<a href="{{ route('product.details',['slug'=>$pp->product->slug]) }}" class="product-name"><span>{{ $pp->product->name }}</span></a>
											<div class="wrap-price"><span class="product-price"> @currency($pp->product->sale_price) </span></div>
											</div>
										</div>
								</li>
								@endforeach

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

</main>