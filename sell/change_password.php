<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
if(!is_vlogged_in()){
	login_error_redirect();
}
include 'includes/head.php';

$hashed = $vuser_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $vuser_data['id'];
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
			if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
				$errors[] = 'You must fill out all fields.';

			}
			
			
			//check if password is more than 6 characters
			if(strlen($password) < 6){
				$errors[] = 'Password must be atleast 6 characters.';
			}
			//if new password matches confirm
			if($password != $confirm){
				$errors[] = 'New password and confirm password does not match.';
			}
			//
			if(!password_verify($old_password, $hashed)){
				$errors[] = 'your old password does not match our records. Please try again';
			}
			//check for errors
			if(!empty($errors)){
				echo display_error($errors);
			}else{
				//change password
				$query = $db->query("UPDATE vendors SET password ='$new_hashed' WHERE id = '$user_id'");
				$_SESSION['success_flash'] = 'Your password has successfully been updated.';
				header('Location: index.php');
			}
		}
		?>
	</div>
	<h2 class="text-center">Change Password</h2><hr>
	<form action="change_password.php" method="post">
		<div class="form-group">
			<label for="old_password">Old Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
		</div>

		<div class="form-group">
			<label for="password">New Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>

		<div class="form-group">
			<label for="confirm">Confirm Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
		</div>


		<div class="form-group">
			<a href="login.php" class="btn btn-default">Cancel</a>
			<input type="submit" class="btn btn-success" value="Login">
		</div>
	</form>
	<p class="text-right"><a href="/online-mall/index.php">Visit Site</a></p>
</div>

<?php include 'includes/footer.php';?>
