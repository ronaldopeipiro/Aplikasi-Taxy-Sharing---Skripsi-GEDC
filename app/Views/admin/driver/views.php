<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-8" id="home" style="min-height: 97vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(<?= base_url() ?>/assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card rounded-3">
					<div class="card-body">
						<h5>
							Data Driver
						</h5>
						<hr>

						<!-- <div class="row mb-3">
							<div class="col-lg-2">
								<label for="statusVerifikasiSelect">Status Verifikasi</label>
								<div id="statusVerifikasiSelect"></div>
							</div>
							<div class="col-lg-2">
								<label for="statusAkunSelect">Status Akun</label>
								<div id="statusAkunSelect"></div>
							</div>
						</div> -->

						<div class="row">
							<div class="col-12">
								<table class="table-sm table-bordered table-hover" style="width: 100%; font-size: 12px;" id="data-table-custom">
									<thead>
										<tr class="text-center">
											<th>No.</th>
											<th>Foto</th>
											<th>Nama Driver</th>
											<th>No. Anggota</th>
											<th>No. Polisi</th>
											<th>Username</th>
											<th>Email</th>
											<th>No. Handphone</th>
											<th>Verifikasi</th>
											<th>Aktif</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$no = 1;
										$data_driver = $db->query("SELECT * FROM tb_driver ORDER BY id_driver DESC");
										?>
										<?php foreach ($data_driver->getResult('array') as $row) : ?>
											<tr>
												<td style="vertical-align: middle;" class="text-center">
													<?= $no++; ?>.
												</td>
												<td style="vertical-align: middle;">
													<img src="<?= (empty($row['foto'])) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/driver/' . $row['foto']; ?>" style="width: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%;">
												</td>
												<td style="vertical-align: middle;"><?= $row['nama_lengkap']; ?></td>
												<td style="vertical-align: middle;"><?= $row['no_anggota']; ?></td>
												<td style="vertical-align: middle;"><?= $row['nopol']; ?></td>
												<td style="vertical-align: middle;"><?= $row['username']; ?></td>
												<td style="vertical-align: middle;"><?= $row['email'] ?></td>
												<td style="vertical-align: middle;"><?= $row['no_hp'] ?></td>
												<td style="vertical-align: middle;">
													<form action="" method="POST">
														<?= csrf_field(); ?>
														<input type="hidden" name="id_driver" class="id_driver" value="<?= $row['id_driver']; ?>">
														<select name="status_akun" id="status_akun" required class="form-control-sm confirm-submit-status-akun">
															<option value="0" <?= ($row['status_akun'] == "0") ? "selected" : ""; ?>>Belum diverifikasi</option>
															<option value="1" <?= ($row['status_akun'] == "1") ? "selected" : ""; ?>>Terverifikasi</option>
															<option value="2" <?= ($row['status_akun'] == "2") ? "selected" : ""; ?>>Tidak terverifikasi</option>
														</select>
													</form>
												</td>
												<td style="vertical-align: middle;">
													<form action="" method="POST">
														<?= csrf_field(); ?>
														<input type="hidden" name="id_driver" class="id_driver" value="<?= $row['id_driver']; ?>">
														<select name="aktif" id="aktif" required class="form-control-sm confirm-submit-aktif">
															<option value="Y" <?= ($row['aktif'] == "Y") ? "selected" : ""; ?>>Aktif</option>
															<option value="N" <?= ($row['aktif'] == "N") ? "selected" : ""; ?>>Tidak Aktif</option>
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
		$('.confirm-submit-status-akun').on('change', function(e) {
			event.preventDefault(); // prevent form submit
			Swal.fire({
				title: 'Apakah anda yakin ?',
				text: "Pilih ya, jika anda ingin mengubah status verifikasi driver ini !" + status,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					var form = $(this).parents('form');
					var id_driver = form.find(':input.id_driver').val();
					var status_akun = form.find('.confirm-submit-status-akun').val();

					$.ajax({
						beforeSend: function() {
							$("#loading-image").show();
						},
						type: "POST",
						url: "<?= base_url() ?>/Admin/Driver/update_status_akun",
						dataType: "JSON",
						data: {
							id_driver: id_driver,
							status_akun: status_akun
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

		$('.confirm-submit-aktif').on('change', function(e) {
			event.preventDefault(); // prevent form submit
			Swal.fire({
				title: 'Apakah anda yakin ?',
				text: "Pilih ya, jika anda ingin mengubah status aktif driver ini !" + status,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					var form = $(this).parents('form');
					var id_driver = form.find(':input.id_driver').val();
					var aktif = form.find('.confirm-submit-aktif').val();

					$.ajax({
						beforeSend: function() {
							$("#loading-image").show();
						},
						type: "POST",
						url: "<?= base_url() ?>/Admin/Driver/update_aktif",
						dataType: "JSON",
						data: {
							id_driver: id_driver,
							aktif: aktif
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
				// var statusVerifikasi = this.api().column(8);
				// var statusVerifikasiSelect = $('<select class="filter form-control-sm"><option value="">Semua</option></select>')
				// 	.appendTo('#statusVerifikasiSelect')
				// 	.on('change', function() {
				// 		var val = $(this).val();
				// 		statusVerifikasi.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
				// 	});
				// statusVerifikasiSelect.append(`
				// 	<option value="Belum diverifikasi">Belum diverifikasi</option>
				// 	<option value="Terverifikasi">Terverifikasi</option>
				// 	<option value="Tidak terverifikasi">Tidak terverifikasi</option>
				// 	`);

				// var statusAkun = this.api().column(9);
				// var statusAkunSelect = $('<select class="filter form-control-sm"><option value="">Semua</option></select>')
				// 	.appendTo('#statusAkunSelect')
				// 	.on('change', function() {
				// 		var val = $(this).val();
				// 		statusAkun.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
				// 	});
				// statusAkunSelect.append(`
				// 	<option value="Aktif">Aktif</option>
				// 	<option value="Tidak Aktif">Tidak Aktif</option>
				// 	`);

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