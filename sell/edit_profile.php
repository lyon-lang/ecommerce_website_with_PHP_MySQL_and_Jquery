<?php
require_once '../core/connect.php';


include 'includes/head.php';

if(!is_vlogged_in()){
	login_error_redirect();
}
$userid = $vuser_data['id'];
if($_POST){
	$productresults = $db->query("SELECT * FROM vendors WHERE id = '$userid'");
	$userquery = mysqli_fetch_assoc($productresults);
				$bio = $_POST['bio'];
				$errors = array();
				
				$allowed = array('png', 'jpg', 'jpeg', 'gif');
				$photoName = array();
				$uploadPath = array();
				$tmpLoc = array();
				
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
					$uploadPath[] = BASEURL.'images/profile_images/'.$uploadName;
					if($i != 0){
						$dbPath .= ',';
					}
					
					$dbPath .= '/online-mall/images/profile_images/'.$uploadName; 
					
					
					if($mimeType != 'image'){
						$errors[] = 'The file must be an image.';

					}
					if(!in_array($fileExt, $allowed)){
						$errors[] = 'The file extension must be a png, jpg, jpeg or gif.';

					}
					if($fileSize > 15000000){
						$errors[] = 'The file size must be under 15MB.';
					}
					//  if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt == 'jpg')){
					// 	 $errors[] = 'The file extension does not much the file.';
					//  }
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
					
				}
				if($userquery['profile_image'] == ''){
			 $insertSql = "UPDATE vendors SET profile_image = '$dbPath', bio = '$bio'
			 WHERE id = '$userid'";
				}else{
					$insertSql = "UPDATE vendors SET bio = '$bio'
			 WHERE id = '$userid'";
				}
		$db->query($insertSql);
		header('Location: edit_profile.php');
	}
	$productresults = $db->query("SELECT * FROM vendors WHERE id = '$userid'");
	$user = mysqli_fetch_assoc($productresults);
	$saved_image = (($user['profile_image'] != '')?$user['profile_image']:'');
	$dbPath = $saved_image;

if(isset($_GET['delete_image'])){
	$imgi = (int)$_GET['imgi'] - 1;
	$images = explode(',', $user['profile_image']);
	$image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi]; //echo $image_url;			
	unlink($image_url);
	unset($images[$imgi]);
	$imageString = implode(',',$images);
	$db->query("UPDATE vendors SET profile_image = '{$imageString}' WHERE id = $userid");
	header('Location: edit_profile.php?edit='.$userid);
}


	
	

	
?>
<div class="wrapper">
<?php include 'includes/navigation.php'; ?>
<div id="content">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
		<button type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fa fa-align-left"></i>
			<span>Toggle Sidebar</span>

		</button>


</nav>
<div class="container-fluid">

<form  action="edit_profile.php" method="POST" enctype="multipart/form-data">






<div class="form-group col-md-6">
<?php if($saved_image != ''): ?>
		<?php 
			$imgi = 1;
			$images = explode(',', $saved_image);
		 ?>
<?php foreach($images as $image):?>
<div class="saved-image col-md-6" >
	<img src="<?=$image;?>" alt="saved image" /><br>
	<a href="edit_profile.php?delete_image=1&edit=<?=$userid;?>&imgi=<?=$imgi;?>" class="text-danger">Delete Image</a>
</div>
<?php 
$imgi++;
endforeach;?>
<?php else: ?>
<label for="photo">Profile Photo:</label>
<input type="file" name="photo[]" class="form-control" value="<?=$user['profile_image'];?>" id="photo" multiple>
<?php endif; ?>
</div>
<div class="form-group col-md-6">
<label for="bio">Bio:</label>
<textarea name="bio" class="form-control" id="bio" rows="6"><?=$user['bio'];?></textarea>
</div>


<div class="form-group pull-right">
<input type="submit"  class="btn btn-success" value="Add Profile Image" style="border:none;background-color:#2af598;">
</div><div class="clear-fix"></div>
</form>