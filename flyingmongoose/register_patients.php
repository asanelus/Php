<?php
function main() {
	try {
		$pdo = new PDO ( 'mysql:host=localhost;port=3306;dbname=clinic;', 'root', '' );
		//$pdo = new PDO('mysql:host=waldo2.dawsoncollege.qc.ca;port=3306;dbname=cs1233306;', 'CS1233306', 'whableny');
		$pdo->setAttribute ( PDO::ATTR_CASE, PDO::CASE_NATURAL );
		$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		createPatient ( $pdo, 'ABCD89582609', 'Abc', 'Derrick', '555-555-5555', 
			'555-555-5556', 'Dr. Joy', 'Amnesia, Headache, Potato', 'BENZAMYCIN', 
			'ACCUTANE', 'NO MEDICATION LISTED.' );
		createPatient ( $pdo, 'EFGH91081422', 'Efg', 'Harold', '555-456-5555', 
			'555-456-5556', 'Dr. Face', 'Shoulder Pain, Leg Pain, Pain Pain', 
			'NEXIUM', 'ADVAIR DISKUS', 'LEVAQUIN' );
		createPatient ( $pdo, 'IJKL67510158', 'Ijk', 'Ludwig', '555-222-5555', 
			'555-222-5556', 'Dr. Sadness', 'Bronchitis, Smallpox, Influenza', 
			'TAMIFLU', 'KENALOG', 'ACETAMINOPHEN' );
		createPatient ( $pdo, 'MNOP94090399', 'Mno', 'Potato', '555-123-5555', 
			'555-123-5556', 'Dr. Lambda', 'Gravity, Elevator, Jump', 'ADVIL', 
			'VIOXX', 'CELEBREX' );
	} catch ( PDOException $ex ) {
		echo $ex->getMessage ();
	} finally { 
		unset ( $pdo );
	}
}
function createPatient($pdo, $ramqId, $lastName, $firstName, $phoneNumHome, 
		$phoneNumEmergency, $primaryPhysician, $existingConditions,
		$medication1, $medication2, $medication3) {
	$query = "INSERT INTO patient(ramq_id, last_name, first_name, " .
		"phone_num_home, phone_num_emergency, primary_physician, " .
		"existing_conditions, medication1, medication2, medication3) " .
		"VALUES(?,?,?,?,?,?,?,?,?,?)";
	
	$stmt = $pdo->prepare ( $query );
	
	$stmt->bindParam ( 1, $ramqId );
	$stmt->bindParam ( 2, $lastName );
	$stmt->bindParam ( 3, $firstName );
	$stmt->bindParam ( 4, $phoneNumHome );
	$stmt->bindParam ( 5, $phoneNumEmergency );
	$stmt->bindParam ( 6, $primaryPhysician );
	$stmt->bindParam ( 7, $existingConditions );
	$stmt->bindParam ( 8, $medication1 );
	$stmt->bindParam ( 9, $medication2 );
	$stmt->bindParam ( 10, $medication3 );
	
	$stmt->execute ();
}

main ();
?>