<?php
include "config/library.php";

echo "<div class='contentHeading'>User List</div>";

//query list user
$sql  	= mysql_query("SELECT * FROM user WHERE user_id != 1 ORDER BY name ASC");

echo "<div id='contentPage'>
	<p>Berikut adalah list nama-nama user:</p>
	<ol>";

while ($r=mysql_fetch_array($sql)){
	echo "<li><a href=$_SERVER[PHP_SELF]?component=user&act=view&id=$r[user_id]>$r[name]</a></li>";
}
	
echo "</div><br><a href=javascript:history.back()>[kembali]</a>";
	  
?>