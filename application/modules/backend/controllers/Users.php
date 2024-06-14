<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends FMS_Backend {

	protected $limit, $table;
	
	function __construct()
	{
		parent::__construct();
		$this->limit = 10;
		$this->table = 'c_users';
		$this->load->model('users_model');
	}
	
	function index()
	{
		$data['page_title'] = 'Users';
		$data['users_group'] = $this->collection_model->list_user_groups();
		$this->layout_backend('users/index', $data);
	}

	function list()
	{
		if (!secure_get('page')) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}
		$param = ['keyword' => secure_get('keyword')];
		$start = (((int) secure_get('page') - 1) * $this->limit);

		$data = $this->users_model->get_list_data($start, $this->limit, $param);
		$data['page'] = (int) secure_get('page');
		$data['limit'] = $this->limit;

		die(json_encode($data));
	}

	function show($id)
	{
		if (!$id) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}

		$data = $this->builder_model->find($this->table, ['id' => $id]);
		die(json_encode($data));
	}

	function update_status()
	{
		if (!secure_post('id') || secure_post('status') == '') {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}
		$param = [
			'id' => secure_post('id'),
			'status' => secure_post('status')
		];
		$data = $this->users_model->update_status($param);
		if ($data) {
			die(json_encode([
				'status' => true, 
				'message' => 'Berhasil mengubah status.',
				'_token' => $this->security->get_csrf_hash(),
			]));
		} else {
			die(json_encode([
				'status' => false, 
				'message' => 'Gagal mengubah status.',
				'_token' => $this->security->get_csrf_hash(),
			]));
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('name', 'Nama lengkap', 'required|trim');
		$this->form_validation->set_rules('id_user_group', 'User group', 'required|trim');
		
		if (secure_post('id') === '') {
			$this->form_validation->set_rules('username', 'Username', 'required|trim|is_exist[c_users.nip]');
		}

		if ($this->form_validation->run()) return true;
		
		$data = $error = []; 
		$data['error_class'] = $data['error_string'] = [];
		$data['status'] = true;
		$data['_token'] = $this->security->get_csrf_hash();

		if (form_error('username')) $error[] = 'username';
		if (form_error('name')) $error[] = 'name';
		if (form_error('id_user_group')) $error[] = 'id_user_group';

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
			'id_user_group' => secure_post('id_user_group'),
			'nama_pegawai' => secure_post('name'),
		];

		$filename = 'avatar-'.date('Ymd').'-'.time();
		if (!empty($_FILES['file_avatar']['name'])) {
			$data_upload = $this->do_upload($filename, 'avatars', 'file_avatar', 60, 200, 200);
			if ($data_upload['status'] !== false) {
				$data['foto_pegawai'] = $data_upload['data']['file_name'];
				if (secure_post('id') !== '') {
					if (secure_post('file_avatar_old') !== '') {
						$this->unlink_file('avatars/'.secure_post('file_avatar_old'));
					}
				}
			} else {
				$data['foto_pegawai'] = NULL;
			}
		}
		if (secure_post('id') === '') {
			$this->db->trans_begin();
			$data['nip'] = secure_post('username');
			$data['password'] = password_hash('12345', PASSWORD_DEFAULT);
			$data['is_pegawai'] = 0;
			$this->builder_model->store($this->table, $data);
			
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$this->send_error($data_upload['message']);
			} else {
				$this->db->trans_commit();
				$this->send_success('Berhasil menyimpan data.');
			}
		} else {
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

	function destroy($id)
	{
		if (secure_post('file_avatar') !== '' && secure_post('file_avatar') !== NULL) {
			$this->unlink_file('avatars/'.secure_post('file_avatar'));
		}
		$this->builder_model->destroy($this->table, ['id' => $id]);
		$this->send_success('Berhasil menghapus data.');
	}
}