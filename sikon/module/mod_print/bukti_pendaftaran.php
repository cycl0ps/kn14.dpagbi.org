<?php

include "../../config/koneksi.php";
include "../../config/library.php";
include "../../config/fungsi_indotgl.php";

$theme 	= mysql_query("SELECT path_theme FROM themes WHERE status_theme = 'active'");
$t 		= mysql_fetch_array($theme);

$nopes 	= $_GET[no_pes];

$sql1		= mysql_query("SELECT * FROM biodata 
								LEFT JOIN db_negara ON negara = id_negara
								LEFT JOIN db_prop ON propinsi = id_propinsi
								LEFT JOIN db_kabkota ON kab_kota = id_kabkota
								LEFT JOIN sphere ON biodata.sphere = sphere.id_sphere
								LEFT JOIN komisi ON biodata.komisi = komisi.id_komisi
								LEFT JOIN penginapan ON lokasi_penginapan = id_penginapan
								WHERE no_peserta = '$nopes'");
$r 			= mysql_fetch_array($sql1);
								
$sql2 		= mysql_query("SELECT * FROM kpa 
								LEFT JOIN db_negara ON negara_kpa = id_negara
								LEFT JOIN db_prop ON propinsi_kpa = id_propinsi
								LEFT JOIN db_kabkota ON kabkota_kpa = id_kabkota
								LEFT JOIN pdn_dpa ON pdn_kpa = id_pdn
								WHERE id_kpa = '$r[asal_kpa]'");
$p 			= mysql_fetch_array($sql2);

$sql3 		= mysql_query("SELECT * FROM pembayaran WHERE no_peserta = '$r[no_peserta]'");
$q 			= mysql_fetch_array($sql3);

$paydate 	= tgl_indo($q[tanggal_bayar]);
$bday 		= tgl_indo($r[tanggal_lahir]);

setlocale(LC_MONETARY, 'id_ID');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bukti Pendaftaran <?php echo "#$r[no_registrasi]";?> KN XIV DPA GBI</title>
	<link href="print.css" rel="stylesheet" type="text/css">
	<link href="<?php echo "../../$t[path_theme]" ?>/knicon.ico" rel="shortcut icon" type="image/x-icon">
	<script type="text/javascript">
		function cetak() {
			window.print();
		}
	</script>

</head>
<body onload="cetak()">
<div id="header">
	<img src="head.jpg" />
</div>
<div id="content">
	<p align="right">Manado, <?php echo tgl_indo(date("Y m d"));?></p>
	<h1>Bukti Pendaftaran KN XIV DPA GBI</h1>
	<p>Salam Sejahtera,</p>
	<p>Berikut kami sampaikan bukti pendaftaran untuk no registrasi <span class="emp1"><?php echo "#$r[no_registrasi]";?> </span>
		dengan data sebagai berikut:</p>	
			
	<table id="tabel1">
		<tr>
			<td class="label1">No Peserta</td><td>:</td>
			<td><span class="emp1"><?php echo "$r[no_peserta]";?></span></td>
		</tr>
		<tr>
			<td class="label1">Nama Peserta</td><td>:</td>
			<td><span class="emp1"><?php echo (stripslashes($r[nama_lengkap]));?></span></td>
		</tr>
		<tr>
			<td class="label1">Jumlah Bayar</td><td>:</td>
			<td><span class="emp1">Rp. <?php echo $q[jumlah_bayar];?></span></td>
		</tr>
		<tr>
			<td class="label1">Tanggal Bayar</td><td>:</td>
			<td><span class="emp1"><?php echo $paydate;?></span></td>
		</tr>
		<tr>
			<td class="label1">Metode Bayar</td><td>:</td>
			<td><span class="emp1"><?php echo $q[metode_bayar];?></span></td>
		</tr>
		<tr>
			<td  class="label1" valign="top">Pilihan Workshop</td><td></td>
			<td valign="top"><span class="emp1"><?php echo "Sphere : $r[nama_sphere] ($r[kode_sphere])<br />Komisi : $r[nama_komisi] ($r[abb_komisi])";?></span></td>
		</tr>
		<tr>
			<td class="label1">Tempat Penginapan</td><td>:</td>
			<td><span class="emp1"><?php echo $r[nama_penginapan];?> - <?php echo $r[alamat_penginapan];?></span></td>
		</tr>
	</table>
	<table id="tabel2">
		<tr>
			<td colspan="3"><h3>Data Personal</h3></td>
		</tr>
		<tr>
			<td>Nama Lengkap</td><td>:</td>
			<td><?php echo (stripslashes($r[nama_lengkap]));?>
		</tr>
		<tr>
			<td>Jenis Kelamin</td><td>:</td>
			<td><?php echo $r[jenis_kelamin];?></td>
		</tr>
		<tr>
			<td>Tempat Tanggal Lahir</td><td>:</td>
			<td><?php echo (stripslashes($r[tempat_lahir]));echo " $bday";?></td>
		</tr>
		<tr>
			<td valign="top">Alamat</td><td valign="top">:</td>
			<td><?php echo(stripslashes($r[alamat]));
		
				if ($r[negara]==107) {
					echo "<br />$r[nama_kabkota] - $r[nama_propinsi]";
				}
				echo "<br />$r[nama_negara]. $r[kodepos]";?>
			</td>
		</tr>
		<tr>
			<td>Nomor Kontak</td><td>:</td>
			<td><?php echo " Telp. $r[no_tlp] - Hp. $r[no_hp] - Email. $r[email]";?></td>
		</tr>
		<tr>
			<td>Pekerjaan</td><td>:</td>
			<td><?php echo "$r[pekerjaan]";?></td>
		</tr>
		<tr>
			<td>Jabatan di KPA</td><td>:</td>
			<td><?php echo(stripslashes($r[jabatan_kpa]));?></td>
		</tr>
		
		<tr>
			<td colspan="3"><h3>Data KPA</h3></td>
		</tr>
		<tr>
			<td>Nama KPA</td><td>:</td>
			<td><?php echo(stripslashes($p[nama_kpa]));?></td>
		</tr>
		<tr>
			<td>Asal PD</td><td>:</td>
			<td><?php echo "$p[nama_pdn]";?></td>
		</tr>
		<tr>
			<td valign="top">Alamat KPA</td><td valign="top">:</td>
			<td><?php echo(stripslashes($p[alamat_kpa]));
		
				if ($r[negara]==107) {
					echo "<br />$p[nama_kabkota] - $p[nama_propinsi] - ";
				}
				echo "$p[nama_negara]";?>
			</td>
		</tr>
		<tr>
			<td>No. Kontak KPA</td><td>:</td>
			<td><?php echo " Telp. $p[tlp_kpa] - Fax. $p[fax_kpa]";?></td>
		</tr>
		<tr>
			<td>Nama Gembala</td><td>:</td>
			<td><?php echo(stripslashes($p[gembala_grj_kpa]));?></td>
		</tr>
		<tr>
			<td>Ketua KPA</td><td>:</td>
			<td><?php echo(stripslashes($p[nama_ketua_kpa]));?></td>
		</tr>
	</table>
	<p>
		Atas partisipasi dan kerjasama anda dalam Kongres Nasional XIV Departemen 
		Pemuda dan Anak Gereja Bethel Indonesia Tahun 2013 sehingga dapat terselenggara dengan baik, 
		kami sampaikan terima kasih.
	</p>
	<p align="center"><span class="emp1">Tuhan Yesus Memberkati</span></p>
	<p align="center">Hormat Kami,<br />Panitia Pelaksana KN XIV DPA GBI</p>
</div>
<div id="footer">
	<img src="foot.jpg" />
</div>	
</body>
</html>
