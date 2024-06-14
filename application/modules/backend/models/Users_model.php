<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{

	protected $table; 
	
	function __construct()
	{
		parent::__construct();
		$this->table = 'c_users';
	}

	function get_list_data($start, $limit, $search)
	{
		$where_param = "";
		if ($search['keyword'] != '') {
			$where_param .= " AND (a.nama_pegawai like '%" . $search['keyword'] . "%'";
			$where_param .= " OR a.nip like '%" . $search['keyword'] . "%')";
		}

		// $where_param .= " AND (a.nip != 'faizmsyam')";

		$limitation = "";
		if ($limit !== 0) {
			$limitation = " LIMIT " . $start . " , " . $limit;
		}
		$sql = "SELECT a.*,
				b.name as user_group 
				FROM " . $this->table . " a 
				JOIN c_users_group as b ON (b.id = a.id_user_group)
				WHERE a.id IS NOT NULL 
				$where_param";
		$order = " ORDER BY a.nama_pegawai ASC";
		$result["data"] = $this->db->query($sql . $order . $limitation)->result();
		$result["jumlah"] = $this->db->query($sql)->num_rows();
		$this->db->close();
		return $result;
	}

	function update_status($data)
	{
		if ($data['status'] == 1) {
			$this->db->where('id', $data['id'], true);
			$this->db->update($this->table, ['is_active' => 0]);
		} else if ($data['status'] == 0) {
			$this->db->where('id', $data['id'], true);
			$this->db->update($this->table, ['is_active' => 1]);
		}
		return $this->db->affected_rows();
	}
}
