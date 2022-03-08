<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title; ?> | TAXI SHARING APP</title>

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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
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
	<script src="<?= base_url(); ?>/assets_login/vendor/countdowntime/countdowntime.js"></script>

	<script src="<?= base_url(); ?>/assets_custom/sweetalert2/sweetalert2.min.js"></script>

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

	<script>
		if ('serviceWorker' in navigator) {
			window.addEventListener('load', function() {
				navigator.serviceWorker.register('<?= base_url() ?>/service-worker.js').then(function(registration) {
					console.log('ServiceWorker Berhasil di Install: ', registration.scope);
				}, function(err) {
					console.log('ServiceWorker Gagal Di Install: ', err);
				});
			});
		}
	</script>

</body>

</html>