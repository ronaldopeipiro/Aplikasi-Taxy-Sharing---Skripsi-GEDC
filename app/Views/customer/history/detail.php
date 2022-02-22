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

					<div class="col-lg-8 mb-3 mb-lg-0">
						<div class="card">
							<div class="card-body">
								<h5>
									Detail Order
								</h5>
								<table class="table table-sm table-borderless table-responsive mt-5" style="font-size: 14px;">
									<tr>
										<td>Tanggal Order</td>
										<td>:</td>
										<td>
											<?= strftime("%d/%m/%Y", strtotime($orderan->create_datetime)); ?>
										</td>
									</tr>
									<tr>
										<td>Waktu Order</td>
										<td>:</td>
										<td>
											<?= strftime("%H:%M:%S WIB", strtotime($orderan->create_datetime)); ?>
										</td>
									</tr>
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

	</div>
</section>

<?= $this->endSection('content'); ?>