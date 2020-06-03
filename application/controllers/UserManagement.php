<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UserManagement extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserManagement_model');
    }

    public function index() {
        redirect('Home');
    }

    public function user() {
        $this->userRoleAuthentication(USER);
        $this->data['currentPageCode'] = USER;
        $this->data['pageHeading'] = 'User';
        $this->data['pageUrl'] = 'userManagement/userView';
        //$this->data['pageUrl'] = 'userManagement/userDataTableView';
        $this->loadView($this->data);
    }

    public function getUserList() {
        $this->userRoleAuthentication(USER);
        //$arr['isActive'] = '';
        $results = $this->UserManagement_model->getUser();
        $response = array();
        $i = 1;
        foreach ($results as $result) {
            $status = "";
            if ($result['is_active'] == 1) {
                $status = 'Active';
            } else if ($result['is_active'] == 0) {
                $status = 'Inactive';
            }
            $x = array($i,
                '<span class="td-f-l">' . $result['full_name'] . '</span>',
                $result['mobile_no'],
                ($result['email']) ? '<span class="td-f-l">' . $result['email'] . '</span>' : '<small><i>N/A</i></small>',
                ($result['role_title'] != '0') ? $result['role_title'] : '<small><i>N/A</i></small>',
                $status,
                $result['user_id']
            );
            $response[] = $x;
            $i++;
        }

        echo json_encode(array('data' => $response));
    }

    public function newUser() {
        $this->userRoleAuthentication(USER);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully crearted a user";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate user";
            $this->data['msgFlag'] = "danger";
        }

        $arr['isActive'] = 1;
        $this->data['userRoles'] = $this->UserManagement_model->getUserRole($arr);
        $this->data['currentPageCode'] = USER;
        $this->data['pageHeading'] = 'New User';
        $this->data['pageUrl'] = 'userManagement/addUserView';
        $this->loadView($this->data);
    }

    public function userDuplicateCheck() {
        $this->userRoleAuthentication(USER);
        $arr['userId'] = trim($this->input->post('userId', true));
        $arr['mobileNo'] = trim($this->input->post('mobileNo', true));
        $arr['addEditFlag'] = trim($this->input->post('addEditFlag', true));
        $result = $this->UserManagement_model->userDuplicateCheck($arr);
        echo $result;
    }

    public function addUser() {
        $this->userRoleAuthentication(USER);
        $fullName = $this->getInputValue('fullName', 'POST', 'string', 200, 1);
        $mobileNo = $this->getInputValue('mobile', 'POST', 'string', 30, 1);
        $email = $this->getInputValue('email', 'POST', 'email', 100, 0);
        $userRole = $this->getInputValue('userRole', 'POST', 'string', 100, 1);

        if ($fullName && $mobileNo && $userRole) {
            $userInfo['user_id'] = getCode(USER_CODE);
            $userInfo['full_name'] = $fullName;
            $userInfo['email'] = $email;
            $userInfo['mobile_no'] = $mobileNo;
            $userInfo['created_by'] = $this->user;
            $userInfo['created_dt_tm'] = $this->dateTime;
            $userInfo['updated_by'] = $this->user;
            $userInfo['updated_dt_tm'] = $this->dateTime;

            $userLogin['user_id'] = $userInfo['user_id'];
            $userLogin['username'] = $mobileNo;
            $userLogin['password'] = md5($this->getInputValue('password', 'POST', 'string', NULL, 1));
            $userLogin['user_role'] = $userRole;
            $userLogin['created_by'] = $this->user;
            $userLogin['created_dt_tm'] = $this->dateTime;
            $userLogin['updated_by'] = $this->user;
            $userLogin['updated_dt_tm'] = $this->dateTime;

            $result = $this->UserManagement_model->addUser($userInfo, $userLogin);
            redirect('UserManagement/newUser?response=' . $result);
        } else {
            redirect('UserManagement/newUser?response=2');
        }
    }

    public function showUserDetails() {
        $this->userRoleAuthentication(USER);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Updated done";
            $this->data['msgFlag'] = "success";
        }

        $userId = $this->getInputValue('userId', 'GET', 'string', 30, 1);
        $this->data['userDetails'] = $this->UserManagement_model->getUser(array('userId' => $userId));
        $this->data['currentPageCode'] = USER;
        $this->data['pageHeading'] = 'User Details';
        $this->data['pageUrl'] = 'userManagement/userDetailsView';
        $this->loadView($this->data);
    }

    public function showUserEdit() {
        $userId = $this->getInputValue('userId', 'GET', 'string', 30, 1);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Updated successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate user";
            $this->data['msgFlag'] = "danger";
        }
        $arr['isActive'] = 1;
        $this->data['userRoles'] = $this->UserManagement_model->getUserRole($arr);
        $this->data['userDetails'] = $this->UserManagement_model->getUser(array('userId' => $userId));
        if ($this->data['userDetails']) {
            $this->data['currentPageCode'] = USER;
            $this->data['pageHeading'] = 'Edit User Details';
            $this->data['pageUrl'] = 'userManagement/editUserView';
            $this->loadView($this->data);
        } else {
            redirect('UserManagement/user');
        }
    }

    public function editUser() {
        $this->userRoleAuthentication(USER);
        $userId = $this->getInputValue('userId', 'POST', 'string', 30, 1);
        $fullName = $this->getInputValue('fullName', 'POST', 'string', 200, 1);
        $mobileNo = $this->getInputValue('mobile', 'POST', 'string', 30, 1);
        $email = $this->getInputValue('email', 'POST', 'email', 100, 0);
        $userRole = $this->getInputValue('userRole', 'POST', 'string', 100, 1);

        $userInfo['full_name'] = $fullName;
        $userInfo['email'] = $email;
        $userInfo['mobile_no'] = $mobileNo;
        $userInfo['updated_by'] = $this->user;
        $userInfo['updated_dt_tm'] = $this->dateTime;

        $userLogin['user_role'] = $userRole;
        $userLogin['username'] = $mobileNo;
        $userLogin['updated_by'] = $this->user;
        $userLogin['updated_dt_tm'] = $this->dateTime;

        $result = $this->UserManagement_model->editUser($userInfo, $userLogin, $userId);
        redirect('UserManagement/showUserEdit?userId=' . $userId . '&response=' . $result);
    }

    public function statusChange() {
        $this->userRoleAuthentication(USER);
        $userId = $this->getInputValue('userId', 'POST', 'string', 30, 1);
        if ($userId == $this->user) {
            echo 2;
            exit();
        }
        $userDetails = $this->UserManagement_model->getUser(array('userId' => $userId));
        if ($userDetails) {
            if ($userDetails[0]['is_active'] == 1) {  // do inactive
                $userInfo['is_active'] = 0;
                $userLogin['is_active'] = 0;
            } else if ($userDetails[0]['is_active'] == 0) {  // do active
                $userInfo['is_active'] = 1;
                $userLogin['is_active'] = 1;
            }

            $userInfo['updated_by'] = $this->user;
            $userInfo['updated_dt_tm'] = $this->dateTime;

            $userLogin['updated_by'] = $this->user;
            $userLogin['updated_dt_tm'] = $this->dateTime;

            $response = $this->UserManagement_model->statusChange($userInfo, $userLogin, $userId);
            echo $response;
        }
    }

    public function userRole() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
//        if ($response == 1) {
//            $this->data['msg'] = "Successfully deleted";
//            $this->data['msgFlag'] = "success";
//        }
        $this->data['currentPageCode'] = USER_ROLE_PAGE;
        $this->data['pageHeading'] = 'User Role';
        $this->data['pageUrl'] = 'userManagement/userRoleView';
        $this->loadView($this->data);
    }

    public function getUserRole() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);


        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->UserManagement_model->getUserRoleForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function newUserRole() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully create a user role";
            $this->data['msgFlag'] = "success";
        }

//        echo "<pre>";
//        print_r(getLeftMenu());
//        exit();

        $this->data['currentPageCode'] = USER_ROLE_PAGE;
        $this->data['pageHeading'] = 'New User Role';
        $this->data['pageUrl'] = 'userManagement/addUserRoleView';
        $this->loadView($this->data);
    }

    public function userRoleTitleDuplicateCheck() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);
        $arr['roleCode'] = $this->getInputValue('roleCode', 'POST', 'string', NULL, 0);
        $arr['userRoleTitle'] = $this->getInputValue('userRoleTitle', 'POST', 'string', 100, 1);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'string', NULL, 1);
        $result = $this->UserManagement_model->userRoleTitleDuplicateCheck($arr);
        echo $result;
    }

    public function addUserRole() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);
        $userRoleInsertArr['role_title'] = $this->getInputValue('userRoleTitle', 'POST', 'string', 100, 1);
        $menuListCheckBoxCount = $this->getInputValue('menuListCheckBoxCount', 'POST', 'int', NULL, 1);
        $pageCodeArr = array();
        for ($i = 1; $i < $menuListCheckBoxCount; $i++) {
            $pageCode = $this->input->post('menuListCheckbox' . $i, true);
            if ($pageCode) {
                $pageCodeArr[] = $pageCode;
            }
        }

        $actionCheckBoxCount = $this->getInputValue('actionCheckBoxCount', 'POST', 'int', NULL, 1);
        $actionCodeArr = array();
        for ($i = 1; $i < $actionCheckBoxCount; $i++) {
            $actionCode = $this->input->post('actionCodeCheckBox' . $i, true);
            if ($actionCode) {
                $actionCodeArr[] = $actionCode;
                if ($actionCode == '03') {
                    $pageCodeArr[] = '17';
                } else if ($actionCode == '04') {
                    $pageCodeArr[] = '18';
                }
            }
        }

        $userRoleInsertArr['permitted_page_code'] = ($pageCodeArr) ? implode(',', $pageCodeArr) : NULL;
        $userRoleInsertArr['permitted_action_code'] = ($actionCodeArr) ? implode(',', $actionCodeArr) : NULL;
        $userRoleInsertArr['created_by'] = $this->user;
        $userRoleInsertArr['created_dt_tm'] = $this->dateTime;
        $userRoleInsertArr['updated_by'] = $this->user;
        $userRoleInsertArr['updated_dt_tm'] = $this->dateTime;
        $result = $this->UserManagement_model->addUserRole($userRoleInsertArr);
        redirect('UserManagement/newUserRole?response=' . $result);
//        echo "<pre>";
//        print_r($pageCodeArr);
//        print_r($actionCodeArr);
    }

    public function showEditUserRole() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);
        $roleCode = $this->getInputValue('roleCode', 'GET', 'string', 30, 1);
        $arr['isActive'] = 1;
        $arr['roleCode'] = $roleCode;
        $this->data['userRoleDetails'] = $this->UserManagement_model->getUserRole($arr);
        if ($this->data['userRoleDetails']) {
            $response = (int) $this->input->get('response', true);
            $this->data['msgFlag'] = "";
            if ($response == 1) {
                $this->data['msg'] = "Successfully edited user role";
                $this->data['msgFlag'] = "success";
            }

//            echo "<pre>";
//            print_r($this->data['userRoleDetails']);
//            exit();

            $this->data['currentPageCode'] = USER_ROLE_PAGE;
            $this->data['pageHeading'] = 'Edit User Role';
            $this->data['pageUrl'] = 'userManagement/editUserRoleView';
            $this->loadView($this->data);
        } else {
            redirect('UserManagement/userRole');
        }
    }

    public function editUserRole() {
        $this->userRoleAuthentication(USER_ROLE_PAGE);
        $roleCode = $this->getInputValue('roleCode', 'POST', 'string', 30, 1);
        $userRoleUpdatetArr['role_title'] = $this->getInputValue('userRoleTitle', 'POST', 'string', 100, 1);
        $menuListCheckBoxCount = $this->getInputValue('menuListCheckBoxCount', 'POST', 'int', NULL, 1);
        $pageCodeArr = array();
        for ($i = 1; $i < $menuListCheckBoxCount; $i++) {
            $pageCode = $this->input->post('menuListCheckbox' . $i, true);
            if ($pageCode) {
                $pageCodeArr[] = $pageCode;
            }
        }

        $actionCheckBoxCount = $this->getInputValue('actionCheckBoxCount', 'POST', 'int', NULL, 1);
        $actionCodeArr = array();
        for ($i = 1; $i < $actionCheckBoxCount; $i++) {
            $actionCode = $this->input->post('actionCodeCheckBox' . $i, true);
            if ($actionCode) {
                $actionCodeArr[] = $actionCode;
                if ($actionCode == '03') {
                    $pageCodeArr[] = '17';
                } else if ($actionCode == '04') {
                    $pageCodeArr[] = '18';
                }
            }
        }

        $userRoleUpdatetArr['permitted_page_code'] = ($pageCodeArr) ? implode(',', $pageCodeArr) : NULL;
        $userRoleUpdatetArr['permitted_action_code'] = ($actionCodeArr) ? implode(',', $actionCodeArr) : NULL;
        $userRoleUpdatetArr['updated_by'] = $this->user;
        $userRoleUpdatetArr['updated_dt_tm'] = $this->dateTime;

//        echo "<pre>";
//        print_r($userRoleUpdatetArr);
//        exit();

        $result = $this->UserManagement_model->editUserRole($userRoleUpdatetArr, $roleCode);
        redirect('UserManagement/showEditUserRole?response=' . $result . '&roleCode=' . $roleCode);
    }

}
