<?php
include "config/class_paging.php";

if ($_GET[form] == "tambah_kpa") {
	echo "<div class='contentHeading'>Tambah KPA</div>
		<form id='tambah_kpa' action='component/com_ppusat/proses.php?act=tambah_kpa' method='post'>
		<p>
			<label class='label2' for='nama_kpa'>Nama KPA : &nbsp;</label>
			<input type='text' name='nama_kpa' size='50' required/>
		</p>
		<p>
			<label class='label2'>Alamat KPA : &nbsp;</label>
			<input type='text' name='alamat_kpa' id='alamat_kpa' size='60'/>
  		</p>
		<p>
			<label class='label2'>Negara KPA : &nbsp;</label>
        	<select name='negara' onchange='klikNegara(this,0,0,2)' required>
			<option value='' selected>-- Pilih Negara --</option>";
        	
			$sql=mysql_query("SELECT * FROM db_negara");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_negara]'>$r[nama_negara]</option>";
			}
			echo "</select></p>";
			
		$textdivkab		= "<select name='kabkota' id='kabkota'>
								<option value='' selected>-- Pilih Kabupaten/Kota --</option>
							</select>";

		$textdivprop	= "<select name='propinsi' id='propinsi'>
								<option value='' selected>-- Pilih Propinsi --</option>
							</select>";
								
		
		echo "<p><label class='label2'>Propinsi KPA :</label>
					<span id='div_prop'>$textdivprop</span></p>
				<p><label class='label2'>Kabupaten/Kota KPA :</label>
					<span id='div_kabkota'>$textdivkab</span></p>
				

		<p>
			<label class='label2'>No.Telp KPA : &nbsp;</label>
        	<input name='tlp_kpa' type='text' id='tlp_kpa' size='15' maxlength='20'>&nbsp; &nbsp;
         	Fax : &nbsp;<input name='fax_kpa' type='text' id='fax_kpa' size='15' maxlength='20' />
		</p>
		<p>
			<label class='label2'>Nama Gembala Gereja : &nbsp;</label>
			<select name='gelar' id='gelar'>
		  		<option value='Pdt.'>Pdt.</option>
		  		<option value='Pdm.'>Pdm.</option>
		  		<option value='Pdp.'>Pdp.</option>
      		</select>
			<input type='text' name='gembala' id='gembala' size='40' required/>
		</p>
		<p>
			<label class='label2'>Nama Ketua KPA : &nbsp;</label>
			<input type='text' name='ketua_kpa' id='ketua_kpa' size='30'/>
  		</p>
		<p>
			<label class='label2'>Asal PD/PLN : &nbsp;</label>
        	<select name='asal_pd' required><option value='' selected>- Pilih PD - </option>";
			
			$sql=mysql_query("SELECT * FROM pdn_dpa");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_pdn]'>$r[nama_pdn]</option>";
			}

			echo "</select>
    	</p>
		<p>
			<input type='submit' name='tombol-tambah' value='Tambah' />
		</p>
		</form>";
		
	echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else if ($_GET[form] == "edit_kpa") {
	$id   = $_POST[id];

	$sql  = mysql_query("SELECT * FROM kpa WHERE id_kpa='$id'");
	$r    = mysql_fetch_array($sql);

	echo "<div class='contentHeading'>Edit KPA</div>
		<form id='edit_kpa' action='component/com_ppusat/proses.php?act=edit_kpa' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label class='label2' for='nama_kpa'>Nama KPA : &nbsp;</label>
			<input type='text' name='nama_kpa' size='50' value=\"";echo(stripslashes($r[nama_kpa]));echo "\"/>
		</p>
		<p>
			<label for='alamat_grj'>Alamat KPA : &nbsp;</label>
			<input type='text' name='alamat_kpa' id='alamat_kpa' size='60' value=\"";echo(stripslashes($r[alamat_kpa]));echo "\"/>
  		</p>";
		
		if ($r[negara_kpa] != 107) {
			$textdivkab = "<select name='kabkota' id='kabkota'>
							<option value='0' selected>-- Luar Negeri --</option>
							</select>";
			$textdivprop = "<select name='propinsi' id='propinsi'>
							<option value='0' selected>-- Luar Negeri --</option>
							</select>";
		
		} 
		else {
			$textdivkab		= "<select name='kabkota' id='kabkota'>";
				
			$qkabkota = mysql_query("SELECT * FROM db_kabkota WHERE id_propinsi='$r[propinsi_kpa]'");
			while ($d=mysql_fetch_array($qkabkota)) {
				$textdivkab .= "<option value='$d[id_kabkota]'";
				if ($d[id_kabkota]==$r[kabkota_kpa]){
					$textdivkab .= " selected";
				}
				$textdivkab .= ">$d[nama_kabkota]</option>"; 
			}
			$textdivkab .= "</select>";

			$textdivprop	= "<select name='propinsi' id='propinsi' onchange='klikPropinsi(this,2,$r[id_kpa])'>";

			$qprop = mysql_query("SELECT * FROM db_prop");
			while ($e=mysql_fetch_array($qprop)) {
				$textdivprop .= "<option value='$e[id_propinsi]'";
				if ($e[id_propinsi]==$r[propinsi_kpa]){
					$textdivprop .= " selected";
				}
				$textdivprop .= ">$e[nama_propinsi]</option>"; 
			}
			$textdivprop .= "</select>";
		}
				
	echo "<p><label class='label2'>Kabupaten/Kota KPA :</label>
				<span id='div_kabkota'>$textdivkab</span></p>
			<p><label class='label2'>Propinsi KPA :</label>
				<span id='div_prop'>$textdivprop</span></p>";
		
	echo "<p><label class='label2'>Negara :</label>
			<select name='negara' id='negara' onchange='klikNegara(this,$r[propinsi_kpa],2,$r[id_kpa])'>";
			$qneg=mysql_query("SELECT * FROM db_negara");
					while ($g=mysql_fetch_array($qneg)) {
						echo "<option value='$g[id_negara]'";
						if ($g[id_negara]==$r[negara_kpa]){
							echo " selected";
						}
						echo ">$g[nama_negara]</option>";
					}
			echo "</select></p>";

		echo "<p>
			<label for='tlp_kpa'>No.Telp KPA : &nbsp;</label>
        	<input name='tlp_kpa' type='text' id='tlp_kpa' size='15' maxlength='20' value='$r[tlp_kpa]'/>&nbsp; &nbsp;
         	Fax : &nbsp;<input name='fax_kpa' type='text' id='fax_kpa' size='15' maxlength='20' value='$r[fax_kpa]'/>
		</p>
		<p>
			<label for='gembala'>Nama Gembala : &nbsp;</label>
			<input type='text' name='gembala' id='gembala' size='40' value=\"";echo(stripslashes($r[gembala_grj_kpa]));echo "\"/>
		</p>
		<p>
			<label for='ketua_kpa'>Nama Ketua KPA : &nbsp;</label>
			<input type='text' name='ketua_kpa' id='ketua_kpa' size='30' value=\"";echo(stripslashes($r[nama_ketua_kpa]));echo "\"/>
  		</p>
		<p>
				<label for='asal_pd'>Asal PD/PLN : &nbsp;</label>
				<select name='asal_pd'>";
				$qdpa=mysql_query("SELECT * FROM pdn_dpa");
				while ($h=mysql_fetch_array($qdpa)) {
					echo "<option value='$h[id_pdn]'";
					if ($h[id_pdn]==$r[pdn_kpa]){
						echo " selected";
					}
					echo ">$h[nama_pdn]</option>";
				}
				echo "</select>
			</p>
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";
		
		echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else {
	echo "<div class='contentHeading'>Kelola KPA</div>";
	echo "
	<p>
		<a href=$_SERVER[PHP_SELF]?component=ppusat&act=kelola_kpa&form=tambah_kpa>Tambah KPA</a>
	</p>";

	$p      = new Paging;
	$batas  = 100;
	$posisi = $p->cariPosisi($batas);

	$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM kpa"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	
	$sql = mysql_query("SELECT * FROM kpa 	LEFT JOIN db_kabkota ON kabkota_kpa = id_kabkota
											ORDER BY pdn_kpa, propinsi_kpa, kabkota_kpa ASC
											LIMIT $posisi,$batas");
							
	echo "<div class='subcontentHeading'><center>Listing data KPA</center></div>";
	echo "<table class='report2' align='center'	>
			<tr><thead>
				<th>No</th>
				<th>Nama KPA</th>
				<th>Kabupaten/Kota</th>
				<th></th>
			</tr></thead>";
	$i=$posisi+1;
	while ($r=mysql_fetch_array($sql)){
		if ($r[negara_kpa] != 107) {
			$kabkota = "Luar Negeri";
		} else {
			$kabkota = $r[nama_kabkota];
		}
		echo "<tr>
				<td align='right'>$i.</td>
				<td><a href=$_SERVER[PHP_SELF]?module=detail&act=kpa&id=$r[id_kpa]>";echo(stripslashes($r[nama_kpa]));echo "</td>
				<td>$kabkota</td>
				<td align='center'>
					<form name='kpaedit$i' method='POST' action='index.php?component=ppusat&act=kelola_kpa&form=edit_kpa'>
					<input name='id' type='hidden' value='$r[id_kpa]'></input></form>
					<form name='kpadel$i' method='POST' action='component/com_ppusat/proses.php?act=del_kpa'>
					<input name='id' type='hidden' value='$r[id_kpa]'></input></form>
					<a href='javascript:document.kpaedit$i.submit();'>edit</a> &nbsp;
					<a href='javascript:document.kpadel$i.submit();'
					onclick=\"javascript:return confirm('$r[nama_kpa] akan dihapus. Yakin?')\">delete</a>
				</td>
			</tr>";
		$i++;
	}
	echo "</table>";
	echo "<div class='navigasi'>$linkHalaman</div>";
}


	


?>