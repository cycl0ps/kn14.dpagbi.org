<?php
$id   = $_POST[userid];

$sql  = mysql_query("SELECT * FROM user WHERE user_id='$id'");
$r    = mysql_fetch_array($sql);

echo "<div class='contentHeading'>Edit User</div>
		<form id='edit_user' action='component/com_admin/proses.php?form=edituser' method='post'>
		<input name='userid' type='hidden' value='$id'>
		<p>
			<label class='label1' for='username'>Username : &nbsp;</label>$r[username]
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
			<label class='label1' for='akses_level'>Akses Level : &nbsp;</label>
			<select name=akses_level>";
			$sql=mysql_query("SELECT * FROM roles ORDER BY id_roles ASC");
			while ($d=mysql_fetch_array($sql)) {
				echo "<option value='$d[role]'";
				if ($r[akses_level] == $d[role]) echo " selected";
				echo ">$d[role]</option>";
				}
				echo "</select>
		</p>
		<p>
			<label class='label1' for='status'>Status : &nbsp;</label>
			<input type='radio' value='active' name='active' ";
				if ($r[active]=='active') {
					echo "checked";}echo "/>Active 
			<input type='radio' value='not active' name='active' ";
				if ($r[active]=='not active') {
					echo "checked";}echo "/>Not Active 
		</p>
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p>
		</form>";

			
echo "<br><a href=javascript:history.back()>[kembali]</a>";


?>