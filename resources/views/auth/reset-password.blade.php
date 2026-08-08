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
                            <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                            <x-jet-validation-errors class="mb-4" />
                            <form name="frm-login" method="POST" action="{{ route('password.update') }}">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:1em"><a href="{{ route('/') }}" style="font-weight: bold; font-size:1.5em"><i class="bi bi-arrow-left"></i> </a></div>
                                </div>
                                <div class="row" style="margin-bottom: 3em">
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-xl-12 text-center">
                                        <img src="{{ asset('assets/images/logo-poli.png') }}" style="width:10em;">
                                    </div>
                                </div>
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <fieldset class="wrap-title">
                                    <h3 class="form-title">Reset Password</h3>
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="email"><i class="bi bi-envelope"></i> Email :</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Ketik alamat email anda" required autofocus>
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="password"><i class="bi bi-key"></i> Password Baru :</label>
                                    <input type="password" id="password" name="password" placeholder="Password baru" required autocomplete="new-password">
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="password_confirmation"><i class="bi bi-key"></i> Konfirmasi Password :</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required autocomplete="new-password">
                                </fieldset>
                                <button type="submit" class="btn btn-submit" name="submit"><i class="bi bi-box-arrow-in-right"></i> &nbsp;Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div><!--end main products area-->
            </div>
        </div><!--end row-->

    </div><!--end container-->
</main>
</x-guest-layout>
