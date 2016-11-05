<?php
// Taken from http://stackoverflow.com/questions/804399/codeigniter-create-new-helper
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function asset_url() {
	return base_url().'assets/';
}

function valid_string($string) {
	if(!isset($string)) {
		return 0;
	}
	if(empty($string)) {
		return 0;
	}
	if(!is_string($string)) {
		return 0;
	}
	return 1;
}

?>