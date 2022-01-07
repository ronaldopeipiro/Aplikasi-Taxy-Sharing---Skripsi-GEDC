<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/driver/pengantaran/create" class="btn btn-success" title="Tambah Data Pengantaran">
						<i class="fa fa-plus"></i>
					</a>
					<h4 class="mt-2 ml-2">
						Pengantaran
					</h4>
				</div>
				<hr>
			</div>

			<div class="col-lg-12" style="min-height: 300px;">
				<table class="table table-sm table-responsive table-responsive" id="data-table-custom" style="width: 100%;">
					<thead>
						<tr>
							<th>No.</th>
							<th>Lokasi</th>
							<th>Radius Jemput</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
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
								<td style="width: 50px;"><?= $no++; ?></td>
								<td style="width: 70%;"><?= $row['latitude']; ?>, <?= $row['longitude']; ?></td>
								<td class="text-center"><?= $row['radius_jemput']; ?> Meter</td>
								<td class="text-center">
									<span class="<?= $class_status; ?>">
										<?= $status_pengantaran; ?>
									</span>
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