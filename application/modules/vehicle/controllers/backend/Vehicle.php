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

		$data = $this->vehicle_model->find($id);
		die(json_encode($data));
	}

	private function _validation(){
		$this->form_validation->set_rules('name','Nama Kendaraan','required|trim');
		
		if($this->form_validation->run()) return true;

		$data = $error = [];
		$data['error_class'] = $data['error_string'] = [];
		$data['status'] = true;
		$data['_token'] = $this->security->get_csrf_hash();

		if(form_error('name')) $error[] = 'name';
		
		if ($error) {
			foreach ($error as $row) {
				$data['error_class'][$row] = 'is-invalid';
				$data['error_string'][$row] = form_error($row);
			}
			$data['validasi'] = false;
			die(json_encode($data));
		}
	}

	function store() {
		$this->_validation();
		$data = [
			'nama_kendaraan' => secure_post('name'),
		];

		$filename = 'avatar-'.date('Ymd').'-'.time();
		if (!empty($_FILES['file_avatar']['name'])) {
			
		}
	}

}