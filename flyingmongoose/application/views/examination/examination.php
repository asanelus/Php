<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $pagetitle; ?></title>

<link href="<?php echo asset_url(); ?>css/styles.css" rel="stylesheet"
	type="text/css" />



</head>
<body>

	<div id="container">
		<h1><?php echo $pagetitle; ?></h1>

		<div id="wrapper">
			<p></p>
			<h3>Queue 1 : <?php echo $queue1; ?></h3>
			<h3>Queue 2 : <?php echo $queue2; ?></h3>
			<h3>Queue 3 : <?php echo $queue3; ?></h3>
			<h3>Queue 4 : <?php echo $queue4; ?></h3>
			<h3>Queue 5 : <?php echo $queue5; ?></h3>
			
			<?php echo form_open('/examination/dequeue'); ?>			
			<button type="submit" id="getNextPatientBtn">Get Next Patient</button>
		</div>
		<footer><?php echo $visitsLeft;?></footer>

	</div>

</body>
</html>