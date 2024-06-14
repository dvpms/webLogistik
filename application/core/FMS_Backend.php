<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Faiz Muhammad Syam, S.Kom
 * @project    E - Office 2023
 * @e-mail     faizmsyam@gmail.com - cafeweb.id@gmail.com
 * @license    Dinas Komunikasi dan Informatika
 */

class FMS_Backend extends FMS_Controller
{
	protected $data = [];
	public $menus = [];
	public $url, $id_user_group;

	function __construct()
	{
		parent::__construct();
		$this->refresh_cache();
		
		// check for session
		if (!$this->session->userdata('is_login')) redirect('auth');
		
		$this->url = $this->uri->segment(2);
		$this->id_user_group = $this->session->userdata('id_user_group');

		$this->lang->load('upload', 'indonesia');
		$this->config->set_item('language', 'indonesia');
		$this->menus = $this->set_menus($this->session->userdata('id_user_group'));
	}

	function check_valid_menu($id_user_group, $menu)
	{
		$this->load->model('backend/menu_admin_model');
		$valid = $this->menu_admin_model->get_valid_menu($id_user_group, $menu);
		if ($valid == 0) {
			redirect(site_url('eo/dashboard'));
		}
	}

	function refresh_cache()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
	}

	private function set_menus($id_user_group)
	{
		$this->load->model('backend/menu_admin_model');
		$menus = $this->menu_admin_model->get_menus($id_user_group);
		if (count((array) $menus) > 0) {
			foreach ($menus as $menu) {
				$row['id'] = $menu->id;
				$row['name'] = $menu->name;
				$row['url'] = $menu->url;
				$row['position'] = $menu->position;
				$row['icon'] = $menu->icon;
				$row['id_parent'] = $menu->id_parent;
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

	function send_success($message, $data = NULL)
	{
		$response = [
			'code' => 200,
			'status' => TRUE,
			'message' => $message,
			'data' => $data,
			'_token' => $this->security->get_csrf_hash(),
		];
		die(json_encode($response));
	}

	function send_error($message, $data = [])
	{
		$response = [
			'code' => 400,
			'status' => FALSE,
			'message' => $message,
		];
		if (!empty($data)) {
			$response['data'] = $data;
		}
		$response['_token'] = $this->security->get_csrf_hash();
		die(json_encode($response));
	}
}
