<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Notifikasi - Formulir Pendaftaran KN XIV DPA GBI 2013</title>
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="knicon.ico" rel="shortcut icon" type="image/x-icon">
	</head>

	<body> 
	<div id="header">
		<?php include_once "header.php" ?>
	</div>
	<div id="errorBox">
	<?php
if ($notif_type == 'al_regis'){
      echo "<h3>MAAF!</h3>
			<p>$nama_lengkap sudah pernah melakukan pendaftaran sebelumnya.</p>";
}

if ($notif_type == 'na_na'){
      echo "<h3>MAAF!</h3>
			<p>Nama belum diisi.</p>";
}

if ($notif_type == 'jk_na'){
      echo "<h3>MAAF!</h3>
			<p>Jenis kelamin belum diisi.</p>";
}

if ($notif_type == 'tmptlh_na'){
      echo "<h3>MAAF!</h3>
			<p>Tempat lahir belum diisi.</p>";
}

if ($notif_type == 'tgl_na'){
      echo "<h3>MAAF!</h3>
			<p>Tanggal lahir belum diisi.</p>";
}

if ($notif_type == 'bln_na'){
      echo "<h3>MAAF!</h3>
			<p>Bulan lahir belum diisi.</p>";
}

if ($notif_type == 'thn_na'){
      echo "<h3>MAAF!</h3>
			<p>Tahun lahir belum diisi.</p>";
}

if ($notif_type == 'neg_na'){
      echo "<h3>MAAF!</h3>
			<p>Negara tidak boleh kosong.</p>";
}

if ($notif_type == 'prop_na'){
      echo "<h3>MAAF!</h3>
			<p>Propinsi belum diisi.</p>";
}

if ($notif_type == 'kabkota_na'){
      echo "<h3>MAAF!</h3>
			<p>Kabupaten/Kota belum diisi.</p>";
}

if ($notif_type == 'al_na'){
      echo "<h3>MAAF!</h3>
			<p>Alamat tidak boleh kosong.</p>";
}

if ($notif_type == 'hp_er'){
      echo "<h3>MAAF!</h3>
			<p>No HP belum diisi atau tidak valid.</p>";
}

if ($notif_type == 'em_er'){
      echo "<h3>MAAF!</h3>
			<p>Email belum diisi atau tidak valid.</p>";
}

if ($notif_type == 'pd_na'){
      echo "<h3>MAAF!</h3>
			<p>PD tidak boleh kosong.</p>";
}

if ($notif_type == 'sp_na'){
      echo "<h3>MAAF!</h3>
			<p>Belum memilih sphere.</p>";
}

if ($notif_type == 'ko_na'){
      echo "<h3>MAAF!</h3>
			<p>Anda belum memilih komisi.</p>";
}

echo "<a href=javascript:history.back()>Kembali</a></div>";
		?>
		</div>
	</body>
</html>