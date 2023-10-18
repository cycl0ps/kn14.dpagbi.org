<?php
include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/koleksi_fungsi.php";
include "../../config/fungsi_indotgl.php";

//This is notif category if an notif exist
$notif_cat = "com_sekretariat";

if ($_GET[act]=='registrasi_ulang') {

	$nopes			= $_POST['nopes'];	
	
	mysql_query("UPDATE biodata SET status='Active' WHERE no_peserta='$nopes'");

	//input log data
	session_start();
	$log_activity 	= "Registrasi Ulang";
	$log_comment	= "$nopes Active";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
					VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
	$message = "<h2>Registrasi ulang Berhasil</h2>
				No. Peserta : <span style='emp1'>$nopes</span>
				<p align='center'><form><input type=\"button\" value=\"Cetak Bukti Daftar\" onclick=\"window.open('../../module/mod_print/bukti_pendaftaran.php?no_pes=$nopes','cetakbukti','height=500,width=400,left=100,top=100,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');\"></p></form>
				<p><a href=../../index.php?component=sekretariat&act=registrasi_ulang&no_pes=$nopes>[kembali]</a></p>";	

}

if ($_GET[act]=='konfirmasi_pembayaran') {
	$noreg 			= $_POST[noreg];
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
								FROM biodata WHERE no_registrasi = '$noreg'");
		$r  = mysql_fetch_array($sql);
	
		$no_peserta = noPeserta($r[asal_pd], $r[jenis_kelamin]);
		
		mysql_query("REPLACE INTO pembayaran(no_peserta, no_registrasi, tanggal_bayar, jumlah_bayar,
											metode_bayar, trans_date)
							VALUES ('$no_peserta', '$noreg', '$thn_byr-$bln_byr-$tgl_byr', $jml_bayar,
										'$metode_byr', '$waktu_sekarang')");
	
		mysql_query("UPDATE biodata SET status='Peserta',
											no_peserta ='$no_peserta'
										WHERE no_registrasi='$noreg'");
		
		$message = "<h2>Konfirmasi pembayaran berhasil!</h2>
					No. Registrasi: <span style='emp1'>#$noreg</span><br />
					No. Peserta : <span style='emp1'>$no_peserta</span>
					<p><a href=../../index.php?component=sekretariat&act=konfirmasi_pembayaran&no_reg=$noreg>[kembali]</a></p>";
					
	
		//input log data
		session_start();
		$log_activity 	= "Konfirmasi Pembayaran";
		$log_comment	= "#$noreg $no_peserta";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	}
}

if ($_GET[act]=='edit_biodata') {

	$nopes			= $_POST['nopes'];
	$nama_lengkap	= mysql_real_escape_string($_POST['nama']);
	$jenis_kelamin	= $_POST['jenis_kelamin'];
	$tempat_lahir	= mysql_real_escape_string($_POST['tempat_lahir']);
	$tgl_lahir		= $_POST['tgl_lahir'];
	$bln_lahir		= $_POST['bln_lahir'];
	$thn_lahir		= $_POST['thn_lahir'];
	$negara			= $_POST['negara'];
	$propinsi		= $_POST['propinsi'];
	$kabkota		= $_POST['kabkota'];
	$alamat			= mysql_real_escape_string($_POST['alamat']);
	$kodepos		= $_POST['kodepos'];
	$no_tlp			= $_POST['no_tlp'];
	$no_hp			= $_POST['no_hp'];
	$email			= $_POST['email'];
	$pekerjaan		= $_POST['pekerjaan'];

	$asal_pd		= $_POST['asal_pd'];
	$asal_kpa		= $_POST['nama_kpa'];
	$jabatan_kpa	= $_POST['jabatan_kpa'];

	$komisi			= $_POST['komisi'];
	$sphere			= $_POST['sphere'];

	$arrive_by		= $_POST['arrive_by'];
	$arrive_tgl		= $_POST['arrive_tgl'];
	$arrive_bln		= $_POST['arrive_bln'];
	$arrive_thn		= $_POST['arrive_thn'];
	$arrive_jam		= $_POST['arrive_jam'];

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
		include "../../core/notifikasi/index.php";
		die();
	}

	else if (empty($alamat)) {
		$notif_type = "al_na";
		include "../../core/notifikasi/index.php";
		die();
	}

	else if (empty($komisi)) {
		$notif_type = "ko_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	/* Nanti enable pas registrasi ulang 
	else if (empty($asal_kpa)) {
		$notif_type = "kpa_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	*/
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

										asal_pd			= '$asal_pd',
										asal_kpa		= '$asal_kpa',
										jabatan_kpa		= '$jabatan_kpa', 

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
					<p><a href=../../index.php?component=sekretariat&act=edit_biodata&no_pes=$nopes>[kembali]</a></p>";	
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

	$nopes			= $_POST['nopes'];
	$new_penginapan = $_POST['kode_penginapan'];
	$old_penginapan = $_POST['old_penginapan'];
	
	$sql 	= mysql_query("SELECT * from penginapan WHERE id_penginapan = '$new_penginapan'");
	$r		= mysql_fetch_array($sql);
	
	if ((($r[terisi]+1)> $r[kapasitas]) AND ($r[flag] !=1)) {
		$message = "<h2>Assign Penginapan Gagal</h2>
					<p>Kapasitas Penginapan sudah penuh</p>
					<p><a href=../../index.php?component=sekretariat&act=assign_penginapan&no_pes=$nopes>[kembali]</a></p>";
	} else {		

		// masukkan data kedatabase
		mysql_query("UPDATE penginapan SET terisi = terisi-1
							WHERE id_penginapan = '$old_penginapan'");
		mysql_query("UPDATE penginapan SET terisi = terisi+1
							WHERE id_penginapan = '$new_penginapan'");
		mysql_query("UPDATE biodata SET lokasi_penginapan = '$new_penginapan'
							WHERE no_peserta = '$nopes'");

		//input log data
		session_start();
		$log_activity 	= "Assign Penginapan";
		$log_comment	= "$nopes penginapan $new_penginapan";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		$message = "<h2>Assign Penginapan Berhasil</h2>
					No. Peserta : <span style='emp1'>$nopes</span><br />
					Kode Penginapan: <span style='emp1'>$new_penginapan</span>
					<p><a href=../../index.php?component=sekretariat&act=assign_penginapan&no_pes=$nopes>[kembali]</a></p>";	
	}
}

if ($_GET[act]=='tambah_acara') {

	$nama_acara 	= $_POST['nama_acara'];
	$jadwal_tgl		= $_POST['jadwal_tgl'];
	$jadwal_bln		= $_POST['jadwal_bln'];
	$jadwal_thn		= $_POST['jadwal_thn'];
	$jadwal_jam		= $_POST['jadwal_jam'];
	$deskripsi		= $_POST['deskripsi'];
	$absensi		= $_POST['absensi'];
	$kredensi		= $_POST['kredensi'];
	
	
		// masukkan data kedatabase
		mysql_query("INSERT INTO activity(nama_activity, deskripsi_activity, group_activity, start_activity, flag1, flag2)
							VALUES ('$nama_acara', '$deskripsi', '1', '$jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam', '$absensi', '$kredensi')");									
		//input log data
		session_start();
		$log_activity 	= "Tambah Acara";
		$log_comment	= "$nama_acara";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_acara");

}

if ($_GET[act]=='edit_acara') {

	$id				= $_POST['id'];
	$nama_acara 	= $_POST['nama_acara'];
	$jadwal_tgl		= $_POST['jadwal_tgl'];
	$jadwal_bln		= $_POST['jadwal_bln'];
	$jadwal_thn		= $_POST['jadwal_thn'];
	$jadwal_jam		= $_POST['jadwal_jam'];
	$deskripsi		= $_POST['deskripsi'];
	$absensi		= $_POST['absensi'];
	$kredensi		= $_POST['kredensi'];

		// masukkan data kedatabase
		mysql_query("UPDATE activity SET	nama_activity 		= '$nama_acara',
											deskripsi_activity	= '$deskripsi',
											start_activity		= '$jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam',
											flag1				= '$absensi',
											flag2				= '$kredensi'
								   WHERE id_activity = '$id'");										

		//input log data
		session_start();
		$log_activity 	= "Edit Acara";
		$log_comment	= "$nama_acara";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_acara");

}

if ($_GET[act]=='del_acara') {
	$id   = $_POST[id];

	//request data for log
	$sql = mysql_query("SELECT nama_activity FROM activity WHERE id_activity = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete Acara";
	$log_comment	= "$r[nama_activity]";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM activity WHERE id_activity='$id'");
	
	//tampilkan kalo sukses
	header("location:../../index.php?component=sekretariat&act=kelola_acara");
}

if ($_GET[act]=='tambah_konsumsi') {

	$nama_acara 	= $_POST['nama_acara'];
	$jadwal_tgl		= $_POST['jadwal_tgl'];
	$jadwal_bln		= $_POST['jadwal_bln'];
	$jadwal_thn		= $_POST['jadwal_thn'];
	$jadwal_jam		= $_POST['jadwal_jam'];
	$deskripsi		= $_POST['deskripsi'];	
	
		// masukkan data kedatabase
		mysql_query("INSERT INTO activity(nama_activity, deskripsi_activity, group_activity, start_activity, flag1)
							VALUES ('$nama_acara', '$deskripsi', '2', '$jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam', '1')");									
		//input log data
		session_start();
		$log_activity 	= "Tambah Jadwal Konsumsi";
		$log_comment	= "$nama_acara $jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_konsumsi");

}

if ($_GET[act]=='edit_konsumsi') {

	$id				= $_POST['id'];
	$nama_acara 	= $_POST['nama_acara'];
	$jadwal_tgl		= $_POST['jadwal_tgl'];
	$jadwal_bln		= $_POST['jadwal_bln'];
	$jadwal_thn		= $_POST['jadwal_thn'];
	$jadwal_jam		= $_POST['jadwal_jam'];
	$deskripsi		= $_POST['deskripsi'];

		// masukkan data kedatabase
		mysql_query("UPDATE activity SET	nama_activity 		= '$nama_acara',
											deskripsi_activity	= '$deskripsi',
											start_activity		= '$jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam'
								   WHERE id_activity = '$id'");										

		//input log data
		session_start();
		$log_activity 	= "Edit Jadwal Konsumsi";
		$log_comment	= "$nama_acara $jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_konsumsi");

}

if ($_GET[act]=='del_konsumsi') {
	$id   = $_POST[id];

	//request data for log
	$sql = mysql_query("SELECT nama_activity FROM activity WHERE id_activity = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete Jadwal Konsumsi";
	$log_comment	= "$nama_acara $jadwal_thn-$jadwal_bln-$jadwal_tgl $jadwal_jam";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM activity WHERE id_activity='$id'");
	
	//tampilkan kalo sukses
	header("location:../../index.php?component=sekretariat&act=kelola_konsumsi");
}

if ($_GET[act]=='absensi') {

	$kode_acara = $_POST['kode_acara'];
	$kredensi 	= $_POST['kredensi'];
	$kom_sph 	= $_POST['kom_sph'];
	$kode_pil 	= $_POST['kode_pil'];
	$no_peserta = $_POST['no_peserta'];
	
	//cek already
	$sql 	= mysql_query("SELECT nama_lengkap, nama_activity, start_activity FROM presensi 
							LEFT JOIN biodata ON id_peserta = no_peserta
							LEFT JOIN activity ON id_activity = kode_activity
							WHERE id_peserta='$no_peserta' AND kode_activity='$kode_acara'");
	$sum 	= mysql_num_rows($sql);
	$r		= mysql_fetch_array($sql);
	$jadwal_tgl = tgl_indo($r[start_activity]);
	$jadwal_jam = getjam($r[start_activity]);
	
	if (empty($no_peserta)) {
		header("location:../../index.php?component=sekretariat&act=absensi&kode_acara=$kode_acara");
	}
	
	if ($sum >= 1) {
		echo "<script type='text/javascript'>
				window.alert('SUDAH DIABSEN!!! $r[nama_lengkap] sudah mengisi absen sebelumnya untuk $r[nama_activity] - $jadwal_tgl $jadwal_jam.');
				window.location = '../../index.php?component=sekretariat&act=absensi&kode_acara=$kode_acara';
				</script>";
		die();
	} 
	
	//cek kredensi
	if ($kredensi == 1) {
		
	}
	
	//cek sphere
	if ($kom_sph == 1) {
		$r	= mysql_fetch_array(mysql_query("SELECT nama_lengkap, sphere, id_sphere, nama_sphere FROM biodata
													LEFT JOIN sphere ON id_sphere = biodata.sphere
													WHERE no_peserta = '$no_peserta'"));
		if ($r[sphere] <> $kode_pil) {
			echo "<script type='text/javascript'>
				window.alert('Maaf!! $no_peserta tidak diabsen. Sphere pilihan peserta $r[nama_lengkap] adalah $r[nama_sphere]. Hubungi sekretariat untuk mengganti pilihan sphere.');
				window.location = '../../index.php?component=sekretariat&act=absensi&kode_acara=$kode_acara';
				</script>";
			die();
		}
	}
	
	//cek komisi
	if ($kom_sph == 2) {
		$r	= mysql_fetch_array(mysql_query("SELECT nama_lengkap, komisi, id_komisi, abb_komisi FROM biodata
													LEFT JOIN komisi ON id_komisi = biodata.komisi
													WHERE no_peserta = '$no_peserta'"));
		if ($r[komisi] <> $kode_pil) {
			echo "<script type='text/javascript'>
				window.alert('Maaf!! $no_peserta tidak diabsen. Komisi pilihan peserta $r[nama_lengkap] adalah $r[abb_komisi]. Hubungi sekretariat untuk mengganti pilihan komisi.');
				window.location = '../../index.php?component=sekretariat&act=absensi&kode_acara=$kode_acara';
				</script>";
			die();
		}

	}
	
	
		// masukkan data kedatabase
		session_start();
		mysql_query("INSERT INTO presensi(id_peserta, kode_activity, time_activity, operator)
							VALUES ('$no_peserta', '$kode_acara', '$waktu_sekarang', '$_SESSION[username]')");									
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=absensi&kode_acara=$kode_acara");
	
}

if ($_GET[act]=='konsumsi') {

	$kode_konsumsi 	= $_POST['kode_konsumsi'];
	$no_peserta 	= $_POST['no_peserta'];
	
	
	//cek sudah ambil
	$sql 	= mysql_query("SELECT nama_lengkap, nama_activity, start_activity FROM presensi 
							LEFT JOIN biodata ON id_peserta = no_peserta
							LEFT JOIN activity ON id_activity = kode_activity
							WHERE id_peserta='$no_peserta' AND kode_activity='$kode_konsumsi'");
	$sum 	= mysql_num_rows($sql);
	$r		= mysql_fetch_array($sql);
	$jadwal_tgl = tgl_indo($r[start_activity]);
	$jadwal_jam = getjam($r[start_activity]);
	
	
	if (empty($no_peserta)) {
		header("location:../../index.php?component=sekretariat&act=konsumsi&kode_konsumsi=$kode_konsumsi");
	} 
	
	else if ($sum >= 1) {
		echo "<script type='text/javascript'>
				window.alert('SUDAH DIAMBIL!! $r[nama_lengkap] sudah mengambil konsumsi untuk $r[nama_activity] $jadwal_tgl $jadwal_jam.');
				window.location = '../../index.php?component=sekretariat&act=konsumsi&kode_konsumsi=$kode_konsumsi';
				</script>";
		die();
	} else {	
	
		// masukkan data kedatabase
		session_start();
		mysql_query("INSERT INTO presensi(id_peserta, kode_activity, time_activity, operator)
							VALUES ('$no_peserta', '$kode_konsumsi', '$waktu_sekarang', '$_SESSION[username]')");									
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=konsumsi&kode_konsumsi=$kode_konsumsi");
	}
}

//themes query
$theme = mysql_query("SELECT path_theme FROM themes WHERE status_theme = 'active'");
$t = mysql_fetch_array($theme);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Sistem Informasi KN XIV DPA-GBI</title>
		<link href="../../<?php echo "$t[path_theme]" ?>/css/style.css" rel="stylesheet" type="text/css">
		<link href="../../<?php echo "$t[path_theme]" ?>/knicon.ico" rel="shortcut icon" type="image/x-icon">
	</head>
	<body>
		<div id="header"></div>
		<div id="content"><div id="notifBox"><?php echo $message; ?></div></div>
		<div id="footer"><?php include "../../footer.php"; ?></div>
	</body>
</html>