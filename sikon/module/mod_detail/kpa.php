<?php
include "config/fungsi_indotgl.php";

$id = $_GET[id];

$sql 	= mysql_query("SELECT * FROM kpa 
								LEFT JOIN db_negara ON negara_kpa = id_negara
								LEFT JOIN db_prop ON propinsi_kpa = id_propinsi
								LEFT JOIN db_kabkota ON kabkota_kpa = id_kabkota
								LEFT JOIN pdn_dpa ON pdn_kpa = id_pdn
								WHERE id_kpa = '$id'");

$r 		= mysql_fetch_array($sql);

echo "
<div class='contentHeading'>Detail KPA</div>
<div id='div02'>
	<h3>";echo(stripslashes($r[nama_kpa]));echo "</h3>
	<p><label class='label2'>Alamat KPA :</label>";echo(stripslashes($r[alamat_kpa]));echo "&nbsp;</p>
	<p><label class='label2'>Kabupaten/Kota :</label>$r[nama_kabkota]&nbsp;</p>
	<p><label class='label2'>Propinsi :</label>$r[nama_propinsi]&nbsp;</p>
	<p><label class='label2'>Negara :</label>$r[nama_negara]&nbsp;</p>
	<p><label class='label2'>Asal PD :</label>$r[nama_pdn]</p>
	<p><label class='label2'>No Kontak :</label>Telp. KPA. $r[tlp_kpa]<br />
		<label class='label2'>&nbsp;</label>Fax. KPA. $r[fax_kpa]</p>
	<p><label class='label2'>Nama Gembala :</label>";echo(stripslashes($r[gembala_grj_kpa]));echo "</p>
	<p><label class='label2'>Nama Ketua KPA :</label>";echo(stripslashes($r[nama_ketua_kpa]));echo "&nbsp;</p>
</div>";

$member = mysql_query("SELECT nama_lengkap, no_registrasi FROM biodata WHERE asal_kpa = '$id'");

echo "
<div id='div05'>
	<h3>Listing Peserta dari KPA ini</h3>
	<ol>";
	
	$i=1;
	while ($q=mysql_fetch_array($member)){
		echo "<li><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$q[no_registrasi]>";echo(stripslashes($q[nama_lengkap]));echo "</a></li>";
	$i++;
	}

echo "</ol></div>

<a href=javascript:history.back()>[kembali]</a>";