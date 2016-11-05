<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');

class Web_api extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('web_api_model');
		$this->load->model('Patient');
		$this->load->driver('session');
	}
	
	public function getPatientAndVisitData($visitId = -1) {
		if(isset($visitId) && $visitId > 0) { 
			$result = $this->web_api_model->get_visits($visitId);
		} else {
			$result = NULL;
		}
		
		// If it's not null
		if(isset($result)) {
			// If it's not zero
			if($result) {
				$output = $result;
			} else {
				// It's zero. No records were found.
				$output = array('error' => 0);
			}
		} else {
			// It's null. Visit id was not specified.
			$output = array('error' => 1);
		}
		
		$data['json'] = json_encode($output);
		$this->load->view('web_api/web_api', $data);
	}
	
	public function getWaitQueue($visitId = -1) {
		// Validate parameter
		if($visitId != -1) {
			$positionPattern = array (2,3,2,4,3,2,5,2,3,4);
			
			$queue1 = $this->getQueue('1');
			$queue2 = $this->getQueue('2');
			$queue3 = $this->getQueue('3');
			$queue4 = $this->getQueue('4');
			$queue5 = $this->getQueue('5');
			
			$waitQueue = array();
			$foundVisitId = false;
			
			// Get all the priority 1 patients into the array
			while(!$queue1->isEmpty()) {
				$dequeued = $queue1->dequeue();
				$newVisitId = $dequeued->getVisit_id();
				if($newVisitId == $visitId) {
					$foundVisitId = true;
					break;
				}
				$code = 1;
				$waitQueue[] = strval($code);
			}
			
			// If we have not yet found our visit id, start adding these codes
			if(!$foundVisitId) {
				// Get the rest of the patients according to the dequeuing algorithm.
				$ctr = 0;
				while(!$queue2->isEmpty() || !$queue3->isEmpty() ||
					!$queue4->isEmpty() || !$queue5->isEmpty()) {
					if($ctr == 10) {
						$ctr = 0;
					}
					
					if($positionPattern[$ctr] == 2 && !$queue2->isEmpty()) {
						$dequeued = $queue2->dequeue();
						$newVisitId = $dequeued->getVisit_id();
						if($newVisitId == $visitId) {
							break;
						}
						$code = 2;
						$waitQueue[] = strval($code);
					} elseif ($positionPattern[$ctr] == 3 && !$queue3->isEmpty()) {
						$dequeued = $queue3->dequeue();
						$newVisitId = $dequeued->getVisit_id();
						if($newVisitId == $visitId) {
							break;
						}
						$code = 3;
						$waitQueue[] = strval($code);
					} elseif($positionPattern[$ctr] == 4 && !$queue4->isEmpty()) {
						$dequeued = $queue4->dequeue();
						$newVisitId = $dequeued->getVisit_id();
						if($newVisitId == $visitId) {
							break;
						}
						$code = 4;
						$waitQueue[] = strval($code);
					} elseif($positionPattern[$ctr] == 5 && !$queue5->isEmpty()) {
						$dequeued = $queue5->dequeue();
						$newVisitId = $dequeued->getVisit_id();
						if($newVisitId == $visitId) {
							break;
						}
						$code = 5;
						$waitQueue[] = strval($code);
					}
					$ctr++;
				}
			}
			$waitQueueStr = '';
			foreach($waitQueue as $visitAndCode) {
				$waitQueueStr .= $visitAndCode . ';';
			}
			$result = $waitQueueStr;
		} else {
			// No parameters were sent in.
			$result = NULL;
		}
		
		// If it's not null
		if(isset($result)) {
			// If it's not zero
			if($result) {
				$output = $result;
			} else {
				// It's zero. No records were found.
				$output = array('error' => 0);
			}
		} else {
			// It's null. Visit id was not specified.
			$output = array('error' => 1);
		}
		
		$data['json'] = json_encode($output);
		//third option is to return data from page instead of viewing the page
		$this->load-> view('web_api/web_api', $data);
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
    	FROM queue WHERE queue_name LIKE '" . $name . "'" );
		$row = $queueTable->row_array ();
		$serializedQueue = $row ['queue_content'];
		$unserializedQueue = new SplQueue ();
		if (! empty ( $serializedQueue )) {
			$unserializedQueue->unserialize ( $serializedQueue );
		}
		return $unserializedQueue;
	}
}
?>