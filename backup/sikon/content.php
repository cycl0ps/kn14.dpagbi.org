<?php

if ($_GET[component]=='home'){
  include "component/com_home/home.php";
}

else if ($_GET[component]=='user'){
  include "component/com_user/controller.php";
}

else if ($_GET[component]=='sekretariat'){
  include "component/com_sekretariat/controller.php";
}

else if ($_GET[component]=='ppusat'){
  include "component/com_ppusat/controller.php";
}

else if ($_GET[component]=='reports'){
  include "component/com_reports/controller.php";
}

else if ($_GET[component]=='admin'){
  include "component/com_admin/controller.php";
}

else if ($_GET[module]=='detail'){
  include "module/mod_detail/controller.php";
}

else if ($_GET[module]=='search'){
  include "module/mod_search/controller.php";
}

else {
  include "component/com_home/home.php";
}

?>