<?php
class Register_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function createPatient($ramqId, $lastName, $firstName, $phoneNumHome, 
		$phoneNumEmergency, $primaryPhysician, $existingConditions,
		$medication1, $medication2, $medication3) {
		$sql = "INSERT INTO patient(ramq_id, last_name, first_name, " .
			"phone_num_home, phone_num_emergency, primary_physician, " .
			"existing_conditions, medication1, medication2, medication3) " .
			"VALUES(?,?,?,?,?,?,?,?,?,?)";
		
		$query = $this->db->query($sql, array($ramqId, $lastName, $firstName, 
			$phoneNumHome, $phoneNumEmergency, $primaryPhysician, 
			$existingConditions, $medication1, $medication2, $medication3));
	}
	
	public function createVisit($ramqId) {
		$sql = "SELECT patient_id FROM patient where ramq_id = ?";
		
		$query1 = $this->db->query($sql, array($ramqId));
		
		$sql = "INSERT INTO visit(patient_id, `time_of_registration`) VALUES(?,?)";
		
		date_default_timezone_set('America/New_York');
		
		$timeOfRegistration = date('o-m-d H:i:s');
		
		$query2 = $this->db->query($sql, array($query1->row()->patient_id, $timeOfRegistration));	
	}
	
	public function getUserByRAMQId($ramqId = '') {
		$sql = "SELECT patient_id, ramq_id, last_name, first_name, phone_num_home,
			phone_num_emergency, primary_physician, existing_conditions,
			medication1, medication2, medication3 
			FROM patient WHERE ramq_id = ?";
		
		$query = $this->db->query($sql, array($ramqId));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}

	public function getAllMeds() {
		$sql = "SELECT medication_name FROM medication";

		$query = $this->db->query($sql);
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return 0;
		}
	}
	
	public function getMedIdByName($medName = '') {
		$sql = "SELECT medication_id FROM medication 
						WHERE medication_name = ?";

		$query = $this->db->query($sql, array($medName));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}
	
}
?>