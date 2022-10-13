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
$TuyChonVung = "SELECT DISTINCT Vung FROM thongke";
$KQTuyChonVung = mysqli_query($mysqli,$TuyChonVung);
if(mysqli_num_rows($KQTuyChonVung)>0){
    $ChonVung = mysqli_fetch_array($KQTuyChonVung);
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
    $VungTK = $_POST['VungTK'];
    // Truy vấn lấy dữ liệu
    
    $sqlloaimot = "SELECT Nam,Thang,Vung,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%'  AND Vung like '%".$VungTK."%'";

    $sqlloaihai = "SELECT Nam,Thang,Vung,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' AND Vung like '%".$VungTK."%'";

    $sqlGTWM = "SELECT Nam,Thang,Vung,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' AND Vung like '%".$VungTK."%'";

    $sqlGTREF = "SELECT Nam,Thang,Vung,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' AND Vung like '%".$VungTK."%'";

    $sqlModelmot = "SELECT Nam,Thang,Model,Vung,COUNT(*) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' AND Vung like '%".$VungTK."%' GROUP BY Model";

    $sqlModelhai = "SELECT Nam,Thang,Model,Vung,COUNT(*) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
    AND Thang like '%".$ThangTK."%' AND Vung like '%".$VungTK."%' GROUP BY Model";

//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

    $KQGTWM = mysqli_query($mysqli,$sqlGTWM);
    $dataGTWM = mysqli_fetch_array($KQGTWM);
       $NamGTwm = $dataGTWM['Nam'];
       $ThangGTwm = $dataGTWM['Thang'];
        $VungGTwm = $dataGTWM['Vung'];
        $GiaTien= $dataGTWM['SUM(GiaTien)'];
      if(empty($dataGTWM['Nam'])){
        echo 'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống
        <a href="http://localhost:81/TKLG/thongke.php" class="alert-link">Go Back</a> <br>';
       
      }else{
           
    $thucthiGT = mysqli_query($mysqli,"SELECT * FROM giatienVwm WHERE NamGTVwm like '%".$NamGTwm."%'
    AND ThangGTVwm like '%".$ThangGTwm."%' AND VungGTwm like '%".$VungGTwm."%' AND GiaTienVwm like '%".$GiaTien."%'");
   
      if(!$thucthiGT || mysqli_num_rows($thucthiGT)>0){
        echo '';
      }else{

       
     $ThongKeGTMot ="INSERT INTO giatienVwm(NamGTVwm,ThangGTVwm,VungGTwm,GiaTienVwm) VALUES($NamGTwm,'$ThangGTwm','$VungGTwm',$GiaTien)";
      mysqli_query($mysqli,$ThongKeGTMot);
      
    
    }
      }
//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)             

      $KQGTREF = mysqli_query($mysqli,$sqlGTREF);
      $dataGTREF = mysqli_fetch_array($KQGTREF);
       $NamGTref = $dataGTREF['Nam'];
       $ThangGTref = $dataGTREF['Thang'];
       $VungGTref = $dataGTWM['Vung'];
       $GiaTienref= $dataGTREF['SUM(GiaTien)'];

       if(empty($dataGTWM['Nam'])){
        echo 'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống
        <a href="http://localhost:80/TKLG/thongke.php" class="alert-link">Go Back</a><br>';
        
      }else{
//KT trùng

      $thucthiGTref = mysqli_query($mysqli,"SELECT * FROM giatienvref WHERE NamGTref like '%".$NamGTref."%'
      AND ThangGTref like '%".$ThangGTref."%'  AND VungGTref like '%".$VungGTref."%' AND GiaTienref like '%".$GiaTienref."%'");

      if(!$thucthiGTref || mysqli_num_rows($thucthiGTref)>0){
        echo '';
      }else{
        $ThongKeGTHai ="INSERT INTO giatienvref(NamGTref,ThangGTref,VungGTref,GiaTienref) VALUES($NamGTref,'$ThangGTref','$VungGTref',$GiaTienref)";
        mysqli_query($mysqli,$ThongKeGTHai);
       
      }
    }
    //Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

    $KQLoaimot = mysqli_query($mysqli,$sqlloaimot);
    $dataLoaimot = mysqli_fetch_array($KQLoaimot);
    $Namslwm = $dataLoaimot['Nam'];
    $Thangslwm = $dataLoaimot['Thang'];
    $Vungslwm = $dataLoaimot['Vung'];
    $SoLuongslwm= $dataLoaimot['SUM(SoLuong)'];

    if(empty($dataGTWM['Nam'])){
      echo 'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống
      <a href="http://localhost:81/TKLG/thongke.php" class="alert-link">Go Back</a><br>';
      
    }else{

//KT trùng

    $thucthiSLwm = mysqli_query($mysqli,"SELECT * FROM soluongvwm WHERE Namslvwm like '%".$Namslwm."%'
    AND Thangslvwm like '%".$Thangslwm."%'  AND Vungslwm like '%".$Vungslwm."%' AND SoLuongvwm like '%".$SoLuongslwm."%'");

    if(!$thucthiSLwm || mysqli_num_rows($thucthiSLwm)>0){
     echo '';
    }else{
      $ThongKeSLMot ="INSERT INTO soluongvwm(Namslvwm,Thangslvwm,Vungslwm,SoLuongvwm) VALUES($Namslwm,'$Thangslwm','$Vungslwm',$SoLuongslwm)";
      mysqli_query($mysqli,$ThongKeSLMot);
     
    }
  }

  //Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

  $KQLoaihai = mysqli_query($mysqli,$sqlloaihai);
  $dataLoaihai = mysqli_fetch_array($KQLoaihai);
  $Namref = $dataLoaihai['Nam'];
  $Thangref = $dataLoaihai['Thang'];
  $Vungref =  $dataLoaihai['Vung'];
  $SoLuongref= $dataLoaihai['SUM(SoLuong)'];

//KT trùng

  $thucthiSLref = mysqli_query($mysqli,"SELECT * FROM soluongvref WHERE Namvref like '%".$Namref."%'
  AND Thangvref like '%".$Thangref."%' AND Vungref like '%".$Vungref."%' AND SoLuongref like '%".$SoLuongref."%'");
  if(!$thucthiSLref || mysqli_num_rows($thucthiSLref)>0){
    echo '';
  }else{
    $ThongKeSLHai ="INSERT INTO soluongvref(Namvref,Thangvref,Vungref,SoLuongref) VALUES($Namref,'$Thangref','$Vungref',$SoLuongref)";
    mysqli_query($mysqli,$ThongKeSLHai);
   
  }

 //Lấy mảng dữ liệu từ câu truy vấn(Vì trả về 1 mảng nhiều model)
    
 $KQModelmot = mysqli_query($mysqli,$sqlModelmot);
 while($dataModelmot = mysqli_fetch_array($KQModelmot)){
      $NamMDwm = $dataModelmot['Nam'];
      $ThangMDwm = $dataModelmot['Thang'];
      $MDwm = $dataModelmot['Model'];
      $VungMDwm = $dataModelmot['Vung'];
      $DemMDwm = $dataModelmot['COUNT(*)'];

//KT trùng

      $thucthiMDwm = mysqli_query($mysqli,"SELECT * FROM modelvungwm WHERE 
     NamVMD like '%".$NamMDwm."%'
     AND ThangVMD like '%".$ThangMDwm."%' 
     AND ModelVungwm like '%".$MDwm."%'
     AND VungMDwm like '%".$VungMDwm."%'
     AND DemModel like '%".$DemMDwm."%'");
    
     if(!$thucthiMDwm || mysqli_num_rows($thucthiMDwm)>0){
       echo '';
     }else{

     $ThongKeMDMot ="INSERT INTO modelvungwm(NamVMD,ThangVMD,ModelVungwm,VungMDwm,DemModel)
      VALUES($NamMDwm,'$ThangMDwm','$MDwm','$VungMDwm',$DemMDwm)";
     mysqli_query($mysqli,$ThongKeMDMot);
     
     }
     
 }
 
 $dataTK = [];
 $KQModelhai = mysqli_query($mysqli,$sqlModelhai);
 if(mysqli_num_rows( $KQModelhai)>0){
    while($dataModelhai = mysqli_fetch_array($KQModelhai)){
      $dataTK[] = $dataModelhai; 
        //KT trùng
        }
        foreach($dataTK as $key){
            $NamMDref = $key['Nam'];
            $ThangMDref = $key['Thang'];
            $MDref = $key['Model'];
            $VungMDref = $key['Vung'];
            $DemMDref = $key['COUNT(*)'];

          $thucthiMDref = mysqli_query($mysqli,"SELECT * FROM modelvref WHERE NamvMDref like '%".$NamMDref."%'
          AND ThangvMDref like '%".$ThangMDref."%' AND ModelvMDref like '%".$MDref."%'
          AND VungMDref like '%".$VungMDref."%'
          AND DemMDref like '%".$DemMDref."%'");
         
          if(!$thucthiMDref || mysqli_num_rows($thucthiMDref)>0){
            echo '';
          }else{
            $ThongKeMDHai ="INSERT INTO modelvref(NamvMDref,ThangvMDref,ModelvMDref,VungMDref,DemMDref)
            VALUES($NamMDref,'$ThangMDref','$MDref','$VungMDref',$DemMDref)";
           mysqli_query($mysqli,$ThongKeMDHai);
          
          } 
         

        }
        
       
      }
      if(!empty($_POST['NamTK']) && empty($_POST['ThangTK']) && !empty($_POST['VungTK'])){
          $n++;
          $mysqlSLwmMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jan' AND Vung like '".$VungTK."'";
          $RSSslwmMot = mysqli_query($mysqli,$mysqlSLwmMot);
          $dulieuslWMMot = mysqli_fetch_array($RSSslwmMot);
          
          $mysqlSLwmHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Feb' AND Vung like '".$VungTK."'";
          $RSSslwmHai = mysqli_query($mysqli,$mysqlSLwmHai);
          $dulieuslWMHai = mysqli_fetch_array($RSSslwmHai);
          
          $mysqlSLwmBa = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Mar' AND Vung like '".$VungTK."'";
          $RSSslwmBa = mysqli_query($mysqli,$mysqlSLwmBa);
          $dulieuslWMBa = mysqli_fetch_array($RSSslwmBa);
          
          $mysqlSLwmBon = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Apr' AND Vung like '".$VungTK."'";
          $RSSslwmBon = mysqli_query($mysqli,$mysqlSLwmBon);
          $dulieuslWMBon = mysqli_fetch_array($RSSslwmBon);
          
          $mysqlSLwmNam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'May' AND Vung like '".$VungTK."'";
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
          AND Thang like 'Aug' AND Vung like '".$VungTK."'";
          $RSSslwmTam = mysqli_query($mysqli,$mysqlSLwmTam);
          $dulieuslWMTam = mysqli_fetch_array($RSSslwmTam);
          
          $mysqlSLwmChin = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Sep'";
          $RSSslwmChin = mysqli_query($mysqli,$mysqlSLwmChin);
          $dulieuslWMChin = mysqli_fetch_array($RSSslwmChin);
          
          $mysqlSLwmMuoi = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Oct' AND Vung like '".$VungTK."'";
          $RSSslwmMuoi = mysqli_query($mysqli,$mysqlSLwmMuoi);
          $dulieuslWMMuoi = mysqli_fetch_array($RSSslwmMuoi);
          
          $mysqlSLwmMuoiMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Nov' AND Vung like '".$VungTK."'";
          $RSSslwmMuoiMot = mysqli_query($mysqli,$mysqlSLwmMuoiMot);
          $dulieuslWMMuoiMot = mysqli_fetch_array($RSSslwmMuoiMot);
          
          $mysqlSLwmMuoiHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Dec' AND Vung like '".$VungTK."'";
          $RSSslwmMuoiHai = mysqli_query($mysqli,$mysqlSLwmMuoiHai);
          $dulieuslWMMuoiHai = mysqli_fetch_array($RSSslwmMuoiHai);
          
          
          
          //Số Lượng ref 1-12
          
          $mysqlSLrefMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jan' AND Vung like '".$VungTK."'";
          $RSSslrefMot = mysqli_query($mysqli,$mysqlSLrefMot);
                 $dulieuslREFMot = mysqli_fetch_array($RSSslrefMot);
          
          $mysqlSLrefHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Feb' AND Vung like '".$VungTK."'";
          $RSSslrefHai = mysqli_query($mysqli,$mysqlSLrefHai);
                 $dulieuslREFHai = mysqli_fetch_array($RSSslrefHai);
          
          $mysqlSLrefBa = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Mar' AND Vung like '".$VungTK."'";
          $RSSslrefBa = mysqli_query($mysqli,$mysqlSLrefBa);
                 $dulieuslREFBa = mysqli_fetch_array($RSSslrefBa);
          
          $mysqlSLrefBon = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Apr' AND Vung like '".$VungTK."'";
          $RSSslrefBon = mysqli_query($mysqli,$mysqlSLrefBon);
                 $dulieuslREFBon = mysqli_fetch_array($RSSslrefBon);
          
          $mysqlSLrefNam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'May' AND Vung like '".$VungTK."'";
          $RSSslrefNam = mysqli_query($mysqli,$mysqlSLrefNam);
                 $dulieuslREFNam = mysqli_fetch_array($RSSslrefNam);
          
          $mysqlSLrefSau = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jun' AND Vung like '".$VungTK."'";
          $RSSslrefSau = mysqli_query($mysqli,$mysqlSLrefSau);
                 $dulieuslREFSau = mysqli_fetch_array($RSSslrefSau);
          
          $mysqlSLrefBay = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jul' AND Vung like '".$VungTK."'";
          $RSSslrefBay = mysqli_query($mysqli,$mysqlSLrefBay);
                 $dulieuslREFBay = mysqli_fetch_array($RSSslrefBay);
          
          $mysqlSLrefTam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Aug' AND Vung like '".$VungTK."'";
          $RSSslrefTam = mysqli_query($mysqli,$mysqlSLrefTam);
                 $dulieuslREFTam = mysqli_fetch_array($RSSslrefTam);
          
          $mysqlSLrefChin = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Sep'";
          $RSSslrefChin = mysqli_query($mysqli,$mysqlSLrefChin);
                 $dulieuslREFChin = mysqli_fetch_array($RSSslrefChin);
          
          $mysqlSLrefMuoi = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Oct' AND Vung like '".$VungTK."'";
          $RSSslrefMuoi = mysqli_query($mysqli,$mysqlSLrefMuoi);
                 $dulieuslREFMuoi = mysqli_fetch_array($RSSslrefMuoi);
          
          $mysqlSLrefMuoiMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Nov' AND Vung like '".$VungTK."'";
          $RSSslrefMuoiMot = mysqli_query($mysqli,$mysqlSLrefMuoiMot);
                 $dulieuslREFMuoiMot = mysqli_fetch_array($RSSslrefMuoiMot);
          
          $mysqlSLrefMuoiHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Dec' AND Vung like '".$VungTK."'";
          $RSSslrefMuoiHai = mysqli_query($mysqli,$mysqlSLrefMuoiHai);
                 $dulieuslREFMuoiHai = mysqli_fetch_array($RSSslrefMuoiHai);
          
          
          //Gia Tien WM
          
          
          $mysqlGTwmMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jan' AND Vung like '".$VungTK."'";
          $RSSgtwmMot = mysqli_query($mysqli,$mysqlGTwmMot);
                 $dulieugtWMMot = mysqli_fetch_array($RSSgtwmMot);
          
          $mysqlGTwmHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Feb' AND Vung like '".$VungTK."'";
          $RSSgtwmHai = mysqli_query($mysqli,$mysqlGTwmHai);
                 $dulieugtWMHai = mysqli_fetch_array($RSSgtwmHai);
          
          $mysqlGTwmBa = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Mar' AND Vung like '".$VungTK."'";
          $RSSgtwmBa = mysqli_query($mysqli,$mysqlGTwmBa);
                 $dulieugtWMBa = mysqli_fetch_array($RSSgtwmBa);
          
          $mysqlGTwmBon = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Apr' AND Vung like '".$VungTK."'";
          $RSSgtwmBon = mysqli_query($mysqli,$mysqlGTwmBon);
                 $dulieugtWMBon = mysqli_fetch_array($RSSgtwmBon);
          
          $mysqlGTwmNam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'May' AND Vung like '".$VungTK."'";
          $RSSgtwmNam = mysqli_query($mysqli,$mysqlGTwmNam);
                 $dulieugtWMNam = mysqli_fetch_array($RSSgtwmNam);
          
          $mysqlGTwmSau = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jun'";
          $RSSgtwmSau = mysqli_query($mysqli,$mysqlGTwmSau);
                 $dulieugtWMSau = mysqli_fetch_array($RSSgtwmSau);
          
          $mysqlGTwmBay = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jul' AND Vung like '".$VungTK."'";
          $RSSgtwmBay = mysqli_query($mysqli,$mysqlGTwmBay);
                 $dulieugtWMBay = mysqli_fetch_array($RSSgtwmBay);
          
          $mysqlGTwmTam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Aug' AND Vung like '".$VungTK."'";
          $RSSgtwmTam = mysqli_query($mysqli,$mysqlGTwmTam);
                 $dulieugtWMTam = mysqli_fetch_array($RSSgtwmTam);
          
          $mysqlGTwmChin = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Sep'";
          $RSSgtwmChin = mysqli_query($mysqli,$mysqlGTwmChin);
                 $dulieugtWMChin = mysqli_fetch_array($RSSgtwmChin);
          
          $mysqlGTwmMuoi = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Oct' AND Vung like '".$VungTK."'";
          $RSSgtwmMuoi = mysqli_query($mysqli,$mysqlGTwmMuoi);
                 $dulieugtWMMuoi = mysqli_fetch_array($RSSgtwmMuoi);
          
          $mysqlGTwmMuoiMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Nov' AND Vung like '".$VungTK."'";
          $RSSgtwmMuoiMot = mysqli_query($mysqli,$mysqlGTwmMuoiMot);
                 $dulieugtWMMuoiMot = mysqli_fetch_array($RSSgtwmMuoiMot);
          
          $mysqlGTwmMuoiHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
          AND Thang like 'Dec' AND Vung like '".$VungTK."'";
          $RSSgtwmMuoiHai = mysqli_query($mysqli,$mysqlGTwmMuoiHai);
                 $dulieugtWMMuoiHai = mysqli_fetch_array($RSSgtwmMuoiHai);
          
          
          //Gia Tien Ref
          
          
          $mysqlGTrefMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jan' AND Vung like '".$VungTK."'";
          $RSSgtrefMot = mysqli_query($mysqli,$mysqlGTrefMot);
          $dulieugtREFMot = mysqli_fetch_array($RSSgtrefMot);
          
          $mysqlGTrefHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Feb' AND Vung like '".$VungTK."'";
          $RSSgtrefHai = mysqli_query($mysqli,$mysqlGTrefHai);
          $dulieugtREFHai = mysqli_fetch_array($RSSgtrefHai);
          
          $mysqlGTrefBa = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Mar' AND Vung like '".$VungTK."'";
          $RSSgtrefBa = mysqli_query($mysqli,$mysqlGTrefBa);
          $dulieugtREFBa = mysqli_fetch_array($RSSgtrefBa);
          
          $mysqlGTrefBon = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Apr' AND Vung like '".$VungTK."'";
          $RSSgtrefBon = mysqli_query($mysqli,$mysqlGTrefBon);
          $dulieugtREFBon = mysqli_fetch_array($RSSgtrefBon);
          
          $mysqlGTrefNam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'May' AND Vung like '".$VungTK."'";
          $RSSgtrefNam = mysqli_query($mysqli,$mysqlGTrefNam);
          $dulieugtREFNam = mysqli_fetch_array($RSSgtrefNam);
          
          $mysqlGTrefSau = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jun' AND Vung like '".$VungTK."'";
          $RSSgtrefSau = mysqli_query($mysqli,$mysqlGTrefSau);
          $dulieugtREFSau = mysqli_fetch_array($RSSgtrefSau);
          
          $mysqlGTrefBay = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Jul'";
          $RSSgtrefBay = mysqli_query($mysqli,$mysqlGTrefBay);
          $dulieugtREFBay = mysqli_fetch_array($RSSgtrefBay);
          
          $mysqlGTrefTam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Aug' AND Vung like '".$VungTK."'";
          $RSSgtrefTam = mysqli_query($mysqli,$mysqlGTrefTam);
          $dulieugtREFTam = mysqli_fetch_array($RSSgtrefTam);
          
          $mysqlGTrefChin = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Sep' AND Vung like '".$VungTK."'";
          $RSSgtrefChin = mysqli_query($mysqli,$mysqlGTrefChin);
          $dulieugtREFChin = mysqli_fetch_array($RSSgtrefChin);
          
          $mysqlGTrefMuoi = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Oct '";
          $RSSgtrefMuoi = mysqli_query($mysqli,$mysqlGTrefMuoi);
          $dulieugtREFMuoi = mysqli_fetch_array($RSSgtrefMuoi);
          
          $mysqlGTrefMuoiMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Nov' AND Vung like '".$VungTK."'";
          $RSSgtrefMuoiMot = mysqli_query($mysqli,$mysqlGTrefMuoiMot);
          $dulieugtREFMuoiMot = mysqli_fetch_array($RSSgtrefMuoiMot);
          
          $mysqlGTrefMuoiHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
          AND Thang like 'Dec' AND Vung like '".$VungTK."'";
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
                  
                $mysqlMDwm = "SELECT Nam,Vung,Model,COUNT(*) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
                 AND Vung like '".$VungTK."'GROUP BY Model";
          
                $RSSmdWM = mysqli_query($mysqli,$mysqlMDwm);
                              if(mysqli_num_rows($RSSmdWM)>0){
                                while($Mdtkwm = mysqli_fetch_array($RSSmdWM)){
                                  $dataMDwmtk[] = $Mdtkwm;                  
                                   }    
                              }else{
                                echo'Đã xảy ra lỗi hoặc chưa tổng hợp dữ liệu, mời chọn lại';
                                   exit();
                               }
          
                $mysqlMDref = "SELECT Nam,Vung,Model,COUNT(*) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
                AND Vung like '".$VungTK."' GROUP BY Model";
                
                $RSSmdREF = mysqli_query($mysqli,$mysqlMDref);
                              if(mysqli_num_rows($RSSmdREF)>0){
                                while($Mdtkref = mysqli_fetch_array($RSSmdREF)){
                                  $dataMDreftk[] = $Mdtkref;                  
                                   }    
                              }else{
                                echo'Đã xảy ra lỗi hoặc chưa tổng hợp dữ liệu, mời chọn lại';
                                   exit();
                               }
          
                               
                             
               
                
         // Tính cả năm
         
   
  
      }else{
         $a++;
          
         
     
                  
                                       // năm và tháng 
                $VungmdWM ="SELECT * FROM modelvungwm where NamVMD like '%".$NamTK."%' 
   AND ThangVMD like '%".$ThangTK."%' AND VungMDwm like '%".$VungTK."%'";

             $KQvungmdWM = mysqli_query($mysqli,$VungmdWM);
                   if(mysqli_num_rows($KQvungmdWM)>0){
                     while($modelvungwm = mysqli_fetch_array($KQvungmdWM)){
                      $dataMDVwm[] = $modelvungwm;
                        
                        }
                            
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" vùng "'.$VungTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                        exit();
                    }
                    
                    
     
   $VungmdREF ="SELECT * FROM modelvref where NamvMDref like '%".$NamTK."%' 
   AND ThangvMDref like '%".$ThangTK."%' AND VungMDref like '%".$VungTK."%'";
                
   $KQvungmdREF = mysqli_query($mysqli,$VungmdREF);
                   if(mysqli_num_rows($KQvungmdREF)>0){
                     while($modelvungref = mysqli_fetch_array($KQvungmdREF)){
                      $dataMDVref[] = $modelvungref; 
                                         
                       }
                                    
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" vùng "'.$VungTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                       exit();
                    }
                    
   $Vungslwm ="SELECT * FROM soluongvwm where Namslvwm = $NamTK
   AND Thangslvwm = '$ThangTK'";
                                 
             $KQVungslwm = mysqli_query($mysqli,$Vungslwm);
                   if(mysqli_num_rows($KQVungslwm)>0){
                     while($SLvwm = mysqli_fetch_array($KQVungslwm)){
                         $Namslvwm = $SLvwm['Namslvwm'];
                         $Thangslvwm = $SLvwm['Thangslvwm'];
                         $SLsanphamvwm = $SLvwm['SoLuongvwm'];
                                                          
                       }
                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" vùng "'.$VungTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                       exit();
                   }
   $Vungslref ="SELECT * FROM soluongvref where Namvref = $NamTK 
   AND Thangvref = '$ThangTK'";
                                                 
             $KQvungslref = mysqli_query($mysqli,$Vungslref);
                   if(mysqli_num_rows($KQvungslref)>0){
                     while($SLvref = mysqli_fetch_array($KQvungslref)){
                           $Namslvref = $SLvref['Namvref'];
                           $Thangslvref = $SLvref['Thangvref'];
                           $SLsanphamvref = $SLvref['SoLuongref'];
                                                                          
                       }
                                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" vùng "'.$VungTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                       exit();
                   }
   $VungTienwm ="SELECT * FROM giatienvwm where NamGTVwm like '%".$NamTK."%' 
   AND ThangGTVwm like '%".$ThangTK."%'";
                                 
             $KQGTvungwm = mysqli_query($mysqli,$VungTienwm);
                   if(mysqli_num_rows($KQGTvungwm)>0){
                     while($GTvwm = mysqli_fetch_array($KQGTvungwm)){
                         $NamGTvwm = $GTvwm['NamGTVwm'];
                         $ThangGTvwm = $GTvwm['ThangGTVwm'];
                        $GTsanphamvwm = $GTvwm['GiaTienVwm'];
                                                          
                       }
                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" vùng "'.$VungTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                       exit();
                   }
   $VungTienref ="SELECT * FROM giatienvref where NamGTref like '%".$NamTK."%' 
   AND ThangGTref like '%".$ThangTK."%'";
                                                 
   $KQGTvungref = mysqli_query($mysqli,$VungTienref);
                   if(mysqli_num_rows($KQGTvungref)>0){
                      while($GTvref = mysqli_fetch_array($KQGTvungref)){
                          $NamGTvref = $GTvref['NamGTref'];
                          $ThangGTvref = $GTvref['ThangGTref'];
                         $GTsanphamvref = $GTvref['GiaTienref'];
                                                                          
                       }
                                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" vùng "'.$VungTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
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
  <link rel="stylesheet" href="../css/time.css">

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
    <!-- Bộ lọc -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
  <title>Thống Kê Theo Vùng</title>

  <script class="chinhscrip" type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['ModelMD', 'SoLuongMD'],
         

         <?php
         if($n>0){

          foreach($dataMDwmtk as $keyba){
            echo "['".$keyba['Model']."',".$keyba['COUNT(*)']."],"; 
  
           }

         }elseif($a>0){

          foreach($dataMDVwm as $keybon){
            echo "['".$keybon['ModelVungwm']."',".$keybon['DemModel']."],"; 
  
           }

         }
         
         ?>
        ]);
       
        var options = {
          title:
            <?php
             if($n>0){
                echo "'Biểu đồ model WM năm ".$NamTK." vùng ".$VungTK."'";
                }elseif($a>0){
                  echo "'Biểu đồ model WM Vùng ".$VungTK." tháng ".$ThangTK."'";
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
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php
           if($n>0){

            foreach($dataMDreftk as $keykey){
              echo "['".$keykey['Model']."',".$keykey['COUNT(*)']."],"; 
    
             }
  
           }elseif($a>0){

            foreach($dataMDVref as $keyn){
              echo "['".$keyn['ModelvMDref']."',".$keyn['DemMDref']."],"; 
    
             }
  
           }

         
         
         ?>
        ]);

        var options = {
          title: <?php
             if($n>0){
                 echo "'Biểu đồ model REF năm ".$NamTK." vùng ".$VungTK."'";
                 }elseif($a>0){
                  echo "'Biểu đồ model REF Vùng ".$VungTK." tháng ".$ThangTK."'";
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
             echo "['".$Thangslwm."',".$SLsanphamvwm.",".$GTsanphamvwm."],"; 
          }
          
          
          ?>
         
        ]);

        var materialOptions = {
          width: 450,
          chart: {
            title:
            <?php
             if($a>0){
             echo "'(WM) tháng ".$Thangslwm." năm ".$Namslwm." vùng ".$VungTK."'";
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
             echo "['".$Thangslvref."',".$SLsanphamvref.",".$GTsanphamvref."],"; 
          }
          
          ?>
         
        ]);

        var materialOptions = {
          width: 450,
          chart: {
            title:
            <?php
             if($a>0){
             echo "' (REF) tháng ".$ThangTK." năm ".$NamTK." vùng ".$VungTK."'";
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
                echo "'Biểu đồ cột WM năm ".$NamTK." vùng ".$VungTK."'";
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
                echo "'Biểu đồ cột WM năm ".$NamTK." vùng ".$VungTK."'";
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
                       <select name="VungTK" id="VungTK" class="chinhboloc" required>
                           <span class="TuyChinh">&#8744;</span>
                        <option value="">Chọn Vùng: </option>
                        <?php
                         foreach($KQTuyChonVung as $ChonVung){

                         echo '<option class="optionloc" value="'.$ChonVung["Vung"].'">'.$ChonVung["Vung"].'</option>'; 
                          }
                        ?>
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
   <h1>Thống Kê Theo Vùng...! </h1>
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