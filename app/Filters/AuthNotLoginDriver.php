<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthNotLoginDriver implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		if (session()->get('login_driver_taxy_sharing')) {
			return redirect()->to(base_url() . '/driver');
		}
	}

	//--------------------------------------------------------------------
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	}
}
