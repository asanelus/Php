<?php
class Login_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function getUsers() {
		$query = $this->db->get('user');
		return $query->result_array();
	}

	public function getUserName($userName = '') {
		$sql = "SELECT user_name FROM user WHERE user_name = ?";

		$query = $this->db->query($sql, array($userName));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}
	
	public function getUserPasswordByName($userName = '') {
		$sql = "SELECT hashed_password " .
				"FROM user WHERE user_name = ?";
		$query = $this->db->query($sql, array($userName));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}
	
	public function getUserIdAndPrivsByName($userName = '') {
		$sql = "SELECT user_id, reception_priv, triage_priv, " .
				"nurse_priv FROM user WHERE user_name = ?";
		$query = $this->db->query($sql, array($userName));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}
	
	public function incrementInvalidLoginCtr($userName = '') {
		$sql = "UPDATE user SET invalid_login_counter = " .
				"invalid_login_counter + 1 " .
				"WHERE user_name = ?";
		$query = $this->db->query($sql, array($userName));
		// Since this a write query, it will return TRUE or FALSE
		return $query;
	}
	
	public function resetInvalidLoginCtrForUser($userName = '') {
		$sql = "UPDATE user SET invalid_login_counter = 0 " .
				"WHERE user_name = ?";
		$query = $this->db->query($sql, array($userName));
		// Since this a write query, it will return TRUE or FALSE
		return $query;
	}
	
	public function getInvalidLoginCtr($userName = '') {
		$sql = "SELECT invalid_login_counter FROM user " . 
				"WHERE user_name = ?";
		$query = $this->db->query($sql, array($userName));
		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return 0;
		}
	}
}
?>