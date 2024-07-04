<?php defined('BASEPATH') or exit('No direct script access allowed');

class Harian extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Laporan Harian';
		$this->layout_backend('laporan_harian/index', $data);
	}
}