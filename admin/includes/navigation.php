

<nav id="sidebar">
	<div class="sidebar-header">
		<h3>Admin Panel</h3>
		
	</div>
	<ul class="list-unstyled components">
	

		<li class="active">
			<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><img src="<?= $user_data['profile_image']; ?>" height="50" width="50" class="img-circle"> Hello <?=$user_data['first'];?></a>
			<ul class="collapse list-unstyled" id="homeSubmenu">
			<li><a href="change_password.php">Change Password</a></li>
			<li><a href="edit_profile.php">Change Profile Picture</a></li>
			<li><a href="logout.php">Log Out</a></li>
			</ul>
		</li>
		<li><a href="index.php"> Dashboard</a></li>
		<li><a href="brands.php">Brands</a></li>
		<li><a href="categories.php">Categories</a></li>
		<li><a href="products.php"> Products</a></li>
		<li><a href="archive.php">Archives</a></li>
		
		
		<?php if(has_permission('admin')): ?>
		<li><a href="customers.php">Customers</a></li>
		<li><a href="vendors.php">Vendors</a></li>
		<li><a href="users.php">Admins</a></li>
		<?php endif ; ?>
		

	</ul>
</nav>