<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collection_model extends FMS_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function list_user_groups()
	{
		return $this->db->get('c_users_group')->result();
	}
}
