<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Triage extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->model('Patient');
		$this->load->model('Visit');
		$this->load->driver('session');
	}

	/**
	* Initial entry point.
	*/
	public function index() {
		$userId = $this->session->userdata('userId');
		
		if($userId) {
			$data['userId'] = $userId;
		} else {
			// By setting this to empty string, we can avoid having to check
			// if it's null in the view
			$data['userId'] = '';
		}
		
		// unsorted queue length
		$length = $this->getQueueLength();
		if(isset($length))
			$data['queueLength'] = $length;

		// patient info
		$patient = $this->session->userdata('patient');
		if (isset($patient))
			$data['patient'] = $patient;

		//This takes care of the load->view
		$this->load->template("triage/triage", $data);	

		
	}

	/**
	* Entry point when requesting to see the next unsorted Patient.
	*/
	public function getNextPatient() {
		$queue = $this->getQueue('unsorted');
		if (!$queue->isEmpty()) {
			$next = $queue->dequeue();

			$patient = array(
				'patient' => array(
					'Patient ID:'=>$next->getPatient_id(),
					'RAMQ:'=>$next->getRamq(),
					'First Name:'=>$next->getFirstName(),
					'Last Name:' => $next->getLastName(),
					'Phone - Home:'=>$next->getPhoneHome(),
					'Phone - Emergency:'=>$next->getPhoneEmergency(),
					'Primary Physician:'=>$next->getPrimaryPhysician(),
					'Existing Conditions:'=>$next->getExistingConditions(),
					'Medication1:'=>$next->getMedication1(),
					'Medication2:'=>$next->getMedication2(),
					'Medication3:'=>$next->getMedication3(),
				)
			);
			//create session data with the Patient array
			$this->session->set_userdata($patient);

			//update the 'unsorted' queue in the database
			$serialized = $queue->serialize();
			$datam = array('queue_content'=>$serialized);
			$this->db->where('queue_name', 'unsorted');
			$this->db->update('queue', $datam);
		}


		//refresh the page
		redirect('triage/index', 'refresh');
	}

	/**
	* Entry point when submitting a new Visit.
	*/
	public function submitNewPatient() {
		//get information from the form
		$code = $this->input->post("code");
		$primaryComplaint = $this->input->post("primaryComplaint");
		$secondaryComplaint1 = $this->input->post("secondaryComplaint1");
		$secondaryComplaint2 = $this->input->post("secondaryComplaint2");

		//construct Patient object
		$patient = $this->session->userdata('patient');

		$p = new Patient();
		$p->setPatient_id($patient['Patient ID:']);
		$p->setRamq($patient['RAMQ:']);
		$p->setLastName($patient['First Name:']);
		$p->setFirstName($patient['Last Name:']);
		$p->setPhoneHome($patient['Phone - Home:']);
		$p->setPhoneEmergency($patient['Phone - Emergency:']);
		$p->setPrimaryPhysician($patient['Primary Physician:']);
		$p->setExistingConditions($patient['Existing Conditions:']);
		$p->setMedication1($patient['Medication1:']);
		$p->setMedication2($patient['Medication2:']);
		$p->setMedication3($patient['Medication3:']);

		//construct Visit object
		$visit = new Visit();
		$visit->setCode($code);
		$visit->setPrimaryComplaint($primaryComplaint);
		$visit->setSymptom1($secondaryComplaint1);
		$visit->setSymptom2($secondaryComplaint2);
		
		//enqueue patient
		$this->enqueuePatient($p, $visit);
		
		//update visit
		$this->updateVisit($p, $visit);
		
		redirect('triage', 'refresh');		
	}

	/**
	* Get the queue from the database, enqueue the Patient object, serialize it, and put it into the database
	*
	* @param $patient the Patient object
	* @param $visit the Visit object
	*/
	private function enqueuePatient($patient, $visit) {
		$code = $visit->getCode();
		$queue = $this->getQueue($code);

		$queue->enqueue($patient);
		$serialized = $queue->serialize();

		$datam = array('queue_content'=>$serialized);
		$this->db->where('queue_name', $code);
		$this->db->update('queue', $datam);
	}

	/**
	* Gets a serialized queue from the database, unserializes it, and returns it.
	*
	* @param the string name of the queue (e.g. 'unsorted', '1')
	* @return the unserialized queue
	*/
	private function getQueue($name) {
		$queueTable = $this->db->query("SELECT `queue_content` FROM queue WHERE queue_name LIKE '" . $name . "'");
		$row = $queueTable->row_array();
		$serializedQueue = $row['queue_content'];
		$unserializedQueue = new SplQueue();

		if (!empty($serializedQueue)) {
			$unserializedQueue->unserialize($serializedQueue);
		}

		return $unserializedQueue;
	}

	/**
	* Count the number of items in the Unsorted queue
	*
	* @return the length of the unsorted queue
	*/
	private function getQueueLength() {
		$queue = new SplQueue();
		$queue = $this->getQueue('unsorted');
		$length = $queue->count();
		return $length;
	}

	/**
	* Update the row in the visit table with new primary complaint, secondary complaints, 
	* and code.
	*/
	private function updateVisit($patient, $visit) {
		//find the visit_id
		$patient_id = $patient->getPatient_id();
		$query = "SELECT MAX(`visit_id`) as visit_id FROM VISIT WHERE `patient_id` = '" . $patient_id . "'";
		$row = $this->db->query($query);
		$visitFromDb = $row->row_array();
		$visit_id = $visitFromDb['visit_id'];
		
		//update the visit
		date_default_timezone_set('America/New_York');
		$datam = array(
			'code'=>$visit->getCode(),
			'primary_complaint'=>$visit->getPrimaryComplaint(),
			'time_of_triage'=>date('o-m-d H:i:s'),
			'symptom1'=>$visit->getSymptom1(),
			'symptom2'=>$visit->getSymptom2()
		);
		$this->db->where('visit_id', $visit_id);
		$this->db->update('visit', $datam);
	}
}
?>