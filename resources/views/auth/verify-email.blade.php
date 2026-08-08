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
									<h3 class="form-title">Verifikasi Email</h3>
								</fieldset>

								@if (session('status') == 'verification-link-sent')
									<div class="alert alert-success" role="alert">
										Link verifikasi baru telah dikirim ke alamat email yang anda daftarkan.
									</div>
								@endif

								<p class="mb-3">Sebelum melanjutkan, mohon verifikasi alamat email anda dengan mengeklik tautan yang baru saja kami kirim ke email anda. Jika email tidak diterima, kami akan dengan senang hati mengirim ulang.</p>

								@if (Route::has('verification.send'))
									<form method="POST" action="{{ route('verification.send') }}">
										@csrf
										<button type="submit" class="btn btn-submit" name="submit"><i class="bi bi-envelope-arrow-up"></i> &nbsp;Kirim Ulang Email Verifikasi</button>
									</form>
								@endif

								<div class="row" style="margin-top:1em">
									@if (Route::has('profile.show'))
										<a href="{{ route('profile.show') }}">Edit Profil</a>
									@endif
									@if (Route::has('logout'))
										<form method="POST" action="{{ route('logout') }}" class="inline">
											@csrf
											<button type="submit" class="btn btn-link">Log Out</button>
										</form>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</x-guest-layout>
