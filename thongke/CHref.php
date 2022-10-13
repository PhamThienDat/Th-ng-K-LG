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
$TuyChonMaCHref = "SELECT DISTINCT MaCH FROM thongke WHERE Loai ='REF'";
$KQTuyChonMaCHref = mysqli_query($mysqli,$TuyChonMaCHref);
if(mysqli_num_rows($KQTuyChonMaCHref)>0){
    $ChonMaCHref = mysqli_fetch_array($KQTuyChonMaCHref);
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
           $sqlloaimot = "SELECT Nam,Thang,MaCH,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
           AND Thang like '%".$ThangTK."%' AND MaCH like '%".$MaCHTK."%'";

           $sqlGTWM = "SELECT Nam,Thang,MaCH,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
           AND Thang like '%".$ThangTK."%' AND MaCH like '%".$MaCHTK."%'";

           $sqlModelmot = "SELECT Nam,Thang,Model,MaCH,COUNT(*) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
           AND Thang like '%".$ThangTK."%' AND MaCH like '%".$MaCHTK."%' GROUP BY Model";

         

//Lấy dữ liệu từ câu truy vấn(Vì trả về 1 bản ghi)

           $KQGTWM = mysqli_query($mysqli,$sqlGTWM);
           $dataGTWM = mysqli_fetch_array($KQGTWM);
             $NamGTwm = $dataGTWM['Nam'];
              $ThangGTwm = $dataGTWM['Thang'];
             $MaCHGTwm = $dataGTWM['MaCH'];
             $GiaTien= $dataGTWM['SUM(GiaTien)'];

//KT trùng   
           $thucthiGT = mysqli_query($mysqli,"SELECT * FROM moneymchref WHERE NamMCHGTref like '%".$NamGTwm."%'
           AND ThangMCHGTref like '%".$ThangGTwm."%' AND MaCHGTref like '%".$MaCHGTwm."%' AND GTMaCHref like '%".$GiaTien."%'");

           if(!$thucthiGT || mysqli_num_rows($thucthiGT)>0){
             echo '';
           }else{

           
            $ThongKeGTMot ="INSERT INTO moneymchref(NamMCHGTref,ThangMCHGTref,MaCHGTref,GTMaCHref) VALUES($NamGTwm,'$ThangGTwm','$MaCHGTwm',$GiaTien)";
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

           $thucthiSLwm = mysqli_query($mysqli,"SELECT * FROM qtymachref WHERE NamslMCHref like '%".$Namslwm."%'
           AND ThangslMCHref like '%".$Thangslwm."%' AND MaCHslref like '%".$MaCHslwm."%' AND SoLuongMaCHref like '%".$SoLuongslwm."%'");

           if(!$thucthiSLwm || mysqli_num_rows($thucthiSLwm)>0){
            echo '';
           }else{
             $ThongKeSLMot ="INSERT INTO qtymachref(NamslMCHref,ThangslMCHref,MaCHslref,SoLuongMaCHref) VALUES($Namslwm,'$Thangslwm','$MaCHslwm',$SoLuongslwm)";
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

                $thucthiMDwm = mysqli_query($mysqli,"SELECT * FROM modelmchref WHERE NamMDMCHref like '%".$SaveNamwm."%'
               AND ThangMDMCHref like '%".$SaveThangwm."%' AND ModelMCHref like '%".$SaveMDwm."%'
               AND MDMCHref like '%".$SaveMACH."%'
               AND SoLuongMCHref like '%".$SaveMDMCwm."%'");
           
               if(!$thucthiMDwm || mysqli_num_rows($thucthiMDwm)>0){
                 echo '';
               }else{

               $ThongKeMDMot ="INSERT INTO modelmchref(NamMDMCHref,ThangMDMCHref,ModelMCHref,MDMCHref,SoLuongMCHref) VALUES($SaveNamwm,'$SaveThangwm','$SaveMDwm','$SaveMACH',$SaveMDMCwm)";
               mysqli_query($mysqli,$ThongKeMDMot);
               
                echo'';
               
               }
               
           }

           


      if(!empty($_POST['NamTK']) && empty($_POST['ThangTK']) && !empty($_POST['MaCHTK'])){
          $n++;
         // Tính cả năm
         
         //Số Lượng ref 1-12
         
         $mysqlSLrefMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan' AND MaCH like '".$MaCHTK."'";
         $RSSslrefMot = mysqli_query($mysqli,$mysqlSLrefMot);
                $dulieuslREFMot = mysqli_fetch_array($RSSslrefMot);
         
         $mysqlSLrefHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb' AND MaCH like '".$MaCHTK."'";
         $RSSslrefHai = mysqli_query($mysqli,$mysqlSLrefHai);
                $dulieuslREFHai = mysqli_fetch_array($RSSslrefHai);
         
         $mysqlSLrefBa = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar' AND MaCH like '".$MaCHTK."'";
         $RSSslrefBa = mysqli_query($mysqli,$mysqlSLrefBa);
                $dulieuslREFBa = mysqli_fetch_array($RSSslrefBa);
         
         $mysqlSLrefBon = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr' AND MaCH like '".$MaCHTK."'";
         $RSSslrefBon = mysqli_query($mysqli,$mysqlSLrefBon);
                $dulieuslREFBon = mysqli_fetch_array($RSSslrefBon);
         
         $mysqlSLrefNam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'May' AND MaCH like '".$MaCHTK."'";
         $RSSslrefNam = mysqli_query($mysqli,$mysqlSLrefNam);
                $dulieuslREFNam = mysqli_fetch_array($RSSslrefNam);
         
         $mysqlSLrefSau = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun' AND MaCH like '".$MaCHTK."'";
         $RSSslrefSau = mysqli_query($mysqli,$mysqlSLrefSau);
                $dulieuslREFSau = mysqli_fetch_array($RSSslrefSau);
         
         $mysqlSLrefBay = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul' AND MaCH like '".$MaCHTK."'";
         $RSSslrefBay = mysqli_query($mysqli,$mysqlSLrefBay);
                $dulieuslREFBay = mysqli_fetch_array($RSSslrefBay);
         
         $mysqlSLrefTam = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug' AND MaCH like '".$MaCHTK."'";
         $RSSslrefTam = mysqli_query($mysqli,$mysqlSLrefTam);
                $dulieuslREFTam = mysqli_fetch_array($RSSslrefTam);
         
         $mysqlSLrefChin = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep' AND MaCH like '".$MaCHTK."'";
         $RSSslrefChin = mysqli_query($mysqli,$mysqlSLrefChin);
                $dulieuslREFChin = mysqli_fetch_array($RSSslrefChin);
         
         $mysqlSLrefMuoi = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct' AND MaCH like '".$MaCHTK."'";
         $RSSslrefMuoi = mysqli_query($mysqli,$mysqlSLrefMuoi);
                $dulieuslREFMuoi = mysqli_fetch_array($RSSslrefMuoi);
         
         $mysqlSLrefMuoiMot = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov' AND MaCH like '".$MaCHTK."'";
         $RSSslrefMuoiMot = mysqli_query($mysqli,$mysqlSLrefMuoiMot);
                $dulieuslREFMuoiMot = mysqli_fetch_array($RSSslrefMuoiMot);
         
         $mysqlSLrefMuoiHai = "SELECT Nam,Thang,SUM(SoLuong) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec' AND MaCH like '".$MaCHTK."'";
         $RSSslrefMuoiHai = mysqli_query($mysqli,$mysqlSLrefMuoiHai);
                $dulieuslREFMuoiHai = mysqli_fetch_array($RSSslrefMuoiHai);
         
         
         //Gia Tien WM
         
         
         
         //Gia Tien Ref
         
         
         $mysqlGTrefMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jan' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefMot = mysqli_query($mysqli,$mysqlGTrefMot);
         $dulieugtREFMot = mysqli_fetch_array($RSSgtrefMot);
         
         $mysqlGTrefHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Feb' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefHai = mysqli_query($mysqli,$mysqlGTrefHai);
         $dulieugtREFHai = mysqli_fetch_array($RSSgtrefHai);
         
         $mysqlGTrefBa = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Mar' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefBa = mysqli_query($mysqli,$mysqlGTrefBa);
         $dulieugtREFBa = mysqli_fetch_array($RSSgtrefBa);
         
         $mysqlGTrefBon = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Apr' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefBon = mysqli_query($mysqli,$mysqlGTrefBon);
         $dulieugtREFBon = mysqli_fetch_array($RSSgtrefBon);
         
         $mysqlGTrefNam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'May' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefNam = mysqli_query($mysqli,$mysqlGTrefNam);
         $dulieugtREFNam = mysqli_fetch_array($RSSgtrefNam);
         
         $mysqlGTrefSau = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jun' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefSau = mysqli_query($mysqli,$mysqlGTrefSau);
         $dulieugtREFSau = mysqli_fetch_array($RSSgtrefSau);
         
         $mysqlGTrefBay = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Jul' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefBay = mysqli_query($mysqli,$mysqlGTrefBay);
         $dulieugtREFBay = mysqli_fetch_array($RSSgtrefBay);
         
         $mysqlGTrefTam = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Aug' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefTam = mysqli_query($mysqli,$mysqlGTrefTam);
         $dulieugtREFTam = mysqli_fetch_array($RSSgtrefTam);
         
         $mysqlGTrefChin = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Sep'";
         $RSSgtrefChin = mysqli_query($mysqli,$mysqlGTrefChin);
         $dulieugtREFChin = mysqli_fetch_array($RSSgtrefChin);
         
         $mysqlGTrefMuoi = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Oct ' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefMuoi = mysqli_query($mysqli,$mysqlGTrefMuoi);
         $dulieugtREFMuoi = mysqli_fetch_array($RSSgtrefMuoi);
         
         $mysqlGTrefMuoiMot = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Nov' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefMuoiMot = mysqli_query($mysqli,$mysqlGTrefMuoiMot);
         $dulieugtREFMuoiMot = mysqli_fetch_array($RSSgtrefMuoiMot);
         
         $mysqlGTrefMuoiHai = "SELECT Nam,Thang,SUM(GiaTien) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
         AND Thang like 'Dec' AND MaCH like '".$MaCHTK."'";
         $RSSgtrefMuoiHai = mysqli_query($mysqli,$mysqlGTrefMuoiHai);
         $dulieugtREFMuoiHai = mysqli_fetch_array($RSSgtrefMuoiHai);
         
               
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
                  
         
              
         
               $mysqlMDref = "SELECT Nam,MaCH,Model,COUNT(*) FROM thongke WHERE Loai = 'REF' AND Nam like '%".$NamTK."%'
               AND MaCH like '".$MaCHTK."' GROUP BY Model";
               
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
        $c++;

        $datamchrefTK = [];
        $NgayThangmchref ="SELECT * FROM modelmchref where NamMDMCHref = $NamTK 
        AND ThangMDMCHref = '$ThangTK' AND MDMCHref = '$MaCHTK'";
         
                  $KQmchref = mysqli_query($mysqli,$NgayThangmchref);
                        if(mysqli_num_rows($KQmchref)>0){
                          while($mchTKref = mysqli_fetch_array($KQmchref)){
                            $datamchrefTK[] = $mchTKref; 
                             }
                            
                              
                        }else{
                            echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" mã CH "'.$MaCHTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                             exit();
                         }
        $NgayThangmchrefhai ="SELECT * FROM qtymachref where NamslMCHref like '%".$NamTK."%' 
         AND ThangslMCHref like '%".$ThangTK."%' AND MaCHslref like '%".$MaCHTK."%'";
                                 
         $KQmchrefhai = mysqli_query($mysqli,$NgayThangmchrefhai);
                   if(mysqli_num_rows($KQmchrefhai)>0){
                     while($GTvwm = mysqli_fetch_array($KQmchrefhai)){
                         $Namgtvwm = $GTvwm['NamslMCHref'];
                         $Thangtvwm = $GTvwm['ThangslMCHref'];
                         $SLsanphamgtwm = $GTvwm['SoLuongMaCHref'];
                                                          
                       }
                                                     
                   }else{
                    echo'Đã xảy ra lỗi hoặc chưa import excel tháng"'.$ThangTK.'" năm "'.$NamTK.'" mã CH "'.$MaCHTK.'", mời chọn lại hoặc liên hệ với quản trị hệ thống';
                       exit();
                   }
    $NgayThangmchhai ="SELECT * FROM moneymchref where NamMCHGTref like '%".$NamTK."%' 
         AND ThangMCHGTref like '%".$ThangTK."%' AND MaCHGTref like '%".$MaCHTK."%'";
                                 
         $KQmchhai = mysqli_query($mysqli,$NgayThangmchhai);
                   if(mysqli_num_rows($KQmchhai)>0){
                     while($SLvwm = mysqli_fetch_array($KQmchhai)){
                         $Namslvwm = $SLvwm['NamMCHGTref'];
                         $Thanslvwm = $SLvwm['ThangMCHGTref'];
                         $SLsanphamslwm = $SLvwm['GTMaCHref'];
                                                          
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
  <title>Thống Kê REF</title>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php
           if($c>0){

            foreach($datamchrefTK as $keyhai){
              echo "['".$keyhai['ModelMCHref']."',".$keyhai['SoLuongMCHref']."],"; 
    
             }
  
           }elseif($n>0){

            foreach($dataMDreftk as $keykey){
              echo "['".$keykey['Model']."',".$keykey['COUNT(*)']."],"; 
    
             }
  
           }

         
         
         ?>
        ]);

        var options = {
          title: <?php
             if($c>0){
               echo "'Biểu đồ model REF mã CH: ".$MaCHTK."'";
               }elseif($n>0){
                 echo "'Biểu đồ model REF năm ".$NamTK." mã CH: ".$MaCHTK."'";
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
           if($c>0){
             echo "['".$Thangtvwm."',".$SLsanphamgtwm.",".$SLsanphamslwm."],"; 
          }
         
          ?>
         
        ]);

        var materialOptions = {
          width: 450,
          chart: {
            title:
            <?php
             if($c>0){
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
                        <option value="">Chọn Mã Cửa Hàng REF: </option>
                        <?php
                         foreach($KQTuyChonMaCHref as $ChonMaCHref){

                         echo '<option class="optionloc" value="'.$ChonMaCHref["MaCH"].'">'.$ChonMaCHref["MaCH"].'</option>'; 
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
   <h1>Thống Kê Theo Mã Cửa Hàng REF...! </h1>
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
    </div>
    
  
    
  
 
  
</body>
</html>
