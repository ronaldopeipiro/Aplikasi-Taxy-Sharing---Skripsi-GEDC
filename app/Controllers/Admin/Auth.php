<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\AdminModel;

class Auth extends Controller
{
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->request = \Config\Services::request();
		$this->AdminModel = new AdminModel();
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
			'title' => 'Masuk sebagai Administrator',
			'db' => $this->db,
			'validation' => $this->validation
		];
		return view('admin/auth/login', $data);
	}

	public function auth_login()
	{
		$session = session();
		$model = new AdminModel();
		$username = $this->request->getVar('username');
		$password = $this->request->getVar('password');

		$data = $model->where('username', $username)->first();

		if ($data) {
			$pass = $data['password'];
			$status = $data['status'];

			if ($status == "1") {
				$verify_pass = password_verify($password, $pass);
				if ($verify_pass) {
					$ses_data = [
						'id_user' => $data['id_admin'],
						'login_driver_taxy_sharing'  => TRUE
					];

					$session->setFlashdata('pesan_berhasil', 'Selamat Datang ' . $data['nama_lengkap']);
					$session->set($ses_data);
					return redirect()->to(base_url() . '/admin');
				} else {
					$session->setFlashdata('pesan_gagal', 'Password salah !');
					return redirect()->to(base_url() . '/admin/login');
				}
			} elseif ($status == "0") {
				$session->setFlashdata('pesan_gagal', 'Akun anda telah dinonaktifkan !');
				return redirect()->to(base_url() . '/admin/login');
			}
		} else {
			$session->setFlashdata('pesan_gagal', 'Username tidak ditemukan !');
			return redirect()->to(base_url() . '/admin/login');
		}
	}
}
