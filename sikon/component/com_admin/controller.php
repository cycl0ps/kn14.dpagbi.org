<?php

if ($r[akses_level]!="Administrator") {
  echo "<b>Request denied!</b>";
  die();
}

if ($_GET[act]=='kelola_user'){
  include "component/com_admin/kelola_user.php";
}

if ($_GET[act]=='edit_user'){
  include "component/com_admin/edit_user.php";
}

if ($_GET[act]=='ganti_pass'){
  include "component/com_admin/ganti_pass.php";
}

if ($_GET[act]=='del_pendaftar'){
  include "component/com_admin/del_pendaftar.php";
}





?>