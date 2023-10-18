<?php
include "config/fungsi_indotgl.php";

$kode_konsumsi 	= $_GET[kode_konsumsi];

echo "<div class='contentHeading'>Absen Konsumsi</div>";

$acara = mysql_query("SELECT * FROM activity WHERE group_activity = 2 ORDER BY start_activity ASC");

echo "<form method=GET action=index.php?component=sekretariat&act=konsumsi>
		<input type='hidden' name='component' value='sekretariat' />
		<input type='hidden' name='act' value='konsumsi' />
		<p>Pilihan Jadwal Konsumsi :
		<select name=kode_konsumsi>";
			
	$i=1;
	while ($r=mysql_fetch_array($acara)){
		$tgl_kons	= tgl_indo($r[start_activity]);
		$jam_kons	= getjam($r[start_activity]);
		echo "<option value='$r[id_activity]'"; if ($kode_acara == $r[id_activity]) {echo " selected";} echo ">$r[nama_activity] $tgl_kons $jam_kons</option>";
		$i++;
	}
	echo "<input type='submit' value='Pilih'></p></form><br>";

if ($kode_konsumsi != "") {
	
	$sql 	= mysql_query("SELECT * FROM activity WHERE id_activity = '$kode_konsumsi'");
	$q 		= mysql_fetch_array($sql);
	
	$jadwal_tgl = tgl_indo($q[start_activity]);
	$jadwal_jam = getjam($q[start_activity]);
									
	echo "<div id='div03'><h1><center>$q[nama_activity]</h1>";
	echo "
		<p align=center>Tanggal : $jadwal_tgl</p>
		<p align=center>Jam : $jadwal_jam WITA</p>";
	
	echo "<form name='konsumsi' action='component/com_sekretariat/proses.php?act=konsumsi' method='post'>
			<input type='hidden' name='kode_konsumsi' value='$kode_konsumsi' />
			<p align=center>No Peserta :
			<input type='text' name='no_peserta' size='8' maxlength='8' required>&nbsp;
			<input type='submit' value='Hadir' name='button-submit'></p></form><br></div>";
	echo "<script type='text/javascript' language='JavaScript'>
			document.forms['konsumsi'].elements['no_peserta'].focus();
			</script>";	
			
}
?>