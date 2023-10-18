<?php
include "config/fungsi_indotgl.php";

$kode_tgl 	= $_POST[kode_tgl];

echo "<div class='contentHeading'>Data Kedatangan</div>";

echo "<form method=POST action=$_SERVER[PHP_SELF]?component=reports&act=data_kedatangan>
			<p>Tanggal Kedatangan :
			<select name=kode_tgl>
			<option value='1'"; if ($kode_tgl == 1) {echo " selected";} echo ">Sebelum 22 Agustus</option>
			<option value='2'"; if ($kode_tgl == 2) {echo " selected";} echo ">22 Agustus</option>
			<option value='3'"; if ($kode_tgl == 3) {echo " selected";} echo ">23 Agustus</option>
			<option value='4'"; if ($kode_tgl == 4) {echo " selected";} echo ">24 Agustus</option>
			<option value='5'"; if ($kode_tgl == 5) {echo " selected";} echo ">25 Agustus</option>
			<option value='6'"; if ($kode_tgl == 6) {echo " selected";} echo ">26 Agustus</option>
			<option value='7'"; if ($kode_tgl == 7) {echo " selected";} echo ">27 Agustus</option>
			<option value='8'"; if ($kode_tgl == 8) {echo " selected";} echo ">Sesudah 27 Agustus</option>
			<option value='9'"; if ($kode_tgl == 9) {echo " selected";} echo ">Belum diketahui</option>&nbsp;
			<input type='submit' value='Pilih' name='button-submit'></p></form><br>";

if ($kode_tgl != "") {

	switch($kode_tgl) {
		case 1: $ekspresi_query = "arrive_date BETWEEN 1 AND '2013-08-21'"; $s = "Sebelum 22 Agustus 2013"; break;
		case 2: $ekspresi_query = "arrive_date = '2013-08-22'"; $s = "22 Agustus 2013"; break;
		case 3: $ekspresi_query = "arrive_date = '2013-08-23'"; $s = "23 Agustus 2013"; break;
		case 4: $ekspresi_query = "arrive_date = '2013-08-24'"; $s = "24 Agustus 2013"; break;
		case 5: $ekspresi_query = "arrive_date = '2013-08-25'"; $s = "25 Agustus 2013"; break;
		case 6: $ekspresi_query = "arrive_date = '2013-08-26'"; $s = "26 Agustus 2013"; break;
		case 7: $ekspresi_query = "arrive_date = '2013-08-27'"; $s = "27 Agustus 2013"; break;
		case 8: $ekspresi_query = "arrive_date > '2013-08-27'"; $s = "Setelah 27 Agustus 2013"; break;
		case 9: $ekspresi_query = "arrive_date = '0000-00-00'"; $s = "Belum diketahui"; break;
	}
	
	$sql 	= mysql_query("SELECT nama_lengkap, id_pdn, asal_pd, nama_pdn, arrive_date, 
									arrive_by, arrive_time, no_registrasi  FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn 
									WHERE $ekspresi_query 
									ORDER BY asal_pd ASC");
									
	echo "<div class='subcontentHeading'><center>Data Kedatangan $s</center></div>";
	echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>Nama Lengkap</th>
			<th>Asal PD/PLN</th>
			<th>Tanggal</th>
			<th>Jam</th>
			<th>Transportasi</th>
		</tr></thead>";
		$i=1;
		while ($r=mysql_fetch_array($sql)){
			$arrdate 	= tgl_indo($r[arrive_date]);
			echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$r[no_registrasi]>$r[nama_lengkap]</a></td>
					<td>$r[nama_pdn]</td>
					<td align='center'>$arrdate</td>
					<td>$r[arrive_time]</td>
					<td align='center'>$r[arrive_by]</td>
				</tr>";
		$i++;
		}
echo "</table>";
}
?>