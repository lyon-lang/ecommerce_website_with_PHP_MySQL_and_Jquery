<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online-mall/core/connect.php';
if(!is_logged_in()){
	login_error_redirect();
}

include 'includes/head.php';



$sql ="SELECT * FROM categories WHERE parent = 0";
$result = $db->query($sql);
$errors = array();
$category = '';
$post_parent = '';

//Edit
if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$edit_id = (int)$_GET['edit'];
	$edit_id = sanitize($edit_id);
	$edit_sql = "SELECT * FROM categories WHERE id ='$edit_id'";
	$edit_result = $db->query($edit_sql);
	$edit_category = mysqli_fetch_assoc($edit_result);
	
	//$db->query($dsql);
	//header('Location: categories.php');
}

//Delete
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	$delete_id = sanitize($delete_id);
	$sql = "SELECT * FROM categories WHERE id ='$delete_id'";
	$result = $db->query($sql);
	$category = mysqli_fetch_assoc($result);
	if($category['parent'] == 0){
		$sql = "DELETE FROM categories WHERE parent ='$delete_id'";
		$db->query($sql);
	}
	$dsql = "DELETE FROM categories WHERE id ='$delete_id'";
	$db->query($dsql);
	header('Location: categories.php');

}
//form process
if(isset($_POST) && !empty($_POST)){
	$post_parent = sanitize($_POST['parent']);
	$category = sanitize($_POST['category']);
	$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent'";
	if(isset($_GET['edit'])){
		$id =  $edit_category['id'];
		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id !='$id' ";
	}
	$fresult = $db->query($sqlform);
	$count = mysqli_num_rows($fresult);
	//if category is blank
	if($category == ''){
		$errors[] .= 'The Category can not be left blank';

	}
	//if category already exists
	if( $count > 0 ){
	$errors[] .= $category. ' already exists. Please choose a new Category.';
	}
//Displays errors  or update database
	if(!empty($errors)){
		//Display errors
		$display = display_error($errors); ?>
		<script>
			jQuery('document').ready(function(){
				jQuery('#errors').html('<?=$display;?>');
			})
		</script>
	<?php }else{
		//update database
		$updatesql = "INSERT INTO categories(category, parent) VALUES('$category','$post_parent')";
		if (isset($_GET['edit'])) {
			$updatesql = "UPDATE categories SET category = '$category', parent = '$post_parent' WHERE id = '$edit_id'";
			# code...
		}
		$db->query($updatesql);
		header('Location: categories.php');
	}
}
$category_value = '';
$parent_value = 0;
if(isset($_GET['edit'])){
$category_value = $edit_category['category'];
$parent_value = $edit_category['parent'];
}else{
	if(isset($_POST)){
		$category_value = $category;
		$parent_value = $post_parent;
	}
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
	<h2 class="text-center" >Categories</h2><hr>
<div class="row">

	<!-- form-->
<div class="col-md-6">
	<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit=' .$edit_id: '');?>" method="post">
		<legend><?=((isset($_GET['edit']))? 'Edit' : 'Add A');?> Category</legend>
		<div id="errors"></div>
	<div class="form-group">
		
		<label for="parent"> Parent</label>
		<select class="form-control" name="parent" id="parent"> 
			<option value="0"<?=(($parent_value == 0)? 'selected="selected"' : 'Add A');?>>Parent</option>
			<?php while ($parent = mysqli_fetch_assoc($result)):?>
			<option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected ="selected"':'');?>><?=$parent['category'];?></option>
			<?php endwhile; ?>
		</select>
	</div>

	<div class="form-group">
		
		<label for="category"> Category</label>
		<input type="text" name="category" id="category" class="form-control" value="<?=$category_value;?>">
	</div>

	<div class="form-group">
		<input type="submit"  class="btn btn-success" value="<?=((isset($_GET['edit']))? 'Edit' : 'Add');?> Category" style="border:none;background-color:#2af598;">
	</div>
	</form>
</div>

<!-- category table-->
<div class="col-md-6">
	<table class="table table-bordered" > 
		<thead>
			<th>Category</th><th>Parent</th><th></th></thead>
		<tbody>
			
				<?php
				$sql ="SELECT * FROM categories WHERE parent = 0";
				$result = $db->query($sql);
				 while($parent = mysqli_fetch_assoc($result)): 
				$parent_id = (int)$parent['id'];
				$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
				$cresult = $db->query($sql2);
				?>
				<tr class="success">
				<td><?=$parent['category'];?></td>
				<td>Parent</td>
				<td>
					<a href="categories.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="categories.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>

				</td>
				</tr>
				<?php while($child = mysqli_fetch_assoc($cresult)): 
				
				?>
				<tr class="info">
				<td><?=$child['category'];?></td>
				<td><?=$parent['category'];?></td>
				<td>
					<a href="categories.php?edit=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="categories.php?delete=<?=$child['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>

				</td>
				</tr>
			<?php endwhile; ?>
			<?php endwhile; ?>
			
		</tbody>
	</table>
</div>
</div>

<?php include 'includes/footer.php';?>
</div>
</div>
