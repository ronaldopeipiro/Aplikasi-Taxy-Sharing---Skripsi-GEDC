<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\DriverModel;

class Driver extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->AdminModel = new AdminModel();
		$this->DriverModel = new DriverModel();

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
			'title' => 'Data Driver',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status
		];
		return view('admin/driver/views', $data);
	}

	public function update_aktif()
	{
		$id_driver = $this->request->getVar('id_driver');
		$aktif = $this->request->getVar('aktif');

		$this->db->query("UPDATE tb_driver SET aktif='$aktif' WHERE id_driver= '$id_driver' ");

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Status aktif berhasil diubah !'
		));
	}

	public function update_status_akun()
	{
		$id_driver = $this->request->getVar('id_driver');
		$status_akun = $this->request->getVar('status_akun');

		$this->db->query("UPDATE tb_driver SET status_akun='$status_akun' WHERE id_driver= '$id_driver' ");

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Status verifikasi berhasil diubah !'
		));
	}
}
