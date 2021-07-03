<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
if(!is_vlogged_in()){
	login_error_redirect();
}

include 'includes/head.php';

//check

if(isset($_GET['delete'])){
	$id = sanitize($_GET['delete']);
	$db->query("UPDATE products SET deleted = 1 WHERE id ='$id'");
	header('Location: products.php');
}
$dbPath = '';
if (isset($_GET['add']) || isset($_GET['edit'])) {
	$brandQuery = $db->query("SELECT * FROM brand ORDER BY brand ");
	$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category ");
	$seller_id = $vuser_data['id']; 
	$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
	$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
	$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
	$category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
	$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
	$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
	$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
	$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
	$sizes = rtrim($sizes, ',');
	$saved_image = '';
	if(isset($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$productresults = $db->query("SELECT * FROM products WHERE id = $edit_id");
		$product = mysqli_fetch_assoc($productresults);
		if(isset($_GET['delete_image'])){
			$imgi = (int)$_GET['imgi'] - 1;
			$images = explode(',', $product['image']);
			$image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi]; //echo $image_url;			
			unlink($image_url);
			unset($images[$imgi]);
			$imageString = implode(',',$images);
			$db->query("UPDATE products SET image = '{$imageString}' WHERE id = $edit_id");
			header('Location: products.php?edit='.$edit_id);
		}
		$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
		$seller_id = $vuser_data['id']; 
		$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
		$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
		$parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
		$parentResult = mysqli_fetch_assoc($parentQ);
		$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
		$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
		$list_price = ((isset($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
		$description = ((isset($_POST['description']))?sanitize($_POST['description']):$product['description']);
		$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
		$sizes = rtrim($sizes, ',');
		$saved_image = (($product['image'] != '')?$product['image']:'');
		$dbPath = $saved_image;

	}
	if(!empty($sizes)){
			$sizeString = sanitize($sizes);
			$sizeString = rtrim($sizeString ,','); 
			$sizesArray = explode(',', $sizeString);
			$sArray = array();
			$qArray = array();
			$tArray = array();
			foreach ($sizesArray as $ss) {
				$s = explode(':', $ss);
				$sArray[] = $s[0];
				$qArray[] = $s[1];
				$tArray[] = $s[2];
			}
		}else{
			$sizesArray = array();
		}
	$sizesArray = array();
	if($_POST){
		$errors = array();
		$required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
		$allowed = array('png', 'jpg', 'jpeg', 'gif');
		$photoName = array();
		$uploadPath = array();
		$tmpLoc = array();
		foreach ($required as $field) {
			if($_POST[$field] == ''){
				$errors[] = 'All fields with asterisks are required.';
				break;
			}
		}
	
		$photo_count = count($_FILES['photo']['name']);
		if ($photo_count > 0) {
			for ($i=0; $i<$photo_count;$i++) {
			
		 	$name = $_FILES['photo']['name'][$i];
		 	$nameArray = explode('.', $name);
		 	$fileName = $nameArray[0];
		 	$fileExt = $nameArray[1];
		 	$mime = explode('/',$_FILES['photo']['type'][$i]);
		 	$mimeType = $mime[0];
		 	$mimeExt = $mime[1];
		 	$tmpLoc[] = $_FILES['photo']['tmp_name'][$i];
		 	$fileSize = $_FILES['photo']['size'][$i];
		 	$uploadName = md5(microtime().$i).'.'.$fileExt;
		 	$uploadPath[] = BASEURL.'images/products/'.$uploadName;
		 	if($i != 0){
		 		$dbPath .= ',';
		 	}
		 	$dbPath .= '/online-mall/images/products/'.$uploadName; 
		 	if($mimeType != 'image'){
		 		$errors[] = 'The file must be an image.';

		 	}
		 	if(!in_array($fileExt, $allowed)){
		 		$errors[] = 'The file extension must be a png, jpg, jpeg or gif.';

		 	}
		 	if($fileSize > 15000000){
		 		$errors[] = 'The file size must be under 15MB.';
		 	}
		 	// if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt == 'jpg')){
		 	// 	$errors[] = 'The file extension does not much the file.';
		 	// }
			}
		}
		if(!empty($errors)){
			echo display_error($errors);
		}else{
			//upload file and insert into database
		 	if($photo_count > 0){
		 		for ($i=0; $i < $photo_count ; $i++) { 
		 				move_uploaded_file($tmpLoc[$i], $uploadPath[$i]);
		 		}
		 
		 } 
		 	$insertSql = "INSERT INTO products (seller_id,title,price,list_price,brand,categories,image,sizes,description)
			 VALUES ('$seller_id', '$title', '$price', '$list_price', '$brand', '$category', '$dbPath', '$sizes', '$description')";
			 if(isset($_GET['edit'])){
			 	$insertSql = "UPDATE products SET seller_id = '$seller_id', title ='$title', price = '$price', list_price = '$list_price', brand = '$brand', categories = '$category', image = '$dbPath', sizes = '$sizes', description = '$description' 
			 	WHERE id = '$edit_id'";
			 }
			$db->query($insertSql);
			header('Location: products.php');
		}
	}
?>
<div class="wrapper">
<?php include 'includes/navigation.php'; ?>
<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		
		<button  onclick="toggleSidebar()" type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-align-left"></i>
		</button>
		

	</nav>
	<div class="container-fluid">
<h2 class="text-center" ><?=((isset($_GET['edit']))?'Edit ':'Add A New ');?>Product</h2><hr>

<form  action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
<div class="form-group col-md-3">
<label for="title">title*:</label>
<input type="text" name="title" class="form-control" id="title" value="<?=$title;?>">
</div>

<div class="form-group col-md-3">
<label for="brand">brand*:</label>
<select name="brand" class="form-control" id="brand" >
<option value="<?=(($brand == '')?'selected':'');?>"></option>
<?php while ($b = mysqli_fetch_assoc($brandQuery)): ?>
<option value="<?=$b['id'];?>"<?=(($brand == $b['id'])?'selected':'');?>><?=$b['brand'];?></option>
<?php endwhile;?>
</select>
</div>


<div class="form-group col-md-3">
<label for="parent">Parent Category*:</label>
<select name="parent" class="form-control" id="parent" >
<option value="<?=(($parent == '')?'selected':'');?>"></option>
<?php while ($p = mysqli_fetch_assoc($parentQuery)): ?>
<option value="<?=$p['id'];?>"<?=(($parent == $p['id'])?'selected':'');?>><?=$p['category'];?></option>
<?php endwhile;?>
</select>
</div>

<div class="form-group col-md-3">
<label for="child">Child Category*:</label>
<select  name="child" class="form-control" id="child" >
</select>
</div>

<div class="form-group col-md-3">
<label for="price">Price*:</label>
<input type="text" name="price" class="form-control" id="price" value="<?=$price;?>" >
</div>

<div class="form-group col-md-3">
<label for="list_price">List Price*:</label>
<input type="text" name="list_price" class="form-control" id="list_price" value="<?=$list_price;?>" >
</div>

<div class="form-group col-md-3">
<label>Quantity & Sizes*:</label>
<button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity &  Sizes:</button>
</div>

<div class="form-group col-md-3">
<label for="sizes">Sizes & Qty preview</label>
<input type="text" name="sizes" class="form-control" id="sizes" value="<?=$sizes;?>"  readonly>
</div>

<div class="form-group col-md-6">
	<?php if($saved_image != ''): ?>
		<?php 
			$imgi = 1;
			$images = explode(',', $saved_image);
		 ?>
<?php foreach($images as $image):?>
<div class="saved-image col-md-4" >
	<img src="<?=$image;?>" alt="saved image" /><br>
	<a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
</div>
<?php 
$imgi++;
endforeach;?>
<?php else: ?>
<label for="photo">Product Photo:</label>
<input type="file" name="photo[]" class="form-control" id="photo" multiple>
<?php endif; ?>
</div>

<div class="form-group col-md-6">
<label for="description">Description:</label>
<textarea name="description" class="form-control" id="description" rows="6"><?=$description;?></textarea>
</div> 


<div class="form-group pull-right">
	<a href="products.php" class="btn btn-default">Cancel</a>
<input type="submit"  class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> Product" style="border:none;background-color:#2af598;">
</div><div class="clear-fix"></div>
</form>

<!--details modal-->
<div class="modal fade details-1" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModallabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button class="close" type="button" onclick="closeModal()" aria-lable="close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title text-center" id="sizesModallabel">Add Quantity and Sizes</h4>
</div>
<div class="modal-body">
<div class="container-fluid">
<div class="row">
<?php for ($i=1;$i <= 12;$i++): ?>
<div class="form-group col-md-2">
<label for="size<?=$i;?>">Size:</label>
<input type="text" name="size<?=$i;?>" class="form-control" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" >
</div>
<div class="form-group col-md-2">
<label for="qty<?=$i;?>">Quantity:</label>
<input type="number" name="qty<?=$i;?>" class="form-control" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0">
</div>
<div class="form-group col-md-2">
<label for="threshold<?=$i;?>">Threshold:</label>
<input type="number" name="threshold<?=$i;?>" class="form-control" id="threshold<?=$i;?>" value="<?=((!empty($tArray[$i-1]))?$tArray[$i-1]:'');?>" min="0">
</div>
<?php endfor; ?>
</div>
</div>
<div class="modal-footer">
<button class="btn btn-default" data-dismiss="modal">close</button>
<button class="btn btn-primary" type="submit" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save Changes</button>
</div>
</div>
</div>
</div>
</div>


<?php }else{

	
$sid = $vuser_data['id']; 
$sql = "SELECT * FROM products WHERE deleted = 0 AND seller_id = $sid";
$presults = $db->query($sql);
if(isset($_GET['featured'])){
$id = (int)$_GET['id'];
$featured = (int)$_GET['featured'];
$featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id' ";
$db->query($featuredsql);
header('Location: products.php');
}

?>
<div class="wrapper">
<?php include 'includes/navigation.php'; ?>
<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		
		<button onclick="toggleSidebar()" type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-align-left"></i>
			

		</button>
	

	</nav>
<h2 class="text-center">Products</h2>

<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn" style="border:none;background-color:#2af598;">Add Product</a>
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
			$presult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].'~'.$child['category'];
			?>
							
				<tr>
				<td>
					<a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
				</td>
				<td><?=$product['title'];?></td>
				<td><?=money($product['price']);?></td>
				<td><?=$category;?></td>
				
				
				<td>0</td>
			</tr>
		<?php endwhile;?>
		</tbody>
	</table>
	
<?php } include 'includes/footer.php';?>
</div>
</div>
<script>
jQuery('document').ready(function(){
	get_child_options('<?=$category?>');
	
});
</script>
</div>
</div>
