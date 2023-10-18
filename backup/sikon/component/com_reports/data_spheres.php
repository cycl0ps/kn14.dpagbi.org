<?php

$kode_spheres 	= $_POST[kode_spheres];

echo "<div class='contentHeading'>Data Spheres</div>";

$sphere = mysql_query("SELECT * FROM sphere");

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_spheres>
		<p>Pilihan Spheres :
		<select name=kode_spheres>";
			
	$i=1;
	while ($r=mysql_fetch_array($sphere)){
		echo "<option value='$r[id_sphere]'"; if ($kode_spheres == $r[id_sphere]) {echo " selected";} echo ">$r[nama_sphere]</option>";
		$i++;
	}
	echo "<input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_spheres != "") {
	
	$sql 	= mysql_query("SELECT nama_lengkap, id_pdn, asal_pd, nama_pdn, no_registrasi, sphere FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn 
									WHERE sphere = '$kode_spheres'
									ORDER BY asal_pd ASC");
	$sql2 	= mysql_query("SELECT nama_sphere FROM sphere where id_sphere = '$kode_spheres'");
	$q    = mysql_fetch_array($sql2);
									
	echo "<div class='subcontentHeading'><center>Data Sphere $q[nama_sphere]</center></div>";
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
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$s[no_registrasi]>$s[nama_lengkap]</a></td>
					<td>$s[nama_pdn]</td>
				</tr>";
		$i++;
		}
echo "</table>";
}
?>