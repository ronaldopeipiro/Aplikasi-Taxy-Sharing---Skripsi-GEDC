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

$orderan_belum_selesai = ($db->query("SELECT * FROM tb_order WHERE id_customer='$user_id' AND status <= 4 LIMIT 1 "))->getRow();
$cek_orderan_belum_selesai = ($db->query("SELECT * FROM tb_order WHERE id_customer='$user_id' AND status <= 4 LIMIT 1 "))->getNumRows();
?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<?php if ($cek_orderan_belum_selesai > 0) : ?>
			<?php
			$id_pengantaran = $orderan_belum_selesai->id_pengantaran;
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

			if ($orderan_belum_selesai->status == "0") {
				$class_text_status = "badge badge-warning";
				$text_status = "Proses (Menunggu driver untuk konfirmasi orderan anda)";
			} else if ($orderan_belum_selesai->status == "1") {
				$class_text_status = "badge badge-info";
				$text_status = "Orderan diterima oleh driver";
			} else if ($orderan_belum_selesai->status == "2") {
				$class_text_status = "badge badge-info";
				$text_status = "Driver menuju lokasi anda";
			} else if ($orderan_belum_selesai->status == "3") {
				$class_text_status = "badge badge-primary";
				$text_status = "Dalam perjalanan menuju bandara";
			} else if ($orderan_belum_selesai->status == "4") {
				$class_text_status = "badge badge-success";
				$text_status = "Selesai";
			} else if ($orderan_belum_selesai->status == "5") {
				$class_text_status = "badge badge-danger";
				$text_status = "Orderan dibatalkan oleh customer";
			} else if ($orderan_belum_selesai->status == "6") {
				$class_text_status = "badge badge-dark";
				$text_status = "Orderan ditolak oleh driver";
			}
			?>

			<div class="row">
				<div class="col-lg-12">
					<div class="d-flex align-items-center justify-content-between">
						<h4 class="mt-2">
							Orderan Saya
						</h4>
					</div>
					<hr>
				</div>

				<div class="col-12">
					<div class="row">
						<div class="col-lg-12">
							<p>
								Lokasi saya : <?= $class_dashboard->getAddress($user_latitude, $user_longitude); ?>
							</p>
						</div>
					</div>

					<div class="row">

						<?php if ($orderan_belum_selesai->status < 4) : ?>
							<div class="col-lg-12 mb-3">
								<div class="card">
									<div class="card-body">
										<div id="maps" style="border-radius: 10px; height: 77vh; width: 100%;"></div>
									</div>
								</div>
							</div>
						<?php endif; ?>

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
												<?= $class_dashboard->getAddress($orderan_belum_selesai->latitude, $orderan_belum_selesai->longitude); ?>
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
												<?= $orderan_belum_selesai->jarak_customer_to_bandara; ?> Km
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
													<?= rupiah($orderan_belum_selesai->biaya, "Y"); ?>
												</span>
												<br>
												<small class="text-warning font-italic">
													(Pembayaran dapat dilakukan secara cash kepada driver kami saat anda sampai di bandara tujuan)
												</small>
											</td>
										</tr>
										<tr>
											<td>Anda akan dijemput</td>
											<td>:</td>
											<td>
												<?= $estimasi_penjemputan; ?> menit lagi
											</td>
										</tr>
									</table>

									<?php if ($orderan_belum_selesai->status == "0") : ?>
										<button onclick="customer_update_status_order(<?= $orderan_belum_selesai->id_order ?>, '5', <?= $id_driver ?>,  <?= $user_id ?>)" class="btn btn-block btn-outline-danger" title="Batalkan Orderan" style="width: 50%;">
											<i class="fa fa-times"></i> Batalkan
										</button>
									<?php endif; ?>

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

									<a href="tel:<?= $driver->no_hp; ?>" class="btn btn-block btn-primary">
										<i class="fa fa-phone mr-2"></i> Hubungi Driver
									</a>
								</div>
							</div>

						</div>

					</div>

				</div>
			</div>

			<?php if ($orderan_belum_selesai->status < 4) : ?>
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

								$.ajax({
									type: "POST",
									url: "<?= base_url() ?>/Customer/Dashboard/update_posisi",
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
										strokeColor: "red"
									},
									suppressMarkers: true
								});

								// directionsDisplay.setMap(map);
								google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
									if (directionsDisplay.directions === null) {
										return;
									}
								});

								var trafficLayer = new google.maps.TrafficLayer();
								trafficLayer.setMap(map);

								var icon_user = {
									url: "<?= base_url() ?>/assets/img/user-loc-marker.png", // url
									scaledSize: new google.maps.Size(40, 40), // scaled size
									origin: new google.maps.Point(0, 0), // origin
									anchor: new google.maps.Point(20, 20), // anchor
									animation: google.maps.Animation.DROP
								};

								var centerLoc = new google.maps.Marker({
									position: userLoc,
									map: map,
									title: 'Lokasi Saya !',
									icon: icon_user,
									animation: google.maps.Animation.DROP
								});

								tampilTitik();
							}, function() {
								handleLocationError(true, centerLoc, map.getCenter());
							}, positionOptions);

							function tampilTitik() {
								var arrayTitikPengantaran = [
									<?= "
									{
										id_driver: '" . $id_driver . "',
										id_bandara: '" . $id_bandara . "',
										id_pengantaran: '" . $id_pengantaran . "',
										nama_bandara: '" . $bandara->nama_bandara . "',
										latitude: '" . $pengantaran->latitude . "',
										longitude: '" . $pengantaran->longitude . "',
										nama_lokasi: '" . $class_dashboard->getAddress($pengantaran->latitude, $pengantaran->longitude) . "',
										radius_jemput: '" . $pengantaran->radius_jemput . "',
										jarak_user_to_titik: '" . $jarak_user_to_titik["distance"] . "',
										waktu_tempuh_user_to_titik: '" . $jarak_user_to_titik["duration"] . "',
										jarak_titik_to_bandara: '" . $jarak_titik_to_bandara["distance"] . "',
										waktu_tempuh_titik_to_bandara: '" . $jarak_titik_to_bandara["duration"] . "',
										jarak_user_to_bandara: '" . $data_jarak_user_to_bandara[0] . "',
										waktu_tempuh_user_to_bandara: '" . $data_waktu_tempuh_user_to_bandara[0] . "',
										estimasi_penjemputan: '" . $estimasi_penjemputan . "',
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
									let jarak_user_to_titik = arrayTitikPengantaran[i].jarak_user_to_titik;
									let jarak_titik_to_bandara = arrayTitikPengantaran[i].jarak_titik_to_bandara;
									let jarak_user_to_bandara = arrayTitikPengantaran[i].jarak_user_to_bandara;
									let waktu_tempuh_user_to_bandara = arrayTitikPengantaran[i].waktu_tempuh_user_to_bandara;
									let estimasi_penjemputan = arrayTitikPengantaran[i].estimasi_penjemputan;
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
                                            <td>Anda akan sampai di bandara tujuan dalam</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${waktu_tempuh_user_to_bandara} menit</td>
                                        </tr>
										<tr style="text-align: left;">
                                            <td>Anda akan dijemput dalam</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${estimasi_penjemputan} menit</td>
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
										id_driver: '" . $id_driver . "',
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
									let id_driver = arrayDriver[i].id_driver;
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
			<?php endif; ?>

		<?php else : ?>

			<div class="row">
				<div class="col-lg-12">
					<div class="d-flex align-items-center justify-content-between">
						<h4 class="mt-2">
							Order TAXI menuju Bandara
						</h4>
					</div>
					<hr>
				</div>

				<div class="col-12">
					<div class="row">
						<div class="col-lg-12">
							<p>
								<span class="font-weight-bold">
									Lokasi saya : <?= $class_dashboard->getAddress($user_latitude, $user_longitude); ?> <br>
								</span>
								<span class="text-success font-italic">
									Silahkan pilih lokasi pengantaran penumpang yang terdekat dengan lokasi anda saat ini agar anda dijemput lebih awal
								</span>
							</p>
						</div>
					</div>

					<div class="row justify-content-start align-content-center">
						<?php
						$no = 0;
						?>
						<?php foreach ($pengantaran as $data) : ?>
							<?php
							$id_pengantaran = $data["id_pengantaran"];
							$ceK_orderan_proses = $db->query("SELECT * FROM tb_order WHERE id_pengantaran='$id_pengantaran' AND status < '5' ")->getNumRows();
							if ($ceK_orderan_proses == 0) {

								$id_driver = $data["id_driver"];
								$id_bandara = $data["id_bandara"];

								$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver' "))->getRow();
								$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara' "))->getRow();

								$nama_lokasi = $class_dashboard->getAddress($data['latitude'], $data['longitude']);
								$jarak_user_to_titik = $class_dashboard->distance_matrix_google($user_latitude, $user_longitude, $data['latitude'], $data['longitude']);
								$jarak_driver_to_titik = $class_dashboard->distance_matrix_google($driver->latitude, $driver->longitude, $data['latitude'], $data['longitude']);
								$jarak_titik_to_bandara = $class_dashboard->distance_matrix_google($data['latitude'], $data['longitude'], $bandara->latitude, $bandara->longitude);
								$jarak_user_to_bandara = $class_dashboard->distance_matrix_google($user_latitude, $user_longitude, $bandara->latitude, $bandara->longitude);

								$data_jarak_user_to_titik = explode(' ', $jarak_user_to_titik['distance']);
								$user_to_titik_jarak = $data_jarak_user_to_titik[0];

								$data_jarak_user_to_bandara = explode(' ', $jarak_user_to_bandara['distance']);
								$user_to_bandara_jarak = $data_jarak_user_to_bandara[0];
								$biaya_perjalanan = ($data_tarif['tarif_perkm'] * $user_to_bandara_jarak);

								$data_waktu_tempuh_user_to_titik = explode(' ', $jarak_user_to_titik['duration']);
								$data_waktu_tempuh_driver_to_titik = explode(' ', $jarak_driver_to_titik['duration']);
								$data_waktu_tempuh_user_to_bandara = explode(' ', $jarak_user_to_bandara['duration']);
								$estimasi_penjemputan = $data_waktu_tempuh_driver_to_titik[0] + $data_waktu_tempuh_user_to_titik[0];
							?>

								<?php if (($user_to_titik_jarak * 1000) <= $data['radius_jemput']) : ?>

									<div class="col-lg-4 h-100 mt-3">
										<div class="card p-0">

											<div class="card-header pt-2 pb-0 d-flex justify-content-center align-items-center">
												<div class="text-center">
													<h5>
														<?= $driver->nama_lengkap; ?>
													</h5>
													<p>
														<?= $driver->nopol; ?>
													</p>
												</div>
											</div>

											<div class="card-body p-1">
												<div class="text-center">
													<img src="<?= (empty($driver->foto)) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/driver/' . $driver->foto; ?>" style="width: 150px; height: 150px; object-fit: cover; object-position: center; border-radius: 10px;" alt="">
												</div>
												<table class="table-sm table-responsive table-borderless" style="font-size: 12px;">
													<tr>
														<td colspan="3">
															<span class="font-weight-bold">
																Driver akan menjemput anda dalam <br>
															</span>
															<?= $estimasi_penjemputan; ?> menit
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<span class="font-weight-bold">
																Lokasi Pengantaran <br>
															</span>
															<?= $nama_lokasi; ?>
														</td>
													</tr>
													<tr>
														<td colspan="3">
															<span class="font-weight-bold">
																Bandara Tujuan <br>
															</span>
															<?= $bandara->nama_bandara; ?>
														</td>
													</tr>
													<tr>
														<td>Jarak anda ke bandara</td>
														<td>:</td>
														<td><?= $jarak_user_to_bandara['distance']; ?></td>
													</tr>
													<tr>
														<td>Biaya Perjalanan</td>
														<td>:</td>
														<td><?= rupiah($biaya_perjalanan, "Y"); ?></td>
													</tr>
												</table>
											</div>

											<div class="card-footer">
												<div class="d-flex">
													<button onclick="submit_order(<?= $id_driver ?>, <?= $user_id ?>, <?= $id_pengantaran ?>, <?= $user_latitude ?>, <?= $user_longitude ?>, <?= $data_tarif['tarif_perkm'] ?>, <?= $user_to_bandara_jarak ?>, <?= $biaya_perjalanan ?>)" class="btn btn-block btn-outline-success" title="Order Taxi">
														<i class="fa fa-taxi"></i> ORDER TAXI
													</button>
												</div>
											</div>
										</div>
									</div>
									<?php $no += 1; ?>
								<?php endif; ?>
							<?php } ?>
						<?php endforeach; ?>

						<?php if ($no == 0) : ?>

							<div class="col-lg-12">;
								<div class="card">
									<div class="card-body text-center py-6">
										Belum ada driver tersedia yang melakukan pengantaran penumpang disekitar anda !
										<br>
										<br>
										<a class="btn btn-info text-white" onclick="window.location.reload();">
											<i class="fas fa-sync-alt"></i> Muat Ulang
										</a>
									</div>
								</div>
							</div>

						<?php endif; ?>

					</div>

				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<script>
	function submit_order(id_driver, id_customer, id_pengantaran, latitude, longitude, tarif_perkm, jarak_customer_to_bandara, biaya) {

		event.preventDefault();
		Swal.fire({
			title: 'Order TAXI',
			text: "Pilih ya, jika anda ingin order TAXI ini !",
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
					url: "<?= base_url() ?>/customer/order/submit-order",
					dataType: "JSON",
					data: {
						id_customer: id_customer,
						id_pengantaran: id_pengantaran,
						latitude: latitude,
						longitude: longitude,
						tarif_perkm: tarif_perkm,
						jarak_customer_to_bandara: jarak_customer_to_bandara,
						biaya: biaya
					},
					beforeSend: function() {
						$("#loader").show();
					},
					success: function(data) {
						if (data.success == "1") {
							Swal.fire(
								'Berhasil !',
								data.pesan,
								'success'
							);
							send_notif(id_driver, 'driver', 'Anda memiliki orderan baru, silahkan buka aplikasi untuk melihat orderan !');
							send_notif(id_customer, 'customer', 'Orderan berhasil dibuat !');
						} else if (data.success == "0") {
							Swal.fire(
								'Gagal !',
								data.pesan,
								'error'
							);
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

<script>
	$(document).ready(function() {
		var datetime = new Date();
		var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

		var tabel_user = $('#data-table-custom').DataTable({
			"paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			"initComplete": function() {
				var status = this.api().column(4);
				var statusSelect = $('<select class="filter form-control"><option value="">Semua</option></select>')
					.appendTo('#statusSelect')
					.on('change', function() {
						var val = $(this).val();
						status.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				statusSelect.append(`
					<option value="Dalam Perjalanan">Dalam Perjalanan</option>
					<option value="Selesai">Selesai</option>
					<option value="Tidak Selesai">Tidak Selesai</option>
					`);
			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
		});
	});
</script>


<?= $this->endSection('content'); ?>