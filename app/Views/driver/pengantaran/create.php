<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/driver/pengantaran" class="btn btn-dark" title="Tambah Data Pengantaran">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-2">
						Pengantaran
					</h4>
				</div>
				<hr>
			</div>

			<div class="col-lg-12" style="min-height: 300px;">
				<h4>
					Mau antar penumpang kemana ?
				</h4>
				<form action="<?= base_url(); ?>/Driver/Pengantaran/tambah_data_pengantaran" method="POST" enctype="multipart/form-data">
					<?= csrf_field(); ?>
					<div class="row">
						<div class="col-lg-8">
							<input id="pac-input" type="text" placeholder="Masukkan nama tempat ..." class="form-control" name="lokasi" value="" required>
							<div id="map" style="width: 100%; height: 440px;"></div>
						</div>
						<div class="col-lg-4">

							<div class="form-group row">
								<label for="latlonginput" class="col-12 col-form-label">
									Koordinat <br>
									<span id="mapSearchInput"></span>
								</label>
								<div class="col-12">
									<input class="form-control <?= ($validation->hasError('latlonginput')) ? 'is-invalid' : ''; ?>" id="latlonginput" name="latlonginput" value="<?= old('latlonginput') ?>" readonly required>
									<div class="invalid-feedback">
										<?= $validation->getError('latlonginput'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label for="radius_jemput" class="col-12 col-form-label">
									Radius Jemput
								</label>
								<div class="col-12">
									<div id="radius_pilihan">100</div>
									<input type="range" class="form-range <?= ($validation->hasError('radius_jemput')) ? 'is-invalid' : ''; ?>" id="radius_jemput" id="radius_jemput" name="radius_jemput" value="<?= (old('radius_jemput')) ? old('radius_jemput') : '100'; ?>" min="100" max="5000" step="10" onchange="updateTextInput(this.value);">
									<div class="invalid-feedback">
										<?= $validation->getError('radius_jemput'); ?>
									</div>
								</div>
							</div>

							<div class="form-group row mt-5">
								<div class="col-12">
									<button type="submit" class="btn btn-block btn-success">
										<i class="fa fa-arrow-right"></i> SUBMIT
									</button>
								</div>
							</div>

						</div>
					</div>

				</form>

			</div>
		</div>

	</div>
</section>

<script>
	let lineMarkers = [];
	let lingkar = [];
	let circle_user;
	let rad = 100;
	let slider_rad = 100;

	function initMap() {

		if (navigator.geolocation) {
			var positionOptions = {
				enableHighAccuracy: true,
				timeout: 10 * 1000 // 10 seconds
			};

			navigator.geolocation.getCurrentPosition(function(position) {
				userLat = position.coords.latitude;
				userLng = position.coords.longitude;
				userLoc = new google.maps.LatLng(userLat, userLng);

				const map = new google.maps.Map(document.getElementById("map"), {
					center: {
						lat: userLat,
						lng: userLng
					},
					zoom: 14,
					mapTypeId: "roadmap",
				});

				// Create the search box and link it to the UI element.
				const input = document.getElementById("pac-input");
				const searchBox = new google.maps.places.SearchBox(input);

				map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
				// Bias the SearchBox results towards current map's viewport.
				map.addListener("bounds_changed", () => {
					searchBox.setBounds(map.getBounds());
				});

				let markers = [];

				// Listen for the event fired when the user selects a prediction and retrieve
				// more details for that place.
				searchBox.addListener("places_changed", () => {
					const places = searchBox.getPlaces();

					if (places.length == 0) {
						return;
					}

					// Clear out the old markers.
					markers.forEach((marker) => {
						marker.setMap(null);
					});
					markers = [];

					// For each place, get the icon, name and location.
					const bounds = new google.maps.LatLngBounds();

					places.forEach((place) => {
						if (!place.geometry || !place.geometry.location) {
							console.log("Returned place contains no geometry");
							return;
						}

						let dataLatLng = place.geometry.location;
						document.getElementById("latlonginput").value = dataLatLng;

						const icon = {
							url: "<?= base_url() ?>/assets/img/marker-tujuan.png",
							size: new google.maps.Size(51, 51),
							origin: new google.maps.Point(0, 0),
							anchor: new google.maps.Point(17, 34),
							scaledSize: new google.maps.Size(70, 70),
						};

						// Create a marker for each place.
						var marker_tujuan;

						markers.push(
							marker_tujuan = new google.maps.Marker({
								map,
								icon,
								title: place.name,
								position: place.geometry.location,
								draggable: true
							})
						);

						google.maps.event.addListener(marker_tujuan, 'dragend', function() {
							var test = geocodePosition(marker_tujuan.getPosition());
							console.log(test);
						});

						function geocodePosition(pos) {
							geocoder = new google.maps.Geocoder();
							geocoder.geocode({
									latLng: pos
								},
								function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										$("#mapSearchInput").val(results[0].formatted_address);
										$("#mapErrorMsg").hide(100);
									} else {
										$("#mapErrorMsg").html('Cannot determine address at this location.' + status).show(100);
									}
								}
							);
						}

						var circle_tujuan = new google.maps.Circle({
							strokeColor: '#000AAA',
							strokeOpacity: 0.5,
							strokeWeight: 1,
							fillColor: '#00AEFF',
							fillOpacity: 0.1,
							map: map,
							radius: slider_rad
						});

						circle_tujuan.bindTo('center', marker_tujuan, 'position');
						circle_tujuan.setRadius(parseFloat(slider_rad));

						$(document).on('input', '#radius_jemput', function() {
							$('#radius_pilihan').html($(this).val());
							slider_rad = $(this).val();
							circle_tujuan.bindTo('center', marker_tujuan, 'position');
							circle_tujuan.setRadius(parseFloat(slider_rad));
						});


						if (place.geometry.viewport) {
							// Only geocodes have viewport.
							bounds.union(place.geometry.viewport);
						} else {
							bounds.extend(place.geometry.location);
						}
					});
					map.fitBounds(bounds);
				});

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
					url: "<?= base_url() ?>/assets/img/taxi-top-right.png", // url
					scaledSize: new google.maps.Size(40, 40), // scaled size
					origin: new google.maps.Point(0, 0), // origin
					anchor: new google.maps.Point(14, 18), // anchor
					animation: google.maps.Animation.DROP
				};

				var centerLoc = new google.maps.Marker({
					position: userLoc,
					map: map,
					title: 'Lokasi Saya !',
					icon: icon_user,
					animation: google.maps.Animation.DROP
				});

				// var circle_user = new google.maps.Circle({
				// 	strokeColor: '#000AAA',
				// 	strokeOpacity: 0.5,
				// 	strokeWeight: 1,
				// 	fillColor: '#00AEFF',
				// 	fillOpacity: 0.1,
				// 	map: map,
				// 	radius: rad
				// });

				// circle_user.bindTo('center', centerLoc, 'position');
				// circle_user.setRadius(parseFloat(rad));

			}, function() {
				handleLocationError(true, centerLoc, map.getCenter());
			}, positionOptions);

		} else {
			handleLocationError(false, infoWindow, map.getCenter());
		}

	}

	function geocodePosition(pos) {
		geocoder.geocode({
			latLng: pos
		}, function(responses) {
			if (responses && responses.length > 0) {
				updateMarkerAddress(responses[0].formatted_address);
			} else {
				updateMarkerAddress('Cannot determine address at this location.');
			}
		});
	}

	function updateMarkerStatus(str) {
		document.getElementById('markerStatus').innerHTML = str;
	}

	function updateMarkerPosition(latLng) {
		document.getElementById('info').innerHTML = [
			latLng.lat(),
			latLng.lng()
		].join(', ');
	}

	function updateMarkerAddress(str) {
		document.getElementById('address').innerHTML = str;
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