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

$class_dashboard = new App\Controllers\Admin\Dashboard;
?>

<style>
	.cards tbody tr {
		float: left;
		width: 19.6rem;
		margin: 10px;
		border: none;
		border-radius: 10px;
		box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
		padding: 10px;
	}

	.cards tbody td {
		display: block;
	}

	.cards thead {
		display: none;
	}

	.cards td:before {
		content: attr(data-label);
		position: relative;
		float: left;
		color: #808080;
		width: 5rem;
		margin-left: 0;
		/* margin-right: 1rem; */
		text-align: left;
	}

	tr.selected td:before {
		color: #ccc;
	}

	.table .avatar {
		width: 50px;
	}

	.cards .avatar {
		width: 150px;
		margin: 15px;
	}
</style>

<section class="py-8" id="home" style="min-height: 97vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(<?= base_url() ?>/assets/img/illustrations/category-bg.png); background-position:right top; background-size:200px 320px;">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card rounded-3">
					<div class="card-body">
						<h5>
							<?= $title; ?>
						</h5>
						<hr>

						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label for="tanggalOrderSelect">Tanggal Orderan</label>
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
						</div>

						<div class="row">

							<div class="col-lg-4 mb-3">
								<label for="driverSelect">Driver</label>
								<div id="driverSelect"></div>
							</div>

							<div class="col-lg-4 mb-3">
								<label for="customerSelect">Customer</label>
								<div id="customerSelect"></div>
							</div>

							<div class="col-lg-4 mb-3">
								<label for="statusOrderanSelect">Status</label>
								<div id="statusOrderanSelect"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-12 table-responsive ">
								<table class="table-sm table-bordered table-hover" style="font-size: 12px; width: 100%;" id="data-table-custom">
									<thead>
										<tr class="text-center">
											<th>No.</th>
											<th>Tanggal</th>
											<th>Waktu</th>
											<th>Customer</th>
											<th>Driver</th>
											<th>Bandara Tujuan</th>
											<th>Jarak ke Bandara</th>
											<th>Biaya</th>
											<th>Status</th>
											<th>Detail</th>
										</tr>
									</thead>

									<tbody>
										<?php
										$no = 1;
										$data_order = $db->query("SELECT * FROM tb_order ORDER BY id_order DESC");
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


											if ($row['status'] == "0") {
												$class_text_status = "badge badge-warning";
												$text_status = "Proses";
											} else if ($row['status'] == "1") {
												$class_text_status = "badge badge-info";
												$text_status = "Orderan diterima oleh driver";
											} else if ($row['status'] == "2") {
												$class_text_status = "badge badge-info";
												$text_status = "Driver menjemput customer";
											} else if ($row['status'] == "3") {
												$class_text_status = "badge badge-primary";
												$text_status = "Dalam perjalanan menuju bandara";
											} else if ($row['status'] == "4") {
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
												<td style="vertical-align: middle;">
													<?= $no++; ?>.
												</td>
												<td style="vertical-align: middle">
													<?= strftime("%d/%m/%Y", strtotime($row['create_datetime'])); ?>
												</td>
												<td style="vertical-align: middle">
													<?= strftime("%H:%M:%S", strtotime($row['create_datetime'])); ?>
												</td>
												<td style="vertical-align: middle;"><?= $customer->nama_lengkap; ?></td>
												<td style="vertical-align: middle;"><?= $driver->nama_lengkap; ?></td>
												<td style="vertical-align: middle;">
													<?= $bandara->nama_bandara; ?>
												</td>
												<td style="vertical-align: middle;">
													<?= $row['jarak_customer_to_bandara']; ?> Km
												</td>
												<td style="vertical-align: middle;">
													<?= rupiah($row['biaya'], "Y") ?>
												</td>
												<td style="vertical-align: middle;">
													<?= $text_status; ?>
												</td>
												<td style="vertical-align: middle;">
													<a href="<?= base_url(); ?>/admin/orderan/detail/<?= $row['kode_order']; ?>" class="btn btn-sm btn-outline-info">
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

		var dataTable = $('#data-table-custom').DataTable({
			"paging": true,
			'dom': "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-md-right ml-2'B>f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
			"responsive": true,
			"searching": true,
			"deferRender": true,
			'buttons': [{
				'text': '<i class="fa fa-id-badge fa-fw" aria-hidden="true"></i>',
				'action': function(e, dt, node) {
					$(dt.table().node()).toggleClass('cards');
					$('.fa', node).toggleClass(['fa-table', 'fa-id-badge']);
					dt.draw('page');
				},
				'className': 'btn',
				'attr': {
					'title': 'Change views',
				}
			}],
			"drawCallback": function(settings) {
				var api = this.api();
				var dataTable = $(api.table().node());

				if (dataTable.hasClass('cards')) {

					// Create an array of labels containing all table headers
					var labels = [];
					$('thead th', dataTable).each(function() {
						labels.push($(this).text());
					});

					// Add data-label attribute to each cell
					$('tbody tr', dataTable).each(function() {
						$(this).find('td').each(function(column) {
							$(this).attr('data-label', labels[column]);
						});
					});

					var max = 0;
					$('tbody tr', dataTable).each(function() {
						max = Math.max($(this).height(), max);
					}).height(max);

				} else {
					// Remove data-label attribute from each cell
					$('tbody td', dataTable).each(function() {
						$(this).removeAttr('data-label');
					});

					$('tbody tr', dataTable).each(function() {
						$(this).height('auto');
					});
				}
			},
			"initComplete": function() {
				var statusOrderan = this.api().column(6);
				var statusOrderanSelect = $('<select class="filter form-control-sm js-select-2" style="width: 100%;"><option value="">Semua</option></select>')
					.appendTo('#statusOrderanSelect')
					.on('change', function() {
						var val = $(this).val();
						statusOrderan.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				statusOrderanSelect.append(`
					<option value="Proses">Proses</option>
					<option value="Orderan diterima oleh driver">Orderan diterima oleh driver</option>
					<option value="Driver menjemput customer">Driver menjemput customer</option>
					<option value="Dalam perjalanan menuju bandara">Dalam perjalanan menuju bandara</option>
					<option value="Selesai">Selesai</option>
					<option value="Orderan dibatalkan oleh customer">Orderan dibatalkan oleh customer</option>
					<option value="Orderan ditolak oleh driver">Orderan ditolak oleh driver</option>
					`);

				var customer = this.api().column(1);
				var customerSelect = $('<select class="filter form-control-sm js-select-2" style="width: 100%;"><option value="">Semua</option></select>')
					.appendTo('#customerSelect')
					.on('change', function() {
						var val = $(this).val();
						customer.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				customer.data().unique().sort().each(function(d, j) {
					customerSelect.append('<option value="' + d + '">' + d + '</option>');
				});

				var driver = this.api().column(2);
				var driverSelect = $('<select class="filter form-control-sm js-select-2" style="width: 100%;"><option value="">Semua</option></select>')
					.appendTo('#driverSelect')
					.on('change', function() {
						var val = $(this).val();
						driver.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				driver.data().unique().sort().each(function(d, j) {
					driverSelect.append('<option value="' + d + '">' + d + '</option>');
				});
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
			dataTable.draw();
		});

		$('#cariTanggalOrder').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalOrder, 1));
			dataTable.draw();
		});
	});
</script>

<?= $this->endSection('content'); ?>