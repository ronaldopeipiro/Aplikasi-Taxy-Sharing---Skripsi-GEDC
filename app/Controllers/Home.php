<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\DriverModel;
use App\Models\PushNotifModel;

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class Home extends BaseController
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();

		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();
		$this->PushNotifModel = new PushNotifModel();
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

	public function push_subscription()
	{
		$id_user = $this->request->getPost('id_user');
		$tipe_user = $this->request->getPost('tipe_user');
		$endpoint = $this->request->getPost('endpoint');
		$p256dh = $this->request->getPost('p256dh');
		$auth = $this->request->getPost('auth');

		$cek_data = $this->db->query("SELECT * FROM tb_push_notif WHERE id_user='$id_user' AND tipe_user='$tipe_user' AND endpoint = '$endpoint'");
		if ($cek_data->getNumRows() == 0) {
			$this->PushNotifModel->save([
				'id_user' => $id_user,
				'tipe_user' => $tipe_user,
				'endpoint' => $endpoint,
				'p256dh' => $p256dh,
				'auth' => $auth
			]);
		} else {
			$data = $cek_data->getRow();
			$this->PushNotifModel->updatePushNotif([
				'p256dh' => $p256dh,
				'auth' => $auth
			], $data->id_push_notif);
		}
	}

	public function send_push_notif()
	{
		// $id_user = $this->request->getPost('id_user');
		$tipe_user = $this->request->getPost('tipe_user');
		$text_pesan = $this->request->getPost('text_pesan');
		$contentencoding = $this->request->getPost('ce');

		$id_user = 7;
		$auth = [
			'VAPID' => [
				'subject' => 'https://jo.yokcaridok.id/',
				'publicKey' => file_get_contents(base_url() . '/notif-keys/public_key.txt'),
				'privateKey' => file_get_contents(base_url() . '/notif-keys/private_key.txt')
			],
		];

		if ($tipe_user === "customer") {
			$user = $this->CustomerModel->getCustomer($id_user);
		} elseif ($tipe_user === "driver") {
			$user = $this->DriverModel->getDriver($id_user);
		}

		$email_user = $user["email"];
		$confirm_send_notif = "Notif to User [$email_user] -> ";

		$cek_user = $this->db->query("SELECT * FROM tb_push_notif WHERE id_user='$id_user' AND tipe_user='$tipe_user' ORDER BY id_push_notif DESC");
		foreach ($cek_user->getResult('array') as $result) {
			$tujuan = array(
				"endpoint" => $result['endpoint'],
				"expirationTime" => "",
				"keys" => array(
					"p256dh" => $result['p256dh'],
					"auth" => $result['auth']
				),
				"contentEncoding" => "$contentencoding"
			);

			$subscription = Subscription::create($tujuan, true);
			$webPush = new WebPush($auth);

			$report = $webPush->sendOneNotification(
				$subscription,
				$text_pesan
			);

			$endpoint = $report->getRequest()->getUri()->__toString();

			if ($report->isSuccess()) {
				$result_success = true;
				$confirm_send_notif .= "Sent to $endpoint -> ";
			} else {
				$result_success = false;
				$confirm_send_notif .= "Failed to $endpoint -> ";
				$this->db->query("DELETE FROM tb_push_notif WHERE endpoint='$endpoint' ");
			}
		}

		if ($confirm_send_notif != "") {
			echo json_encode(array(
				'pesan' => "$confirm_send_notif"
			));
		}
	}
}
