<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu_admin_model extends FMS_Model
{
	protected $table = 'c_menus';

	function get_valid_menu($id_user_group, $menu)
	{
		$this->db->select('count(m.id) as jml');
		$this->db->from($this->table . ' m');
		$this->db->join('c_menus_privileges mp', 'mp.id_menu = m.id', 'left');
		$this->db->where('m.status', 'active', true);
		$this->db->where('mp.id_user_group', $id_user_group, true);
		$this->db->where('m.url', $menu, true);
		return $this->db->get()->row()->jml;
	}

	
	function get_menus($id_user_group)
	{
		$this->db->select('m.id, m.name, m.url, m.position, m.icon, m.status, m.id_parent, mp.id_menu, id_user_group');
		$this->db->from($this->table . ' m');
		$this->db->join('c_menus_privileges mp', 'mp.id_menu = m.id', 'left');
		$this->db->where('m.status', 'active');

		if ($id_user_group !== NULL) {
			$this->db->where('mp.id_user_group', $id_user_group);
		}
		$this->db->order_by('m.position asc', 'm.name asc');
		return $this->db->get()->result();
	}

	private function get_child($id_parent)
	{
		$sql = "select *, (NULL) as child 
				from " . $this->table . " 
				where id_parent = " . $id_parent . " 
				order by position, name asc";
		return $this->db->query($sql)->result();
	}

	function get_list_data($start, $limit)
	{
		$params = '';
		if (isset($search['keyword']) and $search['keyword'] !== '') {
			$params .= " and name = '" . $search['keyword'] . "'";
		}
		$limitation = "";
		if ($limit !== 0) {
			$limitation = " LIMIT " . $start . " , " . $limit;
		}
		$sql = "select *, (NULL) as child 
				from " . $this->table . "
				where id_parent IS NULL $params 
				order by position, name asc ";
		$root = $this->db->query($sql . $limitation)->result();
		foreach ($root as $key => $value) {
			$child = $this->get_child($value->id);
			// child
			if (count($child) > 0) {
				$root[$key]->child = $child;

				foreach ($child as $key2 => $value2) {
					$child2 = $this->get_child($value2->id);
					// child 
					if (count($child) > 0) {
						$root[$key]->child[$key2]->child = $child2;
					}
				}
			}
		}
		$result['data'] = $root;
		$result['jumlah'] = $this->db->query($sql)->num_rows();
		$this->db->close();
		return $result;
	}

	function get_list_data_search($start, $limit, $search)
	{
		$params = '';
		if (isset($search['keyword']) and $search['keyword'] !== '') {
			$params .= " and (m.name like '%" . $search['keyword'] . "%'";
			$params .= " or ma.name like '%" . $search['keyword'] . "%')";
		}
		$limitation = "";
		if ($limit !== 0) {
			$limitation = " LIMIT " . $start . " , " . $limit;
		}
		$select = "select m.*, 
                    ma.name as name_parent ";
		$count = "select count(*) as count ";
		$sql = "from " . $this->table . " m
                join " . $this->table . " ma on (ma.id = m.id_parent) 
                where m.id is not null $params";
		$order = " order by m.position, name";
		$query = $this->db->query($select . $sql . $order . $limitation);
		$result['data'] = $query->result();
		$result['jumlah'] = $this->db->query($count . $sql . $params)->row()->count;
		$this->db->close();
		return $result;
	}
}
