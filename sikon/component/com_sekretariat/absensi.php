<?php
include "config/fungsi_indotgl.php";

$kode_acara 	= $_GET[kode_acara];

echo "<div class='contentHeading'>Absen Acara</div>";

$acara = mysql_query("SELECT * FROM activity WHERE group_activity = 1 AND flag1 = 1 ORDER BY start_activity ASC");

echo "<form method=GET action=index.php?component=sekretariat&act=absensi>
		<input type='hidden' name='component' value='sekretariat' />
		<input type='hidden' name='act' value='absensi' />
		<p>Pilihan Acara :
		<select name=kode_acara>";
			
	$i=1;
	while ($r=mysql_fetch_array($acara)){
		echo "<option value='$r[id_activity]'"; 
		if ($kode_acara == $r[id_activity]) {echo " selected";} echo ">$r[nama_activity]</option>";
		$i++;
	}
	echo "<input type='submit' value='Pilih'></p></form><br>";

if ($kode_acara != "") {
	
	$sql 	= mysql_query("SELECT * FROM activity WHERE id_activity = '$kode_acara'");
	$q 		= mysql_fetch_array($sql);
	
	$jadwal_tgl = tgl_indo($q[start_activity]);
	$jadwal_jam = getjam($q[start_activity]);
									
	echo "<div id='div02'><h1><center>$q[nama_activity]</h1>";
	if (!empty($q[deskripsi_activity])) {echo "<h3><center>";echo nl2br($q[deskripsi_activity]); echo "</center></h3>";}
	echo "
		<p align=center>Tanggal : $jadwal_tgl</p>
		<p align=center>Jam : $jadwal_jam WITA</p>";
	if ($q[flag2]==1) {echo "<p align=center>Terbatas pemegang kredensi</p>";}
	
	echo "<form name='absensi' id='absensi' action='component/com_sekretariat/proses.php?act=absensi' method='post'>
			<input type='hidden' name='kode_acara' value='$kode_acara' />
			<input type='hidden' name='kredensi' value='$q[flag2]' />
			<input type='hidden' name='kom_sph' value='$q[flag3]' />
			<input type='hidden' name='kode_pil' value='$q[flag4]' />
			<p align=center>No Peserta :
			<input type='text' name='no_peserta' id='no_peserta' size='8' maxlength='8'>&nbsp;
			<input type='submit' value='Hadir' name='button-submit'></p></form><br></div>";

	echo "<script type='text/javascript' language='JavaScript'>
			document.forms['absensi'].elements['no_peserta'].focus();
			</script>";		
}
?>