<?php

namespace App\Controllers\Driver;

use CodeIgniter\Controller;
use App\Models\CustomerModel;
use App\Models\DriverModel;

class Akun extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();

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
		$this->user_status = $data_user['status_akun'];
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
			'user_no_anggota' => $this->user_no_anggota,
			'user_nopol' => $this->user_nopol,
			'driver_aktif' => $this->DriverModel->getDriverAktif()
		];
		return view('driver/akun/views', $data);
	}

	public function ubah_data_akun()
	{
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$username = $this->request->getPost('username');
		$no_anggota = $this->request->getPost('no_anggota');
		$nopol = $this->request->getPost('nopol');
		$no_hp = $this->request->getPost('no_hp');
		$email = $this->request->getPost('email');

		$cek_username = $this->db->query("SELECT * FROM tb_driver WHERE id_driver != '$this->id_user' AND username='$username' ");
		if ($cek_username->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username telah digunakan !'
			));
			return false;
		} else {
			$this->DriverModel->updateDriver([
				'nama_lengkap' => $nama_lengkap,
				'no_anggota' => $no_anggota,
				'nopol' => $nopol,
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

		$cek_password_lama = ($this->db->query("SELECT * FROM tb_driver WHERE id_driver = '$this->id_user' "))->getRow();
		if (password_verify($password_lama, $cek_password_lama->password)) {
			if ($password_baru == $konfirmasi_password) {
				$password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
				$this->DriverModel->updateDriver(
					[
						'password' => $password_baru_hash
					],
					$this->id_user
				);

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

		$data_lama = $this->DriverModel->getDriver($this->id_user);

		$nama_foto = $file_foto->getRandomName();
		$file_foto->move('assets/img/driver', $nama_foto);

		// Hapus file lama
		$explode_foto = explode(':', $data_lama['foto']);
		if (!$explode_foto) {
			if ($data_lama['foto'] != '') {
				unlink('assets/img/driver/' . $data_lama['foto']);
			}
		}

		$this->DriverModel->updateDriver([
			'foto' => $nama_foto
		], $this->id_user);

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Foto profil berhasil diubah !!!'
		));
	}
}
