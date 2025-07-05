<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
	ini_set('display_errors', 0);  // Tắt hiển thị lỗi
error_reporting(0);           // Tắt tất cả các loại lỗi
}

include_once 'config.php';
include_once 'server_config.php';

$_user = isset($_SESSION['account']) ? $_SESSION['account'] : null;
if ($_user != null) {
	$_login = "on";
	$user_arr = _fetch("SELECT * FROM account Where username='$_user'");
	if (!$user_arr) {
		header("location:/?out");
	}
	$_uid = $user_arr['id'];
	$_username = htmlspecialchars($user_arr['username']);
	$_coin = $user_arr['coin'];
	$_vnd = $user_arr['vnd'];
	$_tvnd = htmlspecialchars($user_arr['tongnap']);
	$_magioithieu = $user_arr['gioithieu'];
	$_status = $user_arr['active'];
	$_ticket = $user_arr['luotquay'];
} else {
	$_login = null;
}

if (isset($_GET['out'])) {
	session_destroy();
	header("location:/");
}