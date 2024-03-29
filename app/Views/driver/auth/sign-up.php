<?= $this->extend('layout/template-auth'); ?>

<?= $this->section('content_auth'); ?>

<div class="container-login100" style="background-image: url('<?= base_url(); ?>/assets/img/bg-login.jpg');">
	<div class="wrap-login100 p-l-20 p-r-20 p-t-40 p-b-40">

		<form action="<?= base_url(); ?>/Driver/Auth/tambah_driver" method="POST" enctype="multipart/form-data">
			<?= csrf_field(); ?>

			<div class="row mb-5">
				<div class="col-12">
					<h3 class="text-center font-weight-bold">AIRPORT TAXI SHARING APP</h3>
					<hr>
					<h5 class="text-center">
						Daftar sebagai Driver
					</h5>
				</div>
			</div>

			<div class="row justify-content-center">

				<div class="col-lg-6">

					<div class="wrap-input100">
						<input class="input100 <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" type="text" name="nama_lengkap" placeholder="Nama lengkap ..." value="<?= (old('nama_lengkap')) ? old('nama_lengkap') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('nama_lengkap'); ?>
					</div>

					<div class="wrap-input100 m-t-20">
						<input class="input100 <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" type="text" name="username" placeholder="Username ..." value="<?= (old('username')) ? old('username') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('username'); ?>
					</div>

					<div class="wrap-input100 m-t-20">
						<input class="input100 <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" type="email" name="email" placeholder="Email ..." value="<?= (old('email')) ? old('email') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('email'); ?>
					</div>

					<div class="wrap-input100 m-t-20">
						<input class="input100 <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>" type="text" name="no_hp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="No. Handphone (08 XX ...)" value="<?= (old('no_hp')) ? old('no_hp') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('no_hp'); ?>
					</div>

					<div class="wrap-input100 m-t-20">
						<input class="input100 <?= ($validation->hasError('no_anggota')) ? 'is-invalid' : ''; ?>" type="text" name="no_anggota" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="No. Anggota ..." value="<?= (old('no_anggota')) ? old('no_anggota') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('no_anggota'); ?>
					</div>

					<div class="wrap-input100 m-t-20">
						<input class="input100 <?= ($validation->hasError('nopol')) ? 'is-invalid' : ''; ?>" type="text" name="nopol" placeholder="No. Polisi / TNKB (Contoh : KB 1234 YY)" value="<?= (old('nopol')) ? old('nopol') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('nopol'); ?>
					</div>

				</div>

				<div class="col-lg-6 mt-4 mt-lg-0">
					<div class="wrap-input100">
						<input class="input100 <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>" type="password" id="password" name="password" placeholder="Password ..." value="<?= (old('password')) ? old('password') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('password'); ?>
					</div>

					<div class="wrap-input100 m-t-20">
						<input class="input100 <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>" type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi Password ..." value="<?= (old('konfirmasi_password')) ? old('konfirmasi_password') : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<span id="confirm_password_message" class="mt-1"></span>
					<div class="text-danger font-italic ml-3">
						<?= $validation->getError('konfirmasi_password'); ?>
					</div>

					<div class="container-login100-form-btn mt-5">
						<button type="submit" id="btn-submit" class="login100-form-btn btn-block" disabled>
							<i class="fa fa-arrow-right mr-2"></i> SUBMIT
						</button>
					</div>

					<div class="text-center mt-5">
						Sudah punya akun ? silahkan
						<a href="<?= base_url(); ?>/driver/login" class="btn btn-link pl-0 pt-1 pb-2">
							Login
						</a>
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

	$('#konfirmasi_password').on('keyup', function() {
		if ($('#password').val() == $('#konfirmasi_password').val()) {
			$('#confirm_password_message').html('Password cocok !').css('color', '#04ff00');
			document.getElementById('btn-submit').disabled = false;
		} else {
			$('#confirm_password_message').html('Password tidak cocok !').css('color', 'red');
			document.getElementById('btn-submit').disabled = true;
		}
	});
</script>
<?= $this->endSection('content_auth'); ?>