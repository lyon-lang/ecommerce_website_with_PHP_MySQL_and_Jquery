<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
include 'includes/head.php';

// $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
// $email = trim($email);
// $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
// $password = trim($password);
// $errors = array();

?>
<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
// Instantiation and passing `true` enables exceptions

if(isset($_POST["email"])){
	$emailTo = $_POST["email"];
	$code = uniqid(true);
	
	$insertCode = $db->query("INSERT INTO reset_passwords (code, email) VALUES ('$code', '$emailTo')");
	if(!$insertCode){
		exit("Error!");
	}

	$mail = new PHPMailer(true);

	try {
		//Server settings 
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'bistetteh19@gmail.com';                     // SMTP username
		$mail->Password   = 'th3KingLion';                               // SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom('bistetteh19@gmail.com', 'KuCWebMall');
		$mail->addAddress($emailTo);     // Add a recipient
		$mail->addReplyTo('no-reply@kucwebmall.com', 'No Reply');
		

		// Content
		$url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/reset-password.php?code=$code";
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Your password reset link';
		$mail->Body    = "<h1>You requested a password reset </h1>
							click <a href='$url'>this link</a> to do so";
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->send();
		echo 'Reset Password link has been sent to your email';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
	exit();
}

?>
<style>
body{
	background: #ffffff;
}
</style>
<div id="login-form" style="background-color:#ffffff;">
	<div>
		<?php
		// if($_POST){
		// 	//form validation
		// 	if(empty($_POST['email']) || empty($_POST['password'])){
		// 		$errors[] = 'You must provide email and password.';

		// 	}
		// 	//validate email
		// 	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		// 		$errors[] = 'You must enter a valid Email.';
		// 	}
		// 	//check if password is more than 6 characters
		// 	if(strlen($password) < 6){
		// 		$errors[] = 'Password must be atleast 6 characters.';
		// 	}
		// 	//check if email exists in database
		// 	$query = $db->query("SELECT * FROM customers WHERE email ='$email'");
		// 	$user = mysqli_fetch_assoc($query);
		// 	$userCount = mysqli_num_rows($query);
		// 	if($userCount < 1){
		// 		$errors[] = 'User doesn\'t  exists in our database.';
		// 	}
		// 	//
		// 	if(!password_verify($password, $user['password'])){
		// 		$errors[] = 'Password does not match our records. Please try again';
		// 	}
		// 	//check for errors
		// 	if(!empty($errors)){
		// 		echo display_error($errors);
		// 	}else{
		// 		//login
		// 		$userid = $user['id'];
		// 		custlogin($userid);
		// 	}
		// }
		?>
	</div>
	<h2 class="text-center">Forgot Password</h2><hr>
	<form method="post">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control"  placeholder="Email">
		</div>

		<div class="form-group">
			
			<input type="submit" class="btn btn-success" style="border:none;background-color:#2af598;" value="Reset Password">
		</div>
		
	</form>
	<p class="text-right"><a href="/online-mall/index.php">Visit Site</a></p>
</div>

<?php include 'includes/footer.php';?>
