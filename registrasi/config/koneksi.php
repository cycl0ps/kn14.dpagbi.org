<?php
$server = "localhost";
$database = "h44572_kn14";
$db_user = "root";
$db_pass = "";

// konek ke server MYSQL
$link = mysql_connect($server, $db_user, $db_pass)
or die ("Could not connect to mysql because ".mysql_error());
// pilih database
mysql_select_db($database)
or die ("Could not select database because ".mysql_error());

?>