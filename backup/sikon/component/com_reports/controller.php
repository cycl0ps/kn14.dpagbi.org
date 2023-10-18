<?php

if ($_GET[act]=='data_pendaftar'){
  include "component/com_reports/data_pendaftar.php";
}

if ($_GET[act]=='data_peserta'){
  include "component/com_reports/data_peserta.php";
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

if ($_GET[act]=='search_pendaftar'){
  include "component/com_reports/search_pendaftar.php";
}

if ($_GET[act]=='search_peserta'){
  include "component/com_reports/search_peserta.php";
}

if ($_GET[act]=='rekapitulasi'){
  include "component/com_reports/rekapitulasi.php";
}





?>