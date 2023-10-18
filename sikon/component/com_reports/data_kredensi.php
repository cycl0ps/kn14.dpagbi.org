<?php
include "config/class_paging.php";
include "config/fungsi_indotgl.php";

echo "<div class='contentHeading'>Data Pembayaran</div>";

$field = "nama_kredensi AS nama,noreg_kredensi AS no_registrasi,nama_kpa";

$query	= "SELECT ".$field." FROM kredensi
									LEFT JOIN kpa ON kpa_kredensi = id_kpa";

$p      = new Paging;
$batas  = 100;
$posisi = $p->cariPosisi($batas);

$jmldata     = mysql_num_rows(mysql_query($query));
$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

$query_limit	= $query . " LIMIT $posisi,$batas";

$sql = mysql_query($query_limit);

echo "<div class='subcontentHeading'><center>Listing Data Pemegang Kredensi</center></div>";
	echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"Data Kredensi\"></input>
						<input name='field' type='hidden' value=\"$field\"></input>
						<input name='query' type='hidden' value=\"$query\"></input></form>
						<a href='javascript:document.download.submit();'>Download Data</a>";
	echo "<table class='report1'>
		<tr><thead>
				<th>No</th>
				<th>Nama Pemegang</th>
				<th>No Registrasi</th>
				<th>Asal KPA</th>
			</tr></thead>";
		$i=$posisi+1;
		while ($s=mysql_fetch_array($sql)){
			echo "<tr>
				<td align='right'>$i.</td>
				<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$s[noreg_kredensi]>";echo(stripslashes($s[nama]));echo "</td>
				<td align='center'>$s[no_registrasi]</td>
				<td>";echo(stripslashes($s[nama_kpa]));echo "</td>
			</tr>";
		$i++;
		}
echo "</table>";

echo "<div class='navigasi'>$linkHalaman</div>";
	


?>