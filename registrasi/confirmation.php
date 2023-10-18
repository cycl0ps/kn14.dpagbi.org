<?php
include "config/library.php";
include "config/koleksi_fungsi.php";
include "config/fungsi_combobox.php";
include "config/koneksi.php";

$nama_lengkap	= mysql_real_escape_string($_POST['nama']);
$jenis_kelamin	= mysql_real_escape_string($_POST['jenis_kelamin']);
$tempat_lahir	= mysql_real_escape_string($_POST['tempat_lahir']);
$tgl_lahir		= mysql_real_escape_string($_POST['tgl_lahir']);
$bln_lahir		= mysql_real_escape_string($_POST['bln_lahir']);
$thn_lahir		= mysql_real_escape_string($_POST['thn_lahir']);
$negara			= mysql_real_escape_string($_POST['negara']);
$propinsi		= mysql_real_escape_string($_POST['propinsi']);
$kabkota		= mysql_real_escape_string($_POST['kabkota']);
$alamat			= mysql_real_escape_string($_POST['alamat']);
$kodepos		= mysql_real_escape_string($_POST['kodepos']);
$no_tlp			= mysql_real_escape_string($_POST['no_tlp']);
$no_hp			= mysql_real_escape_string($_POST['no_hp']);
$email			= mysql_real_escape_string($_POST['email']);
$pekerjaan		= mysql_real_escape_string($_POST['pekerjaan']);

$gelar			= mysql_real_escape_string($_POST['gelar']);
$gembala		= mysql_real_escape_string($_POST['gembala']);
$alamat_grj		= mysql_real_escape_string($_POST['alamat_grj']);
$tlp_grj		= mysql_real_escape_string($_POST['tlp_grj']);
$fax_grj		= mysql_real_escape_string($_POST['fax_grj']);
$asal_pd		= mysql_real_escape_string($_POST['asal_pd']);
$jabatan_kpa	= mysql_real_escape_string($_POST['jabatan_kpa']);
$ketua_kpa		= mysql_real_escape_string($_POST['ketua_kpa']);
$komisi			= mysql_real_escape_string($_POST['komisi']);

$sphere			= mysql_real_escape_string($_POST['sphere']);

$arrive_by		= mysql_real_escape_string($_POST['arrive_by']);
$arrive_tgl		= mysql_real_escape_string($_POST['arrive_tgl']);
$arrive_bln		= mysql_real_escape_string($_POST['arrive_bln']);
$arrive_thn		= mysql_real_escape_string($_POST['arrive_thn']);
$arrive_jam		= mysql_real_escape_string($_POST['arrive_jam']);

// cek kalo ada username yang sama
$check = "SELECT nama_lengkap, tanggal_lahir FROM biodata 
				WHERE nama_lengkap = '$nama_lengkap' AND tanggal_lahir='$thn_lahir-$bln_lahir-$tgl_lahir'";
$qry = mysql_query($check) or die ("Could not match data because ".mysql_notif());
$num_rows = mysql_num_rows($qry);

if ($num_rows != 0) {
	$notif_type = "al_regis";
	include "notifikasi.php";
	die();
}

else if (empty($nama_lengkap)) {
	$notif_type = "na_na";
	include "notifikasi.php";
	die();
}

else if (empty($jenis_kelamin)) {
	$notif_type = "jk_na";
	include "notifikasi.php";
	die();
}

else if (empty($tempat_lahir)) {
	$notif_type = "tmptlh_na";
	include "notifikasi.php";
	die();
}
		
else if (empty($tgl_lahir)) {
	$notif_type = "tgl_na";
	include "notifikasi.php";
	die();
}
		
else if (empty($bln_lahir)) {
	$notif_type = "bln_na";
	include "notifikasi.php";
	die();
}
		
else if (empty($thn_lahir)) {
	$notif_type = "thn_na";
	include "notifikasi.php";
	die();
}

else if (empty($negara)) {
	$notif_type = "neg_na";
	include "notifikasi.php";
	die();
}

else if ($negara==107 AND empty($propinsi)) {
	$notif_type = "prop_na";
	include "notifikasi.php";
	die();
}

else if ($negara==107 AND empty($kabkota)) {
	$notif_type = "kabkota_na";
	include "notifikasi.php";
	die();
}

else if (empty($alamat)) {
	$notif_type = "al_na";
	include "notifikasi.php";
	die();
}
		
else if (!eregi($nim_exp,$no_hp)) {
	$notif_type = "hp_er";
	include "notifikasi.php";
	die();
}
		
else if (!eregi($email_exp,$email)) {
	$notif_type = "em_er";
	include "notifikasi.php";
	die();	
} 

else if (empty($asal_pd)) {
	$notif_type = "pd_na";
	include "notifikasi.php";
	die();
}

else if (empty($sphere)) {
	$notif_type = "sp_na";
	include "notifikasi.php";
	die();
} 

else if (empty($komisi)) {
	$notif_type = "ko_na";
	include "notifikasi.php";
	die();
}
else {

	//Konversi String
	$nama_lengkap = convertCaps($nama_lengkap);
	$tempat_lahir = convertCaps($tempat_lahir);
	$alamat = convertCaps($alamat);
	$email = strtolower($email);
	$ketua_kpa = convertCaps($ketua_kpa);

	//Set no registrasi
	$r	 = mysql_fetch_array(mysql_query("SELECT no_registrasi FROM biodata ORDER BY no_registrasi DESC"));
	$lastId = $r['no_registrasi'];
	$no_registrasi = noRegistrasi($lastId, $tgl_bln_sekarang);

	mysql_query("INSERT INTO biodata(no_registrasi, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat,
										kab_kota, propinsi, negara, kodepos, no_tlp, no_hp, email, pekerjaan, 
										nama_gembala, alamat_grj, tlp_grj, fax_grj, asal_pd, jabatan_kpa, ketua_kpa,
										komisi, sphere, arrive_by, arrive_date,
										arrive_time, reg_date)
					VALUES ('$no_registrasi', '$nama_lengkap', '$tempat_lahir', '$thn_lahir-$bln_lahir-$tgl_lahir', '$jenis_kelamin', 
										'$alamat', '$kabkota', '$propinsi', '$negara', '$kodepos', '$no_tlp', '$no_hp', '$email', 
										'$pekerjaan', '$gelar $gembala', '$alamat_grj', '$tlp_grj', '$fax_grj', '$asal_pd', 
										'$jabatan_kpa', '$ketua_kpa', '$komisi', 
										'$sphere', '$arrive_by', '$arrive_thn-$arrive_bln-$arrive_tgl', '$arrive_jam', '$waktu_sekarang')");


	if (!empty($email)) {
		include "kirimemail.php";
	}										

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulir Pendaftaran KN XIV DPA GBI 2013</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="knicon.ico" rel="shortcut icon" type="image/x-icon">
	<script type='text/javascript' src='js/common.js'></script>
</head>

<body>
<div id="header">
		<?php include_once "header.php" ?>
</div>


<h1>Terima Kasih</h1>

<div id="div01">
<p>Aplikasi anda akan segera kami proses. Nomor Registrasi anda adalah: <span class="emp2"><?php echo "#$no_registrasi"; ?></span>. Mohon anda dapat mencatat nomor registrasi ini, yang nantinya diperlukan pada saat konfirmasi pembayaran dan Registrasi-Ulang.</p>
</div>
<div id="div02">
<p>Silahkan melakukan pembayaran yang dapat disetorkan ke rekening:</p>
<ol>
<li>BCA cab. Ranotana No. 780-0202-099. a/n. Chandra Manalip &amp; Nico Edwin Paath</li>
<li>BRI cab. MTC Manado No. 2024-01-002668-50-5. a/n. Panitia Kongres Nasional DPA GBI</li>
</ol>
</div>
<div id="div01">
<h3>Ketentuan Pendaftaran Kongres Nasional XIV DPA GBI</h3>
<ol>
  <li>Bukti Pembayaran/Transfer harap dikirim melalui fax/email ke Panitia Pelaksana Kongres.</li>
  <li>Panpel KN akan memberikan Bukti Pendaftaran setelah formulir pendaftaran dan biaya pendaftaran telah diterima. Jika peserta belum menerima bukti pendaftaran, dapat menghubungi panpel KN untuk minta dikirimkan/difax/diemail, atau peserta minta nomor bukti pendaftaran.</li>
  <li>Bukti Pendaftaran, bukti transfer, atau nomor bukti pendaftaran harap dibawa dan ditunjukkan atau disebutkan pada waktu registrasi ulang.</li>
  <li>Pergantian peserta (perubahan nama) harap diberitahukan kepada panpel paling lambat tanggal 13 Agustus 2013. Jika peserta tidak memberitahukannya, maka segala resiko akan menjadi tanggungan peserta (khususnya nama pada nametag dan akomodasi pria/wanita).</li>
  <li>Peserta yang membatalkan keikutsertaannya dalam Kongres Nasional XIV DPA GBI tidak dapat meminta pengembalian uang pendaftaran yang telah dibayarkan.</li>
  <li>PP DPA GBI dan Panitia Pelaksana Kongres, TIDAK menanggung akomodasi dan konsumsi, maupun transport lokal maupun pulang diluar waktu Kongres Nasional</li>
  </ol>
<p align="center"><a href="http://kn14.dpagbi.org">Kembali ke website KN-XIV</a></p>
</div>
<div id="footer">
<?php include_once "footer.php" ?>
</div>

</body>
</html>