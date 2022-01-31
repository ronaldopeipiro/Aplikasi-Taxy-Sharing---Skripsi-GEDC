<?php

namespace App\Models;

use CodeIgniter\Model;

class BandaraModel extends Model
{
	protected $primaryKey = 'id_bandara';
	protected $table = 'tb_Bandara';
	protected $allowedFields = [
		'id_bandara',
		'nama_bandara',
		'alamat',
		'latitude',
		'longitude',
		'status',
		'create_datetime',
		'update_datetime'
	];

	public function getBandara($id_bandara = false)
	{
		if ($id_bandara == false) {
			return $this->orderBy('id_bandara', 'desc')->findAll();
		}
		return $this->where(['id_bandara' => $id_bandara])->first();
	}

	public function getBandaraByStatus($status)
	{
		return $this->where([
			'status' => $status
		])->orderBy('id_bandara', 'DESC')->findAll();
	}

	public function updateBandara($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_bandara' => $id));
		return $query;
	}

	public function deleteBandara($id)
	{
		return $this->db->table($this->table)->delete(['id_bandara' => $id]);
	}
}
