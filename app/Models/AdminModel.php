<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
	protected $primaryKey = 'id_admin';
	protected $table = 'tb_admin';
	protected $allowedFields = [
		'id_admin',
		'username',
		'password',
		'nama_lengkap',
		'email',
		'no_hp',
		'foto',
		'status',
		'last_login',
		'create_datetime',
		'update_datetime'
	];

	public function getAdmin($id_admin = false)
	{
		if ($id_admin == false) {
			return $this->orderBy('id_admin', 'desc')->findAll();
		}
		return $this->where(['id_admin' => $id_admin])->first();
	}

	public function getAdminByStatus($status)
	{
		return $this->where([
			'status' => $status
		])->orderBy('id_admin', 'DESC')->findAll();
	}

	public function updateAdmin($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_admin' => $id));
		return $query;
	}

	public function deleteAdmin($id)
	{
		return $this->db->table($this->table)->delete(['id_admin' => $id]);
	}
}
