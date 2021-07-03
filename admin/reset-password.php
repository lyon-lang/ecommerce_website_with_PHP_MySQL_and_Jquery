<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
include 'includes/head.php';

if(!isset($_GET["code"])){
    exit("Can't find page");

}
$code = $_GET["code"];

$getEmailQuery = $db->query("SELECT email FROM reset_passwords WHERE code = '$code'");
if(mysqli_num_rows($getEmailQuery) == 0){
    exit("Can't find page");
}

if(isset($_POST["password"])){
    $password = $_POST["password"];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $row = mysqli_fetch_array($getEmailQuery);
    $email = $row["email"];
    
    $query = $db->query("UPDATE users SET password ='$hashed' WHERE email = '$email'");
    if($query){
        $query = $db->query("DELETE FROM reset_passwords WHERE code ='$code'");
        exit("Password Updated succesfully");
    }else{
        exit("something went wrong");
    }
}

?>
<div id="login-form" style="background-color:#ffffff;">
	
	<h2 class="text-center">Forgot Password</h2><hr>
	<form method="post">
		<div class="form-group">
			
			<input type="password" name="password" id="password" class="form-control"  placeholder="New password">
		</div>

		<div class="form-group">
			
			<input type="submit" class="btn btn-success" style="border:none;background-color:#2af598;" value="Update password">
		</div>
		
	</form>
	<p class="text-right"><a href="/online-mall/index.php">Visit Site</a></p>
</div>

<?php include 'includes/footer.php';?>