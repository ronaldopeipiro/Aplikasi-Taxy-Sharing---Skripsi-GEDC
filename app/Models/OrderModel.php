<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
	protected $primaryKey = 'id_order';
	protected $table = 'tb_order';
	protected $allowedFields = [
		'id_order',
		'kode_order',
		'id_pengantaran',
		'id_customer',
		'latitude',
		'longitude',
		'jarak_customer_to_bandara',
		'tarif_perkm',
		'biaya',
		'status',
		'create_datetime',
		'update_datetime'
	];

	public function getOrder($id_order = false)
	{
		if ($id_order == false) {
			return $this->orderBy('id_order', 'desc')->findAll();
		}
		return $this->where(['id_order' => $id_order])->first();
	}

	public function getOrderByIdPengantaran($id_pengantaran)
	{
		return $this->where([
			'id_pengantaran' => $id_pengantaran
		])->orderBy('id_order', 'desc')->findAll();
	}

	public function getOrderByIdUser($id_user)
	{
		return $this->where([
			'id_user' => $id_user
		])->orderBy('id_order', 'desc')->findAll();
	}

	public function getOrderByKodeOrder($kode_order)
	{
		return $this->where([
			'kode_order' => $kode_order
		])->first();
	}

	public function getOrderByStatus($status)
	{
		return $this->where([
			'status' => $status
		])->orderBy('id_order', 'DESC')->findAll();
	}

	public function updateOrder($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_order' => $id));
		return $query;
	}

	public function deleteOrder($id)
	{
		return $this->db->table($this->table)->delete(['id_order' => $id]);
	}
}
