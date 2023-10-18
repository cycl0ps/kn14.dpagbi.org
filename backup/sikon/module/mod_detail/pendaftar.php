<?php
include "config/fungsi_indotgl.php";

$id = $_GET[id];

$sql = mysql_query("SELECT * FROM biodata 
								LEFT JOIN db_negara ON negara = id_negara
								LEFT JOIN db_prop ON propinsi = id_propinsi
								LEFT JOIN db_kabkota ON kab_kota = id_kabkota
								LEFT JOIN pdn_dpa ON asal_pd = id_pdn
								LEFT JOIN sphere ON biodata.sphere = sphere.id_sphere
								WHERE no_registrasi = '$id'");

$r = mysql_fetch_array($sql);
$regdate = tgl_indo($r[reg_date]);
$bday 	= tgl_indo($r[tanggal_lahir]);
$arrdate 	= tgl_indo($r[arrive_date]);

echo "
<div class='contentHeading'>Detail Pendaftar</div>
<div id='div04'>
<p><span class='emp1'>No. Registrasi : #$r[no_registrasi]</span></p>
<p><span class='emp1'>Tanggal Daftar: $regdate</span></p>
<p><span class='emp1'>Status Bayar: Belum Bayar/Konfirmasi Pembayaran</span></p>
</div>
<div id='div01'>
	<h3>Data Pribadi</h3>
	<p><label class='label2'>Nama Lengkap :</label>$r[nama_lengkap]</p>
	<p><label class='label2'>Jenis Kelamin :</label>$r[jenis_kelamin]</p>
	<p><label class='label2'>Tempat Tgl Lahir :</label>$r[tempat_lahir] $bday</p>
	<p>
		<label class='label2'>Alamat :</label>$r[alamat]";
		
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
	<p><label class='label2'>Nama Gembala :</label>$r[nama_gembala]&nbsp;</p>
	<p><label class='label2'>Alamat Gereja :</label>$r[alamat_grj]&nbsp;</p>
	<p><label class='label2'>No Kontak :</label>Telp. Gereja. $r[tlp_grj]<br />
		<label class='label2'>&nbsp;</label>Fax. Gereja. $r[fax_grj]</p>
	<p><label class='label2'>Asal PD :</label>$r[nama_pdn]</p>
	<p><label class='label2'>Jabatan KPA :</label>$r[jabatan_kpa]&nbsp;</p>
	<p><label class='label2'>Ketua KPA :</label>$r[ketua_kpa]&nbsp;</p>
	<p><label class='label2'>Komisi :</label>";
		
		if ($r[komisi_abi]==1) echo "ABI ";
		if ($r[komisi_rbi]==1) echo "RBI ";
		if ($r[komisi_pbi]==1) echo "PBI ";
		if ($r[komisi_dmbi]==1) echo "DMBI ";
		echo "
	</p>
</div>
<div id='div03'>
	<h3>Pilihan Sphere</h3>
	<p>Sphere : $r[nama_sphere]</p>
	<h3>Rencana Kedatangan</h3>
	<p>Rencana Kedatangan dengan : $r[arrive_by]</p>
	<p>Tiba di Manado Tanggal : $arrdate - Jam : $r[arrive_time]</p>
</div>

<a href=javascript:history.back()>[kembali]</a>";