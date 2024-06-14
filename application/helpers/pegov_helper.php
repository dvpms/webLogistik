<?php 

function login_pegov($username, $password)
{
  $param = http_build_query(['username' => $username, 'password' => $password]);
  $output = curl_post(PEGOV_URL.'/api/authv2/login', $param, PEGOV_UID.':'.PEGOV_PID);
  if ($output) {
    $result['success'] = $output['success'];
    $result['message'] = $output['message'];
    
    $data_foto = get_foto_pegawai($output['data']['id_pegawai']);
    if (!$data_foto) $foto = NULL;
    else $foto = 'https://simasn.tangerangkota.go.id/apps/assets/media/file/'.$username.'/pasfoto/thumb_'.$data_foto;

    $output['data']['foto'] = $foto;
    $result['data'] = $output['data'];
    
    return $result;
  } else {
    return $output;
  }
}
