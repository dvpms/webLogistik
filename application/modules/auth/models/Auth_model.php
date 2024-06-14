<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends FMS_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_data_user($username)
	{
		$this->db->select('a.*, b.name as user_group');
		$this->db->from('c_users a');
		$this->db->join('c_users_group b', 'b.id = a.id_user_group');
		$this->db->where('a.nip', $username);
		// $this->db->where('a.is_active', 1, true);
		return $this->db->get()->row();
	}

	function update_user($data)
	{
		$users = $this->db->get_where('c_users', ['nip' => $data['nip']])->num_rows();
		if ($data['nip'] !== 'egov') {
			$param = [
				'id_user_pegawai' => $data['id'],
				'id_user_group' => $data['id_user_group'],
				'nip' => $data['nip'],
				'nama_pegawai' => $data['nama_pegawai'],
				'id_pegawai' => $data['id_pegawai'],
				'id_unor' => $data['id_unor'],
				'kode_unor' => $data['kode_unor'],
				'nama_unor' => $data['nama_unor'],
				'nomor_hp' => $data['nomor_hp'],
				'gender' => $data['gender'],
				'tempat_lahir' => $data['tempat_lahir'],
				'tanggal_lahir' => $data['tanggal_lahir'],
				'status_asn' => $data['status_asn'],
				'nama_golongan' => $data['nama_golongan'],
				'kode_golongan' => $data['kode_golongan'],
				'status_perkawinan' => $data['status_perkawinan'],
				'nomenklatur_pada' => $data['nomenklatur_pada'],
				'jab_type' => $data['jab_type'],
				'id_jenjang_jabatan' => $data['id_jenjang_jabatan'],
				'nama_jenjang' => $data['nama_jenjang'],
				'tanggal_lulus' => $data['tanggal_lulus'],
				'tmt_pangkat' => $data['tmt_pangkat'],
				'mk_gol_tahun' => $data['mk_gol_tahun'],
				'gelar_nonakademis' => $data['gelar_nonakademis'],
				'mk_gol_bulan' => $data['mk_gol_bulan'],
				'instansi' => $data['instansi'],
				'gelar_belakang' => $data['gelar_belakang'],
				'nama_jenjang_rumpun' => $data['nama_jenjang_rumpun'],
				'nama_unor_parent' => $data['nama_unor_parent'],
				'tmt_cpns' => $data['tmt_cpns'],
				'tugas_tambahan' => $data['tugas_tambahan'],
				'agama' => $data['agama'],
				'gelar_depan' => $data['gelar_depan'],
				'tmt_pns' => $data['tmt_pns'],
				'tmt_jabatan' => $data['tmt_jabatan'],
				'status_kepegawaian' => $data['status_kepegawaian'],
				'nama_ese' => $data['nama_ese'],
				'nama_pangkat' => $data['nama_pangkat'],
				'foto_pegawai' => $data['foto'],
				'is_pegawai' => $data['is_pegawai'],
			];
		} else {
			$param = [
				'id_user_pegawai' => $data['id'],
				'id_user_group' => $data['id_user_group'],
				'nip' => $data['nip'],
				'nama_pegawai' => $data['nama_pegawai'],
				'id_pegawai' => $data['id_pegawai'],
				'foto_pegawai' => NULL,
				'is_pegawai' => $data['is_pegawai'],
			];
		}
		if ($users > 0) {
			$this->builder_model->store('c_users', $param, ['nip' => $data['nip']]);
		} else {
			$this->builder_model->store('c_users', $param);
		}
	}
}
