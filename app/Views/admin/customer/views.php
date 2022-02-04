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
							Data Customer
						</h5>
						<hr>

						<div class="row mb-3">
							<div class="col-lg-2">
								<label for="statusAkunSelect">Status Akun</label>
								<div id="statusAkunSelect"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-12">
								<table class="table-sm table-bordered table-hover" style="width: 100%; font-size: 12px;" id="data-table-custom">
									<thead>
										<tr class="text-center">
											<th>No.</th>
											<th>Foto</th>
											<th>Nama Lengkap</th>
											<th>Username</th>
											<th>Email</th>
											<th>No. Handphone</th>
											<th>Lokasi Terkini</th>
											<th>Aktif</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$no = 1;
										$data_customer = $db->query("SELECT * FROM tb_customer ORDER BY id_customer DESC");
										?>
										<?php foreach ($data_customer->getResult('array') as $row) : ?>
											<tr>
												<td style="vertical-align: middle;" class="text-center">
													<?= $no++; ?>.
												</td>
												<td style="vertical-align: middle;">
													<img src="<?= (empty($row['foto'])) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/customer/' . $row['foto']; ?>" style="width: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%;">
												</td>
												<td style="vertical-align: middle;"><?= $row['nama_lengkap']; ?></td>
												<td style="vertical-align: middle;"><?= $row['username']; ?></td>
												<td style="vertical-align: middle;"><?= $row['email'] ?></td>
												<td style="vertical-align: middle;"><?= $row['no_hp'] ?></td>
												<td style="vertical-align: middle;">
													<?= $class_dashboard->getAddress($row['latitude'], $row['longitude']); ?>
												</td>
												<td style="vertical-align: middle;">
													<form action="" method="POST">
														<?= csrf_field(); ?>
														<select name="aktif" id="aktif" required class="form-control-sm" onchange="this.form.submit()">
															<option value="Y">Aktif</option>
															<option value="N">Tidak Aktif</option>
														</select>
													</form>
												</td>
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