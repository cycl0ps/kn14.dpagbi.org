<?php
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

$nopes 	= $_GET[no_pes];

echo "<div class='contentHeading'>Edit Biodata Peserta</div>";

//form query no registrasi
echo "<form method=GET action=$_SERVER[PHP_SELF]>
			<input name='component' type='hidden' value='sekretariat'>
			<input name='act' type='hidden' value='edit_biodata'>
			<p>Masukkan No Peserta :
			<input type='text' name='no_pes' size='8' maxlength='8' value='$nopes'>&nbsp;
			<input type='submit' value='Submit'></p></form><br>";

			
if ($nopes != "") {
	$sql 	= mysql_query("SELECT * FROM biodata 
									LEFT JOIN pdn_dpa ON asal_pd = id_pdn
									LEFT JOIN db_kabkota ON kab_kota = id_kabkota
									LEFT JOIN db_prop ON propinsi = db_prop.id_propinsi
									LEFT JOIN kpa ON asal_kpa = id_kpa
									WHERE no_peserta = '$nopes'");
	$r		= mysql_fetch_array($sql);
	
	if (mysql_num_rows($sql) == 0) {
		echo "<div id='notifBox'>Tidak ada data dengan <span class='emp1'>No. Peserta $nopes</span></div>";
	} else {
		echo "
		<span class='emp2'>NO PESERTA : $r[no_peserta]</span>
		<form method=POST action=component/com_sekretariat/proses.php?act=edit_biodata
		onSubmit=\"return confirm('Data peserta $r[no_peserta] akan diubah. Yakin?');\">
		<input type='hidden' name='nopes' value='$r[no_peserta]'>
		<div id='div01'>	
			<h3>Data Pribadi</h3>		
			<p>
				<label class='label2'>Nama Lengkap :</label>
				<input type='text' name='nama' id='nama' size='52' value=\"";echo(stripslashes($r[nama_lengkap]));echo "\" required/>
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
				<input type='text' name='tempat_lahir' size='15' value=\"";echo(stripslashes($r[tempat_lahir]));echo "\" />&nbsp;";
 
					combotgl2(1,31,'tgl_lahir',gettgl($r[tanggal_lahir]));
					combobln2(1,12,'bln_lahir',getbln($r[tanggal_lahir]));
					combotgl2(1960,$thn_sekarang-10,'thn_lahir',getthn($r[tanggal_lahir]));

			echo "</p>
			<hr />
			<h4>Alamat Domisili</h4>
			<p>
				<label class='label2'>Alamat :</label>
				<input type='text' name='alamat' id='alamat' size='52' value=\"";echo(stripslashes($r[alamat]));echo "\" />&nbsp;
				Kode Pos : <input name='kodepos' type='text' id='kodepos' size='7' maxlength='7' value='$r[kodepos]'/>
			</p>";
			
			if ($r[negara] != 107) {
				$textdivkab = "<select name='kabkota' id='kabkota'>
									<option value='0' selected>-- Luar Negeri --</option>
								</select>";
				$textdivprop = "<select name='propinsi' id='propinsi'>
									<option value='0' selected>-- Luar Negeri --</option>
								</select>";	
								
			} 
			else {
				$textdivkab		= "<select name='kabkota' id='kabkota'>";
				
				$qkabkota		= mysql_query("SELECT * FROM db_kabkota WHERE id_propinsi='$r[propinsi]'");
				while ($d=mysql_fetch_array($qkabkota)) {
					$textdivkab .= "<option value='$d[id_kabkota]'";
					if ($d[id_kabkota]==$r[kab_kota]){
						$textdivkab .= " selected";
					}
					$textdivkab .= ">$d[nama_kabkota]</option>"; 
				}
				$textdivkab .= "</select>";
		
				$textdivprop	= "<select name='propinsi' id='propinsi' onchange='klikPropinsi(this,1,$r[no_peserta])'>";
				
				$qprop			= mysql_query("SELECT * FROM db_prop");
				while ($e=mysql_fetch_array($qprop)) {
					$textdivprop .= "<option value='$e[id_propinsi]'";
					if ($e[id_propinsi]==$r[propinsi]){
						$textdivprop .= " selected";
					}
					$textdivprop .= ">$e[nama_propinsi]</option>"; 
				}
				$textdivprop .= "</select>";
			}
			
			echo "<p><label class='label2'>Kabupaten/Kota :</label>
					<span id='div_kabkota'>$textdivkab</span></p>
				<p><label class='label2'>Propinsi :</label>
					<span id='div_prop'>$textdivprop</span></p>";

			echo "<p>
					<label class='label2'>Negara :</label>
					<select name='negara' id='negara' onchange='klikNegara(this,$r[propinsi],1,$r[no_peserta])'>";
					
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
				<label class='label2'>No. Kontak : &nbsp;</label>
				Telp. Rumah : &nbsp;<input name='no_tlp' type='text' id='no_tlp' size='15' maxlength='20' value='$r[no_tlp]' />&nbsp; &nbsp;
				No.HP : &nbsp;<input name='no_hp' type='text' id='no_hp' size='15' maxlength='15' value='$r[no_hp]' />
			</p>
			<p>
				<label class='label2'>Email : &nbsp;</label>
				<input type='text' name='email' id='email' size='30' value='$r[email]' />
			</p>
			<p>
				<label class='label2'>Pekerjaan : &nbsp;</label>
				<input type='text' name='pekerjaan' id='pekerjaan' size='30' value='$r[pekerjaan]' />
			</p>
		</div>";
		
		$textdivkabkpa = "<select name='filter_kabkota' id='filter_kabkota'>
								<option value=''>-- Filter Kabupaten/Kota --</option>
							</select>";
		
		$textdivkpa = "<select name='nama_kpa' id='kabkota_kpa'>
						<option value=''>-- Pilih KPA --</option>";
			
		$qkpa = mysql_query("SELECT * FROM kpa WHERE pdn_kpa = $r[asal_pd]");
		while ($h=mysql_fetch_array($qkpa)) {
			$textdivkpa .= "<option value='$h[id_kpa]'";
			if ($h[id_kpa]==$r[asal_kpa]){
				$textdivkpa .= " selected";
			}
			$textdivkpa .= ">" . stripslashes($h[nama_kpa]) . "</option>"; 
		}
		$textdivkpa .= "</select>";	
		
		echo "
		<div id='div02'>	
			<h3>Data KPA</h3>
			<p>
				<label class='label2'>Asal KPD : &nbsp;</label>
				<select name='asal_pd' id='asal_pd' onchange='filterKpd(this,1,$r[no_peserta])'>";
				$qpdn=mysql_query("SELECT * FROM pdn_dpa");
				while ($s=mysql_fetch_array($qpdn)) {
					echo "<option value='$s[id_pdn]'";
					if ($s[id_pdn]==$r[asal_pd]){
						echo " selected";
					}
					echo ">$s[nama_pdn]</option>";
				}
				echo "</select>
			</p>
			<p>
				<label class='label2'>Asal KPA : &nbsp;</label>
				<span id='div_kpa'>$textdivkpa</span>
			</p>

			<p>
				<label class='label2'>&nbsp;</label>
				<select name='filter_prop' onchange='filterPropinsi(this,1,$r[no_peserta])'>
				<option value=''>-- Filter Propinsi --</option>
				<option value='0'>LUAR NEGERI</option>";
        		
				$qpropkpa=mysql_query("SELECT * FROM db_prop");
				while ($u=mysql_fetch_array($qpropkpa)) {
					echo "<option value='$u[id_propinsi]'>$u[nama_propinsi]</option>";
				}
				echo "</select>
			</p>
			<p>
				<label class='label2'>&nbsp;</label><span id='div_filterkabkota'>$textdivkabkpa</span>
			</p>

			<p>
				<label class='label2'>Jabatan di KPA : &nbsp;</label>
				<input type='text' name='jabatan_kpa' id='jabatan_kpa' size='30' value='$r[jabatan_kpa]'/>
			</p>
		</div>";
		
		echo "
		<div id='div03'>
			<h3>Pilihan Workshop</h3>
			<p>
				<label class='label2'>Sphere : &nbsp;</label>
				<select name='sphere'>";
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
			<p>
				<label class='label2'>Komisi : &nbsp;</label>
				<select name='komisi'><option value='' selected>- Pilih Komisi - </option>";

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