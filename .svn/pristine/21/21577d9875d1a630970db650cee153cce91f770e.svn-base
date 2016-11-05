<?php
function main() {
	try {
		//$pdo = new PDO ( 'mysql:host=localhost;port=3306;dbname=clinic;', 'root', '' );
		$pdo = new PDO('mysql:host=waldo2.dawsoncollege.qc.ca;port=3306;dbname=cs1233306;', 'CS1233306', 'whableny');
		$pdo->setAttribute ( PDO::ATTR_CASE, PDO::CASE_NATURAL );
		$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		createUser ( $pdo, 'marc', 'marc', 1, 0, 0 ); /* reception */
		createUser ( $pdo, 'antonika', 'antonika', 0, 1, 0 ); /* triage */
		createUser ( $pdo, 'richard', 'richard', 0, 0, 1); /* nurse */
		createUser ( $pdo, 'kevin', 'kevin', 1, 1, 1); /* all privs */

		createPatient ( $pdo, 'ABCD89582609', 'Abc', 'Derrick', '555-555-5555',
		'555-555-5556', 'Dr. Joy', 'Amnesia, Headache, Potato', 'BENZAMYCIN',
		'ACCUTANE', 'NONE' );
		createPatient ( $pdo, 'EFGH91081422', 'Efg', 'Harold', '555-456-5555',
		'555-456-5556', 'Dr. Face', 'Shoulder Pain, Leg Pain, Pain Pain',
		'NEXIUM', 'ADVAIR DISKUS', 'LEVAQUIN' );
		createPatient ( $pdo, 'IJKL67510158', 'Ijk', 'Ludwig', '555-222-5555',
		'555-222-5556', 'Dr. Sadness', 'Bronchitis, Smallpox, Influenza',
		'TAMIFLU', 'KENALOG', 'ACETAMINOPHEN' );
		createPatient ( $pdo, 'MNOP94090399', 'Mno', 'Potato', '555-123-5555',
		'555-123-5556', 'Dr. Lambda', 'Gravity, Elevator, Jump', 'ADVIL',
		'VIOXX', 'CELEBREX' );
		
		createVisit ( $pdo, 1, 2, 'Elephant on the head', 'Sore hip', 'Smoke from the ears' ); 
		createVisit ( $pdo, 1, 5, 'Dust bunnies in the ears', 'Dizzy', 'Nausea');
		createVisit ( $pdo, 2, 1, 'Cannot stop laughing', 'Cannot stop dancing', 'Orange skin' ); 
		createVisit ( $pdo, 3, 2, 'Ate a bad potato', 'Rickrolls everyone', 'Rolls on the floor' );
		insertPatientIntoQueue($pdo,"1");
		insertPatientIntoQueue($pdo,"2");
		insertPatientIntoQueue($pdo,"3");
		insertPatientIntoQueue($pdo,"4");
		insertPatientIntoQueue($pdo,"5");
		
		$patients = createPatientModels($pdo);
		$queue = new SplQueue();
		foreach($patients as $p) {
			$queue->enqueue($p);
		}
		$serialized = $queue->serialize();
		createUnsortedQueue ( $pdo, $serialized);
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

function createVisit($pdo, $patientId, $code, $primaryComplaint, $symptom1, $symptom2) {
	$query = "INSERT INTO visit(patient_id, code, primary_complaint, symptom1, symptom2)" .
			"VALUES(?,?,?,?,?)";
	
	$stmt = $pdo->prepare ( $query );
	
	$stmt->bindParam ( 1, $patientId );
	$stmt->bindParam ( 2, $code );
	$stmt->bindParam ( 3, $primaryComplaint );
	$stmt->bindParam ( 4, $symptom1 );
	$stmt->bindParam ( 5, $symptom2 );
	
	$stmt->execute ();
	
	$query2 = "SELECT visit_id from visit where patient_id=?";
	$stmt1 = $pdo -> prepare($query2);
	$stmt1 ->bindParam ( 1, $patientId );
	$stmt1 ->execute ();
	
	$result = $stmt1 -> fetch();
	
	
}
function insertPatientIntoQueue($pdo,$code=-1){
		
	$querycontent = "select queue_content from queue where queue_name =?";
	$stmttemp = $pdo -> prepare($querycontent);
	$stmttemp -> bindParam(1,$code);
	$stmttemp -> execute();
	$result = $stmttemp -> fetch();
	
	$unserializedQueue = new SplQueue();
	if(!empty($result[0])){
		$unserializedQueue -> unserialize($result[0]);
	}

	$patientsInCode = createPatientModels($pdo,$code);
	foreach($patientsInCode as $apatient){
		$unserializedQueue -> push($apatient);
	}
	
	$serializedQ = $unserializedQueue -> serialize();
	
	$query1 = "UPDATE QUEUE SET QUEUE_CONTENT = ? WHERE QUEUE_NAME=? ";
	$stmt1 = $pdo->prepare ( $query1 );
	//$content = "(select queue_content from queue where queue_name =".$code.")";
	$stmt1 -> bindParam(1,$serializedQ);
	$stmt1 -> bindParam(2,$code);
	$stmt1 -> execute();
	
}
function createPatientModels($pdo,$code) {
	$patients = array();

	$query = "SELECT * FROM patient,visit WHERE code=".$code;
	$stmnt = $pdo->prepare($query);
	$stmnt->execute();

	$visit_id = 0;

	if($rows = $stmnt->fetchAll()) {
		foreach($rows as $row) {
			$p = new Patient();
			$p->setPatient_id($row[0]);
			$p->setVisit_id($row['visit_id']);
			$p->setRamq($row[1]);
			$p->setLastName($row[2]);
			$p->setFirstName($row[3]);
			$p->setPhoneHome($row[4]);
			$p->setPhoneEmergency($row[5]);
			$p->setPrimaryPhysician($row[6]);
			$p->setExistingConditions($row[7]);
			$p->setMedication1($row[8]);
			$p->setMedication2($row[9]);
			$p->setMedication3($row[10]);
			$patients[] = $p;
			$visit_id ++;
		}
	}

	return $patients;
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

function createUnsortedQueue($pdo, $queue) {
	$query = "UPDATE queue
			  SET queue_content = ?
			  WHERE `queue_name` LIKE 'unsorted'";

	$stmt = $pdo->prepare ( $query );

	$stmt->bindParam ( 1, $queue );

	$stmt->execute ();
}
function createPatientModels($pdo,$code) {
	$patients = array();

	$query = "SELECT * FROM patient,visit WHERE code=".$code;
	$stmnt = $pdo->prepare($query);
	$stmnt->execute();

	$visit_id = 0;

	if($rows = $stmnt->fetchAll()) {
		foreach($rows as $row) {
			$p = new Patient();
			$p->setPatient_id($row[0]);
			$p->setVisit_id($row['visit_id']);
			$p->setRamq($row[1]);
			$p->setLastName($row[2]);
			$p->setFirstName($row[3]);
			$p->setPhoneHome($row[4]);
			$p->setPhoneEmergency($row[5]);
			$p->setPrimaryPhysician($row[6]);
			$p->setExistingConditions($row[7]);
			$p->setMedication1($row[8]);
			$p->setMedication2($row[9]);
			$p->setMedication3($row[10]);
			$patients[] = $p;
			$visit_id ++;
		}
	}

	return $patients;
}

main ();
?>
<?php
class Patient {
	private $patient_id;
	private $visit_id;
	private $ramq;
	private $lastName;
	private $firstName;
	private $phone_home;
	private $phone_emergency;
	private $primaryPhysician;
	private $existingConditions;
	private $medication1;
	private $medication2;
	private $medication3;

	public function __construct($patient_id = "", $visit_id = "", $ramq = "", $lastName = "", 
		$firstName = "", $phone_home = "", $phone_emergency = "", $primaryPhysician = "",
		$existingConditions = "", $medication1 = "", $medication2 = "", $medication3 = "") {
		$this->patient_id = $patient_id;
		$this->visit_id = $visit_id;
		$this->ramq = $ramq;
		$this->lastName = $lastName;
		$this->firstName = $firstName;
		$this->phone_home = $phone_home;
		$this->phone_emergency = $phone_emergency;
		$this->primaryPhysician = $primaryPhysician;
		$this->existingConditions = $existingConditions;
		$this->medication1 = $medication1;
		$this->medication2 = $medication2;
		$this->medication3 = $medication3;
	}

	public function getPatient_id() {
		return $this->patient_id;
	}

	public function setPatient_id($patient_id) {
		$this->patient_id = $patient_id;
	}
	
	public function getVisit_id() {
		return $this-> visit_id;
	}
	
	public function setVisit_id($visit_id) {
		$this-> visit_id = $visit_id;
	}

	public function getRamq() {
		return $this->ramq;
	}

	public function setRamq($ramq) {
		$this->ramq = $ramq;
	}

	public function getLastName() {
		return $this->lastName;
	}

	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	public function getPhoneHome() {
		return $this->phone_home;
	}

	public function setPhoneHome($phone_home) {
		$this->phone_home = $phone_home;
	}

	public function getPhoneEmergency() {
		return $this->phone_emergency;
	}

	public function setPhoneEmergency($phone_emergency) {
		$this->phone_emergency = $phone_emergency;
	}

	public function getPrimaryPhysician() {
		return $this->primaryPhysician;
	}

	public function setPrimaryPhysician($primaryPhysician) {
		$this->primaryPhysician = $primaryPhysician;
	}

	public function getExistingConditions() {
		return $this->existingConditions;
	}

	public function setExistingConditions($existingConditions) {
		$this->existingConditions = $existingConditions;
	}

	public function getMedication1() {
		return $this->medication1;
	}

	public function setMedication1($medication1) {
		$this->medication1 = $medication1;
	}

	public function getMedication2() {
		return $this->medication2;
	}

	public function setMedication2($medication2) {
		$this->medication2 = $medication2;
	}

	public function getMedication3() {
		return $this->medication3;
	}

	public function setMedication3($medication3) {
		$this->medication3 = $medication3;
	}
}
?>