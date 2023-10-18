<?php
include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/koleksi_fungsi.php";

$id = $_GET[id];

//This is notif category if an notif exist
$notif_cat = "com_ppusat";

if ($_GET[act]=='tambah_kpa') {

	$nama_kpa 		= mysql_real_escape_string($_POST['nama_kpa']);
	$alamat_kpa 	= mysql_real_escape_string($_POST['alamat_kpa']);
	$negara_kpa		= $_POST['negara'];
	$propinsi_kpa	= $_POST['propinsi'];
	$kabkota_kpa	= $_POST['kabkota'];
	$tlp_kpa		= $_POST['tlp_kpa'];
	$fax_kpa		= $_POST['fax_kpa'];
	$gelar			= $_POST['gelar'];
	$gembala		= mysql_real_escape_string($_POST['gembala']);
	$ketua_kpa		= mysql_real_escape_string($_POST['ketua_kpa']);
	$pdn			= $_POST['asal_pd'];
	
	if (empty($nama_kpa)) {
		$notif_type = "na_na";
		include "../../core/notifikasi/index.php";
		die();
	}
		
	else if ($negara_kpa==107 AND empty($propinsi_kpa)) {
		$notif_type = "prop_na";
		include "../../core/notifikasi/index.php";
		die();
	}

	else if ($negara==107 AND empty($kabkota_kpa)) {
		$notif_type = "kabkota_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	else if (empty($pdn)) {
		$notif_type = "pdn_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	/*
	else if (empty($asal_kpa)) {
		$notif_type = "kpa_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	*/


		// masukkan data kedatabase
		mysql_query("INSERT INTO kpa(nama_kpa, alamat_kpa, negara_kpa, propinsi_kpa, kabkota_kpa, pdn_kpa,
										tlp_kpa, fax_kpa, gembala_grj_kpa, nama_ketua_kpa)
							VALUES ('$nama_kpa', '$alamat_kpa', '$negara_kpa', '$propinsi_kpa', '$kabkota_kpa', 
										'$pdn', '$tlp_kpa', '$fax_kpa', '$gelar $gembala', '$ketua_kpa')");									

		//input log data
		session_start();
		$log_activity 	= "Tambah KPA";
		$log_comment	= "$nama_kpa";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=ppusat&act=kelola_kpa");
}

if ($_GET[act]=='edit_kpa') {

	$id				= $_POST['id'];
	$nama_kpa 		= mysql_real_escape_string($_POST['nama_kpa']);
	$alamat_kpa 	= mysql_real_escape_string($_POST['alamat_kpa']);
	$negara_kpa		= $_POST['negara'];
	$propinsi_kpa	= $_POST['propinsi'];
	$kabkota_kpa	= $_POST['kabkota'];
	$tlp_kpa		= $_POST['tlp_kpa'];
	$fax_kpa		= $_POST['fax_kpa'];
	$gembala		= mysql_real_escape_string($_POST['gembala']);
	$ketua_kpa		= mysql_real_escape_string($_POST['ketua_kpa']);
	$pdn			= $_POST['asal_pd'];
	
	if (empty($nama_kpa)) {
		$notif_type = "na_na";
		include "../../core/notifikasi/index.php";
		die();
	}
		
	else if ($negara_kpa==107 AND empty($propinsi_kpa)) {
		$notif_type = "prop_na";
		include "../../core/notifikasi/index.php";
		die();
	}

	else if ($negara==107 AND empty($kabkota_kpa)) {
		$notif_type = "kabkota_na";
		include "../../core/notifikasi/index.php";
		die();
	}


	else if (empty($pdn)) {
		$notif_type = "pdn_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
		// masukkan data kedatabase
		mysql_query("UPDATE kpa SET	nama_kpa 		= '$nama_kpa',
									alamat_kpa		= '$alamat_kpa',
									negara_kpa		= '$negara_kpa',
									propinsi_kpa	= '$propinsi_kpa',
									kabkota_kpa		= '$kabkota_kpa',
									pdn_kpa			= '$pdn',
									tlp_kpa			= '$tlp_kpa',
									fax_kpa			= '$fax_kpa',
									gembala_grj_kpa	= '$gembala',
									nama_ketua_kpa	= '$ketua_kpa'
								   WHERE id_kpa = '$id'");									

		//input log data
		session_start();
		$log_activity 	= "Edit KPA";
		$log_comment	= "$nama_kpa";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=ppusat&act=kelola_kpa");
}

if ($_GET[act]=='del_kpa') {
	$id   = $_POST[id];

	//request data for log
	$sql = mysql_query("SELECT nama_kpa, kabkota_kpa FROM kpa WHERE id_kpa = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete KPA";
	$log_comment	= "$r[nama_kpa] - $r[kabkota_kpa]";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM kpa WHERE id_kpa='$id'");
	
	//tampilkan kalo sukses
	header("location:../../index.php?component=ppusat&act=kelola_kpa");
}

if ($_GET[act]=='tambah_kredensi') {

	$nama 		= mysql_real_escape_string($_POST['nama']);
	$noreg 		= $_POST['noreg'];
	$kpa 		= $_POST['nama_kpa'];
	
	if (empty($nama)) {
		$notif_type = "kre_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	else if (empty($kpa)) {
		$notif_type = "kpa_na";
		include "../../core/notifikasi/index.php";
		die();
	}



		// masukkan data kedatabase
		mysql_query("INSERT INTO kredensi(nama_kredensi, noreg_kredensi, kpa_kredensi)
							VALUES ('$nama', '$noreg', '$kpa')");									

		//input log data
		session_start();
		$log_activity 	= "Tambah Kredensi";
		$log_comment	= "$nama";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=ppusat&act=kredensi");
}

if ($_GET[act]=='edit_kredensi') {

	$id			= $_POST['id'];
	$nama 		= mysql_real_escape_string($_POST['nama']);
	$noreg 		= $_POST['noreg'];
	$kpa 		= $_POST['nama_kpa'];
	
	if (empty($nama)) {
		$notif_type = "kre_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
	else if (empty($kpa)) {
		$notif_type = "kpa_na";
		include "../../core/notifikasi/index.php";
		die();
	}
	
		// masukkan data kedatabase
		mysql_query("UPDATE kredensi SET	nama_kredensi 	= '$nama',
											noreg_kredensi	= '$noreg',
											kpa_kredensi	= '$kpa'
								   WHERE id_kredensi = '$id'");									

		//input log data
		session_start();
		$log_activity 	= "Edit Kredensi";
		$log_comment	= "$nama";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=ppusat&act=kredensi");
}

if ($_GET[act]=='del_kredensi') {
	$id   = $_POST[id];

	//request data for log
	$sql = mysql_query("SELECT * FROM kredensi WHERE id_kredensi = '$id'");
	$r  = mysql_fetch_array($sql);
	
	//input log data
	session_start();
	$log_activity 	= "Delete Kredensi";
	$log_comment	= "$r[nama_kredensi] - $r[noreg_kredensi]";
	mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");

	mysql_query("DELETE FROM kredensi WHERE id_kredensi='$id'");
	
	//tampilkan kalo sukses
	header("location:../../index.php?component=ppusat&act=kredensi");
}

if ($_GET[act]=='download_data_pendaftaran') {
	$namafile 	= 'pendaftaran_'.$tgl_bln_sekarang.'.xls';
	
	//query data
	$q		= "SELECT no_peserta, no_registrasi, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin,
					alamat, nama_kabkota, nama_propinsi, nama_negara, kodepos, no_tlp, no_hp, email, 
					pekerjaan, nama_gembala, alamat_grj, tlp_grj, fax_grj, nama_pdn, jabatan_kpa, ketua_kpa
					FROM biodata 
					LEFT JOIN db_kabkota ON kab_kota = id_kabkota
					LEFT JOIN db_prop ON biodata.propinsi = db_prop.id_propinsi
					LEFT JOIN db_negara ON negara = id_negara
					LEFT JOIN pdn_dpa ON asal_pd = id_pdn
					ORDER BY asal_pd, no_peserta ASC";
	$query = mysql_query($q);
	$res .= "NO\tNO. PESERTA\tNO. REGISTRASI\tNAMA LENGKAP\tTEMPAT LAHIR\tTANGGAL LAHIR\tJENIS KELAMIN\tALAMAT\tKABUPATEN/KOTA\tPROPINSI\tNEGARA\tKODE POS\tNO. TELP\tNO. HP\tEMAIL\tPEKERJAAN\tNAMA GEMBALA\tALAMAT GEREJA\tTELP. GEREJA\tFAX GEREJA\tASAL PDN\tJABATAN KPA\tKETUA KPA\r\n";
	$count = 1;
	while ($r = mysql_fetch_array($query)) {
		$res .= $count."\t";
		for ($i=0; $i<mysql_num_fields($query); $i++) {
			$res .= stripslashes($r[$i]) . "\t";
		}
		$res .= "\r\n";
		$count++;
	}

	mysql_free_result($query);
	header("Content-disposition: attachment; filename=$namafile");
	header("Content-type: Application/exe");
	header("Content-Transfer-Encoding: binary");
	echo $res;
}

?>
