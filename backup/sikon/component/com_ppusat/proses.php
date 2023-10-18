<?php
include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/koleksi_fungsi.php";

$id = $_GET[id];

//This is notif category if an notif exist
$notif_cat = "com_ppusat";

if ($_GET[act]=='tambah_kpa') {

	$nama_kpa 	= $_POST['nama_kpa'];
	$alamat_kpa = $_POST['alamat_kpa'];
	$tlp_kpa	= $_POST['tlp_kpa'];
	$fax_kpa	= $_POST['fax_kpa'];
	$gelar		= $_POST['gelar'];
	$gembala	= $_POST['gembala'];
	
	


		// masukkan data kedatabase
		mysql_query("INSERT INTO penginapan(nama_penginapan, alamat_penginapan, kapasitas)
							VALUES ('$nama', '$alamat', '$kapasitas')");									

		//input log data
		session_start();
		$log_activity 	= "Tambah Penginapan";
		$log_comment	= "$nama - kapasitas $kapasitas";
		mysql_query("INSERT INTO log(log_user, log_activity, log_comment, log_date)
						VALUES ('$_SESSION[username]','$log_activity','$log_comment','$waktu_sekarang')");
		
		// tampilkan kalo sukses
		header("location:../../index.php?component=sekretariat&act=kelola_penginapan");

}

if ($_GET[act]=='edit_kpa') {

	$id				= $_POST['id'];
	$nama 			= $_POST['nama_penginapan'];
	$alamat 		= $_POST['alamat_penginapan'];
	$kapasitas		= $_POST['kapasitas'];


		// masukkan data kedatabase
		mysql_query("UPDATE penginapan SET	nama_penginapan 	= '$nama',
											alamat_penginapan	= '$alamat',
											kapasitas			= '$kapasitas'
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

if ($_GET[act]=='del_kpa') {
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
	$res .= "No\tNo. Peserta\tNo. Registrasi\tNama Lengkap\tTempat Lahir\tTanggal Lahir\tJenis Kelamin\tAlamat\tKabupaten/Kota\tPropinsi\tNegara\tKode Pos\tNo. Telp\tNo. HP\tEmail\tPekerjaan\tNama Gembala\tAlamat Gereja\tTelp. Gereja\tFax Gereja\tAsal PDN\tJabatan KPA\tKetua KPA\r\n";
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