<?php
include "config/class_paging.php";
include "config/fungsi_indotgl.php";

echo "<div class='contentHeading'>Data Pendaftar</div>";
echo "
	<p>
		Data Pendaftar adalah data calon peserta yang telah mengisi formulir pendaftaran
		dan belum terdaftar sebagai peserta atau belum melakukan pembayaran/konfirmasi pembayaran.
	</p>
	<p>
		<a href=component/com_reports/proses.php?act=download_data_pendaftar>Download Data Pendaftar</a>
	</p>
	<p>
		<a href=$_SERVER[PHP_SELF]?component=reports&act=search_pendaftar>Advanced Search</a>
	</p>";

$p      = new Paging;
$batas  = 100;
$posisi = $p->cariPosisi($batas);

$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM biodata WHERE status = 'Pendaftar'"));
$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);




$sql = mysql_query("SELECT no_registrasi, nama_lengkap, alamat_grj, asal_pd, nama_pdn, reg_date 
							FROM biodata LEFT JOIN pdn_dpa ON asal_pd = id_pdn
							WHERE status = 'Pendaftar'
							ORDER BY asal_pd, no_registrasi ASC
							LIMIT $posisi,$batas");

echo "<div class='subcontentHeading'><center>Listing data pendaftar/calon peserta</center></div>";
echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>No Reg.</th>
			<th>Nama Lengkap</th>
			<th>Asal PD/PLN</th>
			<th>Tgl. Daftar</th>
		</tr></thead>";
		$i=$posisi+1;
		while ($r=mysql_fetch_array($sql)){
			$tanggal = tgl_indo($r[reg_date]);
			echo "<tr>
					<td align='right'>$i.</td>
					<td align='center'>#$r[no_registrasi]</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$r[no_registrasi]>$r[nama_lengkap]</a></td>
					<td>$r[nama_pdn]</td>
					<td align='center'>$tanggal</td>
				</tr>";
		$i++;
		}
echo "</table>";

echo "<div class='navigasi'>$linkHalaman</div>";
	


?>