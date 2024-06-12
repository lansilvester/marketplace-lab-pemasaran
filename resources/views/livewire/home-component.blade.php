
	<main id="main" style="min-height: 80vh">
		<div class="container">

			<!--MAIN SLIDE-->
			<div class="wrap-main-slide">
				<div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true" data-dots="false">
					@foreach ($sliders as $slide)

					<div class="item-slide">
						<img src="{{ asset('assets/images/sliders') }}/{{ $slide->image }}" alt="{{ $slide->title }}" class="img-slide">
						<div class="slide-info slide-1">
							<h2 class="" style="font-weight: bold">{{ $slide->title }}</b></h2>
							<span class="subtitle" style="font-weight: bold">{{ $slide->subtitle }}</span>
							<p class="sale-info">{{ $slide->price }}</p>
							@if ($slide->link)
							<a href="{{ $slide->link }}" class="btn-link">Check</a>
							@endif
						</div>
					</div>
					@endforeach

				</div>
			</div>

			<!--BANNER-->

			{{-- Latest Products --}}
            <div class="row">
                <div class="wrap-show-advance-info-box style-1">
                    <h3 class="title-box">Product Terbaru</h3>
                    <div class="wrap-products">
                        <div class="wrap-product-tab tab-style-1">
                            <div class="tab-contents">
                                <div class="tab-content-item active" id="digital_1a">
                                    <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
                                        @forelse ($lproducts as $lp)
                                        <div class="product product-style-2 equal-elem ">
                                            <div class="product-thumnail">
                                                <a href="{{ route('product.details',['slug'=>$lp->slug]) }}" title="{{ $lp->name }}">
                                                    <figure><img src="{{ asset('assets/images/products') }}/{{ $lp->image }}" width="800" height="800" alt="{{ $lp->name }}"></figure>
                                                </a>
                                                <div class="group-flash">
                                                    <span class="flash-item new-label">new</span>
                                                </div>
                                                <div class="wrap-btn">
                                                    <a href="{{ route('product.details', ['slug'=>$lp->slug]) }}" class="function-link">Lihat Product</a>
                                                </div>
                                            </div>
                                            <div class="product-info">

                                                <h4>{{ $lp->name }}</h4>
                                                    <a href="{{ route('product.category',['category_slug'=>$lp->category->slug]) }}" class="product-name">
                                                        <span class="text-info">
                                                            {{ $lp->category->name }}
                                                        </span>
                                                    </a>
                                                <div class="wrap-price">
                                                    <span class="product-price">
                                                        {{ $lp->regular_price }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <div class="alert alert-warning">Tidak ada product</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<!--Product Categories-->
			<div class="row">
                <div class="wrap-show-advance-info-box style-1">
                    <h3 class="title-box">Product Categories</h3>
                    <div class="wrap-products">
                        <div class="wrap-product-tab tab-style-1">
                            <div class="tab-control">
                                @foreach ($categories as $key=>$category)
                                    <a href="#category_{{ $category->id }}" class="tab-control-item {{ $key == 0 ? 'active':'' }} "><b>{{ $category->name }}</b></a>
                                @endforeach
                            </div>
                            <div class="tab-contents">
                                @foreach ($categories as $key=>$category)
                                <div class="tab-content-item {{ $key == 0 ? 'active':'' }} " id="category_{{ $category->id }}">
                                    <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
                                        @php
                                            $c_products = DB::table('products')->where('category_id', $category->id)->get()->take($no_of_products);
                                        @endphp
                                        @foreach ($c_products as $c_product)
                                        @if($c_product->image !== 'default-product.jpg' && $c_product->id !== 1)
                                        <div class="product product-style-2 equal-elem">
                                            <div class="product-thumnail">
                                                <a href="{{ route('product.details', ['slug'=>$c_product->slug]) }}" title="{{ $c_product->name }}">
                                                    <figure><img src="{{ asset('assets/images/products') }}/{{ $c_product->image }}" alt="{{ $c_product->name }}"></figure>
                                                </a>
                                                {{-- <div class="group-flash">
                                                    <span class="flash-item new-label">new</span>
                                                </div> --}}
                                                <div class="wrap-btn">
                                                    <a href="{{ route('product.details', ['slug'=>$c_product->slug]) }}" class="function-link">Lihat Product</a>
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <a href="{{ route('product.details', ['slug'=>$c_product->slug]) }}" class="product-name"><h3 style="color:#555;font-weight: 500">{{ $c_product->name }}</h3></a>
                                                <div class="wrap-price"><span class="product-price">@currency($c_product->sale_price)</span></div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($c_product->image == 'default-product.jpg' && DB::table('products')->count() == 1)
                                            <p class="text-center" style="padding:20px 0">Belum ada product</p>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>

	</main>
