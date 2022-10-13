<?php
   $mysqli = mysqli_connect('localhost','root','','lg');
   $mysqli->set_charset('utf8');
    if(mysqli_connect_error()){
    echo ' connect failed: '.mysqli_connect_error();
    exit;
}


?>