<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contacts extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Contacts_model');
    }

    public function index() {
        redirect('Home');
    }

    public function vendor() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully deleted";
            $this->data['msgFlag'] = "success";
        }
        $this->data['currentPageCode'] = VENDOR_PAGE;
        $this->data['pageHeading'] = 'Vendor';
        $this->data['pageUrl'] = 'contacts/vendorView';
        $this->loadView($this->data);
    }

    public function getVendorList() {
        $this->userRoleAuthentication(VENDOR_PAGE);

     

        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Contacts_model->getVendorForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);


//        $results = $this->Contacts_model->getVendor(array('isActive' => 1));
//        $response = array();
//        $i = 1;
//        foreach ($results as $result) {
//            $status = "";
//            if ($result['is_active'] == 1) {
//                $status = '';
//            } else if ($result['is_active'] == 0) {
//                $status = '';
//            }
//            $x = array($i,
//                $result['display_contact_id'],
//                '<span class="td-f-l">' . $result['contact_name'] . '</span>',
//                $result['mobile_no'],
//                ($result['email']) ? '<span class="td-f-l">' . $result['email'] . '</span>' : '<small><i>N/A</i></small>'
//            );
//            $response[] = $x;
//            $i++;
//        }
//        echo json_encode(array('data' => $response));
    }

    public function newVendor() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully created a vendor";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate vendor";
            $this->data['msgFlag'] = "danger";
        }

        $this->data['currentPageCode'] = VENDOR_PAGE;
        $this->data['pageHeading'] = 'New Vendor';
        $this->data['pageUrl'] = 'contacts/addVendorView';
        $this->loadView($this->data);
    }

    public function vendorDuplicateCheck() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'string', 30, 1);
        $arr['displayContactId'] = $this->getInputValue('displayContactId', 'POST', 'string', 30, 1);
        $arr['contactCode'] = $this->getInputValue('contactCode', 'POST', 'string', 30, 0);
        $result = $this->Contacts_model->vendorDuplicateCheck($arr);
        echo $result;
    }

    public function addVendor() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $contactInfo['display_contact_id'] = $this->getInputValue('displayContactId', 'POST', 'string', 30, 1);
        $contactInfo['contact_name'] = $this->getInputValue('fullName', 'POST', 'string', 200, 1);
        $contactInfo['mobile_no'] = $this->getInputValue('mobile', 'POST', 'mobile', NULL, 0);
        $contactInfo['email'] = $this->getInputValue('email', 'POST', 'email', NULL, 0);
        $contactInfo['address'] = $this->getInputValue('address', 'POST', 'string', NULL, 0);
        $contactInfo['opening_balance'] = $this->getInputValue('openingBalance', 'POST', 'float', NULL, 0);
        $contactInfo['created_by'] = $this->user;
        $contactInfo['created_dt_tm'] = $this->dateTime;
        $contactInfo['updated_by'] = $this->user;
        $contactInfo['updated_dt_tm'] = $this->dateTime;
        $result = $this->Contacts_model->addVendor($contactInfo);
        redirect('Contacts/newVendor?response=' . $result);
    }

    public function showVendorDetails() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $vendorId = $this->getInputValue('vendorId', 'GET', 'string', NULL, 1);
        $this->data['vendorDetail'] = $this->Contacts_model->getVendor(array('vendorId' => $vendorId));
        if ($this->data['vendorDetail']) {
            $this->data['currentPageCode'] = VENDOR_PAGE;
            $this->data['pageHeading'] = 'Vendor Details';
            $this->data['pageUrl'] = 'contacts/vendorDetailView';
            $this->loadView($this->data);
        } else {
            redirect('Contacts/vendor');
        }
    }

    public function showEditVendor() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully edited a vendor";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate vendor";
            $this->data['msgFlag'] = "danger";
        }
        $vendorId = $this->getInputValue('vendorId', 'GET', 'string', NULL, 1);
        $this->data['vendorDetail'] = $this->Contacts_model->getVendor(array('vendorId' => $vendorId));
        if ($this->data['vendorDetail']) {
            $this->data['currentPageCode'] = VENDOR_PAGE;
            $this->data['pageHeading'] = 'Edit Vendor';
            $this->data['pageUrl'] = 'contacts/editVendorView';
            $this->loadView($this->data);
        } else {
            redirect('Contacts/vendor');
        }
    }

    public function editVendor() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $contactInfo['contact_code'] = $this->getInputValue('vendorId', 'POST', 'string', NULL, 1);
        $contactInfo['contact_name'] = $this->getInputValue('fullName', 'POST', 'string', 200, 1);
        $contactInfo['mobile_no'] = $this->getInputValue('mobile', 'POST', 'mobile', NULL, 1);
        $contactInfo['email'] = $this->getInputValue('email', 'POST', 'email', NULL, 0);
        $contactInfo['address'] = $this->getInputValue('address', 'POST', 'string', NULL, 0);
        $contactInfo['opening_balance'] = $this->getInputValue('openingBalance', 'POST', 'float', NULL, 0);
        $contactInfo['updated_by'] = $this->user;
        $contactInfo['updated_dt_tm'] = $this->dateTime;

        $vendorDetail = $this->Contacts_model->getVendor(array('vendorId' => $contactInfo['contact_code']));
        if ($vendorDetail) {
            $result = $this->Contacts_model->editVendor($contactInfo);
            redirect('Contacts/showEditVendor?vendorId=' . $contactInfo['contact_code'] . '&response=' . $result);
        } else {
            redirect('Contacts/vendor');
        }
    }

    public function deleteVendor() {
        $this->userRoleAuthentication(VENDOR_PAGE);
        $vendorId = $this->getInputValue('vendorId', 'POST', 'string', NULL, 1);
        $contactInfo['is_active'] = 0;
        $contactInfo['updated_by'] = $this->user;
        $contactInfo['updated_dt_tm'] = $this->dateTime;
        $response = $this->Contacts_model->deleteVendor($contactInfo, $vendorId);
        echo $response;
    }

}
