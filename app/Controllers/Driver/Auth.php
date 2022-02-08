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

	public function lupa_password()
	{
		helper(['form']);
		$data = [
			'title' => 'Lupa Password Akun Driver',
			'db' => $this->db,
			'validation' => $this->validation
		];
		return view('driver/auth/lupa-password', $data);
	}

	public function reset_password($token)
	{
		helper(['form']);
		$data = [
			'title' => 'Lupa Password Akun Driver',
			'db' => $this->db,
			'validation' => $this->validation,
			'token' => $token
		];
		return view('driver/auth/reset-password', $data);
	}

	public function sign_up()
	{
		helper(['form']);
		$data = [
			'title' => 'Daftar sebagai Driver',
			'db' => $this->db,
			'validation' => $this->validation
		];
		return view('driver/auth/sign-up', $data);
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
			$status = $data['aktif'];

			if ($status == "Y") {
				$verify_pass = password_verify($password, $pass);
				if ($verify_pass) {
					$ses_data = [
						'id_user' => $data['id_driver'],
						'login_driver_taxy_sharing'  => TRUE
					];

					$session->set($ses_data);
					$this->kirim_email_konfirmasi_login($data['nama_lengkap'], $data['email']);

					echo json_encode(array(
						'success' => '1',
						'pesan' => 'Selamat Datang ' . $data["nama_lengkap"]
					));
				} else {
					echo json_encode(array(
						'success' => '0',
						'pesan' => 'Password salah !'
					));
					return false;
				}
			} elseif ($status == "N") {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'Akun anda telah dinonaktifkan !'
				));
				return false;
			}
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username tidak dittemukan !'
			));
			return false;
		}
	}

	public function submit_lupa_password()
	{
		$session = session();
		$username = $this->request->getVar('username');

		$data = ($this->db->query("SELECT * FROM tb_driver WHERE username = '$username' OR email = '$username' "))->getRow();

		if ($data) {
			$status = $data->aktif;
			if ($status == "Y") {

				$token_reset_password = $this->getToken(97);

				$this->DriverModel->updateDriver([
					'token_reset_password' => $token_reset_password
				], $data->id_driver);

				$this->kirim_email_konfirmasi_lupa_password($data->nama_lengkap, $data->email, $token_reset_password);

				$session->setFlashdata('pesan_berhasil', 'Pesan konfirmasi lupa password telah dikirimkan melalui email ' . $data->email . '. Silahkan periksa email anda !');
				return redirect()->to(base_url() . '/driver/login');
			} elseif ($status == "N") {
				$session->setFlashdata('pesan_gagal', 'Akun dengan username/email ini telah dinonaktifkan !');
				return redirect()->to(base_url() . '/driver/lupa-password');
			}
		} else {
			$session->setFlashdata('pesan_gagal', 'Username/Email tidak ditemukan !');
			return redirect()->to(base_url() . '/driver/lupa-password');
		}
	}

	public function submit_reset_password()
	{
		$session = session();
		$token_reset_password = $this->request->getVar('token_reset_password');
		$password = $this->request->getVar('password');
		$konfirmasi_password = $this->request->getVar('konfirmasi_password');

		if ($password != $konfirmasi_password) {
			$session->setFlashdata('pesan_gagal', 'Password baru tidak sesuai dengan konfirmasi !');
			return redirect()->to(base_url() . '/driver/reset-password/' . $token_reset_password);
		}

		$password_baru_hash = password_hash($password, PASSWORD_DEFAULT);

		$data = ($this->db->query("SELECT * FROM tb_driver WHERE token_reset_password = '$token_reset_password' "))->getRow();

		$this->DriverModel->updateDriver([
			'token_reset_password' => '',
			'password' => $password_baru_hash
		], $data->id_driver);

		$this->kirim_email_konfirmasi_reset_password($data->nama_lengkap, $data->email, $data->username, $password);

		$session->setFlashdata('pesan_berhasil', 'Password akun berhasil diubah. Silahkan login kembali menggunakan password baru anda !');
		return redirect()->to(base_url() . '/driver/login');
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

		$no_anggota = $this->request->getVar('no_anggota');
		$nopol = $this->request->getVar('nopol');
		$username = $this->request->getVar('username');
		$nama_lengkap = $this->request->getVar('nama_lengkap');
		$email = $this->request->getVar('email');
		$no_hp = $this->request->getVar('no_hp');

		$this->DriverModel->save([
			'no_anggota' => $no_anggota,
			'nopol' => $nopol,
			'username' => $username,
			'password' => $password_hash,
			'nama_lengkap' => $nama_lengkap,
			'email' => $email,
			'no_hp' => $no_hp,
			'status_akun' => '0',
			'aktif' => 'Y',
			'create_datetime' => $datetime
		]);

		$this->kirim_email_konfirmasi_pendaftaran($nama_lengkap, $email, $no_hp, $username, $password, $no_anggota, $nopol);

		session()->setFlashdata('pesan_berhasil', 'Selamat anda berhasil terdaftar sebagai driver kami, silahkan login untuk mulai menggunakan aplikasi ini !');
		return redirect()->to(base_url() . '/driver/login');
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

	public function kirim_email_konfirmasi_pendaftaran($nama_penerima, $email_penerima, $no_hp, $username, $password, $no_anggota, $nopol)
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

		$email_smtp->setSubject("Konfirmasi Pendaftaran Akun Driver");
		$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					anda baru saja melakukan pendaftaran aplikasi AIRPORT TAXI SHARING sebagai <b>Driver</b> pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
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
							<td>' . $password . '</td>
						</tr>
						<tr>
							<td>No. Anggota</td>
							<td>:</td>
							<td>' . $no_anggota . '</td>
						</tr>
						<tr>
							<td>No. Polisi</td>
							<td>:</td>
							<td>' . $nopol . '</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td>' . $email_penerima . '</td>
						</tr>
						<tr>
							<td>No. Handphone</td>
							<td>:</td>
							<td>' . $no_hp . '</td>
						</tr>
						<tr>
							<td>Status Akun</td>
							<td>:</td>
							<td>Menunggu Verifikasi</td>
						</tr>
					</table>
					<br>
					Silahkan login untuk melihat detail akun anda melalui tautan 
					<br>
					<a href="' . base_url() . '/driver/login">
						Login Aplikasi
					</a>
					<br>
					<br>
					Mohon untuk menunggu verifikasi dari administrator kami untuk dapat mulai menggunakan akun anda. 
					<br>
					Kami akan mengirimkan notifikasi selanjutnya melalui email ini terkait hasil verifikasi akun anda.
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

	public function kirim_email_konfirmasi_lupa_password($nama_penerima, $email_penerima, $token)
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

		$email_smtp->setSubject("Permohonan Reset Password");
		$pesan = '
					<h4>Hallo, saudara/i <b>' . $nama_penerima . '</b></h4>
					anda baru saja meminta untuk melakukan reset password akun anda pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
					<br>
					<br>
					Silahkan lakukan reset password melalui tautan : 
					<a href="' . base_url() . '/driver/reset-password/' . $token . '">
						' . base_url() . '/driver/reset-password/' . $token . '
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

	public function kirim_email_konfirmasi_reset_password($nama_penerima, $email_penerima, $username, $password_baru)
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
					anda baru saja melakukan reset password akun anda pada ' . date("d/m/Y") . ' pukul ' . date("H:i:s") . ' WIB
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
					<a href="' . base_url() . '/driver/login">
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
