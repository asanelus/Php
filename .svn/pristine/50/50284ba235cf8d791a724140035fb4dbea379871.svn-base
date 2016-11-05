<?php
// Taken from: http://stackoverflow.com/questions/9540576/header-and-footer-in-codeigniter#9541565 and
// http://stackoverflow.com/questions/804399/codeigniter-create-new-helper
class MY_Loader extends CI_Loader {
    public function template($template_name, $vars = array(), $return = FALSE)
    {
        $this->view('templates/header', $vars, $return);
        $this->view($template_name, $vars, $return);
        $this->view('templates/footer', $vars, $return);
    }
}
?>