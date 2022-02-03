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

<section class="py-8" id="home" style="min-height: 94vh;">
	<div class="bg-holder d-none d-sm-block" style="background-image:url(assets/img/illustrations/category-bg.png);background-position:right top;background-size:200px 320px;">
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
				<table class="table-sm table-bordered table-hover" style="width: 100%; font-size: 12px;" id="data-table-custom">
					<thead>
						<tr class="text-center">
							<th>No.</th>
							<th>Lokasi Pengantaran Penumpang dari Bandara</th>
							<th>Lokasi Penjemputan Customer</th>
							<th>Bandara Tujuan</th>
							<th>Jarak ke Bandara</th>
							<th>Driver</th>
							<th>Biaya</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$no = 1;
						$data_order = $db->query("SELECT * FROM tb_order WHERE id_customer='$user_id' ORDER BY id_order DESC");
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
								$text_status = "Driver menuju lokasi anda";
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
								<td style="vertical-align: middle;" class="text-center">
									<?= $no++; ?>.
								</td>
								<td style="vertical-align: middle;">
									<?= $class_dashboard->getAddress($pengantaran->latitude, $pengantaran->longitude); ?>
									<br>
									(<?= $pengantaran->latitude . "," . $pengantaran->longitude ?>)
								</td>
								<td style="vertical-align: middle;">
									<?= $class_dashboard->getAddress($row['latitude'], $row['longitude']); ?>
									<br>
									(<?= $row['latitude'] . "," . $row['longitude'] ?>)
								</td>
								<td style="vertical-align: middle;">
									<?= $bandara->nama_bandara; ?>
									<br>
									(<?= $row['latitude'] . "," . $row['longitude'] ?>)
								</td>
								<td style="vertical-align: middle;">
									<?= $row['jarak_customer_to_bandara']; ?> Km
								</td>
								<td style="vertical-align: middle;"><?= $driver->nama_lengkap; ?></td>
								<td style="vertical-align: middle;"><?= rupiah($row['biaya'], "Y") ?></td>
								<td style="vertical-align: middle;">
									<?= $text_status; ?>
								</td>
								<td style="vertical-align: middle;">
									<a href="<?= base_url(); ?>/admin/orderan/detail" class="btn btn-outline-info">
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