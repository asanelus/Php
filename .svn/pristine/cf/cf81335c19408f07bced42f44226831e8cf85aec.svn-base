<!DOCTYPE html>
<html>
<head>
	<!-- See http://stackoverflow.com/questions/6630770/where-do-i-put-image-files-css-js-etc-in-codeigniter -->
	<link href="<?php echo asset_url(); ?>css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<header>
		<h1>MediXFlyingMongoose</h1>
</header>
<hr />
<?php
// So long as the user is logged in, display the nav bar.
	if(isset($userId)) {
		echo '<nav>';
		echo '<ul>';
		echo '<li>' . anchor('home/index', 'Home') . '</li>';
		echo '<li id="nav_right">' . anchor('home/logout', 'Logout') . '</li>';		
		echo '</ul>';
		echo '</nav>';
	}
?>
</body>
</html>