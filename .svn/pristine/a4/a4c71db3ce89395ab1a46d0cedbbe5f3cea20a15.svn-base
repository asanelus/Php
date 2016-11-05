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
	<?php 
		/* Form:
		 * 	RAMQ id
		 * 	if patient with RAMQ id doesn't exist, load new patient form
		 *  else, load existing patient's information (editable)
		 *  
		 *  textarea for existing conditions
		 *  3 select menus (one per medication, single selection mode in each)
		 *  	listing 20 meds per list, if previously selected, remove from list 
		 *  
		 *  button to add patient to triage queue
		 */
	?>
	<div class="form-box-wrapper-register">
		<div class="form-box-register">
			<?php echo form_open('register'); ?>
			<table>
				<tr>
					<td><?php echo form_label('Patient RAMQ ID:', 'ramqId'); ?></td>
					<td><?php echo form_input('ramqId'); ?></td>
				</tr>
			</table>
			<div class="form-btn-wrapper">
				<?php echo form_submit(array('name' => 'register_submit', 'value' => 'Search',
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
	<div class="message-box">
		<?php 
		echo $message;
		$this->session->unset_userdata('message');
		?>
	</div><!-- message-box -->
</div>
</body>
</html>
<script src="<?php echo asset_url(); ?>js/script.js" type="text/javascript"></script>