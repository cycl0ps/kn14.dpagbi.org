<?php
include "config/library.php";
include "config/fungsi_combobox.php";
include "config/koneksi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Formulir Pendaftaran KN XIV DPA GBI 2013</title>
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="knicon.ico" rel="shortcut icon" type="image/x-icon">
	<script type='text/javascript' src='js/common.js'></script>
</head>
<body>
	<div id="header">
		<?php include_once "header.php" ?>
	</div>

	<h1>Formulir Pendaftaran Peserta KN XIV DPA GBI Tahun 2013</h1>
	<form id="registrasi" action="confirmation.php" method="post">

	<div id="div01">
		<h3>Data Pribadi</h3>
		<p>
			<label for='nama'>Nama Lengkap : &nbsp;</label>
			<input type='text' name='nama' id='nama' size='52' required/>
		</p>
		<p>
			<label for='jenis_kelamin'>Jenis Kelamin : &nbsp;</label>
			<input type='radio' value='Laki-Laki' name='jenis_kelamin' required/>Laki-Laki 
			<input type='radio' value='Perempuan' name='jenis_kelamin' />Perempuan
		</p>
		<p>
			<label for='tempat_tanggal_lahir'>Tempat Tanggal Lahir : &nbsp;</label>
			<input type="text" name="tempat_lahir" size="15" />
        	<?php    
			combotgl(1,31,'tgl_lahir','Tgl');
			combobln(1,12,'bln_lahir','Bulan');
			combotgl(1960,$thn_sekarang-10,'thn_lahir','Tahun');
			?>
		</p>

    	<hr />
		<h4>Alamat Domisili</h4>
    	<p>
			<label for='Negara'>Negara : &nbsp;</label>
        	<select name='negara' onchange='klikNegara(this)' required><option value='' selected>- Pilih Negara - </option>
        	<?php
			$sql=mysql_query("SELECT * FROM db_negara");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_negara]'>$r[nama_negara]</option>";
			}
			?>
			</select>
    	</p>
    	<p><div id="propinsi"></div></p>
    	<p><div id="kabkota"></div></p>
		<p>
			<label for='alamat'>Alamat : &nbsp;</label>
			<input type='text' name='alamat' id='alamat' size='50' required/>&nbsp; &nbsp;
        	Kode Pos : <input name='kodepos' type='text' id='kodepos' size='7' maxlength="7" />
		</p>
    	<hr />

		<p>
			<label for='no_telp'>No. Kontak : &nbsp;</label>
        	Telp. Rumah : &nbsp;<input name='no_tlp' type='text' id='no_tlp' size='15' maxlength="20" />&nbsp; &nbsp;
         	No.HP : &nbsp;<input name='no_hp' type='text' id='no_hp' size='15' maxlength="15" required/>
  		</p>
		<p>
			<label for='email'>Email : &nbsp;</label>
			<input type='text' name='email' id='email' size='30' required/>
		</p>
		<p>
			<label for='pekerjaan'>Pekerjaan : &nbsp;</label>
			<input type='text' name='pekerjaan' id='pekerjaan' size='30' />
  		</p>
	</div>

	<div id="div02">
		<h3>Data Gereja</h3>
		<p>
			<label for='gembala'>Nama Gembala : &nbsp;</label>
			<select name="gelar" id="gelar">
		  		<option value="Pdt.">Pdt.</option>
		  		<option value="Pdm.">Pdm.</option>
		  		<option value="Pdp.">Pdp.</option>
      		</select>
			<input type='text' name='gembala' id='gembala' size='40' required/>
		</p>
		<p>
			<label for='alamat_grj'>Asal Gereja : &nbsp;</label>
			<input type='text' name='alamat_grj' id='alamat_grj' size='60' required/>
  		</p>
		<p>
			<label for='tlp_grj'>No.Telp Gereja : &nbsp;</label>
        	<input name='tlp_grj' type='text' id='tlp_grj' size='15' maxlength="20" />&nbsp; &nbsp;
         	Fax : &nbsp;<input name='fax_grj' type='text' id='fax_grj' size='15' maxlength="20" />
		</p>
    	<p>
			<label for='asal_pd'>Asal PD : &nbsp;</label>
        	<select name='asal_pd' required><option value='' selected>- Pilih PD - </option>
        	<?php
			$sql=mysql_query("SELECT * FROM pdn_dpa");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_pdn]'>$r[nama_pdn]</option>";
			}
			?>
			</select>
    	</p>
 		<p>
			<label for='jabatan_kpa'>Jabatan KPA : &nbsp;</label>
			<input type='text' name='jabatan_kpa' id='jabatan_kpa' size='30' />
  		</p>
 		<p>
			<label for='ketua_kpa'>Nama Ketua KPA : &nbsp;</label>
			<input type='text' name='ketua_kpa' id='ketua_kpa' size='30' required/>
  		</p>
    	<p>
			<label for='komisi'>Komisi : &nbsp;</label>
        	<select name='komisi' required><option value='' selected>- Pilih Komisi - </option>
        	<?php
			$sql=mysql_query("SELECT * FROM komisi");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_komisi]'>$r[nama_komisi] - $r[abb_komisi]</option>";
			}
			?>
			</select>
    	</p>
    	</table>
	</div>

	<div id="div03">
    	<h3>Pilihan Sphere</h3>
    	<p>
			<label for='sphere'>Pilihan Sphere : &nbsp;</label>
        	<select name='sphere' required><option value='' selected>- Pilih Sphere - </option>
        	<?php
			$sql=mysql_query("SELECT * FROM sphere");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_sphere]'>$r[nama_sphere]</option>";
			}
			?>
			</select>
    	</p>
	</div>

	<div id="div04">
		<h3>Rencana Kedatangan</h3>
		<span class="emp1">Isi data dibawah ini jika rencana kedatangan telah fix. (optional)</span>
	  <p>
			Rencana Kedatangan dengan : &nbsp;
  		  <input type='radio' value='Kapal Laut' name='arrive_by' />
	  		Kapal Laut  &nbsp;
			<input type='radio' value='Pesawat Udara' name='arrive_by' />
			Pesawat Udara  &nbsp;
        	<input type='radio' value='Bis' name='arrive_by' />
        	Bis  &nbsp;
        	<input type='radio' value='Kendaraan Pribadi' name='arrive_by' />
        	Kendaraan Pribadi  &nbsp;
	  </p>
    	<p>
			Tiba di Manado Tanggal : &nbsp;
        	<?php    
			combotgl(1,31,'arrive_tgl','Tgl');
			combobln(6,8,'arrive_bln','Bulan');
			combotgl(2013,2013,'arrive_thn','Tahun');
			?>
        	&nbsp;&nbsp;Jam :<input name='arrive_jam' type='text' id='arrive_jam' size='6' maxlength="6" />
        	WITA
	  </p>
	</div>
    <p class="center">
		<input type='submit' name='tombol-register' value='Register' />
	</p>
	</form>

	<div id="footer">
		<?php include_once "footer.php" ?>
	</div>
</body>
</html>
