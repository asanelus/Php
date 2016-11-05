<?php
class Patient extends CI_Model {
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