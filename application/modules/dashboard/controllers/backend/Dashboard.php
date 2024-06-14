<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Dashboard';
		$this->layout_backend('index', $data);
	}
}
