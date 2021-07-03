<?php 
require_once 'core/connect.php';
include'includes/head.php';
include'includes/navigation.php';


$sql = "SELECT * FROM products";
$cat_id = (($_POST['cat'] != '')?sanitize($_POST['cat']):'');
// if($cat_id == ''){
// 	$sql .= " WHERE deleted = 0";
// }else{
// 	$sql .= " WHERE categories = '{$cat_id}' AND deleted = 0";
// }
$search = (($_POST['search'] != '')?sanitize($_POST['search']):'');

if($search != ''){
	$sql .= " WHERE title LIKE '%{$search}'";
}

$productQ = $db->query($sql);
$category = get_category($cat_id);
?>

<div class="container-fluid">

<?php include'includes/leftbar.php'; ?>
<!--main-->
<div class="col-md-10">
<div class="row">
	<?php if($search != ''): ?>
<h2 class="text-center"><?=$category['parent'].' '.$category['child'];?></h2>
	<?php else: ?>
<h2 style="background:linear-gradient(to right, #30cfd0 0%, #330867 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">KuCWebMall</h2>
	<?php endif;?>
<?php while ( $product = mysqli_fetch_assoc($productQ)) :?>
<div class="item" id="item" onclick="detailsmodal(<?= $product['id']; ?>)">
<h4><?= $product['title']; ?></h4>
<?php $photos = explode(',',$product['image'])?>
<img src="<?= $photos[0]; ?>" class="img-thumb" alt="<?= $product['title']; ?>" style="border-radius:15px;" >
<p class="list-price text-danger">WAS: <s>&#8373;<?= $product['list_price']; ?></s></p>
<p class="price"><b> <img src="images/vectors/tag.svg" class="grid-price-img"/> NOW: &#8373;<?= $product['price']?></b></p>

</div>

<?php endwhile; ?>
</div>
</div>
<?php
// include 'includes/rightbar.php';


?>
</div>
<?php 
include 'includes/footer.php';
?>