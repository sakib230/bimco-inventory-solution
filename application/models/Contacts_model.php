<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contacts_model extends CI_Model {

    function getVendor($arr = array()) {
        $this->db->select('contact.*');
        $this->db->from('contact');
        if (isset($arr['vendorId'])) {
            $this->db->where('contact.contact_code', $arr['vendorId']);
        }
        if (isset($arr['isActive'])) {
            $this->db->where('contact.is_active', $arr['isActive']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function getVendorForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $query = $this->db->get('contact');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->like('is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('display_contact_id', $searchValue);
            $this->db->or_like('contact_name', $searchValue);
            $this->db->or_like('mobile_no', $searchValue);
            $this->db->or_like('email', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $query = $this->db->get('contact');
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array('serial' => $i,
                'display_contact_id' => $record['display_contact_id'],
                'contact_name' => $record['contact_name'],
                'mobile_no' => $record['mobile_no'],
                'email' => $record['email'],
                'contact_code' => $record['contact_code']);
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

    function vendorDuplicateCheck($arr) {
        if ($arr['edit']) {
            $this->db->where_not_in('contact_code', $arr['contactCode']);
        }
        $this->db->where('display_contact_id', $arr['displayContactId']);
        $this->db->where('is_active', 1);
        $query = $this->db->get('contact');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addVendor($contactInfo) {
        $arr['displayContactId'] = $contactInfo['display_contact_id'];
        $arr['addEditFlag'] = 'add';
        $duplicateFlag = $this->vendorDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $contactInfo['contact_code'] = getCode(CONTACT_CODE);
        $this->db->insert('contact', $contactInfo);
        return 1;
    }

    function editVendor($contactInfo) {
        $arr['mobileNo'] = $contactInfo['mobile_no'];
        $arr['vendorId'] = $contactInfo['contact_code'];
        $arr['addEditFlag'] = 'edit';
        $duplicateFlag = $this->vendorDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $this->db->where('contact_code', $contactInfo['contact_code']);
        $this->db->update('contact', $contactInfo);

        return 1;
    }

    function deleteVendor($contactInfo, $vendorId) {
        $this->db->where('contact_code', $vendorId);
        $this->db->update('contact', $contactInfo);
        return 1;
    }

}
