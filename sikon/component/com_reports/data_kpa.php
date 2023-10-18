<?php

$kode_pdln 	= $_POST[kode_pdln];

echo "<div class='contentHeading'>Data KPA</div>";

$sphere = mysql_query("SELECT * FROM pdn_dpa");

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_kpa>
		<p>Pilihan PD/PLN :
		<select name=kode_pdln>";
			
	$i=1;
	while ($r=mysql_fetch_array($sphere)){
		echo "<option value='$r[id_pdn]'"; if ($kode_pdln == $r[id_pdn]) {echo " selected";} echo ">$r[nama_pdn]</option>";
		$i++;
	}
	echo "</select><input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_pdln != "") {

	$field = "nama_kpa,alamat_kpa,nama_kabkota,nama_propinsi,nama_negara,tlp_kpa,fax_kpa,gembala_grj_kpa,nama_ketua_kpa";
	
	$query	= "SELECT ".$field." FROM kpa 
							LEFT JOIN db_negara ON negara_kpa = id_negara 
							LEFT JOIN db_prop ON propinsi_kpa = id_propinsi 
							LEFT JOIN db_kabkota ON kabkota_kpa = id_kabkota
							WHERE pdn_kpa = '$kode_pdln'
							ORDER BY propinsi_kpa, kabkota_kpa ASC";
							
	$sql 	= mysql_query($query);
	$sql2 	= mysql_query("SELECT nama_pdn FROM pdn_dpa where id_pdn = '$kode_pdln'");
	$q    = mysql_fetch_array($sql2);
	$title	= $q[nama_pdn];
									
	echo "<div class='subcontentHeading'><center>Data KPA $title</center></div>";
	//download link
	echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"kpa_$title\"></input>
						<input name='field' type='hidden' value=\"$field\"></input>
						<input name='query' type='hidden' value=\"$query\"></input></form>
						<a href='javascript:document.download.submit();'>Download Data</a>";
	echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>Nama KPA</th>
			<th>Kabupaten/Kota</th>
			<th>Propinsi</th>
			<th>Negara</th>
		</tr></thead>";
		$i=1;
		while ($s=mysql_fetch_array($sql)){
			echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=kpa&id=$s[id_kpa]>";echo(stripslashes($s[nama_kpa]));echo "</a></td>
					<td>$s[nama_kabkota]</td>
					<td>$s[nama_propinsi]</td>
					<td>$s[nama_negara]</td>
				</tr>";
		$i++;
		}
echo "</table>";
}
?>