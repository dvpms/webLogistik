<?php defined('BASEPATH') or exit('No direct script access allowed');

class FMS_Frontend extends FMS_Controller {
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
}