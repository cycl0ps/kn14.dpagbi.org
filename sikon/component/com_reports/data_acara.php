<?php
include "config/fungsi_indotgl.php";

echo "<div class='contentHeading'>Data Jadwal Acara</div>";



$query	= "SELECT * FROM activity where group_activity = 1 ORDER BY start_activity ASC";
							
$sql 	= mysql_query($query);
							
	echo "<div class='subcontentHeading'><center>Jadwal Acara</center></div>";

	echo "<table class='report1' align='center'	>
			<tr><thead>
				<th>No</th>
				<th>Nama Acara</th>
				<th>Tanggal</th>
				<th>Jam</th>
				<th>Absensi</th>
			</tr></thead>";
			$i=1;
			while ($r=mysql_fetch_array($sql)){
				$jadwal_tgl = tgl_indo($r[start_activity]);
				$jadwal_jam = getjam($r[start_activity]);
				echo "<tr>
					<td align='right'>$i.</td>
					<td><a href=$_SERVER[PHP_SELF]?module=detail&act=acara&id=$r[id_activity]>$r[nama_activity]</a>";
					if ($r[flag2]==1) {echo " (*)";}
					echo"</td>
					<td>$jadwal_tgl</td>
					<td>$jadwal_jam</td>
					<td align='center'>";
					if ($r[flag1]==1) {echo "&#10003;</td>";}
					
					echo "
				</tr>";
				$i++;
			}
	echo "</table><br />(*) Terbatas pemegang kredensi";
	


?>