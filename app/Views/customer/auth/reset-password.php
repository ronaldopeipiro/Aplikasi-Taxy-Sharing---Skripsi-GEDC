<?= $this->extend('layout/template-auth'); ?>

<?= $this->section('content_auth'); ?>

<div class="container-login100" style="background-image: url('<?= base_url(); ?>/assets/img/bg-login.jpg');">
	<div class="wrap-login100 p-l-20 p-r-20 p-t-40 p-b-40">

		<form id="formSubmitResetPassword">
			<?= csrf_field(); ?>

			<input type="hidden" id="token_reset_password" name="token_reset_password" value="<?= $token; ?>">

			<div class="row mb-5">
				<div class="col-12">
					<h3 class="text-center font-weight-bold">AIRPORT TAXI SHARING APP</h3>
					<hr>
					<h5 class="text-center">
						Reset Password Akun Customer
					</h5>
				</div>
			</div>

			<div class="row justify-content-center">

				<?php
				$cek_token = ($db->query("SELECT * FROM tb_customer WHERE token_reset_password = '$token' "))->getNumRows();
				?>
				<?php if ($cek_token > 0) : ?>

					<div class="col-lg-8 mt-4 mt-lg-0">
						<div class="wrap-input100">
							<input class="input100 <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>" type="password" id="password" name="password" placeholder="Password baru ..." value="<?= (old('password')) ? old('password') : ''; ?>">
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
							<a href="<?= base_url(); ?>/customer/login" class="btn btn-link pl-0 pt-1 pb-2">
								Login
							</a>
						</div>

						<div class="text-center mt-4">
							<a href="<?= base_url(); ?>">
								<i class="fa fa-arrow-left"></i> Kembali
							</a>
						</div>
					</div>

				<?php else : ?>

					<div class="col-lg-12">
						<div class="alert alert-danger text-center">
							<h3>
								Token tidak valid !
							</h3>
						</div>

						<div class="text-center mt-5">
							<a href="<?= base_url(); ?>">
								<i class="fa fa-arrow-left"></i> Dashboard Aplikasi
							</a>
						</div>
					</div>

				<?php endif; ?>

			</div>

		</form>


	</div>
</div>

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

<script>
	$(document).ready(function() {
		$(function() {

			$("#formSubmitResetPassword").submit(function(e) {
				e.preventDefault();
				var token_reset_password = $('#token_reset_password').val();
				var password = $('#password').val();
				var konfirmasi_password = $('#konfirmasi_password').val();

				$.ajax({
					type: "POST",
					url: "<?= base_url(); ?>/Customer/Auth/submit_reset_password",
					dataType: "JSON",
					data: {
						token_reset_password: token_reset_password,
						password: password,
						konfirmasi_password: konfirmasi_password
					},
					beforeSend: function() {
						$("#loading-image").show();
					},
					success: function(data) {
						if (data.success == "1") {
							Swal.fire(
								'Berhasil',
								data.pesan,
								'success'
							).then(function() {
								window.location = base_url + '/customer/login';
							});
						} else if (data.success == "0") {
							Swal.fire(
								'Gagal',
								data.pesan,
								'error'
							)
						}
					},
					complete: function(data) {
						$("#loading-image").hide();
					}
				});
			});

		});
	});
</script>

<?= $this->endSection('content_auth'); ?>