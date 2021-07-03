<?php
require_once 'core/connect.php';
include 'includes/head.php';
include 'includes/navigation.php';
if(!is_clogged_in()){
	header('Location: users/login.php');
}
if($cart_id != ''){
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$result = mysqli_fetch_assoc($cartQ);
	$items =json_decode($result['items'],true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;

}
?>
<?php foreach ($items as $item) {

$product_id = $item['id'];
			$prouctQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
			$product = mysqli_fetch_assoc($prouctQ);	

$item_count += $item['quantity'];
			$sub_total += ($product['price'] * $item['quantity']);
}

$tax = TAXRATE * $sub_total;
			 $tax = number_format($tax,2);
			 $grand_total = $tax + $sub_total;
			 
?>

<style>
form label {font-size:12px; text-transform:uppercase }
.-header-{display:none}
.form-control{border-radius:100px; border:2px solid #eee; box-shadow:none; height:32px}
button{height:30px; background:black; border-radius:100px; width:50%; color:white; border:none}
</style>
<p>&nbsp;</p><p>&nbsp;</p>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<center><h2 style='font-family:proxima-bold'>Payment</h2></center>
<p>&nbsp;</p>
<div class='container'>
<form action="thankYou.php" method="POST" id="payment-form">
	<div class="form-group col-md-6">
		<label for="email">Email *</label>
		<input type="email" name="email" Placeholder="E-mail" class="form-control" id="email">
	</div>
	<div class="form-group col-md-6">
		<label for="name">Name</label>
		<input type="text" name="name" Placeholder="Name" class="form-control" id="name">
	</div>
	<div class="form-group col-md-6">
		<label for="phone">Phone</label>
		<input type="text" name="phone" Placeholder="Phone" class="form-control" id="phone">
	</div>
	<div class="form-group col-md-6">
		<label for="amount">Amount</label>
		<input type="text" name="amount" class="form-control"  id="amount" value="<?php echo $grand_total; ?>" disabled >
	</div>
		<div class="form-group col-md-6">
		<label for="currency">Currency</label>
		<input type="text" name="currency" class="form-control" id="currency" value="GHS" disabled>
	</div>
	<p>&nbsp;</p>
 <script src="https://checkout.flutterwave.com/v3.js"></script>
  <button type="button" onClick="makePayment()">Pay Now</button>


</form>

</div>
<script>

  function makePayment() {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-e2dd161aff14f35de22deecdefe0f543-X",
      tx_ref: "hooli-tx-1920bbtyt",
      amount: $('#amount').val(),
      currency: $('#currency').val(),
      country: "GH",
      payment_options: "card, mobilemoneyghana",
      redirect_url: // specified redirect URL
        "https://localhost/remake/thankyou.php",
      meta: {
        consumer_id: 23,
        consumer_mac: "92a3-912ba-1192a",
      },
      customer: {
        email: $('#email').val(),
        phone_number: $('#phone').val(),
        name: $('#name').val(),
      },
      callback: function (data) {
        console.log(data);
      },
      onclose: function() {
        // close modal
      },
      customizations: {
        title: "KUC MALL",
        description: "Payment for items in cart",
        logo: "https://assets.piedpiper.com/logo.png",
      },
    });
  }
</script>
