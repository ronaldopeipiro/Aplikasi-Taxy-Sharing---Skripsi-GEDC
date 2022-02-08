<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use App\Models\AdminModel;
use App\Models\CustomerModel;

class Customer extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->AdminModel = new AdminModel();
		$this->CustomerModel = new CustomerModel();

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
			'title' => 'Data Customer',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status
		];
		return view('admin/customer/views', $data);
	}

	public function update_status()
	{
		$id_customer = $this->request->getVar('id_customer');
		$status = $this->request->getVar('status');

		$this->db->query("UPDATE tb_customer SET status='$status' WHERE id_customer= '$id_customer' ");

		echo json_encode(array(
			'success' => '1',
			'pesan' => 'Status berhasil diubah !'
		));
	}
}
