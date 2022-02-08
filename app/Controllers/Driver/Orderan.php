<?php

namespace App\Controllers\Driver;

use CodeIgniter\Controller;
use App\Models\CustomerModel;
use App\Models\DriverModel;
use App\Models\PengantaranModel;
use App\Models\OrderModel;

class Orderan extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();
		$this->PengantaranModel = new PengantaranModel();
		$this->OrderModel = new OrderModel();

		$this->session = session();
		$this->id_user = $this->session->get('id_user');
		$data_user = $this->DriverModel->getDriver($this->id_user);
		$this->user_username = $data_user['username'];
		$this->user_nama_lengkap = $data_user['nama_lengkap'];
		$this->user_no_hp = $data_user['no_hp'];
		$this->user_email = $data_user['email'];
		$this->user_no_anggota = $data_user['no_anggota'];
		$this->user_nopol = $data_user['nopol'];
		$this->user_level = "driver";
		$this->user_foto =	$data_user['foto'];
		$this->user_latitude =	$data_user['latitude'];
		$this->user_longitude =	$data_user['longitude'];
		$this->user_status = $data_user['status_akun'];
	}

	public function index()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Orderan',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_latitude' => $this->user_latitude,
			'user_longitude' => $this->user_longitude,
			'user_status' => $this->user_status,
			'user_no_anggota' => $this->user_no_anggota,
			'user_nopol' => $this->user_nopol,
		];
		return view('driver/orderan/views', $data);
	}

	public function history()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Orderan',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_no_anggota' => $this->user_no_anggota,
			'user_nopol' => $this->user_nopol,
		];
		return view('driver/history/views', $data);
	}

	public function update_status_order()
	{
		$id_order = $this->request->getPost('id_order');
		$status = $this->request->getPost('status');

		$order = ($this->db->query("SELECT * FROM tb_order WHERE id_order='$id_order' "))->getRow();
		$customer = ($this->db->query("SELECT * FROM tb_customer WHERE id_customer='$order->id_customer' "))->getRow();

		if ($status == "2") {
			$data_order = $this->OrderModel->getOrder($id_order);
			$this->PengantaranModel->updatePengantaran([
				'status_pengantaran' => '1'
			], $data_order['id_pengantaran']);
		}


		$this->OrderModel->updateOrder([
			'status' => $status
		], $id_order);

		session()->setFlashdata('pesan_berhasil', 'Berhasil update status orderan !');
		$this->kirim_email_konfirmasi_status_orderan($customer->nama_lengkap, $customer->email, $status);
		return redirect()->to(base_url() . '/driver/orderan');
	}

	public function kirim_email_konfirmasi_status_orderan($nama_penerima, $email_penerima, $status)
	{
		$email_smtp = \Config\Services::email();

		$config["protocol"] = "smtp";
		$config["mailType"] = 'html';
		$config["charset"] = 'utf-8';
		// $config["CRLF"] = 'rn';
		$config["priority"] = '5';
		$config["SMTPHost"] = "smtp.gmail.com"; //alamat email SMTP 
		$config["SMTPUser"] = "airporttaxisharing@gmail.com"; //password email SMTP 
		$config["SMTPPass"] = "ztyfhshhykzoqloq";

		// $config["SMTPPort"] = 465;
		// $config["SMTPCrypto"] = "ssl";
		$config["SMTPPort"] = 587;
		$config["SMTPCrypto"] = "tls";

		$config["SMTPAuth"] = true;
		$email_smtp->initialize($config);
		$email_smtp->setFrom("airporttaxisharing@gmail.com", "AIRPORT TAXI SHARING");

		$email_smtp->setTo($email_penerima);

		if ($status == "1") {
			$email_smtp->setSubject("Orderan diterima oleh Driver");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Orderan anda baru saja diterima oleh driver, pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					<br>
					Mohon tunggu, driver kami akan segera menjemput anda di lokasi penjemputan. 
					<br>
					Mohon siapkan uang cash untuk melakukan pembayaran.
					<br>
					<br>
					Lihat detail orderan dan posisi driver anda disini.
					<br>
					<a href="' . base_url() . '/customer/order">
						' . base_url() . '/customer/order
					</a>
					<br>
					<br>
					Terima Kasih 
					<br>
					<br>
					<br>
					<i><b>Pesan ini dikirimkan otomatis oleh sistem !</b></i>
					<br>
			';
		} elseif ($status == "2") {
			$email_smtp->setSubject("Driver menuju lokasi anda");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Driver sedang berangkat menuju lokasi anda, pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Mohon siapkan uang cash untuk melakukan pembayaran.
					<br>
					<br>
					Lihat detail orderan dan posisi driver anda disini.
					<br>
					<a href="' . base_url() . '/customer/order">
						' . base_url() . '/customer/order
					</a>
					<br>
					<br>
					Terima Kasih 
					<br>
					<br>
					<br>
					<i><b>Pesan ini dikirimkan otomatis oleh sistem !</b></i>
					<br>
			';
		} elseif ($status == "3") {
			$email_smtp->setSubject("Berangkat menuju Bandara");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Saat ini anda bersama driver dalam perjalanan menuju bandara, pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Mohon siapkan uang cash untuk melakukan pembayaran.
					<br>
					<br>
					Lihat detail orderan dan posisi anda disini.
					<br>
					<a href="' . base_url() . '/customer/order">
						' . base_url() . '/customer/order
					</a>
					<br>
					<br>
					Terima Kasih 
					<br>
					<br>
					<br>
					<i><b>Pesan ini dikirimkan otomatis oleh sistem !</b></i>
					<br>
			';
		} elseif ($status == "4") {
			$email_smtp->setSubject("Orderan Selesai - Anda telah sampai di Tujuan");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Saat ini anda bersama driver telah sampai di bandara, pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Mohon siapkan uang cash dan melakukan pembayaran pada driver kami.
					<br>
					<br>
					Lihat detail orderan dan posisi anda disini.
					<br>
					<a href="' . base_url() . '/customer/order">
						' . base_url() . '/customer/order
					</a>
					<br>
					<br>
					Terima Kasih 
					<br>
					<br>
					<br>
					<i><b>Pesan ini dikirimkan otomatis oleh sistem !</b></i>
					<br>
			';
		} elseif ($status == "6") {
			$email_smtp->setSubject("Orderan dibatalkan oleh Driver");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Maaf, orderan tidak dapat diterima oleh driver pilihan anda, mohon lakukan order ulang dan pilih driver kami yang lain.
					<br>
					<br>
					Lihat detail orderan disini.
					<br>
					<a href="' . base_url() . '/customer/order">
						' . base_url() . '/customer/order
					</a>
					<br>
					<br>
					<br>
					<br>
					Terima Kasih 
					<br>
					<br>
					<br>
					<i><b>Pesan ini dikirimkan otomatis oleh sistem !</b></i>
					<br>
			';
		}

		$email_smtp->setMessage($pesan);
		$email_smtp->send();
	}
}
