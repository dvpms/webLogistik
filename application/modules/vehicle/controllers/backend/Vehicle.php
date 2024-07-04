<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vehicle extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Data Kendaraan';
		$this->layout_backend('index', $data);
	}
}