<?php

namespace App\Controllers\customer;

use CodeIgniter\Controller;
use App\Models\CustomerModel;

class Auth extends Controller
{
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->request = \Config\Services::request();
		$this->CustomerModel = new CustomerModel();
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
		$session = session();
		$waktu_input = date("Y-m-d H:i:s");

		require_once APPPATH . 'Libraries/vendor/autoload.php';
		$google_client = new \Google_Client();

		// Localhost
		$google_client->setClientId('470512694911-b0qms2mklitu9btvi9fvr21j65vlkmcs.apps.googleusercontent.com');
		$google_client->setClientSecret('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');

		// Hosting jo.yokcaridok.id
		// $google_client->setClientId('470512694911-6ffkdo551ugthpd935s930p0636o92a2.apps.googleusercontent.com');
		// $google_client->setClientSecret('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');

		$google_client->setRedirectUri(base_url() . '/customer/login');
		$google_client->addScope('email');
		$google_client->addScope('profile');
		$google_client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));

		if ($this->request->getVar('code')) {

			$token = $google_client->fetchAccessTokenWithAuthCode($this->request->getVar('code'));

			if (!isset($token['error'])) {

				$google_client->setAccessToken($token['access_token']);
				$session->set('access_token', $token['access_token']);
				$google_service = new \Google_Service_Oauth2($google_client);
				$gdata = $google_service->userinfo->get();

				// print_r($gdata);
				$google_id_user = $gdata['id'];
				$email_user = $gdata['email'];
				$nama_user = $gdata['given_name'] . " " . $gdata['family_name'];
				$picture_user = $gdata['picture'];
				$gender_user = $gdata['gender'];

				$cek_data = $this->CustomerModel->getCustomerByGoogleId($google_id_user);

				if (!$cek_data) {
					$this->CustomerModel->save([
						'google_id' => $google_id_user,
						'nama_lengkap' => $nama_user,
						'username' => $email_user,
						'email' => $email_user,
						'foto' => $picture_user,
						'last_login' => $waktu_input
					]);
				}

				$session_data = [
					'google_id' => $google_id_user,
					'login_customer_taxy_sharing'  => TRUE
				];
				$session->set($session_data);

				$this->kirim_email_konfirmasi_login($nama_user, $email_user);
			}
			return redirect()->to(base_url() . '/customer/login');
		}

		if (!$session->get('access_token')) {
			$tombol_login = $google_client->createAuthUrl();
		} else {
			$tombol_login = "";
		}

		// helper(['form']);
		$data = [
			'title' => 'Masuk sebagai Customer',
			'db' => $this->db,
			'validation' => $this->validation,
			'tombol_login' => $tombol_login
		];
		return view('customer/auth/login', $data);
	}

	public function sign_up()
	{
		helper(['form']);
		$data = [
			'title' => 'Daftar sebagai Customer',
			'db' => $this->db,
			'validation' => $this->validation
		];
		return view('customer/auth/sign_up', $data);
	}

	public function auth_login()
	{
		$session = session();
		$model = new CustomerModel();
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
						'id_user' => $data['id_customer'],
						'login_customer_taxy_sharing'  => TRUE
					];

					$session->setFlashdata('pesan_berhasil', 'Selamat Datang ' . $data['nama_lengkap']);
					$session->set($ses_data);

					$this->kirim_email_konfirmasi_login($data['nama_lengkap'], $data['email']);

					return redirect()->to(base_url() . '/customer');
				} else {
					$session->setFlashdata('pesan_gagal', 'Password salah !');
					return redirect()->to(base_url() . '/customer/login');
				}
			} elseif ($status == "0") {
				$session->setFlashdata('pesan_gagal', 'Akun anda telah dinonaktifkan !');
				return redirect()->to(base_url() . '/customer/login');
			}
		} else {
			$session->setFlashdata('pesan_gagal', 'Username tidak ditemukan !');
			return redirect()->to(base_url() . '/customer/login');
		}
	}

	public function tambah_customer()
	{
		if (!$this->validate([
			'username' => [
				'rules' => 'required|is_unique[tb_customer.username]',
				'errors' => [
					'required' => '{field} harus diisi !',
					'is_unique' => '{field} telah digunakan !'
				]
			],
			'email' => [
				'rules' => 'required|is_unique[tb_customer.email]',
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
			return redirect()->to(base_url() . '/customer/sign-up')->withInput();
		}

		$datetime = date("Y-m-d H:i:s");

		$password = $this->request->getVar('password');
		$konfirmasi_password = $this->request->getVar('konfirmasi_password');
		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		if ($password != $konfirmasi_password) {
			session()->setFlashdata('pesan_gagal', 'Password tidak sesuai dengan konfirmasi !');
			return redirect()->to(base_url() . '/customer/sign-up')->withInput();
		}

		$this->CustomerModel->save([
			'username' => $this->request->getVar('username'),
			'password' => $password_hash,
			'nama_lengkap' => $this->request->getVar('nama_lengkap'),
			'email' => $this->request->getVar('email'),
			'no_hp' => $this->request->getVar('no_hp'),
			'status' => '1',
			'aktif' => 'N',
			'create_datetime' => $datetime
		]);

		session()->setFlashdata('pesan_berhasil', 'Selamat anda berhasil terdaftar sebagai Customer kami, silahkan login untuk mulai menggunakan aplikasi ini !');
		return redirect()->to(base_url() . '/customer/login');
	}

	public function kirim_email_konfirmasi_login($nama_penerima, $email_penerima)
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

		$email_smtp->setSubject("Konfirmasi Login Aplikasi");
		$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					anda baru saja login akun anda pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					<br>
					Jika benar anda yang melakukan aktifitas ini, silahkan abaikan pesan ini. 
					<br>
					Tetapi jika ini bukan anda, silahkan lakukan reset password akun anda dan hubungi administrator kami.
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
