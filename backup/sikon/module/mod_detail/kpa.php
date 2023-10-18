<?php
include "config/fungsi_indotgl.php";

$id = $_GET[id];

$sql 		= mysql_query("SELECT * FROM kpa 
								LEFT JOIN db_negara ON negara = id_negara
								LEFT JOIN db_prop ON propinsi = id_propinsi
								LEFT JOIN db_kabkota ON kabkota = id_kabkota
								LEFT JOIN pdn_dpa ON pdn = id_pdn
								WHERE id_kpa = '$id'");

$r 			= mysql_fetch_array($sql);

echo "
<div class='contentHeading'>Detail KPA</div>
<div id='div02'>
	<h3>$r[nama_kpa]</h3>
	<p><label class='label2'>alamat KPA :</label>$r[alamat_kpa]&nbsp;</p>
	<p><label class='label2'>Kab/Kota :</label>$r[nama_kabkota]&nbsp;</p>
	<p><label class='label2'>Propinsi :</label>$r[nama_propinsi]&nbsp;</p>
	<p><label class='label2'>Negara :</label>$r[nama_negara]&nbsp;</p>
	<p><label class='label2'>Asal PD :</label>$r[nama_pdn]</p>
	<p><label class='label2'>No Kontak :</label>Telp. KPA. $r[tlp_grj]<br />
		<label class='label2'>&nbsp;</label>Fax. KPA. $r[fax_grj]</p>
	<p><label class='label2'>Nama Gembala :</label>$r[nama_gembala]</p>
	<p><label class='label2'>Nama Ketua KPA :</label>$r[ketua_kpa]&nbsp;</p>
</div>

<a href=javascript:history.back()>[kembali]</a>";