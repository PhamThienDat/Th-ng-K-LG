<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["loai"]);
   
   echo 'You have cleaned session';
   header('Refresh: 2; URL = dangnhap.php');
?>