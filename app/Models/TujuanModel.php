<?php

namespace App\Models;

use CodeIgniter\Model;

class TujuanModel extends Model
{
	protected $primaryKey = 'id_tujuan';
	protected $table = 'tb_tujuan';
	protected $allowedFields = [
		'id_tujuan',
		'nama_bandara',
		'alamat',
		'latitude',
		'longitude',
		'status',
		'create_datetime',
		'update_datetime'
	];

	public function getTujuan($id_tujuan = false)
	{
		if ($id_tujuan == false) {
			return $this->orderBy('id_tujuan', 'desc')->findAll();
		}
		return $this->where(['id_tujuan' => $id_tujuan])->first();
	}

	public function getTujuanByStatus($status)
	{
		return $this->where([
			'status' => $status
		])->orderBy('id_tujuan', 'DESC')->findAll();
	}

	public function updateTujuan($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_tujuan' => $id));
		return $query;
	}

	public function deleteTujuan($id)
	{
		return $this->db->table($this->table)->delete(['id_tujuan' => $id]);
	}
}
