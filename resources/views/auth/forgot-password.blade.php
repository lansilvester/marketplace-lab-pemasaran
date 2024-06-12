{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}


<x-guest-layout>
    <!--main area-->
<main id="main" class="main-site left-sidebar">

    <div class="container" style="margin-top:10em">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-6 col-xs-12 col-md-offset-3">
                <div class=" main-content-area">
                    <div class="wrap-login-item ">						
                        <div class="login-form form-item form-stl">
                            @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                            @endif
                            <x-jet-validation-errors class="mb-4" />
                            <form name="frm-login" method="POST" action="{{ route('password.email') }}">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:1em"><a href="{{ route('/') }}" style="font-weight: bold; font-size:1.5em"><i class="bi bi-arrow-left"></i> </a></div>
                                </div>
                                <div class="row" style="margin-bottom: 3em">
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-xl-12 text-center">
                                        <img src="{{ asset('assets/images/Logo-lab-penjualan-black.png') }}" style="width:20em;">
                                    </div>
                                </div>
                                @csrf
                                <fieldset class="wrap-title">
                                    <h3 class="form-title">Lupa Password</h3>										
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="frm-login-uname"><i class="bi bi-envelope"></i> Email :</label>
                                    <input type="email" id="frm-login-uname" name="email" placeholder="Ketik alamat email anda" :value="old('email')" required autofocus>
                                </fieldset>
                                <button type="submit" class="btn btn-submit" name="submit"><i class="bi bi-box-arrow-in-right"></i> &nbsp;Email Password Reset Link</button>
                            </form>
                        </div>												
                    </div>
                </div><!--end main products area-->		
            </div>
        </div><!--end row-->

    </div><!--end container-->
</main>
</x-guest-layout>