<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>

<link href="<?php echo asset_url(); ?>css/styles.css" rel="stylesheet" type="text/css" />

</head>
<body>

	<div id="container">
		<h1><?php echo $page_title; ?></h1>

		<div id="body">
		<div id="wrapper">
			<h2><?php echo $last_name.', '.$first_name;?></h2><h3>Code: <?php echo $code;?></h3>
			<h2>Existing Conditions </h2>
			<h4>	<?php echo $existing_conditions;?></h4>
			<h2>Current Medications</h2>
			<h4>	<?php echo $medication1.' '.$medication2.' '.$medication3;?></h4>
			<h2>Primary Physician </h2>
			 <h4>	<?php echo $primary_physician;?></h4>
			
			<h2>Contact Information</h2>
			<h4>	Home: <?php echo $phone_num_home; ?> Emergency: <?php echo $phone_num_emergency;?></h4>
			<br/><br/>
			<h2>Primary Complaint</h2>
			<h4>	<?php echo $primary_complaint;?></h4>
			<h2>Symptoms</h2>
			<h4>	<?php echo $symptom1.', '.$symptom2; ?></h4>		
			<?php echo form_open('/examination'); ?>			
			<button type="submit" id="finishVisitBtn" >Finish Visit</button>
			</div>
		</div>

		
	</div>

</body>
</html>