<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Logout extends Controller
{
	public function administrator()
	{
		$session = session();
		$session->destroy();
		return redirect()->to(base_url() . '/administrator/login');
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
		$session->destroy();
		return redirect()->to(base_url() . '/customer/login');
	}
}
