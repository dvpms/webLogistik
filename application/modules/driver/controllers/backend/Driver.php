<?php defined('BASEPATH') or exit('No direct script access allowed');

class Driver extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Data Driver';
		$this->layout_backend('index', $data);
	}
}