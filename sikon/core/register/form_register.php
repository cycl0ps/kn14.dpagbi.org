<div class='contentHeading'>Daftar User pada SIKON KN XIV DPA</div>

<form id="register_member" action="proses.php" method="post">
	<p>
		<label class='label1' for='username'>Username* : &nbsp;</label>
		<input type='text' name='username' id='username' size='15' required/>&nbsp;
		* Username tidak boleh lebih dari 1 kata
	</p>
	<p>
		<label class='label1' for='nama'>Full Name : &nbsp;</label>
		<input type='text' name='nama' id='nama' size='30' required/>
	</p>
	<p>
		<label class='label1' for='email'>Email : &nbsp;</label>
		<input type='text' name='email' id='email' size='25' required/>
	</p>
	<p>
		<label class='label1' for='password'>Password : &nbsp;</label>
		<input type='password' name='password' id='password' size='15' required/>
	</p>
	<p>
		<input type='submit' name='tombol-register' value='Submit' />&nbsp; &nbsp;
		<input type='reset' name='tombol-reset' value='Reset' />
	</p>
</form>

