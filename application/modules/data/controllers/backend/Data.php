<?php defined('BASEPATH') or exit('No direct script access allowed');

class Data extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Data Pengiriman';
		$this->layout_backend('index', $data);
	}
}