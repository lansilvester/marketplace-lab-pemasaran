{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
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
                            <div class="register-form form-item ">
                                <x-jet-validation-errors class="mb-4" />
								<form class="form-stl" action="{{ route('register') }}" name="frm-login" method="POST" >
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom:1em"><a href="{{ route('/') }}" style="font-weight: bold; font-size:1.5em"><i class="bi bi-arrow-left"></i> </a></div>
                                    </div>
                                    <div class="row" style="margin-bottom: 3em">
                                        <div class="col-md-12 col-xs-12 col-sm-12 col-xl-12 text-center">
                                            <img src="{{ asset('assets/images/logo-poli.png') }}" style="width:10em;">
                                        </div>
                                    </div>
									@csrf
                                    <fieldset class="wrap-title">
										<h3 class="form-title">Registrasi Akun</h3>
										<h4 class="form-subtitle">Informasi Personal</h4>
									</fieldset>									
									<fieldset class="wrap-input">
										<label for="frm-reg-lname"><i class="bi bi-person"></i> Nama</label>
										<input type="text" id="frm-reg-lname" name="name" placeholder="Nama Lengkap" :value="old('name')" required autofocus autocomplete="name">
									</fieldset>
									<fieldset class="wrap-input">
										<label for="frm-reg-email"><i class="bi bi-envelope"></i> Email</label>
										<input type="email" id="frm-reg-email" name="email" placeholder="Alamat Email"  :value="old('email')">
									</fieldset>
									<fieldset class="wrap-input">
										<label for="frm-reg-email"><i class="bi bi-person-fill"></i> Mendaftar Sebagai</label>
                                        <select name="utype" id="" class="form-control">
                                            <option value="USR">User</option>
                                            <option value="PNJ">Penjual</option>
                                            <option value="PBN">Pemasok Bahan</option>
                                        </select>
                                    </fieldset>
                                    <hr>
									<fieldset class="wrap-title">
										<h3 class="form-title">Informasi Login</h3>
									</fieldset>
									<fieldset class="wrap-input item-width-in-half left-item ">
										<label for="frm-reg-pass"><i class="bi bi-key"></i> Password</label>
										<input type="password" id="frm-reg-pass" name="password" placeholder="Password" required autocomplete="new-password">
									</fieldset>
									<fieldset class="wrap-input item-width-in-half ">
										<label for="frm-reg-cfpass">Confirm Password</label>
										<input type="password" id="frm-reg-cfpass" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
									</fieldset>
                                    <br />
                                    <div class="row" >
                                        <div class="col-md-12" style="margin-top:2em">
                                                Sudah punya akun? <a href="{{ route('login') }}">Login</a> Sekarang.
                                        </div>
                                    </div>
									<button type="submit" class="btn btn-sign" name="register"><i class="bi bi-arrow-return-right"></i> Register</button>
								</form>
							</div>											
						</div>
					</div><!--end main products area-->		
				</div>
			</div><!--end row-->

		</div><!--end container-->

	</main>
</x-guest-layout>

