<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthNotLoginCustomer implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		if (session()->get('login_customer_taxy_sharing')) {
			return redirect()->to(base_url() . '/customer');
		}
	}
	//--------------------------------------------------------------------

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	}
}
