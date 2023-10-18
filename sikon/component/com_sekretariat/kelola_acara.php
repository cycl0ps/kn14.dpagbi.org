<?php
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

if ($_GET[form] == "tambah_acara") {

	echo "<div class='contentHeading'>Tambah Acara</div>
		<form id='tambah_acara' action='component/com_sekretariat/proses.php?act=tambah_acara' method='post'>
		<p>
			<label class='label2' for='nama'>Nama Acara : &nbsp;</label>
			<input type='text' name='nama_acara' size='30'/>
		</p>
		<p>
			<label class='label2' for='alamat'>Jadwal : &nbsp;</label>";    
			combotgl(26,29,'jadwal_tgl','Tgl');
			combobln2(8,8,'jadwal_bln','8');
			combotgl2(2013,2013,'jadwal_thn','2013');
			
        	echo "&nbsp;&nbsp;Jam : <input name='jadwal_jam' type='text' id='jadwal_jam' size='5' maxlength='5' />
        	WITA 
		<p>
			<span class='label2'>&nbsp;</span>(Contoh format penulisan jam 09:30)
		</p>
		<p>
			<label class='label2' for='deskripsi'>Deskripsi : &nbsp;</label>
			<textarea name='deskripsi' cols='50' rows='4'></textarea>
		</p>
		<p>
			<label class='label2' for='flag'>Additional : &nbsp;</label>
			<input type='checkbox' name='absensi' value='1'> Pakai daftar hadir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='checkbox' name='kredensi' value='1'> Terbatas pemegang kredensi
		</p>
		<p>
			<input type='submit' name='tombol-tambah' value='Tambah' />
		</p>
		</form>";
		
	echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else if ($_GET[form] == "edit_acara") {
	$id   = $_POST[id];

	$sql  = mysql_query("SELECT * FROM activity WHERE id_activity='$id'");
	$r    = mysql_fetch_array($sql);
	$jadwal_jam = getjam($r[start_activity]);

	echo "<div class='contentHeading'>Edit Acara</div>
		<form id='edit_acara' action='component/com_sekretariat/proses.php?act=edit_acara' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label class='label2' for='nama'>Nama Acara : &nbsp;</label>
			<input type='text' name='nama_acara' size='30' value='$r[nama_activity]'/>
		</p>
		<p>
			<label class='label2' for='alamat'>Jadwal : &nbsp;</label>";    
			combotgl2(26,29,'jadwal_tgl',gettgl($r[start_activity]));
			combobln2(8,8,'jadwal_bln',getbln($r[start_activity]));
			combotgl2(2013,2013,'jadwal_thn',getthn($r[start_activity]));
			
    echo "&nbsp;&nbsp;Jam : <input name='jadwal_jam' type='text' id='jadwal_jam' size='5' maxlength='5' value='$jadwal_jam'/>
        	WITA 
		<p>
			<span class='label2'>&nbsp;</span>(Contoh format penulisan jam 09:30)
		</p>
		<p>
			<label class='label2' for='deskripsi'>Deskripsi : &nbsp;</label>
			<textarea name='deskripsi' cols='50' rows='4'>$r[deskripsi_activity]</textarea>
		</p>
		<p>
			<label class='label2' for='flag'>Additional : &nbsp;</label>
			<input type='checkbox' name='absensi' value='1'"; 
			if ($r[flag1]==1) {echo " checked";}
			echo "> Pakai daftar hadir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='checkbox' name='kredensi' value='1'";
			if ($r[flag2]==1) {echo " checked";}
			echo "> Terbatas pemegang kredensi
		</p>
		<p>
			<input type='submit' name='tombol-tambah' value='Update' />
		</p>
		</form>";
		
	echo "<br><a href=javascript:history.back()>[kembali]</a>";
} 

else {
	
	echo "<div class='contentHeading'>Kelola Jadwal Acara</div>";
	echo "<p>
			<a href=$_SERVER[PHP_SELF]?component=sekretariat&act=kelola_acara&form=tambah_acara>Tambah Jadwal Acara</a>
		</p>";

	$sql = mysql_query("SELECT * FROM activity where group_activity = 1 ORDER BY start_activity ASC");
							
	echo "<div class='subcontentHeading'><center>Listing Jadwal Acara</center></div>";
	echo "<table class='report2' align='center'	>
			<tr><thead>
				<th>No</th>
				<th>Nama Acara</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Absensi</th>
				<th></th>
			</tr></thead>";
			$i=1;
			while ($r=mysql_fetch_array($sql)){
				$jadwal_tgl = tgl_indo($r[start_activity]);
				$jadwal_jam = getjam($r[start_activity]);
				echo "<tr>
					<td align='right'>$i.</td>
					<td>$r[nama_activity]";
					if ($r[flag2]==1) {echo " (*)";}
					echo"</td>
					<td>$jadwal_tgl</td>
					<td>$jadwal_jam</td>
					<td align='center'>";
					if ($r[flag1]==1) {echo "&#10003;</td>";}
					
					echo "<td>
						<form name='acaraedit$i' method='POST' action='index.php?component=sekretariat&act=kelola_acara&form=edit_acara'>
						<input name='id' type='hidden' value='$r[id_activity]'></input></form>
						<form name='acaradel$i' method='POST' action='component/com_sekretariat/proses.php?act=del_acara'>
						<input name='id' type='hidden' value='$r[id_activity]'></input></form>
						<a href='javascript:document.acaraedit$i.submit();'>edit</a> &nbsp;
						<a href='javascript:document.acaradel$i.submit();'
						onclick=\"javascript:return confirm('$r[nama_activity] akan dihapus. Yakin?')\">delete</a>
					</td>
				</tr>";
				$i++;
			}
	echo "</table><br />(*) Terbatas pemegang kredensi";
}


	


?>