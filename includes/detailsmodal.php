<?php
require_once '../core/connect.php';

$id = $_POST['id'];
$id = (int)$id;
$sql = "SELECT * FROM products WHERE id = '$id'";
$result = $db->query($sql);
$product = mysqli_fetch_assoc($result);
$brand_id = $product['brand'];
$sql = "SELECT brand FROM brand WHERE id = '$brand_id'";
$brand_query = $db->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$seller_id = $product['seller_id'];
$sql = "SELECT shop_name FROM vendors WHERE id = '$seller_id'";
$seller_query = $db->query($sql);
$seller = mysqli_fetch_assoc($seller_query);
$sizestring = $product['sizes'];
$sizestring = rtrim($sizestring,',');
$size_array = explode(',', $sizestring)
?>

<?php ob_start(); ?>
<!--details modal-->
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="detail-1" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button class="close" type="button" onclick="closeModal()" aria-lable="close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title text-center"><?= $product['title']; ?></h4>
</div>
<div class="modal-body">
<div class="container-fluid">
<div class="row">
	<span id="modal_errors" class="bg-danger"></span>
<div class="col-sm-6 fotorama">
	<?php $photos = explode(',', $product['image']);
	foreach($photos as $photo):?>
<img src="<?=$photo; ?>" alt="<?= $product['title']; ?>" class="details img-responsive" >
<?php endforeach; ?>
</div>  
<div class="col-sm-6">
<h4>Details</h4>
<p><?= nl2br($product['description']); ?></p>
<hr>
<p>price: &#8373;<?= $product['price']; ?></p>
<p>brand: <?= $brand['brand']; ?> </p>
<p>seller: <?= $seller['shop_name']; ?> </p>
<form action="index.php" method="post" id="add_product_form">
	<input type="hidden" name="product_id" id="product_id" value="<?=$id;?>">
	<input type="hidden" name="available" id="available" value="">
<div class="form-group">
<div class="col-xs-3">
<label for="quantity">Quantity:</label>
<input type="number" class="form-control" id="quantity" name="quantity" min="0">
</div>

</div>
<br><br><br><br>
<div class="form-group">
<label for="size">Size:</label>
<select name="size" class="form-control" id="size">
<option value=""></option>
<?php foreach ($size_array as $string) {
	$string_array = explode(':', $string);
	$size = $string_array[0];
	$available = $string_array[1];
	if($available > 0){
		echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.' Available)</option>';
	}
} ?>


</select>

</div>

</form>
</div>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-default" onclick="closeModal()">close</button>
<button class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
</div>
</div>
</div>
</div>
</div>
<script>

jQuery('#size').change(function(){
	var available = jQuery('#size option:selected').data("available");
	jQuery('#available').val(available);
});
	$(function(){
		$('.fotorama').fotorama({'loop':true,'autoplay':true});
	});

 function closeModal(){
 	jQuery('#details-modal').modal('hide');
 	setTimeout(function(){
 		jQuery('#details-modal').remove();
 		jQuery('.modal-backdrop').remove();
 	},500);
 }
</script>
<?php echo ob_get_clean(); ?>