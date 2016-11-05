<?php
class Web_api_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function get_visits($visitId) {
		if(!isset($visitId)) {
			return 0;
		}
		if(!is_numeric($visitId)) {
			return 0;
		}
		
		$sql = "SELECT patient.patient_id, ramq_id, last_name, first_name, " . 
			"phone_num_home, phone_num_emergency, primary_physician, " .
			"existing_conditions, medication1, medication2, medication3, " .
			"visit_id, code, primary_complaint, symptom1, symptom2 " .
			"FROM visit JOIN patient ON visit.patient_id = patient.patient_id " .
			"WHERE visit_id = ?";
		
			$query = $this->db->query($sql, array($visitId));
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
	
	public function get_wait_queue($visitId) {
		if(!isset($visitId)) {
			return 0;
		}
		if(empty($visitId)) {
			return 0;
		}
		if(!is_numeric($visitId)) {
			return 0;
		}
	
		$sql = "SELECT patient.patient_id, ramq_id, last_name, first_name, " .
				"phone_num_home, phone_num_emergency, primary_physician, " .
				"existing_conditions, medication1, medication2, medication3, " .
				"visit_id, code, primary_complaint, symptom1, symptom2 " .
				"FROM visit JOIN patient ON visit.patient_id = patient.patient_id " .
				"WHERE visit_id = ?";
	
		$query = $this->db->query($sql, array($visitId));
		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return 0;
		}
	}
}
?>