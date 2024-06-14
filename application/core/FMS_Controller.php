<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author     Faiz Muhammad Syam, S.Kom
 * @project    E - Office 2023
 * @e-mail     faizmsyam@gmail.com - cafeweb.id@gmail.com
 * @license    Dinas Komunikasi dan Informatika
 */

class FMS_Controller extends MX_Controller
{
	public $brand, $date, $datetime, $id_user, $id_pegawai, $kode_unor, $platform, $dashboard;

	function __construct()
	{
		parent::__construct();
		if ($this->_agent() == 'none' && $this->_agent() == 'robot') exit;

		// override
		$this->load->add_package_path(APPPATH . 'third_party/app/');
		$this->load->config('app_config');

		$this->load->database();
		$this->load->library(['session', 'form_validation', 'encrypt', 'user_agent']);
		$this->load->helper(['url', 'text', 'html', 'form', 'navigation', 'syam', 'opendatav2', 'pegov', 'api']);
		$this->load->model(['builder_model','collection_model']);

		$this->brand = $this->brand();
		$this->date = date('Y-m-d');
		$this->datetime = date('Y-m-d H:i:s');
		$this->config->set_item('language', 'indonesia');

		$this->id_user = $this->session->userdata('id');
		$this->id_pegawai = $this->session->userdata('id_pegawai');
		$this->kode_unor = $this->session->userdata('kode_unor');
		$this->dashboard = data_dashboard($this->id_pegawai);

		$this->output->set_header('Cache-Control: public, max-age=0');
		$this->output->set_header('Content-Type: text/html; charset=' . $this->config->item('charset'));
		$this->output->set_header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 604800) . ' GMT');
		$this->output->set_header('Strict-Transport-Security: max-age=31536000');
		$this->output->set_header('Referrer-Policy: no-referrer-when-downgrade');
		$this->output->set_header('X-Powered-By: Faiz Muhammad Syam, S.Kom');
	}

	function check_login()
	{
		if (!$this->session->userdata('is_login')) redirect('auth');
	}

	function brand()
	{
		return $this->db->get('c_brand')->row();
	}

	// layouting for backend
	function layout($view = NULL, $data = [])
	{
		if ($view) {
			$data["content"] = $view;
			$this->load->view('themes/backend/index', $data);
		}
	}

	function layout_backend($view = NULL, $data = [])
	{
		if ($view) {
			$data["content"] = 'backend' . '/' . $view;
			$this->load->view('themes/backend/index', $data);
		}
	}

	// layouting for frontend
	function layout_frontend($view = NULL, $data = [])
	{
		if ($view) {
			$data["content"] = 'frontend' . '/' . $view;
			$this->load->view('themes/frontend/index', $data);
		}
	}

	// layouting for blank
	function layout_blank($view = NULL, $data = [])
	{
		if ($view) {
			$data["content"] = $view;
			$this->load->view('themes/blank/index', $data);
		}
	}

	function do_upload($filename, $path, $name, $quality = 100, $width = 0, $height = 0)
	{
		$config['upload_path'] = './assets/clouds/drives/' . $path . '/';
		$config['allowed_types'] = 'gif|jpeg|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|csv';
		$config['file_name'] = $filename;
		$config['overwrite'] = true;
		$config['remove_spaces'] = true;
		$config['max_size'] = 10240;

		$this->load->library('upload');
		$this->upload->initialize($config);
		$errors = [];
		if (!$this->upload->do_upload($name)) {
			$errors = [
				'code' => 400,
				'status' => false,
				'message' => $this->upload->display_errors(),
				'data' => NULL,
				'_token' => $this->security->get_csrf_hash(),
			];
			die(json_encode($errors));
		} else {
			$data = $this->upload->data();
			// compress Image
			$config['image_library'] = 'gd2';
			$config['source_image'] = './assets/clouds/drives/' . $path . '/' . $data['file_name'];
			$config['create_thumb'] = false;
			$config['maintain_ratio'] = false;
			$config['quality'] = $quality . '%';
			if ($width !== 0) {
				$config['width']      = $width;
			}
			if ($height !== 0) {
				$config['height'] = $height;
			}
			$config['new_image'] = './assets/clouds/drives/' . $path . '/' . $data['file_name'];
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();

			$errors = [
				'code' => 200,
				'status' => true,
				'message' => 'Berhasil mengunggah file',
				'data' => $this->upload->data(),
				'_token' => $this->security->get_csrf_hash(),
			];
			return $errors;
		}
	}
	
	function do_upload_loop($path, $name)
	{		
		$files = $_FILES;
		$data = [];
		$count_file = count($_FILES[$name]['name']);
		for ($i = 0; $i < $count_file; $i++) { 
			$_FILES[$name]['name'] = strtolower($files[$name]['name'][$i]);
			$_FILES[$name]['tmp_name'] = $files[$name]['tmp_name'][$i];
			$_FILES[$name]['error'] = $files[$name]['error'][$i];
			$_FILES[$name]['size'] = $files[$name]['size'][$i];

			$config['upload_path'] = './assets/clouds/drives/' . $path . '/';
			$config['allowed_types'] = 'gif|jpeg|jpg|png|pdf|doc|docx|xls|xlsx|ppt|pptx|csv';
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			$config['max_size'] = 10240;
			$config['encrypt_name'] = true;
			$config['file_ext_tolower'] = true;

			$this->load->library('upload');
			$this->upload->initialize($config);

			if (!$this->upload->do_upload($name)) {
				$response = [
					'code' => 400,
					'status' => false,
					'message' => $this->upload->display_errors(),
					'data' => NULL,
					'_token' => $this->security->get_csrf_hash(),
				];
			} else {
				$data[] = $this->upload->data();
				$response = [
					'code' => 200,
					'status' => true,
					'message' => 'Berhasil mengunggah file',
					'data' => $data,
					'_token' => $this->security->get_csrf_hash(),
				];
			}
		}
		return $response;
	}

	function unlink_file($path)
	{
		unlink('./assets/clouds/drives/' . $path);
	}

	function build_data_files($boundary, $fields, $files)
	{
		$data = '';
		$eol = "\r\n";
		$delimiter = '-------------' . $boundary;
		foreach ($fields as $name => $content) {
			$data .= "--" . $delimiter . $eol
				. 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol
				. $content . $eol;
		}
		foreach ($files as $name => $content) {
			$data .= "--" . $delimiter . $eol
				. 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $name . '"' . $eol
				//. 'Content-Type: image/png'.$eol	
				. 'Content-Transfer-Encoding: binary' . $eol;

			$data .= $eol;
			$data .= $content . $eol;
		}
		$data .= "--" . $delimiter . "--" . $eol;
		return $data;
	}

	private function _agent()
	{
		$this->load->library('user_agent');
		if ($this->agent->is_browser()) {
			$agent = 'website';
		} elseif ($this->agent->is_robot()) {
			$agent = 'robot';
		} elseif ($this->agent->is_mobile()) {
			$agent = 'mobile';
		} else {
			$agent = 'none';
		}

		return $agent;
	}
}
