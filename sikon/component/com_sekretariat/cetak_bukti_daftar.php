<?php
include "config/koleksi_fungsi.php";

$nopes 	= $_GET[no_pes];

echo "<div class='contentHeading'>Cetak Bukti Pendaftaran</div>";

//form query no pesta
echo "<form method=GET action=$_SERVER[PHP_SELF]>
			<input name='component' type='hidden' value='sekretariat'>
			<input name='act' type='hidden' value='cetak_bukti_daftar'>
			<p>Masukkan No Peserta :
			<input type='text' name='no_pes' size='8' maxlength='8' value='$nopes'>&nbsp;
			<input type='submit' value='Submit'></p></form><br>";
			
if ($nopes != "") {

	$sql 	= mysql_query("SELECT no_peserta, nama_lengkap, nama_pdn, status FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									WHERE no_peserta = '$nopes'");
	$r		= mysql_fetch_array($sql);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Peserta $nopes</span></div>";
	} 
	
	else {
		echo "<div id='div01'>
			<form>
			<span class='emp1'><label class='label2'>NO PESERTA :</label>$r[no_peserta]</span>
			<p>
				<label class='label2'>Nama Lengkap :</label>";echo(stripslashes($r[nama_lengkap]));echo "
			</p>
			<p>
				<label class='label2'>Asal PD :</label>$r[nama_pdn]
			</p>
		</div>";

		echo "<p align='center'><input type=\"button\" value=\"Cetak Bukti Daftar\" onclick=\"window.open('./module/mod_print/bukti_pendaftaran.php?no_pes=$r[no_peserta]','cetakbukti','height=500,width=400,left=100,top=100,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no');\"></p></form>";

	}
	
}

?>
