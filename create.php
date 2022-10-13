<?php
 require_once 'connect/db_connect.php';
 session_start();

$MienCre = $MaKHCre = $MaCHCre =$TenCHCre = $VungCre = $KieuCre =$SeriCre =$LoaiCre =$ModelCre =$ModelSuCre =$GiaTienCre =$SoLuongCre 
=$TienThuongCre =$BillCodeCre =$BillNameCre =$ThoiGianCre =$NamCre =$ThangCre ='';
//Tạo biến lưu giá trị
$Mien_err = $MaKH_err = $MaCH_err =$TenCH_err = $Vung_err = $Kieu_err =$Seri_err =$Loai_err =$Model_err =$ModelSu_err =$GiaTien_err =$SoLuong_err 
=$TienThuong_err =$BillCode_err =$BillName_err =$ThoiGian_err =$Nam_err =$Thang_err ='';
//Tạo biến lưu lỗi
if($_SERVER["REQUEST_METHOD"]=="POST"){
    //Nếu ấn nút submid
   $input_Mien = trim($_POST["MienCre"]);
   //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
   if(empty($input_Mien)){
      $Mien_err ="Please Miền Bắc Hoặc Nam.";
    //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
   }elseif(!filter_var(trim($_POST["MienCre"]))){
          $Mien_err="Please enter a valid name";
          //Nếu ko phải là ký tự thì mời nhập lại
      }else{
          $MienCre = $input_Mien;
          // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
      }

      $input_MaKH = trim($_POST["MaKHCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_MaKH)){
         $MaKH_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["MaKHCre"]))){
             $MaKH_err="Please ký tự là chuỗi không phải số";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $MaKHCre = $input_MaKH;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }
        
         $input_MaCH = trim($_POST["MaCHCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_MaCH)){
         $MaCH_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["MaCHCre"]))){
             $MaCH_err="Please ký tự là chuỗi không phải số";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $MaCHCre = $input_MaCH;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_TenCH = trim($_POST["TenCHCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_TenCH)){
         $TenCH_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["TenCHCre"]))){
             $TenCH_err="Please ký tự là chuỗi không phải số";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $TenCHCre = $input_TenCH;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_Vung = trim($_POST["VungCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_Vung)){
         $Vung_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["VungCre"]))){
             $Vung_err="Please ký tự là chuỗi không phải số";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $VungCre = $input_Vung;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_Kieu = trim($_POST["KieuCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_Kieu)){
         $Kieu_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["KieuCre"]))){
             $Kieu_err="Please ký tự là chuỗi không phải số";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $KieuCre = $input_Kieu;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_Seri = trim($_POST["SeriCre"]);
         //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
         if(empty($input_Seri)){
            $Seri_err ="Please không được để trống.";
          //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
         }elseif(!filter_var(trim($_POST["SeriCre"]))){
                $Seri_err="Please ký tự là chuỗi không phải số";
                //Nếu ko phải là ký tự thì mời nhập lại
            }else{
                $SeriCre = $input_Seri;
                // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
            }

            $input_Loai = trim($_POST["LoaiCre"]);
            //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
            if(empty($input_Loai)){
               $Loai_err ="Please không được để trống.";
             //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
            }elseif(!filter_var(trim($_POST["LoaiCre"]))){
                   $Loai_err="Please ký tự là chuỗi không phải số";
                   //Nếu ko phải là ký tự thì mời nhập lại
               }else{
                   $LoaiCre = $input_Loai;
                   // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
               }

               $input_Model = trim($_POST["ModelCre"]);
            //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
            if(empty($input_Model)){
               $Model_err ="Please không được để trống.";
             //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
            }elseif(!filter_var(trim($_POST["ModelCre"]))){
                   $Model_err="Please ký tự là chuỗi không phải số";
                   //Nếu ko phải là ký tự thì mời nhập lại
               }else{
                   $ModelCre = $input_Model;
                   // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
               }

               $input_ModelSu = trim($_POST["ModelSuCre"]);
            //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
            if(empty($input_ModelSu)){
               $ModelSu_err ="Please không được để trống.";
             //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
            }elseif(!filter_var(trim($_POST["ModelSuCre"]))){
                   $ModelSu_err="Please ký tự là chuỗi không phải số";
                   //Nếu ko phải là ký tự thì mời nhập lại
               }else{
                   $ModelSuCre = $input_ModelSu;
                   // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
               }

               $input_GiaTien = trim($_POST["GiaTienCre"]);
            //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
            if(empty($input_GiaTien)){
               $GiaTien_err ="Please không được để trống.";
             //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
            }elseif(!ctype_digit(trim($_POST["GiaTienCre"]))){
                   $GiaTien_err="Please ký tự là số chứ không phải chữ";
                   //Nếu ko phải là Số Nguyên Dương thì mời nhập lại
               }else{
                   $GiaTienCre = $input_GiaTien;
                   // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
               }

               $input_SoLuong = trim($_POST["SoLuongCre"]);
            //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
            if(empty($input_SoLuong)){
               $SoLuong_err ="Please không được để trống.";
             //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
            }elseif(!ctype_digit(trim($_POST["SoLuongCre"]))){
                   $SoLuong_err="Please ký tự là số chứ không phải chữ";
                   //Nếu ko phải là Số Nguyên Dương thì mời nhập lại
               }else{
                   $SoLuongCre = $input_SoLuong;
                   // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
               }

               $input_TienThuong = trim($_POST["TienThuongCre"]);
            //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
            if(empty($input_TienThuong)){
               $TienThuong_err ="Please không được để trống.";
             //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
            }elseif(!ctype_digit(trim($_POST["TienThuongCre"]))){
                   $TienThuong_err="Please ký tự là là số chứ không phải chữ";
                   //Nếu ko phải là Số Nguyên Dương thì mời nhập lại
               }else{
                   $TienThuongCre = $input_TienThuong;
                   // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
               }

               $input_BillCode = trim($_POST["BillCodeCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_BillCode)){
         $BillCode_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["BillCodeCre"]))){
             $BillCode_err="Please ký tự là số chứ không phải chữ";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $BillCodeCre = $input_BillCode;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_BillName = trim($_POST["BillNameCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_BillName)){
         $BillName_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["BillNameCre"]))){
             $BillName_err="Please ký tự là chuỗi không phải số";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $BillNameCre = $input_BillName;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_ThoiGian = trim($_POST["ThoiGianCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_ThoiGian)){
         $ThoiGian_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!ctype_digit(trim($_POST["ThoiGianCre"]))){
             $ThoiGian_err="Please nhập số đúng như bản excel";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $ThoiGianCre = $input_ThoiGian;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_Nam = trim($_POST["NamCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_Nam)){
         $Nam_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!ctype_digit(trim($_POST["NamCre"]))){
             $Nam_err="Please nhập số đúng như bản excel";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $NamCre = $input_Nam;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         $input_Thang = trim($_POST["ThangCre"]);
      //Cắt chuỗi(Lấy giá trị của input Mien) lưu bằng input_Mien
      if(empty($input_Thang)){
         $Thang_err ="Please không được để trống.";
       //Nếu giá trị rỗng thì in ra Mời nhập lại miền bắc hoặc nam
      }elseif(!filter_var(trim($_POST["ThangCre"]))){
             $Thang_err="Please ký tự là số chứ không phải chữ";
             //Nếu ko phải là ký tự thì mời nhập lại
         }else{
             $ThangCre = $input_Thang;
             // Nếu hợp lệ thì gán biến $Mien = giá trị của input đó
         }

         if(empty($Mien_err) && empty($MaKH_err) && empty($MaCH_err) && empty($TenCH_err) && empty($Vung_err)
         && empty($Kieu_err) && empty($Seri_err) && empty($Loai_err) && empty($Model_err) && empty($ModelSu_err)
         && empty($GiaTien_err) && empty($SoLuong_err) && empty($TienThuong_err) && empty($BillCode_err) && empty($BillName_err)
         && empty($ThoiGian_err) && empty($Nam_err) && empty($Thang_err)){
             $sql ="INSERT INTO thongke(Mien,MaKH,MaCH,TenCH,Vung,Kieu,Seri,Loai,Model,ModelSu,GiaTien,SoLuong,
             TienThuong,BillCode,BillName,ThoiGian,Nam,Thang) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

             if($stmt = mysqli_prepare($mysqli,$sql)){
                 $stmt->bind_param("ssssssssssssssssss",$Mot,$Hai,$Ba,$Bon,$SoNam,$Sau,$Bay,$Tam,$Chin,$Muoi,
                 $MuoiMot,$MuoiHai,$MuoiBa,$MuoiBon,$MuoiNam,$MuoiSau,$MuoiBay,$MuoiTam);
                 

            $Mot =  $MienCre ;
            $Hai =  $MaKHCre; 
            $Ba = $MaCHCre;
            $Bon = $TenCHCre;
            $SoNam =$VungCre; 
            $Sau = $KieuCre;
            $Bay = $SeriCre;
            $Tam  = $LoaiCre;
            $Chin = $ModelCre;
            $Muoi = $ModelSuCre;
            $MuoiMot = $GiaTienCre;
            $MuoiHai  = $SoLuongCre;
            $MuoiBa  = $TienThuongCre; 
            $MuoiBon = $BillCodeCre; 
            $MuoiNam = $BillNameCre; 
            $MuoiSau = $ThoiGianCre; 
            $MuoiBay  = $NamCre; 
            $MuoiTam = $ThangCre;
            
            if(mysqli_stmt_execute($stmt)){
                header('location: index.php');
                exit();
            }else{
                echo"Something went wrong. Please try again latter";
            }

             }
             mysqli_stmt_close($stmt);

         }
         mysqli_close($mysqli);
}

?>
<?php 
       if (!isset($_SESSION['username']) || $_SESSION['loai']==0) {
        header('Location: dangnhap.php');
   }
       ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Courgette|Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/cre.css">k 
    <title>Create</title>
    <style type="text/css">
      .wrapper{
          width: 500px;
          margin:0 auto;
      }
    </style>
</head>
<body>
<section>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                       
                    </div>
                    <p>Please fill this form and submit to add Bảng Tính record to the database</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                     <div class="form-group <?php echo (!empty($Mien_err)) ? 'has-error' : ''?>">
                       <label>Pricing group</label>
                       <input type="text" name="MienCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Mien_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($MaKH_err)) ? 'has-error' : ''?>">
                       <label>Customer code</label>
                       <input type="text" name="MaKHCre" class="form-control" value="">
                       <span class="help-block"><?php echo $MaKH_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($MaCH_err)) ? 'has-error' : ''?>">
                       <label>Store code</label>
                       <input type="text" name="MaCHCre" class="form-control" value="">
                       <span class="help-block"><?php echo $MaCH_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($TenCH_err)) ? 'has-error' : ''?>">
                       <label>Store name</label>
                       <input type="text" name="TenCHCre" class="form-control" value="">
                       <span class="help-block"><?php echo $TenCH_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Vung_err)) ? 'has-error' : ''?>">
                       <label>Province</label>
                       <input type="text" name="VungCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Vung_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Kieu_err)) ? 'has-error' : ''?>">
                       <label>Channel type</label>
                       <input type="text" name="KieuCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Kieu_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Seri_err)) ? 'has-error' : ''?>">
                       <label>Serial No</label>
                       <input type="text" name="SeriCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Seri_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Loai_err)) ? 'has-error' : ''?>">
                       <label>Division</label>
                       <input type="text" name="LoaiCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Loai_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Model_err)) ? 'has-error' : ''?>">
                       <label>Model</label>
                       <input type="text" name="ModelCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Model_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($ModelSu_err)) ? 'has-error' : ''?>">
                       <label>Model Suffix</label>
                       <input type="text" name="ModelSuCre" class="form-control" value="">
                       <span class="help-block"><?php echo $ModelSu_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($GiaTien_err)) ? 'has-error' : ''?>">
                       <label>MRP</label>
                       <input type="text" name="GiaTienCre" class="form-control" value="">
                       <span class="help-block"><?php echo $GiaTien_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($SoLuong_err)) ? 'has-error' : ''?>">
                       <label>Qty</label>
                       <input type="text" name="SoLuongCre" class="form-control" value="">
                       <span class="help-block"><?php echo $SoLuong_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($TienThuong_err)) ? 'has-error' : ''?>">
                       <label>Incentive amount</label>
                       <input type="text" name="TienThuongCre" class="form-control" value="">
                       <span class="help-block"><?php echo $TienThuong_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($BillCode_err)) ? 'has-error' : ''?>">
                       <label>Bill to code</label>
                       <input type="text" name="BillCodeCre" class="form-control" value="">
                       <span class="help-block"><?php echo $BillCode_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($BillName_err)) ? 'has-error' : ''?>">
                       <label>Bill to name</label>
                       <input type="text" name="BillNameCre" class="form-control" value="">
                       <span class="help-block"><?php echo $BillName_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($ThoiGian_err)) ? 'has-error' : ''?>">
                       <label>Sell out date</label>
                       <input type="text" name="ThoiGianCre" class="form-control" value="">
                       <span class="help-block"><?php echo $ThoiGian_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Nam_err)) ? 'has-error' : ''?>">
                       <label>Year</label>
                       <input type="text" name="NamCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Nam_err; ?></span>
                     </div>
                     <div class="form-group <?php echo (!empty($Thang_err)) ? 'has-error' : ''?>">
                       <label>Month</label>
                       <input type="text" name="ThangCre" class="form-control" value="">
                       <span class="help-block"><?php echo $Thang_err; ?></span>
                     </div>
                     <input type="submit" class="btn btn-primary" value="Submit">
                     <a href="index.php" class="btn btn-default">Cancel</a>
                     
                </form>
                </div>
            </div>
        </div>
    </div>
  </div>
     <div class="leaf">
     <div>  <img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
      <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
      <div>  <img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
      <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
       <div> <img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
     <div>   <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div>
            
     </div>
     
     <div class="leaf leaf1">
     <div>  <img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
      <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
      <div>  <img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
      <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>
       <div> <img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
     <div>   <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div>
            
     </div>
     
     <div class="leaf leaf2">
     <div>  <img src="http://www.pngmart.com/files/1/Fall-Autumn-Leaves-Transparent-PNG.png" height="75px" width="75px"></img></div>
      <div><img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Pictures-Collage-PNG.png" height="75px" width="75px"></img></div>
      <div>  <img src="http://www.pngmart.com/files/1/Autumn-Fall-Leaves-Clip-Art-PNG.png" height="75px" width="75px" ></img></div>
      <div><img  src="http://www.pngmart.com/files/1/Green-Leaves-PNG-File.png" height="75px" width="75px"></img></div>

       <div> <img src="http://www.pngmart.com/files/1/Transparent-Autumn-Leaves-Falling-PNG.png" height="75px" width="75px"></img></div>
     <div>   <img src="http://www.pngmart.com/files/1/Realistic-Autumn-Fall-Leaves-PNG.png" height="75px" width="75px"></div>
     <div><img src="http://cdn.clipart-db.ru/rastr/autumn_leaves_025.png" height="75px" width="75px"></div>
            
     </div>
     </section>
    
    
</body>
</html>