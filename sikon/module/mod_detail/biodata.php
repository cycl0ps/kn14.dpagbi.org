<?php
include "config/fungsi_indotgl.php";

$id = $_GET[id];

$sql 		= mysql_query("SELECT * FROM biodata 
								LEFT JOIN db_negara ON negara = id_negara
								LEFT JOIN db_prop ON propinsi = id_propinsi
								LEFT JOIN db_kabkota ON kab_kota = id_kabkota
								LEFT JOIN kpa ON asal_kpa = id_kpa
								LEFT JOIN pdn_dpa ON asal_pd = id_pdn
								LEFT JOIN sphere ON biodata.sphere = sphere.id_sphere
								LEFT JOIN komisi ON biodata.komisi = komisi.id_komisi
								LEFT JOIN penginapan ON lokasi_penginapan = id_penginapan
								WHERE no_registrasi = '$id'");
								
$sql2		= mysql_query("SELECT tanggal_bayar FROM pembayaran WHERE no_registrasi = '$id'");

$r 			= mysql_fetch_array($sql);
$q 			= mysql_fetch_array($sql2);
$regdate 	= tgl_indo($r[reg_date]);
$paydate 	= tgl_indo($q[tanggal_bayar]);
$bday 		= tgl_indo($r[tanggal_lahir]);
$arrdate 	= tgl_indo($r[arrive_date]);

//status setting
switch ($r[status]) {
	case "Pendaftar" :
		$status_bayar		= "Belum Bayar/Konfirmasi Pembayaran";
		$status_registrasi 	= "Belum Registrasi-Ulang";
		break;
	case "Peserta" :
		$status_bayar		= "Sudah Bayar";
		$status_registrasi 	= "Belum Registrasi-Ulang";
		break;
	case "Active" :
		$status_bayar		= "Sudah Bayar";
		$status_registrasi 	= "Sudah Registrasi-Ulang";
		break;
}

echo "
<div class='contentHeading'>Detail Biodata</div>
<div id='div04'>
<p><span class='emp1'>No. Registrasi : #$r[no_registrasi]</span></p>
<p><span class='emp1'>No. Peserta : $r[no_peserta]</span></p>
<p><span class='emp1'>Tanggal Daftar : $regdate</span></p>
<p><span class='emp1'>Status Bayar: $status_bayar</span></p>
<p><span class='emp1'>Tanggal Bayar : $paydate</span></p>
<p><span class='emp1'>Lokasi Penginapan : $r[nama_penginapan]</span></p>
<p><span class='emp1'>Status Registrasi : $status_registrasi</span></p>
</div>
<div id='div01'>
	<h3>Data Pribadi</h3>
	<p><label class='label2'>Nama Lengkap :</label>";echo(stripslashes($r[nama_lengkap]));echo "</p>
	<p><label class='label2'>Jenis Kelamin :</label>$r[jenis_kelamin]</p>
	<p><label class='label2'>Tempat Tgl Lahir :</label>";echo(stripslashes($r[tempat_lahir]));echo " $bday</p>
	<p>
		<label class='label2'>Alamat :</label>";echo(stripslashes($r[alamat]));
		
		if ($r[negara]==107) {
			echo "<br /><label class='label2'>&nbsp;</label>$r[nama_kabkota] - $r[nama_propinsi]";
		}
		echo "
		<br /><label class='label2'>&nbsp;</label>$r[nama_negara] $r[kodepos]

	</p>
	<p><label class='label2'>No Kontak :</label>Telp. $r[no_tlp]<br />
		<label class='label2'>&nbsp;</label>HP. $r[no_hp]<br />
		<label class='label2'>&nbsp;</label>Email. $r[email]</p>
	<p><label class='label2'>Pekerjaan :</label>$r[pekerjaan]&nbsp;</p>
</div>
<div id='div02'>
	<h3>Data Gereja</h3>
	<p><label class='label2'>Nama KPA :</label><a href=$_SERVER[PHP_SELF]?module=detail&act=kpa&id=$r[asal_kpa]>";echo(stripslashes($r[nama_kpa]));echo "</a>&nbsp;</p>
	<p><label class='label2'>Asal PD :</label>$r[nama_pdn]&nbsp;</p>
	<p><label class='label2'>Jabatan KPA :</label>$r[jabatan_kpa]&nbsp;</p>

</div>
<div id='div03'>
	<h3>Pilihan Workshop</h3>
	<p>Sphere : $r[nama_sphere]</p>
	<p>Komisi : $r[nama_komisi] ($r[abb_komisi])</p>
	<h3>Rencana Kedatangan</h3>
	<p>Rencana Kedatangan dengan : $r[arrive_by]</p>
	<p>Tiba di Manado Tanggal : $arrdate - Jam : $r[arrive_time]</p>
</div>

<a href=javascript:history.back()>[kembali]</a>";