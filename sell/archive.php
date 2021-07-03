<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
if(!is_vlogged_in()){
	login_error_redirect();
}

include 'includes/head.php';

//restore product
if(isset($_GET['restore'])){
	$id = sanitize($_GET['restore']);
	$db->query("UPDATE products SET deleted = 0 WHERE id = '$id' ");
	header('Location: archive.php');
}
$sid = $vuser_data['id']; 
$presults = $db->query("SELECT * FROM products WHERE deleted = 1 AND seller_id = $sid ORDER BY title");
		
		
?>



<div class="wrapper">
<?php include 'includes/navigation.php'; ?>
<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
		<button  onclick="toggleSidebar()" type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-align-left"></i>
			

		</button>
	

	</nav>	

	<h2 class="text-center">Archives</h2>

<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped" > 
		<thead>
			<th></th><th>Products</th><th>Price</th><th>Category</th><th>Sold</th></thead>
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
				
				<td>0</td>
			</tr>
		<?php endwhile;?>
		</tbody>
	</table>
<?php include 'includes/footer.php';?>

</div>
</div>
