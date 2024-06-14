<?php defined('BASEPATH') or exit('No direct script access allowed');

class Privileges extends FMS_Backend
{
	protected $limit, $table;
	
	function __construct()
	{
		parent::__construct();
		$this->limit = 10;
		$this->table = 'c_users_group';
		$this->load->model('privileges_model');
		$this->check_valid_menu($this->id_user_group, $this->url);
	}

	function index()
	{
		$data['page_title'] = 'Set Privileges';
		$this->layout_backend('privileges/index', $data);
	}

	function list()
	{
		if (!secure_get('page')) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}
		$param = ['keyword' => secure_get('keyword')];
		$start = (((int) secure_get('page') - 1) * $this->limit);

		$data = $this->privileges_model->get_list_data($start, $this->limit, $param);
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

	function list_privileges()
	{
		$id = secure_get('id');
		$data = $this->privileges_model->get_list_data_privileges($id);
		echo json_encode($data);
	}

	private function _validation()
	{
		$this->form_validation->set_rules('name', 'nama group', 'required|trim');

		if ($this->form_validation->run()) return true;

		$data = $error = [];
		$data['error_class'] = $data['error_string'] = [];
		$data['status'] = true;

		if (form_error('name')) $error[] = 'name';

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
		$data = $this->privileges_model->update_data_privileges();
		echo json_encode($data);
	}

	function destroy()
	{
		$id = secure_post('id');
		$this->builder_model->destroy($this->table, ['id' => $id]);
		$this->send_success('Berhasil menghapus data.');
	}
}
