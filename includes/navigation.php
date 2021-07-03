<?php 
$sql = "SELECT * FROM categories WHERE parent = 0 ";
$pquery= $db->query($sql);

$search = ((isset($_REQUEST['search']))?sanitize($_REQUEST['search']):'');

	
?>

<div>
<?php if(empty($cart_id)){
$item_count = 0;
}else{
	$cartQ = $db->query("SELECT * FROM cart WHERE id ='{$cart_id}'");
	$results = mysqli_fetch_assoc($cartQ);
	$items = json_decode($results['items'],true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;
	
	foreach($items as $item){
		
		$item_count += $item['quantity'];

	}

				

	
}
 ?>
</div>
<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#ffffff;">
<a href="index.php" class="navbar-brand" style="background:linear-gradient(to right, #833ab4 0%, #c13584 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">KuCWebMall</a>
<form action="search_products.php" method="post" style="display:inline-block;">
<input type="text" name="search" placeholder="Search product" style="margin-top:10px;border: 1px solid #ccc; border-radius:5px;height:30px;">
<input type="submit" class="btn btn-sm btn-success" value="Search" style="border:none;background:#30cfd0;">	
</form>

	
	
		
		<ul class="nav navbar-nav navbar-right" >
		<?php if(!is_clogged_in()): ?>
		
		<li  >
			<a href="/online-mall/users/login.php" > Sign In</a>
			
		</li>
		<li  >
			<a href="/online-mall/users/register.php" > Sign Up</a>
			
		</li>
		<?php else: ?>
		
		<li class="dropdown">
		
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?= $cuser_data['profile_image']; ?>" height="30" width="30" class="img-circle"> Hello <?=$cuser_data['first'];?><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					
					<li><a href="/online-mall/users/change_password.php">Change Password</a></li>
					<li><a href="/online-mall/users/edit_profile.php">Change Profile image</a></li>
					<li><a href="/online-mall/users/logout.php">Log Out</a></li>
					
				</ul>
		
		</li>
			
		
		<?php endif ; ?>
		<li  >
			<a href="cart.php" > <span style="background-color:#B53737;color:#FFFFFF;padding:3px;border-radius:30px;"><b><?=$item_count;?></b></span><img src="/online-mall/images/vectors/cart2.svg" style="width:20px;">Cart</a>
			
		</li>
		<li  >
			<a href="/online-mall/sell/login.php" >Sell</a>
			
		</li>
		</ul>
		
		
	

</nav>