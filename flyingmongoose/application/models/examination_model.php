<?php
class Examination_model extends CI_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->database ();
		$this->load->model ( 'Patient' );
	}
	/**
	 * Updates the desired queue by dequeueing
	 * 
	 * @param number $queuename
	 */
	public function updateQueue($queuename = 0) {
		$q1 = $this->getQueue ( $queuename ) ;
		
		if (count ( $q1 ) > 0) {
			$q1->pop();
			$serialized = $q1->serialize ();
			$this->db->trans_start();
			$this->db->query("SELECT * from queue where queue_name=".$queuename." FOR UPDATE");
			$this->db->query ( "UPDATE QUEUE SET queue_content='" . $serialized . "' WHERE queue_name = " . $queuename );
			$this->db->trans_complete();
						
		}
	}
	
	public function updateExaminationTime($visitId=-1){
		if (isset ( $visitId ) && is_numeric ( $visitId ) && $visitId > 0) {
			date_default_timezone_set('America/New_York');
			
			$this->db->trans_start();
			$this->db->query("SELECT * from visit where visit_id=".$visitId." FOR UPDATE");
			$this->db->query ( "UPDATE VISIT SET time_of_registration='" . date('o-m-d H:i:s') . "' where visit_id=".$visitId );
			$this->db->trans_complete();
		}
	}	
	
	
	/**
	 * Gets a serialized queue from the database, unserializes it,
	 * and returns it.
	 *
	 * @param $name the
	 *        	string name of the queue (e.g. 'unsorted', '1')
	 * @return the unserialized queue
	 */
	public function getQueue($name) {
		$queueTable = $this->db->query ( "SELECT `queue_content`
    	FROM queue WHERE queue_name =" . $name  );
		$row = $queueTable->row_array ();
		$serializedQueue = $row ['queue_content'];
		$unserializedQueue = new SplQueue ();
		if (! empty ( $serializedQueue )) {
			$unserializedQueue->unserialize ( $serializedQueue );
		}
		//var_dump($unserializedQueue);
		return $unserializedQueue;
	}
	/**
	 *Returns the Patient objects that are in the desired queue
	 * @param string $queue_names        	
	 * @return array of Patient Objects
	 */
	public function get_patient_models_in_queue($queue_name) {
		$q1 =  $this->getQueue ( $queue_name ) ;
		$patients = array ();
		
		foreach ( $q1 as $visit ) {
			if ($visit != "") {
				$row = $this->get_patient_visit_info_row ( $visit );
				
				$tempPatient = $this->Patient->__construct ( $row->patient_id, $row->ramq_id, $row->last_name, $row->first_name, $row->phone_num_home, $row->phone_num_emergency, $row->primary_physician, $row->existing_conditions, $row->medication1, $row->medication2, $row->medication3 );
				$patients [] = $tempPatient;
			} 
		}
		
		return $patients;
	}
	/**
	 *Returns the Visit objects that are in the desired queue
	 * @param string $queue_names        	
	 * @return array of Visit Objects
	 */
	public function get_visit_models_in_queue($queue_name) {
		
		$q1 = $this->getQueue ( $queue_name );
		//$tempq1 = $q1 -> dequeue();		
		//var_dump($q1);
		
		//echo  'count of q1 '. count($q1) . '<br />';
		$visits = array ();			
		//echo 'gets here in get visitmodels ';
		//var_dump($q1);
		foreach ( $q1 as $visit ) {
			if ($visit != "" && $visit != "NULL") {			
			//	echo 'patientID '. $visit -> getPatient_id() ;
			//	$row1 = $this -> get_patient_info_row($visit -> getPatient_id());	
				//var_dump($visit);
				$row =  $this -> get_patient_visit_info_row_patientid($visit -> getRamq());
				//echo ' row content ' . $row['ramq_id'] ;
				//var_dump($row);
				if (! is_null ( $row )) {
					
					$tempVisit = new Visit ( $row->visit_id, $row->patient_id, $row->time_of_registration, $row->time_of_examination, $row->code, "", $row->primary_complaint, $row->symptom1, $row->symptom2 );
					$visits [] = $tempVisit;
				}else{
					//echo 'null';
					//var_dump($row);
				}
			}
			//var_dump($visit);
		}
		echo  'count of visits'. count($visits);
		return $visits;
	}
	/**
	 * Returns a row from the db containing all the info about the patient and visit
	 * associated with $visitId
	 *
	 * @param number $visitId        	
	 * @return array
	 */
	public function get_patient_visit_info_row($visitId = 0) {
		if (isset ( $visitId ) && is_numeric ( $visitId ) && $visitId > 0) {
			$query = $this->db->query ( "SELECT * FROM VISIT JOIN PATIENT ON  VISIT.PATIENT_ID =PATIENT.PATIENT_ID WHERE VISIT.VISIT_ID=" . $visitId );
			$row = $query->row ();
			return $row;
		}
		return null;
	}
	
	public function get_patient_visit_info_row_patientid($patientId = -1) {
		if (isset ( $patientId )) {			
			$query = $this->db->query ( "SELECT * FROM VISIT , PATIENT  WHERE VISIT.PATIENT_ID =PATIENT.PATIENT_ID AND PATIENT.RAMQ_ID LIKE '" . $patientId."'" );
			
			$row = $query->row ();
			return $row;
		}
		
		return null;
	}
	
	public function get_patient_info_row($patientId = 0) {
		if (isset ( $patientId ) && is_numeric ( $patientId ) && $patientId > 0) {
			$query = $this->db->query ( "SELECT * FROM PATIENT  WHERE PATIENT_ID =" . $patientId );
			$row = $query->row ();
			return $row;
		}
		return null;
	}	
}
?>