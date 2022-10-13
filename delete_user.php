<?php
session_start(); 
include_once('config.php');
if(isset($_REQUEST['delId']) and $_REQUEST['delId']!=""){
	$db->delete('member',array('ID'=>$_REQUEST['delId']));
	header('location: browse-users.php?msg=rds');
	exit;
}
?>
<?php 
       if (!isset($_SESSION['username']) || $_SESSION['loai']==0) {
        header('Location: dangnhap.php');
   }
       ?>