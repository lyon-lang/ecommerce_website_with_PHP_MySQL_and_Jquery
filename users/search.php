<?php 
require_once '../core/connect.php';
include'includes/head.php';
include'../includes/navigation.php';
include'../includes/leftbar.php';

$sql = "SELECT * FROM products";
$cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
if($cat_id == ''){
	$sql .= " WHERE deleted = 0";
}else{
	$sql .= " WHERE categories = '{$cat_id}' AND deleted = 0";
}
$price_sort = (($_POST['price_sort'] != '')?sanitize($_POST['price_sort']):'');
$min_price = (($_POST['min_price'] != '')?sanitize($_POST['min_price']):'');
$max_price = (($_POST['max_price'] != '')?sanitize($_POST['max_price']):'');
$brand = (($_POST['brand'] != '')?sanitize($_POST['brand']):'');
if($min_price != ''){
	$sql .= " AND price >= '{$min_price}'";
}
if($max_price != ''){
	$sql .= " AND price <= '{$max_price}'";
}
if($brand != ''){
	$sql .= " AND brand = '{$brand}'";
}
if($price_sort == 'low'){
	$sql .= " ORDER BY price";
}
if($price_sort == 'high'){
	$sql .= " ORDER BY price DESC";
}
$productQ = $db->query($sql);
$category = get_category($cat_id);
?>
<!--top header-->
<div id="headerWrapper">
<div id="back-flower"></div>
<div id="logotext"></div>
<div id="for-flower"></div>
</div>
<div class="container-fluid">


<!--main-->
<div class="col-md-10">
<div class="row">
	<?php if($cat_id != ''): ?>
<h2 class="text-center"><?=$category['parent'].' '.$category['child'];?></h2>
	<?php else: ?>
<h2 style="background:linear-gradient(to right, #30cfd0 0%, #330867 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">KuCWebMall</h2>
	<?php endif;?>
<?php while ( $product = mysqli_fetch_assoc($productQ)) :?>
<div class="item" id="item" onclick="detailsmodal(<?= $product['id']; ?>)">
<h4><?= $product['title']; ?></h4>
<?php $photos = explode(',',$product['image'])?>
<img src="<?= $photos[0]; ?>" class="img-thumb" alt="<?= $product['title']; ?>" style="border-radius:15px;">
<p class="list-price text-danger">WAS: <s>&#8373;<?= $product['list_price']; ?></s></p>
<p class="price"><b> <img src="../images/vectors/tag.svg" class="grid-price-img"/>NOW: &#8373;<?= $product['price']?></b></p>
<!-- <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)" style="border:none;background:#30cfd0;">Details</button> -->
</div>

<?php endwhile; ?>
</div>
</div>

</div>
<?php 
include '../includes/footer.php';
?>