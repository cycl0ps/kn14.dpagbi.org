<?php

if ($_GET[act]=='konfirmasi_pembayaran'){
  include "component/com_sekretariat/konfirmasi_pembayaran.php";
}

if ($_GET[act]=='edit_biodata'){
  include "component/com_sekretariat/edit_biodata.php";
}

if ($_GET[act]=='kelola_penginapan'){
  include "component/com_sekretariat/kelola_penginapan.php";
}

if ($_GET[act]=='edit_penginapan'){
  include "component/com_sekretariat/edit_penginapan.php";
}

if ($_GET[act]=='tambah_penginapan'){
  include "component/com_sekretariat/tambah_penginapan.php";
}

if ($_GET[act]=='assign_penginapan'){
  include "component/com_sekretariat/assign_penginapan.php";
}


?>