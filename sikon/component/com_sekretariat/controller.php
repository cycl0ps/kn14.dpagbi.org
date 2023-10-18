<?php

if ($_GET[act]=='registrasi_ulang'){
  include "component/com_sekretariat/registrasi_ulang.php";
}

if ($_GET[act]=='konfirmasi_pembayaran'){
  include "component/com_sekretariat/konfirmasi_pembayaran.php";
}

if ($_GET[act]=='edit_biodata'){
  include "component/com_sekretariat/edit_biodata.php";
}

if ($_GET[act]=='kelola_penginapan'){
  include "component/com_sekretariat/kelola_penginapan.php";
}

if ($_GET[act]=='assign_penginapan'){
  include "component/com_sekretariat/assign_penginapan.php";
}

if ($_GET[act]=='kelola_acara'){
  include "component/com_sekretariat/kelola_acara.php";
}

if ($_GET[act]=='kelola_konsumsi'){
  include "component/com_sekretariat/kelola_konsumsi.php";
}

if ($_GET[act]=='absensi'){
  include "component/com_sekretariat/absensi.php";
}

if ($_GET[act]=='konsumsi'){
  include "component/com_sekretariat/konsumsi.php";
}

if ($_GET[act]=='cetak_bukti_daftar'){
  include "component/com_sekretariat/cetak_bukti_daftar.php";
}


?>