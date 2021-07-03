<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
if(!is_logged_in()){
	login_error_redirect();
}

include 'includes/head.php';
include 'includes/navigation.php';
//restore product
if(isset($_GET['restore'])){
	$id = sanitize($_GET['restore']);
	$db->query("UPDATE products SET deleted = 0 WHERE id = '$id' ");
	header('Location: archive.php');
}

$presults = $db->query("SELECT * FROM products WHERE deleted = 1 ORDER BY title");
		
		
?>



	

<h2 class="text-center">Archives</h2>

<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped" > 
		<thead>
			<th></th><th>Products</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th></thead>
		<tbody>
			<?php while($product = mysqli_fetch_assoc($presults)):
			$childID = $product['categories'];
			$catsql = "SELECT * FROM Categories WHERE id = '$childID'";
			$result = $db->query($catsql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM Categories WHERE id = '$parentID'";
			$pResult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($pResult);
			$category = $parent['category'].'~'.$child['category'];
			?>
							
				<tr>
				<td>
					<a href="archive.php?restore=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-refresh"></span></a>
					
				</td>
				<td><?=$product['title'];?></td>
				<td><?=money($product['price']);?></td>
				<td><?=$category;?></td>
				<td>
					<a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>& id=<?=$product['id'];?>" class="btn btn-xs btn-default">
						<span class="glyphicon glyphicon-<?=(($product['featured'] == 1)?'minus':'plus');?>"></span></a>
						&nbsp <?=(($product['featured'] == 1)?'Featured Product':'Not Featured');?>
				</td>
				
				<td>0</td>
			</tr>
		<?php endwhile;?>
		</tbody>
	</table>
<?php include 'includes/footer.php';?>
