<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();

?>
<style>
body{
	background: #ffffff;
}
</style>
<div id="login-form" >
	<div>
		<?php
		if($_POST){
			//form validation
			if(empty($_POST['email']) || empty($_POST['password'])){
				$errors[] = 'You must provide email and password.';

			}
			//validate email
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid Email.';
			}
			//check if password is more than 6 characters
			if(strlen($password) < 6){
				$errors[] = 'Password must be atleast 6 characters.';
			}
			//check if email exists in database
			$query = $db->query("SELECT * FROM users WHERE email ='$email'");
			$user = mysqli_fetch_assoc($query);
			$userCount = mysqli_num_rows($query);
			if($userCount < 1){
				$errors[] = 'User doesn\'t  exists in our database.';
			}
			//
			if(!password_verify($password, $user['password'])){
				$errors[] = 'Password does not match our records. Please try again';
			}
			//check for errors
			if(!empty($errors)){
				echo display_error($errors);
			}else{
				//login
				$user_id = $user['id'];
				login($user_id);
			}
		}
		?>
	</div>
	<h2 class="text-center">Login</h2><hr>
	<form action="login.php" method="post">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>

		<div class="form-group">
			
			<input type="submit" class="btn btn-success" style="border:none;background-color:#2af598;" value="Login">
		</div>
		<span>Don't have an account?</span><a href="register.php">Sign Up</a>
		<br>
		<br>
		<p><a href="/online-mall/admin/forgot-password.php">Forgot password?</a></p>
	</form>
	<br>
	<p class="text-right"><a href="/online-mall/index.php">Visit Site</a></p>
</div>

<?php include 'includes/footer.php';?>
