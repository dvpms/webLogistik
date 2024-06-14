<?php 

if (!function_exists('get_main_menu_navigation')) {
	function get_main_menu_navigation($type = NULL)
	{
		$ci =& get_instance();
		$sql = "SELECT id, id_parent, name, url, target_blank
				FROM c_menus_main
				WHERE status = 'active' 
				ORDER BY id, position ASC";
		$result = $ci->db->query($sql)->result();

		if (count((array) $result) > 0) {
			foreach ($result as $menu) {
				$row['id'] = $menu->id;
				$row['name'] = $menu->name;
				$row['url'] = $menu->url;
				$row['id_parent'] = $menu->id_parent;
				$row['target_blank'] = $menu->target_blank;
				$row['nodes'] = NULL;

				$data[] = $row;
			}

			foreach ($data as $key => &$value) {
				$output[$value['id']] = &$value;
			}
			foreach ($data as $key => &$value) {
				if ($value['id_parent'] && isset($output[$value['id_parent']])) {
					$output[$value['id_parent']]['nodes'][] = &$value;
				}
			}
			foreach ($data as $key => &$value) {
				if ($value['id_parent'] && isset($output[$value['id_parent']])) {
					unset($data[$key]);
				}
			}
			return $data;
		}
	}
}