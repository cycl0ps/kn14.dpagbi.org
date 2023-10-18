<?php
include "config/library.php";

echo "<div class='contentHeading'>Profil User</div>";

//query data member
$id		= $_GET[id];
$sql  	= mysql_query("SELECT * FROM user WHERE user_id='$id'");
$r    	= mysql_fetch_array($sql);

echo "<div id='contentPage'>
	<h2><label class='label1' for='nama'>Nama</label>: $r[name]</h2>
	<p><label class='label1' for='username'>Username &nbsp;</label>: $r[username]</p>
	<p><label class='label1' for='email'>Email &nbsp;</label>: $r[email]</p>
	<p><label class='label1' for='akseslevel'>Level Akses &nbsp;</label>: $r[akses_level]</p>
	<p><label class='label1' for='status'>Status &nbsp;</label>: $r[active]</p>";
echo "<br />";

//Cek akses level untuk menampilkan link edit
if ($_SESSION[user_id] == $id) {
	echo "
		<form name='datapersonal' method='POST' action='index.php?component=user&act=edit&form=editprofile'>
			<input name='userid' type='hidden' value='$id'></input></form>
		<form name='passwordlogin' method='POST' action='index.php?component=user&act=edit&form=editpassword'>
			<input name='userid' type='hidden' value='$id'></input></form>
                
		<p><a href='javascript:document.datapersonal.submit();'>Edit Data Personal</a></p>
		<p><a href='javascript:document.passwordlogin.submit();'>Ganti Password</a></p>";
}
	
echo "</div><br><a href=javascript:history.back()>[kembali]</a>";
	  
?>