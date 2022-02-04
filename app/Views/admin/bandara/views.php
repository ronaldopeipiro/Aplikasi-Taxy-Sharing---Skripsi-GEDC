<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
$class_dashboard = new App\Controllers\Admin\Dashboard;
?>

<section class="py-8" id="home" style="min-height: 97vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card rounded-3">
					<div class="card-body">
						<h5>
							Data Bandara
						</h5>
						<hr>

						<div class="row">
							<div class="col-12">
								<table class="table-sm table-bordered table-hover" style="width: 100%; font-size: 12px;" id="data-table-custom">
									<thead>
										<tr class="text-center">
											<th>No.</th>
											<th>Nama Bandara</th>
											<th>Alamat</th>
											<th>Latitude</th>
											<th>Longitude</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$no = 1;
										$data_bandara = $db->query("SELECT * FROM tb_bandara ORDER BY id_bandara DESC");
										?>
										<?php foreach ($data_bandara->getResult('array') as $row) : ?>
											<tr>
												<td style="vertical-align: middle;" class="text-center">
													<?= $no++; ?>.
												</td>
												<td style="vertical-align: middle;"><?= $row['nama_bandara']; ?></td>
												<td style="vertical-align: middle;"><?= $row['alamat']; ?></td>
												<td style="vertical-align: middle;"><?= $row['latitude'] ?></td>
												<td style="vertical-align: middle;"><?= $row['longitude'] ?></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>

					</div>
				</div>
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
				var statusVerifikasi = this.api().column(8);
				var statusVerifikasiSelect = $('<select class="filter form-control-sm"><option value="">Semua</option></select>')
					.appendTo('#statusVerifikasiSelect')
					.on('change', function() {
						var val = $(this).val();
						statusVerifikasi.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				statusVerifikasiSelect.append(`
					<option value="Belum diverifikasi">Belum diverifikasi</option>
					<option value="Terverifikasi">Terverifikasi</option>
					<option value="Tidak terverifikasi">Tidak terverifikasi</option>
					`);

				var statusAkun = this.api().column(9);
				var statusAkunSelect = $('<select class="filter form-control-sm"><option value="">Semua</option></select>')
					.appendTo('#statusAkunSelect')
					.on('change', function() {
						var val = $(this).val();
						statusAkun.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				statusAkunSelect.append(`
					<option value="Aktif">Aktif</option>
					<option value="Tidak Aktif">Tidak Aktif</option>
					`);

				// var status = this.api().column(4);
				// var statusSelect = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
				// 	.appendTo('#statusSelect')
				// 	.on('change', function() {
				// 		var val = $(this).val();
				// 		status.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
				// 	});
				// status.data().unique().sort().each(function(d, j) {
				// 	statusSelect.append('<option value="' + d + '">' + d + '</option>');
				// });

			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
		});
	});
</script>

<?= $this->endSection('content'); ?>