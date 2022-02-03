<?php

namespace App\Models;

use CodeIgniter\Model;

class DriverModel extends Model
{
	protected $primaryKey = 'id_driver';
	protected $table = 'tb_driver';
	protected $allowedFields = [
		'id_driver',
		'no_anggota',
		'nopol',
		'username',
		'password',
		'nama_lengkap',
		'email',
		'no_hp',
		'foto',
		'status_akun',
		'aktif',
		'latitude',
		'longitude',
		'token_reset_password',
		'last_login',
		'create_datetime',
		'update_datetime'
	];

	public function getDriver($id_driver = false)
	{
		if ($id_driver == false) {
			return $this->orderBy('id_driver', 'desc')->findAll();
		}
		return $this->where(['id_driver' => $id_driver])->first();
	}

	public function getDriverAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy('id_driver', 'DESC')->findAll();
	}

	public function getDriverTidakAktif()
	{
		return $this->where([
			'aktif' => 'N'
		])->orderBy('id_driver', 'DESC')->findAll();
	}

	public function getDriverByStatus($status)
	{
		return $this->where([
			'status_akun' => $status
		])->orderBy('id_driver', 'DESC')->findAll();
	}

	public function updateDriver($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_driver' => $id));
		return $query;
	}

	public function deleteDriver($id)
	{
		return $this->db->table($this->table)->delete(['id_driver' => $id]);
	}
}
