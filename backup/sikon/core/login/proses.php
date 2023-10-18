<?php
include "../../config/koneksi.php";

$pass		= md5($_POST[password]);
$username	= $_POST[username];

//This is notif category if notification exist
$notif_cat = "login";

$login	= mysql_query("SELECT * FROM user WHERE username='$username' AND active='active' ");
$ketemu	= mysql_num_rows($login);
$r		= mysql_fetch_array($login);

// Apabila username ditemukan
if ($ketemu > 0) {
  if($r[password] == $pass){
    session_register("username");
	session_register("password");
	session_register("name");
	session_register("sessionid");

    $_SESSION[username] = $r[username];
	$_SESSION[passta] 	= $r[passta];
	$_SESSION[name]   	= $r[name];
	$_SESSION[sessionid]= session_id();
	
	//input log data
	include "../../config/library.php";
	$log_activity 	= "User Login";
	$log_comment	= "";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
	   
    //sent to home
	header('location:../../index.php?component=home');
	
  } else {
	$notif_type = "pass_notmatch";
	include "../notifikasi/index.php";
  }
} else {
	$notif_type = "user_notexist";
	include "../notifikasi/index.php";
}
?>