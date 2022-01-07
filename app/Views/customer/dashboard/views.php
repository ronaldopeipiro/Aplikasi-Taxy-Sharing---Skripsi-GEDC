<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">
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
				Ingin menuju bandara ? <br>
				<a href="" class="btn btn-success mt-2">
					<i class="fa fa-arrow-right"></i> Order TAXI
				</a>
			</div>

		</div>
	</div>
</section>

<section class="py-0">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-12 text-center">
				<h3 class="font-weight-bold">
					Lokasi Driver
				</h3>
				<p>
					( Lokasi driver aktif dalam redius sekitar anda )
				</p>
				<div id="alamat_saya"></div>
				<hr>
			</div>
			<div class="col-12 p-0">
				<div id="peta"></div>
			</div>
		</div>
	</div>

</section>

<script>
	function writeAddressName(latLng) {
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({
				"location": latLng
			},
			function(results, status) {
				if (status == google.maps.GeocoderStatus.OK)
					document.getElementById("alamat_saya").value = results[0].formatted_address;
				else
					document.getElementById("alamat_saya").innerHTML += "Unable to retrieve your address" + "<br />";
			});
	}

	function initMap() {
		var map;
		var userLoc;
		var gmarkers = [];
		var marker, i, marker_semua, marker_dokter, marker_tempat_praktik, marker_optik;
		var lineMarkers = [];
		var lingkar = [];
		var circle_user;
		var id_kategori;

		var rad = 1000;

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
						visibility: "on"
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

				map = new google.maps.Map(document.getElementById('peta'), mapOptions);
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
					url: "<?= base_url() ?>/assets/img/marker-red.png", // url
					scaledSize: new google.maps.Size(28, 36), // scaled size
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

				var circle_user = new google.maps.Circle({
					strokeColor: '#000AAA',
					strokeOpacity: 0.5,
					strokeWeight: 2,
					fillColor: '#00AEFF',
					fillOpacity: 0.1,
					map: map,
					radius: rad
				});

				circle_user.bindTo('center', centerLoc, 'position');
				circle_user.setRadius(parseFloat(rad));
				tampilTitik(rad, 'semua');
			}, function() {
				handleLocationError(true, centerLoc, map.getCenter());
			}, positionOptions);

			function tampilTitik(radius, id_kategori) {
				if (marker) {
					marker.setMap(null);
					marker = "";
				}

				// hapus marker
				for (i = 0; i < gmarkers.length; i++) {
					if (gmarkers[i].getMap() != null) gmarkers[i].setMap(null);
				}
				// Akhir hapus marker

				// directionsDisplay.setDirections(response);
				var arrayDriver = [
					<?php
					foreach ($driver_aktif as $data) {
						$id_driver = $data["id_driver"];
						$nama_lengkap = $data["nama_lengkap"];
						$latitude = $data["latitude"];
						$longitude = $data["longitude"];
						echo "
						{
                            id_driver: '" . $id_driver . "',
                            nama_lengkap: '" . $nama_lengkap . "',
                            latitude: '" . $latitude . "',
                            longitude: '" . $longitude . "'
                        },
                        ";
					}
					?>
				];

				for (i = 0; i < arrayDriver.length; i++) {
					let latitude = arrayDriver[i].lat;
					let longitude = arrayDriver[i].lng;
					let posisiMarker = new google.maps.LatLng(latitude, longitude);
					let id_driver = arrayDriver[i].id_driver;
					let nama_lengkap = arrayDriver[i].nama_lengkap;
					stuDistances = calculateDistances(userLoc, posisiMarker);

					// if (stuDistances.metres <= radius) {
					var icon_tempat_praktik = {
						url: "<?= base_url() ?>/assets/img/taxi-marker.png", // url
						scaledSize: new google.maps.Size(28, 36), // scaled size
						origin: new google.maps.Point(0, 0), // origin
						anchor: new google.maps.Point(14, 18) // anchor
					};
					var marker_tempat_praktik = new google.maps.Marker({
						position: posisiMarker,
						map: map,
						icon: icon_tempat_praktik
					});
					google.maps.event.addListener(marker_tempat_praktik, 'click', (function(marker_tempat_praktik, i) {
						return function() {
							var distinationOrigin = userLoc;
							var destinationMarker = posisiMarker;
							infoWindow.setContent(`
                                    <div style="width: 100%; text-align: center;">
                                        <h4>${nama_lengkap}</h4>
                                    </div>
                                    <br>
                                    <div class="row justify-content-center">
                                        <a href="${id_driver}" class="badge badge-success p-2">
                                            <i class="fa fa-eye"></i> Lihat Dokter
                                        </a>
                                    </div>
                                    <table class="table-sm table-borderless mt-5">
                                        <tr style="text-align: left;">
                                            <td>Latitude</td>
                                            <td>:</td>
                                            <td style="width: 50%;">${latitude}</td>
                                        </tr> 
                                        <tr style="text-align: left;">
                                            <td>Longitude</td>
                                            <td>:</td>
                                            <td style="width: 50%;">${longitude}</td>
                                        </tr>
									</table>
									`);
							calculateAndDisplayRoute(directionsService, directionsDisplay, distinationOrigin, destinationMarker, infoWindow, id_driver);
							infoWindow.open(map, marker_tempat_praktik);
						}
					})(marker_tempat_praktik, i));
					// }
					gmarkers.push(marker_tempat_praktik);
				}
			}

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

<?= $this->endSection('content'); ?>