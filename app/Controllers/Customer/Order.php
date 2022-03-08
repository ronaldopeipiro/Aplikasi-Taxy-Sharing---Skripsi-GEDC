<?php

namespace App\Controllers\Customer;

use CodeIgniter\Controller;
use App\Models\CustomerModel;
use App\Models\DriverModel;
use App\Models\OrderModel;
use App\Models\PengantaranModel;
use App\Models\TarifModel;
use App\Models\BandaraModel;

class Order extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();

		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();
		$this->OrderModel = new OrderModel();
		$this->PengantaranModel = new PengantaranModel();
		$this->TarifModel = new TarifModel();
		$this->BandaraModel = new BandaraModel();

		$this->session = session();
		if ($this->session->get('id_user') != "") {
			$this->id_user = $this->session->get('id_user');
			$data_user = $this->CustomerModel->getCustomer($this->id_user);
		} elseif ($this->session->get('google_id') != "") {
			$this->google_id = $this->session->get('google_id');
			$data_user = $this->CustomerModel->getCustomerByGoogleId($this->google_id);
			$this->id_user = $data_user['id_customer'];
		}

		$this->user_username = $data_user['username'];
		$this->user_nama_lengkap = $data_user['nama_lengkap'];
		$this->user_no_hp = $data_user['no_hp'];
		$this->user_email = $data_user['email'];
		$this->user_level = "customer";
		$this->user_foto =	$data_user['foto'];
		$this->user_status = $data_user['status'];
		$this->user_latitude = $data_user['latitude'];
		$this->user_longitude = $data_user['longitude'];
	}


	function crypto_rand_secure($min, $max)
	{
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}

	function getToken($length)
	{
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		$max = strlen($codeAlphabet); // edited

		for ($i = 0; $i < $length; $i++) {
			$token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
		}

		return $token;
	}

	public function index()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Order',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_latitude' => $this->user_latitude,
			'user_longitude' => $this->user_longitude,
			'data_tarif' => $this->TarifModel->getTarif(1),
			'pengantaran' => $this->PengantaranModel->getPengantaranProses(),
		];
		return view('customer/order/views', $data);
	}

	public function history()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'History',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_latitude' => $this->user_latitude,
			'user_longitude' => $this->user_longitude,
			'data_tarif' => $this->TarifModel->getTarif(1),
		];
		return view('customer/history/views', $data);
	}

	public function detail_history($kode_order)
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'History',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_latitude' => $this->user_latitude,
			'user_longitude' => $this->user_longitude,
			'data_tarif' => $this->TarifModel->getTarif(1),
			'kode_order' => $kode_order
		];
		return view('customer/history/detail', $data);
	}

	public function submit_order()
	{
		$kode_order = $this->getToken(10);
		$id_pengantaran = $this->request->getPost('id_pengantaran');
		$id_customer = $this->request->getPost('id_customer');
		$latitude = $this->request->getPost('latitude');
		$longitude = $this->request->getPost('longitude');
		$jarak_customer_to_bandara = $this->request->getPost('jarak_customer_to_bandara');
		$tarif_perkm = $this->request->getPost('tarif_perkm');
		$biaya = $this->request->getPost('biaya');

		$customer = ($this->db->query("SELECT * FROM tb_customer WHERE id_customer='$id_customer' "))->getRow();
		$pengantaran = ($this->db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' "))->getRow();
		$driver = ($this->db->query("SELECT * FROM tb_driver WHERE id_driver='$pengantaran->id_driver' "))->getRow();

		$cek_orderan_proses = ($this->db->query("SELECT * FROM tb_order WHERE id_customer='$id_customer' AND status='0' LIMIT 1 "))->getNumRows();

		if ($cek_orderan_proses > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Orderan gagal ditambahkan, anda masih memiliki orderan yang belum selesai !'
			));
		} else {
			$this->OrderModel->save([
				'kode_order' => $kode_order,
				'id_pengantaran' => $id_pengantaran,
				'id_customer' => $id_customer,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'jarak_customer_to_bandara' => $jarak_customer_to_bandara,
				'tarif_perkm' => $tarif_perkm,
				'biaya' => $biaya
			]);

			$this->kirim_email_konfirmasi_status_orderan($customer->nama_lengkap, $customer->email, "0");
			$this->kirim_email_to_driver($driver->nama_lengkap, $driver->email, "0");

			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Orderan masuk, menunggu driver menerima orderan anda !'
			));
		}
	}

	public function cancel_order()
	{
		$id_order = $this->request->getPost('id_order');
		$order = ($this->db->query("SELECT * FROM tb_order WHERE id_order='$id_order' "))->getRow();
		$customer = ($this->db->query("SELECT * FROM tb_customer WHERE id_customer='$order->id_customer' "))->getRow();

		$id_pengantaran = $order->id_pengantaran;
		$pengantaran = ($this->db->query("SELECT * FROM tb_pengantaran WHERE id_pengantaran='$id_pengantaran' "))->getRow();
		$driver = ($this->db->query("SELECT * FROM tb_driver WHERE id_driver='$pengantaran->id_driver' "))->getRow();

		// $this->OrderModel->deleteOrder($id_order);
		$this->OrderModel->updateOrder([
			'status' => '5'
		], $id_order);

		$this->kirim_email_konfirmasi_status_orderan($customer->nama_lengkap, $customer->email, "5");
		$this->kirim_email_to_driver($driver->nama_lengkap, $driver->email, "5");

		session()->setFlashdata('pesan_berhasil', 'Orderan dibatalkan !');
		return redirect()->to(base_url() . '/customer/order');
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

		if ($status == "0") {
			$email_smtp->setSubject("Orderan berhasil ditambahkan - Menunggu konfirmasi Driver");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Orderan anda berhasil masuk pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Mohon tunggu, driver kami untuk melakukan konfirmasi orderan anda. 
					<br>
					<br>
					Lihat detail orderan anda disini.
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
		} elseif ($status == "5") {
			$email_smtp->setSubject("Orderan dibatalkan");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Orderan anda berhasil dibatalkan pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB !
					<br>
					<br>
					Lihat detail orderan anda disini.
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
		}

		$email_smtp->setMessage($pesan);
		$email_smtp->send();
	}

	public function kirim_email_to_driver($nama_penerima, $email_penerima, $status)
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

		if ($status == "0") {
			$email_smtp->setSubject("Orderan Masuk");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Ada orderan masuk untuk anda, pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Lihat detail orderan anda disini.
					<br>
					<a href="' . base_url() . '/driver/orderan">
						' . base_url() . '/driver/orderan
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
		} elseif ($status == "5") {
			$email_smtp->setSubject("Orderan dibatalkan oleh customer");
			$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					Orderan anda telah dibatalkan oleh customer pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Lihat detail orderan anda disini.
					<br>
					<a href="' . base_url() . '/driver/orderan">
						' . base_url() . '/driver/orderan
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
		}

		$email_smtp->setMessage($pesan);
		$email_smtp->send();
	}
}
