<?php
include "config/koneksi.php";
include "config/koleksi_fungsi.php";

$cat			= $_GET[cat];
$form			= $_GET[form];

$filter			= $_GET[filter];
$kode			= $_GET[kode];
$id				= $_GET[id];

if (!empty($id)) {
	if ($form == 1) {
		$query 	= mysql_query("SELECT kab_kota, propinsi, negara, asal_kpa FROM biodata WHERE no_peserta = '$id'");
		$r		= mysql_fetch_array($query);
	} 
	
	if ($form == 2) {
		$query 	= mysql_query("SELECT kabkota_kpa, propinsi_kpa, negara_kpa FROM kpa WHERE id_kpa = '$id'");
		$r		= mysql_fetch_array($query);
	}
}

if ($cat == "select_propinsi") {
	echo "<select name='propinsi' id='propinsi' onchange='klikPropinsi(this,$form,$id)' required>
			<option value=''>-- Pilih Propinsi --</option>";
		
	$sql=mysql_query("SELECT * FROM db_prop");
		
	while ($q=mysql_fetch_array($sql)) {
		echo "<option value='$q[id_propinsi]'";
		
		if (($q[id_propinsi]==$r[propinsi]) OR ($q[id_propinsi]==$r[propinsi_kpa])) {
			echo " selected";
		}
	
		
		echo ">$q[nama_propinsi]</option>";
	}
	echo "</select>";
}

if ($cat == "select_kabkota") {
	echo "<select name='kabkota' id='kabkota' required>
			<option value=''>-- Pilih Kabupaten/Kota --</option>";
		
	$sql=mysql_query("SELECT * FROM db_kabkota WHERE $filter ='$kode'");
		
	while ($q=mysql_fetch_array($sql)) {
		echo "<option value='$q[id_kabkota]'";
		
		if (($q[id_kabkota]==$r[kab_kota]) OR ($q[id_kabkota]==$r[kabkota_kpa])) {
			echo " selected";
		}
		
		echo ">$q[nama_kabkota]</option>";
	}
	echo "</select>";
}

if ($cat == "select_kabkota_kpa") {
	echo "<select name='filter_kabkota' id='filter_kabkota' onchange='filterKabkota(this,1,null)'>
			<option value=''>-- Filter Kabupaten/Kota --</option>";
		
	$sql=mysql_query("SELECT * FROM db_kabkota WHERE $filter ='$kode'");
		
	while ($q=mysql_fetch_array($sql)) {
		echo "<option value='$q[id_kabkota]'>$q[nama_kabkota]</option>";
		
	}
	echo "</select>";
}

if ($cat == "select_kpa") {
	
	echo "<select name='nama_kpa' id='nama_kpa' required>
			<option value=''>-- Pilih KPA --</option>";
		
	$sql=mysql_query("SELECT * FROM kpa WHERE $filter = '$kode'");
		
	while ($q=mysql_fetch_array($sql)) {
		echo "<option value='$q[id_kpa]'";
		
		if ($q[id_kpa]==$r[asal_kpa]){
			echo " selected";
		}
		echo ">".(stripslashes($q[nama_kpa]));echo "</option>";
	}
	echo "</select>";
}
?>