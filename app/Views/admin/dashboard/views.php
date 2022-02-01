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

$tarif = ($db->query("SELECT * FROM tb_tarif ORDER BY id_tarif DESC LIMIT 1"))->getRow();

$jumlah_driver = $db->query("SELECT * FROM tb_driver")->getNumRows();
$jumlah_driver_aktif = $db->query("SELECT * FROM tb_driver WHERE aktif='Y' ")->getNumRows();

$jumlah_customer = $db->query("SELECT * FROM tb_customer")->getNumRows();
$jumlah_customer_aktif = $db->query("SELECT * FROM tb_customer WHERE status='1' ")->getNumRows();

$jumlah_bandara = $db->query("SELECT * FROM tb_bandara")->getNumRows();
$jumlah_bandara_aktif = $db->query("SELECT * FROM tb_bandara WHERE status='1' ")->getNumRows();

$data_bandara = ($db->query("SELECT * FROM tb_bandara ORDER BY id_bandara DESC LIMIT 1"))->getRow();
// Query jumlah orderan perbulan -> chart
for ($i = 1; $i <= 12; $i++) {
	for ($angka_status = 0; $angka_status <= 6; $angka_status++) {
		$data_orderan_perbulan = ($db->query("SELECT * FROM tb_order WHERE status = '$angka_status' AND MONTH(create_datetime) = '$i' ORDER BY id_order DESC"))->getNumRows();
		$data_jumlah_orderan[$i][$angka_status] = $data_orderan_perbulan;
	}
}

$class_dashboard = new App\Controllers\Driver\Dashboard;
?>

<section class="py-8" id="home" style="min-height: 97vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="card rounded-3">
					<div class="card-body">

						<div class="row align-items-center pt-3 pt-lg-0">
							<div class="col-lg-3 text-sm-start text-center">
								<img src="<?= (empty($user_foto)) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/admin/' . $user_foto; ?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: solid 2px #fff; padding: 2px; object-position: top;">
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
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3">

			<div class="col-lg-3">
				<a style="text-decoration: none;" href="<?= base_url(); ?>/admin/driver">
					<div class="card rounded-3">
						<div class="card-body">
							Tarif <br>
							<h3>
								<?= rupiah($tarif->tarif_perkm, "Y"); ?>
							</h3>
							<span class="text-success">
								Per-Km
							</span>
						</div>
					</div>
				</a>
			</div>

			<div class="col-lg-3">
				<a style="text-decoration: none;" href="<?= base_url(); ?>/admin/driver">
					<div class="card rounded-3">
						<div class="card-body">
							Driver <br>
							<h3>
								<?= $jumlah_driver; ?>
							</h3>
							<span class="text-success">
								<?= $jumlah_driver_aktif; ?> driver aktif
							</span>
						</div>
					</div>
				</a>
			</div>

			<div class="col-lg-3">
				<a style="text-decoration: none;" href="<?= base_url(); ?>/admin/customer">
					<div class="card rounded-3">
						<div class="card-body">
							Customer <br>
							<h3>
								<?= $jumlah_customer; ?>
							</h3>
							<span class="text-success">
								<?= $jumlah_customer_aktif; ?> customer aktif
							</span>
						</div>
					</div>
				</a>
			</div>

			<div class="col-lg-3">
				<a style="text-decoration: none;" href="<?= base_url(); ?>/admin/bandara">
					<div class="card rounded-3">
						<div class="card-body">
							Bandara Tujuan <br>
							<h3>
								<?= $jumlah_bandara; ?>
							</h3>
							<span class="text-success">
								<?= $jumlah_bandara_aktif; ?> bandara tujuan aktif
							</span>
						</div>
					</div>
				</a>
			</div>

		</div>

		<div class="row mt-3">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h5>
							Grafik Orderan Perbulan Tahun <?= date("Y"); ?>
						</h5>
						<hr>
						<div id="chart" style="width: 100%; height: 100%;"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body">
						<h5>
							Peta lokasi bandara, driver, customer, & titik pengantaran
						</h5>
						<hr>
						<div id="maps" style="border-radius: 20px; width: 100%; height: 77vh;"></div>
					</div>
				</div>
			</div>
		</div>

	</div>

</section>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
	function drawVisualization() {
		// Create and populate the data table.
		var data = google.visualization.arrayToDataTable([
			[
				'Bulan',
				'Proses',
				'Orderan diterima driver',
				'Driver sedang jemput penumpang',
				'Menuju bandara',
				'Selesai',
				'Order dibatalkan oleh customer',
				'Order dibatalkan oleh driver'
			],
			<?php
			for ($a = 1; $a <= 12; $a++) {

				echo "
					[
						'$a', ";
				for ($b = 0; $b <= 6; $b++) {
					$data_jumlah = $data_jumlah_orderan[$a][$b];
					echo $data_jumlah . ',';
				}
				echo "],
				";
			}
			?>
		]);

		// Create and draw the visualization.
		new google.visualization.ColumnChart(document.getElementById('chart')).
		draw(data, {
			title: "",
			// width: 600,
			height: 400,
			vAxis: {
				title: "Jumlah Orderan"
			},
			isStacked: true,
			hAxis: {
				title: "Bulan"
			}
		});
	}

	google.load("visualization", "1", {
		packages: ["corechart"]
	});
	google.setOnLoadCallback(drawVisualization);
</script>


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
		var gmarkersDriver = [];
		var marker, i;
		var lineMarkers = [];
		var lingkar = [];
		var id_kategori;

		var infoWindow = new google.maps.InfoWindow;
		var bounds = new google.maps.LatLngBounds();
		var directionsService = new google.maps.DirectionsService;
		var directionsDisplay;

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

		var center = new google.maps.LatLng(-0.047732, 109.374607);

		var mapOptions = {
			center: center,
			zoom: 12,
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

		var trafficLayer = new google.maps.TrafficLayer();
		trafficLayer.setMap(map);

		var posisiBandara = new google.maps.LatLng(<?= $data_bandara->latitude . ',' . $data_bandara->longitude ?>);
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
										<?= $data_bandara->nama_bandara ?>
									</h5>
								</div>
								<br>
								<div class="mb-2">
									<span class="font-weight-bold">
										Alamat
									</span> <br>
									<span>
										<?= $data_bandara->alamat ?>
									</span>
								</div>
								<div class="mb-2">
									<span class="font-weight-bold">
										Koordinat Lokasi
									</span> <br>
									<span>
										(<?= $data_bandara->latitude ?>, <?= $data_bandara->longitude ?>)
									</span>
								</div>
								<br>
								`);
				infoWindow.open(map, markerBandara);
			}
		})(markerBandara));


		// Titik pengantaran
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
				$pengantaran = $db->query("SELECT * FROM tb_pengantaran WHERE status_pengantaran='0'");
				foreach ($pengantaran->getResult('array') as $data) {

					$id_driver = $data["id_driver"];
					$id_bandara = $data["id_bandara"];

					$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver' "))->getRow();
					$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara' "))->getRow();

					$id_pengantaran = $data["id_pengantaran"];
					$nama_bandara = $bandara->nama_bandara;
					$latitude = $data["latitude"];
					$longitude = $data["longitude"];
					$nama_lokasi = $class_dashboard->getAddress($data['latitude'], $data['longitude']);
					$radius_jemput = $data["radius_jemput"];
					$foto_profil_driver = $driver->foto;
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
						infoWindow.setContent(`
												<div style="width: 100%; text-align: center;">
													<h4>${nama_driver}</h4>
													<p>${nopol_driver}</p>
													<img src="${link_foto_profil_driver}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
												</div>
												<br>
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
												<br>
												<br>
												`);
						infoWindow.open(map, marker_pengantaran);
					}
				})(marker_pengantaran, i));
				gmarkers.push(marker_pengantaran);
			}
		}

		// Lokasi Driver
		tampilLokasiDriver();

		function tampilLokasiDriver() {
			if (marker) {
				marker.setMap(null);
				marker = "";
			}

			// hapus marker
			for (i = 0; i < gmarkersDriver.length; i++) {
				if (gmarkersDriver[i].getMap() != null) gmarkersDriver[i].setMap(null);
			}
			// Akhir hapus marker

			var arrayLokasiDriver = [
				<?php
				$driver = $db->query("SELECT * FROM tb_driver WHERE aktif='Y'");
				foreach ($driver->getResult('array') as $data) {
					$id_driver = $data["id_driver"];
					$latitude = $data["latitude"];
					$longitude = $data["longitude"];
					$nama_lokasi = $class_dashboard->getAddress($data['latitude'], $data['longitude']);
					$no_hp = $data["no_hp"];
					$email = $data["email"];
					$foto_profil_driver = $data["foto"];
					echo "
						{
                            id_driver: '" . $id_driver . "',
                            latitude_driver: '" . $latitude . "',
                            longitude_driver: '" . $longitude . "',
                            foto_profil_driver: '" . $foto_profil_driver . "',
							nama_driver:'" . $data["nama_lengkap"] . "',
							nopol_driver:'" . $data["nopol"] . "',
							nama_lokasi_driver:'" . $nama_lokasi . "',
							email_driver:'" . $email . "',
							no_hp_driver:'" . $no_hp . "',
                        },
                        ";
				}
				?>
			];

			for (i = 0; i < arrayLokasiDriver.length; i++) {
				let id_driver = arrayLokasiDriver[i].id_driver;
				let nama_driver = arrayLokasiDriver[i].nama_driver;
				let nopol_driver = arrayLokasiDriver[i].nopol_driver;
				let no_hp_driver = arrayLokasiDriver[i].no_hp_driver;
				let email_driver = arrayLokasiDriver[i].email_driver;
				let foto_profil_driver = arrayLokasiDriver[i].foto_profil_driver;

				let latitude = arrayLokasiDriver[i].latitude_driver;
				let longitude = arrayLokasiDriver[i].longitude_driver;
				let nama_lokasi = arrayLokasiDriver[i].nama_lokasi_driver;
				let posisiDriver = new google.maps.LatLng(latitude, longitude);

				let link_foto_profil_driver = "";
				if (foto_profil_driver == "") {
					link_foto_profil_driver = base_url + '/assets/img/noimg.png';
				} else {
					link_foto_profil_driver = base_url + '/assets/img/driver/' + foto_profil_driver;
				}

				var iconDriver = {
					url: "<?= base_url() ?>/assets/img/taxi.png", // url
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
													<h4>${nama_driver}</h4>
													<p>${nopol_driver}</p>
													<img src="${link_foto_profil_driver}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
												</div>
												<br>
												<div class="mb-2">
													<span class="font-weight-bold">
														Lokasi Driver
													</span> <br>
													<span>
														${nama_lokasi} <br>
														(${latitude}, ${longitude})
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														No. Handphone
													</span> <br>
													<span>
														${no_hp_driver}
													</span>
												</div>
												<div class="mb-2">
													<span class="font-weight-bold">
														Email
													</span> <br>
													<span>
														${email_driver}
													</span>
												</div>
												<br>
												<br>
												`);
						infoWindow.open(map, markerDriver);
					}
				})(markerDriver, i));
				gmarkersDriver.push(markerDriver);
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

	google.maps.event.addDomListener(window, 'load', initMap);
</script>

<?= $this->endSection('content'); ?>