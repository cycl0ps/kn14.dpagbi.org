<?php
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

$nopes 	= $_GET[no_pes];

echo "<div class='contentHeading'>Registrasi Ulang</div>";

//form query no registrasi
echo "<form method=GET action=$_SERVER[PHP_SELF]>
			<input name='component' type='hidden' value='sekretariat'>
			<input name='act' type='hidden' value='registrasi_ulang'>
			<p>Masukkan No Peserta :
			<input type='text' name='no_pes' size='8' maxlength='8' value='$nopes'>&nbsp;
			<input type='submit' value='Submit'></p></form><br>";

			
if ($nopes != "") {
	$sql 	= mysql_query("SELECT no_peserta, nama_lengkap, tanggal_lahir, email, asal_kpa, lokasi_penginapan, nama_pdn, status FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									WHERE no_peserta = '$nopes'");
	$r		= mysql_fetch_array($sql);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Peserta $nopes</span></div>";
	} 
	
	else {
		echo "<div id='div01'>
			<form method=POST action=component/com_sekretariat/proses.php?act=registrasi_ulang
					onSubmit=\"return confirm('Registrasi ulang peserta $r[no_peserta] akan dilakukan. Yakin?');\">
					<input type='hidden' name='nopes' value='$r[no_peserta]' />
			<span class='emp1'><label class='label2'>NO PESERTA :</label>$r[no_peserta]</span>
			<p>
				<label class='label2'>Nama Lengkap :</label>";echo(stripslashes($r[nama_lengkap]));echo "
			</p>
			<p>
				<label class='label2'>Asal PD :</label>$r[nama_pdn]
			</p>
		</div>";
	
		if ($r[status] != "Active") {
	
			if ($r[tanggal_lahir]=='1991-08-24' OR $r[tanggal_lahir]=='2000-12-25' OR $r[tanggal_lahir]=='0000-00-00' 
					OR $r[email]=='tmonolimay@yahoo.com' or $r[pekerjaan]=='belum tahu'
					OR $r[email]=='sampelg@yahoo.co.id' OR $r[asal_kpa] == 0 OR $r[lokasi_penginapan] == 0) {
			
				echo "<div id='div04'><span class='emp1'>Notifikasi Sistem</span><br /><br />";
		
			if ($r[tanggal_lahir]=='1991-08-24' OR $r[tanggal_lahir]=='2000-12-25' OR $r[email]=='sampelg@yahoo.co.id' 
					OR $r[tanggal_lahir]=='0000-00-00' OR $r[email]=='tmonolimay@yahoo.com' or $r[pekerjaan]=='belum tahu') {
				echo "* Biodata peserta belum diupdate
					<a href=$_SERVER[PHP_SELF]?component=sekretariat&act=edit_biodata&no_pes=$r[no_peserta]>[Update Biodata]</a><br />";
			}
			if ($r[asal_kpa] == 0) {
				echo "* Asal KPA peserta belum diisi
					<a href=$_SERVER[PHP_SELF]?component=sekretariat&act=edit_biodata&no_pes=$r[no_peserta]>[Update KPA]</a><br />";
			}
			if ($r[lokasi_penginapan] == 0) {
				echo "* Penginapan peserta belum diassign
					<a href=$_SERVER[PHP_SELF]?component=sekretariat&act=assign_penginapan&no_pes=$r[no_peserta]>[Assign Penginapan]</a><br />";
			}
			echo "<br /></div>";
		}

		echo "<p align='center'><input type='submit' value='Registrasi Ulang' name='button-confirm'></p></form></div>";
	
		} else {
			echo "</form><div id='div04'><span class='emp1'>SUDAH REGISTRASI ULANG</span></div>";
		}
	}
}
?>