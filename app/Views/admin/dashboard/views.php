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

$jumlah_driver = $db->query("SELECT * FROM tb_driver")->getNumRows();
$jumlah_driver_aktif = $db->query("SELECT * FROM tb_driver WHERE aktif='Y' ")->getNumRows();

$jumlah_customer = $db->query("SELECT * FROM tb_customer")->getNumRows();
$jumlah_customer_aktif = $db->query("SELECT * FROM tb_customer WHERE status='1' ")->getNumRows();

$jumlah_bandara = $db->query("SELECT * FROM tb_bandara")->getNumRows();
$jumlah_bandara_aktif = $db->query("SELECT * FROM tb_bandara WHERE status='1' ")->getNumRows();
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
				<a href="<?= base_url(); ?>/admin/driver">
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
				<a href="<?= base_url(); ?>/admin/customer">
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
				<a href="<?= base_url(); ?>/admin/bandara">
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

	</div>

</section>


<?= $this->endSection('content'); ?>