<?php
include "config/class_paging.php";
include "config/fungsi_indotgl.php";

echo "<div class='contentHeading'>Data Pembayaran</div>";

$field = "pembayaran.no_peserta,pembayaran.no_registrasi,nama_lengkap,nama_pdn,tanggal_bayar,jumlah_bayar,trans_date";

$query	= "SELECT ".$field." FROM pembayaran
									LEFT JOIN biodata ON pembayaran.no_registrasi = biodata.no_registrasi
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									ORDER BY id_pdn, tanggal_bayar ASC";

$p      = new Paging;
$batas  = 100;
$posisi = $p->cariPosisi($batas);

$jmldata     = mysql_num_rows(mysql_query($query));
$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

$query_limit	= $query . " LIMIT $posisi,$batas";

$sql = mysql_query($query_limit);

echo "<div class='subcontentHeading'><center>Listing Data Pembayaran</center></div>";
	echo "<form name='download' method='POST' action='component/com_reports/proses.php?act=download_query'>
						<input name='title' type='hidden' value=\"Data Pembayaran\"></input>
						<input name='field' type='hidden' value=\"$field\"></input>
						<input name='query' type='hidden' value=\"$query\"></input></form>
						<a href='javascript:document.download.submit();'>Download Data</a>";
	echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>Nama Lengkap</th>
			<th>Asal PD/PLN</th>
			<th>Tanggal Bayar</th>
		</tr></thead>";
		$i=$posisi+1;
		while ($s=mysql_fetch_array($sql)){
			$tgl_byr = tgl_indo($s[tanggal_bayar]);
			echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$s[no_registrasi]>";echo(stripslashes($s[nama_lengkap]));echo "</a></td>
					<td>$s[nama_pdn]</td>
					<td>$tgl_byr</td>
				</tr>";
		$i++;
		}
echo "</table>";

echo "<div class='navigasi'>$linkHalaman</div>";
	


?>