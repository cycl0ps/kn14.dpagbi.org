<?php
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

$nopes 	= $_POST[no_peserta];

echo "<div class='contentHeading'>Assign Penginapan</div>";

//form query no registrasi
echo "<form method=POST action=$_SERVER[PHP_SELF]?component=sekretariat&act=assign_penginapan>
			<p>Masukkan No Peserta :
			<input type='text' name='no_peserta' size='8' maxlength='8' value='$nopes'>&nbsp;
			<input type='submit' value='Search' name='button-search'></p></form><br>";

			
if ($nopes != "") {
	$sql 	= mysql_query("SELECT * FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									LEFT JOIN db_kabkota ON kab_kota = id_kabkota
									LEFT JOIN db_prop ON propinsi = db_prop.id_propinsi
									WHERE no_peserta = '$nopes'");
	$r		= mysql_fetch_array($sql);
	$bday 	= tgl_indo($r[tanggal_lahir]);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Peserta $nopes</span></div>";
	}
	
	else {
		echo "<div id='div01'>
				<span class='emp1'><label class='label2'>NO PESERTA :</label>$r[no_peserta]</span>
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
				<label class='label2'>Asal KPA :</label>$r[asal_kpa]
			</p>
			<p>
				<label class='label2'>Email :</label>$r[email]
			</p></div>";
			
		echo "<div id='div04'><span class='emp1'>Assign Penginapan</span>";
		echo "<form method=POST action=component/com_sekretariat/proses.php?act=assign_penginapan
					onSubmit=\"return confirm('Assign penginapan $r[no_peserta] akan dilakukan. Yakin?');\">
				<input type='hidden' name='no_peserta' value='$r[no_peserta]' />
				<input type='hidden' name='old_penginapan' value='$r[lokasi_penginapan]' />
				<p><label class='label2'>Penginapan :</label>
				<select name=kode_penginapan required><option value='' selected>- Pilih Penginapan -</option>";
					
		$sql2 = mysql_query("SELECT * from penginapan");
		
		while ($s=mysql_fetch_array($sql2)){
			echo "<option value='$s[id_penginapan]'"; if ($r[lokasi_penginapan] == $s[id_penginapan]) {echo " selected";} echo ">$s[nama_penginapan]</option>";
		}

		echo "</select><p><input type='submit' value='Assign Penginapan' name='button-confirm'></p></form>";

	}
}
?>