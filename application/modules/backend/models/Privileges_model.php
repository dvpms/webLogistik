<?php defined('BASEPATH') or exit('No direct script access allowed');

class Privileges_model extends FMS_Model
{
	protected $table = 'c_users_group';
	protected $table2 = 'c_menus_privileges';

	function __construct()
	{
		parent::__construct();
	}

	function get_list_data($start, $limit, $search)
	{
		$where_param = "";
		if ($search['keyword'] != '') {
			$where_param .= " AND a.name like '%" . $search['keyword'] . "%'";
		}

		if ($this->session->userdata('nip') !== 'taqwaw') {
			$where_param = " AND (a.id != 1) ";
		}

		$limitation = "";
		if ($limit !== 0) {
			$limitation = " LIMIT " . $start . " , " . $limit;
		}
		$sql = "SELECT a.* 
				FROM " . $this->table . " a 
				WHERE a.id IS NOT NULL $where_param";
		$order = " ORDER BY a.id ASC";
		$result["data"] = $this->db->query($sql . $order . $limitation)->result();
		$result["jumlah"] = $this->db->query($sql)->num_rows();
		$this->db->close();
		return $result;
	}

	function get_list_data_privileges($id_user_group)
	{
		$this->db->select('id, name, url, position, icon, status, id_parent');
		$this->db->from('c_menus');
		$this->db->where('status', 'active');

		if ($this->session->userdata('nip') !== 'taqwaw') {
			$this->db->group_start();
			$this->db->where('id != 24');
			$this->db->group_end();
		}

		$this->db->order_by('position asc', 'name asc');
		$data['all_menus'] = $this->db->get()->result();

		$this->db->select('a.id, a.name, a.url, a.position, a.icon, a.status, a.id_parent,
			b.id_user_group, b.id_menu
		');
		$this->db->from('c_menus a');
		$this->db->join($this->table2 . ' b', 'b.id_menu = a.id', 'left');
		$this->db->where('a.status', 'active');
		if ($id_user_group !== '') {
			$this->db->where('b.id_user_group', $id_user_group);
		}
		$this->db->order_by('a.position asc', 'name asc');
		$data['all_menus_by_group'] = $this->db->get()->result();
		return $data;
	}

	function update_data_privileges()
	{
		$id = $this->input->post('id', true);
		$name = secure_post('name');
		$id_menu = $this->input->post('id_menu', true);
		$data_group = [
			'name' => $name,
			'created_date' => $this->datetime,
		];
		if ($id === '') {
			$this->db->trans_start();
			$this->db->insert($this->table, $data_group);
			$id = $this->db->insert_id();
			$this->db->delete($this->table2, ['id_user_group' => $id]);
			if (is_array($id_menu)) {
				$menus = [];
				foreach ($id_menu as $i => $value) {
					$sub_data['id_user_group'] = $id;
					$sub_data['id_menu'] = $value;
					$sub_data['created_date'] = $this->datetime;
					$menus[] = $sub_data;
				}
				$this->db->insert_batch($this->table2, $menus);
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$response = [
					'status' => false,
					'message' => 'Gagal menambahkan user group dan setting privileges',
				];
			} else {
				$this->db->trans_commit();
				$response = [
					'status' => true,
					'message' => 'Berhasil menambahkan user group dan setting privileges',
				];
			}
			return $response;
		} else {
			$this->db->trans_start();
			$this->db->update($this->table, $data_group, ['id' => $id]);
			$this->db->delete($this->table2, ['id_user_group' => $id]);
			if (is_array($id_menu)) {
				$menus = [];
				foreach ($id_menu as $i => $value) {
					$sub_data['id_user_group'] = $id;
					$sub_data['id_menu'] = $value;
					$sub_data['created_date'] = $this->datetime;
					$menus[] = $sub_data;
				}
				$this->db->insert_batch($this->table2, $menus);
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$response = [
					'status' => false,
					'message' => 'Gagal mengubah user group dan setting privileges',
				];
			} else {
				$this->db->trans_commit();
				$response = [
					'status' => true,
					'message' => 'Berhasil mengubah user group dan setting privileges',
				];
			}
			return $response;
		}
	}
}
