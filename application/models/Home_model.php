<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    function changePassword($oldPassword, $userLogin) {
        $this->db->where('user_id', $this->user);
        $this->db->where('password', md5($oldPassword));
        $query = $this->db->get('user_login');
        if ($query->num_rows() == 0) {
            return 2;
        }

        $this->db->where('user_id', $this->user);
        $this->db->update('user_login', $userLogin);
        return 1;
    }

}
