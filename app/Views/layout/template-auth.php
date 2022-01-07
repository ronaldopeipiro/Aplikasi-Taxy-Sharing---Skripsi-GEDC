<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?> | TAXI SHARING APP</title>

	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/assets/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/assets/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/assets/img/favicons/favicon-16x16.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/assets/img/favicons/favicon.ico">
	<link rel="manifest" href="<?= base_url(); ?>/assets/img/favicons/manifest.json">
	<meta name="msapplication-TileImage" content="<?= base_url(); ?>/assets/img/favicons/mstile-150x150.png">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/css/main.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

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

	<script src="<?= base_url(); ?>/assets_login/js/main.js"></script>

	<style>
		/* Hide the browser's default checkbox */
		.container-remember input {
			position: absolute;
			opacity: 0;
			cursor: pointer;
			height: 0;
			width: 0;
		}

		/* Create a custom checkbox */
		.checkmark {
			position: absolute;
			top: 0;
			left: 0;
			height: 22px;
			width: 22px;
			background-color: #ccc;
			border-radius: 50%;
		}

		.checkmark2 {
			position: absolute;
			top: 0;
			height: 22px;
			width: 22px;
			background-color: #ccc;
			border-radius: 50%;
		}

		/* On mouse-over, add a grey background color */
		.container-remember:hover input~.checkmark,
		.container-remember:hover input~.checkmark2 {
			background-color: #ccc;
			color: #000;
		}

		/* When the checkbox is checked, add a blue background */
		.container-remember input:checked~.checkmark,
		.container-remember input:checked~.checkmark2 {
			background-color: #3CAB35;
		}

		/* Create the checkmark/indicator (hidden when not checked) */
		.checkmark:after,
		.checkmark2:after {
			content: "";
			position: absolute;
			display: none;
		}

		/* Show the checkmark when checked */
		.container-remember input:checked~.checkmark:after,
		.container-remember input:checked~.checkmark2:after {
			display: block;
		}

		/* Style the checkmark/indicator */
		.container-remember .checkmark:after,
		.container-remember .checkmark2:after {
			left: 9px;
			top: 4px;
			width: 5px;
			height: 14px;
			border: solid white;
			border-width: 0 3px 3px 0;
			-webkit-transform: rotate(45deg);
			-ms-transform: rotate(45deg);
			transform: rotate(45deg);
		}
	</style>
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

	<?= $this->renderSection('content_auth'); ?>

</body>

</html>