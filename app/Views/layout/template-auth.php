<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?> | AIRPORT TAXI SHARING APP</title>

	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Brew">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>/assets/img/logo.jpg" type="image/png">
	<link rel="apple-touch-icon" sizes="167x167" href="<?= base_url(); ?>/assets/img/logo.jpg" type="image/png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/assets/img/logo.jpg" type="image/png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/assets/img/logo.jpg">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/assets/img/logo.jpg">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/assets/img/logo.jpg">

	<link rel="manifest" href="<?= base_url(); ?>/manifest.json">

	<meta name="msapplication-TileImage" content="<?= base_url(); ?>/assets/img/favicons/logo.jpg">
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

	<script src="<?= base_url(); ?>/assets_custom/jquery/jquery.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/animsition/js/animsition.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/select2/select2.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url(); ?>/assets_login/vendor/countdowntime/countdowntime.js"></script>

	<script src="<?= base_url(); ?>/assets_custom/sweetalert2/sweetalert2.min.js"></script>

	<script src="<?= base_url(); ?>/assets_login/js/main.js"></script>

	<script>
		const base_url = "<?= base_url() ?>"
	</script>

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

		div#loading-image {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(255, 255, 255, 0.5);
			z-index: 100;
		}
	</style>
</head>

<body>

	<div id="loading-image" style="display: none;">
		<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
			<img src="<?= base_url(); ?>/assets/img/loader.gif" style="width: 150px; height: 150px; object-fit: cover; object-position: center;">
		</div>
	</div>

	<?= $this->renderSection('content_auth'); ?>

	<!-- <script>
		if ('serviceWorker' in navigator) {
			window.addEventListener('load', function() {
				navigator.serviceWorker.register('<?= base_url() ?>/service-worker.js').then(function(registration) {
					console.log('ServiceWorker Berhasil di Install: ', registration.scope);
				}, function(err) {
					console.log('ServiceWorker Gagal Di Install: ', err);
				});
			});
		}
	</script> -->
</body>

</html>