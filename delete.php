<?php
session_start();
include 'connect/db_connect.php';
if(isset($_POST["ID"]) && !empty($_POST["ID"])){
    require 'connect/db_connect.php';

    $sql ="DELETE FROM thongke WHERE ID=?";

    if($stmt=mysqli_prepare($mysqli,$sql)){
        $stmt->bind_param("s",$Mot);
        $Mot=trim($_POST["ID"]);

        if(mysqli_stmt_execute($stmt)){
           header("location: index.php");
           exit();
        }else{
            echo"Please try again later!";
        }
    }
    mysqli_stmt_close($stmt);

    mysqli_close($mysqli);

}else{
    if(empty(trim($_GET["ID"]))){
        header("location: index.php");
        exit();
    }
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
    <title>Delete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
      .wrapper{
          width: 500px;
          margin:0 auto;
      }
    </style>
</head>
<body>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Delete Record</h2>
                    </div>
                   
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                     <div class="alert alert-danger fade in">
                       <input type="hidden" name="ID" value="<?php echo trim($_GET["ID"]);?>">
                       <p>Are you sure you want to delete this record</p><br>
                       <p>
                           <input type="submit" value="Yes" class="btn btn-danger">
                           <a href="index.php" class="btn btn-default">No</a>
                       </p>

                     </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>