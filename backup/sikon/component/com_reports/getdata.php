<?php
include "../../config/fungsi_combobox.php";
include "../../config/koneksi.php";

$form		= $_GET[form];
$tabel		= $_GET[cat];

if ($form == "pendaftar") {
	if ($tabel == "no_registrasi") {
		echo "<p><label>Nomor registrasi</label>";
		echo "<input name='key' type='text' id='key' size='7' maxlength='7' />";
		echo "</p><p>
			<input type='submit' name='pencarian' value='Search' />
		</p>";
	}
	
	else if ($tabel == "nama_lengkap") {
		echo "<p><label>Nama Pendaftar</label>";
		echo "<input name='key' type='text' id='key' size='20' />";
		echo "</p><p>
			<input type='submit' name='pencarian' value='Search' />
		</p>";
	}
}

?>