<?php
if ($notif_type == 'tglbayar_na'){
      echo "<h3>MAAF!</h3>
			<p>Tanggal bayar belum diisi.</p>";
}

if ($notif_type == 'blnbayar_na'){
      echo "<h3>MAAF!</h3>
			<p>Bulan bayar belum diisi.</p>";
}

if ($notif_type == 'jmlbayar_na'){
      echo "<h3>MAAF!</h3>
			<p>Jumlah bayar belum diisi.</p>";
}

if ($notif_type == 'mtdbayar_na'){
      echo "<h3>MAAF!</h3>
			<p>Metode bayar belum dipilih.</p>";
}

//edit data

if ($notif_type == 'na_na'){
      echo "<h3>MAAF!</h3>
			<p>Nama belum diisi.</p>";
}

if ($notif_type == 'tmptlh_na'){
      echo "<h3>MAAF!</h3>
			<p>Tempat lahir tidak boleh kosong.</p>";
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
			<p>No HP tidak boleh kosong atau tidak valid.</p>";
}

if ($notif_type == 'em_er'){
      echo "<h3>MAAF!</h3>
			<p>Email tidak boleh kosong atau tidak valid.</p>";
}

if ($notif_type == 'ko_na'){
      echo "<h3>MAAF!</h3>
			<p>Anda belum memilih komisi.</p>";
}

if ($notif_type == 'kpa_na'){
      echo "<h3>MAAF!</h3>
			<p>Anda belum memilih asal KPA.</p>";
}

?>