<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('register_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->driver('session');

		// Define validation rules
		$this->form_validation->set_rules('ramqId', 'RAMQ Id', 
			'trim|required|exact_length[12]');
	}
	
	public function index() {
		$data['title'] = 'Clinic - Patient Registration';
		$data['error'] = '';
		
		// message comes from registerPatient
		// Note: $this->session->userdata(...) returns false if the item does
		// not exist
		if($this->session->userdata('message')) {
			$data['message'] = $this->session->userdata('message');
		} else {
			$data['message'] = '';
		}
		
		$userId = $this->session->userdata('userId');
		
		if($userId) {
			$data['userId'] = $userId;
		} else {
			// By setting this to empty string, we can avoid having to check
			// if it's null in the view
			$data['userId'] = '';
		}

		if($this->form_validation->run() == FALSE) {
			// Error, show form again
			$this->load->template('register/register', $data);
		} else {
			$ramqId = $this->input->post('ramqId');
			// Sends the ramqId in the url to the loadPage function
			header('Location:registerPatient/loadPage/' . urlencode($ramqId));
		}
	}
}
?>