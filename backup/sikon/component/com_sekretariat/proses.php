<?php
include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/koleksi_fungsi.php";

//This is notif category if an notif exist
$notif_cat = "com_sekretariat";

if ($_GET[act]=='konfirmasi_pembayaran') {
	$no_registrasi 	= $_POST[no_registrasi];
	$tgl_byr 		= $_POST[tgl_byr];
	$bln_byr 		= $_POST[bln_byr];
	$thn_byr		= $_POST[thn_byr];
	$jml_bayar		= $_POST[jml_bayar];
	$metode_byr		= $_POST[metode_byr];
	
	if (empty($tgl_byr)) {
		$notif_type = "tglbayar_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	if (empty($bln_byr)) {
		$notif_type = "blnbayar_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	if ($jml_bayar == "") {
		$notif_type = "jmlbayar_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	if (empty($metode_byr)) {
		$notif_type = "mtdbayar_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	else {
		$sql = mysql_query("SELECT asal_pd, jenis_kelamin
								FROM biodata WHERE no_registrasi = '$no_registrasi'");
		$r  = mysql_fetch_array($sql);
	
		$no_peserta = noPeserta($r[asal_pd], $r[jenis_kelamin]);
		
		mysql_query("INSERT INTO pembayaran(no_peserta, no_registrasi, tanggal_bayar, jumlah_bayar,
											metode_bayar, trans_date)
							VALUES ('$no_peserta', '$no_registrasi', '$thn_byr-$bln_byr-$tgl_byr', $jml_bayar,
										'$metode_byr', '$waktu_sekarang')");
	
		mysql_query("UPDATE biodata SET status='Peserta',
											no_peserta ='$no_peserta'
										WHERE no_registrasi='$no_registrasi'");
		
		$message = "<h2>Konfirmasi pembayaran berhasil!</h2>
					No. Registrasi: <span style='emp1'>#$no_registrasi</span><br />
					No. Peserta : <span style='emp1'>$no_peserta</span>
					<p><a href=../../index.php?component=sekretariat&act=konfirmasi_pembayaran>[kembali]</a></p>";
					
	
		//input log data
		session_start();
		$log_activity 	= "Konfirmasi Pembayaran";
		$log_comment	= "#$no_registrasi $no_peserta";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	}
}

if ($_GET[act]=='edit_biodata') {

	$nopes			= mysql_real_escape_string($_POST['nopes']);
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

	$nama_gembala	= mysql_real_escape_string($_POST['nama_gembala']);
	$alamat_grj		= mysql_real_escape_string($_POST['alamat_grj']);
	$tlp_grj		= mysql_real_escape_string($_POST['tlp_grj']);
	$fax_grj		= mysql_real_escape_string($_POST['fax_grj']);
	$asal_pd		= mysql_real_escape_string($_POST['asal_pd']);
	$jabatan_kpa	= mysql_real_escape_string($_POST['jabatan_kpa']);
	$ketua_kpa		= mysql_real_escape_string($_POST['ketua_kpa']);
	$komisi		= mysql_real_escape_string($_POST['komisi']);

	$sphere			= mysql_real_escape_string($_POST['sphere']);

	$arrive_by		= mysql_real_escape_string($_POST['arrive_by']);
	$arrive_tgl		= mysql_real_escape_string($_POST['arrive_tgl']);
	$arrive_bln		= mysql_real_escape_string($_POST['arrive_bln']);
	$arrive_thn		= mysql_real_escape_string($_POST['arrive_thn']);
	$arrive_jam		= mysql_real_escape_string($_POST['arrive_jam']);

	if (empty($nama_lengkap)) {
		$notif_type = "na_na";
		include "../../core/notifikasi/index.php";
		die();
	}

	else if (empty($jenis_kelamin)) {
		$notif_type = "jk_na";
		include "../../core/notifikasi/index.php";
		die();
	}

	else if (empty($tempat_lahir)) {
		$notif_type = "tmptlh_na";
		include "../../core/notifikasi/index.php";
		die();
	}
		
	else if ($negara==107 AND empty($propinsi)) {
		$notif_type = "prop_na";
		include "../../core/notifikasi/index.php";
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

	else if (empty($komisi)) {
		$notif_type = "ko_na";
		include "notifikasi.php";
		die();
	}
	
	else {
	
		mysql_query("UPDATE	biodata SET	nama_lengkap 	= '$nama_lengkap',
										tempat_lahir	= '$tempat_lahir', 
										tanggal_lahir	= '$thn_lahir-$bln_lahir-$tgl_lahir', 
										jenis_kelamin	= '$jenis_kelamin', 
										alamat			= '$alamat',
										kab_kota		= '$kabkota', 
										propinsi		= '$propinsi', 
										negara			= '$negara', 
										kodepos			= '$kodepos', 
										no_tlp			= '$no_tlp', 
										no_hp			= '$no_hp', 
										email			= '$email', 
										pekerjaan		= '$pekerjaan', 
										nama_gembala	= '$nama_gembala', 
										alamat_grj		= '$alamat_grj', 
										tlp_grj			= '$tlp_grj', 
										fax_grj			= '$fax_grj', 
										asal_pd			= '$asal_pd', 
										jabatan_kpa		= '$jabatan_kpa', 
										ketua_kpa		= '$ketua_kpa',
										komisi			= '$komisi', 
										sphere			= '$sphere', 
										arrive_by		= '$arrive_by', 
										arrive_date		= '$arrive_thn-$arrive_bln-$arrive_tgl',
										arrive_time		= '$arrive_jam'
									WHERE no_peserta='$nopes'");
									
		//input log data
		session_start();
		$log_activity 	= "Edit Biodata Peserta";
		$log_comment	= "ID Peserta $nopes $nama_lengkap";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		$message = "<h2>Data Peserta Berhasil diubah</h2>
					No. Peserta : <span style='emp1'>$nopes</span><br />
					Nama : <span style='emp1'>$nama_lengkap</span>
					<p><a href=../../index.php?component=sekretariat&act=edit_biodata&nopes=$nopes>[kembali]</a></p>";	
	}
}

if ($_GET[act]=='tambah_penginapan') {

	$nama 			= $_POST['nama_penginapan'];
	$alamat 		= $_POST['alamat_penginapan'];
	$kapasitas		= $_POST['kapasitas'];
	$flag			= $_POST['flag'];
	
	
		// masukkan data kedatabase
		mysql_query("INSERT INTO penginapan(nama_penginapan, alamat_penginapan, kapasitas, flag)
							VALUES ('$nama', '$alamat', '$kapasitas', '$flag')");									

		//input log data
		session_start();
		$log_activity 	= "Tambah Penginapan";
		$log_comment	= "$nama - kapasitas $kapasitas";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_penginapan");

}

if ($_GET[act]=='edit_penginapan') {

	$id				= $_POST['id'];
	$nama 			= $_POST['nama_penginapan'];
	$alamat 		= $_POST['alamat_penginapan'];
	$kapasitas		= $_POST['kapasitas'];
	$flag			= $_POST['flag'];

		// masukkan data kedatabase
		mysql_query("UPDATE penginapan SET	nama_penginapan 	= '$nama',
											alamat_penginapan	= '$alamat',
											kapasitas			= '$kapasitas',
											flag				= '$flag'
								   WHERE id_penginapan = '$id'");										

		//input log data
		session_start();
		$log_activity 	= "Edit Penginapan";
		$log_comment	= "$nama - kapasitas $kapasitas";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_penginapan");

}

if ($_GET[act]=='del_penginapan') {
	$id   = $_POST[id];

	//request data for log
	$sql = mysql_query("SELECT nama_penginapan FROM penginapan WHERE id_penginapan = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete Penginapan";
	$log_comment	= "$r[nama_penginapan]";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM penginapan WHERE id_penginapan='$id'");
	
	//tampilkan kalo sukses
	header("location:../../index.php?component=sekretariat&act=kelola_penginapan");
}

if ($_GET[act]=='assign_penginapan') {

	$no_peserta		= $_POST['no_peserta'];
	$new_penginapan = $_POST['kode_penginapan'];
	$old_penginapan = $_POST['old_penginapan'];
	
	$sql 	= mysql_query("SELECT * from penginapan WHERE id_penginapan = '$new_penginapan'");
	$r		= mysql_fetch_array($sql);
	
	if ((($r[terisi]+1)> $r[kapasitas]) AND ($r[flag] !=1)) {
		$message = "<h2>Assign Penginapan Gagal</h2>
					<p>Kapasitas Penginapan sudah penuh</p>
					<p><a href=../../index.php?component=sekretariat&act=assign_penginapan&nopes=$no_peserta>[kembali]</a></p>";
	} else {		

		// masukkan data kedatabase
		mysql_query("UPDATE penginapan SET terisi = terisi-1
							WHERE id_penginapan = '$old_penginapan'");
		mysql_query("UPDATE penginapan SET terisi = terisi+1
							WHERE id_penginapan = '$new_penginapan'");
		mysql_query("UPDATE biodata SET lokasi_penginapan = '$new_penginapan'
							WHERE no_peserta = '$no_peserta'");

		//input log data
		session_start();
		$log_activity 	= "Assign Penginapan";
		$log_comment	= "$no_peserta penginapan $new_penginapan";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		$message = "<h2>Assign Penginapan Berhasil</h2>
					No. Peserta : <span style='emp1'>$no_peserta</span><br />
					
					<p><a href=../../index.php?component=sekretariat&act=assign_penginapan&nopes=$no_peserta>[kembali]</a></p>";	
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Sistem Informasi KN XIV DPA-GBI</title>
		<link href="../../images/style.css" rel="stylesheet" type="text/css">
		<link href="../../images/knicon.ico" rel="shortcut icon" type="image/x-icon">
	</head>
	<body>
		<div id="header"></div>
		<div id="content"><div id="notifBox"><?php echo $message; ?></div></div>
		<div id="footer"><?php include "../../footer.php"; ?></div>
	</body>
</html>