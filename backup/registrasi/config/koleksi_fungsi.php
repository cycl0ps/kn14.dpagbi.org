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

function getNilai($tabel,$field,$var,$nilai){
	$sql = mysql_query("SELECT $field FROM $tabel WHERE $var = '$nilai'");
	$r = mysql_fetch_array($sql);
	
	if($sql === FALSE) {
    die(mysql_error()); // TODO: better error handling
	}

	return $r[$field];

}

function convertCaps($string) {
	$conStr = strtolower($string);
	$conStr = ucwords($conStr);
	return $conStr;
}

?>