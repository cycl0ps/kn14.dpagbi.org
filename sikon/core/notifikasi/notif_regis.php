<?php
if ($notif_type == 'us_ex'){
      echo "<h3>MAAF!</h3>
			<p>Username $username sudah terdaftar sebelumnya.</p>";
}

if ($notif_type == 'us_er'){
      echo "<h3>MAAF!</h3>
			<p>Username tidak boleh lebih dari 1 kata.</p>";
}

if ($notif_type == 'username_na'){
      echo "<h3>MAAF!</h3>
			<p>Username tidak boleh kosong.</p>";
}

if ($notif_type == 'name_na'){
      echo "<h3>MAAF!</h3>
			<p>Nama tidak boleh kosong.</p>";
}

if ($notif_type == 'em_er'){
      echo "<h3>MAAF!</h3>
			<p>Email belum diisi atau tidak valid.</p>";
}

if ($notif_type == 'pass_na'){
      echo "<h3>MAAF!</h3>
			<p>Password tidak boleh kosong.</p>";
}
?>