<?php defined('BASEPATH') or exit('No direct script access allowed');

class FMS_Model extends CI_Model {
  
	public $date, $datetime, $id_user, $id_pegawai, $kode_unor;
	
  function __construct()
  {
    parent::__construct();
    $this->date = date('Y-m-d');
    $this->datetime = date('Y-m-d H:i:s');
		$this->id_user = $this->session->userdata('id');
		$this->id_pegawai = $this->session->userdata('id_pegawai');
		$this->kode_unor = $this->session->userdata('kode_unor');
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
      return $errors;
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

	function unlink_file($path)
	{
		unlink('./assets/clouds/drives/' . $path);
	}
}