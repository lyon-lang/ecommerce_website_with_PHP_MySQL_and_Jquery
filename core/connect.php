<?php
$db = mysqli_connect('localhost', 'root', '', 'markshop');
if(mysqli_connect_errno()){
	echo 'Database connnection failed due to the following errors:'. mysqli_connect_errno();
die();
}
 session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/config.php';
 require_once BASEURL.'helpers/helpers.php ';
 #payment integration are down below as comments
 #require BASEURL.'vendor/autoload.php';

 $cart_id = '';
 if(isset($_COOKIE[CART_COOKIE])){
 	$cart_id = sanitize($_COOKIE[CART_COOKIE]);
 }

if(isset($_SESSION['iuser'])){
	$user_id = $_SESSION['iuser'];
	$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fn[0];
	$user_data['last'] = $fn[1];
}

if(isset($_SESSION['cuser'])){
	$cuser_id = $_SESSION['cuser'];
	$query = $db->query("SELECT * FROM customers WHERE id = '$cuser_id'");
	$cuser_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $cuser_data['full_name']);
	$cuser_data['first'] = $fn[0];
	$cuser_data['last'] = $fn[1];
}

if(isset($_SESSION['vuser'])){
	$vuser_id = $_SESSION['vuser'];
	$query = $db->query("SELECT * FROM vendors WHERE id = '$vuser_id'");
	$vuser_data = mysqli_fetch_assoc($query);
	$fn = explode(' ', $vuser_data['full_name']);
	$vuser_data['first'] = $fn[0];
	$vuser_data['last'] = $fn[1];
}

if(isset($_SESSION['success_flash'])){
	echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>';
	unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
	echo '<div class="bg-danger"><p class="text-danger text-center">'.$_SESSION['error_flash'].'</p></div>';
	unset($_SESSION['error_flash']);
}

?>