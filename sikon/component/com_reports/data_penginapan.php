<?php

$kode_penginapan	= $_POST[kode_penginapan];

echo "<div class='contentHeading'>Data Penginapan</div>";

$house = mysql_query("SELECT * FROM penginapan");

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_penginapan>
		<p>Pilihan Penginapan :
		<select name=kode_penginapan>";
			
	$i=1;
	while ($r=mysql_fetch_array($house)){
		echo "<option value='$r[id_penginapan]'"; if ($kode_penginapan == $r[id_penginapan]) {echo " selected";} echo ">$r[nama_penginapan]</option>";
		$i++;
	}
	echo "</select><input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_penginapan != "") {

	$field = "no_peserta,no_registrasi,nama_lengkap,nama_pdn";
	
	$query		= "SELECT ".$field." FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn 
									LEFT JOIN penginapan ON lokasi_penginapan = id_penginapan 
									WHERE lokasi_penginapan = '$kode_penginapan'
									ORDER BY asal_pd ASC";
									
	$sql 	= mysql_query($query);
	$sql2 	= mysql_query("SELECT nama_penginapan FROM penginapan where id_penginapan = '$kode_penginapan'");
	$q    	= mysql_fetch_array($sql2);
	$title	= $q[nama_penginapan];
									
	echo "<div class='subcontentHeading'><center>Data Penginapan ";
	if ($kode_penginapan == 1) {echo "$title</center></div>";}
	else {echo "<a href=$_SERVER[PHP_SELF]?module=detail&act=penginapan&id=$kode_penginapan>$title</a></center></div>";}

	//download link
	echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"penginapan_$title\"></input>
						<input name='field' type='hidden' value=\"$field\"></input>
						<input name='query' type='hidden' value=\"$query\"></input></form>
						<a href='javascript:document.download.submit();'>Download Data</a>";
	
	echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>Nama Lengkap</th>
			<th>Asal PD/PLN</th>
		</tr></thead>";
		$i=1;
		while ($s=mysql_fetch_array($sql)){
			echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$s[no_registrasi]>";echo(stripslashes($s[nama_lengkap]));echo "</a></td>
					<td>$s[nama_pdn]</td>
				</tr>";
		$i++;
		}
echo "</table>";
}
?>