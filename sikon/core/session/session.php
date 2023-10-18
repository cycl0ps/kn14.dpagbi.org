<?php
session_start();
if (empty($_SESSION[user_id]) AND session_id() != $_SESSION[session_id]){
  header('location:core/login/');
}
?>