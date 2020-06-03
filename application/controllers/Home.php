<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Home_model');
    }

    public function index() {
        $this->data['currentPageCode'] = '';
        $this->data['pageHeading'] = 'Dashboard';
        $this->data['pageUrl'] = 'home/homeView';
        $this->loadView($this->data);
    }
    
    public function showChangePasswrord() {
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully changed your password";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Old password doesnot match";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['currentPageCode'] = '';
        $this->data['pageHeading'] = 'Change Password';
        $this->data['pageUrl'] = 'home/changePasswordView';
        $this->loadView($this->data);
    }

    public function changePassword() {
        $oldPassword = $this->input->post('oldPassword');
        $newPassword = $this->input->post('newPassword');

        $userLogin['password'] = md5($newPassword);
        $userLogin['updated_by'] = $this->user;
        $userLogin['updated_dt_tm'] = $this->dateTime;
        $response = $this->Home_model->changePassword($oldPassword, $userLogin);
        redirect('Home/showChangePasswrord?response=' . $response);
    }

}
