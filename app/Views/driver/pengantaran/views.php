<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center justify-content-between">
					<h4 class="mt-2">
						Pengantaran
					</h4>
					<?php if ($jml_pengantaran_diproses == 0) : ?>
						<a href="<?= base_url(); ?>/driver/pengantaran/create" class="btn btn-success" title="Tambah Data Pengantaran">
							<i class="fa fa-plus"></i> Tambah
						</a>
					<?php endif; ?>
				</div>
				<hr>
			</div>

			<div class="col-lg-12" style="min-height: 300px;">
				<table class="table table-responsive table-bordered" id="data-table-custom" style="width: 100%;">
					<thead>
						<tr>
							<th>No.</th>
							<th>Lokasi</th>
							<th>Koordinat</th>
							<th>Radius Jemput</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$class_dashboard = new App\Controllers\Driver\Dashboard;
						?>
						<?php foreach ($pengantaran as $row) : ?>
							<?php
							if ($row['status_pengantaran'] == "0") {
								$status_pengantaran = "Dalam Perjalanan";
								$class_status = "badge badge-warning";
							} elseif ($row['status_pengantaran']) {
								$status_pengantaran = "Selesai";
								$class_status = "badge badge-success";
							}
							?>
							<tr>
								<td style="width: 50px; vertical-align: middle;" class="text-center"><?= $no++; ?>.</td>
								<td style="width: 30%; vertical-align: middle;">
									<?= $class_dashboard->getAddress($row['latitude'], $row['longitude']); ?>
								</td>
								<td style="width: 30%; vertical-align: middle;">
									<a href="https://google.co.id/maps?q=<?= $row['latitude'] . ',' . $row['longitude']; ?>" target="_blank">
										<?= $row['latitude'] . ', ' . $row['longitude']; ?>
									</a>
								</td>
								<td class="text-left" style="vertical-align: middle;"><?= $row['radius_jemput']; ?> Meter</td>
								<td class="text-left" style="vertical-align: middle;">
									<span class="<?= $class_status; ?>">
										<?= $status_pengantaran; ?>
									</span>
								</td>
								<td style="vertical-align: middle;">
									<div class="list-unstyled d-flex justify-content-center align-items-center">
										<li class="mr-2">
											<a href="#" class="btn btn-warning">
												<i class="fa fa-edit"></i>
											</a>
										</li>
										<li>
											<a href="#" class="btn btn-danger">
												<i class="fa fa-trash"></i>
											</a>
										</li>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

			</div>
		</div>

	</div>
</section>



<script>
	$(document).ready(function() {
		var datetime = new Date();
		var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

		var tabel_user = $('#data-table-custom').DataTable({
			"paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			"initComplete": function() {
				var semester = this.api().column(4);
				var selectSemester = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
					.appendTo('#selectSemester')
					.on('change', function() {
						var val = $(this).val();
						semester.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				semester.data().unique().sort().each(function(d, j) {
					selectSemester.append('<option value="' + d + '">' + d + '</option>');
				});

				var angkatan = this.api().column(3);
				var selectAngkatan = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
					.appendTo('#selectAngkatan')
					.on('change', function() {
						var val = $(this).val();
						angkatan.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				angkatan.data().unique().sort().each(function(d, j) {
					selectAngkatan.append('<option value="' + d + '">' + d + '</option>');
				});
			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
		});
	});
</script>

<?= $this->endSection('content'); ?>