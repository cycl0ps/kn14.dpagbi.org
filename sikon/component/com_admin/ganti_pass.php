<?php
$id   = $_POST[userid];

echo "<div class='contentHeading'>Ganti Password</div>
		<form id='ganti_password' action='component/com_admin/proses.php?form=gantipass' method='post'>
		<p>
			<label for='username'>Username : &nbsp;</label>
			<input type='text' name='username' id='username' size='15' />
		</p>
		<p>
			<label for='password'>Password Baru : &nbsp;</label>
			<input type='password' name='pass_baru' id='password' size='15' />
		<p>
			<input type='submit' name='tombol-update' value='Update' />
		</p></form>";

			
echo "<br><a href=javascript:history.back()>[kembali]</a>";


?>