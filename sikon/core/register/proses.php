<?php
include("../../config/koneksi.php");
include("../../config/library.php");
include("../../config/koleksi_fungsi.php");

$username 		= $_POST['username'];
$nama 			= $_POST['nama'];
$email 			= $_POST['email'];
$password 		= $_POST['password'];

$username 		= strtolower($username);
$nama 			= convertCaps($nama);
$email			= strtolower($email);

//This is notif category if notification exist
$notif_cat = "register";

// cek kalo ada username yang sama
$check = "SELECT username FROM user WHERE username = '$username';";
$qry = mysql_query($check) or die ("Could not match data because ".mysql_notif());
$num_rows = mysql_num_rows($qry);
if ($num_rows != 0) {
	$notif_type = "us_ex";
	include "../notifikasi/index.php";
	die();
}

else if (empty($username)) {
	$notif_type = "username_na";
	include "../notifikasi/index.php";
	die();
}

else if (str_word_count($username)>1) {
	$notif_type = "us_er";
	include "../notifikasi/index.php";
	die();
}

else if (empty($nama)) {
	$notif_type = "name_na";
	include "../notifikasi/index.php";
	die();
}
	
else if (!eregi($email_exp,$email)) {
	$notif_type = "em_er";
	include "../notifikasi/index.php";
	die();
}
	
else if (empty($password)) {
	$notif_type = "pass_na";
	include "../notifikasi/index.php";
	die();
}

else {
	$password = md5($password);
	// masukkan data kedatabase
	mysql_query("INSERT INTO user(username, name, email, password)
							VALUES ('$username', '$nama', '$email', '$password')");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Sukses - Sistem Informasi KN XIV DPA-GBI</title>
		<link href="../../images/style.css" rel="stylesheet" type="text/css">
		<link href="../../images/knicon.ico" rel="shortcut icon" type="image/x-icon">
	</head>
	<body>
		<div id="header"></div>
		<div id="successBox">
			<div class='contentHeading'>Formulir Pendaftaran Username SIK0N</div>
				Terima kasih <?php echo $nama ?>, <br>akun anda pada SIK0N telah berhasil dibuat<br><br>
				Hubungi administrator, untuk mengaktifkan akun anda. <a href=../login/>Login</a>
		</div>
	</body>
</html>

<?php } ?>