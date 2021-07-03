<?php
require_once 'core/connect.php';


if($cart_id != ''){
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$result = mysqli_fetch_assoc($cartQ);
	$items =json_decode($result['items'],true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;



foreach ($items as $item) {

            $product_id = $item['id'];
			$prouctQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
			$product = mysqli_fetch_assoc($prouctQ);	

            $item_count += $item['quantity'];
			$sub_total += ($product['price'] * $item['quantity']);
}

            $tax = TAXRATE * $sub_total;
			 $tax = number_format($tax,2);
			 $grand_total = $tax + $sub_total;
			 

//some stripe code goes here
//in the stripe paid in cart is update to 1
//the transactions details is inserted inthe transactions table 
//adjust the inventory

//adjust inventory
$itemQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresults['items'],true);
foreach($items as $item){
    $newSizes = array();
    $item_id = $item['id'];
    $productQ = $db->query("SELECT sizes FROM products WHERE id = '{$item_id}'");
    $product = mysqli_fetch_assoc($productQ);
    $sizes = sizesToArray($product['sizes']);
    foreach($sizes as $size){
        if($size['size'] == $item['size']){
            $q = $size['quantity'] - $item['quantity'];
            $newSizes[] = array('size' => $size['size'], 'quantity' => $q, 'threshold' => $size['threshold']);
        }else{
            $newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity'], 'threshold' => $size['threshold']);
        }

    }
    $sizeString = sizesToString($newSizes);
    $db->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}'");
}

//Get the rest of the post data
$full_name = sanitize($_POST['full_name']);
$email = sanitize($_POST['email']);
$street = sanitize($_POST['street']);
$phone = sanitize($_POST['phone']);
$city = sanitize($_POST['city']);
$state = sanitize($_POST['state']);
$zip_code = sanitize($_POST['zip_code']);
$country = sanitize($_POST['country']);
//$sub_total = sanitize($_POST['sub_total']);
//$tax = sanitize($_POST['tax']);
//$grand_total = sanitize($_POST['grand_total']);
$description = '';
$txn_type = 'MOMO';
//$charge_amount = number_format($grand_total, 2) * 100;
//Update cart
$db->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}'");
$db->query("INSERT INTO transactions (charge_id,cart_id,full_name,email,street,phone,city,state,zip_code,country,sub_total,tax,grand_total,description,txn_type)
            VALUES ('$charge_id','$cart_id','$full_name','$email','$street','$phone','$city','$state','$zip_code','$country','$sub_total','$tax','$grand_total','$description','$txn_type')");

$domain = ($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/head.php';
include 'includes/navigation.php';
?>
<h1 class="text-center text-success">Thank You!</h1>
<p>Your card has successfuly being charged <?=money($grand_total);?>. You have been emailed a receipt. Please
check your spam folder if not in your inbox. Addictionally you can print this page as a receipt.</p>
<p>You receipt number is: <strong><?=$cart_id;?></strong></p>
<p>Your order will be shipped to the address below</p>
<address>
<?=$full_name; ?><br>
<?=$street; ?><br>
<?=(($phone != '')?$phone.'<br>':'');?><br>
<?=$city.', '.$state.' '.$zip_code;?><br>
<?=$country;?><br>

</address>
<?php
} 
include 'includes/head.php';
?>