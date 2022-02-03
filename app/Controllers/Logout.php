<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Logout extends Controller
{
	public function admin()
	{
		$session = session();
		$session->destroy();
		return redirect()->to(base_url() . '/admin/login');
	}

	public function driver()
	{
		$session = session();
		$session->destroy();
		return redirect()->to(base_url() . '/driver/login');
	}

	public function customer()
	{
		$session = session();

		// $token = $session->get('access_token');
		// return redirect()->to("https://accounts.google.com/o/oauth2/revoke?token=$token");
		$session->destroy();
		return redirect()->to(base_url() . '/customer/login');
	}
}
