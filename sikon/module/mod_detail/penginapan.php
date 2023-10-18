<?php

$id = $_GET[id];

$sql 		= mysql_query("SELECT * FROM penginapan WHERE id_penginapan = '$id'");
$r 			= mysql_fetch_array($sql);

echo "
<div class='contentHeading'>Detail Penginapan</div>
<div id='div03'>
	<h3>$r[nama_penginapan]</h3>
	<p><label class='label2'>Alamat Penginapan :</label>$r[alamat_penginapan]</p>
	<p><label class='label2'>Kapasitas :</label>";
	if ($r[flag]==1) {echo "&infin;</p>";}
	else {echo "$r[kapasitas]</p>";}
	echo "
	<p><label class='label2'>Terisi :</label>$r[terisi] peserta</p>
	<p><label class='label2'>Additional :</label>";
	if ($r[flag]==1) {echo "Penginapan dapat diupgrade</td>";}
	echo "</p>
	<p>&nbsp;&nbsp;</p>
</div>


<a href=javascript:history.back()>[kembali]</a>";