<?php

if ($_GET[act]=='kelola_kpa'){
  include "component/com_ppusat/kelola_kpa.php";
}

if ($_GET[act]=='kredensi'){
  include "component/com_ppusat/kredensi.php";
}

if ($_GET[act]=='download_data'){
  include "component/com_ppusat/download_data.php";
}

?>