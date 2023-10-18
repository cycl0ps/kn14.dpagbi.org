<?php
//Query akses level untuk menu
$sql  = mysql_query("SELECT akses_level FROM user WHERE username='$_SESSION[username]'");
$r    = mysql_fetch_array($sql);

echo "<p class='menuHeading'>Search</p>
		<form class=searchForm method=POST action='?module=search&by=keyword'>    
        <input name=keyword type=text size=20 required />
        <input type=submit value=Search />
      </form>";

echo "<p class='menuHeading'>User</p>
		<ul class='menuList'>
		<li><a href=$_SERVER[PHP_SELF]?component=home>Home</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=user&act=view&id=$_SESSION[username]>ProfilKu</a></li>
		</ul>";
		
if ($r[akses_level] =="Panitia Lokal" OR $r[akses_level]=="Administrator") {
	echo "<p class='menuHeading'>Sekretariat</p>
		<ul class='menuList'>
		<li><a href=$_SERVER[PHP_SELF]?component=sekretariat&act=konfirmasi_pembayaran>Konfirmasi Pembayaran</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=sekretariat&act=assign_penginapan>Assign Penginapan</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=sekretariat&act=edit_biodata>Edit Biodata Peserta</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=sekretariat&act=kelola_penginapan>Kelola Penginapan</a></li>
		</ul>";
}

if ($r[akses_level] =="Pengurus Pusat" OR $r[akses_level]=="Administrator") {
	echo "<p class='menuHeading'>Pengurus Pusat</p>
		<ul class='menuList'>
		<li><a href=$_SERVER[PHP_SELF]?component=ppusat&act=kelola_kpa>Kelola KPA</a></li>
<li><a href=$_SERVER[PHP_SELF]?component=ppusat&act=download_data>Download Data</a></li>		
</ul>";
}

if ($r[akses_level] =="Panitia Lokal" OR $r[akses_level]=="Pengurus Pusat" OR $r[akses_level]=="Administrator") {
	echo "<p class='menuHeading'>Reports</p>
		<ul class='menuList'>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=data_pendaftar>Data Pendaftar</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=data_peserta>Data Peserta</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=data_penginapan>Data Penginapan</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=data_kedatangan>Data Kedatangan</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=data_spheres>Data Sphere</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=reports&act=rekapitulasi>Rekapitulasi</a></li>
		</ul>";
}

if ($r[akses_level]=="Administrator") {
	echo "<p class='menuHeading'>Admin</p>
		<ul class='menuList'>
		<li><a href=$_SERVER[PHP_SELF]?component=admin&act=kelola_user>Kelola User</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=admin&act=ganti_pass>Ganti Password</a></li>
		<li><a href=$_SERVER[PHP_SELF]?component=admin&act=del_pendaftar>Delete Pendaftar</a></li>
		</ul>";
}

echo "<a href=core/login/logout.php>Logout</a>";
?>