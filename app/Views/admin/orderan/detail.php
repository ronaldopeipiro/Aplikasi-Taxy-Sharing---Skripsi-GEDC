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
$class_dashboard = new App\Controllers\Admin\Dashboard;

$id_pengantaran = $orderan['id_pengantaran'];
$pengantaran = ($db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' LIMIT 1"))->getRow();

$id_bandara = $pengantaran->id_bandara;
$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'"))->getRow();

$id_driver = $pengantaran->id_driver;
$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver'"))->getRow();

$id_customer = $orderan['id_customer'];
$customer = ($db->query("SELECT * FROM tb_customer WHERE id_customer='$id_customer'"))->getRow();

$nama_lokasi = $class_dashboard->getAddress($pengantaran->latitude, $pengantaran->longitude);
$jarak_user_to_titik = $class_dashboard->distance_matrix_google($orderan['latitude'], $orderan['longitude'], $pengantaran->latitude, $pengantaran->longitude);
$jarak_driver_to_titik = $class_dashboard->distance_matrix_google($driver->latitude, $driver->longitude, $pengantaran->latitude, $pengantaran->longitude);
$jarak_titik_to_bandara = $class_dashboard->distance_matrix_google($pengantaran->latitude, $pengantaran->longitude, $bandara->latitude, $bandara->longitude);
$jarak_user_to_bandara = $class_dashboard->distance_matrix_google($orderan['latitude'], $orderan['longitude'], $bandara->latitude, $bandara->longitude);

$data_jarak_user_to_bandara = explode(' ', $jarak_user_to_bandara['distance']);
$user_to_bandara_jarak = $data_jarak_user_to_bandara[0];
$biaya_perjalanan = $orderan['biaya'];

$data_waktu_tempuh_user_to_titik = explode(' ', $jarak_user_to_titik['duration']);
$data_waktu_tempuh_driver_to_titik = explode(' ', $jarak_driver_to_titik['duration']);
$data_waktu_tempuh_user_to_bandara = explode(' ', $jarak_user_to_bandara['duration']);

if ($orderan['status'] == "0") {
	$class_text_status = "badge badge-warning";
	$text_status = "Proses (Menunggu driver untuk konfirmasi orderan)";
} else if ($orderan['status'] == "1") {
	$class_text_status = "badge badge-info";
	$text_status = "Orderan diterima oleh driver";
} else if ($orderan['status'] == "2") {
	$class_text_status = "badge badge-info";
	$text_status = "Driver menjemput customer";
} else if ($orderan['status'] == "3") {
	$class_text_status = "badge badge-primary";
	$text_status = "Dalam perjalanan menuju bandara";
} else if ($orderan['status'] == "4") {
	$class_text_status = "badge badge-success";
	$text_status = "Selesai";
} else if ($orderan['status'] == "5") {
	$class_text_status = "badge badge-danger";
	$text_status = "Orderan dibatalkan oleh customer";
} else if ($orderan['status'] == "6") {
	$class_text_status = "badge badge-dark";
	$text_status = "Orderan ditolak oleh driver";
}

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

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(<?= base_url() ?>/assets/img/illustrations/category-bg.png); background-position:right top; background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/admin/orderan" class="btn btn-dark">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-2">
						Detail Orderan
					</h4>
				</div>
				<hr>
			</div>

			<div class="col-12">
				<div class="row">

					<div class="col-lg-12 mb-3">
						<div class="card">
							<div class="card-body">
								<div id="peta" style="border-radius: 10px; height: 77vh; width: 100%;"></div>
							</div>
						</div>
					</div>

					<div class="col-lg-12 mb-3">
						<div class="card">
							<div class="card-body">
								<h5>
									Detail Orderan
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
											<?= $class_dashboard->getAddress($orderan['latitude'], $orderan['longitude']); ?>
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
										<td>Jarak customer ke bandara</td>
										<td>:</td>
										<td>
											<?= $orderan['jarak_customer_to_bandara']; ?> Km
										</td>
									</tr>
									<tr>
										<td>Biaya</td>
										<td>:</td>
										<td>
											<span class="font-weight-bold" style="font-size: 30px;">
												<?= rupiah($orderan['biaya'], "Y"); ?>
											</span>
											<small><?= rupiah($orderan['tarif_perkm'], "Y"); ?> / Km</small>
											<br>
											<small class="text-warning font-italic">
												(Pembayaran dapat dilakukan secara cash kepada driver kami saat anda sampai di bandara tujuan)
											</small>
										</td>
									</tr>
								</table>

							</div>
						</div>

					</div>

					<div class="col-lg-6">
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

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body">
								<h5>
									Customer
								</h5>
								<div class="text-center">
									<img src="<?= $foto_customer; ?>" style="width: 180px; height: 180px; border-radius: 50%; padding: 5px; border: solid 2px #eee; object-fit: cover; object-position: top;">
								</div>
								<table class="table table-sm table-borderless table-responsive mt-3" style="font-size: 14px;">
									<tr>
										<td>Nama customer</td>
										<td>:</td>
										<td>
											<?= $customer->nama_lengkap; ?>
										</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>:</td>
										<td>
											<a href="mailto:<?= $customer->email; ?>">
												<?= $customer->email; ?>
											</a>
										</td>
									</tr>
									<tr>
										<td>No. Handphone</td>
										<td>:</td>
										<td>
											<a href="tel:<?= $customer->no_hp; ?>">
												<?= $customer->no_hp; ?>
											</a>
										</td>
									</tr>
								</table>

								<a href="tel:<?= $customer->no_hp; ?>" class="btn btn-block btn-primary">
									<i class="fa fa-phone mr-2"></i> Hubungi Customer
								</a>
							</div>
						</div>

					</div>

				</div>

			</div>
		</div>

	</div>
</section>

<script>
	function initMap() {
		var map;
		var gmarkers = [];
		var marker, i;
		var lineMarkers = [];
		var lingkar = [];
		var id_kategori;

		var infoWindow = new google.maps.InfoWindow;
		var bounds = new google.maps.LatLngBounds();

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

		var posisiDriver = new google.maps.LatLng(<?= $driver->latitude ?>, <?= $driver->longitude ?>);
		var posisiBandara = new google.maps.LatLng(<?= $bandara->latitude . ',' . $bandara->longitude ?>);

		var mapOptions = {
			center: posisiBandara,
			zoom: 11,
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

		let posisiPengantaran = new google.maps.LatLng(<?= $pengantaran->latitude . "," . $pengantaran->longitude ?>);
		let radius_jemput = <?= $pengantaran->radius_jemput ?>;

		var iconTitikPengantaran = {
			url: "<?= base_url() ?>/assets/img/titik-pengantaran.png", // url
			scaledSize: new google.maps.Size(50, 50), // scaled size
			origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(25, 25) // anchor
		};
		var markerPengantaran = new google.maps.Marker({
			position: posisiPengantaran,
			map: map,
			// icon: iconTitikPengantaran
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

		circlePengantaran.bindTo('center', markerPengantaran, 'position');
		circlePengantaran.setRadius(parseFloat(radius_jemput));

		google.maps.event.addListener(markerPengantaran, 'click', (function(markerPengantaran, i) {
			return function() {
				infoWindow.setContent(`
                                    <div style="width: 100%; text-align: center;">
                                        <h5>Titik Pengantaran Penumpang dari Bandara</h5>
									</div>
									<br>
                                    <table class="table-sm table-borderless mt-1">
                                        <tr style="text-align: left;">
                                            <td>Lokasi</td>
                                            <td>:</td>
                                            <td style="width: 70%;"><?= $class_dashboard->getAddress($pengantaran->latitude, $pengantaran->longitude) ?></td>
                                        </tr>
										<tr style="text-align: left;">
                                            <td>Koordinat</td>
                                            <td>:</td>
                                            <td style="width: 70%;"><?= $pengantaran->latitude . ", " . $pengantaran->longitude ?></td>
                                        </tr> 
										<tr style="text-align: left;">
                                            <td>Radius Jemput</td>	
                                            <td>:</td>
                                            <td style="width: 70%;"><?= $pengantaran->radius_jemput ?> meter</td>
                                        </tr>
									`);
				infoWindow.open(map, markerPengantaran);
			}
		})(markerPengantaran, i));

		let posisiCustomer = new google.maps.LatLng(<?= $orderan['latitude'] . "," . $orderan['longitude'] ?>);
		let linkFotoProfilCustomer = "<?= $foto_customer ?>";

		var iconCustomer = {
			url: "<?= base_url() ?>/assets/img/user-loc-marker.png", // url
			scaledSize: new google.maps.Size(40, 40), // scaled size
			origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(20, 20) // anchor
		};

		var markerCustomer = new google.maps.Marker({
			position: posisiCustomer,
			title: 'Lokasi Customer',
			map: map,
			icon: iconCustomer
		});

		google.maps.event.addListener(markerCustomer, 'click', (function(markerCustomer, i) {
			return function() {
				infoWindow.setContent(`
									<div style="width: 100%; text-align: center;">
										<h5>Titik Jemput Customer</h5>
										<img src="${linkFotoProfilCustomer}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; object-position: top;"/>
									</div>
									<br>
									<table class="table-sm table-borderless mt-1">
										<tr style="text-align: left;">
											<td>Nama Customer</td>
											<td>:</td>
											<td style="width: 70%;"><?= $customer->nama_lengkap ?></td>
										</tr>
										<tr style="text-align: left;">
											<td>Email</td>
											<td>:</td>
											<td style="width: 70%;"<?= $customer->email ?></td>
										</tr>
										<tr style="text-align: left;">
											<td>No. Handphone</td>
											<td>:</td>
											<td style="width: 70%;"><?= $customer->no_hp ?></td>
										</tr>
									`);
				infoWindow.open(map, markerCustomer);
			}
		})(markerCustomer, i));

		var iconDriver = {
			url: "<?= base_url() ?>/assets/img/taxi.png", // url
			scaledSize: new google.maps.Size(40, 40), // scaled size
			origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(20, 20) // anchor
		};

		bounds.extend(posisiBandara);
		bounds.extend(posisiCustomer);
		bounds.extend(posisiPengantaran);
		map.fitBounds(bounds); //auto-zoom
		map.panToBounds(bounds); //auto-center
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

<?= $this->endSection('content'); ?>