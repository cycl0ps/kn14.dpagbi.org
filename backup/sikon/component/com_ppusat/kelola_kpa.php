<?php

if ($_GET[form] == "tambah_kpa") {
	echo "<div class='contentHeading'>Tambah KPA</div>
		<form id='tambah_penginapan' action='component/com_ppusat/proses.php?act=tambah_kpa' method='post'>
		<p>
			<label class='label2' for='nama_kpa'>Nama KPA : &nbsp;</label>
			<input type='text' name='nama_kpa' size='50' required/>
		</p>
		<p>
			<label for='alamat_grj'>Alamat KPA : &nbsp;</label>
			<input type='text' name='alamat_kpa' id='alamat_kpa' size='60'/>
  		</p>
		<p>
			<label for='Negara'>Negara : &nbsp;</label>
        	<select name='negara' onchange='klikNegara(this)' required><option value='' selected>- Pilih Negara - </option>";
        				$sql=mysql_query("SELECT * FROM db_negara");
			while ($r=mysql_fetch_array($sql)) {
				echo "<option value='$r[id_negara]'>$r[nama_negara]</option>";
			}
			echo "</select>
    	</p>
		<p>
			<label for='tlp_kpa'>No.Telp KPA : &nbsp;</label>
        	<input name='tlp_kpa' type='text' id='tlp_kpa' size='15' maxlength='20' />&nbsp; &nbsp;
         	Fax : &nbsp;<input name='fax_kpa' type='text' id='fax_kpa' size='15' maxlength='20' />
		</p>
		<p>
			<label for='gembala'>Nama Gembala : &nbsp;</label>
			<select name='gelar' id='gelar'>
		  		<option value='Pdt.'>Pdt.</option>
		  		<option value='Pdm.'>Pdm.</option>
		  		<option value='Pdp.'>Pdp.</option>
      		</select>
			<input type='text' name='gembala' id='gembala' size='40' required/>
		</p>
		<p>
			<label for='ketua_kpa'>Nama Ketua KPA : &nbsp;</label>
			<input type='text' name='ketua_kpa' id='ketua_kpa' size='30'/>
  		</p>
		<p>
			<label for='asal_pd'>Asal PD : &nbsp;</label>
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

	$sql  = mysql_query("SELECT * FROM penginapan WHERE id_penginapan='$id'");
	$r    = mysql_fetch_array($sql);

	echo "<div class='contentHeading'>Edit Penginapan</div>
		<form id='edit_penginapan' action='component/com_sekretariat/proses.php?act=edit_penginapan' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label class='label2' for='nama'>Nama Penginapan : &nbsp;</label>
			<input type='text' name='nama_penginapan' size='30' value='$r[nama_penginapan]'/>
		</p>
		<p>
			<label class='label2' for='alamat'>Alamat Penginapan : &nbsp;</label>
			<input type='text' name='alamat_penginapan' size='50' value='$r[alamat_penginapan]'/>
		</p>
		<p>
			<label class='label2' for='kapasitas'>Kapasitas : &nbsp;</label>
			<input type='text' name='kapasitas' size='5' value='$r[kapasitas]'/>
		</p>
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";		
} 

else {
	echo "<div class='contentHeading'>Kelola KPA</div>";
	echo "
	<p>
		<a href=$_SERVER[PHP_SELF]?component=ppusat&act=kelola_kpa&form=tambah_kpa>Tambah KPA</a>
	</p>";

	$sql = mysql_query("SELECT * FROM kpa 	LEFT JOIN db_kabkota ON kabkota = id_kabkota
											LEFT JOIN pdn_dpa ON pdn = id_pdn
											ORDER BY pdn, kabkota ASC");
							
	echo "<div class='subcontentHeading'><center>Listing data KPA</center></div>";
	echo "<table class='report1' align='center'	>
			<tr><thead>
				<th>No</th>
				<th>Nama KPA</th>
				<th>Asal PD/PLN</th>
				<th>Kabupaten/Kota</th>
				<th></th>
			</tr></thead>";
	$i=1;
	while ($r=mysql_fetch_array($sql)){
		echo "<tr>
				<td align='right'>$i.</td>
				<td><a href=$_SERVER[PHP_SELF]?module=detail&act=kpa&id=$r[id_kpa]>$r[nama_kpa]</td>
				<td>$r[nama_pdn]</td>
				<td>$r[nama_kabkota]</td>
				<td>
					<form name='penginapanedit$i' method='POST' action='index.php?component=ppusat&act=edit_kpa'>
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
}


	


?>