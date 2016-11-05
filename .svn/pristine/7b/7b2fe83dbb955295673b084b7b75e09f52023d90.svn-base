<?php
// See application/core/MY_Loader.php for $this->load->template(...)
if(!defined('BASEPATH'))
	exit('No direct script access allowed');

// http://stackoverflow.com/questions/8616887/logout-codeigniter for logout 

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('login_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->driver('session');
		
		// Define validation rules
		$this->form_validation->set_rules('username', 'Username',
				'trim|required');
		$this->form_validation->set_rules('password', 'Password',
				'trim|required');
	}
	
	public function index() {
		$data['title'] = 'Clinic - Login';
		$data['error'] = '';
		
		if($this->form_validation->run() == FALSE) {
			// Error, show form again.
			$this->load->template('login/login', $data);
		} else {
			// Now check the username and password with the model.
			$userName = $this->input->post('username');
			// See application/helpers/utility_helper.php for valid_string() method
			if(valid_string($userName)) {
				// Check that the username exists in the database
				$userNameQuery = $this->login_model->getUserName($userName);
				if($userNameQuery) {
					// username exists

					// Check the database with this user's name to see if they
					// are locked out from logging in
					$invalidLoginsQuery = $this->login_model->getInvalidLoginCtr(
						$userName);
					if($invalidLoginsQuery->invalid_login_counter >= 5) {
						// The user has surpassed the specified login
						// attempts. Prevent them from gaining access.
						$data['error'] = 'User account \'' . $userName .
														'\' locked: too many failed login 
														attempts. Please contact a site 
														administrator.'; 
						$this->load->template('login/login', $data);
					} else {
						$pwd = $this->input->post('password');
						if(valid_string($pwd)) {
							$queryPassword = $this->login_model->getUserPasswordByName(
								$userName);

							if($queryPassword && password_verify($pwd, 
									$queryPassword->hashed_password)) {
								// Found user! Log them in.
								// Put the user id and user privileges in the session
								$userData = 
									$this->login_model->getUserIdAndPrivsByName(
										$userName);
								
								$this->session->set_userdata('userId', 
										$userData->user_id);
								$this->session->set_userdata('receptionPriv', 
										$userData->reception_priv);
								$this->session->set_userdata('triagePriv', 
										$userData->triage_priv);
								$this->session->set_userdata('nursePriv', 
										$userData->nurse_priv);
								// Send the user to the home controller
								redirect('home', 'index');
							} else {
								// Incorrect password or password does not exist.
								
								// Check if their invalid_login_counter is 
								// still less than 5.
								$counterQuery = 
									$this->login_model->getInvalidLoginCtr(
										$userName);
								if($counterQuery->invalid_login_counter < 5) {
									// Increment the invalid_login_counter in the
									// database
									$this->login_model->incrementInvalidLoginCtr(
											$userName);
									$data['error'] = 'Invalid username or password.';
								} else {
									// The user has surpassed the specified login
									// attempts. Prevent them from gaining access.
									$data['error'] = 'User account \'' . $userName .
																	'\' locked: too many failed login 
																	attempts. Please contact a site 
																	administrator.'; 
								}
								$this->load->template('login/login', $data);
							}
						} else {
							$data['error'] = 'Please type in a password.';
							$this->load->template('login/login', $data);
						}
					}
				} else {
					// username doesn't exist.
					$data['error'] = 'Invalid username or password.';
					$this->load->template('login/login', $data);
				}
			} else {
				$data['error'] = 'Please type in a username.';
				$this->load->template('login/login', $data);
			}
		}
	}
}
?>