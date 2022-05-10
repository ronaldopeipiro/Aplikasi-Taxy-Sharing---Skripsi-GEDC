<?php

namespace App\Models;

use CodeIgniter\Model;

class PushNotifModel extends Model
{
	protected $primaryKey = 'id_push_notif';
	protected $table = 'tb_push_notif';
	protected $allowedFields = [
		'id_push_notif',
		'id_user',
		'tipe_user',
		'endpoint',
		'auth',
		'p256dh',
		'create_datetime'
	];

	public function getPushNotif($id_push_notif = false)
	{
		if ($id_push_notif == false) {
			return $this->orderBy('id_push_notif', 'desc')->findAll();
		}
		return $this->where(['id_push_notif' => $id_push_notif])->first();
	}

	public function getPushNotifByUser($id_user, $tipe_user)
	{
		return $this->where([
			'id_user' => $id_user,
			'tipe_user' => $tipe_user
		])->orderBy('id_push_notif', 'desc')->findAll();
	}

	public function updatePushNotif($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_push_notif' => $id));
		return $query;
	}

	public function deletePushNotif($id)
	{
		return $this->db->table($this->table)->delete(['id_push_notif' => $id]);
	}
}
