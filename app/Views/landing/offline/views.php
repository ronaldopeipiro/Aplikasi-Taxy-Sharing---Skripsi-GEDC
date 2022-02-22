<?= $this->extend('layout/template-landing'); ?>

<?= $this->section('content_landing'); ?>

<section class="py-0" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">
		<div class="row align-items-center min-vh-75 min-vh-md-100">

			<div class="col-md-6 col-lg-5 py-4 text-sm-start text-center">
				<h1 class="mt-2 mb-sm-4 display-2 fw-semi-bold lh-sm fs-5 fs-lg-8 fs-xxl-8">
					TAXI <br class="d-block d-lg-none d-xl-block" />
					<span style="color: brown;">SHARING</span>
				</h1>
				<p class="mb-4">
					Temukan kemudahan perjalanan anda menuju bandara sekitar anda disini !
				</p>
				<div class="pt-2">
					<p class="fw-semi-bold">
						Masuk sebagai ?
					</p>
					<a href="<?= base_url(); ?>/customer" class="btn btn-success mr-2" style="width: 160px;">
						<i class="fa fa-users"></i> Customer
					</a>
					<a href="<?= base_url(); ?>/driver" class="btn btn-info" style="width: 160px;">
						<i class="fa fa-users"></i> Driver
					</a>
				</div>
			</div>

		</div>
	</div>
</section>

<?= $this->endSection('content_landing'); ?>