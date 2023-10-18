<?php
include "config/fungsi_indotgl.php";

echo "<div class='contentHeading'>Selamat Datang $_SESSION[name]</div>
		<p align=right>Login Hari ini: ";
echo tgl_indo(date("Y m d")); 
echo " | "; 
echo date("H:i:s");
echo "</p><p>Sistem Informasi Kongres Nasional XIV DPA GBI. Sistem ini digunakan untuk manajemen pendaftar, peserta, konfirmasi pembayaran, akomodasi dll</p><br />";

include "config/class_paging.php";

$p      = new Paging;
$batas  = 4;
$posisi = $p->cariPosisi($batas);

$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM berita"));
													
$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

$sql = mysql_query("SELECT * FROM berita ORDER BY tanggal_berita DESC
						LIMIT $posisi,$batas");

echo "<div class='subcontentHeading'>UPDATE NEWS</div><hr />";
		
$i=$posisi+1;		
while ($r=mysql_fetch_array($sql)) {
	echo "<span class='emp2'>$r[judul_berita]</span><br />
			<span class='emp1'>$r[tanggal_berita]</span>
			<p>$r[isi_berita]</p>
			<br />";
	$i++;
}

echo "<div class='navigasi'>$linkHalaman</div>";	

?>