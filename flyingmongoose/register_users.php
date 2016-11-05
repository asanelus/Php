<?php
function main() {
	try {
		$pdo = new PDO ( 'mysql:host=localhost;port=3306;dbname=clinic;', 'root', '' );
		//$pdo = new PDO('mysql:host=waldo2.dawsoncollege.qc.ca;port=3306;dbname=cs1233306;', 'CS1233306', 'whableny');
		$pdo->setAttribute ( PDO::ATTR_CASE, PDO::CASE_NATURAL );
		$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		createUser ( $pdo, 'marc', 'marc', 1, 0, 0 ); /* reception */
		createUser ( $pdo, 'antonika', 'antonika', 0, 1, 0 ); /* triage */
		createUser ( $pdo, 'richard', 'richard', 0, 0, 1); /* nurse */
		createUser ( $pdo, 'kevin', 'kevin', 1, 1, 1); /* all privs */
	} catch ( PDOException $ex ) {
		echo $ex->getMessage ();
	} finally {
		unset ( $pdo );
	}
}
function createUser($pdo, $userName, $pwd, $receptionPriv, $triagePriv, $nursePriv) {
	$query = "INSERT INTO user(user_name, hashed_password, reception_priv, triage_priv, nurse_priv) VALUES(?,?,?,?,?)";
	
	$pwdHashed = password_hash ( $pwd, PASSWORD_DEFAULT );
	
	$stmt = $pdo->prepare ( $query );
	
	$stmt->bindParam ( 1, $userName );
	$stmt->bindParam ( 2, $pwdHashed );
	$stmt->bindParam ( 3, $receptionPriv );
	$stmt->bindParam ( 4, $triagePriv );
	$stmt->bindParam ( 5, $nursePriv );
	
	$stmt->execute ();
}

main ();
?>