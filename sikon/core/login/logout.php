<?php
include "../../config/koneksi.php";
include "../../config/library.php";

session_start();

	$log_activity 	= "User Logout";
	$log_comment	= "";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

session_destroy();
header('location:../login/');
?>
