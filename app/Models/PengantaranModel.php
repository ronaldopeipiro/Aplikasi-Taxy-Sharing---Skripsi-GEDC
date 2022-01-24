<?php

namespace App\Models;

use CodeIgniter\Model;

class PengantaranModel extends Model
{
	protected $primaryKey = 'id_pengantaran';
	protected $table = 'tb_pengantaran';
	protected $allowedFields = [
		'id_pengantaran',
		'id_driver',
		'latitude',
		'longitude',
		'radius_jemput',
		'status_pengantaran',
		'create_datetime',
		'update_datetime'
	];

	public function getPengantaran($id_pengantaran = false)
	{
		if ($id_pengantaran == false) {
			return $this->orderBy('id_pengantaran', 'desc')->findAll();
		}
		return $this->where(['id_pengantaran' => $id_pengantaran])->first();
	}

	public function getPengantaranByIdDriver($id_driver)
	{
		return $this->where([
			'id_driver' => $id_driver
		])->orderBy('id_pengantaran', 'desc')->findAll();
	}


	public function getPengantaranProses()
	{
		return $this->where([
			'status_pengantaran' => '0'
		])->findAll();
	}

	public function getJumlahPengantaranProses()
	{
		return $this->where([
			'status_pengantaran' => '0'
		])->countAllResults();
	}

	public function getJumlahPengantaranSelesai()
	{
		return $this->where([
			'status_pengantaran' => '1'
		])->countAllResults();
	}

	public function getJumlahPengantaranTidakSelesai()
	{
		return $this->where([
			'status_pengantaran' => '2'
		])->countAllResults();
	}

	public function getPengantaranByStatus($status)
	{
		return $this->where([
			'status_pengantaran' => $status
		])->orderBy('id_pengantaran', 'DESC')->findAll();
	}

	public function updatePengantaran($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_pengantaran' => $id));
		return $query;
	}

	public function deletePengantaran($id)
	{
		return $this->db->table($this->table)->delete(['id_pengantaran' => $id]);
	}
}
