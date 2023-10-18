<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Login - Sistem Informasi KN XIV DPA-GBI</title>
		<link href="../../images/style.css" rel="stylesheet" type="text/css">
		<link href="../../images/knicon.ico" rel="shortcut icon" type="image/x-icon">
	</head>
	<body>
		<div id="header"></div>
		<div id="loginBox">
			<form method='post' action='proses2.php' >
				<p>Password akan dikirimkan ke alamat email anda!</p>
				<p>
					<label class= 'label2' for='email'>Email : &nbsp;</label>
					<input type='text' name='email' id='email' size='30' />
				</p>
				<p>
					<input type='submit' name='tombol-forget' value='Kirim' />
				</p>
			</form>
		</div>
        <div id="footer"><?php include "../../footer.php"; ?></div>
	</body>
</html>
