<?php

if ($notif_cat == 'register') {
	include "notif_regis.php";
}

if ($notif_cat == 'login') {
	include "notif_login.php";
} 

if ($notif_cat == 'com_user') {
	include "notif_user.php";
} 

if ($notif_cat == 'com_sekretariat') {
	include "notif_sekretariat.php";
} 

if ($notif_cat == 'com_admin') {
	include "notif_admin.php";
} 

echo "<a href=javascript:history.back()>[kembali]</a>";
?>