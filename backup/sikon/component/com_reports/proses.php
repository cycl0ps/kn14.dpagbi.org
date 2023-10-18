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
	$res .= "No\tNo. Registrasi\tNama Lengkap\tAlamat\tKabupaten/Kota\tPropinsi\tNegara\tNo HP\tEmail\tAlamat Gereja\tAsal PDN\r\n";
	$count = 1;
	while ($r = mysql_fetch_array($query)) {
		$res .= $count."\t";
		for ($i=0; $i<mysql_num_fields($query); $i++) {
			$res .= $r[$i] . "\t";
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
					komisi_abi, komisi_rbi, komisi_pbi, komisi_dmbi, nama_sphere
					FROM biodata 
					LEFT JOIN db_kabkota ON kab_kota = id_kabkota
					LEFT JOIN db_prop ON biodata.propinsi = db_prop.id_propinsi
					LEFT JOIN db_negara ON negara = id_negara
					LEFT JOIN pdn_dpa ON asal_pd = id_pdn
					LEFT JOIN sphere ON sphere = id_sphere
					WHERE status = 'Peserta'
					ORDER BY asal_pd, no_peserta ASC";
	$query = mysql_query($q);
	$res .= "No\tNo. Peserta\tNo. Registrasi\tNama Lengkap\tTempat Lahir\tTanggal Lahir\tJenis Kelamin\tAlamat\tKabupaten/Kota\tPropinsi\tNegara\tKode Pos\tNo. Telp\tNo. HP\tEmail\tPekerjaan\tNama Gembala\tAlamat Gereja\tTelp. Gereja\tFax Gereja\tAsal PDN\tJabatan KPA\tNama Ketua KPA\tKomisi ABI\tKomisi RBI\tKomisi PBI\tKomisi DMBI\tPilihan Sphere\r\n";
	$count = 1;
	while ($r = mysql_fetch_array($query)) {
		$res .= $count."\t";
		for ($i=0; $i<mysql_num_fields($query); $i++) {
			$res .= $r[$i] . "\t";
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