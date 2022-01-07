<?php

namespace App\Controllers\Driver;

use CodeIgniter\Controller;
use App\Models\DriverModel;

class Auth extends Controller
{
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->request = \Config\Services::request();
		$this->DriverModel = new DriverModel();
	}

	public function encrypt_openssl($string)
	{
		$ciphering = "AES-256-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = "taxysharingapps##";

		$encryption = openssl_encrypt(
			$string,
			$ciphering,
			$encryption_key,
			$options,
			$encryption_iv
		);

		return $encryption;
	}

	public function decrypt_openssl($string_encrypt)
	{
		$ciphering = "AES-256-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		$decryption_iv = '1234567891011121';
		$decryption_key = "taxysharingapps##";

		$decryption = openssl_decrypt(
			$string_encrypt,
			$ciphering,
			$decryption_key,
			$options,
			$decryption_iv
		);

		return $decryption;
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

	public function login()
	{
		helper(['form']);
		$data = [
			'title' => 'Masuk sebagai Driver',
			'db' => $this->db,
			'validation' => $this->validation
		];
		return view('driver/auth/login', $data);
	}

	public function sign_up()
	{
		helper(['form']);
		$data = [
			'title' => 'Daftar sebagai Driver',
			'db' => $this->db,
			'validation' => $this->validation
		];
		return view('driver/auth/sign_up', $data);
	}

	public function auth_login()
	{
		$session = session();
		$model = new DriverModel();
		$username = $this->request->getVar('username');
		$password = $this->request->getVar('password');

		$data = $model->where('username', $username)->first();

		if ($data) {
			$pass = $data['password'];
			$status = $data['status_akun'];

			if ($status != "2") {
				$verify_pass = password_verify($password, $pass);
				if ($verify_pass) {
					$ses_data = [
						'id_user' => $data['id_driver'],
						'login_driver_taxy_sharing'  => TRUE
					];

					$session->setFlashdata('pesan_berhasil', 'Selamat Datang ' . $data['nama_lengkap']);
					$session->set($ses_data);
					return redirect()->to(base_url() . '/driver');
				} else {
					$session->setFlashdata('pesan_gagal', 'Password salah !');
					return redirect()->to(base_url() . '/driver/login');
				}
			} elseif ($status == "0") {
				$session->setFlashdata('pesan_gagal', 'Akun anda telah dinonaktifkan !');
				return redirect()->to(base_url() . '/driver/login');
			}
		} else {
			$session->setFlashdata('pesan_gagal', 'Username tidak ditemukan !');
			return redirect()->to(base_url() . '/driver/login');
		}
	}

	public function tambah_driver()
	{
		if (!$this->validate([
			'username' => [
				'rules' => 'required|is_unique[tb_driver.username]',
				'errors' => [
					'required' => '{field} harus diisi !',
					'is_unique' => '{field} telah digunakan !'
				]
			],
			'email' => [
				'rules' => 'required|is_unique[tb_driver.email]',
				'errors' => [
					'required' => '{field} harus diisi !',
					'is_unique' => '{field} telah digunakan !'
				]
			],
			'no_hp' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'No. handphone harus diisi !',
				]
			],
			'no_anggota' => [
				'rules' => 'required|is_unique[tb_driver.no_anggota]',
				'errors' => [
					'required' => 'No. Anggota harus diisi !',
					'is_unique' => 'No. Anggota telah terdaftar !'
				]
			],
			'nopol' => [
				'rules' => 'required|is_unique[tb_driver.nopol]',
				'errors' => [
					'required' => 'No. Polisi / TNKB harus diisi !',
					'is_unique' => 'No. Polisi / TNKB telah terdaftar !'
				]
			],
			'nama_lengkap' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom harus diisi !',
				]
			],
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom harus diisi !',
				]
			],
			'konfirmasi_password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom harus diisi !',
				]
			],
		])) {
			return redirect()->to(base_url() . '/driver/sign-up')->withInput();
		}

		$datetime = date("Y-m-d H:i:s");

		$password = $this->request->getVar('password');
		$konfirmasi_password = $this->request->getVar('konfirmasi_password');
		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		if ($password != $konfirmasi_password) {
			session()->setFlashdata('pesan_gagal', 'Password tidak sesuai dengan konfirmasi !');
			return redirect()->to(base_url() . '/driver/sign-up')->withInput();
		}

		$this->DriverModel->save([
			'no_anggota' => $this->request->getVar('no_anggota'),
			'nopol' => $this->request->getVar('nopol'),
			'username' => $this->request->getVar('username'),
			'password' => $password_hash,
			'nama_lengkap' => $this->request->getVar('nama_lengkap'),
			'email' => $this->request->getVar('email'),
			'no_hp' => $this->request->getVar('no_hp'),
			'status_akun' => '0',
			'aktif' => 'N',
			'create_datetime' => $datetime
		]);

		session()->setFlashdata('pesan_berhasil', 'Selamat anda berhasil terdaftar sebagai driver kami, silahkan login untuk mulai menggunakan aplikasi ini !');
		return redirect()->to(base_url() . '/driver/login');
	}
}
