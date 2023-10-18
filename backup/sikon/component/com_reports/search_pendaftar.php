<script type="text/javascript">
/* Created by: Xaverius Najoan */
var xmlhttp = createRequestObject();

function createRequestObject() {
	var ro;
	var browser = navigator.appName;
	if (browser == "Microsoft Internet Explorer") {
		ro = new ActiceXObject("Microsoft.XMLHTTP");
	} else {
		ro = new XMLHttpRequest();
	}
	return ro;
}

function category(combobox) {
	var key = combobox.value;
	if (!key) return;
	xmlhttp.open('get', 'component/com_reports/getdata.php?form=pendaftar&cat='+key, true);
	xmlhttp.onreadystatechange = function() {
		if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200)) {
			document.getElementById("keyword").innerHTML =
				xmlhttp.responseText;
		}
		return false;
	}

	xmlhttp.send(null);
}
</script>

<?php
include "config/class_paging.php";
include "config/fungsi_indotgl.php";

echo "<div class='contentHeading'>Data Pendaftar - Advanced Search</div>";
echo "<form method=POST action='$_SERVER[PHP_SELF]?component=reports&act=search_pendaftar'>
		<p>
			<label>Pencarian berdasarkan</label>
			<select name='kategori'  id='kategori' onchange='category(this)'>
				<option value=''>- Kategori -</option>
		  		<option value='no_registrasi'>Nomor Registrasi</option>
		  		<option value='nama_lengkap'>Nama Pendaftar</option>
      		</select>
		</p>
		<div id='keyword'></div>
		</form>";

if (isset($_POST[pencarian])) {
	$kategori	= $_POST['kategori'];
	$key		= $_POST['key'];
	
	$sql = mysql_query("SELECT no_registrasi, nama_lengkap, alamat_grj, asal_pd, nama_pdn, reg_date 
							FROM biodata LEFT JOIN pdn_dpa ON asal_pd = id_pdn
							WHERE $kategori LIKE '%$key%' AND status = 'Pendaftar'
							ORDER BY asal_pd, no_registrasi ASC");
							
	echo "<div class='subcontentHeading'><center>Search Result - $key</center></div>";
	
	if (mysql_num_rows($sql) != 0) {
	echo "<table class='report1'>
		<tr><thead>
			<th>No</th>
			<th>No Reg.</th>
			<th>Nama Lengkap</th>
			<th>Wilayah</th>
			<th>Tgl. Daftar</th>
		</tr></thead>";
		$i=$posisi+1;
		while ($r=mysql_fetch_array($sql)){
			$tanggal = tgl_indo($r[reg_date]);
			echo "<tr>
					<td align='right'>$i.</td>
					<td align='center'>#$r[no_registrasi]</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=pendaftar&id=$r[no_registrasi]>$r[nama_lengkap]</a></td>
					<td>$r[nama_pdn]</td>
					<td align='center'>$tanggal</td>
				</tr>";		
			$i++;
		}
	echo "</table>";
	} else {
		echo "<center>Tidak ada data</center>";
	}
} 


?>