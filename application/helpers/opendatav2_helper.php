<?php

/**
 * @author     Faiz Muhammad Syam, S.Kom
 * @project    E - Office 2023
 * @e-mail     faizmsyam@gmail.com - cafeweb.id@gmail.com
 * @license    Dinas Komunikasi dan Informatika
 */

function login_opendata($username, $password)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/auth/login_v2/uid/" . $username . "/pid/" . $password;
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result['success']) :
    $result['data']['foto'] = 'https://simasn.tangerangkota.go.id/apps/assets/media/file/'.$username.'/pasfoto/' . get_foto_pegawai($result['data']['id_pegawai']);
    return $result;
  else :
    return $result;
  endif;
}

function get_foto_pegawai($iid)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/pegawai/ini_pegawai_foto/idd/" . $iid;
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result['file_dokumen'];
  else :
    return $result;
  endif;
}

function get_data_pegawai($nip)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/pegawai/pegawaibynip/nip/" . $nip;
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_skpd()
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/unor/unor_parent";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_skpd_by_id_unor($id_unor)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/unor/get_unor_by_id/id_unor/" . $id_unor;
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_skpd_by_kode_unor($kode_unor)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/unor/get_unor_by_kode/kode_unor/" . $kode_unor;
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

// siak
function get_data_agama()
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/agama_all/";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_agama_by_id($id_agama)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/agama_byid/id_agama/$id_agama";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_golongan_darah()
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/goldrh_all/";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_golongan_darah_by_id($id_goldarah)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/goldrh_byid/id_goldrh/$id_goldarah";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_pekerjaan()
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/pekerjaan_all/";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_pekerjaan_by_id($id_pekerjaan)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/pekerjaan_byid/id_pekerjaan/$id_pekerjaan";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_pendidikan()
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/pendidikan_all/";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_pendidikan_by_id($id_pendidikan)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/siakatribut/pendidikan_byid/id_pendidikan/$id_pendidikan";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

// wilayah
function get_data_propinsi()
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/propinsi_all";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_propinsi_by_no_prop($no_prop)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/propinsi/no_prop/$no_prop";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_kabupaten($no_prop)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/kabupaten/no_prop/$no_prop";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_kabupaten_by_no_kab($no_prop, $no_kab)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/kabupatenbyidkab/no_prop/$no_prop/no_kab/$no_kab";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_kecamatan($no_prop, $no_kab)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/kecamatan/no_prop/$no_prop/no_kab/$no_kab";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_kecamatan_by_no_kec($no_prop, $no_kab, $no_kec)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/kecamatanbyidkab/no_prop/$no_prop/no_kab/$no_kab/no_kec/$no_kec";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_kelurahan($no_prop, $no_kab, $no_kec)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/kelurahan/no_prop/$no_prop/no_kab/$no_kab/no_kec/$no_kec";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_kelurahan_by_no_kel($no_prop, $no_kab, $no_kec, $no_kel)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/wilayah/kelurahanbyidkab/no_prop/$no_prop/no_kab/$no_kab/no_kec/$no_kec/no_kel/$no_kel";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_nik($idd)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/eoffice_2018/data_r_pegawai/get_data_nik/id_pegawai/'.$idd.'/format/json";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function get_data_mk_golongan($idd)
{
  $useragent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
  $json_url = OPENDATA_URL . "/eoffice_2018/data_r_pegawai/get_data_mk_golongan/id_pegawai/'.$idd.'/format/json";
  $ch = curl_init($json_url);
  curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, OPENDATA_UID . ':' . OPENDATA_PID);
  $result = json_decode(curl_exec($ch), true);
  if ($result) :
    return $result;
  else :
    return $result;
  endif;
}

function send_to_aktifitas($data)
{
  $auth = OPENDATA_UID . ':' . OPENDATA_PID;
  $result = curl_post(OPENDATA_URL . "/eoffice_2018/surat/create_aktifitas", $data, $auth);
  return $result;
}

function update_data_id($data)
{
  $auth = OPENDATA_UID . ':' . OPENDATA_PID;
  $data_json = json_encode($data);
  $result = curl_post(OPENDATA_URL . "/eaudit_v2/inbox/update_data_id", ['data_json' => $data_json], $auth);
  return $result;
}

function data_dashboard($id_pegawai = '')
{

  $auth = OPENDATA_UID . ':' . OPENDATA_PID;
  $result = curl_post(OPENDATA_URL . "/eoffice_2018/dashboard/get_count_notification_v2", ['id_pegawai' => $id_pegawai, 'website' => true], $auth);
  if ($result['success']) {
    $result = $result['data'];
  } else {
    $result = NULL;
  }
  return $result;
}
