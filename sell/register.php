<?php
require_once '../core/connect.php';


include 'includes/head.php';





	$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm = ((isset($_POST['confirm']) )?sanitize($_POST['confirm']):'');
	$shop_name = ((isset($_POST['shop_name']) )?sanitize($_POST['shop_name']):'');
	
	
	$errors = array();
	if($_POST){

		$emailQuery = $db->query("SELECT * FROM vendors WHERE email = '$email'");
		$emailCount = mysqli_num_rows($emailQuery);

		if($emailCount != 0){
			$errors[] = 'This email already exists in our database.';
		}
		$required = array('name', 'email', 'password', 'confirm', 'shop_name');
		foreach($required as $f){
			if(empty($_POST[$f])){
				$errors[] = 'You must fill all fields.';
				break; 
			}
		}
		if(strlen($password) < 6){
			$errors[] = 'Your password must be atleast 6 characters.';
		}

		if($password != $confirm){
			$errors[] = 'Your password must be equal to confirm password.';
		}
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid Email.';
			}
		if(!empty($errors)){
			echo display_error($errors);
		}else{
			//add users to database
			$hashed = password_hash($password, PASSWORD_DEFAULT);
			$db->query("INSERT INTO vendors(full_name,email,password,shop_name) VALUES('$name', '$email', '$hashed', '$shop_name')");
			$_SESSION['success_flash'] = 'User have been added!';
			header('Location: login.php');
		}
	}

	?>
	<h3 class="text-center">Join Us as a Vendor</h3><hr>

	<form action="register.php" method="POST">

		<div class="form-group col-md-6 ">
			<label for="name">Full Name*:</label>
			<input type="text" name="name" class="form-control" id="name" value="<?=$name;?>">
		</div>

		<div class="form-group col-md-6 ">
			<label for="name">Shop Name*:</label>
			<input type="text" name="shop_name" class="form-control" id="shop_name" value="<?=$shop_name;?>">
		</div>

		<div class="form-group col-md-6 ">
			<label for="email">Email*:</label>
			<input type="email" name="email" class="form-control" id="email" value="<?=$email;?>">
		</div>

		<div class="form-group col-md-6 ">
			<label for="name">Password*:</label>
			<input type="password" name="password" class="form-control" id="password" value="<?=$password;?>">
		</div>

		<div class="form-group col-md-6 ">
			<label for="name">Confirm Password*:</label>
			<input type="password" name="confirm" class="form-control" id="confirm" value="<?=$confirm;?>">
		</div>

		
		<div class="form-group col-md-6 text-right" style="margin-top:25px">
			
			<input type="submit" class="btn btn-success" value="Sign Up" style="border:none;background-color:#2af598;">
		</div>

	</form>
<?php include 'includes/footer.php';?>