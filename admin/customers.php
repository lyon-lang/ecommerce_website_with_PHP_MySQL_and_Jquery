<?php
require_once '../core/connect.php';
if(!is_logged_in()){
	login_error_redirect();
}
if(!has_permission('admin')){
	permission_error_redirect('index.php');
}
include 'includes/head.php';


if(isset($_GET['delete'])){
	$delete_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM customers WHERE id ='$delete_id'");
	$_SESSION['success_flash'] = 'User has been deleted';
	header('Location: customers.php');
}
if(isset($_GET['add'])){

	$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm = ((isset($_POST['confirm']) )?sanitize($_POST['confirm']):'');
	
	$errors = array();
	if($_POST){

		$emailQuery = $db->query("SELECT * FROM customers WHERE email = '$email'");
		$emailCount = mysqli_num_rows($emailQuery);

		if($emailCount != 0){
			$errors[] = 'This email already exists in our database.';
		}
		$required = array('name', 'email', 'password', 'confirm');
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
			$db->query("INSERT INTO customers(full_name,email,password) VALUES('$name', '$email', '$hashed')");
			$_SESSION['success_flash'] = 'User have been added!';
			header('Location: customers.php');
		}
	}

	?>
<div class="wrapper">
<?php include 'includes/navigation.php'; ?>
<div id="content">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
		
		<button onclick="toggleSidebar()" type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-align-left"></i>
			

		</button>


</nav>
	<h2 class="text-center">Add A New Customer</h2><hr>

	<form action="customers.php?add=1" method="POST">

		<div class="form-group col-md-6 ">
			<label for="name">Full Name*:</label>
			<input type="text" name="name" class="form-control" id="name" value="<?=$name;?>">
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
			<a href="customers.php" class="btn btn-default">Cancel</a>
			<input type="submit" class="btn btn-success" value="Add Customer" style="border:none;background-color:#2af598;">
		</div>

	</form>
	</div>
	</div>
<?php
}else{
$userQuery = $db->query("SELECT * FROM customers ORDER BY full_name");

?>
<div class="wrapper">
<?php include 'includes/navigation.php'; ?>
<div id="content">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
		
		<button onclick="toggleSidebar()" type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-align-left"></i>
			

		</button>


</nav>
<h2 class="text-center">Customers</h2>
	<a href="customers.php?add=1" class="btn btn-success pull-right" id="add-product-btn" style="border:none;background-color:#2af598;">Add New Customer</a>
<hr>
<table class="table table-bordered table-condensed table-striped" > 
		<thead>
			<th></th><th>Name</th><th>Email</th><th>Join Date</th><th>Last login</th></thead>
		<tbody>
			<?php while ($users = mysqli_fetch_assoc($userQuery)):?>
							
				<tr>
				<td>
					<?php if($users['id'] != $user_data['id']): ?>
						
						<a href="customers.php?delete=<?=$users['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
					<?php endif;?>
				</td>
				<td><?=$users['full_name'];?></td>
				<td><?=$users['email'];?></td>
				<td><?=pretty_date($users['join_date']);?></td>
				<td><?=(($users['last_login'] == '0000-00-00 00:00:00')?'Never':pretty_date($users['last_login']));?></td>
				
			</tr>
			<?php endwhile;?>
		</tbody>
	</table>
<?php } include 'includes/footer.php';?>
</div>
</div>