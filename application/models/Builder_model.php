<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Builder_model extends CI_Model {

	function __construct()
	{
		parent::__construct();	
	}

	function list($table, $where = false, $limit = NULL)
	{
		if ($where) {
			$this->db->where($where);
		}
		if ($limit) {
			$this->db->limit($limit);
		}
		$query = $this->db->get($table);
		return $query->result();
	}

	function find($table, $where)
	{
		$query = $this->db->get_where($table, $where);
		return $query->row();
	}

	function find_select($field, $table, $where)
	{
		$query = $this->db->select($field)->from($table)->where($where)->get();
		return $query->row();
	}

	function find_one($field, $table, $where)
	{
		$query = $this->db->select($field)->from($table)->where($where)->get()->row();
		if ($query) return $query->$field;
		else return $query;
	}

	function store($table, $data, $where = false)
	{
		if ($where) {
			$this->db->where($where);
			$this->db->update($table, $data);
			return $this->db->affected_rows();
		} else {
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
	}
 
	function destroy($table, $where)
	{
		try {
			if ($this->db->where($where)->delete($table)) {
				return true;
			} else {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
	}
}