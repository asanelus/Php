<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="UTF-8" />
	<!-- See http://stackoverflow.com/questions/6630770/where-do-i-put-image-files-css-js-etc-in-codeigniter -->
	<link href="<?php echo asset_url(); ?>css/styles.css" rel="stylesheet" type="text/css" />

</head>
<body>
	<div id="wrapper">
		<h2><?php echo $title; ?></h2>
		
		<p>
			<?php echo $welcome_message; ?>
		</p>
		
		<ul class="indent1 list-no-bullets">
			<?php
				// If the user is logged in, userId will be set. 
				if(!isset($userId)) {
					echo '<li>' . anchor('login', 'Login') . '</li>'; 
				} 
				if($receptionPriv == 1) {
					echo '<li>' . anchor('register', 'Patient Registration') . '</li>'; 
				} 
				if($triagePriv == 1) {
					echo '<li>' . anchor('triage', 'Triage') . '</li>'; 
				}
				if($nursePriv == 1) {
					echo '<li>' . anchor('examination', 'Examination') . '</li>'; 
				}
			?>
		</ul>
	</div>
</body>
</html>
<script src="<?php echo asset_url(); ?>js/script.js" type="text/javascript"></script>