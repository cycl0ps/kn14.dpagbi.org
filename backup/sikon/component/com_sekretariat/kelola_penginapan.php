<?php

if ($_GET[form] == "tambah_penginapan") {
	echo "<div class='contentHeading'>Tambah Penginapan</div>
		<form id='tambah_penginapan' action='component/com_sekretariat/proses.php?act=tambah_penginapan' method='post'>
		<p>
			<label class='label2' for='nama'>Nama Penginapan : &nbsp;</label>
			<input type='text' name='nama_penginapan' size='30'/>
		</p>
		<p>
			<label class='label2' for='alamat'>Alamat Penginapan : &nbsp;</label>
			<input type='text' name='alamat_penginapan' size='50'/>
		</p>
		<p>
			<label class='label2' for='kapasitas'>Kapasitas : &nbsp;</label>
			<input type='text' name='kapasitas' size='5'/>
		</p>
		<p>
			<label class='label2' for='flag'>Additional : &nbsp;</label>
			<input type='checkbox' name='flag' value='1'>Penginapan yang dapat di upgrade
		</p>
		<p>
			<input type='submit' name='tombol-tambah' value='Tambah' />
		</p>
		</form>";
		
	echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else if ($_GET[form] == "edit_penginapan") {
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
			<label class='label2' for='flag'>Additional : &nbsp;</label>
			<input type='checkbox' name='flag' value='1'";
			if ($r[flag]==1) {echo " checked";}
			echo ">Penginapan yang dapat di upgrade
		</p>
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";		
} 

else {
	echo "<div class='contentHeading'>Kelola Penginapan</div>";
	echo "<p>
			<a href=$_SERVER[PHP_SELF]?component=sekretariat&act=kelola_penginapan&form=tambah_penginapan>Tambah Penginapan</a>
		</p>";

	$sql = mysql_query("SELECT * FROM penginapan WHERE id_penginapan != 1");
							
	echo "<div class='subcontentHeading'><center>Listing data penginapan</center></div>";
	echo "<table class='report2' align='center'	>
			<tr><thead>
				<th>No</th>
				<th>Nama Penginapan</th>
				<th>Alamat</th>
				<th>Kapasitas</th>
				<th></th>
			</tr></thead>";
			$i=1;
			while ($r=mysql_fetch_array($sql)){
				$tersedia = $r[kapasitas]-$r[terisi];
				echo "<tr>
					<td align='right'>$i.</td>
					<td>$r[nama_penginapan]"; 
					if ($r[flag]==1) {echo " (*)";}
					echo"</td>
					<td>$r[alamat_penginapan]</td>
					<td align='center'>";
					if ($r[flag]==1) {echo "&infin;</td>";}
					else {echo "$r[kapasitas]</td>";}
					
					echo "<td>
						<form name='penginapanedit$i' method='POST' action='index.php?component=sekretariat&act=kelola_penginapan&form=edit_penginapan'>
						<input name='id' type='hidden' value='$r[id_penginapan]'></input></form>
						<form name='penginapandel$i' method='POST' action='component/com_sekretariat/proses.php?act=del_penginapan'>
						<input name='id' type='hidden' value='$r[id_penginapan]'></input></form>
						<a href='javascript:document.penginapanedit$i.submit();'>edit</a> &nbsp;
						<a href='javascript:document.penginapandel$i.submit();'
						onclick=\"javascript:return confirm('$r[nama_penginapan] akan dihapus. Yakin?')\">delete</a>
					</td>
				</tr>";
				$i++;
			}
	echo "</table><br />(*) Penginapan yang dapat di upgrade";
}


	


?>