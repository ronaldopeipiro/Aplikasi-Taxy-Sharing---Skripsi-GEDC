<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
$class_dashboard = new App\Controllers\Admin\Dashboard;
?>

<section class="py-8" id="home" style="min-height: 97vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(<?= base_url() ?>/assets/img/illustrations/category-bg.png); background-position:right top; background-size:200px 320px;">
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
											<?php
											$foto_customer = "";
											if ($row['foto'] != "") {
												if (strpos($row['foto'], ':') !== false) {
													$foto_customer = $row['foto'];
												} else {
													$foto_customer = base_url() . '/assets/img/customer/' . $row['foto'];
												}
											} else {
												$foto_customer = base_url() . '/assets/img/noimg.png';
											}
											?>
											<tr>
												<td style="vertical-align: middle;" class="text-center">
													<?= $no++; ?>.
												</td>
												<td style="vertical-align: middle;">
													<img src="<?= $foto_customer; ?>" style="width: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%;">
												</td>
												<td style="vertical-align: middle;"><?= $row['nama_lengkap']; ?></td>
												<td style="vertical-align: middle;"><?= $row['username']; ?></td>
												<td style="vertical-align: middle;"><?= $row['email'] ?></td>
												<td style="vertical-align: middle;"><?= $row['no_hp'] ?></td>
												<td style="vertical-align: middle;">
													<?php if ($row['latitude'] != "" and $row['longitude'] != "") : ?>
														<?= $class_dashboard->getAddress($row['latitude'], $row['longitude']); ?>
													<?php endif; ?>
												</td>
												<td style="vertical-align: middle;">
													<form action="" method="POST">
														<?= csrf_field(); ?>
														<input type="hidden" name="id_customer" class="id_customer" value="<?= $row['id_customer']; ?>">
														<select name="status" id="status" required class="form-control-sm confirm-submit-status">
															<option value="1" <?= ($row['status'] == "1") ? "selected" : ""; ?>>Aktif</option>
															<option value="0" <?= ($row['status'] == "0") ? "selected" : ""; ?>>Tidak Aktif</option>
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
		$('.confirm-submit-status').on('change', function(e) {
			event.preventDefault(); // prevent form submit
			Swal.fire({
				title: 'Apakah anda yakin ?',
				text: "Pilih ya, jika anda ingin mengubah status customer ini !" + status,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					var form = $(this).parents('form');
					var id_customer = form.find(':input.id_customer').val();
					var status = form.find('.confirm-submit-status').val();

					$.ajax({
						beforeSend: function() {
							$("#loading-image").show();
						},
						type: "POST",
						url: "<?= base_url() ?>/Admin/Customer/update_status",
						dataType: "JSON",
						data: {
							id_customer: id_customer,
							status: status
						},
						success: function(data) {
							if (data.success == "1") {
								Swal.fire(
									'Berhasil',
									data.pesan,
									'success'
								)
							} else if (data.success == "0") {
								Swal.fire(
									'Gagal',
									data.pesan,
									'error'
								)
							}
						},
						complete: function(data) {
							$("#loading-image").hide();
						}
					});
				}
			});
		});

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