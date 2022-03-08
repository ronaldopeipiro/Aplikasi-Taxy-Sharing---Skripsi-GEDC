<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\DriverModel;

class Home extends BaseController
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();

		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();
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

	public function subscribe_notification()
	{
		$id_user = $this->request->getVar('id_user');
		$tipe_user = $this->request->getVar('tipe_user');
		$data_endpoint = explode("https://fcm.googleapis.com/fcm/send/", $this->request->getVar('endpoint'));
		$endpoint = $data_endpoint[1];

		if ($tipe_user == "customer") {
			$query = $this->CustomerModel->updateCustomer([
				'endpoint' => $endpoint
			], $id_user);
		} elseif ($tipe_user == "driver") {
			$query = $this->DriverModel->updateDriver([
				'endpoint' => $endpoint
			], $id_user);
		}

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Layanan notifikasi berhasil diaktifkan !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Maaf, terdapat kesalahan teknis !'
			));
		}
	}

	public function send_push_notification()
	{
		$endpoint = $this->request->getVar('endpoint');

		$judul = $this->request->getVar('judul');
		$deskripsi = $this->request->getVar('deskripsi');
		$link_aksi = $this->request->getVar('link_aksi');

		$server_key_firebase = "AAAA3saUcJ8:APA91bFHkJ9eHLkxYc9YLDmsSTabwL8zk2jAzWqpUbqvkXnEhIPKG9gOY0vQkwYaWRHrBZMhLjWaLBcQ3fb68bp1peY0Sw1dy_1mHAZYGgrY26TC9PnlrMFbcrQ_qSxAxBDjArV4xySI";

		define('SERVER_API_KEY', $server_key_firebase);
		$registrationIds[0] = $endpoint;
		$header = [
			'Authorization: Key=' . SERVER_API_KEY,
			'Content-Type: Application/json'
		];
		$msg = [
			'title' => $judul,
			'body'  => $deskripsi,
			'icon'  => 'https://jo.yokcaridok.id/assets/img/logo.jpg',
			'image' => 'https://jo.yokcaridok.id/assets/img/taxi.png',
			'click_action' => $link_aksi
		];

		$payload = [
			'registration_ids'  => $registrationIds,
			'data'				=> $msg
		];

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($payload),
			CURLOPT_HTTPHEADER => $header
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) echo "cURL Error #:" . $err;
		else echo $response;
	}

	public function beranda()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'title' => 'BERANDA',
		];
		return view('landing/welcome/views', $data);
	}

	public function offline()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'title' => 'OFFLINE',
		];
		return view('landing/offline/views', $data);
	}

	public function tentang()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'title' => 'TENTANG',
		];
		return view('landing/tentang/views', $data);
	}
}
