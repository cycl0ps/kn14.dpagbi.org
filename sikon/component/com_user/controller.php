<?php

if ($_GET[act]=='view'){
  include "component/com_user/user_view.php";
}

if ($_GET[act]=='edit'){
  include "component/com_user/user_edit.php";
}

if ($_GET[act]=='list'){
  include "component/com_user/user_list.php";
}

if ($_GET[act]=='news'){
  include "component/com_user/news.php";
}

?>