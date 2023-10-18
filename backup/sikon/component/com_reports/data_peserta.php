<?php

echo "<div class='contentHeading'>Data Peserta</div>";
echo "
	<p>
		Data Peserta adalah data pendaftar yang telah melakukan pembayaran/konfirmasi pembayaran.
	</p>
	<p>
		<a href=component/com_reports/proses.php?act=download_data_peserta>Download Data Peserta</a>
	</p>";

include "config/class_paging.php";

$p      = new Paging;
$batas  = 100;
$posisi = $p->cariPosisi($batas);

$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM biodata WHERE status = 'Peserta'"));
$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);


$sql = mysql_query("SELECT no_peserta, nama_lengkap, asal_pd, nama_pdn, no_registrasi 
							FROM biodata LEFT JOIN pdn_dpa ON asal_pd = id_pdn
							WHERE status = 'Peserta'
							ORDER BY asal_pd, no_peserta ASC
							LIMIT $posisi,$batas");

echo "<div class='subcontentHeading'><center>Listing data peserta</center></div>";
echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>No. Peserta.</th>
			<th>Nama Lengkap</th>
			<th>Asal PD/PLN</th>
			<th>No.Regis</th>
		</tr></thead>";
		$i=$posisi+1;
		while ($r=mysql_fetch_array($sql)){
			echo "<tr>
					<td align='right'>$i.</td>
					<td align='center'>$r[no_peserta]</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$r[no_registrasi]>$r[nama_lengkap]</a></td>
					<td>$r[nama_pdn]</td>
					<td align='center'>#$r[no_registrasi]</td>
				</tr>";
		$i++;
		}
echo "</table>";

echo "<div class='navigasi'>$linkHalaman</div>";
	


?>