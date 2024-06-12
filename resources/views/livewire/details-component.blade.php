<main id="main" class="main-site">

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
        h2{
            font-size:3em;
        }
    </style>
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{ route('product.shop') }}" class="link">home</a></li>
                <li class="item-link"><span>detail</span></li>
            </ul>
        </div>
        <div class="row">

            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                <div class="wrap-product-detail">
                    <div class="detail-media">

                        <div class="product-gallery" wire:ignore>
                          <ul class="slides">
                            <li data-thumb="{{ asset('assets/images/products') }}/{{ $product->image }}">
                                <img src="{{ asset('assets/images/products') }}/{{ $product->image }}" alt="{{ $product->name }}">
                            </li>
                            @php
                                $images = explode(",", $product->images);    
                            @endphp
                            @foreach ($images as $image)
                                @if($image)
                                <li data-thumb="{{ asset('assets/images/products') }}/{{ $image }}">
                                    <img src="{{ asset('assets/images/products') }}/{{ $image }}" alt="{{ $product->name }}">
                                </li>  
                                @endif
                            @endforeach
                          </ul>
                        </div>

                    </div>
                    <div class="detail-info">
                       
                        <div class="product-rating">
                            <style>
                                .color-gray{
                                    color:green !important;
                                }
                                .color-orange{
                                    color: rgb(211, 74, 0);
                                }
                            </style>
                          
                            
                                {{-- <a href="#" class="count-review">({{ $product->review->where('product_id',4)->count() }} review)</a> --}}
                        </div>
                        
                        <br>
                        <b style="font-size:3em;line-height:2em" class="product-name">{{ $product->name }}</b>
                        <div class="short-desc">
                            {!! $product->short_description !!}
                        </div>
                        
                        {{-- <div class="wrap-price"><span class="product-price">Rp. {{ $product->sale_price}}</span></div> --}}
                        <div class="wrap-price"><span class="product-price"> @currency($product->sale_price) </span></div>
                        <div class="stock-info in-stock">
                            <p class="availability">Availability : <b>@if($product->stock_status == 'instock') <span class="bg-success" style="padding:5px 10px; margin:100px 0px;">{{ $product->stock_status }}</span>  @endif</b><br>Stock : <b>{{ $product->quantity }}</b></p>
                        </div>
                        <a href="{{ route('product.penjual', ['penjual'=>$product->user->id]) }}">
                            <div style="
                                background:#efefef;
                                padding:5px;
                                border-radius:10px;
                            ">
                            @if($product->user->profile->image)
                                <img src="{{ asset('assets/images/profile') }}/{{ $product->user->profile->image }}" width="50px" alt="" style="border-radius:.5em;border:1px solid #d6d6d6; margin-right:1em">
                            @else
                                <img src="{{ asset('assets/images/profile/default.png') }}" width="50px" alt="" style="border-radius:.5em;border:1px solid #d6d6d6; margin-right:1em">
                            @endif

                            <b>{{ $product->user->name }}</b>
                            </div>
                        </a>
                        {{-- <div class="quantity">
                            <span>Quantity:</span>
                            <div class="quantity-input">
                                <input type="text" name="product-quatity" value="1" data-max="120" pattern="[0-9]*" wire:model="qty" >
                                <a class="btn btn-reduce" href="#" wire:click.prevent="decreseQuantity"></a>
                                <a class="btn btn-increase" href="#" wire:click.prevent="increaseQuantity"></a>
                            </div>
                        </div> --}}
                        
                        @php
                        $witems = Cart::instance('wishlist')->content()->pluck('id');	
                        @endphp
                        <div class="wrap-butons">
                            {{-- <a href="#" class="btn add-to-cart" wire:click.prevent="store({{ $product->id }},'{{ $product->name }}', {{ $product->sale_price }})"><i class="fa fa-heart"></i> Tambah ke Wishlist</a> --}}
                            @if(Auth::check())
                                @if (Auth::user()->utype == 'USR' && Auth::user()->status === 1)
                                    @if($witems->contains($product->id))
                                        <a href="#" class="btn add-to-cart" wire:click.prevent="removeFromWishlist({{ $product->id }})"><i class="fa fa-heart fill-heart"></i> &nbsp; Hapus dari Wishlist</a>
                                    @else
                                        <a href="#" class="btn add-to-cart" wire:click.prevent="addToWishlist({{ $product->id}},'{{ $product->name }}',{{ $product->sale_price }})"><i class="fa fa-heart"></i> &nbsp; Tambah ke Wishlist</a>
                                    @endif
                                @endif
                            @endif
                            <div class="wrap-btn">
                                <div class="product-wish">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="wrap-social">
                            <style>
                                .bi-facebook{
                                    color:#0052af;
                                    font-size:2.2em
                                }
                                .bi-twitter{
                                    color:#00c0da;
                                    font-size:2.2em;
                                }
                                .bi-whatsapp{
                                    color:green;
                                    font-size:2.2em;
                                }
                            </style>
                            <b style="font-size:1.5em">Bagikan Produk</b><br/>
                                @foreach ($share as $key=>$value)
                                <a href="{{ $value }}" class="btn" target="__blank"><i class="bi bi-{{ $key }}"></i></a>
                                @endforeach
                            <input type="text" class="form-control" id="link" value="{{ route('product.details',['slug'=>$product->slug]) }}" readonly>
                            <button class="btn btn-block btn-primary ctoCb"><i class="fa fa-clipboard"></i> Copy to clipboard</button>
                        </div>
                    </div>
                    <div class="advance-info">
                        <div class="tab-control normal">
                            <a href="#description" class="tab-control-item active">Deskripsi</a>
                            <a href="#review" class="tab-control-item">Reviews</a>
                        </div>
                        <div class="tab-contents">
                            <div class="tab-content-item active" id="description">
                                {!! $product->description !!}
                            </div>
                            {{-- Information box --}}
                        
                            {{-- Review box --}}
                            <div class="tab-content-item " id="review">
                                
                                <div class="wrap-review-form">
                                    
                                    @foreach ($reviews->where('product_id', $product->id) as $review)
                                        
                                    <div id="comments">
                                        <h2 class="woocommerce-Reviews-title">Review untuk <span>{{ $review->product->name }}</span></h2>
                                        <ol class="commentlist">
                                            <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20">
                                                <div id="comment-20" class="comment_container"> 
                                                    <img alt="" src="{{ asset('assets/images/profile') }}/{{ $review->user->profile->image }}" height="80" width="80">
                                                    <div class="comment-text">
                                                        
                                                        <span><b>{{ $review->rating }}</b></span><i class="bi bi-star-fill" style="color:#ffd607"></i> of 5

                                                        <p class="meta"> 
                                                            <strong class="woocommerce-review__author">{{ $review->user->name }}</strong> 
                                                            <span class="woocommerce-review__dash">–</span>
                                                            <time class="woocommerce-review__published-date" datetime="{{ $review->created_at }}" >{{ $review->created_at->diffForHumans() }}</time>
                                                        </p>
                                                        <div class="description">
                                                            <p>{{ $review->comment }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ol>
                                    </div><!-- #comments -->
                                    @endforeach
{{-- 
                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond"> 

                                                <form action="#" method="post" id="commentform" class="comment-form" novalidate="">
                                                    <p class="comment-notes">
                                                        <span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span>
                                                    </p>
                                                    <div class="comment-form-rating">
                                                        <span>Your rating</span>
                                                        <p class="stars">
                                                            
                                                            <label for="rated-1"></label>
                                                            <input type="radio" id="rated-1" name="rating" value="1">
                                                            <label for="rated-2"></label>
                                                            <input type="radio" id="rated-2" name="rating" value="2">
                                                            <label for="rated-3"></label>
                                                            <input type="radio" id="rated-3" name="rating" value="3">
                                                            <label for="rated-4"></label>
                                                            <input type="radio" id="rated-4" name="rating" value="4">
                                                            <label for="rated-5"></label>
                                                            <input type="radio" id="rated-5" name="rating" value="5" checked="checked">
                                                        </p>
                                                    </div>
                                                    <p class="comment-form-author">
                                                        <label for="author">Name <span class="required">*</span></label> 
                                                        <input id="author" name="author" type="text" value="">
                                                    </p>
                                                    <p class="comment-form-email">
                                                        <label for="email">Email <span class="required">*</span></label> 
                                                        <input id="email" name="email" type="email" value="" >
                                                    </p>
                                                    <p class="comment-form-comment">
                                                        <label for="comment">Your review <span class="required">*</span>
                                                        </label>
                                                        <textarea id="comment" name="comment" cols="45" rows="8"></textarea>
                                                    </p>
                                                    <p class="form-submit">
                                                        <input name="submit" type="submit" id="submit" class="submit" value="Submit">
                                                    </p>
                                                </form>

                                            </div><!-- .comment-respond-->
                                        </div><!-- #review_form -->
                                    </div><!-- #review_form_wrapper --> --}}

                                </div>
                            </div>
                            {{-- tutup review box --}}

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                
                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title">Popular Products</h2>
                    <div class="widget-content" wire:ignore>
                        <ul class="products">
                            @foreach ($popular_products as $p_product)
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
                </div>

            </div>
            {{-- <p>{{ $product->where('rstatus',1)->get() }}</p> --}}

            @if ($related_products->count() > 1)
                
            <div class="single-advance-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wrap-show-advance-info-box style-1 box-in-site">
                    <h3 class="title-box">Related Products</h3>
                    <div class="wrap-products">
                        <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}' >
                        @foreach ($related_products as $r_product)
                            @if ($r_product->image !== 'default-product.jpg' && $r_product->count() > 0)
                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="{{ route('product.details', ['slug' => $r_product->slug ]) }}" title="{{ $r_product->name }}">
                                        <figure><img src="{{ asset('assets/images/products') }}/{{ $r_product->image }}" width="214" height="214" alt={{ $r_product->name }}"></figure>
                                    </a>
                                    <div class="group-flash">
                                        <span class="flash-item new-label">new</span>
                                    </div>
                                    <div class="wrap-btn">
                                        <a href="{{ route('product.details', ['slug' => $r_product->slug ]) }}" class="function-link">quick view</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-name"><span>{{ $r_product->name }}</span></a>
                                    <div class="wrap-price"><span class="product-price">@currency($r_product->sale_price)</span></div>
                                </div>
                            </div>
                            @endif

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            
            @endif

        </div>
    </div>
   
</main>

@push('scripts')
<script>
    $(document).ready(function(){
        let copylink = '';
        function copyToClipboard(element, btnElem){
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).val()).select();
            document.execCommand("copy");
            $temp.remove();
            $(btnElem).html(`<i class="fa fa-link"></i> Copied..`);
            setTimeout(() => {
                $(btnElem).html(`<i class="fa fa-clipboard"></i> Copy to clipboard`);
            }, 2000);
        }
        link = $('#link').val();
        // $('#fb_share').click(function(){
        //     window.open('https://www.facebook.com/sharer/share.php?u='+link, 'facebook-share-dialog',"width=625, height=436");
        // });
        // $('tw_share').click(function(){
        //     alert();
        //     window.open('https://twitter.com/intent/tweet?url='+link);
        // });

            $(document).on('click', '.ctoCb', function(){
                copyToClipboard($(this).parent().parent().find('input'), $(this));
            });
    });
</script>

@endpush
