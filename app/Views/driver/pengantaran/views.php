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
					<div class="d-flex align-items-center">
						<a href="<?= base_url(); ?>/driver" class="btn btn-dark" title="Tambah Data Pengantaran">
							<i class="fa fa-arrow-left"></i>
						</a>
						<h4 class="mt-2 ml-2">
							Pengantaran
						</h4>
					</div>

					<?php if (($jml_pengantaran_diproses == '0')) : ?>
						<a href="<?= base_url(); ?>/driver/pengantaran/create" class="btn btn-success" title="Tambah Data Pengantaran">
							<i class="fa fa-plus"></i> Tambah
						</a>
					<?php endif; ?>
				</div>
				<hr>
			</div>

			<div class="col-lg-12" style="min-height: 60vh;">
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="tanggalOrderSelect">Tanggal Pengantaran</label>
							<div class="cariTanggalPengantaran">
								<div class="input-group date">
									<span class="input-group-append">
										<span class="input-group-text bg-light d-block">
											<i class="fa fa-calendar"></i>
										</span>
									</span>
									<input type="text" class="form-control form-control-lg pull-right" id="cariTanggalPengantaran" placeholder="Contoh : 01/01/2022 - 12/12/2022">
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 mb-3">
						<label for="statusSelect">Status</label>
						<div id="statusSelect"></div>
					</div>

					<div class="col-lg-3 mb-3">
						<label for="orderanSelect">Orderan</label>
						<div id="orderanSelect"></div>
					</div>
				</div>

				<div class="">
					<table class="table table-sm table-hover table-bordered" id="data-table-custom" style="font-size: 12px; display: block;">
						<thead>
							<tr>
								<th>No.</th>
								<th>Tanggal</th>
								<th>Waktu</th>
								<th>Bandara</th>
								<th>Lokasi Pengantaran</th>
								<th>Radius Jemput</th>
								<th>Orderan</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							?>
							<?php foreach ($pengantaran as $row) : ?>
								<?php
								$id_bandara = $row['id_bandara'];
								$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara'"))->getRow();

								$id_pengantaran = $row['id_pengantaran'];
								$jumlah_orderan_masuk = $db->query("SELECT * FROM tb_order WHERE id_pengantaran = '$id_pengantaran' ")->getNumRows();
								if ($jumlah_orderan_masuk > 0) {
									$status_orderan = "Ada";
								} else {
									$status_orderan = "Tidak Ada";
								}

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
									<td style="vertical-align: middle">
										<?= strftime("%d/%m/%Y", strtotime($row['create_datetime'])); ?>
									</td>
									<td style="vertical-align: middle">
										<?= strftime("%H:%M:%S", strtotime($row['create_datetime'])); ?>
									</td>
									<td style="width: 30%; vertical-align: middle;">
										<?= $bandara->nama_bandara; ?>
									</td>
									<td style="width: 30%; vertical-align: middle;">
										<?= $class_dashboard->getAddress($row['latitude'], $row['longitude']); ?>
									</td>
									<td class="text-left" style="vertical-align: middle;">
										<?= $row['radius_jemput']; ?> Meter
									</td>
									<td class="text-center" style="vertical-align: middle;">
										<?= $status_orderan; ?>
									</td>
									<td class="text-left <?= $class_status; ?>" style="vertical-align: middle;">
										<?= $status_pengantaran; ?>
									</td>
									<td style="vertical-align: middle;">
										<div class="list-unstyled d-block">
											<?php if (($row['status_pengantaran'] == "0") and ($jumlah_orderan_masuk == 0)) : ?>
												<li class="d-block mb-2">
													<form action="<?= base_url(); ?>/Driver/Pengantaran/confirm_pengantaran" method="post" style="width: 100%;">
														<input type="hidden" name="id_pengantaran" value="<?= $row['id_pengantaran']; ?>">
														<input type="hidden" name="status" value="2">
														<button type="submit" class="btn btn-sm btn-block btn-danger btn-cancel-confirm-pengantaran">
															<i class="fa fa-times"></i> Batalkan
														</button>
													</form>
												</li>
												<li class="d-block mb-2">
													<form action="<?= base_url(); ?>/Driver/Pengantaran/confirm_pengantaran" method="post" style="width: 100%;">
														<input type="hidden" name="id_pengantaran" value="<?= $row['id_pengantaran']; ?>">
														<input type="hidden" name="status" value="1">
														<button type="submit" class="btn btn-sm btn-block btn-success btn-confirm-selesai-pengantaran">
															<i class="fa fa-check"></i> Tandai Selesai
														</button>
													</form>
												</li>
											<?php endif; ?>
											<li class="d-block">
												<a href="<?= base_url(); ?>/driver/pengantaran/detail/<?= $row['id_pengantaran']; ?>" class="btn btn-sm btn-outline-info" style="width: 100%;">
													<i class="fa fa-list"></i> Detail
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

	</div>
</section>

<script>
	$(document).ready(function() {
		var datetime = new Date();
		var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

		var start_date;
		var end_date;
		var filterTanggalPengantaran = (function(oSettings, aData, iDataIndex) {
			var dateStart = parseDateValue(start_date);
			var dateEnd = parseDateValue(end_date);
			var evalDate = parseDateValue(aData[1]);
			if ((isNaN(dateStart) && isNaN(dateEnd)) ||
				(isNaN(dateStart) && evalDate <= dateEnd) ||
				(dateStart <= evalDate && isNaN(dateEnd)) ||
				(dateStart <= evalDate && evalDate <= dateEnd)) {
				return true;
			}
			return false;
		});

		function parseDateValue(rawDate) {
			var dateArray = rawDate.split("/");
			var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]);
			return parsedDate;
		}

		var $dTable = $('#data-table-custom').DataTable({
			"paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			"initComplete": function() {
				var status = this.api().column(7);
				var statusSelect = $('<select class="filter form-control form-control-lg"><option value="">Semua Status</option></select>')
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

				var orderan = this.api().column(6);
				var orderanSelect = $('<select class="filter form-control form-control-lg"><option value="">Semua</option></select>')
					.appendTo('#orderanSelect')
					.on('change', function() {
						var val = $(this).val();
						orderan.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				orderanSelect.append(`
					<option value="Ada">Ada</option>
					<option value="Tidak Ada">Tidak Ada</option>
					`);
			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
		});

		document.getElementsByClassName("cariTanggalPengantaran")[0].style.textAlign = "right";

		//konfigurasi daterangepicker pada input dengan id cariTanggalPengantaran
		$('#cariTanggalPengantaran').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
		$('#cariTanggalPengantaran').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			start_date = picker.startDate.format('DD/MM/YYYY');
			end_date = picker.endDate.format('DD/MM/YYYY');
			$.fn.dataTableExt.afnFiltering.push(filterTanggalPengantaran);
			$dTable.draw();
		});

		$('#cariTanggalPengantaran').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalPengantaran, 1));
			$dTable.draw();
		});
	});
</script>

<?= $this->endSection('content'); ?>