<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php

function rupiah($angka, $string)
{
	if ($string == "Y") {
		$hasil_rupiah = "Rp." . number_format($angka, 0, ',', '.');
	} elseif ($string == "N") {
		$hasil_rupiah = number_format($angka, 0, ',', '.');
	}
	return $hasil_rupiah;
}

$class_dashboard = new App\Controllers\Customer\Dashboard;
?>

<script>
	send_notif('8', 'customer', 'Hai GEDC');
</script>

<section class="py-8" id="home" style="min-height: 94vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image: url(<?= base_url() ?>/assets/img/illustrations/category-bg.png); background-position:right top; background-size:200px 320px;">
	</div>
	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center justify-content-between">
					<h4 class="mt-2">
						History Orderan Saya
					</h4>
				</div>
				<hr>
			</div>

			<div class="col-12">
				<div class="row">
					<div class="col-lg-4 mb-3">
						<div class="form-group">
							<label for="tanggalOrderSelect">Tanggal Order</label>
							<div class="cariTanggalOrder">
								<div class="input-group date">
									<span class="input-group-append">
										<span class="input-group-text bg-light d-block">
											<i class="fa fa-calendar"></i>
										</span>
									</span>
									<input type="text" class="form-control form-control-sm pull-right" id="cariTanggalOrder" placeholder="Contoh : 01/01/2022 - 12/12/2022">
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<label for="statusSelect">Status</label>
						<div id="statusSelect"></div>
					</div>
				</div>
			</div>

			<div class="col-12 table-responsive">
				<table class="table table-bordered table-hover" style="width: 100%; font-size: 14px;" id="data-table-custom">
					<thead>
						<tr class="text-center">
							<th>No.</th>
							<th>Tanggal Order</th>
							<th>Waktu Order</th>
							<th>Driver</th>
							<th>Biaya</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$no = 1;
						$data_order = $db->query("SELECT * FROM tb_order WHERE id_customer='$user_id' AND status >= 4 ORDER BY id_order DESC");
						?>
						<?php foreach ($data_order->getResult('array') as $row) : ?>
							<?php
							$id_pengantaran = $row["id_pengantaran"];
							$pengantaran = ($db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' "))->getRow();

							$id_driver = $pengantaran->id_driver;
							$driver = ($db->query("SELECT * FROM tb_driver WHERE id_driver='$id_driver' "))->getRow();

							$id_customer = $row['id_customer'];
							$customer = ($db->query("SELECT * FROM tb_customer WHERE id_customer='$id_customer' "))->getRow();

							$id_bandara = $pengantaran->id_bandara;
							$bandara = ($db->query("SELECT * FROM tb_bandara WHERE id_bandara='$id_bandara' "))->getRow();

							if ($row['status'] == "4") {
								$class_text_status = "badge badge-success";
								$text_status = "Selesai";
							} else if ($row['status'] == "5") {
								$class_text_status = "badge badge-danger";
								$text_status = "Orderan dibatalkan oleh customer";
							} else if ($row['status'] == "6") {
								$class_text_status = "badge badge-dark";
								$text_status = "Orderan ditolak oleh driver";
							}
							?>
							<tr>
								<td style="vertical-align: middle;" class="text-center">
									<?= $no++; ?>.
								</td>
								<td style="vertical-align: middle">
									<?= strftime("%d/%m/%Y", strtotime($row['create_datetime'])); ?>
								</td>
								<td style="vertical-align: middle">
									<?= strftime("%H:%M:%S WIB", strtotime($row['create_datetime'])); ?>
								</td>
								<td style="vertical-align: middle;"><?= $driver->nama_lengkap; ?></td>
								<td style="vertical-align: middle;"><?= rupiah($row['biaya'], "Y") ?></td>
								<td style="vertical-align: middle;">
									<?= $text_status; ?>
								</td>
								<td style="vertical-align: middle;" class="text-center">
									<a href="<?= base_url(); ?>/customer/history/detail/<?= $row['kode_order']; ?>" class="btn  btn-sm btn-outline-info">
										<i class="fa fa-list"></i> Detail
									</a>
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

		var start_date;
		var end_date;
		var filterTanggalOrder = (function(oSettings, aData, iDataIndex) {
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
			var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]); // -1 because months are from 0 to 11   
			return parsedDate;
		}

		var $dTable = $('#data-table-custom').DataTable({
			"paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			"initComplete": function() {
				var status = this.api().column(5);
				var statusSelect = $('<select class="filter form-control"><option value="">Semua Status</option></select>')
					.appendTo('#statusSelect')
					.on('change', function() {
						var val = $(this).val();
						status.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				statusSelect.append(`
					<option value="Selesai">Selesai</option>
					<option value="Orderan dibatalkan oleh customer">Orderan dibatalkan oleh customer</option>
					<option value="Orderan ditolak oleh driver">Orderan ditolak oleh driver</option>
					`);
			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
		});

		document.getElementsByClassName("cariTanggalOrder")[0].style.textAlign = "right";

		//konfigurasi daterangepicker pada input dengan id cariTanggalOrder
		$('#cariTanggalOrder').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
		$('#cariTanggalOrder').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			start_date = picker.startDate.format('DD/MM/YYYY');
			end_date = picker.endDate.format('DD/MM/YYYY');
			$.fn.dataTableExt.afnFiltering.push(filterTanggalOrder);
			$dTable.draw();
		});

		$('#cariTanggalOrder').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalOrder, 1));
			$dTable.draw();
		});

	});
</script>

<?= $this->endSection('content'); ?>