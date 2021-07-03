

<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#ffffff;">
<a href="index.php" class="navbar-brand" style="background:linear-gradient(to right, #833ab4 0%, #c13584 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Britannia Admin</a>
	<div class="container">
		<ul class="nav navbar-nav">
			<li><a href="brands.php">Brands</a></li>
			<li><a href="categories.php">Categories</a></li>
			<li><a href="products.php">Products</a></li>
			<li><a href="archive.php">Archives</a></li>
			
		<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello <?=$cuser_data['first'];?><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					
					<li><a href="change_password.php">Change Password</a></li>
					<li><a href="logout.php">Log Out</a></li>
					
				</ul>
			</li>
		
			<!--menu items-->
			<!--<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					
					<li><a href="#"><?php echo $child['category'];?></a></li>
					
				</ul>
			</li>-->
		
		</ul>
	
	</div>
</nav>