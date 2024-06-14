<?php

/**
 * @author     Faiz Muhammad Syam, S.Kom
 * @project    E - Office 2023
 * @e-mail     faizmsyam@gmail.com - cafeweb.id@gmail.com
 * @license    Dinas Komunikasi dan Informatika
 */

function day_between_dates($date1, $date2)
{
  $tanggal_awal = date_create($date1);
  $tanggal_akhir = date_create($date2);

  $interval = date_diff($tanggal_awal, $tanggal_akhir);
  $day = 0;
  if ($interval->h >= 1) {
    $day = $interval->days + 1;
  } else {
    $day = $interval->days;
  }
  return $day;
}

function rupiah($jumlah)
{
  $int = number_format($jumlah, 0, '', ',');
  return $int;
}

function currency($jumlah)
{
  $int = number_format(ceil($jumlah), 0, '', '.');
  if ($jumlah < 0)
    return '(' . str_replace('-', '', $int) . ')';
  else if (($jumlah === NULL) or ($jumlah === 0) or ($jumlah === '0') or ($jumlah === ''))
    return '0';
  else
    return $int;
}

function date_indonesian($date, $print_day = false)
{
  $hari = array(
    1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split    = explode('-', $date);
  $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

  if ($print_day) {
    $num = date('N', strtotime($date));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}

function datetime_indonesian($datetime, $print_day = false, $print_time = true)
{
  $hari = array(
    1 =>    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu',
    'Minggu'
  );

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $split1    = explode(' ', $datetime);
  $split_time = explode(':', $split1[1]);
  $time = $split_time[0] . ':' . $split_time[1];
  $split2    = explode('-', $split1[0]);
  $tgl_indo = $split2[2] . ' ' . $bulan[(int) $split2[1]] . ' ' . $split2[0];
  if ($print_time) {
    $tgl_indo = $split2[2] . ' ' . $bulan[(int) $split2[1]] . ' ' . $split2[0] . ' ' . $time . ' WIB';
  }
  if ($print_day) {
    $num = date('N', strtotime($datetime));
    return $hari[$num] . ', ' . $tgl_indo;
  }
  return $tgl_indo;
}

function get_day_indonesian($tanggal)
{
  $datetime = new DateTime($tanggal);
  $day = $datetime->format('N');
  $hari = '';
  switch ($day) {
    case '1':
      $hari = 'Senin';
      break;
    case '2':
      $hari = 'Selasa';
      break;
    case '3':
      $hari = 'Rabu';
      break;
    case '4':
      $hari = 'Kamis';
      break;
    case '5':
      $hari = 'Jumat';
      break;
    case '6':
      $hari = 'Sabtu';
      break;
    case '7':
      $hari = 'Minggu';
      break;
    default:
      # code...
      break;
  }
  return $hari;
}

function get_month_indonesian($tanggal)
{
  $date = explode('-', $tanggal);
  if ($date[1] == '01')
    $mo = "Januari";
  if ($date[1] == '02')
    $mo = "Februari";
  if ($date[1] == '03')
    $mo = "Maret";
  if ($date[1] == '04')
    $mo = "April";
  if ($date[1] == '05')
    $mo = "Mei";
  if ($date[1] == '06')
    $mo = "Juni";
  if ($date[1] == '07')
    $mo = "Juli";
  if ($date[1] == '08')
    $mo = "Agustus";
  if ($date[1] == '09')
    $mo = "September";
  if ($date[1] == '10')
    $mo = "Oktober";
  if ($date[1] == '11')
    $mo = "November";
  if ($date[1] == '12')
    $mo = "Desember";

  return $mo;
}

function get_year($tanggal)
{
  $date = explode('-', $tanggal);
  return $date[0];
}

function get_date_indonesian($date)
{
  $datetime = new DateTime($date);
  $month = $datetime->format('m');
  $bulan = '';
  switch ($month) {
    case '01':
      $bulan = 'Januari';
      break;
    case '02':
      $bulan = 'Februari';
      break;
    case '03':
      $bulan = 'Maret';
      break;
    case '04':
      $bulan = 'April';
      break;
    case '05':
      $bulan = 'Mei';
      break;
    case '06':
      $bulan = 'Juni';
      break;
    case '07':
      $bulan = 'Juli';
      break;
    case '08':
      $bulan = 'Agustus';
      break;
    case '09':
      $bulan = 'September';
      break;
    case '10':
      $bulan = 'Oktober';
      break;
    case '11':
      $bulan = 'November';
      break;
    case '12':
      $bulan = 'Desember';
      break;
    default:
      # code...
      break;
  }
  return $datetime->format('d') . " " . $bulan . " " . $datetime->format('Y');
}

function date_indo_with_day($tanggal)
{
  $hari = array(
    1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
  );
  $bulan = array(
    1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  );
  $split    = explode('-', $tanggal);
  $date = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
  $num = date('N', strtotime($tanggal));
  return $hari[$num] . ', ' . $date;
  return $date;
}

function date_time_slash($date_time)
{
  if ($date_time != NULL && $date_time != '0000-00-00 00:00:00' && $date_time != '-') {
    $ex = explode(" ", $date_time);
    $ex2 = explode("-", $ex[0]);
    $date = "$ex2[2]/$ex2[1]/$ex2[0]";
    return $date . " " . substr($ex[1], 0, 5);
  } else {
    return '-';
  }
}

function date_time_to_server($date_time)
{
  if ($date_time != NULL && $date_time != '0000-00-00 00:00:00') {
    $explode = explode(" ", $date_time);
    $explode2 = explode("/", $explode[0]);
    $date = "$explode2[2]-$explode2[1]-$explode2[0]";
    return $date . " " . $explode[1];
  } else {
    return NULL;
  }
}

function date_slash($date)
{
  if ($date == '' && $date == NULL && $date == '0000-00-00') {
    return '';
  } else {
    $explode = explode("-", $date);
    $data = $explode[2] . "/" . $explode[1] . "/" . $explode[0];
    return $data;
  }
}

function date_to_server($date)
{
  if ($date === '0000-00-00') {
    return NULL;
  } else {
    $explode = explode("/", $date);
    if (empty($explode[2]))
      return '';
    $data = "$explode[2]-$explode[1]-$explode[0]";
    return $data;
  }
}

function indonesian_date($date)
{
  if ($date !== NULL && $date !== '0000-00-00') {
    $date = explode("-", $date);
    if ($date[1] == '01')
      $mo = "Januari";
    if ($date[1] == '02')
      $mo = "Februari";
    if ($date[1] == '03')
      $mo = "Maret";
    if ($date[1] == '04')
      $mo = "April";
    if ($date[1] == '05')
      $mo = "Mei";
    if ($date[1] == '06')
      $mo = "Juni";
    if ($date[1] == '07')
      $mo = "Juli";
    if ($date[1] == '08')
      $mo = "Agustus";
    if ($date[1] == '09')
      $mo = "September";
    if ($date[1] == '10')
      $mo = "Oktober";
    if ($date[1] == '11')
      $mo = "November";
    if ($date[1] == '12')
      $mo = "Desember";
    $data = "$date[2] $mo $date[0]";
    return $data;
  } else {
    return '';
  }
}

function indonesian_time($time, $jam = false)
{
  $split = explode(' ', $time);
  $data = indonesian_date($split[0]) . " ";
  if ($jam = true) {
    $data .= $split[1];
  }
  return $data;
}

function indonesian_date_graphic($tanggal)
{
  $date = explode("-", $tanggal);
  if ($date[1] == "01")
    $mo = "Jan";
  if ($date[1] == "02")
    $mo = "Feb";
  if ($date[1] == "03")
    $mo = "Mar";
  if ($date[1] == "04")
    $mo = "Apr";
  if ($date[1] == "05")
    $mo = "Mei";
  if ($date[1] == "06")
    $mo = "Jun";
  if ($date[1] == "07")
    $mo = "Jul";
  if ($date[1] == "08")
    $mo = "Agu";
  if ($date[1] == "09")
    $mo = "Sep";
  if ($date[1] == "10")
    $mo = "Okt";
  if ($date[1] == "11")
    $mo = "Nov";
  if ($date[1] == "12")
    $mo = "Des";
  $data = (string) $date[2] . " " . $mo;
  return $data;
}

function mysql_count($table, $where_param)
{
  $CI = &get_instance();
  $query = "SELECT count(id) as jumlah FROM $table WHERE $where_param";
  return $CI->db->query($query)->row()->jumlah;
}

function get_age($tanggal_lahir)
{
  $explode = explode('-', $tanggal_lahir);
  $umur = date('Y') - $explode[0];
  return $umur;
}

function is_child($tanggal_lahir)
{
  // apakah ini anak?
  $umur = get_age($tanggal_lahir);
  if ($umur <= 12) $is_anak = true;
  else $is_anak = false;
  return $is_anak;
}

function get_age_indonesian($tanggal_lahir)
{
  $birthDate = new DateTime($tanggal_lahir);
  $today = new DateTime("today");
  if ($birthDate > $today) {
    exit("0 tahun 0 bulan 0 hari");
  }
  $y = $today->diff($birthDate)->y;
  $m = $today->diff($birthDate)->m;
  $d = $today->diff($birthDate)->d;
  return $y . " Tahun " . $m . " Bulan " . $d . " Hari";
}

function currency_to_number($number)
{
  $var = str_replace(".", "", $number);
  $data = str_replace(",", ".", $var);
  return $data;
}

function get_duration($date1, $date2)
{
  $date1 = new DateTime($date1);
  $date2 = new DateTime($date2);
  $durasi = $date1->diff($date2);
  return array('day' => $durasi->d, 'hour' => $durasi->h, 'minute' => $durasi->i);
}

function get_duration_indonesian($date1, $date2)
{
  $durasi = get_duration($date1, $date2);
  $data = $durasi["minute"] . " menit";
  if (0 < $durasi["hour"]) {
    $data = $durasi["hour"] . " jam " . $data;
  }
  if (0 < $durasi["day"]) {
    $data = $durasi["day"] . " hari " . $data;
  }
  return $data;
}

function get_last_id($table, $field)
{
  $CI = &get_instance();
  $query = "SELECT max($field) + 1 as id FROM $table";
  $data = $CI->db->query($query)->row();
  return isset($data->id) ? $data->id : 1;
}

if (!function_exists('str_pad')) {
  function str_pad($number, $length)
  {
    $data = str_pad((string) $number, $length, "0", STR_PAD_LEFT);
    return $data;
  }
}

function export_excel_html($filename)
{
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-type: application/vnd-ms-excel");

  // header untuk nama file
  header("Content-Disposition: attachment; filename=" . $filename . ".xls");
  header("Content-Transfer-Encoding: binary");
}

function export_word_html($filename)
{
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);
  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-type: application/vnd.ms-word");

  // header untuk nama file
  header("Content-Disposition: attachment;Filename=" . $filename . ".doc");
  header("Content-Transfer-Encoding: binary");
}

function secure_get($param)
{
  $CI = &get_instance();
  $string = $CI->input->get($param, true);
  $quote = str_replace("'", "`", $string);
  $result = str_replace(array("?", "\\"), "", $quote);
  return $result;
}

function secure_post($param)
{
  $CI = &get_instance();
  $string = $CI->input->post($param, true);
  $quote = str_replace("'", "`", $string);
  $result = str_replace(array("?", "\\"), "", $quote);
  return $result;
}

function terbilang($number, $with_comma = false)
{
  $before_comma = trim(to_word($number));
  $after_comma = trim(comma($number));
  if ($with_comma) {
    $result = ucwords($result = $before_comma . " koma " . $after_comma);
  } else {
    $result = $before_comma;
  }
  return $result;
}

function to_word($number)
{
  $words = "";
  $arr_number = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($number < 12) {
    $words = " " . $arr_number[$number];
  } else {
    if ($number < 20) {
      $words = to_word($number - 10) . " belas";
    } else {
      if ($number < 100) {
        $words = to_word($number / 10) . " puluh " . to_word($number % 10);
      } else {
        if ($number < 200) {
          $words = "seratus " . to_word($number - 100);
        } else {
          if ($number < 1000) {
            $words = to_word($number / 100) . " ratus " . to_word($number % 100);
          } else {
            if ($number < 2000) {
              $words = "seribu " . to_word($number - 1000);
            } else {
              if ($number < 1000000) {
                $words = to_word($number / 1000) . " ribu " . to_word($number % 1000);
              } else {
                if ($number < 1000000000) {
                  $words = to_word($number / 1000000) . " juta " . to_word($number % 1000000);
                } else {
                  if ($number < 1000000000000.0) {
                    $words = to_word($number / 1000000000) . " milyar " . to_word($number % 1000000000);
                  } else {
                    $words = "undefined";
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  return $words;
}

function comma($number)
{
  $after_comma = stristr($number, ".");
  $arr_number = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan");
  $results = "";
  $length = strlen($after_comma);
  for ($i = 1; $i < $length; $i++) {
    $get = substr($after_comma, $i, 1);
    $results .= " " . $arr_number[$get];
  }
  return $results;
}

function dots($loop)
{
  $dot = "";
  for ($i = 0; $i < $loop; $i++) {
    $dot .= ".";
  }
  return $dot;
}

function space_memory_usage()
{
  $mem_total = memory_get_usage(true);
  $mem_used  = memory_get_usage(false);
  $memory = array($mem_total, $mem_used);
  foreach ($memory as $key => $value) {
    if ($value < 1024) {
      $memory[$key] = $value . ' B';
    } elseif ($value < 1048576) {
      $memory[$key] = round($value / 1024, 2) . ' KB';
    } else {
      $memory[$key] = round($value / 1048576, 2) . ' MB';
    }
  }
  return $memory;
}

function space_disk_usage()
{
  $disktotal = disk_total_space('/');
  $diskfree  = disk_free_space('/');
  $diskuse   = round(100 - (($diskfree / $disktotal) * 100)) . '%';
  return $diskuse;
}

if (!function_exists('get_browser')) {
  function get_browser()
  {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
      return 'Internet explorer';
    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false)
      return 'Internet explorer';
    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false)
      return 'Mozilla Firefox';
    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
      return 'Google Chrome';
    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false)
      return "Opera Mini";
    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false)
      return "Opera";
    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false)
      return "Safari";
    else
      return 'Other';
  }
}

function format_currency($floatcurr, $curr = "IDR", $dec = false)
{
  $currencies["ARS"] = array(2, ",", ".");
  $currencies["AMD"] = array(2, ".", ",");
  $currencies["AWG"] = array(2, ".", ",");
  $currencies["AUD"] = array(2, ".", " ");
  $currencies["BSD"] = array(2, ".", ",");
  $currencies["BHD"] = array(3, ".", ",");
  $currencies["BDT"] = array(2, ".", ",");
  $currencies["BZD"] = array(2, ".", ",");
  $currencies["BMD"] = array(2, ".", ",");
  $currencies["BOB"] = array(2, ".", ",");
  $currencies["BAM"] = array(2, ".", ",");
  $currencies["BWP"] = array(2, ".", ",");
  $currencies["BRL"] = array(2, ",", ".");
  $currencies["BND"] = array(2, ".", ",");
  $currencies["CAD"] = array(2, ".", ",");
  $currencies["KYD"] = array(2, ".", ",");
  $currencies["CLP"] = array(0, "", ".");
  $currencies["CNY"] = array(2, ".", ",");
  $currencies["COP"] = array(2, ",", ".");
  $currencies["CRC"] = array(2, ",", ".");
  $currencies["HRK"] = array(2, ",", ".");
  $currencies["CUC"] = array(2, ".", ",");
  $currencies["CUP"] = array(2, ".", ",");
  $currencies["CYP"] = array(2, ".", ",");
  $currencies["CZK"] = array(2, ".", ",");
  $currencies["DKK"] = array(2, ",", ".");
  $currencies["DOP"] = array(2, ".", ",");
  $currencies["XCD"] = array(2, ".", ",");
  $currencies["EGP"] = array(2, ".", ",");
  $currencies["SVC"] = array(2, ".", ",");
  $currencies["ATS"] = array(2, ",", ".");
  $currencies["BEF"] = array(2, ",", ".");
  $currencies["DEM"] = array(2, ",", ".");
  $currencies["EEK"] = array(2, ",", ".");
  $currencies["ESP"] = array(2, ",", ".");
  $currencies["EUR"] = array(2, ",", ".");
  $currencies["FIM"] = array(2, ",", ".");
  $currencies["FRF"] = array(2, ",", ".");
  $currencies["GRD"] = array(2, ",", ".");
  $currencies["IEP"] = array(2, ",", ".");
  $currencies["ITL"] = array(2, ",", ".");
  $currencies["LUF"] = array(2, ",", ".");
  $currencies["NLG"] = array(2, ",", ".");
  $currencies["PTE"] = array(2, ",", ".");
  $currencies["GHC"] = array(2, ".", ",");
  $currencies["GIP"] = array(2, ".", ",");
  $currencies["GTQ"] = array(2, ".", ",");
  $currencies["HNL"] = array(2, ".", ",");
  $currencies["HKD"] = array(2, ".", ",");
  $currencies["HUF"] = array(0, "", ".");
  $currencies["ISK"] = array(0, "", ".");
  $currencies["INR"] = array(2, ".", ",");
  $currencies["IDR"] = array(2, ",", ".");
  $currencies["IRR"] = array(2, ".", ",");
  $currencies["JMD"] = array(2, ".", ",");
  $currencies["JPY"] = array(0, "", ",");
  $currencies["JOD"] = array(3, ".", ",");
  $currencies["KES"] = array(2, ".", ",");
  $currencies["KWD"] = array(3, ".", ",");
  $currencies["LVL"] = array(2, ".", ",");
  $currencies["LBP"] = array(0, "", " ");
  $currencies["LTL"] = array(2, ",", " ");
  $currencies["MKD"] = array(2, ".", ",");
  $currencies["MYR"] = array(2, ".", ",");
  $currencies["MTL"] = array(2, ".", ",");
  $currencies["MUR"] = array(0, "", ",");
  $currencies["MXN"] = array(2, ".", ",");
  $currencies["MZM"] = array(2, ",", ".");
  $currencies["NPR"] = array(2, ".", ",");
  $currencies["ANG"] = array(2, ".", ",");
  $currencies["ILS"] = array(2, ".", ",");
  $currencies["TRY"] = array(2, ".", ",");
  $currencies["NZD"] = array(2, ".", ",");
  $currencies["NOK"] = array(2, ",", ".");
  $currencies["PKR"] = array(2, ".", ",");
  $currencies["PEN"] = array(2, ".", ",");
  $currencies["UYU"] = array(2, ",", ".");
  $currencies["PHP"] = array(2, ".", ",");
  $currencies["PLN"] = array(2, ".", " ");
  $currencies["GBP"] = array(2, ".", ",");
  $currencies["OMR"] = array(3, ".", ",");
  $currencies["RON"] = array(2, ",", ".");
  $currencies["ROL"] = array(2, ",", ".");
  $currencies["RUB"] = array(2, ",", ".");
  $currencies["SAR"] = array(2, ".", ",");
  $currencies["SGD"] = array(2, ".", ",");
  $currencies["SKK"] = array(2, ",", " ");
  $currencies["SIT"] = array(2, ",", ".");
  $currencies["ZAR"] = array(2, ".", " ");
  $currencies["KRW"] = array(0, "", ",");
  $currencies["SZL"] = array(2, ".", ", ");
  $currencies["SEK"] = array(2, ",", ".");
  $currencies["CHF"] = array(2, ".", "'");
  $currencies["TZS"] = array(2, ".", ",");
  $currencies["THB"] = array(2, ".", ",");
  $currencies["TOP"] = array(2, ".", ",");
  $currencies["AED"] = array(2, ".", ",");
  $currencies["UAH"] = array(2, ",", " ");
  $currencies["USD"] = array(2, ".", ",");
  $currencies["VUV"] = array(0, "", ",");
  $currencies["VEF"] = array(2, ",", ".");
  $currencies["VEB"] = array(2, ",", ".");
  $currencies["VND"] = array(0, "", ".");
  $currencies["ZWD"] = array(2, ".", " ");
  if ($curr == "INR") {
    return format_inr($floatcurr);
  }
  if ($dec) {
    return number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
  }
  $result = number_format($floatcurr, $currencies[$curr][0], $currencies[$curr][1], $currencies[$curr][2]);
  return str_replace(",00", "", $result);
}
function format_inr($input)
{
  $dec = "";
  $pos = strpos($input, ".");
  if ($pos !== false) {
    $dec = substr(round(substr($input, $pos), 2), 1);
    $input = substr($input, 0, $pos);
  }
  $num = substr($input, -3);
  $input = substr($input, 0, -3);
  while (0 < strlen($input)) {
    $num = substr($input, -2) . "," . $num;
    $input = substr($input, 0, -2);
  }
  return $num . $dec;
}
function number_to_currency($input)
{
  $nominal = explode(".", $input);
  if (fmod($input, 1) !== 0) {
    return format_currency($input);
  }
  return currency($nominal[0]);
}

function curl_get($url, $auth = null, $header = null)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  if ($auth !== null) curl_setopt($ch, CURLOPT_USERPWD, $auth);
  if ($header !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  $output = curl_exec($ch);
  curl_close($ch);
  return json_decode($output, true);
}

function curl_post($url, $data, $auth = null, $header = null)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  if ($auth !== null) curl_setopt($ch, CURLOPT_USERPWD, $auth);
  if ($header !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $output = curl_exec($ch);
  curl_close($ch);
  return json_decode($output, true);
}

function curl_custom($method, $url, $data, $auth = null, $header = null)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  if ($auth !== null) curl_setopt($ch, CURLOPT_USERPWD, $auth);
  if ($header !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $output = curl_exec($ch);
  curl_close($ch);
  return json_decode($output, true);
}

function round_two($number)
{
  $padded = sprintf('%0.2f', $number);
  return $padded;
}

function number_format_short($n, $precision = 1)
{
  if ($n < 900) {
    // 0 - 900
    $n_format = number_format($n, $precision);
    $suffix = '';
  } else if ($n < 900000) {
    // 0.9k-850k
    $n_format = number_format($n / 1000, $precision);
    $suffix = 'K';
  } else if ($n < 900000000) {
    // 0.9m-850m
    $n_format = number_format($n / 1000000, $precision);
    $suffix = 'M';
  } else if ($n < 900000000000) {
    // 0.9b-850b
    $n_format = number_format($n / 1000000000, $precision);
    $suffix = 'B';
  } else {
    // 0.9t+
    $n_format = number_format($n / 1000000000000, $precision);
    $suffix = 'T';
  }

  if ($precision > 0) {
    $dotzero = '.' . str_repeat('0', $precision);
    $n_format = str_replace($dotzero, '', $n_format);
  }

  return $n_format . $suffix;
}

function dd($array = [])
{
  echo '<pre>';
  print_r($array);
  die;
  echo '</pre>';
}

function is_not_null($var)
{
  return !is_null($var);
}

function numbertochar($number)
{
  $num = array(1 => ' (satu) ', 2 => ' (dua) ', 3 => ' (tiga) ', 4 => ' (empat) ', 5 => ' (lima) ', 6 => ' (enam) ', 7 => ' (tujuh) ', 8 => ' (delapan) ', 9 => ' (sembilan) ', 10 => ' (sepuluh) ');
  return $num[$number];
}

function get_working_days($startDate, $endDate, $holidays)
{
  $debug = true;
  $work = 0;
  $nowork = 0;
  $dayx = strtotime($startDate);
  $endx = strtotime($endDate);

  while ($dayx <= $endx) {
    $day = date('N', $dayx);
    $date = date('Y-m-d', $dayx);
    if ($day > 5 || in_array($date, $holidays)) {
      $nowork++;
    } else $work++;
    $dayx = strtotime($date . ' +1 day');
  }
  return $work;
}

function get_browser_now()
{
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version = "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  } elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  } elseif (preg_match('/Firefox/i', $u_agent)) {
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  } elseif (preg_match('/Chrome/i', $u_agent)) {
    $bname = 'Google Chrome';
    $ub = "Chrome";
  } elseif (preg_match('/Safari/i', $u_agent)) {
    $bname = 'Apple Safari';
    $ub = "Safari";
  } elseif (preg_match('/Opera/i', $u_agent)) {
    $bname = 'Opera';
    $ub = "Opera";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }

  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
      $version = $matches['version'][0];
    } else {
      $version = $matches['version'][1];
    }
  } else {
    $version = $matches['version'][0];
  }

  // check if we have a number
  if ($version == null || $version == "") {
    $version = "?";
  }

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'    => $pattern
  );
}

//fungsi untuk mencocokan teks di dalam array
function strposa(
  $haystack,
  $needles = array()
) {
  $status = false;
  foreach ($needles as $needle) {
    // $res = strpos(strtolower($haystack), strtolower($needle));
    if (strpos(
      strtolower($haystack),
      strtolower($needle)
    ) !== false) {
      $status = true;
      break;
    }
  }

  return $status;
}
