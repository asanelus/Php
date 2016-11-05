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
<div id="wrapper-register-patient">
	<h2><?php echo $title; ?></h2>

	<div class="form-box-wrapper-register-patient">
		<div class="center-div">
			<div class="form-box-register-patient">
				<?php echo form_open('registerPatient/index'); ?>
				<table>
					<tr>
						<td class="col-width-fit-text"><?php echo form_label('RAMQ ID:', 'ramqId'); ?></td>
						<td><?php echo form_input('ramqId', $ramqId); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Last name:', 'lastName'); ?></td>
						<td><?php echo form_input('lastName', $lastName); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('First name:', 'firstName'); ?></td>
						<td><?php echo form_input('firstName', $firstName); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Home phone number:', 'homePhone'); ?></td>
						<td><?php echo form_input('homePhone', $homePhone); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Emergency phone number:', 'emergencyPhone'); ?></td>
						<td><?php echo form_input('emergencyPhone', $emergencyPhone); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Primary physician:', 'primaryPhysician'); ?></td>
						<td><?php echo form_input('primaryPhysician', $primaryPhysician); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Existing conditions:', 'existingConditions'); ?></td>
						<td><?php 
						$data = array('name' => 'existingConditions', 
													'value' => $existingConditions,
													'rows' => '3', 
													'cols' => '15');
						echo form_textarea($data); 
						?></td>
					</tr>
					<tr>
						<!--NOTE: With enough time, populating these lists would have
						worked a little differently. Instead of having the same exact
						list in each of the three lists, the patient would not be able
						to have duplicate meds, that is, to be able to select the same
						medication from multiple dropdown lists. In order to accomplish
						this goal of uniqueness, one would have to use javascript in 
						order to populate the lists. Also, the only value that need not
						be unique is 'Select a medication', which would be shown by 
						default-->
						<td><?php echo form_label('Medication 1:', 'med1'); ?></td>
						<td><?php echo form_dropdown('med1', $meds, $med1); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Medication 2:', 'med2'); ?></td>
						<td><?php echo form_dropdown('med2', $meds, $med2); ?></td>
					</tr>
					<tr>
						<td><?php echo form_label('Medication 3:', 'med3'); ?></td>
						<td><?php echo form_dropdown('med3', $meds, $med3); ?></td>
					</tr>
				</table>
				<?php echo form_submit(array('name' => 'registerPatient_submit', 
					'value' => 'Add To Triage Queue', 
					'class' => 'form-btn-register-patient')); ?>
			</div><!-- form-box-register-patient -->
			<div class="error-box-register-patient error">
				<?php 
				echo validation_errors(); 
				echo $error;
				?>
			</div><!-- error-box-register-patient -->
			<div class="clear-both">
			</div>
		</div><!-- center-div -->
	</div><!-- form-box-wrapper-register-patient -->
</div><!-- wrapper-register-patient -->
</body>
</html>
<script src="<?php echo asset_url(); ?>js/script.js" type="text/javascript"></script>