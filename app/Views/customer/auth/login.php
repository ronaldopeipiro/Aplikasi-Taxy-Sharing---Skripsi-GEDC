<?= $this->extend('layout/template-auth'); ?>

<?= $this->section('content_auth'); ?>

<div class="container-login100" style="background-image: url('<?= base_url(); ?>/assets/img/bg-login.jpg');">
	<div class="wrap-login100 p-l-20 p-r-20 p-t-40 p-b-40">

		<form action="<?= base_url(); ?>/Customer/Auth/auth_login" method="POST" enctype="multipart/form-data">
			<?= csrf_field(); ?>

			<div class="row">
				<div class="col-12">
					<h3 class="text-center font-weight-bold">AIRPORT TAXI SHARING APP</h3>
					<hr>
					<h5 class="text-center p-b-30">
						Masuk sebagai Customer
					</h5>
				</div>
			</div>

			<div class="row align-items-center justify-content-center">
				<div class="col-lg-6">
					<div class="wrap-input100 validate-input m-b-20" data-validate="Enter username or email">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-25" data-validate="Enter password">
						<input class="input100" type="password" id="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div style="margin-top: -10px; position: relative;">
						<label class="container-remember">
							<p style="font-size: 15px; color: #000; margin: -10px 0 0 30px;">Tampilkan Password</p>
							<input type="checkbox" name="" onclick="myFunction()" value="1">
							<span class="checkmark"></span>
						</label>
					</div>

					<div class="container-login100-form-btn mt-4">
						<button type="submit" class="login100-form-btn btn-block">
							<i class="fa fa-arrow-right mr-2"></i> Masuk
						</button>
					</div>

				</div>

				<div class="col-lg-6">
					<div class="text-center pt-4 pt-lg-0 pb-4">
						<span class="txt1">
							atau masuk dengan
						</span>
					</div>

					<div class="flex-c p-b-30">
						<a href="<?= $tombol_login; ?>" class="btn btn-block btn-light shadow-lg" style="border-radius: 30px;">
							<img src="<?= base_url(); ?>/assets_login/images/icons/icon-google.png" alt="GOOGLE">
							<span class="font-weight-bold ml-2">
								Akun Google
							</span>
						</a>
					</div>

					<div class="text-center">
						Belum punya akun ? silahkan
						<a href="<?= base_url(); ?>/customer/sign-up" class="btn btn-link pl-0 pr-0 pt-1 pb-2">
							Daftar
						</a>
						terlebih dahulu
					</div>

					<div class="text-center mt-4">
						<a href="<?= base_url(); ?>">
							<i class="fa fa-arrow-left"></i> Kembali
						</a>
					</div>

				</div>
			</div>



		</form>

	</div>
</div>

<div id="dropDownSelect1"></div>

<script>
	function myFunction() {
		var x = document.getElementById("password");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
</script>

<?= $this->endSection('content_auth'); ?>