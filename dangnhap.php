<?php
//Khai báo sử dụng session
session_start();
 
//Khai báo utf-8 để hiển thị được tiếng việt
header('Content-Type: text/html; charset=UTF-8');
 
//Xử lý đăng nhập
if (isset($_POST['dangnhap'])) 
{
    //Kết nối tới database
    include('connect/db_connect.php');
     
    //Lấy dữ liệu nhập vào
    $username = addslashes($_POST['txtUsername']);
    $password = addslashes($_POST['txtPassword']);
     
    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$username || !$password) {
        header('location:'.$_SERVER['PHP_SELF'].'?msg=un');
        exit;
    }
     
    // mã hóa pasword
    
     
    //Kiểm tra tên đăng nhập có tồn tại không
    $query = mysqli_query($mysqli,"SELECT username, pass FROM member WHERE username='$username'");
    if (mysqli_num_rows($query) == 0) {
        header('location:'.$_SERVER['PHP_SELF'].'?msg=ue');
        exit;
    }
     
    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_array($query);
     
    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['pass']) {
        header('location:'.$_SERVER['PHP_SELF'].'?msg=up');
        exit;
    }

    //Lưu tên đăng nhập
    $queryhai = mysqli_query($mysqli,"SELECT * FROM member WHERE username='$username' AND pass='$password'");
    while($rowhai = mysqli_fetch_array($queryhai)){
        $Loai = $rowhai['loai'];                                 
      }
    if ($Loai==0) {
         $_SESSION['username'] = $username;
         $_SESSION['loai']=$Loai;
        header('Location: index.php');
       
    die();
    }else 
    $_SESSION['username'] = $username;
    $_SESSION['loai']=$Loai;
    header('Location: homeadmin.php');
    die();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đăng Nhập</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/loginn.css">
        <link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

	<!--[if lt IE 9]>

	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </head>
    <body>
    <div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" action='dangnhap.php?do=login' method='POST'>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" name='txtUsername' class="login__input" placeholder="User name">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" name='txtPassword' class="login__input" placeholder="Password">
				</div>
				<button name="dangnhap" class="button login__submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>
               
                				
			</form>
            <?php
        if(isset($_REQUEST['msg']) and $_REQUEST['msg']=="un"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ue"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Tên đăng nhập này không tồn tại. Vui lòng kiểm tra lại</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="up"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Mật khẩu không đúng. Vui lòng nhập lại</div>';

		}
        ?>
             <div class="social-login">
				<h3>log in LG</h3>	
			</div> 
			
		</div>
        
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
    </body>
</html>
