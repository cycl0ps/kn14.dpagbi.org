<?php
include("../../config/koneksi.php");
include("../../config/library.php");

$id   = $_POST[userid];

//This is notif category if an notif exist
$notif_cat = "com_admin";


if ($_GET[form]=='edituser') {

	$nama 			= $_POST['nama'];
	$email 			= $_POST['email'];
	$akses_level	= $_POST['akses_level'];
	$active			= $_POST['active'];

	// cek kalo ada username yang sama
	$check = "SELECT username FROM user WHERE username = '$username';";
	$qry = mysql_query($check) or die ("Could not match data because ".mysql_notif());
	$num_rows = mysql_num_rows($qry);

	if ($num_rows != 0) {
		$notif_type = "us_ex";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	else if (empty($nama)) {
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
		// masukkan data kedatabase
		mysql_query("UPDATE user SET	name 		= '$nama',
									email   	= '$email',
									akses_level = '$akses_level',
									active   	= '$active'
								   WHERE user_id = '$id'");										

		//input log data
		session_start();
		$log_activity 	= "Edit User";
		$log_comment	= "$nama $email $akses_level $active";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=admin&act=kelola_user");
	}

}

if ($_GET[form]=='delpendaftar') {
	
	//request data for log
	$sql = mysql_query("SELECT no_registrasi, nama_lengkap FROM biodata WHERE id = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete Pendaftar";
	$log_comment	= "#$r[no_registrasi] $r[nama_lengkap]";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM biodata WHERE id ='$id'");
	
	// tampilkan kalo sukses
	header("location:../../index.php?component=admin&act=del_pendaftar");
}

if ($_GET[form]=='deluser') {

	//request data for log
	$sql = mysql_query("SELECT username, name FROM user WHERE user_id = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete User";
	$log_comment	= "$r[username] $r[name]";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM user WHERE user_id='$id'");
	// tampilkan kalo sukses
	header("location:../../index.php?component=admin&act=kelola_user");
}

if ($_GET[form]=='gantipass') {
	$id 		= $_POST['username'];
	$password 	= $_POST['pass_baru'];
	
	$password 	= md5($password);
	
	//input log data
	session_start();
	$log_activity 	= "Ganti Password";
	$log_comment	= "username $id";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
	
	mysql_query("UPDATE user SET password ='$password' WHERE username='$id'");
	// tampilkan kalo sukses
	header("location:../../index.php?component=admin&act=kelola_user");
}



?>