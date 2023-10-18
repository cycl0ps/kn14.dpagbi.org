<?php
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

$noreg 	= $_GET[no_reg];

echo "<div class='contentHeading'>Konfirmasi Pembayaran</div>";

//form query no registrasi
echo "<form method=GET action=$_SERVER[PHP_SELF]>
			<input name='component' type='hidden' value='sekretariat'>
			<input name='act' type='hidden' value='konfirmasi_pembayaran'>
			<p>Masukkan No Registrasi :
			<input type='text' name='no_reg' size='7' maxlength='7' value='$noreg'>&nbsp;
			<input type='submit' value='Submit'></p></form><br>";

			
if ($noreg != "") {
	$sql 	= mysql_query("SELECT * FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									LEFT JOIN db_kabkota ON kab_kota = id_kabkota
									LEFT JOIN db_prop ON propinsi = db_prop.id_propinsi
									WHERE no_registrasi = '$noreg'");
	$r		= mysql_fetch_array($sql);
	$bday 	= tgl_indo($r[tanggal_lahir]);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Registrasi $noreg</span></div>";
	}
	
	else {
		echo "<div id='div01'>
				<span class='emp1'><label class='label2'>NO REGISTRASI :</label>$r[no_registrasi]</span>
			<p>
				<label class='label2'>Nama Lengkap :</label>";echo(stripslashes($r[nama_lengkap]));echo "
			</p>
			<p>
				<label class='label2'>Jenis Kelamin :</label>$r[jenis_kelamin]
			</p>
			<p>
				<label class='label2'>Tempat Tgl Lahir :</label>";echo(stripslashes($r[tempat_lahir]));echo " $bday
			</p>
			<p>
				<label class='label2'>Alamat :</label>";echo(stripslashes($r[alamat]));echo "<br />
				<label class='label2'>&nbsp;</label>$r[nama_kabkota] - $r[nama_propinsi]
			</p>
			<p>
				<label class='label2'>Asal PD :</label>$r[nama_pdn]
			</p>
			<p>
				<label class='label2'>Alamat Gereja :</label>";echo(stripslashes($r[alamat_grj]));echo "
			</p>
			</div>";
			
			if ($r[status] == "Pendaftar") {
				echo "<div id='div04'><span class='emp1'>PEMBAYARAN BELUM DIKONFIRMASI</span>";
				echo "<form method=POST action=component/com_sekretariat/proses.php?act=konfirmasi_pembayaran
					onSubmit=\"return confirm('Pembayaran pendaftar $r[no_registrasi] akan dikonfirmasi. Yakin?');\">
					<input type='hidden' name='noreg' value='$r[no_registrasi]' />
					<p><label class='label2'>Tanggal Bayar</label>";
						combotgl(1,31,'tgl_byr','Tgl');
						combobln(1,12,'bln_byr','Bulan');
						combotgl2(2013,2013,'thn_byr',2013);

					echo "</p>
					<p><label class='label2'>Jumlah Bayar</label>Rp. <input type='text' name='jml_bayar' id='jml_bayar' size='20'/></p>
					<p><label class='label2'>Metode Pembayaran</label>
						<select name='metode_byr'  id='metode_byr'>
						<option value=''>- Pilih Metoda Pembayaran -</option>
						<option value='Langsung'>Bayar Langsung</option>
						<option value='Transfer'>Transfer via Rekening/ATM/Internet</option>
						</select>
					<p><input type='submit' value='Konfirmasi Pembayaran' name='button-confirm'></p></form>
					";
				
			} else {
				echo "<div id='div04'><span class='emp1'>PEMBAYARAN TELAH DIKONFIRMASI</span></div>";
			}
	}
}
?>