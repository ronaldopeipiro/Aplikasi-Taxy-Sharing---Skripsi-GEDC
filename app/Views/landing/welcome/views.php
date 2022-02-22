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

			<div class="col-md-6 col-lg-7 py-3 text-sm-start text-center">
				<img src="assets/img/bg-landing.jpg" style="width: 100%;" alt="">
			</div>

		</div>
	</div>
</section>

<section class="py-5">

	<!--/.bg-holder-->

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-lg-12 text-center mb-3">
				<h5 class="fw-bold fs-3 fs-lg-5 lh-sm mb-3">Manfaat Bergabung</h5>
				<p class="mb-5">Manfaat yang anda dapatkan ketika anda bergabung bersama layanan Taxy Sharing</p>
			</div>
		</div>

		<div class="row flex-center">
			<div class="col-12 col-xl-11">
				<h4 style="margin-left: 15px;">Sebagai Driver</h4>
				<hr>
			</div>
		</div>
		<div class="row flex-center h-100">
			<div class="col-12 col-xl-11">
				<div class="row">
					<div class="col-sm-6 col-lg-4 pb-lg-6 px-lg-4 pb-4">
						<div class="card py-4 shadow-sm h-100 hover-top">
							<div class="text-center">
								<img src="assets/img/illustrations/finance.png" height="120" alt="" />
								<div class="card-body px-2">
									<h6 class="fw-bold fs-1 heading-color">Menambah Pendapatan</h6>
									<p class="mb-0 card-text">Anda dapat memaksimalkan keuntungan anda ketika antar jemput penumpang</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-4 pb-lg-6 px-lg-4 pb-4">
						<div class="card py-4 shadow-sm h-100 hover-top">
							<div class="text-center"> <img src="assets/img/illustrations/design.png" height="120" alt="" />
								<div class="card-body px-2">
									<h6 class="fw-bold fs-1 heading-color">Efisiensi</h6>
									<p class="mb-0 card-text">
										Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, recusandae similique?
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-4 pb-lg-6 px-lg-4 pb-4">
						<div class="card py-4 shadow-sm h-100 hover-top">
							<div class="text-center"> <img src="assets/img/illustrations/programmer.png" height="120" alt="" />
								<div class="card-body px-2">
									<h6 class="fw-bold fs-1 heading-color">Perluasan jangkauan pelanggan</h6>
									<p class="mb-0 card-text">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit praesentium iste nihil tempora nisi!</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row flex-center">
			<div class="col-12 col-xl-11">
				<h4 style="margin-left: 15px;">Sebagai Penumpang</h4>
				<hr>
			</div>
		</div>
		<div class="row flex-center h-100">
			<div class="col-12 col-xl-11">
				<div class="row">
					<div class="col-sm-6 col-lg-4 pb-lg-6 px-lg-4 pb-4">
						<div class="card py-4 shadow-sm h-100 hover-top">
							<div class="text-center">
								<img src="assets/img/illustrations/finance.png" height="120" alt="" />
								<div class="card-body px-2">
									<h6 class="fw-bold fs-1 heading-color">Efisiensi</h6>
									<p class="mb-0 card-text">Anda dapat menghemat waktu serta biaya perjalanan anda menuju bandara</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-4 pb-lg-6 px-lg-4 pb-4">
						<div class="card py-4 shadow-sm h-100 hover-top">
							<div class="text-center"> <img src="assets/img/illustrations/design.png" height="120" alt="" />
								<div class="card-body px-2">
									<h6 class="fw-bold fs-1 heading-color">Terpercaya</h6>
									<p class="mb-0 card-text">
										Driver taxy merupakan driver taxy bandara yang resmi beroperasi di bandara sekitar anda
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-lg-4 pb-lg-6 px-lg-4 pb-4">
						<div class="card py-4 shadow-sm h-100 hover-top">
							<div class="text-center"> <img src="assets/img/illustrations/programmer.png" height="120" alt="" />
								<div class="card-body px-2">
									<h6 class="fw-bold fs-1 heading-color">Kemudahan</h6>
									<p class="mb-0 card-text">
										Lebih mudah dan cepat untuk mendapatkan tumpangan menuju bandara
									</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</section>


<!-- ============================================-->
<!-- <section> begin ============================-->
<section class="py-8">

	<div class="container">
		<div class="row flex-center">
			<div class="col-md-6 order-md-1 text-center text-md-end">
				<img class="img-fluid mb-4 w-100" src="assets/img/landing-bg.jpg" alt="" />
			</div>
			<div class="col-md-5 text-center text-md-start">
				<h1 style="font-size: 65px;">
					Lebih dari
				</h1>
				<h6 class="fw-bold fs-2 fs-lg-3 display-3 lh-sm">
					100 driver taxy & ribuan customer telah bergabung bersama kami
				</h6>
				<p class="my-4 text-justify">
					Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus culpa adipisci vero minus, sint consectetur incidunt esse odit nam similique magni molestias ut dolor fugit laboriosam eveniet. Nihil, modi numquam.
				</p>
			</div>
		</div>
	</div>
	<!-- end of .container-->

</section>
<!-- <section> close ============================-->
<!-- ============================================-->

<!-- <section class="py-8">
	<div class="container-lg">
		<div class="row flex-center">
			<div class="col-md-11 col-lg-6 col-xl-4 col-xxl-5">
				<h6 class="fs-3 fs-lg-4 lh-sm">Testimoni Pelanggan</h6>
			</div>
			<div class="col-lg-4 position-relative mt-n5 mt-md-n4"><a class="carousel-control-prev carousel-icon z-index-2" href="#carouselExampleDark" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next carousel-icon z-index-2" href="#carouselExampleDark" role="button" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></a></div>
		</div>

		<div class="row flex-center">
			<div class="col-xl-11 px-0">
				<div class="carousel slide pt-6" id="carouselExampleDark" data-bs-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active" data-bs-interval="10000">
							<div class="row h-100 m-lg-7 mx-3 mt-6 mx-md-4 my-md-7">
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-1.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-2.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-3.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="carousel-item" data-bs-interval="2000">
							<div class="row h-100 m-lg-7 mx-3 mt-6 mx-md-4 my-md-7">
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-1.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-2.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-3.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="carousel-item">
							<div class="row h-100 m-lg-7 mx-3 mt-6 mx-md-4 my-md-7">
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-1.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-2.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-8 mb-md-0">
									<div class="card card-span h-100 shadow-lg">
										<div class="card-span-img"><img src="assets/img/gallery/user-3.png" alt="" /></div>
										<div class="card-body d-flex flex-column flex-center py-6">
											<div class="my-4">
												<ul class="list-unstyled list-inline">
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
														</svg>
													</li>
													<li class="list-inline-item me-0">
														<svg class="bi bi-star-fill" xmlns="http://www.w3.org/2000/svg" width="28" height="26" fill="#FF974D" viewBox="0 0 16 16">
															<path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"> </path>
														</svg>
													</li>
												</ul>
											</div>
											<p class="card-text text-left text-1000 px-2">Saya sangat puas, layanan dari aplikasi taxy sharing ini sangat membantu sebagai driver maupun penumpang</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->


<?= $this->endSection('content_landing'); ?>