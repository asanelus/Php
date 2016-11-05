<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegisterPatient extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('register_model');
		$this->load->model('Patient');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->driver('session');

		// Define validation rules
		$this->form_validation->set_rules('ramqId', 'RAMQ Id', 
			'trim|required|exact_length[12]');
		$this->form_validation->set_rules('lastName', 'Last name',
			'trim|required|alpha');
		$this->form_validation->set_rules('firstName', 'First name',
			'trim|required|alpha');
		$this->form_validation->set_rules('homePhone', 'Home phone number',
			'trim|required');
		$this->form_validation->set_rules('emergencyPhone', 'Emergency
			phone number', 'trim|required');
		$this->form_validation->set_rules('primaryPhysician', 
			'Primary physician', 'trim|required');
		$this->form_validation->set_rules('existingConditions', 
			'Existing conditions', 'trim|required');
	}
	
	public function index($ramqId = '') {
		$data['title'] = 'Clinic - Patient Registration';
		$data['error'] = '';
		
		$userId = $this->session->userdata('userId');
		
		// Note: $this->session->userdata(...) returns false if the item does
		// not exist
		if($userId) {
			$data['userId'] = $userId;
		} else {
			// By setting this to empty string, we can avoid having if-statements
			// in the view
			$data['userId'] = '';
		}

		// Get all the meds so we can populate the select lists
		$meds = $this->register_model->getAllMeds();
		if($meds) {
			$medsArray = array();
			foreach ($meds as $val) {
				$medsArray[] = $val->medication_name;
			}
			$data['meds'] = $medsArray;
		}

		if($this->form_validation->run() == FALSE) {
			// Error, show form again
			$data['ramqId'] = $ramqId;
			$data['lastName'] = '';
			$data['firstName'] = '';
			$data['homePhone'] = '';
			$data['emergencyPhone'] = '';
			$data['primaryPhysician'] = '';
			$data['existingConditions'] = '';
			$data['med1'] = 0;
			$data['med2'] = 0;
			$data['med3'] = 0;
		} else {
			// Data entered has passed validation.
			// Add this new or updated patient to the unsorted queue
			$patient = new Patient();			
			$patient->setRamq($this->input->post('ramqId'));
			$patient->setLastName($this->input->post('lastName'));
			$patient->setFirstName($this->input->post('firstName'));
			$patient->setPhoneHome($this->input->post('homePhone'));
			$patient->setPhoneEmergency($this->input->post('emergencyPhone'));
			$patient->setPrimaryPhysician($this->input->post('primaryPhysician'));
			$patient->setExistingConditions($this->input->post('existingConditions'));
			$patient->setMedication1($medsArray[$this->input->post('med1')]);
			$patient->setMedication2($medsArray[$this->input->post('med2')]);
			$patient->setMedication3($medsArray[$this->input->post('med3')]);
			
			$row = $this->register_model->getUserByRAMQId($patient->getRamq());
			$patient_id = $row->patient_id;
			$patient->setPatient_id($patient_id);
			
			$this->enqueueUnsortedPatient($patient);
			
			$this->register_model->createPatient($patient->getRamq(), 
				$patient->getLastName(), $patient->getFirstName(), 
				$patient->getPhoneHome(), $patient->getPhoneEmergency(),
				$patient->getPrimaryPhysician(), $patient->getExistingConditions(),
				$patient->getMedication1(), $patient->getMedication2(),
				$patient->getMedication3());
			
			$this->register_model->createVisit($patient->getRamq());

			$message = 'Patient ' . $firstName . ' ' . $lastName . 
				' enqueued successfully.';
			$this->session->set_userdata('message', $message);
			redirect('register', 'index');
		}
		$this->load->template('register/registerPatient', $data);
	}

	public function loadPage($ramqId = '') {
		$data['title'] = 'Clinic - Patient Registration';
		$data['error'] = '';
		
		$userId = $this->session->userdata('userId');
		
		if($userId) {
			$data['userId'] = $userId;
		} else {
			// By setting this to empty string, we can avoid having to check
			// if it's null in the view
			$data['userId'] = '';
		}

		// Get all the meds so we can populate the select lists
		$meds = $this->register_model->getAllMeds();
		if($meds) {
			$medsArray = array();
			foreach ($meds as $val) {
				$medsArray[] = $val->medication_name;
			}
			$data['meds'] = $medsArray;
		}
		// Check the ramq id with the model
		$query = $this->register_model->getUserByRAMQId($ramqId);
		if($query) {
			// patient with specified ramqId exists. Load existing
			// patient's information.
			$data['ramqId'] = $query->ramq_id;
			$data['lastName'] = $query->last_name;
			$data['firstName'] = $query->first_name;
			$data['homePhone'] = $query->phone_num_home;
			$data['emergencyPhone'] = $query->phone_num_emergency;
			$data['primaryPhysician'] = $query->primary_physician;
			$data['existingConditions'] = $query->existing_conditions;
			
			$queryMed1 = $this->register_model->getMedIdByName(
				$query->medication1);
			if($queryMed1) {
				// Found medication id
				$data['med1'] = $queryMed1->medication_id;
			} else {
				$data['med1'] = 0;
			}

			$queryMed2 = $this->register_model->getMedIdByName(
				$query->medication2);
			if($queryMed2) {
				// Found medication id
				$data['med2'] = $queryMed2->medication_id;
			} else {
				$data['med2'] = 0;
			}

			$queryMed3 = $this->register_model->getMedIdByName(
				$query->medication3);
			if($queryMed3) {
				// Found medication id
				$data['med3'] = $queryMed3->medication_id;
			} else {
				$data['med3'] = 0;
			}
		} else {
			// patient does not exist. Load new patient registration
			// form.
			$data['ramqId'] = $ramqId;
			$data['lastName'] = '';
			$data['firstName'] = '';
			$data['homePhone'] = '';
			$data['emergencyPhone'] = '';
			$data['primaryPhysician'] = '';
			$data['existingConditions'] = '';
			$data['med1'] = 0;
			$data['med2'] = 0;
			$data['med3'] = 0;
		}
		$this->load->template('register/registerPatient', $data);
	}

  /**
  * Gets a serialized queue from the database, unserializes it, 
  * and returns it.
  *
  * @param $name the string name of the queue (e.g. 'unsorted', '1')
  * @return the unserialized queue
  */
  private function getQueue($name) {
    $queueTable = $this->db->query("SELECT `queue_content` 
    	FROM queue WHERE queue_name LIKE '" . $name . "'");
    $row = $queueTable->row_array();
    $serializedQueue = $row['queue_content'];
    $unserializedQueue = new SplQueue();
    if (!empty($serializedQueue)) {
            $unserializedQueue->unserialize($serializedQueue);
    }
    return $unserializedQueue;
  }
   
  /**
  * Get the queue from the database, enqueue the Patient object, 
  * serialize it, and put it into the database
  *
  * @param $patient the Patient object
  */
  private function enqueueUnsortedPatient($patient) {
    $unsortedQueue = $this->getQueue("unsorted");
    $unsortedQueue->enqueue($patient);
    $serialized = $unsortedQueue->serialize();
    $datam = array('queue_content'=>$serialized);
    $this->db->where('queue_name', 'unsorted');
    $this->db->update('queue', $datam);
  }


}
?>