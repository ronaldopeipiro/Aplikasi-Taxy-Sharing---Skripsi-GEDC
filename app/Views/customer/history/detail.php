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

$class_dashboard = new App\Controllers\Customer\Dashboard;

$orderan = ($db->query("SELECT * FROM tb_order WHERE kode_order = '$kode_order' LIMIT 1 "))->getRow();
$id_pengantaran = $orderan->id_pengantaran;

$pengantaran = ($db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' LIMIT 1"))->getRow();

$id_bandara = $pengantaran->id_bandara;
$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'"))->getRow();

$id_driver = $pengantaran->id_driver;
$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver'"))->getRow();

$nama_lokasi = $class_dashboard->getAddress($pengantaran->latitude, $pengantaran->longitude);
$jarak_user_to_titik = $class_dashboard->distance_matrix_google($user_latitude, $user_longitude, $pengantaran->latitude, $pengantaran->longitude);
$jarak_driver_to_titik = $class_dashboard->distance_matrix_google($driver->latitude, $driver->longitude, $pengantaran->latitude, $pengantaran->longitude);
$jarak_titik_to_bandara = $class_dashboard->distance_matrix_google($pengantaran->latitude, $pengantaran->longitude, $bandara->latitude, $bandara->longitude);
$jarak_user_to_bandara = $class_dashboard->distance_matrix_google($user_latitude, $user_longitude, $bandara->latitude, $bandara->longitude);

$data_jarak_user_to_bandara = explode(' ', $jarak_user_to_bandara['distance']);
$user_to_bandara_jarak = $data_jarak_user_to_bandara[0];
$biaya_perjalanan = ($data_tarif['tarif_perkm'] * $user_to_bandara_jarak);

$data_waktu_tempuh_user_to_titik = explode(' ', $jarak_user_to_titik['duration']);
$data_waktu_tempuh_driver_to_titik = explode(' ', $jarak_driver_to_titik['duration']);
$data_waktu_tempuh_user_to_bandara = explode(' ', $jarak_user_to_bandara['duration']);
$estimasi_penjemputan = $data_waktu_tempuh_driver_to_titik[0] + $data_waktu_tempuh_user_to_titik[0];

if ($orderan->status == "0") {
	$class_text_status = "badge badge-warning";
	$text_status = "Proses (Menunggu driver untuk konfirmasi orderan anda)";
} else if ($orderan->status == "1") {
	$class_text_status = "badge badge-info";
	$text_status = "Orderan diterima oleh driver";
} else if ($orderan->status == "2") {
	$class_text_status = "badge badge-info";
	$text_status = "Driver menuju lokasi anda";
} else if ($orderan->status == "3") {
	$class_text_status = "badge badge-primary";
	$text_status = "Dalam perjalanan menuju bandara";
} else if ($orderan->status == "4") {
	$class_text_status = "badge badge-success";
	$text_status = "Selesai";
} else if ($orderan->status == "5") {
	$class_text_status = "badge badge-danger";
	$text_status = "Orderan dibatalkan oleh customer";
} else if ($orderan->status == "6") {
	$class_text_status = "badge badge-dark";
	$text_status = "Orderan ditolak oleh driver";
}
?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/customer/history" class="btn btn-dark">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-3">
						Orderan Saya
					</h4>
				</div>
				<hr>
			</div>

			<div class="col-12">
				<div class="row">

					<div class="col-lg-12 mb-3">
						<div class="card">
							<div class="card-body">
								<div id="maps" style="border-radius: 10px; height: 77vh; width: 100%;"></div>
							</div>
						</div>
					</div>

					<div class="col-lg-8 mb-3 mb-lg-0">
						<div class="card">
							<div class="card-body">
								<h5>
									Detail Order
								</h5>
								<table class="table table-sm table-borderless table-responsive" style="font-size: 14px;">
									<tr>
										<td>Status</td>
										<td>:</td>
										<td>
											<span class="<?= $class_text_status; ?>">
												<?= $text_status; ?>
											</span>
										</td>
									</tr>
									<tr>
										<td>Lokasi jemput</td>
										<td>:</td>
										<td>
											<?= $class_dashboard->getAddress($orderan->latitude, $orderan->longitude); ?>
										</td>
									</tr>
									<tr>
										<td>Bandara tujuan</td>
										<td>:</td>
										<td>
											<span class="font-weight-bold">
												<?= $bandara->nama_bandara; ?>
											</span>
											<br>
											<span class="font-italic">
												<?= $bandara->alamat; ?>
											</span>
										</td>
									</tr>
									<tr>
										<td>Jarak ke bandara</td>
										<td>:</td>
										<td>
											<?= $orderan->jarak_customer_to_bandara; ?> Km
										</td>
									</tr>
									<tr>
										<td>Estimasi waktu menuju bandara</td>
										<td>:</td>
										<td>
											<?= $data_waktu_tempuh_user_to_bandara[0]; ?> menit
										</td>
									</tr>
									<tr>
										<td>Biaya</td>
										<td>:</td>
										<td>
											<span class="font-weight-bold" style="font-size: 30px;">
												<?= rupiah($orderan->biaya, "Y"); ?>
											</span>
										</td>
									</tr>
								</table>

							</div>
						</div>

					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body">
								<h5>
									Driver
								</h5>
								<div class="text-center">
									<img src="<?= (empty($driver->foto)) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/driver/' . $driver->foto; ?>" style="width: 180px; height: 180px; border-radius: 50%; padding: 5px; border: solid 2px #eee; object-fit: cover; object-position: top;">
								</div>
								<table class="table table-sm table-borderless table-responsive mt-3" style="font-size: 14px;">
									<tr>
										<td>Nama Driver</td>
										<td>:</td>
										<td>
											<?= $driver->nama_lengkap; ?>
										</td>
									</tr>
									<tr>
										<td>No. Plat</td>
										<td>:</td>
										<td>
											<?= $driver->nopol; ?>
										</td>
									</tr>
									<tr>
										<td>No. Anggota</td>
										<td>:</td>
										<td>
											<?= $driver->no_anggota; ?>
										</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>:</td>
										<td>
											<a href="mailto:<?= $driver->email; ?>">
												<?= $driver->email; ?>
											</a>
										</td>
									</tr>
									<tr>
										<td>No. Handphone</td>
										<td>:</td>
										<td>
											<a href="tel:<?= $driver->no_hp; ?>">
												<?= $driver->no_hp; ?>
											</a>
										</td>
									</tr>
								</table>
							</div>
						</div>

					</div>

				</div>

			</div>
		</div>

		<script>
			function initMap() {
				var map;
				var userLoc;
				var gmarkers = [];
				var marker, i;
				var lineMarkers = [];
				var lingkar = [];
				var circle_user;
				var id_kategori;

				var infoWindow = new google.maps.InfoWindow;
				var bounds = new google.maps.LatLngBounds();
				var directionsService = new google.maps.DirectionsService;
				var directionsDisplay;

				if (navigator.geolocation) {
					var positionOptions = {
						enableHighAccuracy: true,
						timeout: 10 * 1000 // 10 seconds
					};

					navigator.geolocation.getCurrentPosition(function(position) {
						userLat = position.coords.latitude;
						userLng = position.coords.longitude;
						userLoc = new google.maps.LatLng(userLat, userLng);
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
							center: userLoc,
							zoom: 15,
							mapTypeControlOptions: {
								mapTypeIds: ['mystyle', google.maps.MapTypeId.SATELLITE]
							},
							mapTypeId: 'mystyle',
							location_type: google.maps.GeocoderLocationType.ROOFTOP
						};

						map = new google.maps.Map(document.getElementById('maps'), mapOptions);
						map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, {
							name: 'Peta'
						}));
						directionsDisplay = new google.maps.DirectionsRenderer({
							polylineOptions: {
								strokeColor: "red"
							},
							suppressMarkers: true
						});

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

						tampilTitik();
					}, function() {
						handleLocationError(true, centerLoc, map.getCenter());
					}, positionOptions);

					function tampilTitik() {
						var arrayTitikPengantaran = [
							<?= "
									{
										nama_bandara: '" . $bandara->nama_bandara . "',
										latitude: '" . $pengantaran->latitude . "',
										longitude: '" . $pengantaran->longitude . "',
										nama_lokasi: '" . $nama_lokasi . "',
										radius_jemput: '" . $pengantaran->radius_jemput . "',
										jarak_user_to_titik: '" . $jarak_user_to_titik["distance"] . "',
										jarak_titik_to_bandara: '" . $jarak_titik_to_bandara["distance"] . "',
										jarak_user_to_bandara: '" . $data_jarak_user_to_bandara[0] . "',
										biaya_perjalanan: '" . $biaya_perjalanan . "',
										biaya_perjalanan_string: '" . rupiah($biaya_perjalanan, 'Y') . "',
										foto_profil_driver: '" . $driver->foto . "',
										nopol_driver:'" . $driver->nopol . "',
										nama_driver:'" . $driver->nama_lengkap . "',
									},
									";
							?>
						];

						for (i = 0; i < arrayTitikPengantaran.length; i++) {
							let nama_driver = arrayTitikPengantaran[i].nama_driver;
							let nopol_driver = arrayTitikPengantaran[i].nopol_driver;
							let foto_profil_driver = arrayTitikPengantaran[i].foto_profil_driver;

							let nama_bandara = arrayTitikPengantaran[i].nama_bandara;

							let latitude = arrayTitikPengantaran[i].latitude;
							let longitude = arrayTitikPengantaran[i].longitude;
							let nama_lokasi = arrayTitikPengantaran[i].nama_lokasi;

							let posisiMarker = new google.maps.LatLng(latitude, longitude);
							let radius_jemput = arrayTitikPengantaran[i].radius_jemput;
							let jarak_user_to_titik = arrayTitikPengantaran[i].jarak_user_to_titik;
							let jarak_titik_to_bandara = arrayTitikPengantaran[i].jarak_titik_to_bandara;
							let jarak_user_to_bandara = arrayTitikPengantaran[i].jarak_user_to_bandara;
							let biaya_perjalanan = arrayTitikPengantaran[i].biaya_perjalanan;
							let biaya_perjalanan_string = arrayTitikPengantaran[i].biaya_perjalanan_string;

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
									var distinationOrigin = userLoc;
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
                                            <td>Jarak anda ke Bandara</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${jarak_user_to_bandara} Km</td>
                                        </tr>
										<tr style="text-align: left;">
                                            <td>Biaya Perjalanan</td>
                                            <td>:</td>
                                            <td style="width: 70%; font-weight: 900;">${biaya_perjalanan_string}</td>
                                        </tr>
										<tr style="text-align: left;">
                                            <td>Bandara Keberangkatan/Tujuan</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${nama_bandara}</td>
                                        </tr>
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


						var arrayDriver = [
							<?= "
									{
										foto_profil_driver: '" . $driver->foto . "',
										nama_driver:'" . $driver->nama_lengkap . "',
										nopol_driver:'" . $driver->nopol . "',
										no_anggota_driver:'" . $driver->no_anggota . "',
										latitude_driver:'" . $driver->latitude . "',
										longitude_driver:'" . $driver->longitude . "',
									},
									";
							?>
						];

						for (i = 0; i < arrayDriver.length; i++) {
							let nama_driver = arrayDriver[i].nama_driver;
							let nopol_driver = arrayDriver[i].nopol_driver;
							let no_anggota_driver = arrayDriver[i].no_anggota_driver;
							let latitude_driver = arrayDriver[i].latitude_driver;
							let longitude_driver = arrayDriver[i].longitude_driver;
							let foto_profil_driver = arrayDriver[i].foto_profil_driver;

							let posisiDriver = new google.maps.LatLng(latitude_driver, longitude_driver);

							let link_foto_profil_driver = "";
							if (foto_profil_driver == "") {
								link_foto_profil_driver = base_url + '/assets/img/noimg.png';
							} else {
								link_foto_profil_driver = base_url + '/assets/img/driver/' + foto_profil_driver;
							}

							var iconDriver = {
								url: "<?= base_url() ?>/assets/img/taxi-top-right.png", // url
								scaledSize: new google.maps.Size(40, 40), // scaled size
								origin: new google.maps.Point(0, 0), // origin
								anchor: new google.maps.Point(20, 20) // anchor
							};

							var markerDriver = new google.maps.Marker({
								position: posisiDriver,
								map: map,
								icon: iconDriver
							});

							google.maps.event.addListener(markerDriver, 'click', (function(markerDriver, i) {
								return function() {
									infoWindow.setContent(`
											<div style="width: 100%; text-align: center;">
												<img src="${link_foto_profil_driver}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
											</div>
											<br>
											<table class="table-sm table-borderless mt-1">
												<tr style="text-align: left;">
													<td>Nama Driver</td>
													<td>:</td>
													<td style="width: 70%;">${nama_driver}</td>
												</tr>
												<tr style="text-align: left;">
													<td>No. Polisi</td>
													<td>:</td>
													<td style="width: 70%;">${nopol_driver}</td>
												</tr>
												<tr style="text-align: left;">
													<td>No. Anggota</td>
													<td>:</td>
													<td style="width: 70%;">${no_anggota_driver}</td>
												</tr>
											`);
									infoWindow.open(map, markerDriver);
								}
							})(markerDriver, i));
							gmarkers.push(markerDriver);
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

	</div>
</section>

<?= $this->endSection('content'); ?>