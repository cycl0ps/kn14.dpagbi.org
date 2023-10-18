<?php
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

$nopes 	= $_GET[nopes];

echo "<div class='contentHeading'>Edit Biodata Peserta</div>";

//form query no registrasi
echo "<form method=GET action=$_SERVER[PHP_SELF]?component=sekretariat&act=edit_biodata>
			<input name='component' type='hidden' value='sekretariat'>
			<input name='act' type='hidden' value='edit_biodata'>
			<p>Masukkan No Peserta :
			<input type='text' name='nopes' size='8' maxlength='8' value='$nopes'>&nbsp;
			<input type='submit' value='Search'></p></form><br>";

			
if ($nopes != "") {
	$sql 	= mysql_query("SELECT * FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									LEFT JOIN db_kabkota ON kab_kota = id_kabkota
									LEFT JOIN db_prop ON propinsi = db_prop.id_propinsi
									WHERE no_peserta = '$nopes'");
	$r		= mysql_fetch_array($sql);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Peserta $nopes</span></div>";
	} else {
		echo "
		<span class='emp2'>NO PESERTA : $r[no_peserta]</span>
		<form method=POST action=component/com_sekretariat/proses.php?act=edit_biodata
		onSubmit=\"return confirm('Data peserta $r[no_peserta] akan diubah. Yakin?');\">
		<input name='nopes' type='hidden' value='$r[no_peserta]'>
		<div id='div01'>	
			<h3>Data Pribadi</h3>		
			<p>
				<label class='label2'>Nama Lengkap :</label>
				<input type='text' name='nama' id='nama' size='52' value='$r[nama_lengkap]' required/>
			</p>
			<p>
				<label class='label2'>Jenis Kelamin :</label>
				<input type='radio' value='Laki-Laki' name='jenis_kelamin' ";
				if ($r[jenis_kelamin]=='Laki-Laki') {
					echo "checked";}echo "/>Laki-Laki 
				<input type='radio' value='Perempuan' name='jenis_kelamin' ";
				if ($r[jenis_kelamin]=='Perempuan') {
					echo "checked";}echo "/>Perempuan 
			</p>
			<p>
				<label class='label2'>Tempat Tgl Lahir :</label>
				<input type='text' name='tempat_lahir' size='15' value='$r[tempat_lahir]' />&nbsp;";
 
					combotgl2(1,31,'tgl_lahir',gettgl($r[tanggal_lahir]));
					combobln2(1,12,'bln_lahir',getbln($r[tanggal_lahir]));
					combotgl2(1960,$thn_sekarang-10,'thn_lahir',getthn($r[tanggal_lahir]));

			echo "</p>
			<hr />
			<h4>Alamat Domisili</h4>
			<p>
				<label class='label2'>Alamat :</label>
				<input type='text' name='alamat' id='alamat' size='52' value='$r[alamat]' />&nbsp;
				Kode Pos : <input name='kodepos' type='text' id='kodepos' size='7' maxlength='7' value='$r[kodepos]'/>
			</p>";
			
			echo "<p>
				<label class='label2'>Kabupaten/Kota :</label>
				<select name='kabkota' id='kabkota' />";
					$qkabkota=mysql_query("SELECT * FROM db_kabkota");
					echo "<option value=''>- Luar Negeri -</option>";
					while ($d=mysql_fetch_array($qkabkota)) {
						echo "<option value='$d[id_kabkota]'";
						if ($d[id_kabkota]==$r[kab_kota]){
							echo " selected";
						}
						echo ">$d[nama_kabkota]</option>";
					}
			echo "</select></p>
			<p>
				<label class='label2'>Propinsi :</label>
				<select name='propinsi' id='propinsi' />";
					$qprop=mysql_query("SELECT * FROM db_prop");
					echo "<option value=''>- Luar Negeri -</option>";
					while ($f=mysql_fetch_array($qprop)) {
						echo "<option value='$f[id_propinsi]'";
						if ($f[id_propinsi]==$r[propinsi]){
							echo " selected";
						}
                        echo ">$f[nama_propinsi]</option>";
					}
			
			echo "</select></p>
				<p>
					<label class='label2'>Negara :</label>
					<select name='negara' id='negara' />";
					$qneg=mysql_query("SELECT * FROM db_negara");
					while ($g=mysql_fetch_array($qneg)) {
						echo "<option value='$g[id_negara]'";
						if ($g[id_negara]==$r[negara]){
							echo " selected";
						}
						echo ">$g[nama_negara]</option>";
					}
			echo "</select></p>
			<hr />
			<p>
				<label for='no_telp'>No. Kontak : &nbsp;</label>
				Telp. Rumah : &nbsp;<input name='no_tlp' type='text' id='no_tlp' size='15' maxlength='20' value='$r[no_tlp]' />&nbsp; &nbsp;
				No.HP : &nbsp;<input name='no_hp' type='text' id='no_hp' size='15' maxlength='15' value='$r[no_hp]' />
			</p>
			<p>
				<label for='email'>Email : &nbsp;</label>
				<input type='text' name='email' id='email' size='30' value='$r[email]' />
			</p>
			<p>
				<label for='pekerjaan'>Pekerjaan : &nbsp;</label>
				<input type='text' name='pekerjaan' id='pekerjaan' size='30' value='$r[pekerjaan]' />
			</p>
		</div>";
		
		echo "
		<div id='div02'>	
			<h3>Data Gereja</h3>
			<p>
				<label class='label2'>Nama Gembala :</label>
				<input type='text' name='nama_gembala' id='nama_gembala' size='52' value='$r[nama_gembala]' />
			</p>
			<p>
				<label class='label2'>Alamat Gereja:</label>
				<input type='text' name='alamat_grj' id='alamat_grj' size='52' value='$r[alamat_grj]' />
			</p>
			<p>
				<label class='label2'>No.Telp Gereja : &nbsp;</label>
				<input name='tlp_grj' type='text' id='tlp_grj' size='15' maxlength='20' value='$r[tlp_grj]' />&nbsp; &nbsp;
				Fax : &nbsp;<input name='fax_grj' type='text' id='fax_grj' size='15' maxlength='20' value='$r[fax_grj]' />
			</p>
			<p>
				<label for='asal_pd'>Asal PD : &nbsp;</label>
				<select name='asal_pd'>";
				$qdpa=mysql_query("SELECT * FROM pdn_dpa");
				while ($h=mysql_fetch_array($qdpa)) {
					echo "<option value='$h[id_pdn]'";
					if ($h[id_pdn]==$r[asal_pd]){
						echo " selected";
					}
					echo ">$h[nama_pdn]</option>";
				}
				echo "</select>
			</p>
			<p>
				<label for='jabatan_kpa'>Jabatan KPA : &nbsp;</label>
				<input type='text' name='jabatan_kpa' id='jabatan_kpa' size='30' value='$r[jabatan_kpa]'/>
			</p>
			<p>
				<label for='ketua_kpa'>Nama Ketua KPA : &nbsp;</label>
				<input type='text' name='ketua_kpa' id='ketua_kpa' size='30' value='$r[ketua_kpa]' />
			</p>
			<p>
				<label for='komisi'>Komisi : &nbsp;</label>
				<select name='komisi' required><option value='' selected>- Pilih Komisi - </option>";

			$ksql=mysql_query("SELECT * FROM komisi");
			while ($t=mysql_fetch_array($ksql)) {
				echo "<option value='$t[id_komisi]'";
					if ($t[id_komisi]==$r[komisi]){
						echo " selected";
					}
				echo ">$t[nama_komisi] - $t[abb_komisi]</option>";
			}
			echo "</select>
			</p>
		</div>";
		
		echo "
		<div id='div03'>
			<h3>Pilihan Sphere</h3>
			<p>
				<label for='sphere'>Pilihan Sphere : &nbsp;</label>
				<select name='sphere' />";
				$qspe=mysql_query("SELECT * FROM sphere");
				while ($s=mysql_fetch_array($qspe)) {
					echo "<option value='$s[id_sphere]'";
					if ($s[id_sphere]==$r[sphere]){
						echo " selected";
					}
					echo ">$s[nama_sphere]</option>";
				}
				echo "</select>
			</p>
		</div>";
		
		echo "
		<div id='div05'>
			<h3>Rencana Kedatangan</h3>
			 <p>
				Rencana Kedatangan dengan : &nbsp;
				<input type='radio' value='Kapal Laut' name='arrive_by'"; if ($r[arrive_by]=='Kapal Laut') {
					echo "checked";}echo "/>Kapal Laut  &nbsp;
				<input type='radio' value='Pesawat Udara' name='arrive_by'"; if ($r[arrive_by]=='Pesawat Udara') {
					echo "checked";}echo "/>Pesawat Udara  &nbsp;
				<input type='radio' value='Bis' name='arrive_by'"; if ($r[arrive_by]=='Bis') {
					echo "checked";}echo "/>Bis  &nbsp;
				<input type='radio' value='Kendaraan Pribadi' name='arrive_by'"; if ($r[arrive_by]=='Kendaraan Pribadi') {
					echo "checked";}echo "/>Kendaraan Pribadi  &nbsp;
			</p>
			<p>
				Tiba di Manado Tanggal : &nbsp;";
				if ($r[arrive_date]=="0000-00-00") {
					combotgl(1,31,'arrive_tgl','Tgl');
					combobln(6,8,'arrive_bln','Bulan');
					combotgl(2013,2013,'arrive_thn','Tahun');
				} else {
				combotgl2(1,31,'arrive_tgl',gettgl($r[arrive_date]));
				combobln2(6,8,'arrive_bln',getbln($r[arrive_date]));
				combotgl2(2013,2013,'arrive_thn',getthn($r[arrive_date]));
				}
				echo "&nbsp;&nbsp;Jam :<input name='arrive_jam' type='text' id='arrive_jam' size='6' maxlength='6' value='$r[arrive_time]'/>WITA
			</p>
		</div>
		<p align='center'>
		<input type='submit' name='tombol-submit' value='Update' />
		</p>
	</form>";
	}		
}

?>