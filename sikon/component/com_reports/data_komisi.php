<?php

$kode_komisi 	= $_POST[kode_komisi];

echo "<div class='contentHeading'>Data Workshop Komisi</div>";

$komisi = mysql_query("SELECT * FROM komisi");

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_komisi>
		<p>Pilihan Komisi :
		<select name=kode_komisi>";
			
	$i=1;
	while ($r=mysql_fetch_array($komisi)){
		echo "<option value='$r[id_komisi]'"; if ($kode_komisi == $r[id_komisi]) {echo " selected";} echo ">$r[nama_komisi] ($r[abb_komisi])</option>";
		$i++;
	}
	echo "</select><input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_komisi != "") {

	$field = "no_peserta,no_registrasi,nama_lengkap,nama_pdn";

	$query		= "SELECT ".$field." FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn 
									WHERE komisi = '$kode_komisi'
									ORDER BY asal_pd ASC";
	$sql 	= mysql_query($query);
	$sql2 	= mysql_query("SELECT nama_komisi,abb_komisi FROM komisi WHERE id_komisi = '$kode_komisi'");
	$q    	= mysql_fetch_array($sql2);
	$title	= $q[abb_komisi];
									
	echo "<div class='subcontentHeading'><center>Data Workshop Komisi $q[nama_komisi] ($q[abb_komisi])</center></div>";
		echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"komisi_$title\"></input>
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