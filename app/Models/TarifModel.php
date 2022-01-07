<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifModel extends Model
{
	protected $primaryKey = 'id_tarif';
	protected $table = 'tb_tarif';
	protected $allowedFields = [
		'id_tarif',
		'tarif_perkm',
		'id_admin',
		'update_datetime'
	];

	public function getTarif($id_tarif = false)
	{
		if ($id_tarif == false) {
			return $this->orderBy('id_tarif', 'desc')->findAll();
		}
		return $this->where(['id_tarif' => $id_tarif])->first();
	}

	public function updateTarif($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_tarif' => $id));
		return $query;
	}
}
