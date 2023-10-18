<?php
include "config/class_paging.php";

$p      = new Paging;
$batas  = 7;
$posisi = $p->cariPosisi($batas);

$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM berita"));
													
$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

$sql = mysql_query("SELECT * FROM berita ORDER BY tanggal_berita DESC
						LIMIT $posisi,$batas");

echo "<div class='contentHeading'>Update News</div><p></p>";
		
$i=$posisi+1;		
while ($r=mysql_fetch_array($sql)) {
	echo "<span class='emp2'>$r[judul_berita]</span><br />
			<span class='emp1'>$r[tanggal_berita]</span>
			<p>";echo nl2br($r[isi_berita]); echo "</p>
			<br />";
	$i++;
}

echo "<div class='navigasi'>$linkHalaman</div>";	
	  
?>