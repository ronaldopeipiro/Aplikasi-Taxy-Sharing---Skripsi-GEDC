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

$class_dashboard = new App\Controllers\Driver\Dashboard;
?>

<style>
	.select2-container--default .select2-selection--single {
		height: 46px !important;
		padding: 10px 16px;
		font-size: 18px;
		line-height: 1.33;
		border-radius: 30px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow b {
		top: 85% !important;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 26px !important;
	}

	.select2-container--default .select2-selection--single {
		border: 1px solid #CCC !important;
		box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset;
		transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
	}
</style>

<section class="py-8" id="home" style="min-height: 94vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
	</div>
	<div class="container">

		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center">
					<a href="<?= base_url(); ?>/driver" class="btn btn-dark" title="Tambah Data Pengantaran">
						<i class="fa fa-arrow-left"></i>
					</a>
					<h4 class="mt-2 ml-2">
						History Orderan
					</h4>
				</div>
				<hr>
			</div>

			<div class="col-12">
				<div class="row">

					<div class="col-lg-5 mb-3 mb-lg-0">
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

					<div class="col-lg-4 mb-3 mb-lg-0">
						<label for="customerSelect">Customer</label>
						<div id="customerSelect"></div>
					</div>

					<div class="col-lg-3 mb-3 mb-lg-0">
						<label for="statusSelect">Status</label>
						<div id="statusSelect"></div>
					</div>

				</div>
			</div>

			<div class="col-12 mt-3">
				<table class="table table-sm table-responsive table-bordered table-hover" style="width: 100%; font-size: 12px;" id="data-table-custom">
					<thead>
						<tr class="text-center">
							<th>No.</th>
							<th>Tanggal Order</th>
							<th>Waktu Order</th>
							<th>Customer</th>
							<th>Bandara Tujuan</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$no = 1;
						$data_order = $db->query("SELECT * FROM tb_order JOIN tb_pengantaran ON tb_order.id_pengantaran = tb_pengantaran.id_pengantaran WHERE tb_pengantaran.id_driver='$user_id' AND tb_order.status >= 4 ORDER BY tb_order.id_order DESC");
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
									<?= strftime("%H:%M:%S", strtotime($row['create_datetime'])); ?>
								</td>
								<td style="vertical-align: middle;"><?= $customer->nama_lengkap; ?></td>
								<td style="vertical-align: middle;">
									<?= $bandara->nama_bandara; ?>
									<br>
									(<?= $row['latitude'] . "," . $row['longitude'] ?>)
								</td>
								<td style="vertical-align: middle;">
									<?= $text_status; ?>
								</td>
								<td style="vertical-align: middle;">
									<a href="<?= base_url(); ?>/driver/history/detail/<?= $row['kode_order']; ?>" class="btn btn-sm btn-outline-info">
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
				var customer = this.api().column(3);
				var customerSelect = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
					.appendTo('#customerSelect')
					.on('change', function() {
						var val = $(this).val();
						customer.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				customer.data().unique().sort().each(function(d, j) {
					customerSelect.append('<option value="' + d + '">' + d + '</option>');
				});

				var status = this.api().column(5);
				var statusSelect = $('<select class="filter form-control form-control-lg"><option value="">Semua Status</option></select>')
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