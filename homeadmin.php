<?php
session_start();
include 'connect/db_connect.php';
if(isset($_POST['submit'])){

    $file = $_FILES['doc']['tmp_name'];

    $ext=pathinfo($_FILES['doc']['name'],PATHINFO_EXTENSION);
    if($ext=='xlsx'){
    require('PHPExcel/PHPExcel.php');
    require('PHPExcel/PHPExcel/IOFactory.php');
  
    $obj = PHPExcel_IOFactory::load($file);

    $KTColum = $obj->setActiveSheetIndex(0);
    $highestColumn = $KTColum->getHighestColumn();
    if($highestColumn !='R'){
        header('location:'.$_SERVER['PHP_SELF'].'?msg=ur');
                exit();

    }

    $NamKTT = $KTColum->getCellByColumnAndRow(16,2)->getValue();
    $ThangKTT = $KTColum->getCellByColumnAndRow(17,2)->getValue();
    $KTT = mysqli_query($mysqli,"SELECT nam,thang FROM thongke WHERE nam='$NamKTT' AND thang='$ThangKTT'");
            if(mysqli_num_rows($KTT)>0){           
                header('location:'.$_SERVER['PHP_SELF'].'?msg=uw');
                exit();
                
            }

    foreach($obj->getWorksheetIterator() as $sheet){
        $getHighestRow = $sheet->getHighestRow();
       
        
        for($i = 2;$i<=$getHighestRow;$i++){
            $Mien = $sheet->getCellByColumnAndRow(0,$i)->getValue();
            $MaKH = $sheet->getCellByColumnAndRow(1,$i)->getValue();
            $MaCH = $sheet->getCellByColumnAndRow(2,$i)->getValue();
            $TenCH = $sheet->getCellByColumnAndRow(3,$i)->getValue();
            $Vung = $sheet->getCellByColumnAndRow(4,$i)->getValue();
            $Kieu = $sheet->getCellByColumnAndRow(5,$i)->getValue();
            $Seri = $sheet->getCellByColumnAndRow(6,$i)->getValue();
            $Loai = $sheet->getCellByColumnAndRow(7,$i)->getValue();
            $Model = $sheet->getCellByColumnAndRow(8,$i)->getValue();
            $ModelSu = $sheet->getCellByColumnAndRow(9,$i)->getValue();
            $GiaTien = $sheet->getCellByColumnAndRow(10,$i)->getValue();
            $SoLuong = $sheet->getCellByColumnAndRow(11,$i)->getValue();
            $TienThuong = $sheet->getCellByColumnAndRow(12,$i)->getValue();
            $BillCode = $sheet->getCellByColumnAndRow(13,$i)->getValue();
            $BillName = $sheet->getCellByColumnAndRow(14,$i)->getValue();
            $ThoiGian = $sheet->getCellByColumnAndRow(15,$i)->getValue();
            $Nam = $sheet->getCellByColumnAndRow(16,$i)->getValue();
            $Thang = $sheet->getCellByColumnAndRow(17,$i)->getValue();


            
            
                try { 
                    $query = "INSERT INTO thongke
             SET Mien='$Mien',
                 MaKH='$MaKH',
                 MaCH='$MaCH',
                 TenCH='$TenCH',
                 Vung='$Vung',
                 Kieu='$Kieu',
                 Seri='$Seri',
                 Loai='$Loai',
                 Model='$Model',
                 ModelSu='$ModelSu',
                 GiaTien='$GiaTien',
                 SoLuong='$SoLuong',
                 TienThuong='$TienThuong',
                 BillCode='$BillCode',
                 BillName='$BillName',
                 ThoiGian='$ThoiGian',
                 Nam='$Nam',
                 Thang='$Thang'";
                   $result = mysqli_query($mysqli, $query); 
                } catch (mysqli_sql_exception $e) { 
                   var_dump($e);
                   exit; 
                } 
            
              
            }            
        
    }
    header('location:'.$_SERVER['PHP_SELF'].'?msg=un');
    }else{
        header('location:'.$_SERVER['PHP_SELF'].'?msg=ue');
        exit();
    }
   
}
?>

<?php

$TuyChon = "SELECT DISTINCT Nam FROM thongke ORDER BY Nam ASC";
$KQTuyChon = mysqli_query($mysqli,$TuyChon);
if(mysqli_num_rows($KQTuyChon)>0){
    $SoNamTK = mysqli_fetch_array($KQTuyChon);
    

}else{
    
         exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ ADMIN</title>
   <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        
        <!-- Bộ lọc -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="js/bootstrap-select.min.js"></script>
        <!-- icon -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
            <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
            <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" /> 

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/trangchu.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

	<!--[if lt IE 9]>

	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <style>
    </style>
</head>
<!--class-->
<body>
<?php 
       if (!isset($_SESSION['username']) || $_SESSION['loai']==0) {
        header('Location: dangnhap.php');
   }
       ?>


<main>
  <aside>
    <ul class="asideList">
      <li><a class="asideAnchor" href="index.php"><i class='fa fa-home'></i>Home</a></li>
      <li><a class="asideAnchor" href="./thongke/Namthangg.php"><i class='fa fa-bar-chart'></i>Thống Kê</a></li>
      <li><a class="asideAnchor" href="browse-users.php"><i class="fa fa-user" aria-hidden="true"></i>Users</a></li>
      <li><a href="logout.php" class="asideAnchor"><i class="fa fa-outdent" aria-hidden="true"></i>Log Out</a></li>
    </ul>
  </aside>
  <section >
    <input type="checkbox" id="myInput">
    <div class="aduvip">
    <label class="daucard" for="myInput">
      <span class="bar top"></span>
      <span class="bar middle"></span>
      <span class="bar bottom"></span>
    </label>
    </div>
    
    
    <div class="content">
    <div class="container">
        <!--container: tự căn giữa-->
       
            
                <!--cod-md-12 mt-4: tự căng maggin top-->           
                
                <div class="contentdau">
                    <div class="card-dau">


                        <!--Tìm Kiếm-->
                      
                        <form  method="GET" class="se">
                        <input type="search" class="timkiem" name="s" id="s" placeholder="Hãy nhập từ khóa và ấn enter để bắt đầu tìm kiếm" />
                        <button onclick="blogwavesTopFunction()" id="myBtn" title="Go to top" style="display: block;">
                        <i class="fa fa-angle-up"></i>
                        </button> 
                        </form>


                        
                        
                    </div>
                    <div class="card-giua">
                     <div class="card-giua-dau">
<!--import và export-->
                   <h1 class="animate-charcter" >Thao Tác</h1>     
                   <form  action=""  method="POST" enctype="multipart/form-data">
                    <input type="file" name="doc" class="chinhfile">
                    <button class="imporee" id="import" type="submit" name="submit">Import</button> 
                    <a href="create.php" class="addbanghi">Thêm Bản Ghi</a>
                    
                    </form>
                    <form action="export.php" method="POST">
                        <input type="submit" value="export"  class=" exportt">

                        <span class="Suy-ra">&#8666;</span>
                    <div class="row">
                    <select name="filter_country" id="filter_country" class="chinhboloc" required>
                           <span class="TuyChinh">&#8744;</span>
                        <option value="">Năm: </option>
                        <?php
                         foreach($KQTuyChon as $SoNamTK){

                         echo '<option class="optionloc" value="'.$SoNamTK["Nam"].'">'.$SoNamTK["Nam"].'</option>'; 
                          }
                        ?>
                       </select>
                        <select name="filter_gender" id="filter_gender" class=" locmot" required>
                        <span class="TuyChinh">&#8744;</span>
                        <option class="optionloc" value="">Tháng: </option>
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
      
                    </div>
                    </form>
                  

                     </div>
                     <div class="card-giua-sau">
                         <div id="timmer">
                         <div class="circle" style="--clr:#ff2972;">
                         <div class="dots hr_dot"></div>
                             <svg>
                                 <circle cx="70" cy="70" r="70"></circle>
                                 <circle cx="70" cy="70" r="70" id="hh"></circle>
                             </svg>
                       <div id="gio">00</div>
                   </div>
                   <div class="circle" style="--clr:#fee800;">
                   <div class="dots min_dot"></div>
                   <svg>
                                 <circle cx="70" cy="70" r="70"></circle>
                                 <circle cx="70" cy="70" r="70" id="mm"></circle>
                             </svg>
                       <div id="phut">00</div>
                   </div>
                   <div class="circle" style="--clr:#1880C5;">
                   <div class="dots sec_dot"></div>
                   <svg>
                                 <circle cx="70" cy="70" r="70"></circle>
                                 <circle cx="70" cy="70" r="70" id="ss"></circle>
                             </svg>
                       <div id="giay">00</div>
                   </div>
                   <div class="ap">
                       <div id="ampm">00</div>
                   </div>
                         </div>

                    </div>
                    <script>

                        setInterval(() =>{
                        let gio =document.getElementById('gio');
                        let phut =document.getElementById('phut');
                        let giay =document.getElementById('giay');
                        let ampm =document.getElementById('ampm');

                        let hh = document.getElementById('hh');
                        let mm =document.getElementById('mm');
                        let ss =document.getElementById('ss');

                        let hr_dot = document.querySelector('.hr_dot');
                        let min_dot = document.querySelector('.min_dot');
                        let sec_dot = document.querySelector('.sec_dot');

                        let h = new Date().getHours();
                        let m = new Date().getMinutes();
                        let s = new Date().getSeconds();
                        let am = h>=12 ? "PM" : "AM";

                        if(h>12){
                            h=h-12;
                        }

                        h=(h < 10) ? "0" + h:h;
                        m=(m < 10) ? "0" + m:m;
                        s=(s < 10) ? "0" + s:s;

                        gio.innerHTML = h;
                        phut.innerHTML=m;
                        giay.innerHTML=s;
                        ampm.innerHTML=am;

                        hh.style.strokeDashoffset=440-(440*h)/12;
                        mm.style.strokeDashoffset=440-(440*m)/60;
                        ss.style.strokeDashoffset=440-(440*s)/60;

                       $giochay = h*30;

                        hr_dot.style.transform = 'rotate($giochaydeg)';
                        min_dot.style.transform = 'rotate(${m * 6}deg)';
                        sec_dot.style.transform = 'rotate(${s * 6}deg)';
                        })
                        
                    </script>

                     
                          
                    </div>
                </div>          
           
       
    </div>
    

   
   
    
   
   
    <div class="table_container">
                   <div class="table" id="danhsach">
                       <div class="canmar">
                       <marquee width="100%" class="heading" behavior="" direction="" >Bảng Thống Kê LG</marquee>
                       </div>

                       <?php

if(isset($_REQUEST['msg']) and $_REQUEST['msg']=="un"){

    echo	'<div class="alert alert-success"><i class="fa fa-exclamation-triangle"></i> Impore thành công!</div>';

}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ue"){

    echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Lỗi file, file cần .xlsx!</div>';

}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="up"){

    echo	'<div class="alert alert-success"><i class="fa fa-exclamation-triangle"></i> Không tìm thấy tháng</div>';

}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="uw"){

    echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Đã có bản excel này!</div>';

}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ur"){

    echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Bản excel này số cột đang bị nhiều hơn, vui lòng kiểm tra lại!!</div>';

}

?>
                       
                       <?php
                if(isset($_GET['s']) && $_GET['s'] !=''){
                    $sqli ='SELECT * FROM thongke WHERE Nam like "%'.$_GET['s'].'%"
                    OR Thang like "%'.$_GET['s'].'%"
                    OR ThoiGian like "%'.$_GET['s'].'%"
                    OR MaKH like "%'.$_GET['s'].'%"
                    OR MaCH like "%'.$_GET['s'].'%"
                    OR TenCH like "%'.$_GET['s'].'%"
                    OR Vung like "%'.$_GET['s'].'%"
                    OR Kieu like "%'.$_GET['s'].'%"
                    OR Loai like "%'.$_GET['s'].'%"
                    OR Seri like "%'.$_GET['s'].'%"
                    OR Model like "%'.$_GET['s'].'%"
                    OR ModelSu like "%'.$_GET['s'].'%"
                    OR GiaTien like "%'.$_GET['s'].'%"
                    OR SoLuong like "%'.$_GET['s'].'%"
                    OR BillCode like "%'.$_GET['s'].'%"
                    OR BillName like "%'.$_GET['s'].'%"
                    OR TienThuong like "%'.$_GET['s'].'%"
                    OR Mien like "%'.$_GET['s'].'%"
                    ';
                }else{
                    $now = getdate();
                    $ThangHienTai = date('M');
                    switch($ThangHienTai){
                        case 'Dec' :
                            $ThangHienTai='Nov';
                            break;
                        case 'Nov' :
                            $ThangHienTai='Oct';
                            break;
                        case 'Oct' :
                            $ThangHienTai='Sep';
                            break;
                        case 'Sep' :
                            $ThangHienTai='Aug';
                            break;
                        case 'Aug' :
                            $ThangHienTai='Jul';
                            break;
                        case 'Jul' :
                            $ThangHienTai='Jun';
                            break;
                        case 'Jun' :
                            $ThangHienTai='May';
                            break;
                        case 'May' :
                            $ThangHienTai='Apr';
                            break;
                        case 'Apr' :
                            $ThangHienTai='Mar';
                            break;
                        case 'Mar' :
                            $ThangHienTai='Feb';
                            break;
                        case 'Feb' :
                            $ThangHienTai='Jan';
                            break; 
                        case 'Jan' :
                            $ThangHienTai='Dec';
                            break;   
                        default:
                            echo 'Không tìm thấy tháng hiển thị';
                            break;  
                    }
                    
                    $NamHienTai= $now['year'];
                    if($ThangHienTai=='Dec'){
                        $NamHienTai=$NamHienTai-1;
                    }
                   
 
                    $sqli="SELECT * FROM thongke WHERE Nam like '%".$NamHienTai."%'
                    AND Thang like '%".$ThangHienTai."%' OR Nam like '%".$NamHienTai."%'";
                    $HienThipage = mysqli_query($mysqli,$sqli);

                   

                   
                }
                
               
                if($resultt = mysqli_query($mysqli,$sqli)){
                    $dem=mysqli_num_rows($resultt);
                    
                    if($dem>0){
                        echo"<table id='employee_data' class='table table-striped table-bordered'>";
                           echo"<thead>";
                                echo"<tr>";
                                    echo"<th>ID</th>";
                                    echo"<th>Pricing group</th>";
                                    echo"<th>Customer code</th>";
                                    echo"<th>Store code</th>";
                                    echo"<th>Store name</th>";
                                    echo"<th>Province</th>";
                                    echo"<th>Channel type</th>";
                                    echo"<th>Serial No</th>";
                                    echo"<th>Division</th>";
                                    echo"<th>Model</th>";
                                    echo"<th>Model Suffix</th>";
                                    echo"<th>MRP</th>";
                                    echo"<th>Qty</th>";
                                    echo"<th>Incentive amount</th>";
                                    echo"<th>Bill to code</th>";
                                    echo"<th>Bill to name</th>";
                                    echo"<th>Sell out date</th>";
                                    echo"<th>Year</th>";
                                    echo"<th>Month</th>";
                                    
                                echo"</tr>";
                            echo"</thead>";
                            echo"<tbody>";
                            while($row = mysqli_fetch_array($resultt)){
                                $format_number_TT = number_format($row['TienThuong']);
                                $format_number_GT = number_format($row['GiaTien']);
                                 $TachNgay = substr($row['ThoiGian'],6);
                                 $TachThang = substr($row['ThoiGian'],4,-2);
                                 $TachNam = substr($row['ThoiGian'],0,-4);
                                 $KQ= "$TachNgay-$TachThang-$TachNam";
                                        
                                echo"<tr>";
                                  echo"<td class='mot' data-label=ID>". $row['ID']."</td>";
                                  echo"<td class='mot' data-label=Pricing group>". $row['Mien']."</td>";
                                  echo"<td class='mot' data-label=Customer code>". $row['MaKH']."</td>";
                                  echo"<td class='mot' data-label=Store code>". $row['MaCH']."</td>";
                                  echo"<td class='mot' data-label=Store name>". $row['TenCH']."</td>";
                                  echo"<td class='mot' data-label=Province>". $row['Vung']."</td>";
                                  echo"<td class='mot' data-label=Channel type>". $row['Kieu']."</td>";
                                  echo"<td class='mot' data-label=Serial No>". $row['Seri']."</td>";
                                  echo"<td class='mot' data-label=Division>". $row['Loai']."</td>";
                                  echo"<td class='mot' data-label=Model>". $row['Model']."</td>";
                                  echo"<td class='mot' data-label=Model Suffix>". $row['ModelSu']."</td>";
                                  echo"<td class='mot' data-label=MRP>".$format_number_GT."đ</td>";
                                  echo"<td class='mot' data-label=Qty>". $row['SoLuong']."</td>";
                                  echo"<td class='mot' data-label=Incentive amount>".$format_number_TT."đ</td>";
                                  echo"<td class='mot' data-label=Bill to code>". $row['BillCode']."</td>";
                                  echo"<td class='mot' data-label=Bill to name>". $row['BillName']."</td>";
                                  echo"<td class='mot' data-label=Sell out date>".$KQ."</td>";
                                  echo"<td class='mot' data-label=Year>". $row['Nam']."</td>";
                                  echo"<td class='mot' data-label=Month>". $row['Thang']."</td>";
                                         
                            echo"</tr>";
                           
                            }
                            
                            
                            echo"</tbody>";
                           
                            echo"</table>";


                            mysqli_free_result($resultt);
                            //Giải phóng bộ nhớ
                    }else{
                        echo"";
                    }
                }else{
                    echo"ERROR: Could not able to execute $HienThipage.".mysqli_error($mysqli);
                }
               
                ?>
                <?php
                 
        

            if(isset($_GET['s']) && $_GET['s'] !=''){
                echo 'Có "'.$dem.'" bản ghi'; 
            }else{
                // PHẦN XỬ LÝ PHP
       
       
        // BƯỚC 2: TÌM TỔNG SỐ RECORDS
        $result = mysqli_query($mysqli,"SELECT count(ID) as total from thongke WHERE Nam='$NamHienTai' AND 
        Thang='$ThangHienTai' OR Nam='$NamHienTai'");
        $row = mysqli_fetch_assoc($result);
         $total_records = $row['total'];
 
        // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit =100;
 
        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
        // tổng số trang
        $total_page = ceil($total_records / $limit);
 
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
       
        // Tìm Start
         $start = ($current_page - 1) * $limit;
 
        // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
        $result = mysqli_query($mysqli, "SELECT * FROM thongke WHERE nam='$NamHienTai' AND 
        Thang='$ThangHienTai' LIMIT $start, $limit");
 
        ?>
       
        <div class="pagination">
           <?php 
            // PHẦN HIỂN THỊ PHÂN TRANG
            // BƯỚC 7: HIỂN THỊ PHÂN TRANG
 
            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
            if ($current_page > 1 && $tal_page > 1){
                echo '<a class="active" href="index.php?page='.($current_page-1).'">Prev</a> | ';
            }
 
            // Lặp khoảng giữa
            for ($i = 1; $i <= $total_page; $i++){
                // Nếu là trang hiện tại thì hiển thị thẻ span
                // ngược lại hiển thị thẻ a
                if ($i == $current_page){
                    echo '<span>'.$i.'</span> | ';
                }
                else{
                    echo '<a  class="active" href="index.php?page='.$i.'">'.$i.'</a> | ';
                }
            }
 
            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
            if ($current_page < $total_page && $total_page > 1){
                echo '<a class="active" href="index.php?page='.($current_page+1).'">Next</a> | ';
            }
            }
           ?>

  
    
</div>
 <!--Icon-->
    </div>
  </section>

  
</main>
    

 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
 <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="s.js"></script>
    
    
</body>
</html>



