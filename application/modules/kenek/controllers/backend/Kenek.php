<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kenek extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Data Kenek';
		$this->layout_backend('index', $data);
	}
}