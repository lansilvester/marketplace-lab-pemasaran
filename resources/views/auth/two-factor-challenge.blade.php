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
									<h3 class="form-title">Autentikasi Dua Faktor</h3>
								</fieldset>

								<p class="mb-3" id="code-hint">Masukkan kode autentikasi dari aplikasi autentikator anda.</p>
								<p class="mb-3" id="recovery-hint" style="display:none">Masukkan salah satu kode pemulihan (recovery code) darurat anda.</p>

								<form method="POST" action="{{ route('two-factor.login') }}">
									@csrf
									<fieldset class="wrap-input" id="code-field">
										<label for="code"><i class="bi bi-shield-lock"></i> Kode :</label>
										<input type="text" id="code" name="code" inputmode="numeric" placeholder="6 digit kode" autofocus autocomplete="one-time-code">
									</fieldset>
									<fieldset class="wrap-input" id="recovery-field" style="display:none">
										<label for="recovery_code"><i class="bi bi-key"></i> Recovery Code :</label>
										<input type="text" id="recovery_code" name="recovery_code" placeholder="Kode pemulihan" autocomplete="one-time-code">
									</fieldset>
									<div class="row" style="margin: 0 0 1em;">
										<a href="#" id="use-recovery" class="link-function left-position" style="display:inline-block">Gunakan kode pemulihan</a>
										<a href="#" id="use-code" class="link-function left-position" style="display:none">Gunakan kode autentikasi</a>
									</div>
									<button type="submit" class="btn btn-submit" name="submit"><i class="bi bi-box-arrow-in-right"></i> &nbsp;Login</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script>
		$(function () {
			$('#use-recovery').on('click', function (e) {
				e.preventDefault();
				$('#code-field, #code-hint').hide();
				$('#recovery-field, #recovery-hint').show();
				$('#use-recovery').hide();
				$('#use-code').show();
				$('#recovery_code').trigger('focus');
			});
			$('#use-code').on('click', function (e) {
				e.preventDefault();
				$('#recovery-field, #recovery-hint').hide();
				$('#code-field, #code-hint').show();
				$('#use-code').hide();
				$('#use-recovery').show();
				$('#code').trigger('focus');
			});
		});
	</script>
</x-guest-layout>
