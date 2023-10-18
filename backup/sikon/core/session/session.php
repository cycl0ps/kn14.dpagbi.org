<?php
session_start();
if (empty($_SESSION[passta]) AND session_id() != $_SESSION[sessionid]){
  header('location:core/login/');
}
?>