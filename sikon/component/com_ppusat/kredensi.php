<?php
include "config/class_paging.php";

if ($_GET[form] == "tambah_kredensi") {
	echo "<div class='contentHeading'>Tambah Data Kredensi</div>
		<form id='tambah_kredensi' action='component/com_ppusat/proses.php?act=tambah_kredensi' method='post'>
		<p>
			<label class='label2'>Nama Pemegang : &nbsp;</label>
			<input type='text' name='nama' size='50' required/>
		</p>
		<p>
			<label class='label2'>No Registrasi : &nbsp;</label>
			<input type='text' name='noreg' size='7' maxlength='7' />
  		</p>";
		
		$textdivkabkredensi = "<select name='filter_kabkota' id='filter_kabkota'>
								<option value=''>-- Filter Kabupaten/Kota --</option>
							</select>";
		
		$textdivkpa = "<select name='nama_kpa' id='kabkota_kpa'>
						<option value=''>-- Pilih KPA --</option>";
			
		$qkpa = mysql_query("SELECT * FROM kpa");
		while ($h=mysql_fetch_array($qkpa)) {
			$textdivkpa .= "<option value='$h[id_kpa]'>" . stripslashes($h[nama_kpa]) . "</option>"; 
		}
		$textdivkpa .= "</select>";	
		
		echo "
			<p>
				<label class='label2'>Asal KPA : &nbsp;</label>
				<span id='div_kpa'>$textdivkpa</span>
			</p>
			
			<p>
				<label class='label2'>&nbsp;</label>
				<select name='filter_kpd' onchange='filterKpd(this,2,0)'>
				<option value=''>-- Filter KPD --</option>";
				$qpdn=mysql_query("SELECT * FROM pdn_dpa");
				while ($s=mysql_fetch_array($qpdn)) {
					echo "<option value='$s[id_pdn]'>$s[nama_pdn]</option>";
				}
				echo "</select>
			</p>

			<p>
				<label class='label2'>&nbsp;</label>
				<select name='filter_prop' onchange='filterPropinsi(this,2,0)'>
				<option value=''>-- Filter Propinsi --</option>
				<option value='0'>LUAR NEGERI</option>";
        		
				$qpropkpa=mysql_query("SELECT * FROM db_prop");
				while ($u=mysql_fetch_array($qpropkpa)) {
					echo "<option value='$u[id_propinsi]'>$u[nama_propinsi]</option>";
				}
				echo "</select>
			</p>
			<p>
				<label class='label2'>&nbsp;</label>
				<span id='div_filterkabkota'>$textdivkabkredensi</span>
			</p>
				
			
		<p>
			<input type='submit' name='tombol-tambah' value='Tambah' />
		</p>
		</form>";
		
	echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else if ($_GET[form] == "edit_kredensi") {
	$id   = $_POST[id];

	$sql  = mysql_query("SELECT * FROM kredensi WHERE id_kredensi='$id'");
	$r    = mysql_fetch_array($sql);

	echo "<div class='contentHeading'>Edit Kredensi</div>
		<form id='edit_kredensi' action='component/com_ppusat/proses.php?act=edit_kredensi' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label class='label2'>Nama Pemegang : &nbsp;</label>
			<input type='text' name='nama' size='50' value=\"";echo(stripslashes($r[nama_kredensi]));echo "\" required/>
		</p>
		<p>
			<label class='label2'>No Registrasi : &nbsp;</label>
			<input type='text' name='noreg' size='7' maxlength='7' value='$r[noreg_kredensi]' />
  		</p>";
		
		$textdivkabkredensi = "<select name='filter_kabkota' id='filter_kabkota'>
								<option value=''>-- Filter Kabupaten/Kota --</option>
							</select>";
		
		$textdivkpa = "<select name='nama_kpa' id='kabkota_kpa'>
						<option value=''>-- Pilih KPA --</option>";
			
		$qkpa = mysql_query("SELECT * FROM kpa");
		while ($h=mysql_fetch_array($qkpa)) {
			$textdivkpa .= "<option value='$h[id_kpa]'";
			if ($h[id_kpa]==$r[kpa_kredensi]){
				$textdivkpa .= " selected";
			}
			$textdivkpa .= ">" . stripslashes($h[nama_kpa]) . "</option>"; 
		}
		$textdivkpa .= "</select>";	
		
		echo "
			<p>
				<label class='label2'>Asal KPA : &nbsp;</label>
				<span id='div_kpa'>$textdivkpa</span>
			</p>
			
			<p>
				<label class='label2'>&nbsp;</label>
				<select name='filter_kpd' onchange='filterKpd(this,2,$r[kpa_kredensi])'>
				<option value=''>-- Filter KPD --</option>";
				$qpdn=mysql_query("SELECT * FROM pdn_dpa");
				while ($s=mysql_fetch_array($qpdn)) {
					echo "<option value='$s[id_pdn]'>$s[nama_pdn]</option>";
				}
				echo "</select>
			</p>

			<p>
				<label class='label2'>&nbsp;</label>
				<select name='filter_prop' onchange='filterPropinsi(this,2,$r[kpa_kredensi])'>
				<option value=''>-- Filter Propinsi --</option>
				<option value='0'>LUAR NEGERI</option>";
        		
				$qpropkpa=mysql_query("SELECT * FROM db_prop");
				while ($u=mysql_fetch_array($qpropkpa)) {
					echo "<option value='$u[id_propinsi]'>$u[nama_propinsi]</option>";
				}
				echo "</select>
			</p>
			<p>
				<label class='label2'>&nbsp;</label>
				<span id='div_filterkabkota'>$textdivkabkredensi</span>
			</p>
				
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";
		
		echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else {
	echo "<div class='contentHeading'>Kredensi</div>";
	echo "
	<p>
		<a href=$_SERVER[PHP_SELF]?component=ppusat&act=kredensi&form=tambah_kredensi>Tambah Data Kredensi</a>
	</p>";
	
	$p      = new Paging;
	$batas  = 100;
	$posisi = $p->cariPosisi($batas);

	$jmldata     = mysql_num_rows(mysql_query("SELECT * FROM kpa"));
	$jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
	$linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	
	$sql = mysql_query("SELECT * FROM kredensi LEFT JOIN kpa ON id_kpa = kpa_kredensi
											LIMIT $posisi,$batas");
							
	echo "<div class='subcontentHeading'><center>Listing data pemegang kredensi</center></div>";
	echo "<table class='report2' align='center'	>
			<tr><thead>
				<th>No</th>
				<th>Nama Pemegang</th>
				<th>No Registrasi</th>
				<th>Asal KPA</th>
				<th></th>
			</tr></thead>";
	$i=$posisi+1;
	while ($r=mysql_fetch_array($sql)){
	
		echo "<tr>
				<td align='right'>$i.</td>
				<td><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$r[noreg_kredensi]>";echo(stripslashes($r[nama_kredensi]));echo "</td>
				<td align='center'>$r[noreg_kredensi]</td>
				
				<td>";echo(stripslashes($r[nama_kpa]));echo "</td>
				<td align='center'>
					<form name='kredensiedit$i' method='POST' action='index.php?component=ppusat&act=kredensi&form=edit_kredensi'>
					<input name='id' type='hidden' value='$r[id_kredensi]'></input></form>
					<form name='kredensidel$i' method='POST' action='component/com_ppusat/proses.php?act=del_kredensi'>
					<input name='id' type='hidden' value='$r[id_kredensi]'></input></form>
					<a href='javascript:document.kredensiedit$i.submit();'>edit</a> &nbsp;
					<a href='javascript:document.kredensidel$i.submit();'
					onclick=\"javascript:return confirm('$r[nama_kredensi] akan dihapus. Yakin?')\">delete</a>
				</td>
			</tr>";
		$i++;
	}
	echo "</table>";
	echo "<div class='navigasi'>$linkHalaman</div>";

}


	


?>