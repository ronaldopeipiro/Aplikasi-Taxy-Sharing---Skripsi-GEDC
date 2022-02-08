<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php
$class_dashboard = new App\Controllers\Driver\Dashboard;

?>

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

					<?php if (($jml_pengantaran_diproses == '0')) : ?>
						<a href="<?= base_url(); ?>/driver/pengantaran/create" class="btn btn-success" title="Tambah Data Pengantaran">
							<i class="fa fa-plus"></i> Tambah
						</a>
					<?php endif; ?>
				</div>
				<hr>
			</div>

			<div class="col-lg-12" style="min-height: 60vh;">
				<div class="row mb-3">
					<div class="col-lg-3">
						<div id="statusSelect"></div>
					</div>
				</div>

				<div class="">
					<table class="table table-sm table-hover table-bordered table-striped" id="data-table-custom" style="font-size: 12px; display: block;">
						<thead>
							<tr>
								<th>No.</th>
								<th>Bandara</th>
								<th>Lokasi Pengantaran</th>
								<th>Koordinat Pengantaran</th>
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
								$id_bandara = $row['id_bandara'];
								$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'"))->getRow();

								$id_pengantaran = $row['id_pengantaran'];
								$jumlah_orderan_masuk = ($db->query("SELECT * FROM tb_order WHERE id_pengantaran = '$id_pengantaran' "))->getNumRows();

								if ($row['status_pengantaran'] == "0") {
									$status_pengantaran = "Dalam Perjalanan";
									$class_status = "bg bg-warning text-white";
								} elseif ($row['status_pengantaran'] == "1") {
									$status_pengantaran = "Selesai";
									$class_status = "bg bg-success text-white";
								} elseif ($row['status_pengantaran'] == "2") {
									$status_pengantaran = "Tidak Selesai";
									$class_status = "bg bg-danger text-white";
								}
								?>

								<tr>
									<td style="width: 50px; vertical-align: middle;" class="text-center"><?= $no++; ?>.</td>
									<td style="width: 250px; vertical-align: middle;">
										<?= $bandara->nama_bandara; ?>
									</td>
									<td style="width: 300px; vertical-align: middle;">
										<?= $class_dashboard->getAddress($row['latitude'], $row['longitude']); ?>
									</td>
									<td style="width: 20%; vertical-align: middle;">
										<a href="https://google.co.id/maps?q=<?= $row['latitude'] . ',' . $row['longitude']; ?>" target="_blank">
											<?= $row['latitude'] . ', ' . $row['longitude']; ?>
										</a>
									</td>
									<td class="text-left" style="vertical-align: middle;">
										<?= $row['radius_jemput']; ?> Meter
									</td>
									<td class="text-left <?= $class_status; ?>" style="vertical-align: middle;">
										<?= $status_pengantaran; ?>
									</td>
									<td style="vertical-align: middle;">
										<?php if (($row['status_pengantaran'] == "0") and ($jumlah_orderan_masuk == 0)) : ?>
											<form action="<?= base_url(); ?>/Driver/Pengantaran/cancel_pengantaran" method="post" style="width: 100%;">
												<input type="hidden" name="id_pengantaran" value="<?= $row['id_pengantaran']; ?>">
												<input type="hidden" name="status" value="2">
												<button type="submit" class="btn btn-sm btn-block btn-danger btn-cancel-confirm-pengantaran">
													<i class="fa fa-times"></i> Batalkan
												</button>
											</form>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
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
				var status = this.api().column(5);
				var statusSelect = $('<select class="filter form-control-sm"><option value="">Semua Status</option></select>')
					.appendTo('#statusSelect')
					.on('change', function() {
						var val = $(this).val();
						status.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				statusSelect.append(`
					<option value="Dalam Perjalanan">Dalam Perjalanan</option>
					<option value="Selesai">Selesai</option>
					<option value="Tidak Selesai">Tidak Selesai</option>
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