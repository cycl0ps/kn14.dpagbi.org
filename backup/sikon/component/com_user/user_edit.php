<?php
$id   = mysql_real_escape_string($_POST[username]);

include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_combobox.php";

if (empty($id)) {
  echo "<b>Request denied!</b>";
  die();
}

$sql  = mysql_query("SELECT * FROM user WHERE username='$id'");
$r    = mysql_fetch_array($sql);

if ($_GET[form]=='editprofile') {
	echo "<div class='contentHeading'>Edit Data Personal</div>
		<form id='edit_profile' action='component/com_user/proses.php?form=editprofile' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label class='label1' for='username'>Username : &nbsp;</label>
			$r[username]
		</p>
		<p>
			<label class='label1' for='nama'>Nama : &nbsp;</label>
			<input type='text' name='nama' id='nama' size='30' value='$r[name]'/>
		</p>
		<p>
			<label class='label1' for='email'>Email : &nbsp;</label>
			<input type='text' name='email' id='email' size='30' value='$r[email]'/>
		</p>
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";
}

elseif ($_GET[form]=='editpassword') {
	echo "<div class='contentHeading'>Ganti Password</div>
		<form id='edit_password' action='component/com_user/proses.php?form=editpassword' method='post'>
		<input name='id' type='hidden' value='$id'>
		<p>
			<label for='password'>Password Lama : &nbsp;</label>
			<input type='password' name='pass_lama' id='password' size='15' />
		</p>
		<p>
			<label for='password'>Password Baru : &nbsp;</label>
			<input type='password' name='pass_baru' id='password' size='15' />
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>";
}
?>