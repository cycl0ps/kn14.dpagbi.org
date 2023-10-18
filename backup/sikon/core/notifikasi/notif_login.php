<?php

if ($notif_type == 'user_notexist'){
      echo "<h3>LOGIN GAGAL!</h3>
			<p>Username belum aktif atau tidak terdaftar.</p>";
}

if ($notif_type == 'pass_notmatch'){
      echo "<h3>LOGIN GAGAL!</h3>
			<p>Password salah.</p>";
}

if ($notif_type == 'email_na'){
      echo "<h3>GAGAL!</h3>
			<p>Tidak ada akun dengan email $email.</p>";
}

if ($notif_type == 'send_pass'){
      echo "<h3>BERHASIL!</h3>
			<p>Silahkan mengecek email anda di: $email.</p>";
}
?>