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

<?php if ($user_latitude == "" and $user_longitude == "") : ?>
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

			var infoWindow = new google.maps.InfoWindow;
			var bounds = new google.maps.LatLngBounds();
			var directionsService = new google.maps.DirectionsService;
			var directionsDisplay;

			if (navigator.geolocation) {
				var positionOptions = {
					enableHighAccuracy: true,
					timeout: 10 * 1000
				};

				navigator.geolocation.getCurrentPosition(function(position) {
					userLat = position.coords.latitude;
					userLng = position.coords.longitude;
					userLoc = new google.maps.LatLng(userLat, userLng);

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

					location.reload();

				}, function() {
					handleLocationError(true, markerUser, map.getCenter());
				}, positionOptions);

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

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(<?= base_url() ?>/assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="card rounded-3">
					<div class="card-body">

						<div class="row align-items-center pt-3 pt-lg-0">
							<div class="col-lg-3 text-center">
								<?php
								$foto_user = "";
								if ($user_foto != "") {
									if (strpos($user_foto, ':') !== false) {
										$foto_user = $user_foto;
									} else {
										$foto_user = base_url() . '/assets/img/customer/' . $user_foto;
									}
								} else {
									$foto_user = base_url() . '/assets/img/noimg.png';
								}
								?>
								<img src="<?= $foto_user ?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: solid 2px #fff; padding: 2px; object-position: top;">
							</div>

							<div class="col-lg-8 text-center text-lg-start">
								<h4 style="color: brown;">
									<?= $user_nama_lengkap; ?>
								</h4>
								<p style="color: darkslateblue;">
									<?= $user_email; ?>
								</p>
								<p style="color: darkslateblue; margin-top: -15px;">
									<?= $user_no_hp; ?>
								</p>

								<div class="mt-4">
									<p>
										<button class="btn btn-sm btn-outline-info js-notify-btn">Notify me!</button>
									</p>
									<p>
										<span id="statusSubsNotifikasi"></span>
										<button disabled class="btn btn-sm btn-outline-info js-push-btn">Subscribe !</button>
									</p>
									<span id="endpointURL"></span>
								</div>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>

		<?php if (($user_latitude != "") and ($user_longitude != "")) : ?>
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
				$val_jarak_user_to_bandara = str_replace(',', '.', $data_jarak_user_to_bandara[0]);
				$biaya_perjalanan = ($data_tarif['tarif_perkm'] * $val_jarak_user_to_bandara);

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

								<div class="d-flex justify-content-between align-items-center align-content-center">
									<a href="<?= base_url(); ?>/customer/order" class="btn btn-info">
										<i class="fa fa-arrow-right"></i> Detail Order
									</a>
									<?php if ($orderan_belum_selesai->status == "0") : ?>
										<form action="<?= base_url(); ?>/Customer/Order/cancel_order" method="POST">
											<?= csrf_field(); ?>
											<input type="hidden" name="id_order" value="<?= $orderan_belum_selesai->id_order; ?>">

											<button type="submit" class="btn btn-danger btn-cancel-order">
												<i class="fa fa-times"></i> Batalkan
											</button>
										</form>
									<?php endif; ?>
								</div>

							</div>
						</div>

					</div>

				</div>

			<?php else : ?>

				<div class="row justify-content-center mt-3">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<small class="text-left">
									( Lokasi pengantaran penumpang dari bandara di sekitar : <span class="font-italic" id="alamat_saya"></span> )
								</small>
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

					var map,
						markerUser,
						markerUserTag,
						userLoc,
						mapCenter = new google.maps.LatLng({
							lat: -0.0263303,
							lng: 109.3425039
						}),
						map;
					var gmarkers = [];
					var marker, i;
					var lineMarkers = [];
					var lingkar = [];
					var circle_user;

					var driver_ready = 0;

					var infoWindow = new google.maps.InfoWindow;
					var bounds = new google.maps.LatLngBounds();
					var directionsService = new google.maps.DirectionsService;
					var directionsDisplay;

					function initializeMap() {
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
							center: mapCenter,
							zoom: 14,
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

						var trafficLayer = new google.maps.TrafficLayer();
						trafficLayer.setMap(map);
					}

					function locError(error) {
						alert("The current position could not be found!");
					}

					// current position of the user
					function setCurrentPosition(pos) {
						userLoc = new google.maps.LatLng({
							lat: pos.coords.latitude,
							lng: pos.coords.longitude
						});

						var iconUser = {
							url: "<?= base_url() ?>/assets/img/user-loc-marker.png", // url
							scaledSize: new google.maps.Size(30, 30), // scaled size
							origin: new google.maps.Point(0, 0), // origin
							anchor: new google.maps.Point(15, 15), // anchor
						};

						var markerUser = new google.maps.Marker({
							position: userLoc,
							map: map,
							title: 'Lokasi Saya !',
							icon: iconUser
						});

						map.panTo(userLoc);
						writeAddressName(userLoc);

						$.ajax({
							type: "POST",
							url: "<?= base_url() ?>/Customer/Dashboard/update_posisi",
							dataType: "JSON",
							data: {
								latitude: pos.coords.latitude,
								longitude: pos.coords.longitude
							},
							success: function(data) {
								console.log('OK');
							}
						});

						tampilTitikPengantaran();

						function tampilTitikPengantaran() {
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
									$driver = $db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver' ")->getRow();

									$id_bandara = $data["id_bandara"];
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
									$val_jarak_user_to_bandara = str_replace(',', '.', $data_jarak_user_to_bandara[0]);
									$biaya_perjalanan = ($data_tarif['tarif_perkm'] * $val_jarak_user_to_bandara);

									$data_waktu_tempuh_user_to_titik = explode(' ', $jarak_user_to_titik['duration']);
									$data_waktu_tempuh_driver_to_titik = explode(' ', $jarak_driver_to_titik['duration']);
									$data_waktu_tempuh_user_to_bandara = explode(' ', $jarak_user_to_bandara['duration']);
									$estimasi_penjemputan = $data_waktu_tempuh_driver_to_titik[0] + $data_waktu_tempuh_user_to_titik[0];

									echo
									"{
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
												<form id="formSubmitOrder` + i + `">
													<?= csrf_field(); ?>
													<input type="hidden" name="id_customer" value="<?= $user_id ?>" />
													<input type="hidden" name="id_pengantaran" value="${id_pengantaran}"/>
													<input type="hidden" name="latitude" value="<?= $user_latitude ?>" />
													<input type="hidden" name="longitude" value="<?= $user_longitude ?>" />
													<input type="hidden" name="tarif_perkm" value="<?= $data_tarif['tarif_perkm'] ?>" />
													<input type="hidden" name="jarak_customer_to_bandara" value="${jarak_user_to_bandara}" />
													<input type="hidden" name="biaya" value="${biaya_perjalanan}" />
													<button type="button" class="btn btn-block btn-outline-success btn-submit-order-` + i + `" title="Order Taxi">
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

								$(".btn-submit-order-" + i).click(function(e) {
									// e.preventDefault();

									var id_customer = $('#formSubmitOrder' + i + ' input[name="id_customer"]').val();
									var id_pengantaran = $('#formSubmitOrder' + i + ' input[name="id_pengantaran"]').val();
									var latitude = $('#formSubmitOrder' + i + ' input[name="latitude"]').val();
									var longitude = $('#formSubmitOrder' + i + ' input[name="longitude"]').val();
									var tarif_perkm = $('#formSubmitOrder' + i + ' input[name="tarif_perkm"]').val();
									var jarak_customer_to_bandara = $('#formSubmitOrder' + i + ' input[name="jarak_customer_to_bandara"]').val();
									var biaya = $('#formSubmitOrder' + i + ' input[name="biaya"]').val();

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
												setTimeout(function() { // wait for 5 secs(2)
													location.reload(); // then reload the page.(3)
												}, 10);
											} else if (data.success == "0") {
												Swal.fire(
													'Gagal !',
													data.pesan,
													'error'
												);
												setTimeout(function() { // wait for 5 secs(2)
													location.reload(); // then reload the page.(3)
												}, 10);
											}
										}
									});

								});

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
					}

					function displayAndWatch(position) {
						setCurrentPosition(position);
						watchCurrentPosition();
					}

					function watchCurrentPosition() {
						var positionTimer = navigator.geolocation.watchPosition(
							function(position) {
								setMarkerPosition(
									markerUser,
									position
								);
							});
					}

					function setMarkerPosition(markerUserTag, position) {
						markerUserTag.setPosition(
							new google.maps.LatLng(
								position.coords.latitude,
								position.coords.longitude)
						);
					}

					function initLocationProcedure() {
						initializeMap();
						if (navigator.geolocation) {
							navigator.geolocation.getCurrentPosition(displayAndWatch, locError);
						} else {
							alert("Your browser does not support the Geolocation API!");
						}
					}

					// initialize with a little help of jQuery
					$(document).ready(function() {
						initLocationProcedure();
					});
				</script>

			<?php endif; ?>
		<?php endif; ?>


	</div>

</section>

<script>
	"use strict";
	var app = (function() {
		var isSubscribed = false;
		var swRegistration = null;
		var notifyButton = document.querySelector(".js-notify-btn");
		var pushButton = document.querySelector(".js-push-btn");
		var statusPermission = "";
		var endpoint = "";

		if (!("Notification" in window)) {
			console.log("Notifications not supported in this browser");
			return;
		}

		Notification.requestPermission();
		Notification.requestPermission(function(status) {
			statusPermission = status;
		});

		function displayNotification() {
			if (Notification.permission == "granted") {
				navigator.serviceWorker.getRegistration().then(function(reg) {
					var options = {
						// image: "https://jo.yokcaridok.id/assets/img/taxi.png",
						body: "Informasi Test ...",
						tag: "id1",
						icon: "https://jo.yokcaridok.id/assets/img/logo.jpg",
						vibrate: [200, 50, 50, 150],
						data: {
							dateOfArrival: Date.now(),
							primaryKey: 1
						},
						actions: [{
								action: "explore",
								title: "Buka notifikasi",
								icon: "https://jo.yokcaridok.id/assets/img/checkmark.png",
							},
							{
								action: "close",
								title: "Tutup notifikasi",
								icon: "https://jo.yokcaridok.id/assets/img/xmark.png",
							},
						],
					};
					reg.showNotification("Pemberitahuan Baru !", options);
				});
			}
		}


		function initializeUI() {
			pushButton.addEventListener("click", function() {
				if (statusPermission === "denied") {
					Notification.requestPermission();
				} else {
					pushButton.disabled = true;
					if (isSubscribed) {
						unsubscribeUser();
					} else {
						subscribeUser();
					}
				}
			});

			// Set initial subscription value
			swRegistration.pushManager.getSubscription().then(function(subscription) {
				isSubscribed = subscription !== null;
				updateSubscriptionOnServer(subscription);
				updateBtn();
			});
		}

		function subscribeUser() {
			swRegistration.pushManager
				.subscribe({
					userVisibleOnly: true,
				})
				.then(function(subscription) {
					console.log("User is subscribed:", subscription);
					updateSubscriptionOnServer(subscription);
					isSubscribed = true;
					updateBtn();
				})
				.catch(function(err) {
					if (Notification.permission === "denied") {
						console.warn("Permission for notifications was denied");
					} else {
						console.error("Failed to subscribe the user: ", err);
					}
					updateBtn();
				});
		}

		function unsubscribeUser() {
			swRegistration.pushManager
				.getSubscription()
				.then(function(subscription) {
					if (subscription) {
						var id_user = "<?= $user_id ?>";
						var tipe_user = "customer";
						var endpoint = subscription.endpoint;
						$('#endpointURL').text(endpoint);

						$.ajax({
							beforeSend: function() {
								$("#loading-image").show();
							},
							type: "POST",
							url: "<?= base_url() ?>/Home/unsubscribe_notification",
							dataType: "JSON",
							data: {
								id_user: id_user,
								tipe_user: tipe_user,
								endpoint: endpoint
							},
							success: function(data) {},
							complete: function(data) {
								$("#loading-image").hide();
							}
						});

						return subscription.unsubscribe();
					}
				})
				.catch(function(error) {
					console.log("Error unsubscribing", error);
				})
				.then(function() {
					updateSubscriptionOnServer(null);
					console.log("User is unsubscribed");
					isSubscribed = false;
					updateBtn();
				});
		}

		function updateSubscriptionOnServer(subscription) {
			var id_user = "<?= $user_id ?>";
			var tipe_user = "customer";

			if (subscription) {
				endpoint = subscription.endpoint;
				$('#endpointURL').text(endpoint);

				$.ajax({
					beforeSend: function() {
						$("#loading-image").show();
					},
					type: "POST",
					url: "<?= base_url() ?>/Home/subscribe_notification",
					dataType: "JSON",
					data: {
						id_user: id_user,
						tipe_user: tipe_user,
						endpoint: endpoint
					},
					success: function(data) {},
					complete: function(data) {
						$("#loading-image").hide();
					}
				});
			}
		}

		function updateBtn() {
			if (Notification.permission === "denied") {
				pushButton.textContent = "Ubah Izin Notifikasi";
				$("#statusSubsNotifikasi").text('Izin notifikasi diblokir !');
				pushButton.disabled = false;
				updateSubscriptionOnServer(null);
				return;
			}
			if (isSubscribed) {
				pushButton.textContent = "Nonaktifkan";
				$("#statusSubsNotifikasi").text('Notifikasi aktif !');
			} else {
				$("#statusSubsNotifikasi").text('Notifikasi tidak aktif !');
				pushButton.textContent = "Aktifkan";
			}
			pushButton.disabled = false;
		}

		notifyButton.addEventListener("click", function() {
			displayNotification();
		});

		if ("serviceWorker" in navigator && "PushManager" in window) {
			console.log("Service Worker and Push is supported");
			navigator.serviceWorker
				.register("<?= base_url() ?>/service-worker-notif.js")
				.then(function(swReg) {
					console.log("Service Worker registered", swReg);
					swRegistration = swReg;
					initializeUI();
				})
				.catch(function(error) {
					console.error("Service Worker Error", error);
				});
		} else {
			console.warn("Push messaging is not supported");
			pushButton.textContent = "Push Not Supported";
		}
	})();
</script>

th<?= $this->endSection('content'); ?>