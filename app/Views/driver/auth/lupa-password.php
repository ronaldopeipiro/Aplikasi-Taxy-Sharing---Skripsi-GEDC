<?= $this->extend('layout/template-auth'); ?>

<?= $this->section('content_auth'); ?>

<div class="container-login100" style="background-image: url('<?= base_url(); ?>/assets/img/bg-login.jpg');">
	<div class="wrap-login100 p-l-20 p-r-20 p-t-40 p-b-40">

		<form action="<?= base_url(); ?>/Driver/Auth/submit_lupa_password" method="POST" enctype="multipart/form-data">
			<?= csrf_field(); ?>

			<div class="row">
				<div class="col-12">
					<h3 class="text-center font-weight-bold">AIRPORT TAXI SHARING APP</h3>
					<hr>
					<h5 class="text-center p-b-30">
						Lupa Password ?
					</h5>
				</div>
			</div>

			<div class="row align-items-center justify-content-center">
				<div class="col-lg-12">
					<div class="wrap-input100 validate-input m-b-20" data-validate="Masukkan username atau email akun anda ...">
						<input class="input100 text-center" type="text" name="username" id="username" placeholder="Masukkan username atau email akun anda ...">
						<span class="focus-input100"></span>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="container-login100-form-btn mt-4">
						<button type="submit" class="login100-form-btn btn-block">
							<i class="fa fa-arrow-right mr-2"></i> Submit
						</button>
					</div>
				</div>

				<div class="col-lg-12 mt-5">

					<div class="text-center">
						<a href="<?= base_url(); ?>/driver/login" class="btn btn-link pl-0 pr-0 pt-1 pb-2">
							<i class="fa fa-sign-in"></i> Login
						</a>
					</div>

					<div class="text-center mt-4">
						Belum punya akun ? silahkan
						<a href="<?= base_url(); ?>/driver/sign-up" class="btn btn-link pl-0 pr-0 pt-1 pb-2">
							Daftar
						</a>
						terlebih dahulu
					</div>

					<div class="text-center mt-4">
						<a href="<?= base_url(); ?>">
							<i class="fa fa-arrow-left"></i> Home
						</a>
					</div>

				</div>
			</div>

		</form>

	</div>
</div>

<?= $this->endSection('content_auth'); ?>