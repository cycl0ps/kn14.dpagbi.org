<?php
include "../../config/koneksi.php";

$email	= $_POST[email];

//This is notif category if notification exist
$notif_cat = "login";

$login	= mysql_query("SELECT * FROM user WHERE email='$email'");
$ketemu	= mysql_num_rows($login);
$r		= mysql_fetch_array($login);

// Apabila email ditemukan
if ($ketemu > 0) {

	$subject  ='SIKN XIV DPA GBI';
	$headers  = 'From: '."pan-kn14@dpagbi.org\r\n".
		        'Reply-To: '."pan-kn14@dpagbi.org\r\n".
		        'Content-Type: text/plain; charset="iso-8859-1"';
		
	$pesan .= "Berikut data akun anda\n\n";
	$pesan .= "Nama : ".$r[name]."\n";
	$pesan .= "Username : ".$r[username]."\n";
	$pesan .= "Password : ".$r[password]."\n\n";

	@mail($r[email],$subject,$pesan,$headers);

	echo "<center><h3>BERHASIL!</h3>
			<p>Silahkan mengecek email anda di: $email.</p>
			<p><a href='../../index.php'>Login</a>
			</center>";
} else {
	$notif_type = "email_na";
	include "../notifikasi/index.php";
}
?>