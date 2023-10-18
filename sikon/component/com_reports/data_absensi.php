<?php

$kode_acara 	= $_POST[kode_acara];

echo "<div class='contentHeading'>Data Absensi</div>";

$absen = mysql_query("SELECT * FROM activity WHERE group_activity = 1 AND flag1 = 1 ORDER BY start_activity ASC");

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_absensi>
		<p>Pilihan Acara :
		<select name=kode_acara>";
			
	$i=1;
	while ($r=mysql_fetch_array($absen)){
		echo "<option value='$r[id_activity]'"; if ($kode_acara == $r[id_activity]) {echo " selected";} echo ">$r[nama_activity]</option>";
		$i++;
	}
	echo "</select><input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_acara != "") {

	$field = "no_peserta,no_registrasi,nama_lengkap,nama_kpa,nama_pdn";
	
	$query	= "SELECT ".$field." FROM presensi 
									LEFT JOIN activity ON kode_activity = id_activity
									LEFT JOIN biodata ON no_peserta = id_peserta
									LEFT JOIN kpa ON asal_kpa = id_kpa
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									WHERE kode_activity = '$kode_acara'
									ORDER BY id_pdn, id_kpa ASC";
							
	$sql 	= mysql_query($query);
	$sql2 	= mysql_query("SELECT nama_activity FROM activity where id_activity = '$kode_acara'");
	$q    = mysql_fetch_array($sql2);
	$title	= $q[nama_activity];
									
	echo "<div class='subcontentHeading'><center>Data Absensi $title</center></div>";
	echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"absen_$title\"></input>
						<input name='field' type='hidden' value=\"$field\"></input>
						<input name='query' type='hidden' value=\"$query\"></input></form>
						<a href='javascript:document.download.submit();'>Download Data</a>";
	echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>Nama Lengkap</th>
			<th>KPA</th>
			<th>Asal PD/PLN</th>
		</tr></thead>";
		$i=1;
		while ($s=mysql_fetch_array($sql)){
			echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$s[no_registrasi]>";echo(stripslashes($s[nama_lengkap]));echo "</a></td>
					<td>";echo(stripslashes($s[nama_kpa]));echo "</td>
					<td>$s[nama_pdn]</td>
				</tr>";
		$i++;
		}
echo "</table>";
}
?>