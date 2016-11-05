Setup Guide:
1. Make sure WAMP or something similar is up and running.
2. Execute the "MediXFlyingMongoosePHP\flyingmongoose\create_tables.sql" 
script in a MySQL console.

Select one of the following methods to populate the database tables. 3a 
will be a one-shot thing, whereas 3b gives more control over the order 
the tables are populated.
 
**NOTE: If you run 3a, you do not need to run 3b as that will insert 
duplicate records.

3a. Run the batch file toDB.bat (either through the command line 
	or double clicking) to insert dummy data:
	-> "MediXFlyingMongoosePHP\flyingmongoose\toDB.bat"
3b. Run the individual php scripts (either through the command line or 
opening them in a browser) to insert dummy data:
	a. "MediXFlyingMongoosePHP\flyingmongoose\register_patients.php"
	b. "MediXFlyingMongoosePHP\flyingmongoose\register_unsorted_queue.php"
	c. "MediXFlyingMongoosePHP\flyingmongoose\register_users.php"
	d. "MediXFlyingMongoosePHP\flyingmongoose\register_visits.php" 
	
Noteworthy directory locations:
- application/core/MY_Loader.php
- application/helpers/utility_helper.php
- assets/*

WALDO2 URL:
http://waldo2.dawsoncollege.qc.ca/1233306/MediXFlyingMongoosePHP/flyingmongoose/

List of users created: 
(user/password/privilege_level)
- kevin/kevin/nurse_triage_reception
- richard/richard/nurse
- marc/marc/reception
- antonika/antonika/triage

Patients for Tricia: 
(patient_id/visit_id)
- 1/2
- 3/4