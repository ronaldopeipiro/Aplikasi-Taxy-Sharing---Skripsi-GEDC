<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home" style="min-height: 97vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row row-deck row-cards">

			<div class="col-lg-8 mb-2">
				<div class="card shadow">

					<div class="card-body border-bottom py-2">

						<h5 class="mt-3">
							<i class="fa fa-edit"></i>
							Ubah Data Akun
						</h5>
						<hr>
						<form id="formUpdateDataAkun">
							<?= csrf_field(); ?>

							<div class="form-group row mt-3">
								<label for="nama_lengkap" class="col-sm-3 col-form-label">
									Nama Lengkap
								</label>
								<div class="col-sm-9">
									<input type="text" class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap ..." value="<?= (old('nama_lengkap')) ? old('nama_lengkap') : $user_nama_lengkap; ?>">
									<div class="invalid-feedback">
										<?= $validation->getError('nama_lengkap'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-3">
								<label for="username" class="col-sm-3 col-form-label">
									Username
								</label>
								<div class="col-sm-9">
									<input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= (old('username')) ? old('username') : $user_username; ?>" placeholder="Masukkan username . . . ." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" minlength="16" maxlength="16">
									<div class="invalid-feedback">
										<?= $validation->getError('username'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-3">
								<label for="email" class="col-sm-3 col-form-label">
									Email
								</label>
								<div class="col-sm-9">
									<input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Masukkan email ..." value="<?= (old('email')) ? old('email') : $user_email; ?>">
									<div class="invalid-feedback">
										<?= $validation->getError('email'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-3">
								<label for="no_hp" class="col-sm-3 col-form-label">
									No. Handphone
								</label>
								<div class="col-sm-4">
									<input type="text" class="form-control <?= ($validation->hasError('no_hp')) ? 'is-invalid' : ''; ?>" id="no_hp" name="no_hp" placeholder="08XX XXXX . . . ." value="<?= (old('no_hp')) ? old('no_hp') : $user_no_hp; ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" minlength="11" maxlength="13">
									<div class="invalid-feedback">
										<?= $validation->getError('no_hp'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mb-2" style="margin-top: 38px;">
								<div class="col-12 text-right">
									<button type="submit" class="btn btn-outline-success shadow" style="width: 180px;">
										<span class="fa fa-save" style="margin-right: 10px;"></span> SIMPAN
									</button>
								</div>
							</div>

						</form>

					</div>

				</div>
			</div>

			<div class="col-lg-4 mb-2">

				<div class="card shadow">

					<div class="card-body border-bottom py-0">

						<h5 class="mt-3">
							<i class="fa fa-edit"></i>
							Ubah Foto Profil
						</h5>
						<hr>

						<form id="formUbahFotoProfil">

							<div class="form-group row mt-3">
								<div class="col-lg-12 text-center">
									<?php
									if ($user_foto != "") {
										if (strpos($user_foto, ':') !== false) {
											$foto_user = $user_foto;
										} else {
											$foto_user = base_url() . '/assets/img/customer/' . $user_foto;
										}
									} else {
										$foto_user = base_url() . '/assets/img/noimg.png';
									}
									?>
									<img id="fotobaru" src="<?= $foto_user; ?>" style="width: 180px; height: 180px; border-radius: 10px; object-fit: cover; object-position: center;">
								</div>
								<div class="col-sm-12 mt-3">
									<input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : ''; ?>" id="foto" name="foto" required onchange="readURL(this)" accept="image/png, image/jpeg, image/jpg">
									<div class="invalid-feedback">
										<?= $validation->getError('foto'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-4 mb-3">
								<div class="col-12">
									<button type="submit" class="btn btn-block btn-outline-success shadow">
										<span class="fa fa-save" style="margin-right: 10px;"></span> SIMPAN
									</button>
								</div>
							</div>
						</form>

					</div>

				</div>
			</div>

			<div class="col-lg-12 mt-3">
				<div class="card shadow">
					<div class="card-body border-bottom py-2">

						<h5 class="mt-3">
							<i class="fa fa-edit"></i>
							Ubah Password Akun
						</h5>
						<hr>

						<form id="formUpdatePassword">
							<?= csrf_field(); ?>

							<div class="form-group row mt-3">
								<label for="password_lama" class="col-sm-3 col-form-label">
									Password lama
								</label>
								<div class="col-sm-9">
									<input type="password" class="form-control <?= ($validation->hasError('password_lama')) ? 'is-invalid' : ''; ?>" id="password_lama" name="password_lama" placeholder="Masukkan password lama ..." value="<?= old('password_lama') ?>">
									<div class="invalid-feedback">
										<?= $validation->getError('password_lama'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-3">
								<label for="password_baru" class="col-sm-3 col-form-label">
									Password Baru
								</label>
								<div class="col-sm-9">
									<input type="password" class="form-control <?= ($validation->hasError('password_baru')) ? 'is-invalid' : ''; ?>" id="password_baru" name="password_baru" placeholder="Masukkan password baru ..." value="<?= old('password_baru') ?>">
									<div class="invalid-feedback">
										<?= $validation->getError('password_baru'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-3">
								<label for="konfirmasi_password" class="col-sm-3 col-form-label">
									Konfirmasi Password Baru
								</label>
								<div class="col-sm-9">
									<input type="password" class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : ''; ?>" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukkan konfirmasi password  ..." value="<?= old('konfirmasi_password') ?>">
									<div class="invalid-feedback">
										<?= $validation->getError('konfirmasi_password'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-4 mb-2">
								<div class="col-12 text-right">
									<button type="submit" class="btn btn-outline-success shadow" style="width: 180px;">
										<span class="fa fa-save" style="margin-right: 10px;"></span> SIMPAN
									</button>
								</div>
							</div>

						</form>

					</div>

				</div>
			</div>

		</div>

	</div>

</section>

<script>
	$(document).ready(function() {
		$(function() {

			$("#formUpdateTarif").submit(function(e) {
				e.preventDefault();

				var tarif_perkm = $('#tarif_perkm').val();

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/Customer/Akun/ubah_tarif",
					dataType: "JSON",
					data: {
						tarif_perkm: tarif_perkm
					},
					success: function(data) {
						if (data.success == "1") {
							Swal.fire(
								'Berhasil !',
								data.pesan,
								'success'
							)
						} else if (data.success == "0") {
							Swal.fire(
								'Gagal !',
								data.pesan,
								'error'
							)
						}
					}
				});

			});

			$("#formUpdateDataAkun").submit(function(e) {
				e.preventDefault();

				var nama_lengkap = $('#nama_lengkap').val();
				var username = $('#username').val();
				var no_hp = $('#no_hp').val();
				var email = $('#email').val();

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/Customer/Akun/ubah_data_akun",
					dataType: "JSON",
					data: {
						nama_lengkap: nama_lengkap,
						username: username,
						no_hp: no_hp,
						email: email
					},
					success: function(data) {
						if (data.success == "1") {
							Swal.fire(
								'Berhasil !',
								data.pesan,
								'success'
							)
						} else if (data.success == "0") {
							Swal.fire(
								'Gagal !',
								data.pesan,
								'error'
							)
						}
					}
				});

			});

			$("#formUpdatePassword").submit(function(e) {
				e.preventDefault();

				var password_lama = $('#password_lama').val();
				var password_baru = $('#password_baru').val();
				var konfirmasi_password = $('#konfirmasi_password').val();

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/Customer/Akun/ubah_password",
					dataType: "JSON",
					data: {
						password_lama: password_lama,
						password_baru: password_baru,
						konfirmasi_password: konfirmasi_password,
					},
					success: function(data) {
						if (data.success == "1") {
							Swal.fire(
								'Berhasil !',
								data.pesan,
								'success'
							)
						} else if (data.success == "0") {
							Swal.fire(
								'Gagal !',
								data.pesan,
								'error'
							)
						}
					}
				});

			});

			$("#formUbahFotoProfil").submit(function(e) {
				e.preventDefault();

				const foto = $('#foto').prop('files')[0];

				let formData = new FormData();
				formData.append('foto', foto);

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/Customer/Akun/ubah_foto_profil",
					dataType: "JSON",
					data: formData,
					cache: false,
					processData: false,
					contentType: false,
					success: function(data) {
						if (data.success == "1") {
							Swal.fire(
								'Berhasil !',
								data.pesan,
								'success'
							)
						} else if (data.success == "0") {
							Swal.fire(
								'Gagal !',
								data.pesan,
								'error'
							)
						}
					}
				});

			});

		});
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#fotobaru')
					.attr('src', e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
</script>

<?= $this->endSection('content'); ?>