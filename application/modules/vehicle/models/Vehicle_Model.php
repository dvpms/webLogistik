<?php defined('BASEPATH') or exit('No direct script access allowes');

class Vehicle_Model extends CI_Model 
{
    protected $table;

function __construct()
    {
        parent::__construct();
        $this->table = 'c_vehicle';
    }

function get_list_data($start, $limit, $search) {
    $where_param = "";
    if ($search['keyword'] != '') {
        $where_param .= " AND (a.nama_kendaraan LIKE '%" . $search['keyword'] . "%'";
        $where_param .= " OR a.plat_kendaraan LIKE '%" . $search['keyword'] . "%')";
    }

    $limitation = "";
    if ($limit !== 0) {
        $limitation = " LIMIT " . $start . " , " . $limit;
    }

    $sql = "SELECT id, nama_kendaraan, plat_kendaraan, foto_kendaraan
            FROM c_vehicle
            WHERE id IS NOT NULL
            $where_param";

    $order = " ORDER BY nama_kendaraan ASC";
    $result["data"] = $this->db->query($sql . $order . $limitation)->result();
    $result["jumlah"] = $this->db->query($sql)->num_rows();
    $this->db->close();
    return $result;
    }
}