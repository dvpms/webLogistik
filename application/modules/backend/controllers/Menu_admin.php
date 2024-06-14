<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_admin extends FMS_Backend {

	protected $limit, $table;
	
	function __construct()
	{
		parent::__construct();
		$this->limit = 10;
		$this->table = 'c_menus';
		$this->load->model('menu_admin_model');
		$this->check_valid_menu($this->id_user_group, $this->url);
	}
	
	function index()
	{
		$data['page_title'] = 'Menu Admin';
		$this->layout_backend('menu_admin/index', $data);
	}

	function list()
	{
		if (!secure_get('page')) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}

		$tipedata = 'list';
		if (isset($_GET['tipedata'])) {
			$tipedata = secure_get('tipedata');
		}

		$param = ['keyword' => secure_get('keyword')];
		$start = (((int) secure_get('page') - 1) * $this->limit);

		if ($tipedata === 'list') {
			$data = $this->menu_admin_model->get_list_data($start, $this->limit);
		} else {
			$data = $this->menu_admin_model->get_list_data_search($start, $this->limit, $param);
		}

		$data['page'] = (int) secure_get('page');
		$data['limit'] = $this->limit;

		echo json_encode($data);
	}

	function show()
	{
		if (!secure_get('id')) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}

		$data = $this->builder_model->find($this->table, ['id' => secure_get('id')]);
		echo json_encode($data);
	}

	function destroy()
	{
		$id = secure_post('id');
		$this->builder_model->destroy($this->table, ['id' => $id]);
		$this->send_success('Berhasil menghapus data.');
	}

	private function _validation()
	{
		$this->form_validation->set_rules('name', 'nama', 'required|trim');
		$this->form_validation->set_rules('path', 'path', 'required|trim');

		if ($this->form_validation->run()) return true;
		
		$data = $error = []; 
		$data['error_class'] = $data['error_string'] = [];
		$data['status'] = true;

		if (form_error('name')) $error[] = 'name';
		if (form_error('path')) $error[] = 'path';

		if ($error) {
			foreach ($error as $row) {
				$data['error_class'][$row] = 'is-invalid';
				$data['error_string'][$row] = form_error($row);
			}
			$data['validasi'] = false;
			die(json_encode($data));
		}
	}

	function store()
	{
		$this->_validation();
		$data = [
			'id_parent' => (secure_post('id_parent') !== '' ? secure_post('id_parent') : NULL),
			'name' => secure_post('name'),
			// 'url' => url_title(secure_post('path'), '-', true),
			'url' => secure_post('path'),
			'icon' => secure_post('icon'),
			'position' => secure_post('position'),
		];
		
		if (secure_post('id') === '') {
			$this->db->trans_begin();
			$data['created_date'] = $this->datetime;
			$this->builder_model->store($this->table, $data);
			
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$this->send_error('Gagal menyimpan data.');
			} else {
				$this->db->trans_commit();
				$this->send_success('Berhasil menyimpan data.');
			}
		} else {
			$data['updated_date'] = $this->datetime;
			$this->builder_model->store($this->table, $data, ['id' => secure_post('id')]);
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$this->send_error('Gagal mengubah data.');
			} else {
				$this->db->trans_commit();
				$this->send_success('Berhasil mengubah data.');
			}
		}
	}
}