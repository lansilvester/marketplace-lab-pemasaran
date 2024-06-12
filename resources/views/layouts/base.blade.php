<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>POLIMDO</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flexslider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color-01.css') }}">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="home-page home-01">
    <div class="mercado-clone-wrap">
        <div class="mercado-panels-actions-wrap">
            <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
        </div>
        <div class="mercado-panels"></div>
    </div>
	<header id="header" class="header header-style-1">
		<div class="container-fluid">
			<div class="row">
				<div class="topbar-menu-area">
					<div class="container">
						<div class="topbar-menu right-menu">
							<ul>
							@if(Route::has('login'))
								@auth
									@if(Auth::user()->status === 1)
										@if(Auth::user()->utype==='ADM')
											<li class="menu-item menu-item-has-children parent">
											<a href="" onclick="event.preventDefault()">My Account {{Auth::user()->name}} <i class="fa fa-angle-down"></i></a>
												<ul class="submenu">
													{{-- <li class="menu-item">
														<a href="{{ route('admin.dashboard') }}">Dashboard</a>
													</li> --}}
													<li class="menu-item">
														<a href="{{ route('user.profile') }}"><i class="bi bi-person"></i> Profile</a>
													</li>
													<li class="menu-item">
														<a title="Categories" href="{{ route('admin.categories') }}"><i class="bi bi-list-check"></i> Categories</a>
													</li>

													<li class="menu-item">
														<a title="Categories" href="{{ route('admin.contact') }}"><i class="bi bi-envelope"></i> Contact Messages</a>
													</li>

													<li class="menu-item">
														<a title="Categories" href="{{ route('admin.products') }}"><i class="bi bi-bag"></i> Products</a>
													</li>
													<li class="menu-item">
														<a title="Settings" href="{{ route('admin.homeslider') }}"><i class="bi bi-card-image"></i> Home Slider</a>
													</li>
													<li class="menu-item">
														<a title="Settings" href="{{ route('admin.homecategories') }}"><i class="bi bi-list-stars"></i> Home Categories</a>
													</li>
													<li class="menu-item">
														<a title="Settings" href="{{ route('admin.users') }}"><i class="bi bi-people-fill"></i> Manage Users</a>
													</li>
													<li class="menu-item">
														<a title="Settings" href="{{ route('admin.settings') }}"><i class="bi bi-gear"></i> Settings</a>
													</li>
													<li class="menu-item">
														<a href="{{ route('user.changepassword') }}"><i class="fa fa-key"></i> Ganti Password</a>
													</li>

													<li class="menu-item">
														<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="bi bi-box-arrow-right"></i> Logout</a>
													</li>
													<form id="logout-form" method="POST" action="{{ route('logout') }}">
														@csrf
													</form>
												</ul>
											</li>
										@elseif(Auth::user()->utype==='OPT')
											<li class="menu-item menu-item-has-children parent">
												<a href="" onclick="event.preventDefault()">My Account {{Auth::user()->name}} <i class="fa fa-angle-down"></i></a>
													<ul class="submenu">
														{{-- <li class="menu-item">
															<a href="{{ route('admin.dashboard') }}">Dashboard</a>
														</li> --}}
														<li class="menu-item">
															<a href="{{ route('user.profile') }}"><i class="bi bi-person"></i> Profile</a>

														</li>
														<li class="menu-item">
															<a title="Categories" href="{{ route('admin.categories') }}"><i class="bi bi-list-check"></i> Categories</a>

														</li>

														<li class="menu-item">
															<a title="Categories" href="{{ route('admin.products') }}"><i class="bi bi-bag"></i> Products</a>

														</li>
														<li class="menu-item">
															<a title="Settings" href="{{ route('admin.homeslider') }}"><i class="bi bi-card-image"></i> Manage Slider</a>
														</li>
														<li class="menu-item">
															<a title="Settings" href="{{ route('admin.homecategories') }}"><i class="bi bi-list-stars"></i> Manage Home Categories</a>
														</li>
														<li class="menu-item">
															<a title="Settings" href="{{ route('admin.users') }}"><i class="bi bi-people-fill"></i> Manage Users</a>
														</li>
														<li class="menu-item">
															<a title="Settings" href="{{ route('admin.settings') }}"><i class="bi bi-gear"></i> Settings</a>
														</li>
														<li class="menu-item">
														<a href="{{ route('user.changepassword') }}"><i class="fa fa-key"></i> Ganti Password</a>
														</li>
														<li class="menu-item">
															<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="bi bi-box-arrow-left"></i> Logout</a>
														</li>
														<form id="logout-form" method="POST" action="{{ route('logout') }}">
															@csrf
														</form>
													</ul>
											</li>
										@elseif(Auth::user()->utype==='PNJ' || Auth::user()->utype==='PBN')
											<li class="menu-item menu-item-has-children parent">
												<a href="" onclick="event.preventDefault()">My Account {{Auth::user()->name}} <i class="fa fa-angle-down"></i></a>
													<ul class="submenu">
														{{-- <li class="menu-item">
															<a href="{{ route('admin.dashboard') }}">Dashboard</a>
														</li> --}}
														<li class="menu-item">
															<a href="{{ route('user.profile') }}"><i class="bi bi-person"></i> Profile</a>
														</li>
														<li class="menu-item">
															<a title="Categories" href="{{ route('admin.categories') }}"><i class="bi bi-list-check"></i> Categories</a>

														</li>
														<li class="menu-item">
															<a title="Reviews" href="{{ route('admin.reviews', ['user_id'=>Auth::user()->id]) }}"><i class="bi bi-pen"></i> Reviews</a>
														</li>

														<li class="menu-item">
															<a title="Categories" href="{{ route('admin.products') }}"><i class="bi bi-bag"></i> Products</a>

														</li>
														<li class="menu-item">
															<a href="{{ route('user.changepassword') }}"><i class="fa fa-key"></i> Ganti Password</a>
															</li>
														<li class="menu-item">
															<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="bi bi-box-arrow-left"></i> Logout</a>
														</li>
														<form id="logout-form" method="POST" action="{{ route('logout') }}">
															@csrf
														</form>
													</ul>
											</li>
										@else
											<li class="menu-item menu-item-has-children parent">
												<a href="" title="My Account" onclick="event.preventDefault()">My Account {{Auth::user()->name}} <i class="fa fa-angle-down"></i></a>
												<ul class="submenu">
													<li class="menu-item">
														<a href="{{ route('user.profile') }}"><i class="bi bi-person"></i> Profile</a>
													</li>
													<li class="menu-item">
														<a href="{{ route('user.changepassword') }}"><i class="fa fa-key"></i> Ganti Password</a>
													</li>
													<li class="menu-item">
														<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="bi bi-box-arrow-left"></i> Logout</a>
													</li>
													<form id="logout-form" method="POST" action="{{ route('logout') }}">
														@csrf
													</form>
												</ul>
											</li>
										@endif
									@else
										<li class="menu-item menu-item-has-children parent">
											<a href="" title="My Account" onclick="event.preventDefault()">My Account {{Auth::user()->name}} <i class="fa fa-angle-down"></i></a>
											<ul class="submenu">
												<li class="menu-item">
													<a href="{{ route('user.profile') }}"><i class="bi bi-person"></i> Profile</a>
												</li>
												<li class="menu-item">
													<a href="{{ route('user.changepassword') }}"><i class="fa fa-key"></i> Ganti Password</a>
												</li>
												<li class="menu-item">
													<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="bi bi-box-arrow-left"></i> Logout</a>
												</li>
												<form id="logout-form" method="POST" action="{{ route('logout') }}">
													@csrf
												</form>
											</ul>
										</li>
									@endif
								@else
									<li class="menu-item" ><a title="Register or Login" href="{{ route('login') }}">Login</a></li>
									<li class="menu-item" ><a title="Register or Login" href="{{ route('register') }}">Register</a></li>
								@endif

							@endif
							</ul>
						</div>
					</div>
				</div>

				<div class="container">
					<div class="mid-section main-info-area">

						<div class="wrap-logo-top left-section">
							<a href="/" class="link-to-home"><img src="{{ asset('assets/images/logo-poli.png') }}" style="width:50px;margin:20px 0px;" alt="Homepage Logo"></a>
						</div>

						@livewire('header-search-component')

						<div class="wrap-icon right-section">
							@if(Auth::check() && Auth::user()->utype == 'USR')
								@if (Auth::user()->status === 1)
									@livewire('wishlist-count-component')
									@livewire('cart-count-component')
								@endif
							@endif
							<div class="wrap-icon-section show-up-after-1024">
								<a href="#" class="mobile-navigation">
									<span></span>
									<span></span>
									<span></span>
								</a>
							</div>
						</div>

					</div>
				</div>

				{{-- sidebar --}}
				<div class="nav-section header-sticky">
					<div class="primary-nav-section">
						<div class="container">
							<ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Main menu" >
								<li class="menu-item home-icon">
									<a href="/" class="link-term mercado-item-title" style="background:#00275d"><i class="fa fa-home" aria-hidden="true"></i></a>
								</li>
								<li class="menu-item">
									<a href="/about" class="link-term mercado-item-title">About Us</a>
								</li>
								<li class="menu-item">
									<a href="/shop" class="link-term mercado-item-title">Shop</a>
								</li>
								{{-- <li class="menu-item">
									<a href="/cart" class="link-term mercado-item-title">Cart</a>
								</li> --}}
								<li class="menu-item">
									<a href="/contact" class="link-term mercado-item-title">Contact</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>
	</header>
    {{ $slot }}

	@livewire('footer-component')
	<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>

	<script src="{{ asset('assets/js/jquery-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ asset('assets/js/jquery-ui-1.12.4.minb8ff.js?ver=1.12.4') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.flexslider.js') }}"></script>
	{{-- <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script> --}}
	<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>
	<script src="{{ asset('assets/js/functions.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/j21h7jo1xpes3qhzsz5gpo03z7d8wlqjim0d2d18f2k6dkni/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    @livewireScripts

	@stack('scripts')

</body>
</html>
