<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		// url helper is actually being autoloaded in application/config/autoload.php
		$this->load->helper('url');
		$this->load->driver('session');
		$this->load->helper('form');
	}
	
	public function index() {
		$data['title'] = 'Clinic - Home';
		$data['welcome_message'] = 'Welcome to the Flying Mongoose clinic, ' .
				'where all your medical needs are met. We hope to see you ' .
				'again!';

		$userId = $this->session->userdata('userId');
		$receptionPriv = $this->session->userdata('receptionPriv');
		$triagePriv = $this->session->userdata('triagePriv');
		$nursePriv = $this->session->userdata('nursePriv');

		if($userId) {
			$data['userId'] = $userId;
		} else {
			// By setting this to empty string, we can avoid having to check
			// if it's null in the view
			$data['userId'] = '';
		}
		if(isset($receptionPriv)) {
			$data['receptionPriv'] = $receptionPriv;
		} else {
			$data['receptionPriv'] = '';
		}
		if(isset($triagePriv)) {
			$data['triagePriv'] = $triagePriv;
		} else {
			$data['triagePriv'] = '';
		}
		if(isset($nursePriv)) {
			$data['nursePriv'] = $nursePriv;
		} else {
			$data['nursePriv'] = '';
		}

		$this->load->template('home/index', $data);
	}

	public function logout() {
		// User clicked logout. Unset all session variables.
		$this->session->unset_userdata('userId');
		$this->session->unset_userdata('receptionPriv');
		$this->session->unset_userdata('triagePriv');
		$this->session->unset_userdata('nursePriv');
		// Finally, destroy the session.
		$this->session->sess_destroy();
		redirect('login', 'index');
	}
}
?>