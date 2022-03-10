<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\TarifModel;

class Pengaturan extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->AdminModel = new AdminModel();
		$this->TarifModel = new TarifModel();

		$this->session = session();
		$this->id_user = $this->session->get('id_user');
		$data_user = $this->AdminModel->getAdmin($this->id_user);
		$this->user_username = $data_user['username'];
		$this->user_nama_lengkap = $data_user['nama_lengkap'];
		$this->user_no_hp = $data_user['no_hp'];
		$this->user_email = $data_user['email'];
		$this->user_level = "admin";
		$this->user_foto =	$data_user['foto'];
		$this->user_status = $data_user['status'];
	}

	public function index()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Pengaturan',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'data_tarif' => $this->TarifModel->getTarif(1)
		];
		return view('admin/pengaturan/views', $data);
	}

	public function ubah_tarif()
	{
		$tarif_perkm = $this->request->getPost('tarif_perkm');

		$this->TarifModel->updateTarif([
			'tarif_perkm' => $tarif_perkm,
			'id_admin' => $this->id_user
		], 1);

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Tarif berhasil diubah !'
		));
	}

	public function ubah_data_akun()
	{
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$username = $this->request->getPost('username');
		$no_hp = $this->request->getPost('no_hp');
		$email = $this->request->getPost('email');

		$cek_username = $this->db->query("SELECT * FROM tb_admin WHERE id_admin != '$this->id_user' AND username='$username' ");
		if ($cek_username->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username telah digunakan !'
			));

			return false;
		} else {
			$this->AdminModel->updateAdmin([
				'nama_lengkap' => $nama_lengkap,
				'username' => $username,
				'no_hp' => $no_hp,
				'email' => $email,
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

		$cek_password_lama = ($this->db->query("SELECT * FROM tb_admin WHERE id_admin = '$this->id_user' "))->getRow();
		if (password_verify($password_lama, $cek_password_lama->password)) {
			if ($password_baru == $konfirmasi_password) {
				$password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
				$this->AdminModel->updateAdmin(
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

		$data_lama = $this->AdminModel->getAdmin($this->id_user);

		$nama_foto = $file_foto->getRandomName();
		$file_foto->move('assets/img/admin', $nama_foto);

		// Hapus file lama
		if ($data_lama['foto'] != '') {
			unlink('assets/img/admin/' . $data_lama['foto']);
		}

		$this->AdminModel->updateAdmin([
			'foto' => $nama_foto
		], $this->id_user);

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Foto profil berhasil diubah !!!'
		));
	}
}
