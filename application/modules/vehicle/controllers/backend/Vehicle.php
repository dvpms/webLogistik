<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle extends FMS_Backend
{
	protected $limit, $table;

	function __construct()
	{
		parent::__construct();
		$this->limit = 10;
		$this->table = 'c_vehicle';
		$this->load->model('vehicle_model');
	}

	function index()
	{
		$data['page_title'] = 'Data Kendaraan';
		$this->layout_backend('index', $data);
	}
	function list()
	{
		if (!secure_get('page')) {
			die(json_encode(['status' => false,'message' => 'Parameter tidak lengkap']));
		}

		$param = ['keyword' => $this->input->get('keyword', TRUE)];
        $start = (((int) $this->input->get('page') - 1) * $this->limit);

		$data = $this->vehicle_model->get_list_data($start, $this->limit, $param);
		$data['page'] = (int) secure_get('page');
		$data['limit'] = $this->limit;

		die(json_encode($data));
	}

	function show($id){
		if (!$id) {
			die(json_encode(['status' => false, 'message' => 'Parameter tidak lengkap.']));
		}

		$data = $this->builder_model->find($this->table, ['id' => $id]);
		die(json_encode($data));
	}

	private function _validation(){
		$this->form_validation->set_rules('name','Nama Kendaraan');
		
		if(secure_post('id') === '') {
			$this-> form_validation->set_rules('plat_kendaraan','Plat Kendaraan','[c_vehicle.plat_kendaraan');
		}

		if($this->form_validation->run()) return true;

		$data = $error = [];
		$data['error_class'] = $data['error_string'] = [];
		$data['status'] = true;
		$data['_token'] = $this->security->get_csrf_hash();

		if(form_error('name')) $error[] = 'name';
		if(form_error('plat_kendaraan')) $error[] ='plat_kendaraan';
		
		if ($error) {
			foreach ($error as $row) {
				$data['error_class'][$row] = 'is-invalid';
				$data['error_string'][$row] = form_error($row);
			}
			$data['validasi'] = false;
			die(json_encode($data));
		}
	}

	

		// $filename = 'avatar-'.date('Ymd').'-'.time();
		// if (!empty($_FILES['file_avatar']['name'])) {
		// 	$data_upload = $this->do_upload($filename, 'avatars', 'file_avatar', 60, 200, 200);
		// 	if ($data_upload['status'] !== false) {
		// 		$data['foto_pegawai'] = $data_upload['data']['file_name'];
		// 		if (secure_post('id') !== '') {
		// 			if (secure_post('file_avatar_old') !== '') {
		// 				$this->unlink_file('avatars/'.secure_post('file_avatar_old'));
		// 			}
		// 		}
		// 	} else {
		// 		$data['foto_pegawai'] = NULL;
		// 	}
		// }

		function store() {
			$this->_validation();
			$data = [
				'plat_kendaraan' => $this->input->post('plat_kendaraan', true),
				'nama_kendaraan' => $this->input->post('nama_kendaraan', true),
			];
		
			if (secure_post('id') === '') {
				$this->db->trans_begin();
				$data['plat_kendaraan'] = secure_post('plat_kendaraan');
				$this->builder_model->store($this->table, $data);
		
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					show_error('Error saving data', 404);
				} else {
					$this->db->trans_commit();
					redirect('success_url', 'efresh');
				}
			} else {
				$this->builder_model->store($this->table, $data, ['id' => secure_post('id')]);
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					show_error('Error updating data', 404);
				} else {
					$this->db->trans_commit();
					redirect('success_url', 'efresh');
				}
			}
		}

	function destroy($id)
	{
		// if (secure_post('file_avatar') !== '' && secure_post('file_avatar') !== NULL) {
		// 	$this->unlink_file('avatars/'.secure_post('file_avatar'));
		// }
		$this->builder_model->destroy($this->table, ['id' => $id]);
		$this->send_success('Berhasil menghapus data.');
	}
}