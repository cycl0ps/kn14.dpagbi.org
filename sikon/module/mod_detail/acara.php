<?php
include "config/fungsi_indotgl.php";

$id = $_GET[id];

$sql 		= mysql_query("SELECT * FROM activity 
								WHERE id_activity = '$id'");

$r 			= mysql_fetch_array($sql);
$jadwal_tgl = tgl_indo($r[start_activity]);
$jadwal_jam = getjam($r[start_activity]);

echo "
<div class='contentHeading'>Detail Acara</div>
<div id='div03'>
	<h3>$r[nama_activity]</h3>
	<p><label class='label2'>Jadwal :</label>$jadwal_tgl $jadwal_jam WITA</p>
	<p><label class='label2'>Deskripsi :</label>$r[deskripsi_activity]&nbsp;</p>
	<p><label class='label2'>Additional :</label>";
	
	if ($r[flag1]==1) {echo "Pakai Daftar Hadir  ";}
	if ($r[flag2]==1) {echo "Terbatas Pemegang Kredensi  ";}
echo "&nbsp;</p></div>

<a href=javascript:history.back()>[kembali]</a>";