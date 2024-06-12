<footer id="footer">
    <div class="wrap-footer-content footer-style-1">
        <div class="main-footer-content">

            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="wrap-footer-item">
                            <h3 class="item-header">Contact Details</h3>
                            <div class="item-content">
                                <div class="wrap-contact-detail">
                                    <ul>
                                       
                                        <li>
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <p class="contact-txt">{{ $settings->phone }}</p>
                                        </li>
                                        <li>
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            <p class="contact-txt">{{ $settings->email }}</p>
                                        </li>	
                                        <li>
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <p class="contact-txt">{{ $settings->address }}</p>
                                        </li>										
                                    </ul>
                                </div>
                                <iframe src="{{ $settings->map }}" frameborder="0" width="100%" height="300px"></iframe>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 box-twin-content ">
                        <div class="row">
                            <div class="wrap-footer-item twin-item">
                                <h3 class="item-header">My Account</h3>
                                <div class="item-content">
                                    <div class="wrap-vertical-nav">
                                        <ul>
                                            <li class="menu-item"><a href="#" class="link-term">My Account</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="wrap-footer-item twin-item">
                                <h3 class="item-header">Infomation</h3>
                                <div class="item-content">
                                    <div class="wrap-vertical-nav">
                                        <ul>
                                            <li class="menu-item"><a href="{{ route('about') }}" class="link-term">Contact</a></li>
                                            <li class="menu-item"><a href="{{ route('contact') }}" class="link-term">About Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                        <div class="wrap-footer-item">
                            <h3 class="item-header">Social Network</h3>
                            <div class="item-content">
                                <div class="wrap-list-item social-network">
                                    <ul>
                                        <li><a href="{{ $settings->twitter }}" class="link-to-item"><i class="fa fa-twitter" aria-hiddern="true"></i></a></li>
                                        <li><a href="{{ $settings->facebook }}" class="link-to-item"><i class="fa fa-facebook" aria-hiddern="true"></i></a></li>
                                        <li><a href="{{ $settings->pinterest }}" class="link-to-item"><i class="fa fa-pinterest" aria-hiddern="true"></i></a></li>
                                        <li><a href="{{ $settings->instagram }}" class="link-to-item"><i class="fa fa-instagram" aria-hiddern="true"></i></a></li>
                                        <li><a href="{{ $settings->youtube }}" class="link-to-item"><i class="fa fa-youtube" aria-hiddern="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="coppy-right-box" style="margin-top:2em;padding:1em">
            <div class="container">
                <div class="coppy-right-item item-left">
                    <p class="coppy-right-text">&copy; Copyright {{ date('Y') }}  Politeknik Negeri Manado</p>
                </div>
                <div class="coppy-right-item item-right">
                    <div class="wrap-nav horizontal-nav">
                        <ul>
                            {{-- <li class="menu-item"><a href="{{ route('about') }}" class="link-term">About us</a></li>						 --}}
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <img src="{{ asset('assets/images/logo-poli.png') }}" alt="" width="50">
            </div>
        </div>
    </div>
</footer>