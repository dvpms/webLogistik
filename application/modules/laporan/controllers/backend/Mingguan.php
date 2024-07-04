<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mingguan extends FMS_Backend
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = 'Laporan Mingguan';
		$this->layout_backend('laporan_mingguan/index', $data);
	}
}