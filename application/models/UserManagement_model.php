<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UserManagement_model extends CI_Model {

    function getUser($arr = array()) {
        $this->db->select('user_login.user_id,user_login.username,user_login.user_role,user_login.is_active,
                user_role.role_title,user_info.full_name,user_info.email,user_info.mobile_no,user_info.address,user_info.profile_image');
        $this->db->from('user_login');
        $this->db->join('user_role', 'user_role.role_code = user_login.user_role', 'left');
        $this->db->join('user_info', 'user_info.user_id = user_login.user_id');
        if ($arr['userId']) {
            $this->db->where('user_login.user_id', $arr['userId']);
        }
        if ($arr['isActive']) {
            $this->db->where('user_login.is_active', $arr['isActive']);
        }
        $this->db->order_by('user_login.created_dt_tm', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getUserRole($arr) {
        //$this->db->select('role_code,role_title,permitted_page_code');
        if ($arr['isActive']) {
            $this->db->where('is_active', $arr['isActive']);
        }
        if (isset($arr['roleCode'])) {
            $this->db->where('role_code', $arr['roleCode']);
        }
        $query = $this->db->get('user_role');
        return $query->result_array();
    }

    function userDuplicateCheck($arr) {
        if ($arr['addEditFlag'] == 'edit') {
            $this->db->where_not_in('user_id', $arr['userId']);
        }
        $this->db->where('mobile_no', $arr['mobileNo']);
        $query = $this->db->get('user_info');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addUser($userInfo, $userLogin) {
        $arr['mobileNo'] = $userInfo['mobile_no'];
        $duplicateFlag = $this->userDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $this->db->insert('user_info', $userInfo);
        $this->db->insert('user_login', $userLogin);

        return 1;
    }

    function editUser($userInfo, $userLogin, $userId) {
        $arr['userId'] = $userId;
        $arr['mobileNo'] = $userInfo['mobile_no'];
        $arr['addEditFlag'] = 'edit';
        $duplicateFlag = $this->userDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }

        $this->db->where_not_in('user_id', $userId);
        $this->db->where('username', $userInfo['mobile_no']);
        $query = $this->db->get('user_login');
        if ($query->num_rows() > 0) {
            return 3;
        }

        $this->db->where('user_id', $userId);
        $this->db->update('user_info', $userInfo);

        $this->db->where('user_id', $userId);
        $this->db->update('user_login', $userLogin);
        return 1;
    }

    function statusChange($userInfo, $userLogin, $userId) {
        $this->db->where('user_id', $userId);
        $this->db->update('user_info', $userInfo);

        $this->db->where('user_id', $userId);
        $this->db->update('user_login', $userLogin);
        return 1;
    }

    function getUserRoleForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $this->db->where('is_active', 1);
        $query = $this->db->get('user_role');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->like('is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('role_code', $searchValue);
            $this->db->or_like('role_title', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }

        $query = $this->db->get('user_role');
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array('serial' => $i,
                'role_code' => $record['role_code'],
                'role_title' => $record['role_title']);
            $i++;
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $response;
    }

    function userRoleTitleDuplicateCheck($arr) {
        if ($arr['addEditFlag'] == 'edit') {
            $this->db->where_not_in('role_code', $arr['roleCode']);
        }
        $this->db->where('role_title', $arr['userRoleTitle']);
        $this->db->where('is_active', 1);
        $query = $this->db->get('user_role');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addUserRole($userRoleInsertArr) {
        $arr['userRoleTitle'] = $userRoleInsertArr['role_title'];
        $arr['addEditFlag'] = 'add';
        $duplicateFlag = $this->userRoleTitleDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $userRoleInsertArr['role_code'] = getCode(USER_ROLE_CODE);
        $this->db->insert('user_role', $userRoleInsertArr);

        return 1;
    }

    function editUserRole($userRoleUpdatetArr, $roleCode) {
        $arr['userRoleTitle'] = $userRoleUpdatetArr['role_title'];
        $arr['roleCode'] = $roleCode;
        $arr['addEditFlag'] = 'edit';
        $duplicateFlag = $this->userRoleTitleDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $this->db->where('role_code', $roleCode);
        $this->db->update('user_role', $userRoleUpdatetArr);

        return 1;
    }

}
