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


$data_orderan_belum_selesai = $db->query("SELECT * FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE tb_pengantaran.id_driver = '$user_id' AND tb_order.status <= 4");
$jumlah_orderan_masuk_belum_selesai =  $data_orderan_belum_selesai->getNumRows();

$class_dashboard = new App\Controllers\Driver\Dashboard;
?>

<section class="py-8" id="home">

	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">

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

							<?php if ($r_orderan->status == "3") : ?>

							<?php endif; ?>

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
											<span class="d-block font-weight-bold">
												<small>
													<?= rupiah($r_orderan->tarif_perkm, "Y"); ?> / Km
												</small>
											</span>
										</div>

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

												<form action="<?= base_url(); ?>/Driver/Orderan/update_status_order" method="post" style="width: 100%;">
													<input type="hidden" name="id_order" value="<?= $r_orderan->id_order; ?>">
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
				</div>
			<?php endif; ?>


		<?php else : ?>

			<div class="row justify-content-center">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="alert alert-info">
								<div class="row justify-content-center align-items-center" style="min-height: 50vh;">
									<h5 class="text-center">
										Anda belum memiliki aktifitas orderan masuk baru !
									</h5>

									<div class="row justify-content-center">
										<div class="col-lg-3 text-center">
											<a href="<?= base_url(); ?>/driver" class="btn btn-outline-dark">
												<i class="fa fa-home"></i> Kembali ke Beranda
											</a>
										</div>
										<div class="col-lg-3 text-center">
											<a href="<?= base_url(); ?>/driver/pengantaran/create" class="btn btn-outline-success">
												<i class="fa fa-car"></i> Tambah Pengantaran
											</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?= $this->endSection('content'); ?>