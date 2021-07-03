<?php 
require_once 'core/connect.php';
include'includes/head.php';
include'includes/navigation.php';
include'includes/leftbar.php';

if(isset($_GET['cat'])){
	$cat_id = sanitize($_GET['cat']);
}else{
	$cat_id = '';

}

?>
<!--top nav bar-->

<?php 
$sql = "SELECT * FROM products WHERE categories = '$cat_id' ";
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
<h2 class="text-center"><?=$category['parent'].' '.$category['child'];?></h2>
<?php while ( $product = mysqli_fetch_assoc($productQ)) :?>
<div class="item" id="item" onclick="detailsmodal(<?= $product['id']; ?>)">
<h4><?= $product['title']; ?></h4>
<?php $photos = explode(',',$product['image'])?>
<img src="<?= $photos[0]; ?>" class="img-thumb" alt="<?= $product['title']; ?>" style="border-radius:15px;">
<p class="list-price text-danger">WAS: <s>&#8373;<?= $product['list_price']; ?></s></p>
<p class="price"> <b><img src="images/vectors/tag.svg"> NOW: &#8373;<?= $product['price']?></b></p>
</div>

<?php endwhile; ?>
</div>
</div>

</div>
<?php 
include 'includes/footer.php';
?>