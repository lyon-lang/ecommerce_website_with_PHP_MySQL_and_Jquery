<?php
require_once 'core/connect.php';
include 'includes/head.php';
include 'includes/navigation.php';

if($cart_id != ''){
	$cartQ = $db->query("SELECT * FROM cart WHERE id = '{$cart_id}'");
	$result = mysqli_fetch_assoc($cartQ);
	$items =json_decode($result['items'],true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;

}
?>

<div class="container-fluid">
<div class="col-md-12">

	<div class="row">
	
		<h2 class="text-center">My Shopping Cart</h2><hr>
		<?php if($cart_id == ''): ?>
		<div class="bg-danger ">
			<p class="text-center text-danger">
				Your shopping cart is empty!
			</p>
		</div>
	<?php else: ?>
	<table class="table table-bordered table-condensed table-striped">
		<thead>
			<th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub Total</th>
		</thead>
		<tbody>
			<?php
			foreach ($items as $item) {
			$product_id = $item['id'];
			$prouctQ = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
			$product = mysqli_fetch_assoc($prouctQ);
			$sArray = explode(',', $product['sizes']);
			foreach ($sArray as $sizeString) {
				$s = explode(':', $sizeString);
				if ($s[0] == $item['size']) {
					$available = $s[1];
				}
			}?>
				<tr>
					<td><?=$i;?></td>
					<td><?=$product['title'];?></td>
					<td><?=money($product['price']);?></td>
					<td>
						<button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>')">-</button>
						<?=$item['quantity'];?>
						<?php if($item['quantity'] < $available): ?>
						<button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>')">+</button>
					    <?php else:?>
					    <span class="text-danger">Max</span>
						<?php endif; ?>
					</td>
					<td><?=$item['size'];?></td>
					<td><?=money($item['quantity'] * $product['price']);?></td>
				</tr>

			<?php
			$i++;
			$item_count += $item['quantity'];
			$sub_total += ($product['price'] * $item['quantity']);
			 } 
			 $tax = TAXRATE * $sub_total;
			 $tax = number_format($tax,2);
			 $grand_total = $tax + $sub_total;
			 ?>
		</tbody>
	</table>
	<table class="table table-bordered table-condensed text-right">
		<legend>Totals</legend>
		<thead class="totals-table-header">
			<th>Total Items</th><th>Sub Total</th><th>Tax</th><th>Grand Total</th>
		</thead>
		<tbody>
			
				<tr>
					<td><?=$item_count;?></td>
					<td><?=money($sub_total);?></td>
					<td><?=money($tax);?></td>
					<td class="bg-success"><?=money($grand_total);?></td>
					
				</tr>

		</tbody>
	</table>
	<!--check out button-->
	
<!-- <button class="btn btn-primary pull-right" type="submit" data-toggle="modal" data-target="#checkoutModal">
	<span class="glyphicon glyphicon-shopping-cart"></span>Check Out >>
</button> -->
<a href="check_out.php">
<button class="btn btn-primary pull-right" >
	
	<span class="glyphicon glyphicon-shopping-cart"></span>Check Out >>
	
</button></a>
	<!--details modal-->
	
<div class="modal fade details-1" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModallabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button class="close" type="button" onclick="closeModal()" aria-lable="close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title text-center" id="checkoutModallabel">Shipping Address</h4>
</div>
<div class="modal-body">
<div class="container-fluid">
<div class="row">
<form action="thankYou.php" method="POST" id="payment-form">
	<span class="bg-danger" id="payment-errors"></span>

<div id="step1" style="display:block;">
	<div class="form-group col-md-6">
		<label for="full_name">Full Name:</label>
		<input type="text" name="full_name" class="form-control" id="full_name">
	</div>
	<div class="form-group col-md-6">
		<label for="email">Email:</label>
		<input type="email" name="email" class="form-control" id="email">
	</div>
	<div class="form-group col-md-6">
		<label for="street">Street Address:</label>
		<input type="text" name="street" class="form-control" id="street">
	</div>
	<div class="form-group col-md-6">
		<label for="street2">Street Address 2:</label>
		<input type="text" name="street2" class="form-control" id="street2">
	</div>
	<div class="form-group col-md-6">
		<label for="city">City:</label>
		<input type="text" name="city" class="form-control" id="city">
	</div>
		<div class="form-group col-md-6">
		<label for="state">State:</label>
		<input type="text" name="state" class="form-control" id="state">
	</div>
	<div class="form-group col-md-6">
		<label for="zip_code">Zip Code:</label>
		<input type="text" name="zip_code" class="form-control" id="zip_code">
	</div>
	<div class="form-group col-md-6">
		<label for="country">Country:</label>
		<input type="text" name="country" class="form-control" id="country">
		<input type="hidden" name=<?=money($grand_total); ?> class="form-control" id="grand_total" >
	</div>
	

</div>
<div id="step2" style="display:none;">

	<div class="form-group col-md-3">
		<label for="name">Name on Card:</label>
		<input type="text" class="form-control" id="name"><!--some stripe attributes goes inthere same goes for the input below eg is data.stripe=name-->
	</div>
	<div class="form-group col-md-3">
		<label for="number">Card number:</label>
		<input type="text" class="form-control" id="number">
	</div>
	<div class="form-group col-md-2">
		<label for="cvc">CVC:</label>
		<input type="text" class="form-control" id="cvc">
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
<button class="btn btn-default" data-dismiss="modal">close</button>
<button class="btn btn-primary" type="button" onclick="check_address();" id="next-button">Next >></button>
<button class="btn btn-primary" type="button" onclick="back_address();" id="back-button" style="display:none;"><< Back </button>
<button class="btn btn-primary" type="submit" onclick="check_address();" id="check-out-button" style="display:none;">Check Out >></button>
</div>
</form>
</div>
</div>
</div>
</div>
	<?php endif;?>
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
	'grand_total' : jQuery('#grand_total').val(),

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
</script>


<?php 
include 'includes/footer.php';
 ?>