<?php
require_once '../core/connect.php';
if(!is_vlogged_in()){
	login_error_redirect();
}

include 'includes/head.php';

//get brands from database



// if add form is submitted
if(isset($_POST['add_submit'])){
	$brand = sanitize($_POST['brand']);
// check if brand is blank
	if($_POST['brand']==''){
		$errors[] .= 'You must enter a brand!';
	}
    // check of brand exists in database
$sql = "SELECT * FROM brand WHERE brand = '$brand'";
if(isset($_GET['edit'])){
	$sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";
}
$result = $db->query($sql);
$count = mysqli_num_rows($result);  

if($count > 0){
$errors[] .= 'That brand already exists. Please choose another brand...';
}
	// display errors
if(!empty($errors)){
	echo display_error($errors);
}else{
	//Add brand to database
$sql = "INSERT INTO brand (brand) VALUES ('$brand')";
if(isset($_GET['edit'])){
	$sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
}
$db->query($sql);
header('Location: brands.php');
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
	
<h2 class="text-center">Contact Us</h2><hr>
<!--brands form-->
<div class="text-center">
<p>Please do add any info you want on this page</p>
0546413583
</div>
		
		
<?php include 'includes/footer.php';?>
</div>
</div>