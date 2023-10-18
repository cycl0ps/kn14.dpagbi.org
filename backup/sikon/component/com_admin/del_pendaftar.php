<?php
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

$noreg 	= $_POST[no_registrasi];

echo "<div class='contentHeading'>Delete Pendaftar</div>";

//form query no registrasi
echo "<form method=POST action=$_SERVER[PHP_SELF]?component=admin&act=del_pendaftar>
			<p>Masukkan No Registrasi :
			<input type='text' name='no_registrasi' size='7' maxlength='7' value='$noreg'>&nbsp;
			<input type='submit' value='Search' name='button-search'></p></form><br>";

			
if ($noreg != "") {
	$sql 	= mysql_query("SELECT * FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									LEFT JOIN db_kabkota ON kab_kota = id_kabkota
									LEFT JOIN db_prop ON propinsi = db_prop.id_propinsi
									WHERE no_registrasi = '$noreg'");
	$r			= mysql_fetch_array($sql);
	$bday 		= tgl_indo($r[tanggal_lahir]);
	$regdate 	= tgl_indo($r[reg_date]);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Registrasi $noreg</span></div>";
	}
	
	else {
		echo "<div id='div04'>
				<span class='emp1'><label class='label2'>NO REGISTRASI :</label>$r[no_registrasi]</span>
			<p>
				<label class='label2'>Nama Lengkap :</label>$r[nama_lengkap]
			</p>
			<p>
				<label class='label2'>Jenis Kelamin :</label>$r[jenis_kelamin]
			</p>
			<p>
				<label class='label2'>Tempat Tgl Lahir :</label>$r[tempat_lahir] $bday
			</p>
			<p>
				<label class='label2'>Alamat :</label>$r[alamat]<br />
				<label class='label2'>&nbsp;</label>$r[nama_kabkota] - $r[nama_propinsi]
			</p>
			<p>
				<label class='label2'>Asal PD :</label>$r[nama_pdn]
			</p>
			<p>
				<label class='label2'>Alamat Gereja :</label>$r[alamat_grj]
			</p>
			<p>
				<label class='label2'>Tanggal Daftar :</label>$regdate
			</p>
			</div>

			<form method=POST action=component/com_admin/proses.php?form=delpendaftar
				onSubmit=\"return confirm('Data peserta #$r[no_registrasi] - $r[nama_lengkap] akan dihapus. Yakin?');\">
			<input type='hidden' name='userid' value='$r[id]' />
			<input type='submit' value='Delete Pendaftar' name='button-delete'></p></form>

			";
	
	}
}
?>