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
?>

<section class="py-8" id="home">

	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/driver/history" class="btn btn-dark">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-2">
						Detail Orderan
					</h4>
				</div>
				<hr>
			</div>
		</div>

		<?php
		$id_customer = $data_orderan['id_customer'];
		$customer = ($db->query("SELECT * FROM tb_customer WHERE id_customer='$id_customer'"))->getRow();

		$id_pengantaran = $data_orderan['id_pengantaran'];
		$pengantaran = ($db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' LIMIT 1"))->getRow();

		$id_bandara = $pengantaran->id_bandara;
		$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'"))->getRow();

		if ($data_orderan['status'] == "0") {
			$class_text_status = "badge badge-warning";
			$text_status = "Proses (Menunggu konfirmasi)";
		} else if ($data_orderan['status'] == "1") {
			$class_text_status = "badge badge-info";
			$text_status = "Orderan diterima";
		} else if ($data_orderan['status'] == "2") {
			$class_text_status = "badge badge-info";
			$text_status = "Menjemput customer";
		} else if ($data_orderan['status'] == "3") {
			$class_text_status = "badge badge-primary";
			$text_status = "Dalam perjalanan menuju bandara";
		} else if ($data_orderan['status'] == "4") {
			$class_text_status = "badge badge-success";
			$text_status = "Selesai";
		} else if ($data_orderan['status'] == "5") {
			$class_text_status = "badge badge-danger";
			$text_status = "Orderan dibatalkan oleh customer";
		} else if ($data_orderan['status'] == "6") {
			$class_text_status = "badge badge-dark";
			$text_status = "Orderan ditolak oleh anda";
		}
		?>
		<div class="row justify-content-center">
			<div class="col-lg-8 mb-3">
				<div class="card">
					<div class="card-body">
						<h5>Data Orderan</h5>
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
								<?= $class_dashboard->getAddress($data_orderan['latitude'], $data_orderan['longitude']); ?>
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
								<?= $data_orderan['jarak_customer_to_bandara']; ?> Km
							</span>
						</div>
						<div class="mt-3">
							<span class="d-block">
								Tarif
								<span style="font-size: 30px; font-weight: bold;">
									<?= rupiah($data_orderan['biaya'], "Y"); ?>
								</span>
							</span>
							<span class="d-block font-weight-bold">
								<small>
									<?= rupiah($data_orderan['tarif_perkm'], "Y"); ?> / Km
								</small>
							</span>
						</div>

						<div class="mt-3 d-flex justify-content-between">

							<?php if ($data_orderan['status'] == "0") : ?>

								<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 50%">
									<input type="hidden" name="id_order" value="<?= $data_orderan['id_order']; ?>">
									<input type="hidden" name="status" value="1">
									<button type="submit" class="btn btn-block btn-success btn-terima-order" style="width: 100%;">
										<i class="fa fa-check"></i> Terima
									</button>
								</form>

								<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 50%;">
									<input type="hidden" name="id_order" value="<?= $data_orderan['id_order']; ?>">
									<input type="hidden" name="status" value="6">
									<button type="submit" class="btn btn-block btn-danger btn-tolak-order" style="width: 100%;">
										<i class="fa fa-times"></i> Tolak
									</button>
								</form>

							<?php elseif ($data_orderan['status'] == "1") : ?>

								<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 100%;">
									<input type="hidden" name="id_order" value="<?= $data_orderan['id_order']; ?>">
									<input type="hidden" name="status" value="2">
									<button type="submit" class="btn btn-block btn-info btn-confirm-jemput-customer" style="width: 100%;">
										<i class="fa fa-car"></i> Jemput Customer
									</button>
								</form>


							<?php elseif ($data_orderan['status'] == "2") : ?>

								<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 100%;">
									<input type="hidden" name="id_order" value="<?= $data_orderan['id_order']; ?>">
									<input type="hidden" name="status" value="3">
									<button type="submit" class="btn btn-block btn-primary btn-confirm-otw-bandara">
										<i class="fa fa-car"></i> Menuju Bandara
									</button>
								</form>

							<?php elseif ($data_orderan['status'] == "3") : ?>

								<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 100%;">
									<input type="hidden" name="id_order" value="<?= $data_orderan['id_order']; ?>">
									<input type="hidden" name="status" value="4">
									<button type="submit" class="btn btn-block btn-success btn-confirm-selesai-order" style="width: 100%;">
										<i class="fa fa-check"></i> Selesai
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
</section>

<?= $this->endSection('content'); ?>