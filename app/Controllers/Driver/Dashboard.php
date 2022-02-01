<?php

namespace App\Controllers\Driver;

use CodeIgniter\Controller;
use App\Models\CustomerModel;
use App\Models\DriverModel;
use App\Models\PengantaranModel;
use App\Models\OrderModel;
use App\Models\BandaraModel;

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

	public function getAddress($latitude, $longitude)
	{
		//google map api url
		$url = "https://maps.google.com/maps/api/geocode/json?latlng=$latitude,$longitude&key=AIzaSyBJkHXEVXBSLY7ExRcxoDxXzRYLJHg7qfI";

		// send http request
		$geocode = file_get_contents($url);
		$json = json_decode($geocode);
		$address = $json->results[0]->formatted_address;
		return $address;
	}

	public function update_posisi()
	{
		$latitude = $this->request->getPost('latitude');
		$longitude = $this->request->getPost('longitude');

		$this->DriverModel->updateDriver([
			'latitude' => $latitude,
			'longitude' => $longitude
		], $this->id_user);
	}

	public function distance_matrix_google($lat1, $lng1, $lat2, $lng2)
	{
		$fetch = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?departure_time=now&destinations=$lat2%2C$lng2&origins=$lat1%2C$lng1&key=AIzaSyBJkHXEVXBSLY7ExRcxoDxXzRYLJHg7qfI");
		$json = json_decode($fetch);

		$data['distance'] = $json->rows[0]->elements[0]->distance->text;;
		$data['duration'] = $json->rows[0]->elements[0]->duration->text;
		$data['duration_in_traffic'] = $json->rows[0]->elements[0]->duration_in_traffic->text;

		return $data;
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
			'user_jenis_kelamin' => $this->user_jenis_kelamin,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_no_anggota' => $this->user_no_anggota,
			'user_nopol' => $this->user_nopol,
			'driver_aktif' => $this->DriverModel->getDriverAktif()
		];
		return view('driver/dashboard/views', $data);
	}
}
