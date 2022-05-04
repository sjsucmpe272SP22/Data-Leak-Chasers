<?php require_once("../server/connect.php"); ?>
<?php include_once("../session.php"); ?>
<?php include_once("../sanitize.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php include_once("bootstrap.php"); ?>
</head>
<body class="login_background">
	<?php include_once("menubar.php"); ?>

	<div class="container">
		<div class="row my-5">
			<div class="col-sm-4 mx-auto">
				<div class="card">
					<div class="card-body">
						<?php include_once("success_message.php"); ?>						
<?php 
	if(isset($_POST['login'])){
		$email=sanitize($_POST['email']);
		$password=sanitize($_POST['password']);
		$result=mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
		if(mysqli_num_rows($result)>0){
			$rows=mysqli_fetch_array($result);
			if($rows['admin_active'] == "1"){
				$_SESSION['user_id']=$rows['id'];
				$_SESSION['username']=$rows['username'];
				$_SESSION['profile']=$rows['profile'];
				$_SESSION['user_type']=$rows['user_type'];
				$_SESSION['is_login']="loginned";
				$url="dashboard.php";
				$_SESSION['success_message']="You are successfully loginned.";
				header("Location:$url");
				exit();				
			}
			else{
				echo "<div class='alert alert-warning'>Failed to login: Your account not approved by admin.</div>";
			}			
		}
		else{
			?>
<div class="alert alert-danger">
Invalid email id or password
</div>		
<?php
		}
	}
 ?>
 						<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
							<div class="mb-2">
								<label for="email">Email id</label>
								<input type="text" name="email" class="form-control" required autofocus>
							</div>
							<div class="mb-2">
								<label for="password">Password</label>
								<input type="password" name="password" class="form-control" required>
							</div>

							<div class="mb-2 text-center">
								<input type="submit" name="login" value="Login" class="btn btn-primary">
							</div>

							<div class="mb-2 text-center">
								<a href="register.php" class="text-decoration-none">Does not have account?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>