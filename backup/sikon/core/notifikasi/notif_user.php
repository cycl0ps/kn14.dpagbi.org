<?php

if ($notif_type == 'name_na'){
      echo "<h3>MAAF!</h3>
			<p>Nama tidak boleh kosong.</p>";
}

if ($notif_type == 'em_er'){
      echo "<h3>MAAF!</h3>
			<p>Email belum diisi atau tidak valid.</p>";
}

if ($notif_type == 'pass_er'){
      echo "<h3>MAAF!</h3>
			<p>Password lama salah.</p>";
}

if ($notif_type == 'passb_er'){
      echo "<h3>MAAF!</h3>
			<p>Password baru tidak boleh kosong.</p>";
}
?>