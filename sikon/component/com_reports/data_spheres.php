<?php

$kode_spheres 	= $_POST[kode_spheres];

echo "<div class='contentHeading'>Data Workshop Spheres</div>";

$sphere = mysql_query("SELECT * FROM sphere");

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_spheres>
		<p>Pilihan Spheres :
		<select name=kode_spheres>";
			
	$i=1;
	while ($r=mysql_fetch_array($sphere)){
		echo "<option value='$r[id_sphere]'"; if ($kode_spheres == $r[id_sphere]) {echo " selected";} echo ">$r[nama_sphere]</option>";
		$i++;
	}
	echo "</select><input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_spheres != "") {

	$field = "no_peserta,no_registrasi,nama_lengkap,nama_pdn";

	$query		= "SELECT ".$field." FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn 
									WHERE sphere = '$kode_spheres'
									ORDER BY asal_pd ASC";
	$sql 	= mysql_query($query);
	$sql2 	= mysql_query("SELECT nama_sphere FROM sphere WHERE id_sphere = '$kode_spheres'");
	$q    = mysql_fetch_array($sql2);
	$title	= $q[nama_sphere];
									
	echo "<div class='subcontentHeading'><center>Data Workshop Sphere $title</center></div>";
	//download link
	echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"sphere_$title\"></input>
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