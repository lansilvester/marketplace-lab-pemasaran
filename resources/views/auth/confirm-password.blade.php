<x-guest-layout>
	<main id="main" class="main-site left-sidebar">
		<div class="container" style="margin-top:10em">
			<div class="row">
				<div class="col-lg-6 col-sm-12 col-md-6 col-xs-12 col-md-offset-3">
					<div class="main-content-area">
						<div class="wrap-login-item">
							<div class="login-form form-item form-stl">
								<div class="row" style="margin-bottom: 3em">
									<div class="col-md-12 col-xs-12 col-sm-12 col-xl-12 text-center">
										<img src="{{ asset('assets/images/logo-poli.png') }}" style="width:10em;">
									</div>
									<x-jet-validation-errors class="my-3" />
								</div>
								<fieldset class="wrap-title">
									<h3 class="form-title">Konfirmasi Password</h3>
								</fieldset>
								<p class="mb-3">Ini area aman aplikasi. Harap konfirmasi password anda sebelum melanjutkan.</p>
								<form method="POST" action="{{ route('password.confirm') }}">
									@csrf
									<fieldset class="wrap-input">
										<label for="password"><i class="bi bi-key"></i> Password :</label>
										<input type="password" id="password" name="password" placeholder="Ketik password anda" required autocomplete="current-password" autofocus>
									</fieldset>
									<button type="submit" class="btn btn-submit" name="submit"><i class="bi bi-shield-check"></i> &nbsp;Konfirmasi</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</x-guest-layout>
