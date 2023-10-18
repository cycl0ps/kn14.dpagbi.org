<?php
function noRegistrasi($old, $date) {
	if (empty($old)) {
		$old = "0000";
	} else {
		$old = substr($old,3,4);
	}
	$new = $date.$old;
	$new = $new + 1;
	return $new;
}

function noPeserta($pdn, $jk) {
	$pdn = sprintf('%02s', $pdn); 
	$old = "14".$pdn;
	
	//jenis kelamin
	if ($jk == "Laki-Laki") {
		$old = $old."1";
	} else {
		$old = $old."2";
	}

	$r	 = mysql_fetch_array(mysql_query("SELECT no_peserta FROM pembayaran 
															WHERE no_peserta LIKE '$old%' 
															ORDER BY no_peserta DESC"));
	
	if (empty($r[no_peserta])) {
		$lastid = "000";
	} else {
		$lastid = substr($r[no_peserta],5,3);
	}
	$new = $old."$lastid";
	$new = $new + 1;
	return $new;
}

function getNilai($tabel,$field,$var,$nilai){
	$r = mysql_fetch_array(mysql_query("SELECT $field FROM $tabel WHERE $var = $nilai"));
	return $r[$field];
}

function convertCaps($string) {
	$conStr = strtolower($string);
	$conStr = ucwords($conStr);
	return $conStr;
}

?>