<?php

$data = $_GET[data];

echo "<div class='contentHeading'>Rekapitulasi</div>";
echo "
	<ul>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi&data=dpwil>Jumlah Pendaftaran per PD/PLN</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi&data=dpprov>Jumlah Pendaftaran per Propinsi</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi&data=arrtgl>Jumlah Kedatangan per Tanggal</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi&data=sphere>Jumlah Pilihan Spheres</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi&data=penginapan>Jumlah Lokasi Penginapan</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi&data=housing>Jumlah Peserta per Lokasi Penginapan</a></li>
	</ul>";

if ($data == dpwil) {
	$sql	= mysql_query("SELECT * FROM pdn_dpa");
	echo "<div class='subcontentHeading'><center>Rekapitulasi Jumlah Pendaftaran per Wilayah</center></div>";
	echo "<table class='report2' align=center>
			<thead><tr>
				<th>No.</th>
				<th>Asal PD/PLN</th>
				<th>Pria</th>
				<th>Wanita</th>
				<th>Jumlah</th>
			</tr></thead>";
	
	$sql		= mysql_query("SELECT * FROM pdn_dpa");
	$lak_tot	= 0;
	$wan_tot	= 0;
	$total		= 0;

	$i=1;
	while ($r=mysql_fetch_array($sql)) {
		$lak_pw 	= 0;
		$wan_pw		= 0;
		$tot_pw 	= 0;
		
		$sql2	= mysql_query("SELECT jenis_kelamin FROM biodata WHERE asal_pd='$r[id_pdn]'");
		$j=1;
		while ($s=mysql_fetch_array($sql2)) { 
			if ($s[jenis_kelamin] == 'Laki-Laki') {
				$lak_pw++;
			} else {
				$wan_pw++;
			}
		}
		$tot_pw = $lak_pw + $wan_pw;
			
		echo "<tr>
			<td align=right>$i.</td>
			<td>$r[nama_pdn]</td>
			<td align=center>$lak_pw</td>
			<td align=center>$wan_pw</td>
			<td align=center>$tot_pw</td>
		</tr>";	
		
		$lak_tot	+= $lak_pw;
		$wan_tot	+= $wan_pw;
		$total 		+= $tot_pw;
		
		$i++;
	}

	echo "<tr>
			<td colspan=2 align=center>TOTAL</td>
			<td align=center>$lak_tot</td>
			<td align=center>$wan_tot</td>
			<td align=center>$total</td>
		</tr></table>";
}

if ($data == dpprov) {
	echo "<div class='subcontentHeading'><center>Rekapitulasi Jumlah Pendaftaran per Propinsi</center></div>";
	echo "<table class='report2' align=center>
			<thead></tr>
				<th>No.</th>
				<th>Propinsi</th>
				<th>Pria</th>
				<th>Wanita</th>
				<th>Jumlah</th>
			</tr></thead>";
	
	$sql		= mysql_query("SELECT * FROM db_prop");
	$lak_tot	= 0;
	$wan_tot	= 0;
	$total		= 0;

	$i=1;
	while ($r=mysql_fetch_array($sql)) {
		$lak_pw 	= 0;
		$wan_pw		= 0;
		$tot_pw 	= 0;
		
		$sql2	= mysql_query("SELECT jenis_kelamin FROM biodata WHERE propinsi='$r[id_propinsi]'");
		$j=1;
		while ($s=mysql_fetch_array($sql2)) { 
			if ($s[jenis_kelamin] == 'Laki-Laki') {
				$lak_pw++;
			} else {
				$wan_pw++;
			}
		}
		$tot_pw = $lak_pw + $wan_pw;
			
		echo "<tr>
			<td align=right>$i.</td>
			<td>$r[nama_propinsi]</td>
			<td align=center>$lak_pw</td>
			<td align=center>$wan_pw</td>
			<td align=center>$tot_pw</td>
		</tr>";	
		
		$lak_tot	+= $lak_pw;
		$wan_tot	+= $wan_pw;
		$total 		+= $tot_pw;
		
		$i++;
	}
	
	$sql3	= mysql_query("SELECT jenis_kelamin FROM biodata WHERE propinsi = 0");
	$lak_pw 	= 0;
	$wan_pw		= 0;
	$tot_pw 	= 0;
	
	while ($t=mysql_fetch_array($sql3)) {
		if ($t[jenis_kelamin] == 'Laki-Laki') {
				$lak_pw++;
			} else {
				$wan_pw++;
			}
	}
	$tot_pw = $lak_pw + $wan_pw;
	
	echo "<tr>
			<td align=right>$i.</td>
			<td>LUAR NEGERI</td>
			<td align=center>$lak_pw</td>
			<td align=center>$wan_pw</td>
			<td align=center>$tot_pw</td>
		</tr>";	
		
	$lak_tot	+= $lak_pw;
	$wan_tot	+= $wan_pw;
	$total 		+= $tot_pw;

	echo "<tr>
			<td colspan=2 align=center>TOTAL</td>
			<td align=center>$lak_tot</td>
			<td align=center>$wan_tot</td>
			<td align=center>$total</td>
		</tr></table>";
}

if ($data == arrtgl) {
	echo "<div class='subcontentHeading'><center>Rekapitulasi Jumlah Kedatangan per Tanggal</center></div>";
	echo "<table class='report2' align=center>
			<thead>
				<tr>
					<th rowspan=2>No.</th>
					<th rowspan=2>Tanggal Kedatangan</th>
					<th colspan=5>Transportasi</th>
					<th rowspan=2>Jumlah</th>
				</tr>
				<tr>
					<th>Kapal</th>
				<th>Pesawat</th>
				<th>Bis</th>
				<th>Mobil Pribadi</th>
				<th>Belum Tahu</th>
			</tr></thead>";
	
	$kap_tot	= 0;
	$pst_tot	= 0;
	$bis_tot	= 0;
	$pri_tot	= 0;
	$nan_tot	= 0;
	$total		= 0;

	$kode_tgl=1;
	for ($kode_tgl;$kode_tgl<=9;$kode_tgl++) {
		$kap_tgl	= 0;
		$pst_tgl	= 0;
		$bis_tgl	= 0;
		$pri_tgl	= 0;
		$nan_tgl	= 0;
		$tot_tgl	= 0;
	
		switch($kode_tgl) {
			case 1: $ekspresi_query = "arrive_date BETWEEN 1 AND '2013-08-21'"; $s = "Sebelum 22 Agustus 2013"; break;
			case 2: $ekspresi_query = "arrive_date = '2013-08-22'"; $s = "22 Agustus 2013"; break;
			case 3: $ekspresi_query = "arrive_date = '2013-08-23'"; $s = "23 Agustus 2013"; break;
			case 4: $ekspresi_query = "arrive_date = '2013-08-24'"; $s = "24 Agustus 2013"; break;
			case 5: $ekspresi_query = "arrive_date = '2013-08-25'"; $s = "25 Agustus 2013"; break;
			case 6: $ekspresi_query = "arrive_date = '2013-08-26'"; $s = "26 Agustus 2013"; break;
			case 7: $ekspresi_query = "arrive_date = '2013-08-27'"; $s = "27 Agustus 2013"; break;
			case 8: $ekspresi_query = "arrive_date > '2013-08-27'"; $s = "Setelah 27 Agustus 2013"; break;
			case 9: $ekspresi_query = "arrive_date = '0000-00-00'"; $s = "Belum diketahui"; break;
		}
		
		$sql 	= mysql_query("SELECT arrive_by FROM biodata WHERE $ekspresi_query");
		
		while ($r=mysql_fetch_array($sql)) {
			switch ($r[arrive_by]) {
				case "Kapal Laut": $kap_tgl++; break;
				case "Pesawat Udara": $pst_tgl++; break;
				case "Bis": $bis_tgl++; break;
				case "Kendaraan Pribadi": $pri_tgl++; break;
				default: $nan_tgl++;break;
			}
		}
		
		$tot_tgl = $kap_tgl + $pst_tgl + $bis_tgl + $pri_tgl + $nan_tgl;
		
		echo "<tr>
			<td align=right>$kode_tgl.</td>
			<td>$s</td>
			<td align=center>$kap_tgl</td>
			<td align=center>$pst_tgl</td>
			<td align=center>$bis_tgl</td>
			<td align=center>$pri_tgl</td>
			<td align=center>$nan_tgl</td>
			<td align=center>$tot_tgl</td>
		</tr>";	
		
		$kap_tot	+= $kap_tgl;
		$pst_tot	+= $pst_tgl;
		$bis_tot	+= $bis_tgl;
		$pri_tot	+= $pri_tgl;
		$nan_tot	+= $nan_tgl;
		$total		+= $tot_tgl;
	}
	
	echo "<tr>
			<td colspan=2 align=center>TOTAL</td>
			<td align=center>$kap_tot</td>
			<td align=center>$pst_tot</td>
			<td align=center>$bis_tot</td>
			<td align=center>$pri_tot</td>
			<td align=center>$nan_tot</td>
			<td align=center>$total</td>
		</tr></table>";
}

if ($data == sphere) {
	$sql	= mysql_query("SELECT * FROM sphere");
	echo "<div class='subcontentHeading'><center>Rekapitulasi Pilihan Sphere</center></div>";
	echo "<table class='report2' align=center>
			<thead><tr>
				<th>No.</th>
				<th>Sphere</th>
				<th>Jumlah</th>
			</tr></thead>";
	
	$total		= 0;

	$i=1;
	while ($r=mysql_fetch_array($sql)) {
		
		$sql2		= mysql_query("SELECT jenis_kelamin FROM biodata WHERE sphere='$r[id_sphere]'");
		$sphere_tot	= mysql_num_rows($sql2);
			
		echo "<tr>
			<td align=right>$i.</td>
			<td>$r[nama_sphere]</td>
			<td align=center>$sphere_tot</td>
		</tr>";	
		
		$total	+= $sphere_tot;	
		$i++;
	}

	echo "<tr>
			<td colspan=2 align=center>TOTAL</td>
			<td align=center>$total</td>
		</tr></table>";
}

if ($data == penginapan) {
$sql = mysql_query("SELECT * FROM penginapan
							WHERE id_penginapan != 1");
							
echo "<div class='subcontentHeading'><center>Jumlah Lokasi Penginapan</center></div>";
echo "<table class='report2' align='center'>
		<tr><thead>
			<th>No</th>
			<th>Nama Penginapan</th>
			<th>Alamat</th>
			<th>Kapasitas</th>
			<th>Terisi</th>
		</tr></thead>";
		$i=1;
		while ($r=mysql_fetch_array($sql)){
			echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=penginapan&id=$r[id_penginapan]>$r[nama_penginapan]</a>";
					if ($r[flag]==1) {echo " (*)";}
					echo"</td>
					<td>$r[alamat_penginapan]</td>
					<td align='center'>";
					if ($r[flag]==1) {echo "&infin;</td>";}
					else {echo "$r[kapasitas]</td>";}
				
					echo "<td align='center'>$r[terisi]</td>
				</tr>";
		$i++;
		}
echo "</table><br />(*) Penginapan yang dapat di upgrade";
}

if ($data == housing) {
	echo "<div class='subcontentHeading'><center>Rekapitulasi Jumlah Peserta per Lokasi Penginapan</center></div>";
	echo "<table class='report2' align=center>
			<thead><tr>
				<th rowspan=2>No.</th>
				<th rowspan=2>Nama Penginapan</th>
				<th rowspan=2>Kapasitas</th>
				<th colspan=3>Terisi</th>
				</tr>
				<tr>
					<th>Pria</th>
					<th>Wanita</th>
					<th>Total</th>
			</tr></thead>";
	
	$sql		= mysql_query("SELECT * FROM penginapan");
	$lak_tot	= 0;
	$wan_tot	= 0;
	$total		= 0;

	$i=1;
	while ($r=mysql_fetch_array($sql)) {
		$lak_ph 	= 0;
		$wan_ph		= 0;
		$tot_ph 	= 0;
		
		$sql2	= mysql_query("SELECT jenis_kelamin FROM biodata WHERE lokasi_penginapan='$r[id_penginapan]'");
		$j=1;
		while ($s=mysql_fetch_array($sql2)) { 
			if ($s[jenis_kelamin] == 'Laki-Laki') {
				$lak_ph++;
			} else {
				$wan_ph++;
			}
		}
		$tot_ph = $lak_ph + $wan_ph;
			
		echo "<tr>
			<td align=right>$i.</td>
			<td>$r[nama_penginapan]</td>";
			if ($r[flag]==1) {echo "<td align=center>&infin;</td>";}
			else {echo "<td align=center>$r[kapasitas]</td>";}
			echo "
			<td align=center>$lak_ph</td>
			<td align=center>$wan_ph</td>
			<td align=center>$tot_ph</td>
		</tr>";	
		
		$lak_tot	+= $lak_ph;
		$wan_tot	+= $wan_ph;
		$total 		+= $tot_ph;
		
		$i++;
	}
	
	$sql3	= mysql_query("SELECT jenis_kelamin FROM biodata WHERE lokasi_penginapan = 0");
	$lak_ph 	= 0;
	$wan_ph		= 0;
	$tot_ph 	= 0;
	
	while ($t=mysql_fetch_array($sql3)) {
		if ($t[jenis_kelamin] == 'Laki-Laki') {
				$lak_ph++;
			} else {
				$wan_ph++;
			}
	}
	$tot_ph = $lak_ph + $wan_ph;
	
	echo "<tr>
			<td align=right>$i.</td>
			<td colspan=2>Belum Ada Penginapan</td>
			<td align=center>$lak_ph</td>
			<td align=center>$wan_ph</td>
			<td align=center>$tot_ph</td>
		</tr>";	
		
	$lak_tot	+= $lak_ph;
	$wan_tot	+= $wan_ph;
	$total 		+= $tot_ph;

	echo "<tr>
			<td colspan=3 align=center>TOTAL</td>
			<td align=center>$lak_tot</td>
			<td align=center>$wan_tot</td>
			<td align=center>$total</td>
		</tr></table>";
}

?>