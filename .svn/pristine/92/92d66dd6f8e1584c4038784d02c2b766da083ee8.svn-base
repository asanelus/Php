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
		<div class="form-box-wrapper-login">
			<div class="form-box-login">
				<?php echo form_open('login'); ?>
				<table>
					<tr>
						<td><?php echo form_label('Username:', 'username'); ?></td>
						<td><?php echo form_input('username'); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Password:', 'password'); ?></td>
						<td><?php echo form_password('password'); ?></td>
					</tr>
				</table>
				<div class="form-btn-wrapper">
					<?php echo form_submit(array(
						'name' => 'login_submit', 
						'value' => 'Login',
						'class' => 'form-btn')); ?>
				</div><!-- form-btn-wrapper -->
			</div><!-- form-box -->
		</div><!-- form-box-wrapper -->
		<div class="error-box error">
			<?php 
			echo validation_errors(); 
			echo $error;
			?>
		</div><!-- error-box -->
	</div><!-- wrapper -->
</body>
</html>