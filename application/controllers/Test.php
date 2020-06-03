<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function curlTest() {
        //echo 'test';
        echo $this->input->post('age');
    }

}
