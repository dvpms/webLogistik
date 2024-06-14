<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends FMS_Controller
{

	public $menus;

	function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model');
	}

	function index()
	{
		if ($this->session->userdata('is_login')) redirect(site_url('/'));

		$this->_validation();
		if ($this->form_validation->run() == FALSE) {
			$data['page_title'] = 'Login';
			$this->load->view('auth/backend/index', $data);
		} else $this->_login();
	}

	private function _login()
	{
		$username = secure_post('username', true);
		$password = secure_post('password', true);

		$data_user = $this->auth_model->get_data_user($username);
		if (count((array) $data_user) > 0) {
			if ($data_user->is_active == 0) {
				$this->session->set_flashdata('alert', 'Anda tidak diizinkan masuk.');
				redirect(site_url('auth'));
			}

			if ($data_user->password) {
				if (password_verify($password, $data_user->password)) {
					$data = [
						'is_login' => TRUE,
						'id_user_group' => $data_user->id_user_group,
						'id' => $data_user->id,
						'id_unor' => $data_user->id_unor,
						'nomor_hp' => $data_user->nomor_hp,
						'status_asn' => $data_user->status_asn,
						'nama_golongan' => $data_user->nama_golongan,
						'kode_golongan' => $data_user->kode_golongan,
						'status_perkawinan' => $data_user->status_perkawinan,
						'kode_unor' => $data_user->kode_unor,
						'id_pegawai' => $data_user->id_pegawai,
						'nomenklatur_pada' => $data_user->nomenklatur_pada,
						'jab_type' => $data_user->jab_type,
						'id_jenjang_jabatan' => $data_user->id_jenjang_jabatan,
						'nama_jenjang' => $data_user->nama_jenjang,
						'tanggal_lulus' => $data_user->tanggal_lulus,
						'tmt_pangkat' => $data_user->tmt_pangkat,
						'nama_unor' => $data_user->nama_unor,
						'gender' => $data_user->gender,
						'mk_gol_tahun' => $data_user->mk_gol_tahun,
						'username' => $data_user->nip,
						'gelar_nonakademis' => $data_user->gelar_nonakademis,
						'mk_gol_bulan' => $data_user->mk_gol_bulan,
						'instansi' => $data_user->instansi,
						'gelar_belakang' => $data_user->gelar_belakang,
						'nama_jenjang_rumpun' => $data_user->nama_jenjang_rumpun,
						'nama_unor_parent' => $data_user->nama_unor_parent,
						'tmt_cpns' => $data_user->tmt_cpns,
						'tugas_tambahan' => $data_user->tugas_tambahan,
						'agama' => $data_user->agama,
						'user_id' => $data_user->id_user_pegawai,
						'nama_pegawai' => $data_user->nama_pegawai,
						'gelar_depan' => $data_user->gelar_depan,
						'nomor_tlp_rumah' => $data_user->nomor_tlp_rumah,
						'nip' => $data_user->nip,
						'tmt_pns' => $data_user->tmt_pns,
						'nomenklatur_jabatan' => $data_user->nomenklatur_jabatan,
						'kode_ese' => $data_user->kode_ese,
						'tmt_ese' => $data_user->tmt_ese,
						'tmt_jabatan' => $data_user->tmt_jabatan,
						'status_kepegawaian' => $data_user->status_kepegawaian,
						'tempat_lahir' => $data_user->tanggal_lahir,
						'nama_ese' => $data_user->nama_ese,
						'tanggal_lahir' => $data_user->tanggal_lahir,
						'nama_pangkat' => $data_user->nama_pangkat,
						'foto' => $data_user->foto_pegawai,
						'is_pegawai' => $data_user->is_pegawai,
						'json_auth' => json_encode([]),
					];
					$this->session->set_userdata($data);
					$this->builder_model->store('c_users_log', ['nip' => $data_user->nip, 'nama' => $data_user->nama_pegawai, 'login' => $this->datetime]);
					redirect(base_url('eo/dashboard'));
				} else {
					$this->session->set_flashdata('alert', 'Username atau Password yang anda masukkan salah.');
					redirect(site_url('auth'));
				}
			}
		}

		$data_pegawai = login_pegov($username, $password);

		if (count((array) $data_user) > 0) $id_user_group = $data_user->id_user_group;
		else $id_user_group = 2;

		if ((int)$data_pegawai['success'] === 1) {
			if ($data_pegawai['data']['nip'] === 'egov') {
				$data = [
					'is_login' => TRUE,
					'id_user_group' => $id_user_group,
					'id_unor' => $data_pegawai['data']['id_unor'],
					'id_pegawai' => $data_pegawai['data']['id_pegawai'],
					'nomenklatur_pada' => $data_pegawai['data']['nomenklatur_pada'],
					'username' => $data_pegawai['data']['nip'],
					'gelar_nonakademis' => $data_pegawai['data']['gelar_nonakademis'],
					'gelar_belakang' => $data_pegawai['data']['gelar_belakang'],
					'user_id' => $data_pegawai['data']['user_id'],
					'nama_pegawai' => strtoupper($data_pegawai['data']['nama_pegawai']),
					'gelar_depan' => $data_pegawai['data']['gelar_depan'],
					'nip' => $data_pegawai['data']['nip'],
					'nomenklatur_jabatan' => $data_pegawai['data']['nomenklatur_jabatan'],
					'foto' => NULL,
					'is_pegawai' => 1,
				];
				$this->session->set_userdata($data);
			} else {
				$data = [
					'is_login' => TRUE,
					'id_user_group' => $id_user_group,
					'id' => $data_pegawai['data']['id'],
					'id_unor' => $data_pegawai['data']['id_unor'],
					'nomor_hp' => $data_pegawai['data']['nomor_hp'],
					'status_asn' => $data_pegawai['data']['status_asn'],
					'nama_golongan' => $data_pegawai['data']['nama_golongan'],
					'kode_golongan' => $data_pegawai['data']['kode_golongan'],
					'status_perkawinan' => $data_pegawai['data']['status_perkawinan'],
					'kode_unor' => $data_pegawai['data']['kode_unor'],
					'id_pegawai' => $data_pegawai['data']['id_pegawai'],
					'nomenklatur_pada' => $data_pegawai['data']['nomenklatur_pada'],
					'jab_type' => $data_pegawai['data']['jab_type'],
					'id_jenjang_jabatan' => $data_pegawai['data']['id_jenjang_jabatan'],
					'nama_jenjang' => $data_pegawai['data']['nama_jenjang'],
					'tanggal_lulus' => $data_pegawai['data']['tanggal_lulus'],
					'tmt_pangkat' => $data_pegawai['data']['tmt_pangkat'],
					'nama_unor' => $data_pegawai['data']['nama_unor'],
					'gender' => $data_pegawai['data']['gender'],
					'mk_gol_tahun' => $data_pegawai['data']['mk_gol_tahun'],
					'username' => $data_pegawai['data']['nip'],
					'gelar_nonakademis' => $data_pegawai['data']['gelar_nonakademis'],
					'mk_gol_bulan' => $data_pegawai['data']['mk_gol_bulan'],
					'instansi' => $data_pegawai['data']['instansi'],
					'gelar_belakang' => $data_pegawai['data']['gelar_belakang'],
					'nama_jenjang_rumpun' => $data_pegawai['data']['nama_jenjang_rumpun'],
					'nama_unor_parent' => $data_pegawai['data']['nama_unor_parent'],
					'tmt_cpns' => $data_pegawai['data']['tmt_cpns'],
					'tugas_tambahan' => $data_pegawai['data']['tugas_tambahan'],
					'agama' => $data_pegawai['data']['agama'],
					'user_id' => $data_pegawai['data']['user_id'],
					'nama_pegawai' => $data_pegawai['data']['nama_pegawai'],
					'gelar_depan' => $data_pegawai['data']['gelar_depan'],
					'nomor_tlp_rumah' => $data_pegawai['data']['nomor_tlp_rumah'],
					'nip' => $data_pegawai['data']['nip'],
					'tmt_pns' => $data_pegawai['data']['tmt_pns'],
					'nomenklatur_jabatan' => $data_pegawai['data']['nomenklatur_jabatan'],
					'kode_ese' => $data_pegawai['data']['kode_ese'],
					'tmt_ese' => $data_pegawai['data']['tmt_ese'],
					'tmt_jabatan' => $data_pegawai['data']['tmt_jabatan'],
					'status_kepegawaian' => $data_pegawai['data']['status_kepegawaian'],
					'tempat_lahir' => $data_pegawai['data']['tanggal_lahir'],
					'nama_ese' => $data_pegawai['data']['nama_ese'],
					'tanggal_lahir' => $data_pegawai['data']['tanggal_lahir'],
					'nama_pangkat' => $data_pegawai['data']['nama_pangkat'],
					'foto' => $data_pegawai['data']['foto'],
					'is_pegawai' => 1,
					'json_auth' => json_encode($data_pegawai['data'])
				];
				$this->session->set_userdata($data);
			}
			
			$this->auth_model->update_user($data);

			// $this->builder_model->store('c_users_log', ['nip' => $data_pegawai['data']['nip'], 'nama' => $data_pegawai['data']['nama_pegawai'], 'login' => $this->datetime]);
			redirect(base_url('eo/dashboard'));
		} else {
			$this->session->set_flashdata('alert', $data_pegawai['message']);
			redirect(site_url('auth'));
		}
	}

	function logout()
	{
		// $this->builder_model->store('c_users_log', ['nip' => $this->session->userdata('nip'), 'nama' => $this->session->userdata('nama_pegawai'), 'logout' => $this->datetime]);
		$this->session->sess_destroy();
		redirect(site_url('eo'));
	}

	private function _validation()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
	}
}
