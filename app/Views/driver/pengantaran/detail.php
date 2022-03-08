<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
$class_dashboard = new App\Controllers\Driver\Dashboard;
?>

<section class="py-8" id="home">

	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/driver/pengantaran" class="btn btn-dark">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-2">
						Detail Pengantaran
					</h4>
				</div>
				<hr>
			</div>
		</div>

		<?php
		$id_bandara = $pengantaran['id_bandara'];
		$bandara = $db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'")->getRow();
		$nama_lokasi_pengantaran = $class_dashboard->getAddress($pengantaran['latitude'], $pengantaran['longitude']);

		if ($pengantaran['status_pengantaran'] == "0") {
			$class_text_status = "badge badge-warning";
			$text_status = "Dalam Pengantaran";
		} else if ($pengantaran['status_pengantaran'] == "1") {
			$class_text_status = "badge badge-success";
			$text_status = "Selesai";
		} else if ($pengantaran['status_pengantaran'] == "2") {
			$class_text_status = "badge badge-danger";
			$text_status = "Tidak Selesai";
		}
		?>
		<div class="row justify-content-center">

			<div class="col-lg-12">
				<div id="maps" style="width: 100%; height: 70vh; border-radius: 20px;"></div>

				<div class="card my-3">
					<div class="card-body">
						<div id="text-direction-guide"></div>
					</div>
				</div>
			</div>

			<div class="col-lg-12 mt-3">
				<div class="card">
					<div class="card-body">
						<h5>Data Pengantaran</h5>
						<hr>
						<div class="mt-3">
							<span class="d-block">
								Tanggal
							</span>
							<span class="font-weight-bold">
								<?= strftime("%d/%m/%Y", strtotime($pengantaran['create_datetime'])); ?>
							</span>
						</div>
						<div class="mt-3">
							<span class="d-block">
								Waktu
							</span>
							<span class="font-weight-bold">
								<?= strftime("%H:%M:%S", strtotime($pengantaran['create_datetime'])); ?> WIB
							</span>
						</div>
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
								Lokasi Bandara
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
								Lokasi Pengantaran
							</span>
							<span class="d-block font-weight-bold">
								<?= $nama_lokasi_pengantaran ?>
							</span>
						</div>
						<div class="mt-3">
							<span class="d-block">
								Radius Jemput
							</span>
							<span class="d-block font-weight-bold">
								<?= $pengantaran['radius_jemput']; ?> meter
							</span>
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

		var radius_jemput = <?= $pengantaran['radius_jemput'] ?>;

		var infoWindow = new google.maps.InfoWindow;
		var bounds = new google.maps.LatLngBounds();
		var directionsService = new google.maps.DirectionsService();
		var directionsRenderer = new google.maps.DirectionsRenderer({
			// draggable: true,
			map
		});

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

		let bandaraLocation = new google.maps.LatLng(<?= $bandara->latitude . ',' . $bandara->longitude ?>);
		let driverLocation = new google.maps.LatLng(<?= $user_latitude . ',' . $user_longitude ?>);
		let posisiPengantaran = new google.maps.LatLng(<?= $pengantaran["latitude"] . ',' . $pengantaran["longitude"] ?>);

		var mapOptions = {
			center: bandaraLocation,
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
				strokeColor: "blue"
			},
			suppressMarkers: true
		});

		var iconMarkerBandara = {
			url: "<?= base_url() ?>/assets/img/airport-marker.png", // url
			scaledSize: new google.maps.Size(40, 40), // scaled size
			origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(20, 20) // anchor
		};
		var markerBandara = new google.maps.Marker({
			position: bandaraLocation,
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
							${bandaraLocation}
						</span>
					</div>
					<br>
					`);
				infoWindow.open(map, markerBandara);
			}
		})(markerBandara));

		var iconTitikPengantaran = {
			url: "<?= base_url() ?>/assets/img/titik-pengantaran.png", // url
			scaledSize: new google.maps.Size(40, 40), // scaled size
			origin: new google.maps.Point(0, 0), // origin
			anchor: new google.maps.Point(20, 20) // anchor
		};
		var marker_pengantaran = new google.maps.Marker({
			position: posisiPengantaran,
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
				var distinationOrigin = bandaraLocation;
				var destinationMarker = posisiPengantaran;

				infoWindow.setContent(`
                                    <table class="table-sm table-borderless mt-1">
                                        <tr style="text-align: left;">
                                            <td>Lokasi</td>
                                            <td>:</td>
                                            <td style="width: 70%;"><?= $nama_lokasi_pengantaran ?></td>
                                        </tr>
										<tr style="text-align: left;">
                                            <td>Koordinat</td>
                                            <td>:</td>
                                            <td style="width: 70%;">${posisiPengantaran} meter</td>
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
			<?php if ($pengantaran['status_pengantaran'] == '0') : ?>
				var start = driverLocation;

				var iconDriver = {
					url: "<?= base_url() ?>/assets/img/taxi.png", // url
					scaledSize: new google.maps.Size(40, 40), // scaled size
					origin: new google.maps.Point(0, 0), // origin
					anchor: new google.maps.Point(20, 20) // anchor
				};
				var markerDriver = new google.maps.Marker({
					position: driverLocation,
					map: map,
					icon: iconDriver
				});
			<?php else : ?>
				var start = bandaraLocation;
			<?php endif; ?>
			var end = posisiPengantaran;

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

	}

	google.maps.event.addDomListener(window, 'load', initMap);
</script>

<?= $this->endSection('content'); ?>