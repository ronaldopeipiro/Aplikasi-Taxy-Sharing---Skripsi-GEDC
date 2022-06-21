<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
function rupiah($angka, $string)
{
	if ($string == "Y") {
		$hasil_rupiah = "Rp." . number_format($angka, 0, ',', '.');
	} elseif ($string == "N") {
		$hasil_rupiah = number_format($angka, 0, ',', '.');
	}
	return $hasil_rupiah;
}


$data_orderan_belum_selesai = $db->query("SELECT * FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE tb_pengantaran.id_driver = '$user_id' AND tb_order.status <= 4");
$jumlah_orderan_masuk_belum_selesai =  $data_orderan_belum_selesai->getNumRows();

$class_dashboard = new App\Controllers\Driver\Dashboard;
?>

<section class="py-8" id="home">

	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/driver" class="btn btn-dark" title="Tambah Data Pengantaran">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-2">
						Orderan
					</h4>
				</div>
				<hr>
			</div>
		</div>

		<?php if ($jumlah_orderan_masuk_belum_selesai > 0) : ?>
			<?php if ($r_orderan = $data_orderan_belum_selesai->getRow()) : ?>
				<?php
				$id_customer = $r_orderan->id_customer;
				$customer = ($db->query("SELECT * FROM tb_customer WHERE id_customer='$id_customer'"))->getRow();

				$id_pengantaran = $r_orderan->id_pengantaran;
				$pengantaran = ($db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' LIMIT 1"))->getRow();

				$id_driver = $pengantaran->id_driver;
				$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver'"))->getRow();

				$id_bandara = $r_orderan->id_bandara;
				$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'"))->getRow();

				if ($r_orderan->status == "0") {
					$class_text_status = "badge badge-warning";
					$text_status = "Proses (Menunggu konfirmasi)";
				} else if ($r_orderan->status == "1") {
					$class_text_status = "badge badge-info";
					$text_status = "Orderan diterima";
				} else if ($r_orderan->status == "2") {
					$class_text_status = "badge badge-info";
					$text_status = "Menjemput customer";
				} else if ($r_orderan->status == "3") {
					$class_text_status = "badge badge-primary";
					$text_status = "Dalam perjalanan menuju bandara";
				} else if ($r_orderan->status == "4") {
					$class_text_status = "badge badge-success";
					$text_status = "Selesai";
				} else if ($r_orderan->status == "5") {
					$class_text_status = "badge badge-danger";
					$text_status = "Orderan dibatalkan oleh customer";
				} else if ($r_orderan->status == "6") {
					$class_text_status = "badge badge-dark";
					$text_status = "Orderan ditolak oleh anda";
				}
				?>
				<div class="card mt-4">
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col-12">
								<h5>
									Orderan Masuk
								</h5>
								<hr>
							</div>

							<?php if ($r_orderan->status >= "1" and $r_orderan->status < "4") : ?>
								<div class="col-lg-12">
									<div id="maps" style="width: 100%; height: 70vh; border-radius: 20px;"></div>

									<div class="card my-3">
										<div class="card-body">
											<div id="text-direction-guide"></div>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<script>
								function initMap() {
									var map;
									var driverLocation;
									var gmarkers = [];
									var marker, i;
									var lineMarkers = [];
									var lingkar = [];
									var circle_user;
									var id_kategori;

									var infoWindow = new google.maps.InfoWindow;
									var bounds = new google.maps.LatLngBounds();

									var directionsDisplay;

									if (navigator.geolocation) {
										var positionOptions = {
											enableHighAccuracy: true,
											timeout: 10 * 1000 // 10 seconds
										};

										navigator.geolocation.getCurrentPosition(function(position) {
											userLat = position.coords.latitude;
											userLng = position.coords.longitude;
											driverLocation = new google.maps.LatLng(userLat, userLng);
											var myStyle = [{
												featureType: "administrative",
												elementType: "labels",
												stylers: [{
													visibility: "on"
												}]
											}, {
												featureType: "poi",
												elementType: "labels",
												stylers: [{
													visibility: "off"
												}]
											}, {
												featureType: "water",
												elementType: "labels",
												stylers: [{
													visibility: "on"
												}]
											}, {
												featureType: "road",
												elementType: "labels",
												stylers: [{
													visibility: "on"
												}]
											}];

											var mapOptions = {
												center: driverLocation,
												zoom: 15,
												mapTypeControlOptions: {
													mapTypeIds: ['mystyle', google.maps.MapTypeId.SATELLITE]
												},
												mapTypeId: 'mystyle',
												location_type: google.maps.GeocoderLocationType.ROOFTOP
											};

											$.ajax({
												type: "POST",
												url: "<?= base_url() ?>/Driver/Dashboard/update_posisi",
												dataType: "JSON",
												data: {
													latitude: userLat,
													longitude: userLng
												},
												success: function(data) {
													console.log('OK');
												}
											});

											map = new google.maps.Map(document.getElementById('maps'), mapOptions);
											map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, {
												name: 'Peta'
											}));

											directionsDisplay = new google.maps.DirectionsRenderer({
												polylineOptions: {
													strokeColor: "blue"
												},
												suppressMarkers: true
											});

											var directionsService = new google.maps.DirectionsService();
											var directionsRenderer = new google.maps.DirectionsRenderer({
												// draggable: true,
												map
											});

											directionsDisplay.setMap(map);
											directionsDisplay.setOptions({
												suppressMarkers: true
											});
											directionsRenderer.setMap(map);

											google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
												if (directionsDisplay.directions === null) {
													return;
												}
											});

											function showRoute() {
												<?php if ($r_orderan->status == "1") : ?>
													let endLocation = new google.maps.LatLng(<?= $pengantaran->latitude . ', ' . $pengantaran->longitude ?>);
												<?php elseif ($r_orderan->status == "2") : ?>
													let endLocation = new google.maps.LatLng(<?= $customer->latitude . ', ' . $customer->longitude ?>);
												<?php elseif ($r_orderan->status == "3") : ?>
													let endLocation = new google.maps.LatLng(<?= $bandara->latitude . ', ' . $bandara->longitude ?>);
												<?php endif; ?>

												var start = driverLocation;
												var end = endLocation;

												var request = {
													origin: start,
													destination: end,
													travelMode: 'DRIVING'
												};
												directionsService.route(request, function(result, status) {
													if (status == 'OK') {
														directionsRenderer.setDirections(result);
													}
												});
											}

											directionsRenderer.setPanel(document.getElementById("text-direction-guide"));
											const control = document.getElementById("floating-panel");
											map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);
											const onChangeHandler = function() {
												calculateAndDisplayRoute(directionsService, directionsRenderer);
											};

											showRoute();

											var trafficLayer = new google.maps.TrafficLayer();
											trafficLayer.setMap(map);

											var posisiBandara = new google.maps.LatLng(<?= $bandara->latitude . ',' . $bandara->longitude ?>);
											var iconMarkerBandara = {
												url: "<?= base_url() ?>/assets/img/airport-marker.png", // url
												scaledSize: new google.maps.Size(40, 40), // scaled size
												origin: new google.maps.Point(0, 0), // origin
												anchor: new google.maps.Point(20, 20) // anchor
											};
											var markerBandara = new google.maps.Marker({
												position: posisiBandara,
												map: map,
												icon: iconMarkerBandara
											});

											google.maps.event.addListener(markerBandara, 'click', (function(markerBandara) {
												return function() {
													infoWindow.setContent(`
														<div style="width: 100%; text-align: center;">
															<h5>
																<?= $bandara->nama_bandara ?>
															</h5>
														</div>
														<br>
														<div class="mb-2">
															<span class="font-weight-bold">
																Alamat
															</span> <br>
															<span>
																<?= $bandara->alamat ?>
															</span>
														</div>
														<div class="mb-2">
															<span class="font-weight-bold">
																Koordinat Lokasi
															</span> <br>
															<span>
																(<?= $bandara->latitude ?>, <?= $bandara->longitude ?>)
															</span>
														</div>
														<br>
														`);
													infoWindow.open(map, markerBandara);
												}
											})(markerBandara));

										}, function() {
											handleLocationError(true, centerLoc, map.getCenter());
										}, positionOptions);

										function tampilTitik() {
											var arrayTitikPengantaran = [
												<?= "
									{
										id_driver: '" . $user_id . "',
										id_bandara: '" . $id_bandara . "',
										id_pengantaran: '" . $id_pengantaran . "',
										nama_bandara: '" . $bandara->nama_bandara . "',
										latitude: '" . $pengantaran->latitude . "',
										longitude: '" . $pengantaran->longitude . "',
										nama_lokasi: '" . $class_dashboard->getAddress($pengantaran->latitude, $pengantaran->longitude) . "',
										radius_jemput: '" . $pengantaran->radius_jemput . "',
										foto_profil_driver: '" . $user_foto . "',
										nopol_driver:'" . $user_nopol . "',
										nama_driver:'" . $user_nama_lengkap . "',
									},
									";
												?>
											];

											for (i = 0; i < arrayTitikPengantaran.length; i++) {
												let id_pengantaran = arrayTitikPengantaran[i].id_pengantaran;

												let id_driver = arrayTitikPengantaran[i].id_driver;
												let nama_driver = arrayTitikPengantaran[i].nama_driver;
												let nopol_driver = arrayTitikPengantaran[i].nopol_driver;
												let foto_profil_driver = arrayTitikPengantaran[i].foto_profil_driver;

												let id_bandara = arrayTitikPengantaran[i].id_bandara;
												let nama_bandara = arrayTitikPengantaran[i].nama_bandara;

												let latitude = arrayTitikPengantaran[i].latitude;
												let longitude = arrayTitikPengantaran[i].longitude;
												let nama_lokasi = arrayTitikPengantaran[i].nama_lokasi;

												let posisiMarker = new google.maps.LatLng(latitude, longitude);
												let radius_jemput = arrayTitikPengantaran[i].radius_jemput;

												let link_foto_profil_driver = "";
												if (foto_profil_driver == "") {
													link_foto_profil_driver = base_url + '/assets/img/noimg.png';
												} else {
													link_foto_profil_driver = base_url + '/assets/img/driver/' + foto_profil_driver;
												}

												var iconTitikPengantaran = {
													url: "<?= base_url() ?>/assets/img/titik-pengantaran.png", // url
													scaledSize: new google.maps.Size(40, 40), // scaled size
													origin: new google.maps.Point(0, 0), // origin
													anchor: new google.maps.Point(20, 20) // anchor
												};
												var marker_pengantaran = new google.maps.Marker({
													position: posisiMarker,
													map: map,
													icon: iconTitikPengantaran
												});

												var circlePengantaran = new google.maps.Circle({
													strokeColor: '#00e064',
													strokeOpacity: 0.5,
													strokeWeight: 2,
													fillColor: '#00e064',
													fillOpacity: 0.1,
													map: map,
													radius: radius_jemput
												});

												circlePengantaran.bindTo('center', marker_pengantaran, 'position');
												circlePengantaran.setRadius(parseFloat(radius_jemput));

												google.maps.event.addListener(marker_pengantaran, 'click', (function(marker_pengantaran, i) {
													return function() {
														var distinationOrigin = driverLocation;
														var destinationMarker = posisiMarker;

														infoWindow.setContent(`
                                    <div style="width: 100%; text-align: center;">
                                        <h4>${nama_driver}</h4>
                                        <p>${nopol_driver}</p>
										<img src="${link_foto_profil_driver}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
									</div>
									<br>
                                    <table class="table-sm table-borderless mt-1">
                                        <tr style="text-align: left;">
                                            <td>Lokasi</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${nama_lokasi}</td>
                                        </tr>
										<tr style="text-align: left;">
                                            <td>Koordinat</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${latitude}, ${longitude}</td>
                                        </tr> 
										<tr style="text-align: left;">
                                            <td>Radius Jemput</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${radius_jemput} meter</td>
                                        </tr>
									`);
														infoWindow.open(map, marker_pengantaran);
													}
												})(marker_pengantaran, i));
												gmarkers.push(marker_pengantaran);
											}

											var arrayCustomer = [
												<?= "
									{
										foto_profil_customer: '" . $customer->foto . "',
										nama_customer:'" . $customer->nama_lengkap . "',
										email_customer:'" . $customer->email . "',
										no_hp_customer:'" . $customer->no_hp . "',
										latitude_customer:'" . $customer->latitude . "',
										longitude_customer:'" . $customer->longitude . "',
									},
									";
												?>
											];

											for (i = 0; i < arrayCustomer.length; i++) {
												let nama_customer = arrayCustomer[i].nama_customer;
												let email_customer = arrayCustomer[i].email_customer;
												let no_hp_customer = arrayCustomer[i].no_hp_customer;
												let latitude_customer = arrayCustomer[i].latitude_customer;
												let longitude_customer = arrayCustomer[i].longitude_customer;
												let foto_profil_customer = arrayCustomer[i].foto_profil_customer;

												let posisiCustomer = new google.maps.LatLng(latitude_customer, longitude_customer);

												let link_foto_profil_customer = "";
												if (foto_profil_customer == "") {
													link_foto_profil_customer = base_url + '/assets/img/noimg.png';
												} else {
													link_foto_profil_customer = base_url + '/assets/img/customer/' + foto_profil_customer;
												}

												var iconCustomer = {
													url: "<?= base_url() ?>/assets/img/user-loc-marker.png", // url
													scaledSize: new google.maps.Size(40, 40), // scaled size
													origin: new google.maps.Point(0, 0), // origin
													anchor: new google.maps.Point(20, 20) // anchor
												};

												var markerCustomer = new google.maps.Marker({
													position: posisiCustomer,
													map: map,
													icon: iconCustomer
												});

												google.maps.event.addListener(markerCustomer, 'click', (function(markerCustomer, i) {
													return function() {
														infoWindow.setContent(`
											<div style="width: 100%; text-align: center;">
												<img src="${link_foto_profil_customer}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
											</div>
											<br>
											<table class="table-sm table-borderless mt-1">
												<tr style="text-align: left;">
													<td>Nama Customer</td>
													<td>:</td>
													<td style="width: 70%;">${nama_customer}</td>
												</tr>
												<tr style="text-align: left;">
													<td>Email</td>
													<td>:</td>
													<td style="width: 70%;">${email_customer}</td>
												</tr>
												<tr style="text-align: left;">
													<td>No. Handphone</td>
													<td>:</td>
													<td style="width: 70%;">${no_hp_customer}</td>
												</tr>
											</table>
											`);
														infoWindow.open(map, markerCustomer);
													}
												})(markerCustomer, i));
												gmarkers.push(markerCustomer);
											}
										}

										function calculateAndDisplayRoute(directionsService, directionsDisplay, distinationOrigin, destinationMarker, infoWindow, id_pengantaran) {
											directionsService.route({
												origin: distinationOrigin,
												destination: destinationMarker,
												travelMode: google.maps.TravelMode.DRIVING
											}, function(response, status) {
												if (status === google.maps.DirectionsStatus.OK) {
													directionsDisplay.setDirections(response);
													computeTotals(response, infoWindow, id_pengantaran);
												} else {
													window.alert('Directions request failed due to ' + status);
												}
											});
										}

									} else {
										handleLocationError(false, infoWindow, map.getCenter());
									}
								}

								function handleLocationError(browserHasGeolocation, infoWindow, pos) {
									infoWindow.setPosition(pos);
									infoWindow.setContent(browserHasGeolocation ?
										'Error: The Geolocation service failed.' :
										'Error: Your browser doesn\'t support geolocation.');
									infoWindow.open(map);
								}

								google.maps.event.addDomListener(window, 'load', initMap);
							</script>

							<div class="col-lg-8 mb-3">
								<div class="card">
									<div class="card-body">
										<h5>Orderan</h5>
										<hr>
										<div class="mt-3">
											<span class="d-block">
												Status
											</span>
											<span class="font-weight-bold <?= $class_text_status; ?>">
												<?= $text_status; ?>
											</span>
										</div>
										<div class="mt-3">
											<span class="d-block">
												Lokasi
											</span>
											<span class="d-block font-weight-bold">
												<?= $class_dashboard->getAddress($r_orderan->latitude, $r_orderan->longitude); ?>
											</span>
										</div>
										<div class="mt-3">
											<span class="d-block">
												Bandara Tujuan
											</span>
											<span class="d-block font-weight-bold">
												<?= $bandara->nama_bandara; ?>
												<br>
												<small>
													<?= $bandara->alamat; ?>
												</small>
											</span>
										</div>
										<div class="mt-3">
											<span class="d-block">
												Jarak ke bandara
											</span>
											<span class="d-block font-weight-bold">
												<?= $r_orderan->jarak_customer_to_bandara; ?> Km
											</span>
										</div>
										<div class="mt-3">
											<span class="d-block">
												Tarif
												<span style="font-size: 30px; font-weight: bold;">
													<?= rupiah($r_orderan->biaya, "Y"); ?>
												</span>
											</span>
											<span class="d-block font-weight-bold">
												<small>
													<?= rupiah($r_orderan->tarif_perkm, "Y"); ?> / Km
												</small>
											</span>
										</div>

										<div class="mt-3 d-flex justify-content-between">

											<?php if ($r_orderan->status == "0") : ?>

												<button onclick="driver_update_status_order(<?= $r_orderan->id_order ?>, '1', <?= $id_driver ?>,  <?= $id_customer ?>)" class="btn btn-block btn-outline-success mt-2" title="Terima Orderan" style="width: 50%;">
													<i class="fa fa-check"></i> Terima
												</button>

												<button onclick="driver_update_status_order(<?= $r_orderan->id_order ?>, '6', <?= $id_driver ?>,  <?= $id_customer ?>)" class="btn btn-block btn-outline-danger" title="Tolak Orderan" style="width: 50%;">
													<i class="fa fa-times"></i> Tolak
												</button>

											<?php elseif ($r_orderan->status == "1") : ?>

												<button onclick="driver_update_status_order(<?= $r_orderan->id_order ?>, '2', <?= $id_driver ?>,  <?= $id_customer ?>)" class="btn btn-block btn-outline-info" title="Jemput Customer" style="width: 100%;">
													<i class="fa fa-taxi"></i> Jemput Customer
												</button>

											<?php elseif ($r_orderan->status == "2") : ?>

												<button onclick="driver_update_status_order(<?= $r_orderan->id_order ?>, '3', <?= $id_driver ?>,  <?= $id_customer ?>)" class="btn btn-block btn-outline-primary" title="Menuju Bandara" style="width: 100%;">
													<i class="fa fa-car"></i> Menuju Bandara
												</button>

											<?php elseif ($r_orderan->status == "3") : ?>

												<button onclick="driver_update_status_order(<?= $r_orderan->id_order ?>, '4', <?= $id_driver ?>,  <?= $id_customer ?>)" class="btn btn-block btn-outline-success" title="Tandai Selesai" style="width: 100%;">
													<i class="fa fa-check"></i> Selesai
												</button>

											<?php endif; ?>

										</div>

									</div>
								</div>
							</div>

							<div class="col-lg-4 mb-3">
								<div class="card">
									<div class="card-body">
										<h5>Customer</h5>
										<hr>
										<div class="text-center">
											<?php
											$foto_customer = "";
											if ($customer->foto != "") {
												if (strpos($customer->foto, ':') !== false) {
													$foto_customer = $customer->foto;
												} else {
													$foto_customer = base_url() . '/assets/img/customer/' . $customer->foto;
												}
											} else {
												$foto_customer = base_url() . '/assets/img/noimg.png';
											}
											?>
											<img src="<?= $foto_customer ?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: solid 2px #fff; padding: 2px; object-position: top;">
										</div>

										<div class="mt-3">
											<span class="d-block">
												Nama Lengkap
											</span>
											<span class="d-block font-weight-bold">
												<?= $customer->nama_lengkap; ?>
											</span>
										</div>

										<div class="mt-3">
											<span class="d-block">
												Email
											</span>
											<span class="d-block font-weight-bold">
												<a href="mailto:<?= $customer->email; ?>">
													<?= $customer->email; ?>
												</a>
											</span>
										</div>

										<div class="mt-3">
											<span class="d-block">
												No. Handphone
											</span>
											<span class="d-block font-weight-bold">
												<a href="tel:<?= $customer->no_hp; ?>">
													<?= $customer->no_hp; ?>
												</a>
											</span>
										</div>

										<a href="tel:<?= $customer->no_hp; ?>" target="_blank" class="mt-3 btn btn-block btn-primary">
											<i class="fa fa-phone mr-2"></i> Hubungi Customer
										</a>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<div class="row justify-content-center">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="alert alert-info">
								<div class="row justify-content-center align-items-center" style="min-height: 50vh;">
									<h5 class="text-center">
										Anda belum memiliki orderan masuk !
									</h5>

									<div class="row justify-content-center">

										<div class="col-lg-3 mb-3 mb-lg-0 text-center">
											<a href="<?= base_url(); ?>/driver" class="btn btn-outline-dark">
												<i class="fa fa-arrow-left"></i> Beranda
											</a>
										</div>

										<div class="col-lg-3 text-center">
											<a href="<?= base_url(); ?>/driver/pengantaran/create" class="btn btn-outline-success">
												<i class="fa fa-car"></i> Tambah Pengantaran
											</a>
										</div>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?= $this->endSection('content'); ?>