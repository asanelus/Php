<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Examination extends CI_Controller {
	private $queuecont1;
	private $queuecont2;
	private $queuecont3;
	private $queuecont4;
	private $queuecont5;
	private $positionCtr;
	
	public function __construct() {
		parent::__construct ();
		
		$this->load->model ( 'examination_model' );
		$this->load->model ( 'web_api_model' );
		$this->load->model ( 'Patient' );
		$this->load->model ( 'Visit' );
		$this->load->driver ( 'session' );
		$this->load->helper ( 'form' );
		
		$this->positionPattern = array (
				2,
				3,
				2,
				4,
				3,
				2,
				5,
				2,
				3,
				4 
		);
		$this->positionMax = 10;
		
		if ($this->session->userdata ( 'positionCtr' )) {
			$this->positionCtr = $this->session->userdata ( 'positionCtr' );
		} else {
			$this->positionCtr = 0;
		}
	}
	
	/**
	 * Opens a visit page with information about the patient and their current visit
	 *
	 * @param number $visitId        	
	 */
	public function visit($visitId = -1) {
	
		
		//setting the data and updating the examination time
		if(isset($visitId) && $visitId >0){
			$userId = $this->session->userdata('userId');
			
			$this->examination_model->updateExaminationTime();
			$rowInfo = $this->examination_model->get_patient_visit_info_row ( $visitId );
			
			$data ['last_name'] = $rowInfo->last_name;
			$data ['first_name'] = $rowInfo->first_name;
			$data ['existing_conditions'] = $rowInfo->existing_conditions;
			$data ['medication1'] = $rowInfo->medication1;
			$data ['medication2'] = $rowInfo->medication2;
			$data ['medication3'] = $rowInfo->medication3;
			$data ['primary_physician'] = $rowInfo->primary_physician;
			$data ['phone_num_home'] = $rowInfo->phone_num_home;
			$data ['phone_num_emergency'] = $rowInfo->phone_num_emergency;
			$data ['primary_complaint'] = $rowInfo->primary_complaint;
			$data ['symptom1'] = $rowInfo->symptom1;
			$data ['symptom2'] = $rowInfo->symptom2;
			$data ['code'] = $rowInfo->code;
			$data ['page_title'] = 'Clinic - Visit';
			
			if($userId) {
				$data['userId'] = $userId;
			} else {
				// By setting this to empty string, we can avoid having to check
				// if it's null in the view
				$data['userId'] = '';
			}		
			$this->load->template ( 'examination/visit', $data );
		}else{
			
			$amount1 = count ( $this->queuecont1 );
			$amount2 = count ( $this->queuecont2 );
			$amount3 = count ( $this->queuecont3 );
			$amount4 = count ( $this->queuecont4 );
			$amount5 = count ( $this->queuecont5 );
			$data ['queue1'] = $amount1;
			$data ['queue2'] = $amount2;
			$data ['queue3'] = $amount3;
			$data ['queue4'] = $amount4;
			$data ['queue5'] = $amount5;
			$this->load->template ( 'examination/examination', $data );
		}
	}
	
	/**
	 * Dequeue a patient following a pattern and opens a visit page
	 */
	public function dequeue() {

		$this->queuecont1 = $this->examination_model->get_visit_models_in_queue ( "1" );
		$this->queuecont2 = $this->examination_model->get_visit_models_in_queue ( "2" );
		$this->queuecont3 = $this->examination_model->get_visit_models_in_queue ( "3" );
		$this->queuecont4 = $this->examination_model->get_visit_models_in_queue ( "4" );
		$this->queuecont5 = $this->examination_model->get_visit_models_in_queue ( "5" );
		
		//var_dump($this->queuecont2);
		//var_dump($this->queuecont3);
		//var_dump($this->queuecont4);
		//var_dump($this->queuecont5);
		
		//Take care of queue 1 first
		if (count ( $this-> queuecont1 ) != 0) {
			$before =  $this->queuecont1[0];
			
			$visit = array_shift ( $this->queuecont1 );				
			$this -> examination_model -> updateQueue("1");
			$this -> examination_model -> updateExaminationTime("1");
			echo ' id in queue one : ' .$visit->getVisit_id () ;
			echo 'before variable id: '. $before->getVisit_id () ;
			//var_dump(( $this-> queuecont1 ));
			$this->visit ( $visit->getVisit_id () );
		} else {
			
			$this->positionCtr = $this->session->userdata('positionCtr');
			if(!isset($this->positionCtr))
				$this->positionCtr=0;
			
			//check if the current queue is empty
			$qname= "queuecont".$this->positionPattern[$this->positionCtr];
			echo 'name of q: ' .$qname;
			if( empty($this -> {$qname})){
				$this->positionCtr = $this->positionCtr +1;
				$this->session->set_userdata ( 'positionctr', $this->positionCtr );
			}else{
				
				$visit = $this -> {$qname}[0];
				//check all the higher priority queues if they have patients
				//that have been waiting longer
				for($i= $this->positionPattern[$this->positionCtr]-1 ; $i > 0 ; $i--){
					$tempname = 'queuecont'.$i;
					if(!empty($this -> {$tempname})){
						$avisit = $this -> {$tempname}[0];
						
						if( $visit -> getTimeOfRegistration() > $avisit-> getTimeOfRegistration()  ){
							$visit1 = array_shift ($this -> {$qname} );
						
							$id = $visit1->getVisit_id ();
							echo 'after checking time id: '. $id;
							$this -> examination_model -> updateQueue($i);
							$this -> examination_model -> updateExaminationTime($i);
							$this->visit ( $id );
							break 3;
						}
					}
									
				}
					
				
			}//otherwise take care of current patient
				$qname= "queuecont".$this->positionPattern[$this->positionCtr];
				$visit2 = array_shift ($this -> {$qname} );					
				$id = $visit2->getVisit_id ();				
				$this -> examination_model -> updateQueue($this->positionPattern[$this->positionCtr]);
				echo 'id before visit ' .$visit2->getVisit_id ();
				echo 'array count after shift : ' . count($this -> {$qname});
				$this->visit ( $visit2->getVisit_id ());			
			$this->positionCtr = $this->positionCtr +1;
			$this->session->set_userdata ( 'positionctr', $this->positionCtr );
		}		
		
	
	}
	public function _output($output) {
		echo $output;
	}
	public function index() {
		$data ['pagetitle'] = 'Clinic - Examination';
		$userId = $this->session->userdata('userId');
		if($userId) {
			$data['userId'] = $userId;
		} else {
			// By setting this to empty string, we can avoid having to check
			// if it's null in the view
			$data['userId'] = '';
		}
		
		//checks if there is already positionCtr in userdata 
		//otherwise sets to 0 
		if ($this->session->userdata ( 'positionCtr' )) {
			if($this->session->userdata ( 'positionCtr' ) <10){
				$this->positionCtr = $this->session->userdata ( 'positionCtr' );
						
			}else{
				$this->positionCtr =0;
				$this->session->set_userdata ( 'positionctr', $this->positionCtr );
			}
		} else {
			$this->positionCtr = 0;
		}
		
		//getting all the visit models in the queues
		$this->queuecont1 = $this->examination_model->get_visit_models_in_queue ( "1" );
		$this->queuecont2 = $this->examination_model->get_visit_models_in_queue ( "2" );
		$this->queuecont3 = $this->examination_model->get_visit_models_in_queue ( "3" );
		$this->queuecont4 = $this->examination_model->get_visit_models_in_queue ( "4" );
		$this->queuecont5 = $this->examination_model->get_visit_models_in_queue ( "5" );
		
		//checks if there are any patients left in the queues
		if(count($this -> queuecont1)+count($this -> queuecont2)+count($this -> queuecont3)+count($this -> queuecont4)+count($this -> queuecont5) == 0){
				$data['visitsLeft'] ='There are no patients left';
		}else{
			$data['visitsLeft'] = 'There are ' .count($this -> queuecont1)+count($this -> queuecont2)+count($this -> queuecont3)+count($this -> queuecont4)+count($this -> queuecont5).' patients left';
		}		
		
		
		//sets the queue's amounts
		$amount1 = count ( $this->queuecont1 );
		$amount2 = count ( $this->queuecont2 );
		$amount3 = count ( $this->queuecont3 );
		$amount4 = count ( $this->queuecont4 );
		$amount5 = count ( $this->queuecont5 );
		$data ['queue1'] = $amount1;
		$data ['queue2'] = $amount2;
		$data ['queue3'] = $amount3;
		$data ['queue4'] = $amount4;
		$data ['queue5'] = $amount5;
		$this->load->template ( 'examination/examination', $data );
	}	
}

/* End of file examinationCTL.php */