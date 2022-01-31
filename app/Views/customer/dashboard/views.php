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

$class_dashboard = new App\Controllers\Driver\Dashboard;

$orderan_belum_selesai = ($db->query("SELECT * FROM tb_order WHERE id_customer='$user_id' AND (status < 4) LIMIT 1 "))->getRow();
$cek_orderan_belum_selesai = ($db->query("SELECT * FROM tb_order WHERE id_customer='$user_id' AND (status < 4) LIMIT 1 "))->getNumRows();
?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card rounded-3">
					<div class="card-body">

						<div class="row align-items-center pt-3 pt-lg-0">
							<div class="col-lg-3 text-sm-start text-center">
								<img src="<?= (empty($user_foto)) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/customer/' . $user_foto; ?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: solid 2px #fff; padding: 2px; object-position: top;">
							</div>

							<div class="col-lg-8 text-sm-start text-center">
								<h4 style="color: brown;">
									<?= $user_nama_lengkap; ?>
								</h4>
								<p style="color: darkslateblue;">
									<?= $user_email; ?>
								</p>
								<p style="color: darkslateblue; margin-top: -15px;">
									<?= $user_no_hp; ?>
								</p>
								<p>
									<span class="font-weight-bold">
										Lokasi saya :
									</span>
									<br>
									<?= $class_dashboard->getAddress($user_latitude, $user_longitude); ?>
								</p>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>

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
				$text_status = "Proses";
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

			<div class="row mt-3">

				<div class="col-lg-12 mb-3 mb-lg-0">
					<div class="card">
						<div class="card-body">
							<h5>
								Detail Orderan Saya
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
											( <?= $bandara->alamat; ?> )
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
											( Pembayaran dapat dilakukan secara cash kepada driver kami saat anda sampai di bandara tujuan )
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
								<form action="<?= base_url(); ?>/Customer/Order/cancel_order" method="POST">
									<?= csrf_field(); ?>
									<input type="hidden" name="id_order" value="<?= $orderan_belum_selesai->id_order; ?>">

									<div class="d-flex justify-content-between align-items-center align-content-center">
										<a href="<?= base_url(); ?>/customer/order" class="btn btn-info">
											<i class="fa fa-arrow-right"></i> Detail Order
										</a>

										<button type="submit" class="btn btn-danger btn-cancel-order">
											<i class="fa fa-times"></i> Batalkan
										</button>
									</div>
								</form>
							<?php endif; ?>

						</div>
					</div>

				</div>

			</div>

		<?php else : ?>

			<div class="row justify-content-center mt-3">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">

							<h3 class="font-weight-bold text-center">
								Lokasi Driver
							</h3>
							<p class="text-center">
								( Lokasi driver aktif di sekitar : <span id="alamat_saya"></span> )
							</p>
							<hr>

							<span id="text-no-driver-ready" class="text-danger font-italic"></span>

							<div id="maps" style="width: 100%; height: 80vh; border-radius: 20px;"></div>

						</div>
					</div>
				</div>
			</div>

			<script>
				function writeAddressName(latLng) {
					let hasil;
					var geocoder = new google.maps.Geocoder();
					geocoder.geocode({
							"location": latLng
						},
						function(results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								hasil = results[0].formatted_address;
							} else {
								hasil = "Unable to retrieve your address" + "<br />";
							}
							document.getElementById("alamat_saya").innerHTML = hasil;
						});
				}

				function initMap() {
					var map;
					var userLoc;
					var gmarkers = [];
					var marker, i;
					var lineMarkers = [];
					var lingkar = [];
					var circle_user;
					var id_kategori;

					var driver_ready = 0;

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

							writeAddressName(userLoc);

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
								scaledSize: new google.maps.Size(44, 50), // scaled size
								origin: new google.maps.Point(0, 0), // origin
								anchor: new google.maps.Point(22, 34), // anchor
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
							if (marker) {
								marker.setMap(null);
								marker = "";
							}

							// hapus marker
							for (i = 0; i < gmarkers.length; i++) {
								if (gmarkers[i].getMap() != null) gmarkers[i].setMap(null);
							}
							// Akhir hapus marker

							var arrayTitikPengantaran = [
								<?php
								foreach ($pengantaran as $data) {

									$id_driver = $data["id_driver"];
									$id_bandara = $data["id_bandara"];

									$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver' "))->getRow();
									$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara' "))->getRow();

									$id_pengantaran = $data["id_pengantaran"];
									$nama_bandara = $bandara->nama_bandara;
									$latitude = $data["latitude"];
									$longitude = $data["longitude"];
									$nama_lokasi = $class_dashboard->getAddress($data['latitude'], $data['longitude']);
									$jarak_user_to_titik = $class_dashboard->distance_matrix_google($user_latitude, $user_longitude, $latitude, $longitude);
									$jarak_driver_to_titik = $class_dashboard->distance_matrix_google($driver->latitude, $driver->longitude, $latitude, $longitude);
									$jarak_titik_to_bandara = $class_dashboard->distance_matrix_google($latitude, $longitude, $bandara->latitude, $bandara->longitude);
									$jarak_user_to_bandara = $class_dashboard->distance_matrix_google($user_latitude, $user_longitude, $bandara->latitude, $bandara->longitude);
									$radius_jemput = $data["radius_jemput"];
									$foto_profil_driver = $driver->foto;

									$data_jarak_user_to_bandara = explode(' ', $jarak_user_to_bandara['distance']);
									$biaya_perjalanan = ($data_tarif['tarif_perkm'] * $data_jarak_user_to_bandara[0]);

									$data_waktu_tempuh_user_to_titik = explode(' ', $jarak_user_to_titik['duration']);
									$data_waktu_tempuh_driver_to_titik = explode(' ', $jarak_driver_to_titik['duration']);
									$data_waktu_tempuh_user_to_bandara = explode(' ', $jarak_user_to_bandara['duration']);
									$estimasi_penjemputan = $data_waktu_tempuh_driver_to_titik[0] + $data_waktu_tempuh_user_to_titik[0];

									echo "
						{
                            id_driver: '" . $id_driver . "',
                            id_bandara: '" . $id_bandara . "',
                            nama_bandara: '" . $nama_bandara . "',
                            id_pengantaran: '" . $id_pengantaran . "',
                            latitude: '" . $latitude . "',
                            longitude: '" . $longitude . "',
                            nama_lokasi: '" . $nama_lokasi . "',
                            radius_jemput: '" . $radius_jemput . "',
                            jarak_user_to_titik: '" . $jarak_user_to_titik["distance"] . "',
                            waktu_tempuh_user_to_titik: '" . $jarak_user_to_titik["duration"] . "',
                            jarak_titik_to_bandara: '" . $jarak_titik_to_bandara["distance"] . "',
                            waktu_tempuh_titik_to_bandara: '" . $jarak_titik_to_bandara["duration"] . "',
                            jarak_user_to_bandara: '" . $data_jarak_user_to_bandara[0] . "',
                            waktu_tempuh_user_to_bandara: '" . $data_waktu_tempuh_user_to_bandara[0] . "',
                            estimasi_penjemputan: '" . $estimasi_penjemputan . "',
                            biaya_perjalanan: '" . $biaya_perjalanan . "',
                            biaya_perjalanan_string: '" . rupiah($biaya_perjalanan, 'Y') . "',
                            foto_profil_driver: '" . $foto_profil_driver . "',
							nama_driver:'" . $driver->nama_lengkap . "',
							nopol_driver:'" . $driver->nopol . "',
							nama_driver:'" . $driver->nama_lengkap . "',
                        },
                        ";
								}
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

								stuDistances = calculateDistances(posisiMarker, userLoc);

								if (stuDistances.metres <= radius_jemput) {
									driver_ready += 1;

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
											infoWindow.setContent(`
												<div style="width: 100%; text-align: center;">
													<h4>${nama_driver}</h4>
													<p>${nopol_driver}</p>
													<img src="${link_foto_profil_driver}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
												</div>
												<br>
												<div class="row justify-content-center mb-4">
													<form class="formSubmitOrder">
														<?= csrf_field(); ?>
														<input type="hidden" name="id_customer" value="<?= $user_id ?>" />
														<input type="hidden" name="id_pengantaran" value="${id_pengantaran}"/>
														<input type="hidden" name="latitude" value="<?= $user_latitude ?>" />
														<input type="hidden" name="longitude" value="<?= $user_longitude ?>" />
														<input type="hidden" name="tarif_perkm" value="<?= $data_tarif['tarif_perkm'] ?>" />
														<input type="hidden" name="jarak_customer_to_bandara" value="${jarak_user_to_bandara}" />
														<input type="hidden" name="biaya" value="${biaya_perjalanan}" />

														<button type="button" class="btn btn-block btn-outline-success btn-submit-order" title="Order Taxi">
															<i class="fa fa-taxi"></i> ORDER TAXI
														</button>
													</form>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Lokasi Pengantaran
													</span> <br>
													<span>
														${nama_lokasi} <br>
														(${latitude}, ${longitude})
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Radius Jemput
													</span> <br>
													<span>
														${radius_jemput}
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Bandara Tujuan
													</span> <br>
													<span>
														${nama_bandara}
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Jarak menuju Bandara
													</span> <br>
													<span>
														${jarak_user_to_bandara} Km
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Biaya Perjalanan
													</span> <br>
													<span style="font-size: 20px;">
														${biaya_perjalanan_string}
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Waktu tempuh menuju bandara
													</span> <br>
													<span>
														${waktu_tempuh_user_to_bandara} menit
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Anda akan dijemput dalam
													</span> <br>
													<span>
														${estimasi_penjemputan} menit lagi
													</span>
												</div>
												<br>
												<br>
												`);
											infoWindow.open(map, marker_pengantaran);
										}
									})(marker_pengantaran, i));
									gmarkers.push(marker_pengantaran);
								}

								if (driver_ready = 0) {
									$('#text-no-driver-ready').text('Tidak ada driver yang melakukan pengantaran penumpang di sekitar anda !');
								}
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

						function computeTotals(result, infoWindow, id_pengantaran) {
							var totalDist = 0;
							var totalTime = 0;
							var myroute = result.routes[0];
							for (i = 0; i < myroute.legs.length; i++) {
								totalDist += myroute.legs[i].distance.value;
								totalTime += myroute.legs[i].duration.value;
							}

							totalDist = totalDist / 1000;
							infoWindow.setContent(infoWindow.getContent() + `
                        <tr style="text-align: left;">
                            <td>Jarak Tempuh</td>
                            <td>:</td>
                            <td>${totalDist.toFixed(2)} km (${(totalDist * 0.621371).toFixed(2)} miles) dari lokasi anda</td>
                        </tr>
                        <tr style="text-align: left;">
                            <td>Waktu Tempuh</td>
                            <td>:</td>
                            <td>${(totalTime / 60).toFixed(2)} menit dari lokasi anda</td>
                        </tr>
                    </table>
                    `);
						}

						function calculateDistances(start, end) {

							var stuDistances = {};

							stuDistances.metres = google.maps.geometry.spherical.computeDistanceBetween(start, end); // distance in metres
							stuDistances.km = Math.round(stuDistances.metres / 2000 * 10) / 10; // distance in km rounded to 1dp
							stuDistances.miles = Math.round(stuDistances.metres / 2000 * 0.6214 * 10) / 10; // distance in miles rounded to 1dp
							return stuDistances;
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


			<script>
				$(document).ready(function() {
					$(function() {

						$(".btn-submit-order").click(function(e) {
							e.preventDefault();

							var id_customer = $('input[name="id_customer"]').val();
							var id_pengantaran = $('input[name="id_pengantaran"]').val();
							var latitude = $('input[name="latitude"]').val();
							var longitude = $('input[name="longitude"]').val();
							var tarif_perkm = $('input[name="tarif_perkm"]').val();
							var jarak_customer_to_bandara = $('input[name="jarak_customer_to_bandara"]').val();
							var biaya = $('input[name="biaya"]').val();

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
								success: function(data) {
									if (data.success == "1") {
										Swal.fire(
											'Berhasil !',
											data.pesan,
											'success'
										);
										setTimeout(function() {
											window.location = window.location
										}, 5000);
									} else if (data.success == "0") {
										Swal.fire(
											'Gagal !',
											data.pesan,
											'error'
										);
										setTimeout(function() {
											window.location = window.location
										}, 5000);
									}
								}
							});

						});

					});
				});
			</script>

		<?php endif; ?>


	</div>

</section>


<?= $this->endSection('content'); ?>