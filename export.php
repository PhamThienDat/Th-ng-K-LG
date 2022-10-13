<?php
require 'connect/db_connect.php';
if($_SERVER['REQUEST_METHOD']=="POST"){

  $error=array();
  if(empty($_POST['filter_country']) || empty($_POST['filter_gender'])){
    $error['filter_country']="Bạn cần chọn Năm";
    $error['filter_gender']="Bạn cần chọn Tháng";

  }else{
    $Nam= $_POST['filter_country'];
    $Thang = $_POST['filter_gender'];
 // Include SimpleXLSXGen library
 include("SimpleXLSXGen.php");
 
 $TK = [
   ['ID', 'Pricing group', 'Customer code', 'Store code', 'Store name', 'Province', 'Channel type', 'Serial No', 'Division'
   , 'Model','Model Suffix', 'MRP', 'Qty', 'Incentive amount', 'Bill to code', 'Bill to name', 'Sell out date', 'Year', 'Month']
 ];
 
 
 $sql = "SELECT * FROM thongke WHERE Nam like '%".$Nam."%'
 AND Thang like '%".$Thang."%'";
 $res = mysqli_query($mysqli, $sql);
 if (mysqli_num_rows($res) > 0) {
   foreach ($res as $row) {
    
     $TK = array_merge($TK, array(array($row['ID'], $row['Mien'], $row['MaKH'], $row['MaCH'], $row['TenCH'], $row['Vung'], $row['Kieu']
     , $row['Seri'], $row['Loai'], $row['Model'], $row['ModelSu'], $row['GiaTien'], $row['SoLuong'], $row['TienThuong'], $row['BillCode']
     , $row['BillName'], $row['ThoiGian'], $row['Nam'], $row['Thang'])));
   }
 }
 $xlsx = SimpleXLSXGen::fromArray($TK);
 $xlsx->downloadAs('TK".xlsx'); // This will download the file to your local system
 
 echo "<pre>";
 print_r($TK);
  }
}else{
  header('location:error.php');
  exit();
}

