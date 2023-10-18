<?php
include "../../config/koneksi.php";
include "../../config/library.php";

$username 	= mysql_real_escape_string($_POST['id']);

//This is notif category if an notif exist
$notif_cat = "com_user";

if ($_GET[form]=='editprofile') {

	$nama 			= mysql_real_escape_string($_POST['nama']);
	$email 			= mysql_real_escape_string($_POST['email']);
	  
	// validation required field
	if (empty($nama)) {
		$notif_type = "name_na";
		include "../../core/notifikasi/index.php";
		die();
	}

	else if (!eregi($email_exp,$email)) {
		$notif_type = "em_er";
		include "../../core/notifikasi/index.php";
		die();
	}
		
	else {
		//Update database
		mysql_query("UPDATE user SET 	name			= '$nama',
										email           = '$email'
								   WHERE username = '$username'");										

		// tampilkan kalo sukses
		header("location:../../index.php?component=user&act=view&id=$username");
	}
}

if ($_GET[form]=='editpassword') {
	$pass1 	= mysql_real_escape_string($_POST['pass_lama']);
	$pass2	= mysql_real_escape_string($_POST['pass_baru']);
	$pass1	= md5($pass1);
	
	// cek kalo ada password lama sama dengan current password
	$sql  	= mysql_query("SELECT password FROM user WHERE username = '$username'");
	$r    	= mysql_fetch_array($sql);
	
	if ($r[password] != $pass1) {
		$notif_type = "pass_er";
		include "../../core/notifikasi/index.php";
		die();
	}
	else if(empty($pass2)){
        $notif_type = "passb_er";
		include "../../core/notifikasi/index.php";
		die();
	}
	else {
		$pass2 = md5($pass2);
		//Update database
		mysql_query("UPDATE user SET 	password = '$pass2' WHERE username = '$username'");
										
		// tampilkan kalo sukses
		header("location:../../index.php?component=user&act=view&id=$username");
	}
}
?>
