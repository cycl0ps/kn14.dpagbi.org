<?php

$key    = $_POST[keyword];

if (empty($key)){
	echo "Kata kunci pencarian: Tidak ada!<br><br>";
} else {
										  
	$sql 	= mysql_query("SELECT * FROM biodata 
								LEFT JOIN db_kabkota ON kab_kota = id_kabkota
								LEFT JOIN db_prop ON biodata.propinsi = db_prop.id_propinsi
								LEFT JOIN db_negara ON negara = id_negara
								LEFT JOIN pdn_dpa ON asal_pd = id_pdn
								WHERE (no_registrasi = '$key' OR
                                          no_peserta = '$key' OR
										  nama_lengkap LIKE '%$key%' OR
                                          nama_kabkota LIKE '%$key%' OR
										  nama_propinsi LIKE '%$key%' OR
										  nama_pdn LIKE '%$key%' OR
										  nama_negara LIKE '%$key%')");	
	$jumlah = mysql_num_rows($sql);

	echo "<div class='contentHeading'>Search Result</div>";


	if ($jumlah > 0) {
		echo "<p>Ditemukan <span class='emp1'>$jumlah</span> data dengan kata kunci: <span class='emp1'>$key</span><p>";
		$i=1;
		echo "<table>";
		while ($r=mysql_fetch_array($sql)){
			echo "<tr>
					<td valign='top'>$i.</td>
					<td valign='top'><a href=$_SERVER[PHP_SELF]?module=detail&act=biodata&id=$r[no_registrasi]>$r[nama_lengkap]</a></td>
					<td>
						<label class='label1'>No Registrasi</label>: #$r[no_registrasi] &nbsp;<br />
						<label class='label1'>No Peserta</label>: $r[no_peserta] &nbsp;<br />
						<label class='label1'>Kategori</label>: $r[status] &nbsp;<br />
						<label class='label1'>Alamat</label>: $r[nama_kabkota] - $r[nama_propinsi] - $r[nama_negara]
					</td>
				</tr>";
			
			$i++;
		}
		echo "</table>";
	} else {

	}
}
?>