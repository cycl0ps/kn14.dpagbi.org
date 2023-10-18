<?php

if ($_GET[act]=='data_pendaftar'){
  include "component/com_reports/data_pendaftar.php";
}

if ($_GET[act]=='data_peserta'){
  include "component/com_reports/data_peserta.php";
}

if ($_GET[act]=='data_pembayaran'){
  include "component/com_reports/data_pembayaran.php";
}

if ($_GET[act]=='data_penginapan'){
  include "component/com_reports/data_penginapan.php";
}

if ($_GET[act]=='data_kedatangan'){
  include "component/com_reports/data_kedatangan.php";
}

if ($_GET[act]=='data_spheres'){
  include "component/com_reports/data_spheres.php";
}

if ($_GET[act]=='data_komisi'){
  include "component/com_reports/data_komisi.php";
}

if ($_GET[act]=='data_kpa'){
  include "component/com_reports/data_kpa.php";
}

if ($_GET[act]=='data_kredensi'){
  include "component/com_reports/data_kredensi.php";
}

if ($_GET[act]=='data_acara'){
  include "component/com_reports/data_acara.php";
}

if ($_GET[act]=='data_absensi'){
  include "component/com_reports/data_absensi.php";
}

if ($_GET[act]=='rekapitulasi'){
  include "component/com_reports/rekapitulasi.php";
}


?>