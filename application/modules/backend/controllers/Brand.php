<?php defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends FMS_Backend
{
	protected $limit, $table;
	
	function __construct()
	{
		parent::__construct();
		$this->limit = 10;
		$this->table = 'c_brand';
	}

	function index()
	{
		$this->check_valid_menu($this->id_user_group, $this->url);
		$data['page_title'] = 'Brand';
		$this->layout_backend('brand/index', $data);
	}

	function show($id)
	{
		if (!$id) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}

		$data = $this->builder_model->find($this->table, ['id' => $id]);
		echo json_encode($data);
	}

	private function _validation()
	{
		$this->form_validation->set_rules('name', 'title', 'required|trim');
		if (empty($_FILES['file_brand']['name']) && secure_post('id') === '') {
			$this->form_validation->set_rules('file_brand', 'logo', 'required|trim');
		}
		if (empty($_FILES['file_brand_light']['name']) && secure_post('id') === '') {
			$this->form_validation->set_rules('file_brand_light', 'logo light', 'required|trim');
		}
		if (empty($_FILES['file_brand_light']['name']) && secure_post('id') === '') {
			$this->form_validation->set_rules('file_brand_favicon', 'favicon', 'required|trim');
		}
		if ($this->form_validation->run()) return true;

		$data = $error = [];
		$data['error_class'] = $data['error_string'] = [];
		$data['status'] = true;

		if (form_error('name')) $error[] = 'name';
		if (form_error('file_brand')) $error[] = 'file_brand';
		if (form_error('file_brand_light')) $error[] = 'file_brand_light';
		if (form_error('file_brand_favicon')) $error[] = 'file_brand_favicon';

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
			'name' => secure_post('name'),
			'email' => secure_post('email'),
			'address' => secure_post('address'),
			'phone' => secure_post('phone'),
		];
		$filename_logo = 'brand-logo-' . date('Ymd') . '-' . time();
		if (!empty($_FILES['file_brand']['name'])) {
			$data_upload = $this->do_upload($filename_logo, 'brand', 'file_brand', 60, 0, 0);
			if ($data_upload['status'] !== false) {
				$data['logo'] = $data_upload['data']['file_name'];
				if (secure_post('id') !== '') {
					$this->unlink_file('brand/' . secure_post('file_brand_old'));
				}
			} else {
				$data['logo'] = NULL;
			}
		}
		$filename_logo_light = 'brand-logo-light-' . date('Ymd') . '-' . time();
		if (!empty($_FILES['file_brand_light']['name'])) {
			$data_upload = $this->do_upload($filename_logo_light, 'brand', 'file_brand_light', 60, 0, 0);
			if ($data_upload['status'] !== false) {
				$data['logo_light'] = $data_upload['data']['file_name'];
				if (secure_post('id') !== '') {
					$this->unlink_file('brand/' . secure_post('file_brand_light_old'));
				}
			} else {
				$data['logo_light'] = NULL;
			}
		}
		$filename_favicon = 'brand-favicon-' . date('Ymd') . '-' . time();
		if (!empty($_FILES['file_brand_favicon']['name'])) {
			$data_upload = $this->do_upload($filename_favicon, 'brand', 'file_brand_favicon', 60, 32, 32);
			if ($data_upload['status'] !== false) {
				$data['favicon'] = $data_upload['data']['file_name'];
				if (secure_post('id') !== '') {
					$this->unlink_file('brand/' . secure_post('file_brand_favicon_old'));
				}
			} else {
				$data['favicon'] = NULL;
			}
		}
		if (secure_post('id') === '') {
			$this->db->trans_begin();
			$data['created_date'] = $this->datetime;
			$this->builder_model->store($this->table, $data);

			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$this->send_error($data_upload['message']);
			} else {
				$this->db->trans_commit();
				$this->send_success('Berhasil menyimpan data.');
			}
		} else {
			$data['updated_date'] = $this->datetime;
			$this->builder_model->store($this->table, $data, ['id' => secure_post('id')]);
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$this->send_error($data_upload['message']);
			} else {
				$this->db->trans_commit();
				$this->send_success('Berhasil mengubah data.');
			}
		}
	}
}
