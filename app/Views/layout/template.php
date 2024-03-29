<?php
date_default_timezone_set("Asia/Jakarta");
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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

	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400&amp;display=swap" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets_login/vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.2/css/fixedHeader.bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="<?= base_url(); ?>/assets/css/theme.css" rel="stylesheet" />
	<link href="<?= base_url(); ?>/assets/css/maps.css" rel="stylesheet" />

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

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<script src="https://maps.google.com/maps/api/js?libraries=places,geometry&key=AIzaSyB-JpweDJ7_cA9-KiEq-iMjQzlluOemnWo&language=id-ID"></script>

	<script>
		const base_url = "<?= base_url() ?>";
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const applicationServerKey =
				'BMBlr6YznhYMX3NgcWIDRxZXs0sh7tCv7_YCsWcww0ZCv9WGg-tRCXfMEHTiBPCksSqeve1twlbmVAZFv7GSuj0';

			if (!('serviceWorker' in navigator)) {
				console.warn('Service workers are not supported by this browser');
				return;
			}

			if (!('PushManager' in window)) {
				console.warn('Push notifications are not supported by this browser');
				return;
			}

			if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
				console.warn('Notifications are not supported by this browser');
				return;
			}

			if (Notification.permission === 'denied') {
				console.warn('Notifications are denied by the user');
				return;
			}

			push_subscribe();

			navigator.serviceWorker.register(base_url + '/service-worker-notif.js').then(
				() => {
					console.log('[SW] Service worker has been registered');
					push_updateSubscription();
				},
				e => {
					console.error('[SW] Service worker registration failed', e);
				}
			);

			function urlBase64ToUint8Array(base64String) {
				const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
				const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');

				const rawData = window.atob(base64);
				const outputArray = new Uint8Array(rawData.length);

				for (let i = 0; i < rawData.length; ++i) {
					outputArray[i] = rawData.charCodeAt(i);
				}
				return outputArray;
			}

			function checkNotificationPermission() {
				return new Promise((resolve, reject) => {
					if (Notification.permission === 'denied') {
						return reject(new Error('Push messages are blocked.'));
					}
					if (Notification.permission === 'granted') {
						return resolve();
					}
					if (Notification.permission === 'default') {
						return Notification.requestPermission().then(result => {
							if (result !== 'granted') {
								reject(new Error('Bad permission result'));
							} else {
								resolve();
							}
						});
					}
					return reject(new Error('Unknown permission'));
				});
			}

			function push_subscribe() {
				return checkNotificationPermission()
					.then(() => navigator.serviceWorker.ready)
					.then(serviceWorkerRegistration =>
						serviceWorkerRegistration.pushManager.subscribe({
							userVisibleOnly: true,
							applicationServerKey: urlBase64ToUint8Array(applicationServerKey),
						})
					)
					.then(subscription => {
						return subscribe_user(subscription);
					})
					.then(subscription => subscription) // update your UI
					.catch(e => {
						if (Notification.permission === 'denied') {
							console.warn('Notifications are denied by the user.');
						} else {
							console.error('Impossible to subscribe to push notifications', e);
						}
					});
			}

			function push_updateSubscription() {
				navigator.serviceWorker.ready
					.then(serviceWorkerRegistration => serviceWorkerRegistration.pushManager.getSubscription())
					.then(subscription => {
						if (!subscription) {
							return;
						}
						return subscribe_user(subscription);
					})
					.then(subscription => subscription)
					.catch(e => {
						console.error('Error when updating the subscription', e);
					});
			}

			function push_unsubscribe() {
				navigator.serviceWorker.ready
					.then(serviceWorkerRegistration => serviceWorkerRegistration.pushManager.getSubscription())
					.then(subscription => {
						if (!subscription) {
							return;
						}
						// return subscribe_user(subscription);
					})
					.then(subscription => subscription.unsubscribe())
					.catch(e => {
						console.error('Error when unsubscribing the user', e);
					});
			}

			function subscribe_user(subscription) {
				const key = subscription.getKey('p256dh');
				const token = subscription.getKey('auth');
				const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];

				var endpoint = getEndpoint(subscription);
				var p256dh = key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null;
				var auth = token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null;

				console.log(endpoint);
				console.log(p256dh);
				console.log(auth);
				console.log(contentEncoding);

				var id_user = '<?= $user_id ?>';
				var tipe_user = '<?= $user_level ?>';

				$.ajax({
					type: "POST",
					url: base_url + "/Home/push_subscription",
					dataType: "JSON",
					enctype: 'multipart/form-data',
					data: {
						id_user: id_user,
						tipe_user: tipe_user,
						endpoint: endpoint,
						p256dh: p256dh,
						auth: auth,
						ce: contentEncoding
					},
					beforeSend: function() {
						$("#loader").show();
					},
					success: function(data) {
						if (data.success == "1") {
							toastr.success(data.pesan);
						} else if (data.success == "0") {
							toastr.error(data.pesan);
						}
					},
					complete: function() {
						$("#loader").hide();
					}
				});
			}
		});

		function getEndpoint(pushSubscription) {
			var endpoint = pushSubscription.endpoint;
			var subscriptionId = pushSubscription.subscriptionId;

			// fix Chrome < 45
			if (subscriptionId && endpoint.indexOf(subscriptionId) === -1) {
				endpoint += '/' + subscriptionId;
			}

			return endpoint;
		}

		function send_notif(id_user, tipe_user, text_pesan) {
			const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];
			$.ajax({
				type: "POST",
				url: base_url + "/Home/send_push_notif",
				dataType: "JSON",
				data: {
					id_user: id_user,
					tipe_user: tipe_user,
					text_pesan: text_pesan,
					ce: contentEncoding
				},
				beforeSend: function() {
					$("#loader").show();
				},
				success: function(data) {
					console.log(data.pesan);
				},
				complete: function() {
					$("#loader").hide();
				}
			});
		}
	</script>

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

		#navbar-mobile {
			background-color: #66B8F7;
		}

		#navbar-mobile .nav-item {
			color: #fff !important;
		}

		#navbar-mobile .nav-item.active {
			background-color: aliceblue;
		}
	</style>
</head>

<body>

	<div id="loader" style="display: none;">
		<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
			<img src="<?= base_url(); ?>/assets/img/loader.gif" style="width: 150px; height: 150px; object-fit: cover; object-position: center;">
		</div>
	</div>

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

	<main class="main" id="top">
		<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 backdrop" data-navbar-on-scroll="data-navbar-on-scroll">
			<div class="container">
				<?php
				if ($user_level == "admin") {
					$link_home = base_url() . "/admin";
				} elseif ($user_level == "customer") {
					$link_home = base_url() . "/customer";
				} elseif ($user_level == "driver") {
					$link_home = base_url() . "/driver";
				}
				?>

				<a class="navbar-brand d-flex align-items-center fw-bolder fs-2 fst-italic" href="<?= $link_home; ?>">
					<div class="text-danger">AIRPORT</div>
					<div class="text-info">TAXI</div>
					<div class="text-warning">SHARING</div>
				</a>
				<button class="navbar-toggler collapsed d-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0 d-none d-lg-block" id="navbarSupportedContent">
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

							<?php if ($user_status == 1) : ?>
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
							<?php endif; ?>
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

		<div class="container-fluid">
			<div class="row navbar-expand-md fixed-bottom navbar-expand d-lg-none d-xl-none" id="navbar-mobile">
				<div class="p-0 navbar">
					<div class="col-lg-12">

						<?php if ($user_level == "customer") : ?>

							<ul class="navbar-nav nav-justified w-100">
								<li class="nav-item <?= $request->uri->getSegment(2) == '' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/customer">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="5 12 3 12 12 3 21 12 19 12" />
												<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
												<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Dashboard
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'order' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/customer/order">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="7" cy="17" r="2" />
												<circle cx="17" cy="17" r="2" />
												<path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Order
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'history' ? 'active' : ''; ?>">
									<a class="nav-link px-0 py-3 d-block text-center" href="<?= base_url(); ?>/customer/history">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="12 8 12 12 14 14" />
												<path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											History
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'akun' ? 'active' : ''; ?>">
									<a class="nav-link px-0 py-3 d-block" href="<?= base_url(); ?>/customer/akun">
										<div class="nav-link-icon w-100 d-flex justify-content-center justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="12" cy="7" r="4" />
												<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Akun Saya
										</small>
									</a>
								</li>
							</ul>

						<?php elseif ($user_level == "driver") : ?>

							<ul class="navbar-nav nav-justified w-100">
								<li class="nav-item <?= $request->uri->getSegment(2) == '' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/driver">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="5 12 3 12 12 3 21 12 19 12" />
												<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
												<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Dashboard
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'orderan' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/driver/orderan">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="7" cy="17" r="2" />
												<circle cx="17" cy="17" r="2" />
												<path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Orderan
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'pengantaran' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/driver/pengantaran">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="6" cy="19" r="2" />
												<circle cx="18" cy="5" r="2" />
												<path d="M12 19h4.5a3.5 3.5 0 0 0 0 -7h-8a3.5 3.5 0 0 1 0 -7h3.5" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Pengantaran
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'history' ? 'active' : ''; ?>">
									<a class="nav-link px-0 py-3 d-block text-center" href="<?= base_url(); ?>/driver/history">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="12 8 12 12 14 14" />
												<path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											History
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'akun' ? 'active' : ''; ?>">
									<a class="nav-link px-0 py-3 d-block" href="<?= base_url(); ?>/driver/akun">
										<div class="nav-link-icon w-100 d-flex justify-content-center justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="12" cy="7" r="4" />
												<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Akun Saya
										</small>
									</a>
								</li>
							</ul>

						<?php elseif ($user_level == "admin") : ?>

							<ul class="navbar-nav nav-justified w-100">
								<li class="nav-item <?= $request->uri->getSegment(2) == '' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/admin">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<polyline points="5 12 3 12 12 3 21 12 19 12" />
												<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
												<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Dashboard
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'orderan' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/admin/orderan">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="7" cy="17" r="2" />
												<circle cx="17" cy="17" r="2" />
												<path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Orderan
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'customer' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/admin/customer">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<!-- Download SVG icon from http://tabler-icons.io/i/users -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="9" cy="7" r="4" />
												<path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
												<path d="M16 3.13a4 4 0 0 1 0 7.75" />
												<path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Customer
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'driver' ? 'active' : ''; ?>">
									<a class="nav-link py-3 d-block text-center" href="<?= base_url(); ?>/admin/driver">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<circle cx="12" cy="12" r="9" />
												<circle cx="12" cy="12" r="2" />
												<line x1="12" y1="14" x2="12" y2="21" />
												<line x1="10" y1="12" x2="3.25" y2="10" />
												<line x1="14" y1="12" x2="20.75" y2="10" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Driver
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'bandara' ? 'active' : ''; ?>">
									<a class="nav-link px-0 py-3 d-block text-center" href="<?= base_url(); ?>/admin/bandara">
										<div class="nav-link-icon w-100 d-flex justify-content-center">
											<!-- Download SVG icon from http://tabler-icons.io/i/plane -->
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M16 10h4a2 2 0 0 1 0 4h-4l-4 7h-3l2 -7h-4l-2 2h-3l2 -4l-2 -4h3l2 2h4l-2 -7h3z" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Bandara
										</small>
									</a>
								</li>

								<li class="nav-item <?= $request->uri->getSegment(2) == 'pengaturan' ? 'active' : ''; ?>">
									<a class="nav-link px-0 py-3 d-block" href="<?= base_url(); ?>/admin/pengaturan">
										<div class="nav-link-icon w-100 d-flex justify-content-center justify-content-center">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none" />
												<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
												<path d="M10 9v6l5 -3z" />
											</svg>
										</div>
										<small style="font-size: 10px;">
											Pengaturan
										</small>
									</a>
								</li>
							</ul>

						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>

		<?= $this->renderSection('content'); ?>

	</main>

	<script src="<?= base_url(); ?>/vendors/@popperjs/popper.min.js"></script>
	<script src="<?= base_url(); ?>/vendors/bootstrap/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>/vendors/is/is.min.js"></script>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
	<script src="<?= base_url(); ?>/assets/js/theme.js"></script>

	<script>
		$(document).ready(function() {
			$('.btn-hapus').on('click', function(e) {
				event.preventDefault(); // prevent form submit
				Swal.fire({
					title: 'Hapus Data ?',
					text: "Pilih ya, jika anda ingin menghapus data !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
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
					title: 'Batalkan Orderan',
					text: "Pilih ya, jika anda ingin membatalkan orderan !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-cancel-confirm-pengantaran').on('click', function(e) {
				event.preventDefault();
				Swal.fire({
					title: 'Batalkan pengantaran ?',
					text: "Pilih ya, jika anda ingin membatalkan pengantaran !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
					cancelButtonText: 'Batal'
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents('form');
						form.submit();
					}
				});
			});

			$('.btn-confirm-selesai-pengantaran').on('click', function(e) {
				// prevent form submit
				event.preventDefault();
				Swal.fire({
					title: 'Selesai Pengantaran ?',
					text: "Pilih ya, jika anda telah selesai melakukan pengantaran penumpang dari bandara !",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya',
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
					title: 'Logout ?',
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

	<script>
		function customer_update_status_order(id_order, status, id_driver, id_customer) {
			event.preventDefault();
			var title_status,
				text_status,
				text_notif_driver,
				text_notif_customer;

			if (status == '5') {
				title_status = "Batalkan Orderan ?";
				text_status = "Pilih ya, jika anda ingin membatalkan orderan !";

				text_notif_driver = "Orderan dibatalkan oleh customer !";
				text_notif_customer = "Orderan dibatalkan oleh anda !";
			}

			Swal.fire({
				title: title_status,
				text: text_status,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: "POST",
						url: base_url + "/Customer/Order/update_status_order",
						dataType: "JSON",
						data: {
							id_order: id_order,
							status: status
						},
						beforeSend: function() {
							$("#loader").show();
						},
						success: function(data) {
							if (data.success == "1") {
								send_notif(id_driver, 'driver', text_notif_driver);
								send_notif(id_customer, 'customer', text_notif_customer);

								Swal.fire({
									title: 'Berhasil !',
									text: data.pesan,
									type: 'success'
								}).then(function() {
									window.location = base_url + '/customer/order';
								});

							} else if (data.success == "0") {

								Swal.fire({
									title: 'Gagal !',
									text: data.pesan,
									type: 'error'
								}).then(function() {
									window.location = base_url + '/customer/order';
								});
							}
						},
						complete: function(data) {
							$("#loader").hide();
						}
					});
				}
			});

		}

		function driver_update_status_order(id_order, status, id_driver, id_customer) {
			event.preventDefault();
			var title_status,
				text_status,
				text_notif_driver,
				text_notif_customer;

			if (status == '1') {
				title_status = "Terima Orderan ?";
				text_status = "Pilih ya, jika anda ingin menerima orderan !";

				text_notif_driver = "Berhasil menerima orderan !";
				text_notif_customer = "Orderan diterima oleh driver. Mohon tunggu, driver akan segera menjemput anda !";
			} else if (status == '2') {
				title_status = "Jemput Customer ?";
				text_status = "Pilih ya, jika anda benar akan menjemput customer !";

				text_notif_driver = "Menjemput Customer !";
				text_notif_customer = "Driver sedang menuju ke lokasi anda, silahkan tunggu !";
			} else if (status == '3') {
				title_status = "Menuju Bandara ?";
				text_status = "Pilih Ya, jika anda telah siap menuju bandara ?";

				text_notif_driver = "Menuju bandara, hati-hati dijalan yaa !";
				text_notif_customer = "Anda sedang menuju bandara bersama driver kami !";
			} else if (status == '4') {
				title_status = "Selesai";
				text_status = "Anda telah sampai di tujuan pengantaran ?";

				text_notif_driver = "Orderan Selesai, Good Job !";
				text_notif_customer = "Orderan Selesai, Anda telah sampai ditujuan. Terima kasih telah menggunakan layanan kami !";
			} else if (status == '6') {
				title_status = "Batalkan Orderan ?";
				text_status = "Pilih Ya, jika anda ingin membatalkan orderan !";

				text_notif_driver = "Orderan dibatalkan oleh anda !";
				text_notif_customer = "Orderan ditolak oleh driver !";
			}

			Swal.fire({
				title: title_status,
				text: text_status,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: "POST",
						url: base_url + "/Driver/Orderan/update_status_order",
						dataType: "JSON",
						data: {
							id_order: id_order,
							status: status
						},
						beforeSend: function() {
							$("#loader").show();
						},
						success: function(data) {
							if (data.success == "1") {
								send_notif(id_driver, 'driver', text_notif_driver);
								send_notif(id_customer, 'customer', text_notif_customer);

								Swal.fire({
									title: 'Berhasil !',
									text: data.pesan,
									type: 'success'
								}).then(function() {
									window.location = base_url + '/driver/orderan';
								});

							} else if (data.success == "0") {

								Swal.fire({
									title: 'Gagal !',
									text: data.pesan,
									type: 'error'
								}).then(function() {
									window.location = base_url + '/driver/orderan';
								});
							}
						},
						complete: function(data) {
							$("#loader").hide();
						}
					});
				}
			});

		}
	</script>

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