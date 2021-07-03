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
?>
<div class="container-fluid">
<div class="col-md-12">
	
    

	<!--details modal-->
	

<h2 class="text-center">Shipping Address</h2>
</div>
<div class="modal-body">
<div class="container-fluid">
<div class="row">
<form action="thankYou.php" method="POST" id="payment-form">
	<span class="bg-danger" id="payment-errors"></span>

<div id="step1" style="display:block;">
	<div class="form-group col-md-6">
		<label for="full_name">Full Name:</label>
		<input type="text" name="full_name" class="form-control" id="full_name" style="border-radius:20px;">
	</div>
	<div class="form-group col-md-6">
		<label for="email">Email:</label>
		<input type="email" name="email" class="form-control" id="email" style="border-radius:20px;">
	</div>
	<div class="form-group col-md-6">
		<label for="street">Street Address:</label>
		<input type="text" name="street" class="form-control" id="street" style="border-radius:20px;">
	</div>
	<div class="form-group col-md-6">
		<label for="street2">Street Address 2:</label>
		<input type="text" name="street2" class="form-control" id="street2" style="border-radius:20px;">
	</div>
	<div class="form-group col-md-6">
		<label for="city">City:</label>
		<input type="text" name="city" class="form-control" id="city" style="border-radius:20px;">
	</div>
		<div class="form-group col-md-6">
		<label for="state">State:</label>
		<input type="text" name="state" class="form-control" id="state" style="border-radius:20px;">
	</div>
	<div class="form-group col-md-6">
		<label for="zip_code">Zip Code:</label>
		<input type="text" name="zip_code" class="form-control" id="zip_code" style="border-radius:20px;">
	</div>
	<div class="form-group col-md-6">
		<label for="country">Country:</label>
		<input type="text" name="country" class="form-control" id="country" style="border-radius:20px;">
	</div>
	

</div>
<div id="step2" style="display:none;">

	<div class="form-group col-md-3">
		<label for="phone">Phone</label>
		<input type="text" name="phone" Placeholder="Phone" class="form-control" id="phone"><!--some stripe attributes goes inthere same goes for the input below eg is data.stripe=name-->
	</div>
	<div class="form-group col-md-3">
		<label for="amount">Amount</label>
		<input type="text" name="amount" class="form-control"  id="amount" value="<?php echo $grand_total; ?>" disabled >
	</div>
	<div class="form-group col-md-2">
		<label for="currency">Currency</label>
		<input type="text" name="currency" class="form-control" id="currency" value="GHS" disabled>
	</div>
	<div class="form-group col-md-2">
		<label for="exp-month">Expire month:</label>
		<select id="exp-month" class="form-control">
			<option value=""></option>
		<?php for($i=1;$i < 13;$i++): ?>
		<option value="<?=$i;?>"><?=$i;?></option>
		<?php endfor;?>
		</select>
	</div>
	<div class="form-group col-md-2">
		<label for="exp-year">Expire year:</label>
		<select id="exp-year" class="form-control">
			<option value=""></option>
			<?php $yr = date("Y");?>
		<?php for($i=1;$i < 11;$i++): ?>
		<option value="<?=$yr + $i;?>"><?=$yr + $i;?></option>
		<?php endfor;?>
		</select>
	</div>
	
</div>


</div>
</div>
<div class="modal-footer">
<button class="btn btn-default" data-dismiss="modal" style="border-radius:20px;">close</button>
<button class="btn btn-primary" type="button" onclick="check_address();" id="next-button" style="border-radius:20px;">Next >></button>
<button class="btn btn-primary" type="button" onclick="back_address()" id="back-button" style="display:none;border-radius:20px;"><< Back </button>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<button class="btn btn-primary" type="button" onclick="makePayment();" id="check-out-button" style="display:none;border-radius:20px;">Check Out >></button>
</div>
</form>

	
	</div>
</div>

</div>
 

<script>
function back_address(){
	jQuery('#payment-errors').html("");
					jQuery('#step1').css("display","block");
					jQuery('#step2').css("display","none");
					jQuery('#next-button').css("display","inline-block");
					jQuery('#back-button').css("display","none");
					jQuery('#check-out-button').css("display","none");
					jQuery('#checkoutModallabel').html("Shipping Address");

}
function check_address(){
var data = {
	'full_name' : jQuery('#full_name').val(),
	'email' : jQuery('#email').val(),
	'street' : jQuery('#street').val(),
	'street2' : jQuery('#street2').val(),
	'city' : jQuery('#city').val(),
	'state' : jQuery('#state').val(),
	'zip_code' : jQuery('#zip_code').val(),
	'country' : jQuery('#country').val(),
};
jQuery.ajax({
			url: '/online-mall/admin/parsers/check_address.php',
			method: 'post',
			data: data,
			success: function(data){
				if(data != 'passed'){
					jQuery('#payment-errors').html(data);
					

				}
				if(data == 'passed'){
					jQuery('#payment-errors').html("");
					jQuery('#step1').css("display","none");
					jQuery('#step2').css("display","block");
					jQuery('#next-button').css("display","none");
					jQuery('#back-button').css("display","inline-block");
					jQuery('#check-out-button').css("display","inline-block");
					jQuery('#checkoutModallabel').html("Enter Your Card Details");

				}
			},
			error: function(){
			 alert("something went wrong"); 
			}
});

}
//below is still for the stripe gateway configration
//Stripe.setPublishableKey('? #STRIPE_PUBLIC; ?'); //the key goes in the
//stripe response handler goes here followed by some stripe function
function makePayment() {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-e2dd161aff14f35de22deecdefe0f543-X",
      tx_ref: "hooli-tx-1920bbtyt",
      amount: $('#amount').val(),
      currency: $('#currency').val(),
      country: "GH",
      payment_options: "card, mobilemoneyghana",
      redirect_url: // specified redirect URL
        "https://localhost/online-mall/thankYou.php",
      meta: {
        consumer_id: 23,
        consumer_mac: "92a3-912ba-1192a",
      },
      customer: {
        email: $('#email').val(),
        phone_number: $('#phone').val(),
        name: $('#full_name').val(),
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


<?php 
include 'includes/footer.php';
 ?>