<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bulanan extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Laporan Bulanan';
		$this->layout_backend('laporan_bulanan/index', $data);
	}
}