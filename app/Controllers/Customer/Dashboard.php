<?php

namespace App\Controllers\Customer;

use CodeIgniter\Controller;
use App\Models\CustomerModel;
use App\Models\DriverModel;
use App\Models\PengantaranModel;
use App\Models\OrderModel;
use App\Models\BandaraModel;
use App\Models\TarifModel;

class Dashboard extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();
		$this->PengantaranModel = new PengantaranModel();
		$this->OrderModel = new OrderModel();
		$this->BandaraModel = new BandaraModel();
		$this->TarifModel = new TarifModel();

		$this->session = session();
		$this->id_user = $this->session->get('id_user');
		$data_user = $this->CustomerModel->getCustomer($this->id_user);
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

	public function get_client_ip()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	public function update_posisi()
	{
		$latitude = $this->request->getPost('latitude');
		$longitude = $this->request->getPost('longitude');

		$this->CustomerModel->updateCustomer([
			'latitude' => $latitude,
			'longitude' => $longitude
		], $this->id_user);
	}

	public function index()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Dashboard',
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
			'pengantaran' => $this->PengantaranModel->getPengantaranProses(),
			'data_tarif' => $this->TarifModel->getTarif(1)
		];
		return view('customer/dashboard/views', $data);
	}
}
