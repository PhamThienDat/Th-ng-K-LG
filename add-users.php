<?php include_once('config.php');
include_once('connect/db_connect.php');

session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){
	extract($_REQUEST);
	$sqlmot = mysqli_query($mysqli,"SELECT * FROM member where username like '%".$_POST["username"]."%'");
	
	$sqlnam = mysqli_query($mysqli,"SELECT * FROM member where sodt like '%".$_POST["userphone"]."%'");
	

	if($_POST["username"]==""){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=un');
		exit;
	}elseif(mysqli_num_rows($sqlmot)>0){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=uf');
		exit;  
	  }
	elseif($_POST["userpass"]==""){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=ue');
		exit;
	}
	elseif($_POST["useremail"]==""){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=up');
		exit;
	}elseif($_POST["userfullname"]==""){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=uq');
		exit;
	}
	elseif($_POST["userphone"]==""){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=uw');
		exit;
	}elseif(mysqli_num_rows($sqlnam)>0){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=uh');
		exit;  
	  }
	elseif($_POST["userlever"]==""){
		header('location:'.$_SERVER['PHP_SELF'].'?msg=ur');
		exit;
	}else{
		$userCount	=	$db->getQueryCount('member','ID');
		$data	=	array(
						'username'=>$_POST["username"],
						'pass'=>$_POST["userpass"],
						'email'=>$_POST["useremail"],
						'fullname'=>$_POST["userfullname"],
						'sodt'=>$_POST["userphone"],
						'loai'=>$_POST["userlever"],
					);
		$insert	=	$db->insert('member',$data);
		if($insert){
			header('location:browse-users.php?msg=ras');
			exit;
		}else{
			header('location:browse-users.php?msg=rna');
			exit;
		}
	}
	
		
		
	
}
?>
<?php 
       if (!isset($_SESSION['username']) || $_SESSION['loai']==0) {
        header('Location: dangnhap.php');
   }
       ?>

<!doctype html>

<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"  prefix="og: http://ogp.me/ns#" class="no-js">

<head>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>ADD</title>

	

	<link rel="shortcut icon" href="https://demo.learncodeweb.com/favicon.ico">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

	<!--[if lt IE 9]>

	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>

	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<![endif]-->

	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	<script>

	  (adsbygoogle = window.adsbygoogle || []).push({

		google_ad_client: "ca-pub-6724419004010752",

		enable_page_level_ads: true

	  });

	</script>

	<!-- Global site tag (gtag.js) - Google Analytics -->

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131906273-1"></script>

	<script>

	  window.dataLayer = window.dataLayer || [];

	  function gtag(){dataLayer.push(arguments);}

	  gtag('js', new Date());

	  gtag('config', 'UA-131906273-1');

	</script>

</head>



<body>

	

	<div class="bg-light border-bottom shadow-sm sticky-top">

		<div class="container">

			
		</div> <!--/.container-->

	</div>

	<div class="container my-4">

		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

		<!-- demo top banner -->

		<ins class="adsbygoogle"

			 style="display:block"

			 data-ad-client="ca-pub-6724419004010752"

			 data-ad-slot="6737619771"

			 data-ad-format="auto"

			 data-full-width-responsive="true"></ins>

		<script>

		(adsbygoogle = window.adsbygoogle || []).push({});

		</script>

	</div>

	

   	<div class="container">

		

		<?php

		if(isset($_REQUEST['msg']) and $_REQUEST['msg']=="un"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User name is mandatory field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ue"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User password is mandatory field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="up"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User Email is mandatory field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ras"){

			echo	'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Record added successfully!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="rna"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Record not added <strong>Please try again!</strong></div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="uq"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User fullname is mandatory field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="uw"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User Phone is mandatory field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="ur"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> User Lever is mandatory field!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="uf"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Trùng username!</div>';

		}elseif(isset($_REQUEST['msg']) and $_REQUEST['msg']=="uh"){

			echo	'<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>Trùng số điện thoại</div>';

		}

		?>

		<div class="card">

			<div class="card-header"><i class="fa fa-fw fa-plus-circle"></i> <strong>Add User</strong> <a href="browse-users.php" class="float-right btn btn-dark btn-sm"><i class="fa fa-fw fa-globe"></i> Browse Users</a></div>

			<div class="card-body">

				

				<div class="col-sm-6">

					<h5 class="card-title">Fields with <span class="text-danger">*</span> are mandatory!</h5>

					<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

						<div class="form-group">

							<label>User Name <span class="text-danger">*</span></label>

							<input type="text" name="username" id="username" class="form-control" placeholder="Enter user name" required>

						</div>

						<div class="form-group">

							<label>PassWord <span class="text-danger">*</span></label>

							<input type="text" name="userpass" id="userpass" class="form-control" placeholder="Enter user password" required>

						</div>

						<div class="form-group">

							<label>User Email <span class="text-danger">*</span></label>

							<input type="email" class="tel form-control" name="useremail" id="useremail" x-autocompletetype="tel" placeholder="Enter user Email" required>

						</div>
						<div class="form-group">

							<label>FullName <span class="text-danger">*</span></label>

							<input type="text" class="tel form-control" name="userfullname" id="userfullname" x-autocompletetype="tel" placeholder="Enter user FullName" required>

						</div>
						<div class="form-group">

							<label>User Phone <span class="text-danger">*</span></label>

							<input type="tel" maxlength="12" class="tel form-control" name="userphone" id="userphone" x-autocompletetype="tel" placeholder="Enter user Phone" required>

						</div>
						<div class="form-group">
							

							<label>Lever <span class="text-danger">*</span></label>

							<input type="Number" class="tel form-control" Max="1"
Min="0"name="userlever" id="userlever" x-autocompletetype="tel" placeholder="Admin=1, Member =0" required>

						</div>

						<div class="form-group">

							<button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus-circle"></i> Add User</button>

						</div>

					</form>

				</div>

			</div>

		</div>

	</div>

    

	<div class="container my-4">

		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

		<!-- demo left sidebar -->

		<ins class="adsbygoogle"

			 style="display:block"

			 data-ad-client="ca-pub-6724419004010752"

			 data-ad-slot="7706376079"

			 data-ad-format="auto"

			 data-full-width-responsive="true"></ins>

		<script>

		(adsbygoogle = window.adsbygoogle || []).push({});

		</script>

	</div>

	

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/jquery.caret/0.1/jquery.caret.js"></script>
	<script src="https://www.solodev.com/_/assets/phone/jquery.mobilePhoneNumber.js"></script>
	<script>
		$(document).ready(function() {
		jQuery(function($){
			  var input = $('[type=tel]')
			  input.mobilePhoneNumber({allowPhoneWithoutPrefix: '+1'});
			  input.bind('country.mobilePhoneNumber', function(e, country) {
				$('.country').text(country || '')
			  })
			 });
		});
	</script>

    

</body>

</html>