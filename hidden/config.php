<?php
include_once 'connect.php';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

date_default_timezone_set('Asia/Ho_Chi_Minh');
if (!$conn) {
	die("KHONG THE KET NOI DEN CSDL! VUI LONG KIEM TRA LAI");
} else {
	mysqli_set_charset($conn, 'utf8');
}

function _query($sql)
{
	global $conn;
	return mysqli_query($conn, $sql);
}

function _fetch($sql)
{
	return mysqli_fetch_array(_query($sql));
}

function isset_sql($txt)
{
	global $conn;
	return mysqli_real_escape_string($conn, $txt);
}

function _insert($table, $input, $output)
{
	return "INSERT INTO $table($input) VALUES($output)";
}

function _select($select, $from, $where)
{
	return "SELECT $select FROM $from WHERE $where";
}

function _update($tabname, $input_output, $where)
{
	return "UPDATE $tabname SET $input_output WHERE $where";
}

function _console($txt)
{
	return "<script>console.log('" . htmlspecialchars($txt) . "')</script>";
}

function _alert($txt)
{
	return "<script>alert('" . htmlspecialchars($txt) . "')</script>";
}

function get_string_tinhtrangthe($tinhtrangthe)
{
	switch ($tinhtrangthe) {
		case 0:
		case 99:
			$str = '<span class="text-warning">Pending</span>';
			break;
		case 1:
			$str = '<span class="text-success">Success</span>';
			break;
		case 2:
		case 3:
			$str = '<div class="text-danger">Wrong</div>';
			break;
		default:
			$str = '<span class="text-danger">Error</span>';
			break;
	}
	return $str;
}

function nl2break($string)
{
	return str_replace(array('\r\n"', '\r', '\n'), "<br />", $string);
}

function file_get_contents_curl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function random_transaction_id($length = 6)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}