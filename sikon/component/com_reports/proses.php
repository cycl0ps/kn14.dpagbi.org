<?php
include("../../config/koneksi.php");
include("../../config/library.php");

//This is notif category if an notif exist
$notif_cat = "com_reports";

//download data pendaftar
if ($_GET[act]=='download_data_pendaftar') {
	
	$namafile 	= 'pendaftar_'.$tgl_bln_sekarang.'.xls';
	
	//query data
	$q		= "SELECT no_registrasi, nama_lengkap, alamat, nama_kabkota, nama_propinsi, nama_negara, no_hp, email, alamat_grj, nama_pdn 
					FROM biodata 
					LEFT JOIN db_kabkota ON kab_kota = id_kabkota
					LEFT JOIN db_prop ON biodata.propinsi = db_prop.id_propinsi
					LEFT JOIN db_negara ON negara = id_negara
					LEFT JOIN pdn_dpa ON asal_pd = id_pdn
					WHERE status = 'Pendaftar'
					ORDER BY no_registrasi ASC";
	$query = mysql_query($q);
	$res .= "NO\tNO. REGISTRASI\tNAMA LENGKAP\tALAMAT\tKABUPATEN/KOTA\tPROPINSI\tNEGARA\tNO HP\tEMAIL\tALAMAT GEREJA\tASAL PDN\r\n";
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

if ($_GET[act]=='download_data_peserta') {
	$namafile 	= 'peserta_'.$tgl_bln_sekarang.'.xls';
	
	//query data
	$q		= "SELECT no_peserta, no_registrasi, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin,
					alamat, nama_kabkota, nama_propinsi, nama_negara, kodepos, no_tlp, no_hp, email, 
					pekerjaan, nama_gembala, alamat_grj, tlp_grj, fax_grj, nama_pdn, jabatan_kpa, ketua_kpa,
					abb_komisi, nama_sphere
					FROM biodata 
					LEFT JOIN db_kabkota ON kab_kota = id_kabkota
					LEFT JOIN db_prop ON biodata.propinsi = db_prop.id_propinsi
					LEFT JOIN db_negara ON negara = id_negara
					LEFT JOIN pdn_dpa ON asal_pd = id_pdn
					LEFT JOIN komisi ON komisi = id_komisi
					LEFT JOIN sphere ON sphere = id_sphere
					WHERE status = 'Peserta'
					ORDER BY asal_pd, no_peserta ASC";
	$query = mysql_query($q);
	$res .= "NO\tNO. PESERTA\tNO. REGISTRASI\tNAMA LENGKAP\tTEMPAT LAHIR\tTANGGAL LAHIR\tJENIS KELAMIN\tALAMAT\tKABUPATEN/KOTA\tPROPINSI\tNEGARA\tKODE POS\tNO. TELP\tNO. HP\tEMAIL\tPEKERJAAN\tNAMA GEMBALA\tALAMAT GEREJA\tTELP. GEREJA\tFAX GEREJA\tASAL PDN\tJABATAN KPA\tKETUA KPA\tKOMISI\tSPHERE\r\n";
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

if ($_GET[act]=='download_query') {
	
	$title	= str_replace(" ","_",$_POST[title]);
	$q		= stripslashes($_POST[query]);
	$f 		= $_POST[field];
	
	$namafile 	= $title.'_'.$tgl_bln_sekarang.'.xls';
	
	$res = "NO\t". str_replace(",","\t",strtoupper($f));
	$res .= "\r\n";
	
	//echo "$title<br>$q<br>$namafile<br>";
	//print ($res);
	
	//query data
	$query = mysql_query($q);
	
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