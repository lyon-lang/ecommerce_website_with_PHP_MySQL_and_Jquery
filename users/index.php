<?php 
require_once '../core/connect.php';
include 'includes/head.php';
include '../includes/navigation.php';
if(!is_clogged_in()){
	header('Location: login.php');
}

?>
<!--top nav bar-->

<?php 
$sql = "SELECT * FROM products WHERE featured = 1 ";
$featured = $db-> query($sql);
?>
<!--top header-->
<?php 
$sql = "SELECT * FROM categories WHERE parent = 0 ";
$pquery= $db->query($sql);
?>
<div id="headerWrapper">
<div id="back-flower"></div>
<div id="logotext"></div>
<div id="for-flower"></div>
</div>
<div class="container-fluid">


<!--main-->
<div class="row">
<?php include'../includes/leftbar.php';?>
<div class="col-md-10">

<h2 style="background:linear-gradient(to right, #30cfd0 0%, #330867 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">categories</h2>
<div class="container-fluid">
		<ul class="nav navbar-nav" style="color:#3c4512;text-decoration:none;font-size:18px;">
			<?php while ( $parent = mysqli_fetch_assoc($pquery)) :?>
			<?php 
			$parent_id = $parent['id'];
			$sql2 ="SELECT * FROM categories WHERE parent = '$parent_id'";
			$cquery= $db->query($sql2);
			?>
			<!--menu items-->
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'];?><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<?php while($child = mysqli_fetch_assoc($cquery)) :?>
					<li><a href="category.php?cat=<?=$child['id'];?>"><?php echo $child['category'];?></a></li>
					<?php endwhile?>
				</ul>
			</li>
			<?php endwhile; ?>
			
		</ul>
	
	</div>
<h2 style="background:linear-gradient(to right, #30cfd0 0%, #330867 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">featured items</h2>
<?php while ( $product = mysqli_fetch_assoc($featured)) :?>
<div class="item" id="item" onclick="detailsmodal(<?= $product['id']; ?>)">
<h4><?= $product['title']; ?></h4>
<?php $photos = explode(',',$product['image'])?>
<img src="<?= $photos[0]; ?>" class="img-thumb" alt="<?= $product['title']; ?>" style="border-radius:15px;" >
<p class="list-price text-danger">WAS: <s>&#8373;<?= $product['list_price']; ?></s></p>
<p class="price"><b> <img src="../images/vectors/tag.svg" class="grid-price-img"/> NOW: &#8373;<?= $product['price']?></b></p>
<!-- <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)" style="border:none;background:#30cfd0;">Details</button> -->
</div>

<?php endwhile; ?>
</div>


<?php
// include '../includes/rightbar.php';


// include '../includes/widgets/recent.php';
?>
</div>
</div>
<?php 
include 'includes/footer.php';
?>