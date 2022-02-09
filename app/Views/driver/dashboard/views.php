<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
function rupiah($angka, $string)
{
	if ($string == "Y") {
		$hasil_rupiah = "Rp." . number_format($angka, 0, ',', '.') . ",-";
	} elseif ($string == "N") {
		$hasil_rupiah = number_format($angka, 0, ',', '.');
	}
	return $hasil_rupiah;
}

$data_orderan_belum_selesai = $db->query("SELECT * FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE tb_pengantaran.id_driver = '$user_id' AND tb_order.status <= 4");
$jumlah_orderan_masuk_belum_selesai =  $data_orderan_belum_selesai->getNumRows();

$tanggal_hari_ini = date("Y-m-d");
$tahun_ini = date("Y");
$bulan_ini = date("m");

$pendapatan_hari_ini = ($db->query("SELECT sum(tb_order.biaya) as total_biaya FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE tb_order.create_datetime LIKE '$tanggal_hari_ini %' AND tb_pengantaran.id_driver = '$user_id' AND tb_order.status = '4'"))->getRow();
$pendapatan_bulan_ini = ($db->query("SELECT sum(tb_order.biaya) as total_biaya FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE (MONTH(tb_order.create_datetime) = '$bulan_ini' AND YEAR(tb_order.create_datetime) = '$tahun_ini') AND tb_pengantaran.id_driver = '$user_id' AND tb_order.status = '4'"))->getRow();
$pendapatan_tahun_ini = ($db->query("SELECT sum(tb_order.biaya) as total_biaya FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE MONTH(tb_order.create_datetime) = '$bulan_ini' AND tb_pengantaran.id_driver = '$user_id' AND tb_order.status = '4'"))->getRow();
$pendapatan_total = ($db->query("SELECT sum(tb_order.biaya) as total_biaya FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE tb_pengantaran.id_driver = '$user_id' AND tb_order.status = '4'"))->getRow();

$class_dashboard = new App\Controllers\Driver\Dashboard;
?>

<section class="py-8" id="home">

	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<div class="row align-items-center pt-3 pt-lg-0">

							<div class="col-lg-3 text-center">
								<img src="<?= (empty($user_foto)) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/driver/' . $user_foto; ?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: solid 2px #fff; padding: 2px; object-position: top;">
								<p>
									<?= $user_nopol; ?>
								</p>
							</div>

							<div class="col-lg-9 text-sm-start text-center">
								<h4 style="color: brown;">
									<?= $user_nama_lengkap; ?>
								</h4>
								<p class="font-weight-bold">
									No. Anggota : <?= $user_no_anggota; ?>
								</p>
								<p style="color: darkslateblue;">
									<?= $user_email; ?>
								</p>
								<p style="color: darkslateblue; margin-top: -15px;">
									<?= $user_no_hp; ?>
								</p>

								<?php if ($user_status == 1) : ?>
									<a href="<?= base_url(); ?>/driver/orderan" class="btn btn-outline-success mt-2 mr-2">
										<i class="fa fa-arrow-right"></i> Orderan Masuk
									</a>
									<a href="<?= base_url(); ?>/driver/pengantaran" class="btn btn-outline-info mt-2">
										<i class="fa fa-arrow-right"></i> Pengantaran
									</a>
								<?php endif; ?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-lg-12">
				<div class="card">

					<div class="row card-body">
						<h4>
							Total Pendapatan
						</h4>
						<div class="col-lg-3">
							<div class="card mt-3">
								<div class="card-body">
									<p>Hari ini</p>
									<h3>
										<?= rupiah($pendapatan_hari_ini->total_biaya, "Y"); ?>
									</h3>
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="card mt-3">
								<div class="card-body">
									<p>Bulan ini</p>
									<h3>
										<?= rupiah($pendapatan_bulan_ini->total_biaya, "Y"); ?>
									</h3>
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="card mt-3">
								<div class="card-body">
									<p>Tahun ini</p>
									<h3>
										<?= rupiah($pendapatan_tahun_ini->total_biaya, "Y"); ?>
									</h3>
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="card mt-3">
								<div class="card-body">
									<p>Total</p>
									<h3>
										<?= rupiah($pendapatan_total->total_biaya, "Y"); ?>
									</h3>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>

		</div>


		<?php if ($user_status == 0) : ?>

			<div class="alert alert-warning alert-dismissible rounded-3 mt-3 py-5">
				<h4 class="font-weight-bold font-italic">
					Akun anda belum terverifikasi oleh administrator !
				</h4>
				<br>
				Mohon tunggu hingga akun anda terverifikasi oleh administrator kami, agar anda dapat menggunakan layanan pada aplikasi ini. <br>
				Pesan konfirmasi atas verifikasi akun anda akan dikirimkan melalui email !
				<br>
				<br>
				Anda juga dapat menginstal aplikasi ini pada perangkat anda melalui fitur <i><b>Add to Homescreen</b></i> agar anda mendapatkan notifikasi langsung melalui perangkat anda
			</div>

		<?php else : ?>

			<?php if ($jumlah_orderan_masuk_belum_selesai > 0) : ?>
				<?php if ($r_orderan = $data_orderan_belum_selesai->getRow()) : ?>
					<?php
					$id_customer = $r_orderan->id_customer;
					$customer = ($db->query("SELECT * FROM tb_customer WHERE id_customer='$id_customer'"))->getRow();

					$id_pengantaran = $r_orderan->id_pengantaran;
					$pengantaran = ($db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' LIMIT 1"))->getRow();

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
											</div>

											<a href="<?= base_url(); ?>/driver/orderan" class="btn btn-info	btn-block mt-4">
												<i class="fa fa-list"></i> Detail
											</a>

											<div class="mt-3 d-flex justify-content-between">

												<?php if ($r_orderan->status == "0") : ?>

													<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 50%">
														<input type="hidden" name="id_order" value="<?= $r_orderan->id_order; ?>">
														<input type="hidden" name="status" value="1">
														<button type="submit" class="btn btn-block btn-success btn-terima-order" style="width: 100%;">
															<i class="fa fa-check"></i> Terima
														</button>
													</form>

													<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 50%;">
														<input type="hidden" name="id_order" value="<?= $r_orderan->id_order; ?>">
														<input type="hidden" name="status" value="6">
														<button type="submit" class="btn btn-block btn-danger btn-tolak-order" style="width: 100%;">
															<i class="fa fa-times"></i> Tolak
														</button>
													</form>

												<?php elseif ($r_orderan->status == "1") : ?>

													<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 100%;">
														<input type="hidden" name="id_order" value="<?= $r_orderan->id_order; ?>">
														<input type="hidden" name="status" value="2">
														<button type="submit" class="btn btn-block btn-info btn-confirm-jemput-customer" style="width: 100%;">
															<i class="fa fa-car"></i> Jemput Customer
														</button>
													</form>


												<?php elseif ($r_orderan->status == "2") : ?>

													<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 100%;">
														<input type="hidden" name="id_order" value="<?= $r_orderan->id_order; ?>">
														<input type="hidden" name="status" value="3">
														<button type="submit" class="btn btn-block btn-primary btn-confirm-otw-bandara">
															<i class="fa fa-car"></i> Menuju Bandara
														</button>
													</form>

												<?php elseif ($r_orderan->status == "3") : ?>

													<span>
														Telah sampai di bandara ? tandai selesai !
													</span>

													<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post">
														<input type="hidden" name="id_order" value="<?= $r_orderan->id_order; ?>">
														<input type="hidden" name="status" value="4">
														<button type="submit" class="btn btn-block btn-danger btn-confirm-otw-bandara">
															<i class="fa fa-times"></i> Selesai
														</button>
													</form>

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

				<div class="card mt-4">
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col-12 text-left font-italic">
								<span>
									Lokasi Saya :
								</span>
								<span id="alamat_saya"></span>
								<hr>
							</div>
							<div class="col-12">
								<div id="peta" style="border-radius: 20px;"></div>
							</div>
						</div>
					</div>
				</div>

				<script>
					function initMap() {
						let map;
						let userLoc;
						let gmarkers = [];
						let marker, i, marker_semua, markerDriver;
						let lineMarkers = [];
						let lingkar = [];
						let circle_user;

						let infoWindow = new google.maps.InfoWindow;
						let bounds = new google.maps.LatLngBounds();
						let directionsService = new google.maps.DirectionsService;
						let directionsDisplay;

						if (navigator.geolocation) {
							var positionOptions = {
								enableHighAccuracy: true,
								timeout: 10 * 1000 // 10 seconds
							};

							navigator.geolocation.getCurrentPosition(function(position) {
								userLat = position.coords.latitude;
								userLng = position.coords.longitude;
								userLoc = new google.maps.LatLng(userLat, userLng);

								function writeAddressName(latLng) {
									var geocoder = new google.maps.Geocoder();
									geocoder.geocode({
											"location": latLng
										},
										function(results, status) {
											if (status == google.maps.GeocoderStatus.OK) {
												document.getElementById("alamat_saya").innerHTML = results[3].formatted_address;
											} else {
												document.getElementById("alamat_saya").innerHTML += "Unable to retrieve your address" + "<br />";
											}
										});
								}

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

								writeAddressName(userLoc);

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

								map = new google.maps.Map(document.getElementById('peta'), mapOptions);
								map.mapTypes.set('mystyle', new google.maps.StyledMapType(myStyle, {
									name: 'Peta'
								}));

								var trafficLayer = new google.maps.TrafficLayer();
								trafficLayer.setMap(map);

								var icon_user = {
									url: "<?= base_url() ?>/assets/img/taxi.png", // url
									scaledSize: new google.maps.Size(60, 60), // scaled size
									origin: new google.maps.Point(0, 0), // origin
									anchor: new google.maps.Point(30, 30), // anchor
									animation: google.maps.Animation.DROP
								};

								var centerLoc = new google.maps.Marker({
									position: userLoc,
									map: map,
									title: 'Lokasi Saya !',
									icon: icon_user,
									animation: google.maps.Animation.DROP
								});
							}, function() {
								handleLocationError(true, centerLoc, map.getCenter());
							}, positionOptions);

							function calculateAndDisplayRoute(directionsService, directionsDisplay, distinationOrigin, destinationMarker, infoWindow, id_driver) {
								directionsService.route({
									origin: distinationOrigin,
									destination: destinationMarker,
									travelMode: google.maps.TravelMode.DRIVING
								}, function(response, status) {
									if (status === google.maps.DirectionsStatus.OK) {
										directionsDisplay.setDirections(response);
										computeTotals(response, infoWindow, id_driver);
									} else {
										window.alert('Directions request failed due to ' + status);
									}
								});
							}

							function computeTotals(result, infoWindow, id_driver) {
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
                            <td>${totalDist.toFixed(2)} km (${(totalDist * 0.621371).toFixed(2)} miles)</td>
                        </tr>
                        <tr style="text-align: left;">
                            <td>Waktu Tempuh</td>
                            <td>:</td>
                            <td>${(totalTime / 60).toFixed(2)} menit</td>
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

			<?php endif; ?>

		<?php endif; ?>

	</div>

</section>

<?= $this->endSection('content'); ?>