<?= $this->extend('layout/template-landing'); ?>

<?= $this->section('content_landing'); ?>

<section class="py-0" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">
		<div class="row justify-content-center align-items-center min-vh-100 min-vh-md-100">

			<div class="col-md-6 col-lg-5 py-4 text-center">
				<div class="card">
					<div class="card-body">
						<h4 class="mt-4">
							Airport Taxi Sharing
						</h4>
						<div class="mt-4">
							<img src="<?= base_url(); ?>/assets/img/alert.png" style="height: 40px;">
						</div>
						<div>
							<img src="<?= base_url(); ?>/assets/img/offline-logo.png" style="height: 100px;">
						</div>
						<p class="my-4">
							Kehilangan jaringan internet !
						</p>
						<a href="<?= base_url(); ?>" class="btn btn-dark">
							<i class="fas fa-sync"></i>
							Muat Ulang
						</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<?= $this->endSection('content_landing'); ?>