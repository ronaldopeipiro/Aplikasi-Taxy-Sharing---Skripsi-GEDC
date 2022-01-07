<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">
		<div class="row align-items-center pt-3 pt-lg-0">

			<div class="col-lg-8">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title">
							<i class="fa fa-user"></i> Data Diri
						</h5>
					</div>
					<div class="card-body">
						<form action="" method="POST" enctype="multipart/form-data">

						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-3 text-center">
				<img src="<?= (empty($user_foto)) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/driver/' . $user_foto; ?>" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: solid 2px #fff; padding: 2px; object-position: top;">
				<p>
					<?= $user_nopol; ?>
				</p>
			</div>

			<div class="col-lg-8 text-sm-start text-center">
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
				<a href="<?= base_url(); ?>/driver/orderan" class="btn btn-outline-success mt-2 mr-2">
					<i class="fa fa-arrow-right"></i> Orderan Masuk
				</a>
				<a href="<?= base_url(); ?>/driver/pengantaran" class="btn btn-outline-info mt-2">
					<i class="fa fa-arrow-right"></i> Pengantaran
				</a>
			</div>

		</div>
	</div>
</section>

<section class="py-0">
	<div class="container-fluid">
		<div class="row justify-content-center">

		</div>
	</div>

</section>


<?= $this->endSection('content'); ?>