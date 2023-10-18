<?php 
include "core/session/session.php"; 
include "config/koneksi.php";

$theme = mysql_query("SELECT path_theme FROM themes WHERE status_theme = 'active'");
$t = mysql_fetch_array($theme);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Sistem Informasi KN XIV DPA-GBI</title>
		<link href="<?php echo "$t[path_theme]" ?>/css/style.css" rel="stylesheet" type="text/css">
		<link href="<?php echo "$t[path_theme]" ?>/knicon.ico" rel="shortcut icon" type="image/x-icon">
		<script type='text/javascript' src="<?php echo "$t[path_theme]" ?>/js/ajax.js"></script>
		<script type='text/javascript' src="<?php echo "$t[path_theme]" ?>/js/common.js"></script>
	</head>
	<body>
		<div id="header"></div>
		<div id="menu"><?php include "menu.php"; ?></div>
		<div id="content"><?php include "content.php"; ?></div>
		<div id="footer"><?php include "footer.php"; ?></div>
	</body>
</html>