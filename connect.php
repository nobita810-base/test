<?php
$ip_sv = "127.0.0.1";
$dbname_sv = "sinh";
$user_sv = "root";
$pass_sv = "";
$_domain = "http://127.0.0.1/";
//GMT +7
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Create connection
$conn = new mysqli($ip_sv, $user_sv, $pass_sv, $dbname_sv);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>