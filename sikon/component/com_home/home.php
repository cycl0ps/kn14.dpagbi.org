<?php
include "config/fungsi_indotgl.php";
include "config/koleksi_fungsi.php";

$nama_user = getNilai(user,name,user_id,$_SESSION[user_id]);

echo "<div class='contentHeading'>Selamat Datang $nama_user</div>";
echo "<table>
		<tr>
			<td valign='top'>
				
				<p>Sistem Informasi Kongres Nasional XIV DPA GBI. Sistem ini digunakan untuk manajemen pendaftaran, konfirmasi pembayaran, akomodasi dan penginapan, pengelolaan acara dan absensi, pengelolaan konsumsi dan distribusi, data dan reporting</p>
				<p><ul>
					<li>Sistem informasi ini hanya dapat diakses oleh user yang memiliki akun aktif pada sistem ini.</li>
					<li>User hanya dapat mengakses menu-menu sistem yang bersesuaian dengan aksel levelnya</li>
					<li>Demi keamanan sistem, diharapkan agar user selalu logout, setelah selesai melakukan aktivitas dalam sistem</li>
					</ul>
				<br /></p>
				<div class='subcontentHeading'><center>Keterangan Nomor Pendaftaran dan Nomor Peserta</center></div>
				<p><img src='images/noregistrasi.jpg'/><br />Tanggal daftar online: 09 April</p>
				<p><img src='images/nopeserta.jpg'/></p>
				<p><span class='emp1'>NO REGISTRASI</span> di generate secara otomatis oleh sistem, setelah melalui proses pendaftaran online.</p>
				<p><span class='emp1'>NO PESERTA</span> di generate secara otomatis oleh sistem, setelah melalui proses konfirmasi pembayaran pada sistem.</p>";
				echo "<div class='subcontentHeading'><center>Kode Gender</center></div>";
				echo "<table class='report3' align=center>
					<thead><tr>
					<th>Gender</th>
					<th>Kode Gender</th>
					</tr></thead>
					<tr>
						<td>Laki-Laki</td><td align='center'>1</td>
					</tr>
					<tr>
						<td>Perempuan</td><td align='center'>2</td>
					</tr>
					</table>
			</td>
			<td valign='top' width='350px'>";
				echo "<p align=right>Login Hari ini: ";
echo tgl_indo(date("Y m d")); 
echo " | "; 
echo date("H:i:s");
echo "</p>";
				echo "<div class='subcontentHeading'><center>Kode KPD/KPLN</center></div>";
				echo "<table class='report3' align=center>
					<thead><tr>
					<th>Nama KPD</th>
					<th>Kode KPD</th>
					</tr></thead>";

				$sql = mysql_query("SELECT id_pdn, nama_pdn FROM pdn_dpa");
				while ($r=mysql_fetch_array($sql)) {
					echo "<tr>
							<td>$r[nama_pdn]</td>
							<td align=center>$r[id_pdn]</td>
					</tr>";	
				}
				echo "</table>
			</td>
		</tr>
</table>";
?>