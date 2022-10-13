<?php
require  '../connect/db_connect.php';
$TuyChon = "SELECT DISTINCT Nam FROM thongke ORDER BY Nam DESC";
$KQTuyChon = mysqli_query($mysqli,$TuyChon);
if(mysqli_num_rows($KQTuyChon)>0){
    $SoNamTK = mysqli_fetch_array($KQTuyChon);
}else{
         echo'Đã xảy ra lỗi, mời chọn lại';
         exit();
}
$a=0;
$n=0;
$dataTK = [];  $datatwoTK = [];  $dataMDwmtk = [];  $dataMDreftk = []; $dataTKslwm = []; $dataTKslref = []; $dataTKgtwm = []; $dataTKgtref = [];
$dataMDVwm = []; $dataMDVref = [];

if(isset($_POST['submit'])){
    $NamTK= $_POST['NamTK'];
    $ThangTK = $_POST['ThangTK'];
    // Truy vấn lấy dữ liệu
    $sqlloaimot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%'";

    $sqlloaihai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%'";

    $sqlGTWM = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%'";

    $sqlGTREF = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%'";

    $sqlModelmot = "SELECT Nam,Thang,Model,COUNT(*) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' GROUP BY Model";

    $sqlModelhai = "SELECT Nam,Thang,Model,COUNT(*) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' GROUP BY Model";

//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

    $KQGTWM = mysqli_query($mysqli,$sqlGTWM);
    $dataGTWM = mysqli_fetch_array($KQGTWM);
     $NamGTwm = $dataGTWM['Nam'];
     $ThangGTwm = $dataGTWM['Thang'];
     $GiaTien= $dataGTWM['SUM(GiaTien)'];
//KT trùng   
    $thucthiGT = mysqli_query($mysqli,"SELECT * FROM giatienwm WHERE NamGTwm like '%".$NamGTwm."%'
    AND ThangGTwm like '%".$ThangGTwm."%' AND GiaTienwm like '%".$GiaTien."%'");

    if(!$thucthiGT || mysqli_num_rows($thucthiGT)>0){
      echo '';
    }else{

    
     $ThongKeGTMot ="INSERT INTO giatienwm(NamGTwm,ThangGTwm,GiaTienwm) VALUES($NamGTwm,'$ThangGTwm',$GiaTien)";
      mysqli_query($mysqli,$ThongKeGTMot);
     
    
    }

//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)             

    $KQGTREF = mysqli_query($mysqli,$sqlGTREF);
    $dataGTREF = mysqli_fetch_array($KQGTREF);
     $NamGTref = $dataGTREF['Nam'];
     $ThangGTref = $dataGTREF['Thang'];
     $GiaTienref= $dataGTREF['SUM(GiaTien)'];
//KT trùng

    $thucthiGTref = mysqli_query($mysqli,"SELECT * FROM giatienref WHERE NamGTref like '%".$NamGTref."%'
    AND ThangGTref like '%".$ThangGTref."%' AND GiaTienref like '%".$GiaTienref."%'");

    if(!$thucthiGTref || mysqli_num_rows($thucthiGTref)>0){
      echo'';
    }else{
      $ThongKeGTHai ="INSERT INTO giatienref(NamGTref,ThangGTref,GiaTienref) VALUES($NamGTref,'$ThangGTref',$GiaTienref)";
      mysqli_query($mysqli,$ThongKeGTHai);
     
    }
    
//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

    $KQLoaimot = mysqli_query($mysqli,$sqlloaimot);
    $dataLoaimot = mysqli_fetch_array($KQLoaimot);
    $Namslwm = $dataLoaimot['Nam'];
    $Thangslwm = $dataLoaimot['Thang'];
    $SoLuongslwm= $dataLoaimot['SUM(SoLuong)'];

//KT trùng

    $thucthiSLwm = mysqli_query($mysqli,"SELECT * FROM soluongwm WHERE Namslwm like '%".$Namslwm."%'
    AND Thangslwm like '%".$Thangslwm."%' AND SoLuongwm like '%".$SoLuongslwm."%'");

    if(!$thucthiSLwm || mysqli_num_rows($thucthiSLwm)>0){
     echo '';
    }else{
      $ThongKeSLMot ="INSERT INTO soluongwm(Namslwm,Thangslwm,SoLuongwm) VALUES($Namslwm,'$Thangslwm',$SoLuongslwm)";
      mysqli_query($mysqli,$ThongKeSLMot);
      
    }

//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

    $KQLoaihai = mysqli_query($mysqli,$sqlloaihai);
    $dataLoaihai = mysqli_fetch_array($KQLoaihai);
    $Namref = $dataLoaihai['Nam'];
    $Thangref = $dataLoaihai['Thang'];
    $SoLuongref= $dataLoaihai['SUM(SoLuong)'];

//KT trùng

    $thucthiSLref = mysqli_query($mysqli,"SELECT * FROM soluongref WHERE Namref like '%".$Namref."%'
    AND Thangref like '%".$Thangref."%' AND SoLuongref like '%".$SoLuongref."%'");
    if(!$thucthiSLref || mysqli_num_rows($thucthiSLref)>0){
      echo '';
    }else{
      $ThongKeSLHai ="INSERT INTO soluongref(Namref,Thangref,SoLuongref) VALUES($Namref,'$Thangref',$SoLuongref)";
      mysqli_query($mysqli,$ThongKeSLHai);
     
    }

//Lấy mảng dữ liệu từ câu truy vấn(Vì trả về 1 mảng nhiều model)
    
    $KQModelmot = mysqli_query($mysqli,$sqlModelmot);
    while($dataModelmot = mysqli_fetch_array($KQModelmot)){
         $SaveNamwm = $dataModelmot['Nam'];
         $SaveThangwm = $dataModelmot['Thang'];
         $SaveMDwm = $dataModelmot['Model'];
         $SaveMDMCwm = $dataModelmot['COUNT(*)'];

//KT trùng

         $thucthiMDwm = mysqli_query($mysqli,"SELECT * FROM modelwm WHERE NamMD like '%".$SaveNamwm."%'
        AND ThangMD like '%".$SaveThangwm."%' AND ModelMD like '%".$SaveMDwm."%'
        AND SoLuongMD like '%".$SaveMDMCwm."%'");
       
        if(!$thucthiMDwm || mysqli_num_rows($thucthiMDwm)>0){
          echo '';
        }else{

        $ThongKeMDMot ="INSERT INTO modelwm(NamMD,ThangMD,ModelMD,SoLuongMD) VALUES($SaveNamwm,'$SaveThangwm','$SaveMDwm',$SaveMDMCwm)";
        mysqli_query($mysqli,$ThongKeMDMot);
         
        }
        
    }

//Lấy mảng dữ liệu từ câu truy vấn(Vì trả về 1 mảng nhiều model)
    $KQModelhai = mysqli_query($mysqli,$sqlModelhai);
    while($dataModelhai = mysqli_fetch_array($KQModelhai)){
        $SaveNamref = $dataModelhai['Nam'];
        $SaveThangref = $dataModelhai['Thang'];
        $SaveMDref = $dataModelhai['Model'];
        $SaveMDMCref = $dataModelhai['COUNT(*)'];
        //KT trùng
        $thucthiMDref = mysqli_query($mysqli,"SELECT * FROM modelref WHERE NamMDref like '%".$SaveNamref."%'
        AND ThangMDref like '%".$SaveThangref."%' AND ModelMDref like '%".$SaveMDref."%'
        AND SoLuongMDref like '%".$SaveMDMCref."%'");
       
        if(!$thucthiMDref || mysqli_num_rows($thucthiMDref)>0){
          echo '';
        }else{
          $ThongKeMDHai ="INSERT INTO modelref(NamMDref,ThangMDref,ModelMDref,SoLuongMDref)
           VALUES($SaveNamref,'$SaveThangref','$SaveMDref',$SaveMDMCref)";
          mysqli_query($mysqli,$ThongKeMDHai);
          echo'';
        }
        }
      if(!empty($_POST['NamTK']) && empty($_POST['ThangTK'])){
          $n++;
         // Tính cả năm
         $mysqlSLwmMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan'";
         $RSSslwmMot = mysqli_query($mysqli,$mysqlSLwmMot);
         $dulieuslWMMot = mysqli_fetch_array($RSSslwmMot);
         
         $mysqlSLwmHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb'";
         $RSSslwmHai = mysqli_query($mysqli,$mysqlSLwmHai);
         $dulieuslWMHai = mysqli_fetch_array($RSSslwmHai);
         
         $mysqlSLwmBa = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar'";
         $RSSslwmBa = mysqli_query($mysqli,$mysqlSLwmBa);
         $dulieuslWMBa = mysqli_fetch_array($RSSslwmBa);
         
         $mysqlSLwmBon = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr'";
         $RSSslwmBon = mysqli_query($mysqli,$mysqlSLwmBon);
         $dulieuslWMBon = mysqli_fetch_array($RSSslwmBon);
         
         $mysqlSLwmNam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'May'";
         $RSSslwmNam = mysqli_query($mysqli,$mysqlSLwmNam);
         $dulieuslWMNam = mysqli_fetch_array($RSSslwmNam);
         
         $mysqlSLwmSau = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun'";
         $RSSslwmSau = mysqli_query($mysqli,$mysqlSLwmSau);
         $dulieuslWMSau = mysqli_fetch_array($RSSslwmSau);
         
         $mysqlSLwmBay = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul'";
         $RSSslwmBay = mysqli_query($mysqli,$mysqlSLwmBay);
         $dulieuslWMBay = mysqli_fetch_array($RSSslwmBay);
         
         $mysqlSLwmTam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug'";
         $RSSslwmTam = mysqli_query($mysqli,$mysqlSLwmTam);
         $dulieuslWMTam = mysqli_fetch_array($RSSslwmTam);
         
         $mysqlSLwmChin = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep'";
         $RSSslwmChin = mysqli_query($mysqli,$mysqlSLwmChin);
         $dulieuslWMChin = mysqli_fetch_array($RSSslwmChin);
         
         $mysqlSLwmMuoi = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct'";
         $RSSslwmMuoi = mysqli_query($mysqli,$mysqlSLwmMuoi);
         $dulieuslWMMuoi = mysqli_fetch_array($RSSslwmMuoi);
         
         $mysqlSLwmMuoiMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov'";
         $RSSslwmMuoiMot = mysqli_query($mysqli,$mysqlSLwmMuoiMot);
         $dulieuslWMMuoiMot = mysqli_fetch_array($RSSslwmMuoiMot);
         
         $mysqlSLwmMuoiHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec'";
         $RSSslwmMuoiHai = mysqli_query($mysqli,$mysqlSLwmMuoiHai);
         $dulieuslWMMuoiHai = mysqli_fetch_array($RSSslwmMuoiHai);
         
         
         
         //Số Lượng ref 1-12
         
         $mysqlSLrefMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan'";
         $RSSslrefMot = mysqli_query($mysqli,$mysqlSLrefMot);
                $dulieuslREFMot = mysqli_fetch_array($RSSslrefMot);
         
         $mysqlSLrefHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb'";
         $RSSslrefHai = mysqli_query($mysqli,$mysqlSLrefHai);
                $dulieuslREFHai = mysqli_fetch_array($RSSslrefHai);
         
         $mysqlSLrefBa = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar'";
         $RSSslrefBa = mysqli_query($mysqli,$mysqlSLrefBa);
                $dulieuslREFBa = mysqli_fetch_array($RSSslrefBa);
         
         $mysqlSLrefBon = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr'";
         $RSSslrefBon = mysqli_query($mysqli,$mysqlSLrefBon);
                $dulieuslREFBon = mysqli_fetch_array($RSSslrefBon);
         
         $mysqlSLrefNam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'May'";
         $RSSslrefNam = mysqli_query($mysqli,$mysqlSLrefNam);
                $dulieuslREFNam = mysqli_fetch_array($RSSslrefNam);
         
         $mysqlSLrefSau = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun'";
         $RSSslrefSau = mysqli_query($mysqli,$mysqlSLrefSau);
                $dulieuslREFSau = mysqli_fetch_array($RSSslrefSau);
         
         $mysqlSLrefBay = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul'";
         $RSSslrefBay = mysqli_query($mysqli,$mysqlSLrefBay);
                $dulieuslREFBay = mysqli_fetch_array($RSSslrefBay);
         
         $mysqlSLrefTam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug'";
         $RSSslrefTam = mysqli_query($mysqli,$mysqlSLrefTam);
                $dulieuslREFTam = mysqli_fetch_array($RSSslrefTam);
         
         $mysqlSLrefChin = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep'";
         $RSSslrefChin = mysqli_query($mysqli,$mysqlSLrefChin);
                $dulieuslREFChin = mysqli_fetch_array($RSSslrefChin);
         
         $mysqlSLrefMuoi = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct'";
         $RSSslrefMuoi = mysqli_query($mysqli,$mysqlSLrefMuoi);
                $dulieuslREFMuoi = mysqli_fetch_array($RSSslrefMuoi);
         
         $mysqlSLrefMuoiMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov'";
         $RSSslrefMuoiMot = mysqli_query($mysqli,$mysqlSLrefMuoiMot);
                $dulieuslREFMuoiMot = mysqli_fetch_array($RSSslrefMuoiMot);
         
         $mysqlSLrefMuoiHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec'";
         $RSSslrefMuoiHai = mysqli_query($mysqli,$mysqlSLrefMuoiHai);
                $dulieuslREFMuoiHai = mysqli_fetch_array($RSSslrefMuoiHai);
         
         
         //Gia Tien WM
         
         
         $mysqlGTwmMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan'";
         $RSSgtwmMot = mysqli_query($mysqli,$mysqlGTwmMot);
                $dulieugtWMMot = mysqli_fetch_array($RSSgtwmMot);
         
         $mysqlGTwmHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb'";
         $RSSgtwmHai = mysqli_query($mysqli,$mysqlGTwmHai);
                $dulieugtWMHai = mysqli_fetch_array($RSSgtwmHai);
         
         $mysqlGTwmBa = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar'";
         $RSSgtwmBa = mysqli_query($mysqli,$mysqlGTwmBa);
                $dulieugtWMBa = mysqli_fetch_array($RSSgtwmBa);
         
         $mysqlGTwmBon = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr'";
         $RSSgtwmBon = mysqli_query($mysqli,$mysqlGTwmBon);
                $dulieugtWMBon = mysqli_fetch_array($RSSgtwmBon);
         
         $mysqlGTwmNam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'May'";
         $RSSgtwmNam = mysqli_query($mysqli,$mysqlGTwmNam);
                $dulieugtWMNam = mysqli_fetch_array($RSSgtwmNam);
         
         $mysqlGTwmSau = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun'";
         $RSSgtwmSau = mysqli_query($mysqli,$mysqlGTwmSau);
                $dulieugtWMSau = mysqli_fetch_array($RSSgtwmSau);
         
         $mysqlGTwmBay = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul'";
         $RSSgtwmBay = mysqli_query($mysqli,$mysqlGTwmBay);
                $dulieugtWMBay = mysqli_fetch_array($RSSgtwmBay);
         
         $mysqlGTwmTam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug'";
         $RSSgtwmTam = mysqli_query($mysqli,$mysqlGTwmTam);
                $dulieugtWMTam = mysqli_fetch_array($RSSgtwmTam);
         
         $mysqlGTwmChin = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep'";
         $RSSgtwmChin = mysqli_query($mysqli,$mysqlGTwmChin);
                $dulieugtWMChin = mysqli_fetch_array($RSSgtwmChin);
         
         $mysqlGTwmMuoi = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct'";
         $RSSgtwmMuoi = mysqli_query($mysqli,$mysqlGTwmMuoi);
                $dulieugtWMMuoi = mysqli_fetch_array($RSSgtwmMuoi);
         
         $mysqlGTwmMuoiMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov'";
         $RSSgtwmMuoiMot = mysqli_query($mysqli,$mysqlGTwmMuoiMot);
                $dulieugtWMMuoiMot = mysqli_fetch_array($RSSgtwmMuoiMot);
         
         $mysqlGTwmMuoiHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec'";
         $RSSgtwmMuoiHai = mysqli_query($mysqli,$mysqlGTwmMuoiHai);
                $dulieugtWMMuoiHai = mysqli_fetch_array($RSSgtwmMuoiHai);
         
         
         //Gia Tien Ref
         
         
         $mysqlGTrefMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan'";
         $RSSgtrefMot = mysqli_query($mysqli,$mysqlGTrefMot);
         $dulieugtREFMot = mysqli_fetch_array($RSSgtrefMot);
         
         $mysqlGTrefHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb'";
         $RSSgtrefHai = mysqli_query($mysqli,$mysqlGTrefHai);
         $dulieugtREFHai = mysqli_fetch_array($RSSgtrefHai);
         
         $mysqlGTrefBa = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar'";
         $RSSgtrefBa = mysqli_query($mysqli,$mysqlGTrefBa);
         $dulieugtREFBa = mysqli_fetch_array($RSSgtrefBa);
         
         $mysqlGTrefBon = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr'";
         $RSSgtrefBon = mysqli_query($mysqli,$mysqlGTrefBon);
         $dulieugtREFBon = mysqli_fetch_array($RSSgtrefBon);
         
         $mysqlGTrefNam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'May'";
         $RSSgtrefNam = mysqli_query($mysqli,$mysqlGTrefNam);
         $dulieugtREFNam = mysqli_fetch_array($RSSgtrefNam);
         
         $mysqlGTrefSau = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun'";
         $RSSgtrefSau = mysqli_query($mysqli,$mysqlGTrefSau);
         $dulieugtREFSau = mysqli_fetch_array($RSSgtrefSau);
         
         $mysqlGTrefBay = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul'";
         $RSSgtrefBay = mysqli_query($mysqli,$mysqlGTrefBay);
         $dulieugtREFBay = mysqli_fetch_array($RSSgtrefBay);
         
         $mysqlGTrefTam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug'";
         $RSSgtrefTam = mysqli_query($mysqli,$mysqlGTrefTam);
         $dulieugtREFTam = mysqli_fetch_array($RSSgtrefTam);
         
         $mysqlGTrefChin = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep'";
         $RSSgtrefChin = mysqli_query($mysqli,$mysqlGTrefChin);
         $dulieugtREFChin = mysqli_fetch_array($RSSgtrefChin);
         
         $mysqlGTrefMuoi = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct '";
         $RSSgtrefMuoi = mysqli_query($mysqli,$mysqlGTrefMuoi);
         $dulieugtREFMuoi = mysqli_fetch_array($RSSgtrefMuoi);
         
         $mysqlGTrefMuoiMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov'";
         $RSSgtrefMuoiMot = mysqli_query($mysqli,$mysqlGTrefMuoiMot);
         $dulieugtREFMuoiMot = mysqli_fetch_array($RSSgtrefMuoiMot);
         
         $mysqlGTrefMuoiHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec'";
         $RSSgtrefMuoiHai = mysqli_query($mysqli,$mysqlGTrefMuoiHai);
         $dulieugtREFMuoiHai = mysqli_fetch_array($RSSgtrefMuoiHai);
         
                if(empty($dulieuslWMMot['SUM(SoLuong)']) &&  empty($dulieugtWMMot['SUM(GiaTien)']) && empty($dulieuslWMMot['Thang'])){
                 $dulieuslWMMot['SUM(SoLuong)']=0;
                 $dulieugtWMMot['SUM(GiaTien)'] =0;
                 $dulieuslWMMot['Thang']="Rỗng";
                }
                if(empty($dulieuslWMHai['SUM(SoLuong)']) &&  empty($dulieugtWMHai['SUM(GiaTien)']) && empty($dulieuslWMHai['Thang'])){
                 $dulieuslWMHai['SUM(SoLuong)']=0;
                 $dulieugtWMHai['SUM(GiaTien)'] =0;
                 $dulieuslWMHai['Thang']="Rỗng";
                }
                if(empty($dulieuslWMBa['SUM(SoLuong)']) &&  empty($dulieugtWMBa['SUM(GiaTien)']) && empty($dulieuslWMBa['Thang'])){
                 $dulieuslWMBa['SUM(SoLuong)']=0;
                 $dulieugtWMBa['SUM(GiaTien)'] =0;
                 $dulieuslWMBa['Thang']="Rỗng";
                }
                if(empty($dulieuslWMBon['SUM(SoLuong)']) &&  empty($dulieugtWMBon['SUM(GiaTien)']) && empty($dulieuslWMBon['Thang'])){
                 $dulieuslWMBon['SUM(SoLuong)']=0;
                 $dulieugtWMBon['SUM(GiaTien)'] =0;
                 $dulieuslWMBon['Thang']="Rỗng";
                }
                if(empty($dulieuslWMNam['SUM(SoLuong)']) &&  empty($dulieugtWMNam['SUM(GiaTien)']) && empty($dulieuslWMNam['Thang'])){
                 $dulieuslWMNam['SUM(SoLuong)']=0;
                 $dulieugtWMNam['SUM(GiaTien)'] =0;
                 $dulieuslWMNam['Thang']="Rỗng";
                }
                if(empty($dulieuslWMSau['SUM(SoLuong)']) &&  empty($dulieugtWMSau['SUM(GiaTien)']) && empty($dulieuslWMSau['Thang'])){
                 $dulieuslWMSau['SUM(SoLuong)']=0;
                 $dulieugtWMSau['SUM(GiaTien)'] =0;
                 $dulieuslWMSau['Thang']="Rỗng";
                }
                if(empty($dulieuslWMBay['SUM(SoLuong)']) &&  empty($dulieugtWMBay['SUM(GiaTien)']) && empty($dulieuslWMBay['Thang'])){
                 $dulieuslWMBay['SUM(SoLuong)']=0;
                 $dulieugtWMBay['SUM(GiaTien)'] =0;
                 $dulieuslWMBay['Thang']="Rỗng";
                }
                if(empty($dulieuslWMTam['SUM(SoLuong)']) &&  empty($dulieugtWMTam['SUM(GiaTien)']) && empty($dulieuslWMTam['Thang'])){
                 $dulieuslWMTam['SUM(SoLuong)']=0;
                 $dulieugtWMTam['SUM(GiaTien)'] =0;
                 $dulieuslWMTam['Thang']="Rỗng";
                }
                if(empty($dulieuslWMChin['SUM(SoLuong)']) &&  empty($dulieugtWMChin['SUM(GiaTien)']) && empty($dulieuslWMChin['Thang'])){
                 $dulieuslWMChin['SUM(SoLuong)']=0;
                 $dulieugtWMChin['SUM(GiaTien)'] =0;
                 $dulieuslWMChin['Thang']="Rỗng";
                }
                if(empty($dulieuslWMMuoi['SUM(SoLuong)']) &&  empty($dulieugtWMMuoi['SUM(GiaTien)']) && empty($dulieuslWMMuoi['Thang'])){
                 $dulieuslWMMuoi['SUM(SoLuong)']=0;
                 $dulieugtWMMuoi['SUM(GiaTien)'] =0;
                 $dulieuslWMMuoi['Thang']="Rỗng";
                }
                if(empty($dulieuslWMMuoiMot['SUM(SoLuong)']) &&  empty($dulieugtWMMuoiMot['SUM(GiaTien)']) && empty($dulieuslWMMuoiMot['Thang'])){
                 $dulieuslWMMuoiMot['SUM(SoLuong)']=0;
                 $dulieugtWMMuoiMot['SUM(GiaTien)'] =0;
                 $dulieuslWMMuoiMot['Thang']="Rỗng";
                }
                if(empty($dulieuslWMMuoiHai['SUM(SoLuong)']) &&  empty($dulieugtWMMuoiHai['SUM(GiaTien)']) && empty($dulieuslWMMuoiHai['Thang'])){
                 $dulieuslWMMuoiHai['SUM(SoLuong)']=0;
                 $dulieugtWMMuoiHai['SUM(GiaTien)'] =0;
                 $dulieuslWMMuoiHai['Thang']="Rỗng";
                }
                 //REF
                 if(empty($dulieugtREFMot['SUM(SoLuong)']) &&  empty($dulieugtREFMot['SUM(GiaTien)']) && empty($dulieugtREFMot['Thang'])){
                   $dulieuslREFMot['SUM(SoLuong)']=0;
                   $dulieugtREFMot['SUM(GiaTien)'] =0;
                   $dulieuslREFMot['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFHai['SUM(SoLuong)']) &&  empty($dulieugtREFHai['SUM(GiaTien)']) && empty($dulieugtREFHai['Thang'])){
                   $dulieuslREFHai['SUM(SoLuong)']=0;
                   $dulieugtREFHai['SUM(GiaTien)'] =0;
                   $dulieuslREFHai['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFBa['SUM(SoLuong)']) &&  empty($dulieugtREFBa['SUM(GiaTien)']) && empty($dulieugtREFBa['Thang'])){
                   $dulieuslREFBa['SUM(SoLuong)']=0;
                   $dulieugtREFBa['SUM(GiaTien)'] =0;
                   $dulieuslREFBa['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFBon['SUM(SoLuong)']) &&  empty($dulieugtREFBon['SUM(GiaTien)']) && empty($dulieugtREFBon['Thang'])){
                   $dulieuslREFBon['SUM(SoLuong)']=0;
                   $dulieugtREFBon['SUM(GiaTien)'] =0;
                   $dulieuslREFBon['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFNam['SUM(SoLuong)']) &&  empty($dulieugtREFNam['SUM(GiaTien)']) && empty($dulieugtREFNam['Thang'])){
                   $dulieuslREFNam['SUM(SoLuong)']=0;
                   $dulieugtREFNam['SUM(GiaTien)'] =0;
                   $dulieuslREFNam['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFSau['SUM(SoLuong)']) &&  empty($dulieugtREFSau['SUM(GiaTien)']) && empty($dulieugtREFSau['Thang'])){
                   $dulieuslREFSau['SUM(SoLuong)']=0;
                   $dulieugtREFSau['SUM(GiaTien)'] =0;
                   $dulieuslREFSau['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFBay['SUM(SoLuong)']) &&  empty($dulieugtREFBay['SUM(GiaTien)']) && empty($dulieugtREFBay['Thang'])){
                   $dulieuslREFBay['SUM(SoLuong)']=0;
                   $dulieugtREFBay['SUM(GiaTien)'] =0;
                   $dulieuslREFBay['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFTam['SUM(SoLuong)']) &&  empty($dulieugtREFTam['SUM(GiaTien)']) && empty($dulieugtREFTam['Thang'])){
                   $dulieuslREFTam['SUM(SoLuong)']=0;
                   $dulieugtREFTam['SUM(GiaTien)'] =0;
                   $dulieuslREFTam['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFChin['SUM(SoLuong)']) &&  empty($dulieugtREFChin['SUM(GiaTien)']) && empty($dulieugtREFChin['Thang'])){
                   $dulieuslREFChin['SUM(SoLuong)']=0;
                   $dulieugtREFChin['SUM(GiaTien)'] =0;
                   $dulieuslREFChin['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFMuoi['SUM(SoLuong)']) &&  empty($dulieugtREFMuoi['SUM(GiaTien)']) && empty($dulieugtREFMuoi['Thang'])){
                   $dulieuslREFMuoi['SUM(SoLuong)']=0;
                   $dulieugtREFMuoi['SUM(GiaTien)'] =0;
                   $dulieuslREFMuoi['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFMuoiMot['SUM(SoLuong)']) &&  empty($dulieugtREFMuoiMot['SUM(GiaTien)']) && empty($dulieugtREFMuoiMot['Thang'])){
                   $dulieuslREFMuoiMot['SUM(SoLuong)']=0;
                   $dulieugtREFMuoiMot['SUM(GiaTien)'] =0;
                   $dulieuslREFMuoiMot['Thang']="Rỗng";
                  }
                  if(empty($dulieugtREFMuoiHai['SUM(SoLuong)']) &&  empty($dulieugtREFMuoiHai['SUM(GiaTien)']) && empty($dulieugtREFMuoiHai['Thang'])){
                   $dulieuslREFMuoiHai['SUM(SoLuong)']=0;
                   $dulieugtREFMuoiHai['SUM(GiaTien)'] =0;
                   $dulieuslREFMuoiHai['Thang']="Rỗng";
                  }
                  
         
               $mysqlMDwm = "SELECT Nam,Thang,Model,COUNT(*) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%' GROUP BY Model";
         
               $RSSmdWM = mysqli_query($mysqli,$mysqlMDwm);
                             if(mysqli_num_rows($RSSmdWM)>0){
                               while($Mdtkwm = mysqli_fetch_array($RSSmdWM)){
                                 $dataMDwmtk[] = $Mdtkwm;                  
                                  }    
                             }else{
                               echo'Đã xảy ra lỗi hoặc chưa import excel năm "'.$NamTK.'", mời chọn lại hoặc liên hệ quản trị hệ thống';
                                  exit();
                              }
         
               $mysqlMDref = "SELECT Nam,Thang,Model,COUNT(*) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%' GROUP BY Model";
               
               $RSSmdREF = mysqli_query($mysqli,$mysqlMDref);
                             if(mysqli_num_rows($RSSmdREF)>0){
                               while($Mdtkref = mysqli_fetch_array($RSSmdREF)){
                                 $dataMDreftk[] = $Mdtkref;                  
                                  }    
                             }else{
                                echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                                  exit();
                              }
   
  
      }else{
         $a++;
          
         
     
                  
                                       // năm và tháng 
                $NgayThang ="SELECT * FROM modelwm where NamMD like '%".$NamTK."%' 
    AND ThangMD like '%".$ThangTK."%'";

              $KQTime = mysqli_query($mysqli,$NgayThang);
                    if(mysqli_num_rows($KQTime)>0){
                      while($TimeTK = mysqli_fetch_array($KQTime)){
                        $dataTK[] = $TimeTK; 
                         
                         }
                             
                    }else{
                        echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                         exit();
                     }
                    
                     
                    
      
    $NgayThangtwo ="SELECT * FROM modelref where NamMDref = $NamTK 
    AND ThangMDref = '$ThangTK'";
                 
              $KQhaiTime = mysqli_query($mysqli,$NgayThangtwo);
                    if(mysqli_num_rows($KQhaiTime)>0){
                      while($TimetwoTK = mysqli_fetch_array($KQhaiTime)){
                        $datatwoTK[] = $TimetwoTK; 
                                          
                        }
                                     
                    }else{
                        echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                        exit();
                     }
                     
    $NgayThangslwm ="SELECT * FROM soluongwm where Namslwm = $NamTK
    AND Thangslwm = '$ThangTK'";
                                  
              $KQslwm = mysqli_query($mysqli,$NgayThangslwm);
                    if(mysqli_num_rows($KQslwm)>0){
                      while($SLwm = mysqli_fetch_array($KQslwm)){
                          $Namslwm = $SLwm['Namslwm'];
                          $Thangslwm = $SLwm['Thangslwm'];
                          $SLsanphamwm = $SLwm['SoLuongwm'];
                                                           
                        }
                                                      
                    }else{
                        echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                        exit();
                    }
    $NgayThangslref ="SELECT * FROM soluongref where Namref = $NamTK
    AND Thangref = '$ThangTK'";
                                                  
              $KQslref = mysqli_query($mysqli,$NgayThangslref);
                    if(mysqli_num_rows($KQslref)>0){
                      while($SLref = mysqli_fetch_array($KQslref)){
                            $Namslref = $SLref['Namref'];
                            $Thangslref = $SLref['Thangref'];
                            $SLsanphamref = $SLref['SoLuongref'];
                                                                           
                        }
                                                                      
                    }else{
                        echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                        exit();
                    }
    $NgayThangTienwm ="SELECT * FROM giatienwm where NamGTwm like '%".$NamTK."%' 
    AND ThangGTwm like '%".$ThangTK."%'";
                                  
              $KQGTwm = mysqli_query($mysqli,$NgayThangTienwm);
                    if(mysqli_num_rows($KQGTwm)>0){
                      while($GTwm = mysqli_fetch_array($KQGTwm)){
                          $NamGTwm = $GTwm['NamGTwm'];
                          $ThangGTwm = $GTwm['ThangGTwm'];
                         $GTsanphamwm = $GTwm['GiaTienwm'];
                                                           
                        }
                                                      
                    }else{
                        echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                        exit();
                    }
    $NgayThangTienref ="SELECT * FROM giatienref where NamGTref like '%".$NamTK."%' 
    AND ThangGTref like '%".$ThangTK."%'";
                                                  
              $KQGTref = mysqli_query($mysqli,$NgayThangTienref);
                    if(mysqli_num_rows($KQGTref)>0){
                       while($GTref = mysqli_fetch_array($KQGTref)){
                           $NamGTref = $GTref['NamGTref'];
                           $ThangGTref = $GTref['ThangGTref'];
                          $GTsanphamref = $GTref['GiaTienref'];
                                                                           
                        }
                                                                      
                    }else{
                        echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                        exit();
                    }
                  
                                       
                                     
                       
                  
      }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/namthang.css">

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
    <!-- Bộ lọc -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
  <title>Thống Kê Theo Năm</title>

  <script class="chinhscrip" type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['ModelMD', 'SoLuongMD'],
         

         <?php
         if($a>0){
         foreach($dataTK as $key){
          echo "['".$key['ModelMD']."',".$key['SoLuongMD']."],"; 
         }
         }elseif($n>0){
          foreach($dataMDwmtk as $keyba){
            echo "['".$keyba['Model']."',".$keyba['COUNT(*)']."],"; 
           }
         }
         ?>
        ]);
       
        var options = {
          title:
            <?php
             if($a>0){
             echo "'Biểu đồ model WM tháng ".$ThangTK." năm ".$NamTK."'";
             }elseif($n>0){
                echo "'Biểu đồ model WM năm ".$NamTK."'";
                } 
            ?> ,
          is3D: true,
          'width': 550,
          'height': 390
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day '],
          <?php
           if($a>0){
            foreach($datatwoTK as $keyhai){
              echo "['".$keyhai['ModelMDref']."',".$keyhai['SoLuongMDref']."],";
             }  
           }
         elseif($n>0){

            foreach($dataMDreftk as $keykey){
              echo "['".$keykey['Model']."',".$keykey['COUNT(*)']."],"; 
    
             }
  
           }

         
         
         ?>
        ]);

        var options = {
          title: <?php
             if($a>0){
              echo "'Biểu đồ model REF tháng ".$ThangTK." năm ".$NamTK."'";
              }elseif($n>0){
                 echo "'Biểu đồ model REF năm ".$NamTK."'";
                 }
             ?> ,
           
          is3D: true,
          'width': 550,
          'height': 390
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');

        var data = google.visualization.arrayToDataTable([
          ['Bảng Thống Kê LG', 'Số Lượng', 'Giá Tiền'],
          
          <?php
           if($a>0){
             echo "['".$Thangslwm."',".$SLsanphamwm.",".$GTsanphamwm."],"; 
          }
          
          
          ?>
         
        ]);

        var materialOptions = {
          width: 450,
          chart: {
            title:
            <?php
             if($a>0){
             echo "'Thống kê số lượng  và giá tiền (WM) tháng ".$Thangslwm." năm ".$Namslwm."'";
             }
            ?> 
            ,
            subtitle: 'Quantity on the left, price on the right'
          },
          series: {
            0: { axis: 'Số Lượng' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'Giá Tiền' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'Số Lượng'}, // Left y-axis.
              brightness: {side: 'right', label: 'Giá Tiền'} // Right y-axis.
            }
          }
        };

        var classicOptions = {
          width: 450,
          series: {
            0: {targetAxisIndex: 0},
            1: {targetAxisIndex: 1}
          },
          title: 'Quantity on the left, price on the right',
          vAxes: {
            // Adds titles to each axis.
            0: {title: 'Số Lượng'},
            1: {title: 'Giá Tiền'}
          }
        };

        function drawMaterialChart() {
          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
          button.innerText = 'Đổi Dữ Liệu';
          button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Đổi Dữ Liệu';
          button.onclick = drawMaterialChart;
        }

        drawMaterialChart();
    };
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-chartt');
        var chartDiv = document.getElementById('chart_divv');

        var data = google.visualization.arrayToDataTable([
          ['Bảng Thống Kê LG', 'Số Lượng', 'Giá Tiền'],
          
          <?php
           if($a>0){
             echo "['".$Thangslref."',".$SLsanphamref.",".$GTsanphamref."],"; 
          }
          
          ?>
         
        ]);

        var materialOptions = {
          width: 450,
          chart: {
            title:
            <?php
             if($a>0){
             echo "'Thống kê số lượng  và giá tiền (REF) tháng ".$Thangslref." năm ".$Namslref."'";
             } 
            ?> 
            ,
            subtitle: 'Quantity on the left, price on the right'
          },
          series: {
            0: { axis: 'Số Lượng' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'Giá Tiền' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'Số Lượng'}, // Left y-axis.
              brightness: {side: 'right', label: 'Giá Tiền'} // Right y-axis.
            }
          }
        };

        var classicOptions = {
          width: 450,
          series: {
            0: {targetAxisIndex: 0},
            1: {targetAxisIndex: 1}
          },
          title: 'Quantity on the left, price on the right',
          vAxes: {
            // Adds titles to each axis.
            0: {title: 'Số Lượng'},
            1: {title: 'Giá Tiền'}
          }
        };

        function drawMaterialChart() {
          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
          button.innerText = 'Đổi Dữ Liệu';
          button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Đổi Dữ Liệu';
          button.onclick = drawMaterialChart;
        }

        drawMaterialChart();
    };
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-charttt');
        var chartDiv = document.getElementById('chart_divvv');

        var data = google.visualization.arrayToDataTable([
          ['LG', 'Số Lượng', 'Giá Tiền'],
        <?php
        if($n>0){ 
          echo "['".$dulieuslWMMot['Thang']."',".$dulieuslWMMot['SUM(SoLuong)'].",".$dulieugtWMMot['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMHai['Thang']."',".$dulieuslWMHai['SUM(SoLuong)'].",".$dulieugtWMHai['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMBa['Thang']."',".$dulieuslWMBa['SUM(SoLuong)'].",".$dulieugtWMBa['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMBon['Thang']."',".$dulieuslWMBon['SUM(SoLuong)'].",".$dulieugtWMBon['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMNam['Thang']."',".$dulieuslWMNam['SUM(SoLuong)'].",".$dulieugtWMNam['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMSau['Thang']."',".$dulieuslWMSau['SUM(SoLuong)'].",".$dulieugtWMSau['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMBay['Thang']."',".$dulieuslWMBay['SUM(SoLuong)'].",".$dulieugtWMBay['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMTam['Thang']."',".$dulieuslWMTam['SUM(SoLuong)'].",".$dulieugtWMTam['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMChin['Thang']."',".$dulieuslWMChin['SUM(SoLuong)'].",".$dulieugtWMChin['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMMuoi['Thang']."',".$dulieuslWMMuoi['SUM(SoLuong)'].",".$dulieugtWMMuoi['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMMuoiMot['Thang']."',".$dulieuslWMMuoiMot['SUM(SoLuong)'].",".$dulieugtWMMuoiMot['SUM(GiaTien)']."],";
          echo "['".$dulieuslWMMuoiHai['Thang']."',".$dulieuslWMMuoiHai['SUM(SoLuong)'].",".$dulieugtWMMuoiHai['SUM(GiaTien)']."],";
         }
        ?>
        ]);

        var materialOptions = {
          width: 1100,
          chart: {
            title: <?php
              if($n>0){
                echo "'Biểu đồ cột WM năm ".$NamTK."'";
                }
              ?>,
            subtitle: 'RỖNG là tháng đó chưa có dữ liệu'
          },
          series: {
            0: { axis: 'Số Luọng' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'Giá Tiền' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'Giá trị số lượng'}, // Left y-axis.
              brightness: {side: 'right', label: 'Giá trị số tiền'} // Right y-axis.
            }
          }
        };

        var classicOptions = {
          width: 1100,
          series: {
            0: {targetAxisIndex: 0},
            1: {targetAxisIndex: 1}
          },
          title: <?php
              if($n>0){
                echo "'Biểu đồ cột WM năm ".$NamTK."'";
                }
              ?>,
          vAxes: {
            // Adds titles to each axis.
            0: {title: 'Giá trị số lượng'},
            1: {title: 'Giá trị số tiền'}
          }
        };

        function drawMaterialChart() {
          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
          button.innerText = 'Change to Classic';
          button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Change to Material';
          button.onclick = drawMaterialChart;
        }

        drawMaterialChart();
    };
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-chartttt');
        var chartDiv = document.getElementById('chart_divvvv');

        var data = google.visualization.arrayToDataTable([
          ['LG', 'Số Lượng', 'Giá Tiền'],
        <?php
        if($n>0){ 
          echo "['".$dulieuslREFMot['Thang']."',".$dulieuslREFMot['SUM(SoLuong)'].",".$dulieugtREFMot['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFHai['Thang']."',".$dulieuslREFHai['SUM(SoLuong)'].",".$dulieugtREFHai['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFBa['Thang']."',".$dulieuslREFBa['SUM(SoLuong)'].",".$dulieugtREFBa['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFBon['Thang']."',".$dulieuslREFBon['SUM(SoLuong)'].",".$dulieugtREFBon['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFNam['Thang']."',".$dulieuslREFNam['SUM(SoLuong)'].",".$dulieugtREFNam['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFSau['Thang']."',".$dulieuslREFSau['SUM(SoLuong)'].",".$dulieugtREFSau['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFBay['Thang']."',".$dulieuslREFBay['SUM(SoLuong)'].",".$dulieugtREFBay['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFTam['Thang']."',".$dulieuslREFTam['SUM(SoLuong)'].",".$dulieugtREFTam['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFChin['Thang']."',".$dulieuslREFChin['SUM(SoLuong)'].",".$dulieugtREFChin['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFMuoi['Thang']."',".$dulieuslREFMuoi['SUM(SoLuong)'].",".$dulieugtREFMuoi['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFMuoiMot['Thang']."',".$dulieuslREFMuoiMot['SUM(SoLuong)'].",".$dulieugtREFMuoiMot['SUM(GiaTien)']."],";
          echo "['".$dulieuslREFMuoiHai['Thang']."',".$dulieuslREFMuoiHai['SUM(SoLuong)'].",".$dulieugtREFMuoiHai['SUM(GiaTien)']."],";
         }
        ?>
        ]);

        var materialOptions = {
          width: 1100,
          chart: {
            title: 'Nearby galaxies',title: <?php
              if($n>0){
                echo "'Biểu đồ cột REF năm ".$NamTK."'";
                }
              ?>,
            subtitle: 'RỖNG là tháng đó chưa có dữ liệu'
          },
          series: {
            0: { axis: 'Số Luọng' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'Giá Tiền' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            y: {
              distance: {label: 'Giá trị số lượng'}, // Left y-axis.
              brightness: {side: 'right', label: 'Giá trị số tiền'} // Right y-axis.
            }
          }
        };

        var classicOptions = {
          width: 1100,
          series: {
            0: {targetAxisIndex: 0},
            1: {targetAxisIndex: 1}
          },
          title: <?php
              if($n>0){
                echo "'Biểu đồ cột WM năm ".$NamTK."'";
                }
              ?>,
          vAxes: {
            // Adds titles to each axis.
            0: {title: 'Giá trị số lượng'},
            1: {title: 'Giá trị số tiền'}
          }
        };

        function drawMaterialChart() {
          var materialChart = new google.charts.Bar(chartDiv);
          materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
          button.innerText = 'Change to Classic';
          button.onclick = drawClassicChart;
        }

        function drawClassicChart() {
          var classicChart = new google.visualization.ColumnChart(chartDiv);
          classicChart.draw(data, classicOptions);
          button.innerText = 'Change to Material';
          button.onclick = drawMaterialChart;
        }

        drawMaterialChart();
    };
    </script>
</head>
<body>
<div class="header">
    
<form class="TK" action="#" method="post">

<select name="NamTK" id="NamTK" class="chinhboloc" required>
                           <span class="TuyChinh">&#8744;</span>
                        <option value="">Chọn Năm: </option>
                        <?php
                         foreach($KQTuyChon as $SoNamTK){

                         echo '<option class="optionloc" value="'.$SoNamTK["Nam"].'">'.$SoNamTK["Nam"].'</option>'; 
                          }
                        ?>
                         <span><?php if(isset($error['NamTK'])) echo $error['NamTK']; ?></span>
                       </select>


                      
                        <select name="ThangTK" id="ThangTK" class=" locmot" required>
                        <span class="TuyChinh">&#8744;</span>
                        <option class="optionloc" value="">Chọn Tháng: </option>
                        <option value="">Không Chọn</option>
                        <option class="optionloc" value="Jan">January</option>
                        <option class="optionloc" value="Feb">February</option>
                        <option class="optionloc" value="Mar">March</option>
                        <option class="optionloc" value="Apr">April</option>
                        <option class="optionloc" value="May">May</option>
                        <option class="optionloc" value="Jun">June</option>
                        <option class="optionloc" value="Jul">July</option>
                        <option class="optionloc" value="Feb">August</option>
                        <option class="optionloc" value="Sep">September</option>
                        <option class="optionloc" value="Oct">October</option>
                        <option class="optionloc" value="Nov">November</option>
                        <option class="optionloc" value="Dec">December</option>
                       </select>


                       
<input type="submit" name="submit" value="Click me!" class="btn btn-primary mt-3 export" />

</form>

</div>
  <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
  <label for="openSidebarMenu" class="sidebarIconToggle">
    <div class="spinner diagonal part-1"></div>
    <div class="spinner horizontal"></div>
    <div class="spinner diagonal part-2"></div>
  </label>
  <div id="sidebarMenu">
    <ul class="sidebarMenuInner">
      <li><a href="../index.php" target="_blank">Home</a><span>Web Developer</span></li>
      <li><a href="./Vung.php" target="_blank">Thống kê theo vùng</a></li>
      <li><a href="./CHwe.php" target="_blank">Theo mã cửa hàng WM</a></li>
      <li><a href="./CHref.php" target="_blank">Theo mã cửa hàng REF</a></li>
      <li><a href="../homeadmin.php" target="_blank">ADMIN</a></li>
      
    </ul>
  </div>
  <div id='center' class="main center">
  <div class="spostline">
   <h1>Thống Kê Theo Năm Tháng...! </h1>
 </div>
  
  

 <div class="row" style=" display: flex;">
    <div id="piechart_3d" ></div>
    <div id="donutchart" ></div>
    
    </div>
    <button class="chinhchange" id="change-chart">Change to Classic</button>
    <button class="chinhchangee" id="change-chartt">Change to Classic</button>
    <div class="cot">  
     <div id="chart_div" ></div>
     <div id="chart_divv" ></div>
     <div class="Octahedron">
        <div class="Side" style="--R:0;"></div>
        <div class="Side" style="--R:1;"></div>
        <div class="Side" style="--R:2;"></div>
        <div class="Side" style="--R:3;"></div>

        <div class="Side-2" style="--R:0;"></div>
        <div class="Side-2" style="--R:1;"></div>
        <div class="Side-2" style="--R:2;"></div>
        <div class="Side-2" style="--R:3;"></div>

        <div class="Shadow"></div>

    </div>
    <div id="content">
  
  <div id="first">
  </div>
  
  <div id="second">
  </div>
  
  <div id="third">
  </div>
  
  <div id="fourth">
  </div>
  
  <div id="glow1">
  </div>
  
  <div id="glow2">
  </div>
  
</div>
    </div>
    <div class="cotdoc">
      <div class="PTmot">
      <button id="change-charttt">Change to Classic</button>
    <div id="chart_divvv" style="width: 800px; height: 500px;"></div>
      </div>
      <div class="PThai">
      <button id="change-chartttt">Change to Classic</button>
    <div id="chart_divvvv" style="width: 800px; height: 500px;"></div>
      </div>
    </div>
    
  </div>
 
  
</body>
</html>