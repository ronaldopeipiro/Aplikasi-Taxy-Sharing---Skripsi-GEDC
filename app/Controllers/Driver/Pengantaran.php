<?php

namespace App\Controllers\Driver;

use CodeIgniter\Controller;
use App\Models\CustomerModel;
use App\Models\DriverModel;
use App\Models\PengantaranModel;

class Pengantaran extends Controller
{
	public function __construct()
	{
		$this->request = \Config\Services::request();
		$this->db = \Config\Database::connect();
		$this->validation = \Config\Services::validation();
		$this->CustomerModel = new CustomerModel();
		$this->DriverModel = new DriverModel();
		$this->PengantaranModel = new PengantaranModel();

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

	public function index()
	{
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Pengantaran',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_no_anggota' => $this->user_no_anggota,
			'user_nopol' => $this->user_nopol,
			'pengantaran' => $this->PengantaranModel->getPengantaranByIdDriver($this->id_user),
			'jml_pengantaran_diproses' => $this->PengantaranModel->getJumlahPengantaranProses()
		];
		return view('driver/pengantaran/views', $data);
	}

	public function create()
	{
		$jml_pengantaran_diproses = $this->PengantaranModel->getJumlahPengantaranProses();
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Tambah Data Pengantaran',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_email' => $this->user_email,
			'user_no_hp' => $this->user_no_hp,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'user_status' => $this->user_status,
			'user_no_anggota' => $this->user_no_anggota,
			'user_nopol' => $this->user_nopol,
			'pengantaran' => $this->PengantaranModel->getPengantaranByIdDriver($this->id_user),
			'jml_pengantaran_diproses' => $jml_pengantaran_diproses
		];

		if (($jml_pengantaran_diproses == 0) or (isset($jml_pengantaran_diproses))) {
			return view('driver/pengantaran/create', $data);
		} else {
			header('Location:' . base_url() . '/driver/pengantaran');
			exit();
		}
	}

	public function tambah_data_pengantaran()
	{
		if (!$this->validate([
			'latlonginput' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom harus diisi !',
				]
			],
			'radius_jemput' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom harus diisi !',
				]
			]
		])) {
			return redirect()->to(base_url() . '/driver/pengantaran/create')->withInput();
		}

		// $waktu_data = date("Y-m-d H:i:s");

		$latlonginput = explode(", ", $this->request->getVar('latlonginput'));

		$latitude = str_replace("(", "", $latlonginput[0]);
		$longitude = str_replace(")", "", $latlonginput[1]);

		$this->PengantaranModel->save([
			'id_driver' => $this->id_user,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'radius_jemput' => $this->request->getVar('radius_jemput'),
			'status_pengantaran' => '0'
		]);

		session()->setFlashdata('pesan_berhasil', 'Data berhasil disimpan !');
		return redirect()->to(base_url() . '/driver/pengantaran');
	}
}
