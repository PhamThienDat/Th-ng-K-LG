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
$TuyChonMaCH = "SELECT DISTINCT MaCH FROM thongke WHERE Loai ='WM'";
$KQTuyChonMaCH = mysqli_query($mysqli,$TuyChonMaCH);
if(mysqli_num_rows($KQTuyChonMaCH)>0){
    $ChonMaCH = mysqli_fetch_array($KQTuyChonMaCH);
}else{
         echo'Đã xảy ra lỗi, mời chọn lại';
         exit();
}
$n=0; $a=0; $b=0; $c=0;$k=0;
$dataTK = [];  $datatwoTK = [];  $dataMDwmtk = [];  $dataMDreftk = []; $dataTKslwm = []; $dataTKslref = []; $dataTKgtwm = []; $dataTKgtref = [];
$dataMDVwm = []; $dataMDVref = [];

if(isset($_POST['submit'])){
    $NamTK= $_POST['NamTK'];
    $ThangTK = $_POST['ThangTK'];
      $MaCHTK = $_POST['MaCHTK'];
    // Truy vấn lấy dữ liệu
    
     
    $NamTK= $_POST['NamTK'];
    $ThangTK = $_POST['ThangTK'];
      $MaCHTK = $_POST['MaCHTK'];
  // Truy vấn lấy dữ liệu
           
  $sqlloaimot = "SELECT Nam,Thang,MaCH,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
  AND Thang like '%".$ThangTK."%' AND MaCH like '%".$MaCHTK."%'";

  $sqlGTWM = "SELECT Nam,Thang,MaCH,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
  AND Thang like '%".$ThangTK."%' AND MaCH like '%".$MaCHTK."%'";

  $sqlModelmot = "SELECT Nam,Thang,Model,MaCH,COUNT(*) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
  AND Thang like '%".$ThangTK."%' AND MaCH like '%".$MaCHTK."%' GROUP BY Model";



//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

  $KQGTWM = mysqli_query($mysqli,$sqlGTWM);
  $dataGTWM = mysqli_fetch_array($KQGTWM);
    $NamGTwm = $dataGTWM['Nam'];
     $ThangGTwm = $dataGTWM['Thang'];
    $MaCHGTwm = $dataGTWM['MaCH'];
    $GiaTien= $dataGTWM['SUM(GiaTien)'];

//KT trùng   
  $thucthiGT = mysqli_query($mysqli,"SELECT * FROM moneymchwm WHERE NamMCHGTwm like '%".$NamGTwm."%'
  AND ThangMCHGTwm like '%".$ThangGTwm."%' AND MaCHGTwm like '%".$MaCHGTwm."%' AND GTMaCHwm like '%".$GiaTien."%'");

  if(!$thucthiGT || mysqli_num_rows($thucthiGT)>0){
    echo '';
  }else{

  
   $ThongKeGTMot ="INSERT INTO moneymchwm(NamMCHGTwm,ThangMCHGTwm,MaCHGTwm,GTMaCHwm) VALUES($NamGTwm,'$ThangGTwm','$MaCHGTwm',$GiaTien)";
    mysqli_query($mysqli,$ThongKeGTMot);
    echo'';
  
  }
//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

  $KQLoaimot = mysqli_query($mysqli,$sqlloaimot);
  $dataLoaimot = mysqli_fetch_array($KQLoaimot);
  $Namslwm = $dataLoaimot['Nam'];
  $Thangslwm = $dataLoaimot['Thang'];
  $MaCHslwm = $dataGTWM['MaCH'];
  $SoLuongslwm= $dataLoaimot['SUM(SoLuong)'];

//KT trùng

  $thucthiSLwm = mysqli_query($mysqli,"SELECT * FROM qtymachwm WHERE NamslMCHwm like '%".$Namslwm."%'
  AND ThangslMCHwm like '%".$Thangslwm."%' AND MaCHslwm like '%".$MaCHslwm."%' AND SoLuongMaCHwm like '%".$SoLuongslwm."%'");

  if(!$thucthiSLwm || mysqli_num_rows($thucthiSLwm)>0){
   echo '';
  }else{
    $ThongKeSLMot ="INSERT INTO qtymachwm(NamslMCHwm,ThangslMCHwm,MaCHslwm,SoLuongMaCHwm) VALUES($Namslwm,'$Thangslwm','$MaCHslwm',$SoLuongslwm)";
    mysqli_query($mysqli,$ThongKeSLMot);
    echo'';
  }
//Lấy mảng dữ liệu từ câu truy vấn(Vì trả về 1 mảng nhiều model)

  $KQModelmot = mysqli_query($mysqli,$sqlModelmot);
  while($dataModelmot = mysqli_fetch_array($KQModelmot)){
       $SaveNamwm = $dataModelmot['Nam'];
       $SaveThangwm = $dataModelmot['Thang'];
       $SaveMDwm = $dataModelmot['Model'];
       $SaveMACH = $dataModelmot['MaCH'];
       $SaveMDMCwm = $dataModelmot['COUNT(*)'];

//KT trùng

       $thucthiMDwm = mysqli_query($mysqli,"SELECT * FROM modelmchwm WHERE NamMDMCHwm like '%".$SaveNamwm."%'
      AND ThangMDMCHwm like '%".$SaveThangwm."%' AND ModelMCHwm like '%".$SaveMDwm."%'
      AND MDMCHwm like '%".$SaveMACH."%'
      AND SoLuongMCHwm like '%".$SaveMDMCwm."%'");
  
      if(!$thucthiMDwm || mysqli_num_rows($thucthiMDwm)>0){
        echo '';
      }else{

      $ThongKeMDMot ="INSERT INTO modelmchwm(NamMDMCHwm,ThangMDMCHwm,ModelMCHwm,MDMCHwm,SoLuongMCHwm) VALUES($SaveNamwm,'$SaveThangwm','$SaveMDwm','$SaveMACH',$SaveMDMCwm)";
      mysqli_query($mysqli,$ThongKeMDMot);
      
       echo'';
      
      }
      
  }

           


      if(!empty($_POST['NamTK']) && empty($_POST['ThangTK']) && !empty($_POST['MaCHTK'])){
          $n++;
         // Tính cả năm
         $mysqlSLwmMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan' AND MaCH like '".$MaCHTK."'";
         $RSSslwmMot = mysqli_query($mysqli,$mysqlSLwmMot);
         $dulieuslWMMot = mysqli_fetch_array($RSSslwmMot);
         
         $mysqlSLwmHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb' AND MaCH like '".$MaCHTK."'";
         $RSSslwmHai = mysqli_query($mysqli,$mysqlSLwmHai);
         $dulieuslWMHai = mysqli_fetch_array($RSSslwmHai);
         
         $mysqlSLwmBa = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar' AND MaCH like '".$MaCHTK."'";
         $RSSslwmBa = mysqli_query($mysqli,$mysqlSLwmBa);
         $dulieuslWMBa = mysqli_fetch_array($RSSslwmBa);
         
         $mysqlSLwmBon = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr' AND MaCH like '".$MaCHTK."'";
         $RSSslwmBon = mysqli_query($mysqli,$mysqlSLwmBon);
         $dulieuslWMBon = mysqli_fetch_array($RSSslwmBon);
         
         $mysqlSLwmNam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'May' AND MaCH like '".$MaCHTK."'";
         $RSSslwmNam = mysqli_query($mysqli,$mysqlSLwmNam);
         $dulieuslWMNam = mysqli_fetch_array($RSSslwmNam);
         
         $mysqlSLwmSau = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun' AND MaCH like '".$MaCHTK."'";
         $RSSslwmSau = mysqli_query($mysqli,$mysqlSLwmSau);
         $dulieuslWMSau = mysqli_fetch_array($RSSslwmSau);
         
         $mysqlSLwmBay = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul' AND MaCH like '".$MaCHTK."'";
         $RSSslwmBay = mysqli_query($mysqli,$mysqlSLwmBay);
         $dulieuslWMBay = mysqli_fetch_array($RSSslwmBay);
         
         $mysqlSLwmTam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug' AND MaCH like '".$MaCHTK."'";
         $RSSslwmTam = mysqli_query($mysqli,$mysqlSLwmTam);
         $dulieuslWMTam = mysqli_fetch_array($RSSslwmTam);
         
         $mysqlSLwmChin = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep' AND MaCH like '".$MaCHTK."'";
         $RSSslwmChin = mysqli_query($mysqli,$mysqlSLwmChin);
         $dulieuslWMChin = mysqli_fetch_array($RSSslwmChin);
         
         $mysqlSLwmMuoi = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct'";
         $RSSslwmMuoi = mysqli_query($mysqli,$mysqlSLwmMuoi);
         $dulieuslWMMuoi = mysqli_fetch_array($RSSslwmMuoi);
         
         $mysqlSLwmMuoiMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov' AND MaCH like '".$MaCHTK."'";
         $RSSslwmMuoiMot = mysqli_query($mysqli,$mysqlSLwmMuoiMot);
         $dulieuslWMMuoiMot = mysqli_fetch_array($RSSslwmMuoiMot);
         
         $mysqlSLwmMuoiHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec' AND MaCH like '".$MaCHTK."'";
         $RSSslwmMuoiHai = mysqli_query($mysqli,$mysqlSLwmMuoiHai);
         $dulieuslWMMuoiHai = mysqli_fetch_array($RSSslwmMuoiHai);
         
         
         
         
         
         
         //Gia Tien WM
         
         
         $mysqlGTwmMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmMot = mysqli_query($mysqli,$mysqlGTwmMot);
                $dulieugtWMMot = mysqli_fetch_array($RSSgtwmMot);
         
         $mysqlGTwmHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmHai = mysqli_query($mysqli,$mysqlGTwmHai);
                $dulieugtWMHai = mysqli_fetch_array($RSSgtwmHai);
         
         $mysqlGTwmBa = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmBa = mysqli_query($mysqli,$mysqlGTwmBa);
                $dulieugtWMBa = mysqli_fetch_array($RSSgtwmBa);
         
         $mysqlGTwmBon = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmBon = mysqli_query($mysqli,$mysqlGTwmBon);
                $dulieugtWMBon = mysqli_fetch_array($RSSgtwmBon);
         
         $mysqlGTwmNam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'May' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmNam = mysqli_query($mysqli,$mysqlGTwmNam);
                $dulieugtWMNam = mysqli_fetch_array($RSSgtwmNam);
         
         $mysqlGTwmSau = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmSau = mysqli_query($mysqli,$mysqlGTwmSau);
                $dulieugtWMSau = mysqli_fetch_array($RSSgtwmSau);
         
         $mysqlGTwmBay = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmBay = mysqli_query($mysqli,$mysqlGTwmBay);
                $dulieugtWMBay = mysqli_fetch_array($RSSgtwmBay);
         
         $mysqlGTwmTam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmTam = mysqli_query($mysqli,$mysqlGTwmTam);
                $dulieugtWMTam = mysqli_fetch_array($RSSgtwmTam);
         
         $mysqlGTwmChin = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmChin = mysqli_query($mysqli,$mysqlGTwmChin);
                $dulieugtWMChin = mysqli_fetch_array($RSSgtwmChin);
         
         $mysqlGTwmMuoi = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmMuoi = mysqli_query($mysqli,$mysqlGTwmMuoi);
                $dulieugtWMMuoi = mysqli_fetch_array($RSSgtwmMuoi);
         
         $mysqlGTwmMuoiMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmMuoiMot = mysqli_query($mysqli,$mysqlGTwmMuoiMot);
                $dulieugtWMMuoiMot = mysqli_fetch_array($RSSgtwmMuoiMot);
         
         $mysqlGTwmMuoiHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec' AND MaCH like '".$MaCHTK."'";
         $RSSgtwmMuoiHai = mysqli_query($mysqli,$mysqlGTwmMuoiHai);
                $dulieugtWMMuoiHai = mysqli_fetch_array($RSSgtwmMuoiHai);
         
         
         //Gia Tien Ref
         
         
         
         
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
                
                  
         
               $mysqlMDwm = "SELECT Nam,MaCH,Model,COUNT(*) FROM thongke WHERE Loai = 'WM' AND Nam like '%".$NamTK."%'
               AND MaCH like '".$MaCHTK."' GROUP BY Model";
         
               $RSSmdWM = mysqli_query($mysqli,$mysqlMDwm);
                             if(mysqli_num_rows($RSSmdWM)>0){
                               while($Mdtkwm = mysqli_fetch_array($RSSmdWM)){
                                 $dataMDwmtk[] = $Mdtkwm;                  
                                  }    
                             }else{
                               echo'Đã xảy ra lỗi hoặc chưa import excel năm "'.$NamTK.'", mời chọn lại hoặc liên hệ quản trị hệ thống';
                                  exit();
                              }
         
              
   
  
         
   
  
      }else{
        $b++;
 
    $datamchTK = [];
    $NgayThangmch ="SELECT * FROM modelmchwm where NamMDMCHwm like '%".$NamTK."%' 
    AND ThangMDMCHwm like '%".$ThangTK."%' AND MDMCHwm like '%".$MaCHTK."%'";
     
              $KQmch = mysqli_query($mysqli,$NgayThangmch);
                    if(mysqli_num_rows($KQmch)>0){
                      while($mchTK = mysqli_fetch_array($KQmch)){
                        $datamchTK[] = $mchTK; 
                         }
                        
                          
                    }else{
                      echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" mã CH "'.$MaCHTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                         exit();
                     }
        $NgayThangmchmot ="SELECT * FROM qtymachwm where NamslMCHwm like '%".$NamTK."%' 
         AND ThangslMCHwm like '%".$ThangTK."%' AND MaCHslwm like '%".$MaCHTK."%'";
                                 
         $KQmchmot = mysqli_query($mysqli,$NgayThangmchmot);
                   if(mysqli_num_rows($KQmchmot)>0){
                     while($GTvwm = mysqli_fetch_array($KQmchmot)){
                         $Namgtvwm = $GTvwm['NamslMCHwm'];
                         $Thangtvwm = $GTvwm['ThangslMCHwm'];
                         $SLsanphamgtwm = $GTvwm['SoLuongMaCHwm'];
                                                          
                       }
                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" mã CH "'.$MaCHTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                       exit();
                   }
    $NgayThangmchhai ="SELECT * FROM moneymchwm where NamMCHGTwm like '%".$NamTK."%' 
         AND ThangMCHGTwm like '%".$ThangTK."%' AND MaCHGTwm like '%".$MaCHTK."%'";
                                 
         $KQmchhai = mysqli_query($mysqli,$NgayThangmchhai);
                   if(mysqli_num_rows($KQmchhai)>0){
                     while($SLvwm = mysqli_fetch_array($KQmchhai)){
                         $Namslvwm = $SLvwm['NamMCHGTwm'];
                         $Thanslvwm = $SLvwm['ThangMCHGTwm'];
                         $SLsanphamslwm = $SLvwm['GTMaCHwm'];
                                                          
                       }
                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" mã CH "'.$MaCHTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
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
  <link rel="stylesheet" href="../css/thongkemch.css">

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    
    <!-- Bộ lọc -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <!-- icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
  <title>Thống Kê WM</title>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php
         if($b>0){

          foreach($datamchTK as $keyhai){
            echo "['".$keyhai['ModelMCHwm']."',".$keyhai['SoLuongMCHwm']."],"; 
  
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
            if($b>0){
              echo "'Biểu đồ model WM mã CH: ".$MaCHTK."'";
              }elseif($n>0){
                echo "'Biểu đồ model WM năm ".$NamTK."'";
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

        var button = document.getElementById('change-chartt');
        var chartDiv = document.getElementById('chart_divv');

        var data = google.visualization.arrayToDataTable([
          ['Bảng Thống Kê LG', 'Số Lượng', 'Giá Tiền'],
          
          <?php
           if($b>0){
             echo "['".$Thangtvwm."',".$SLsanphamgtwm.",".$SLsanphamslwm."],"; 
          }
         
          ?>
         
        ]);

        var materialOptions = {
          width: 450,
          chart: {
            title:
            <?php
             if($b>0){
             echo "' (REF) tháng ".$ThangTK." năm ".$NamTK." mã CH: ".$MaCHTK."'";
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

        var button = document.getElementById('change-chartttt');
        var chartDiv = document.getElementById('chart_divvvv');

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
            title: 'Nearby galaxies',title: <?php
              if($n>0){
                echo "'Biểu đồ cột REF năm ".$NamTK." mã CH: ".$MaCHTK."'";
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
                       <select name="MaCHTK" id="MaCHTK" class="chinhboloc" required>
                           <span class="TuyChinh">&#8744;</span>
                        <option value="">Chọn Mã Cửa Hàng WM: </option>
                        <?php
                         foreach($KQTuyChonMaCH as $ChonMaCH){

                         echo '<option class="optionloc" value="'.$ChonMaCH["MaCH"].'">'.$ChonMaCH["MaCH"].'</option>'; 
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
   <h1>Thống Kê Theo Mã Cửa Hàng WM...! </h1>
 </div>
  
  
 <button class="chinhchangee" id="change-chartt">Change to Classic</button>
 <div class="row" style=" display: flex;">
     <div id="chart_divv" ></div>
    <div id="donutchart" ></div>
    </div>
    

    
    <div class="cotdoc">
      
      <div class="PThai">
      <button id="change-chartttt">Change to Classic</button>
     <div id="chart_divvvv" style="width: 800px; height: 500px;"></div>
      </div>
    </div>
    
  
 
  
</body>
</html>