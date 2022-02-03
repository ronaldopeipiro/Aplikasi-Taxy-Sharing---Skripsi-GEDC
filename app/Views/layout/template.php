<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title; ?> | AIRPORT TAXI SHARING APP</title>

	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/assets/img/logo.jpg">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/assets/img/logo.jpg">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/assets/img/logo.jpg">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/assets/img/logo.jpg">
	<link rel="manifest" href="<?= base_url(); ?>/assets/img/favicons/manifest.json">
	<meta name="msapplication-TileImage" content="<?= base_url(); ?>/assets/img/favicons/logo.jpg">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

	<link href="<?= base_url(); ?>/assets/css/theme.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>/assets/css/maps.css" rel="stylesheet" />

	<style>
		#description {
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
		}

		#infowindow-content .title {
			font-weight: bold;
		}

		#infowindow-content {
			display: none;
		}

		#map #infowindow-content {
			display: inline;
		}

		.pac-card {
			background-color: #fff;
			border: 0;
			border-radius: 2px;
			box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
			margin: 10px;
			padding: 0 0.5em;
			font: 400 18px Roboto, Arial, sans-serif;
			overflow: hidden;
			font-family: Roboto;
			padding: 0;
		}

		#pac-container {
			padding-bottom: 12px;
			margin-right: 12px;
		}

		.pac-controls {
			display: inline-block;
			padding: 10px 11px;
		}

		.pac-controls label {
			font-family: Roboto;
			font-size: 13px;
			font-weight: 300;
		}

		#pac-input {
			background-color: #fff;
			font-family: Roboto;
			font-size: 15px;
			font-weight: 300;
			margin: 10px 0 0 20px;
			padding: 8px 11px 8px 13px;
			text-overflow: ellipsis;
			width: 400px;
		}

		#pac-input:focus {
			border-color: #4d90fe;
		}

		#title {
			color: #fff;
			background-color: #4d90fe;
			font-size: 25px;
			font-weight: 500;
			padding: 6px 12px;
		}

		#target {
			width: 345px;
		}
	</style>

	<script src="<?= base_url(); ?>/assets_custom/jquery/jquery.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/animsition/js/animsition.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/select2/select2.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/countdowntime/countdowntime.js"></script>

	<script src="<?= base_url(); ?>/assets_custom/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>/assets_custom/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>/assets_custom/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>/assets_custom/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

	<script src="<?= base_url(); ?>/assets_custom/sweetalert2/sweetalert2.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

	<script src="https://maps.google.com/maps/api/js?libraries=places,geometry&key=AIzaSyBJkHXEVXBSLY7ExRcxoDxXzRYLJHg7qfI"></script>

	<script>
		const base_url = "<?= base_url() ?>"
	</script>
</head>

<body>

	<?php if (session()->getFlashdata('pesan_berhasil')) : ?>
		<script>
			Swal.fire(
				'Berhasil !',
				'<?= session()->getFlashdata('pesan_berhasil'); ?>',
				'success'
			)
		</script>
	<?php elseif (session()->getFlashdata('pesan_gagal')) : ?>
		<script>
			Swal.fire(
				'Gagal !',
				'<?= session()->getFlashdata('pesan_gagal'); ?>',
				'error'
			)
		</script>
	<?php endif; ?>

	<script>
		$(document).ready(function() {
			$('.btn-hapus').on('click', function(e) {
				event.preventDefault(); // prevent form submit
				Swal.fire({
					title: 'Apakah anda yakin ?',
					text: "Pilih ya, jika anda ingin menghapus data !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, hapus data !',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-terima-order').on('click', function(e) {
				event.preventDefault();
				Swal.fire({
					title: 'Apakah anda yakin ?',
					text: "Pilih ya, jika anda ingin menerima order !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Terima !',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-tolak-order').on('click', function(e) {
				event.preventDefault();
				Swal.fire({
					title: 'Apakah anda yakin ?',
					text: "Pilih ya, jika anda ingin menolak orderan !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Tolak !',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-cancel-order').on('click', function(e) {
				// prevent form submit
				event.preventDefault();
				Swal.fire({
					title: 'Apakah anda yakin ?',
					text: "Pilih ya, jika anda ingin membatalkan orderan !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Batalkan Orderan !',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-logout').on('click', function(e) {
				event.preventDefault(); // prevent form submit
				Swal.fire({
					title: 'Konfirmasi ?',
					text: "Apakah anda yakin ingin keluar dari aplikasi ?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Tidak'
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = $('.btn-logout').attr('href');
					}
				});
			});
		});

		$(function() {
			$('.js-select-2').select2();
			$('#data-table').DataTable({
				"paging": true,
				"responsive": true,
				"searching": true,
			});
		})
	</script>

	<main class="main" id="top">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 backdrop" data-navbar-on-scroll="data-navbar-on-scroll">
			<div class="container">
				<a class="navbar-brand d-flex align-items-center fw-bolder fs-2 fst-italic" href="#">
					<div class="text-danger">AIRPORT</div>
					<div class="text-info">TAXI</div>
					<div class="text-danger">SHARING</div>
				</a>
				<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto pt-2 pt-lg-0">

						<?php if ($user_level == "admin") : ?>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium active" aria-current="page" href="<?= base_url(); ?>/admin">
									Beranda
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/admin/orderan">
									Orderan
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/admin/customer">
									Customer
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/admin/driver">
									Driver
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/admin/bandara">
									Bandara
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/admin/pengaturan">
									Pengaturan
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium btn-logout" href="<?= base_url(); ?>/admin/logout">
									<i class="fa fa-sign-out"></i>
								</a>
							</li>

						<?php elseif ($user_level == "customer") : ?>

							<li class="nav-item px-2">
								<a class="nav-link fw-medium active" aria-current="page" href="<?= base_url(); ?>/customer">
									Beranda
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/customer/order">
									Order
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/customer/history">
									History
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/customer/akun">
									Akun Saya
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium btn-logout" href="<?= base_url(); ?>/customer/logout">
									<i class="fa fa-sign-out"></i>
								</a>
							</li>

						<?php elseif ($user_level == "driver") : ?>

							<li class="nav-item px-2">
								<a class="nav-link fw-medium active" aria-current="page" href="<?= base_url(); ?>/driver">
									Beranda
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/driver/orderan">
									Orderan
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/driver/pengantaran">
									Pengantaran
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/driver/history">
									History
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium" href="<?= base_url(); ?>/driver/akun">
									Akun Saya
								</a>
							</li>
							<li class="nav-item px-2">
								<a class="nav-link fw-medium btn-logout" href="<?= base_url(); ?>/driver/logout">
									<i class="fa fa-sign-out"></i>
								</a>
							</li>

						<?php endif; ?>

					</ul>
				</div>
			</div>
		</nav>

		<?= $this->renderSection('content'); ?>

		<section class="py-0 bg-primary-gradient">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-auto mb-2">
						<p class="mb-0 fs--1 text-white my-2 text-center">Copyright &copy; | <?= date('Y'); ?> <br>
							<a href="https://instagram.com/wildgedc" class="text-white" target="_blank">
								Gregorius Edward Dicky Chandra
							</a>
						</p>
					</div>
				</div>
			</div>
		</section>
	</main>

	<script src="<?= base_url(); ?>/vendors/@popperjs/popper.min.js"></script>
	<script src="<?= base_url(); ?>/vendors/bootstrap/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>/vendors/is/is.min.js"></script>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
	<script src="<?= base_url(); ?>/assets/js/theme.js"></script>

	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400&amp;display=swap" rel="stylesheet">
</body>

</html>