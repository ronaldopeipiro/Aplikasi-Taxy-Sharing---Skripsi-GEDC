<?php

namespace App\Controllers\Customer;

use CodeIgniter\Controller;
use App\Models\CustomerModel;

class Akun extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();

		$this->CustomerModel = new CustomerModel();

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
		$this->user_password = $data_user['password'];
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
			'title' => 'Akun Saya',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_password' => $this->user_password,
			'user_latitude' => $this->user_latitude,
			'user_longitude' => $this->user_longitude
		];
		return view('customer/akun/views', $data);
	}

	public function ubah_data_akun()
	{
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$username = $this->request->getPost('username');
		$no_hp = $this->request->getPost('no_hp');
		$email = $this->request->getPost('email');

		$cek_username = $this->db->query("SELECT * FROM tb_customer WHERE id_customer != '$this->id_user' AND username='$username' ");
		if ($cek_username->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username telah digunakan !'
			));
			return false;
		} else {
			$this->CustomerModel->updateCustomer([
				'nama_lengkap' => $nama_lengkap,
				'username' => $username,
				'no_hp' => $no_hp,
				'email' => $email
			], $this->id_user);
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data akun berhasil diubah !'
			));
		}
	}

	public function ubah_password()
	{
		$password_lama = $this->request->getPost('password_lama');
		$password_baru = $this->request->getPost('password_baru');
		$konfirmasi_password = $this->request->getPost('konfirmasi_password');

		$cek_password_lama = ($this->db->query("SELECT * FROM tb_customer WHERE id_customer = '$this->id_user' "))->getRow();
		if (password_verify($password_lama, $cek_password_lama->password)) {
			if ($password_baru == $konfirmasi_password) {
				$password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
				$this->CustomerModel->updateCustomer(
					[
						'password' => $password_baru_hash
					],
					$this->id_user
				);

				$this->kirim_email_konfirmasi_update_password($cek_password_lama->nama_lengkap, $cek_password_lama->email, $cek_password_lama->username, $password_baru);

				echo json_encode(array(
					'success' => '1',
					'pesan' => 'Password berhasil diubah !'
				));
			} else {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'Password baru yang anda masukkan tidak sesuai dengan konfirmasi !'
				));

				return false;
			}
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password lama yang anda masukkan salah !'
			));

			return false;
		}
	}

	public function ubah_foto_profil()
	{
		$file_foto = $this->request->getFile('foto');

		$data_lama = $this->CustomerModel->getCustomer($this->id_user);

		$nama_foto = $file_foto->getRandomName();
		$file_foto->move('assets/img/customer', $nama_foto);

		// Hapus file lama
		$explode_foto = explode(':', $data_lama['foto']);
		if (!$explode_foto) {
			if ($data_lama['foto'] != '') {
				unlink('assets/img/customer/' . $data_lama['foto']);
			}
		}

		$this->CustomerModel->updateCustomer([
			'foto' => $nama_foto
		], $this->id_user);

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Foto profil berhasil diubah !!!'
		));
	}

	public function kirim_email_konfirmasi_update_password($nama_penerima, $email_penerima, $username, $password_baru)
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
		$config["SMTPPort"] = 587;
		// $config["SMTPCrypto"] = "ssl";
		$config["SMTPCrypto"] = "tls";
		$config["SMTPAuth"] = true;
		$email_smtp->initialize($config);
		$email_smtp->setFrom("airporttaxisharing@gmail.com", "AIRPORT TAXI SHARING");

		$email_smtp->setTo($email_penerima);

		$email_smtp->setSubject("Berhasil Reset Password");
		$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					anda baru saja melakukan update password akun anda pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Berikut detail akun anda :
					<table>
						<tr>
							<td>Nama Lengkap</td>
							<td>:</td>
							<td>' . $nama_penerima . '</td>
						</tr>
						<tr>
							<td>Username</td>
							<td>:</td>
							<td>' . $username . '</td>
						</tr>
						<tr>
							<td>Password Akun</td>
							<td>:</td>
							<td>' . $password_baru . '</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td>' . $email_penerima . '</td>
						</tr>
						<tr>
							<td>Status Akun</td>
							<td>:</td>
							<td>Aktif</td>
						</tr>
					</table>
					<br>
					Silahkan login menggunakan akun baru anda melalui tautan 
					<br>
					<a href="' . base_url() . '/customer/login">
						Login Aplikasi
					</a>
					<br>
					<br>
					Jika ini bukan anda, silahkan abaikan pesan ini.
					<br>
					<br>
					Terima Kasih 
					<br>
					<br>
					<br>
					<i><b>Pesan ini dikirimkan otomatis oleh sistem !</b></i>
					<br>
			';

		$email_smtp->setMessage($pesan);
		$email_smtp->send();
	}
}
