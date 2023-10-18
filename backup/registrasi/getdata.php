<?php
include "config/koneksi.php";

$cat		= $_GET[cat];
$kode_neg	= $_GET[kode_neg];
$kode_prop	= $_GET[kode_prop];


if ($cat == "negara") {
	if ($kode_neg == 107) {
		echo "<label for='Propinsi'>Propinsi : &nbsp;</label>
				<select name='propinsi' id='propinsi' onchange='klikPropinsi(this)' required>
				<option value='' selected>- Pilih Propinsi - </option>";
		
		$sql=mysql_query("SELECT * FROM db_prop");
		
		while ($r=mysql_fetch_array($sql)) {
			echo "<option value='$r[id_propinsi]'>$r[nama_propinsi]</option>";
		}
		echo "</select>";
	} else {
		echo " ";
	}
}

if ($cat == "propinsi") {

	if (!empty($kode_prop)) {
		echo "<label for='kabkota'>Kabupaten/Kota : &nbsp;</label>
			<select name='kabkota' id='kabkota' required>
			<option value='' selected>- Pilih Kabupaten/Kota - </option>";
			
		$sql 	= mysql_query("SELECT * FROM db_kabkota WHERE id_propinsi = '$kode_prop'");

		while($r = mysql_fetch_array($sql)) {
			echo "<option value = '$r[id_kabkota]'>$r[nama_kabkota]</option>";
		}
		echo "</select>";
	} else {
		echo " ";
	}
}

?>