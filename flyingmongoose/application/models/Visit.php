<?php
class Visit extends CI_Model {
	private $visit_id;
	private $patient_id;
	private $timeOfRegistration;
	private $timeOfExamination;
	private $code;
	private $positionInQueue;
	private $primaryComplaint;
	private $symptom1;
	private $symptom2;

	public function __construct($visit_id = "", $patient_id = "", 
		$timeOfRegistration = "", $timeOfExamination = "", $code = "", 
		$positionInQueue = "", $primaryComplaint = "", $symptom1 = "", 
		$symptom2 = "") {
		parent::__construct();
		$this->visit_id=$visit_id;
		$this->patient_id=$patient_id;
		$this->timeOfRegistration=$timeOfRegistration;
		$this->timeOfExamination=$timeOfExamination;
		$this->code=$code;
		$this->positionInQueue=$positionInQueue;
		$this->primaryComplaint=$primaryComplaint;
		$this->symptom1=$symptom1;
		$this->symptom2=$symptom2;
	}

	public function getVisit_id() {
		return $this->visit_id;
	}

	public function setVisit_id($visit_id) {
		$this->visit_id=$visit_id;
	}

	public function getPatient_id() {
		return $this->patient_id;
	}

	public function setPatient_id($patient_id) {
		$this->patient_id=$patient_id;
	}

	public function getTimeOfRegistration() {
		return $this->timeOfRegistration;
	}

	public function setTimeOfRegistration($timeOfRegistration) {
		$this->timeOfRegistration=$timeOfRegistration;
	}

	public function getTimeOfExamination() {
		return $this->timeOfExamination;
	}

	public function setTimeOfExamination($timeOfExamination) {
		$this->timeOfExamination=$timeOfExamination;
	}

	public function getCode() {
		return $this->code;
	}

	public function setCode($code) {
		$this->code=$code;
	}

	public function getPositionInQueue() {
		return $this->positionInQueue;
	}

	public function setPositionInQueue($positionInQueue) {
		$this->positionInQueue=$positionInQueue;
	}

	public function getPrimaryComplaint() {
		return $this->primaryComplaint;
	}

	public function setPrimaryComplaint($primaryComplaint) {
		$this->primaryComplaint=$primaryComplaint;
	}

	public function getSymptom1() {
		return $this->symptom1;
	}

	public function setSymptom1($symptom1) {
		$this->symptom1=$symptom1;
	}

	public function getSymptom2() {
		return $this->symptom2;
	}

	public function setSymptom2($symptom2) {
		$this->symptom2=$symptom2;
	}
}
?>