<?php defined('BASEPATH') or exit('No direct script access allowed');

class Surat extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Surat Jalan';
		$this->layout_backend('index', $data);
	}
}
