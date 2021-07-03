<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';

$name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$phone = sanitize($_POST['phone']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
$errors = array();
$required = array(
	'full_name' => 'Full Name',
	'email' => 'Email',
	'street' => 'Street Address',
	'phone' => 'Phone Number',
	'city' => 'City',
	'state' => 'State',
	'zip_code' => 'Zip Code',
	'country' => 'Country',
	);
//check if all required fields are out
foreach ($required as $f => $d) {
	if (empty($_POST[$f]) || $_POST[$f] == '') {
		$errors[] = $d. ' is required.';
	}
}

//check if valid email address
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
	$errors[] = 'Please enter a valid email.';
}

if(!empty($errors)){
	echo display_error($errors);
}else{
	echo "passed";
}
?>