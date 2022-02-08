<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400&amp;display=swap" rel="stylesheet">

	<link href="<?= base_url(); ?>/assets/css/theme.css" rel="stylesheet" />

	<script src="<?= base_url(); ?>/assets_custom/jquery/jquery.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/animsition/js/animsition.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendors/@popperjs/popper.min.js"></script>
	<script src="vendors/bootstrap/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>/vendors/is/is.min.js"></script>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
	<script src="<?= base_url(); ?>/assets/js/theme.js"></script>

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

	<style>
		div#loader {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(255, 255, 255, 0.5);
			z-index: 1;
		}
	</style>
</head>


<body>

	<div id="loader" style="display: none;">
		<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
			<img src="<?= base_url(); ?>/assets/img/loader.gif" style="width: 150px; height: 150px; object-fit: cover; object-position: center;">
		</div>
	</div>

	<main class="main" id="top">
		<?= $this->renderSection('content_landing'); ?>

		<section class="py-0 bg-primary-gradient">
			<div class="bg-holder" style="background-image:url(assets/img/illustrations/footer-bg.png);background-position:center;background-size:cover;">
			</div>
			<!--/.bg-holder-->

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


</body>

</html>