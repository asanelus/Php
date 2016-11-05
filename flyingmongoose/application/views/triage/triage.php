<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<HTML>
	<HEAD>
		<title>FlyingMongoose - Triage</title>
		<meta charset="UTF-8" />
		<link href="<?php echo asset_url(); ?>css/styles.css" rel="stylesheet" type="text/css" />
	</HEAD>
	<BODY>			
		<div>
			<p>There are <span id="triage_highlight"><?php echo $queueLength; ?></span> patients in the unsorted queue.</p>
			<?php echo form_open('triage/getNextPatient'); ?>
				<input type="submit" name="nextPatient" value="Display Next Patient" id = "triage_next"/>
			</form>
		</div>
		<div class = "triage" id = "triage_content">
			<?php echo form_open('triage/submitNewPatient'); ?>
				<div id ="triage_patient_from_db">
					<table>
					<?php
					// display patient information
					if (isset($patient)) {
						foreach($patient as $key=>$value) {
							echo '<tr>';
							echo '<td>';
							echo $key;
							echo '</td>';
							echo '<td>';
							echo $value;
							echo '</td>';
							echo '</tr>';
						}
					} else
						echo "<span id = 'triage_highlight'>No patient information available.</span><br>";
					?>
					<table>
				</div>
				<label for="primaryComplaint">Primary Complaint:</label><br>
				<textarea name="primaryComplaint" id ="primaryComplaint" rows="5" cols="40"></textarea>
				<br>

				<label for="secondaryComplaint1">Secondary Complaint:</label><br>
				<textarea name="secondaryComplaint1" id ="secondaryComplaint1" rows="5" cols="40"></textarea>
				<br>

				<label for="secondaryComplaint2">Secondary Complaint:</label><br>
				<textarea name="secondaryComplaint2" id ="secondaryComplaint2" rows="5" cols="40"></textarea>
				<br><br>
				Code:<br>
				<label for"1">
					<input type="radio" name="code" id="1" value="1"> 1 - Reanimation <br>
				</label>
				<label for"2">
					<input type="radio" name="code" id="2" value="2"> 2 - Very Urgent<br>
				</label>
				<label for"3">
					<input type="radio" name="code" id="3" value="3"> 3 - Urgent<br>
				</label>
				<label for"4">
					<input type="radio" name="code" id="4" value="4"> 4 - Less Urgent<br>
				</label>
				<label for"5">
					<input type="radio" name="code" id="5" value="5"> 5 - Not Urgent<br>
				</label>
				<br>
				<input type="submit" name="submit" value="Submit" id="triage_submit">
				<input type="reset" name="reset" value="Reset" id="triage_reset">
			</form>
		</div>
	</BODY>
</HTML>