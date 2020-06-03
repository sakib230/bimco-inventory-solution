<?php

function getLeftMenuForUserRole() {
    $menuArr[] = array(
        'levelOneHeading' => 'User Management',
        'levelOneIcon' => 'fa fa-users',
        'levelTwoLi' => array(USER, USER_ROLE_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => USER, 'levelTwoHeading' => 'User', 'levelTwoUrl' => 'UserManagement/user'),
            array('levelTwoCode' => USER_ROLE_PAGE, 'levelTwoHeading' => 'User Role', 'levelTwoUrl' => 'UserManagement/userRole')
        )
    );

    $menuArr[] = array(
        'levelOneHeading' => 'Accounts',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(VENDOR_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => VENDOR_PAGE, 'levelTwoHeading' => 'Vendor', 'levelTwoUrl' => 'Contacts/vendor')
        )
    );

    $menuArr[] = array(
        'levelOneHeading' => 'Raw Product',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(RAW_CATEGORY_PAGE, RAW_PRODUCT_PAGE, RAW_STOCK_ENTRY_PAGE, RAW_RETURN_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => RAW_CATEGORY_PAGE, 'levelTwoHeading' => 'Product Category', 'levelTwoUrl' => 'RawProduct/category'),
            array('levelTwoCode' => RAW_PRODUCT_PAGE, 'levelTwoHeading' => 'Product', 'levelTwoUrl' => 'RawProduct/product'),
            array('levelTwoCode' => RAW_STOCK_ENTRY_PAGE, 'levelTwoHeading' => 'Stock Entry', 'levelTwoUrl' => 'RawProduct/stockEntry', 'action' => array('Stock Add' => RAW_STOCK_ADD, 'Stock Check' => RAW_STOCK_CHECKED, 'Stock Approve' => RAW_STOCK_APPRV)),
            array('levelTwoCode' => RAW_RETURN_PAGE, 'levelTwoHeading' => 'Raw Return', 'levelTwoUrl' => 'RawProduct/rawReturn', 'action' => array('Raw Return Add' => RAW_RETURN_ADD, 'Raw Return Check' => RAW_RETURN_CHECKED, 'Raw Return Approve' => RAW_RETURN_APPRV))
        )
    );
    $menuArr[] = array(
        'levelOneHeading' => 'Finish Goods',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(FINISH_CATEGORY_PAGE, FINISH_PRODUCT_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => FINISH_CATEGORY_PAGE, 'levelTwoHeading' => 'Product Category', 'levelTwoUrl' => 'FinishGood/category'),
            array('levelTwoCode' => FINISH_PRODUCT_PAGE, 'levelTwoHeading' => 'Product', 'levelTwoUrl' => 'FinishGood/product')
        )
    );
    $menuArr[] = array(
        'levelOneHeading' => 'Formulation',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(PRODUCT_FURMULATION_PAGE, MIXING_RAW_MATERIAL_PAGE, EXTRA_RAW_LIFTING_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => PRODUCT_FURMULATION_PAGE, 'levelTwoHeading' => 'Product Formulation', 'levelTwoUrl' => 'Formulation/productFormulation', 'action' => array('Formulation Add' => FORMULA_ADD, 'Formulation Edit' => FORMULA_EDIT, 'Formulation Check' => FORMULA_CHECKED, 'Formulation Approve' => FORMULA_APPRV, 'Formulation Approve Unlock' => FORMULA_APPRV_UNLOCK, 'Formulation Rate' => FORMULA_RATE, 'Formulation Active & Inactive' => FORMULA_ACTIVE_INACTIVE)),
            array('levelTwoCode' => MIXING_RAW_MATERIAL_PAGE, 'levelTwoHeading' => 'Mixing Raw Material', 'levelTwoUrl' => 'Formulation/mixingRawMaterial', 'action' => array('Mixing Add' => MIXING_ADD, 'Mixing Edit' => MIXING_EDIT, 'Mixing Check' => MIXING_CHECKED, 'Mixing Approve' => MIXING_APPRV, 'Mixing Approve Unlock' => MIXING_APPRV_UNLOCK)),
            array('levelTwoCode' => EXTRA_RAW_LIFTING_PAGE, 'levelTwoHeading' => 'Extra Raw Lifting', 'levelTwoUrl' => 'Formulation/extraRawLifting', 'action' => array('Extra Raw Lifting Add' => RAW_LIFTING_ADD, 'Extra Raw Lifting Edit' => RAW_LIFTING_EDIT, 'Extra Raw Lifting Check' => RAW_LIFTING_CHECKED, 'Extra Raw Lifting Approve' => RAW_LIFTING_APPRV, 'Extra Raw Lifting Approve Unlock' => RAW_LIFTING_APPRV_UNLOCK))
        )
    );

    $menuArr[] = array(
        'levelOneHeading' => 'Reports',
        'levelOneIcon' => 'fa fa-file-text-o',
        'levelTwoLi' => array(RAW_STOCK_REPORT_PAGE,REPORT_RAW_STOCK, REPORT_RAW_STOCK_IN_OUT),
        'levelTwo' => array(
            array('levelTwoCode' => RAW_STOCK_REPORT_PAGE, 'levelTwoHeading' => 'Stock Report', 'levelTwoUrl' => 'Reports/stockReport'),
            array('levelTwoCode' => REPORT_RAW_STOCK, 'levelTwoHeading' => 'Raw Product Stock', 'levelTwoUrl' => 'Reports/rawProductStock', 'action' => array('Show Rate' => REPORT_RAW_RATE)),
            array('levelTwoCode' => REPORT_RAW_STOCK_IN_OUT, 'levelTwoHeading' => 'Stock In & Out Report', 'levelTwoUrl' => 'Reports/rawProductStockInOut')
        )
    );
    return $menuArr;
}

function getLeftMenu() {
    $menuArr[] = array(
        'levelOneHeading' => 'User Management',
        'levelOneIcon' => 'fa fa-users',
        'levelTwoLi' => array(USER, USER_ROLE_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => USER, 'levelTwoHeading' => 'User', 'levelTwoUrl' => 'UserManagement/user'),
            array('levelTwoCode' => USER_ROLE_PAGE, 'levelTwoHeading' => 'User Role', 'levelTwoUrl' => 'UserManagement/userRole')
        )
    );

    $menuArr[] = array(
        'levelOneHeading' => 'Accounts',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(VENDOR_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => VENDOR_PAGE, 'levelTwoHeading' => 'Vendor', 'levelTwoUrl' => 'Contacts/vendor')
        )
    );

    $menuArr[] = array(
        'levelOneHeading' => 'Raw Product',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(RAW_CATEGORY_PAGE, RAW_PRODUCT_PAGE, RAW_STOCK_ENTRY_PAGE, RAW_RETURN_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => RAW_CATEGORY_PAGE, 'levelTwoHeading' => 'Product Category', 'levelTwoUrl' => 'RawProduct/category'),
            array('levelTwoCode' => RAW_PRODUCT_PAGE, 'levelTwoHeading' => 'Product', 'levelTwoUrl' => 'RawProduct/product'),
            array('levelTwoCode' => RAW_STOCK_ENTRY_PAGE, 'levelTwoHeading' => 'Stock Entry', 'levelTwoUrl' => 'RawProduct/stockEntry', 'action' => array('Stock Add' => RAW_STOCK_ADD, 'Stock Check' => RAW_STOCK_CHECKED, 'Stock Approve' => RAW_STOCK_APPRV)),
            array('levelTwoCode' => RAW_STOCK_CHECK_PAGE, 'levelTwoHeading' => 'Stock Check', 'levelTwoUrl' => 'RawProduct/stockEntryCheck'),
            array('levelTwoCode' => RAW_STOCK_APPROVE_PAGE, 'levelTwoHeading' => 'Stock Approve', 'levelTwoUrl' => 'RawProduct/stockEntryApprove'),
            array('levelTwoCode' => RAW_RETURN_PAGE, 'levelTwoHeading' => 'Raw Return', 'levelTwoUrl' => 'RawProduct/rawReturn', 'action' => array('Raw Return Add' => RAW_RETURN_ADD, 'Raw Return Check' => RAW_RETURN_CHECKED, 'Raw Return Approve' => RAW_RETURN_APPRV))
        )
    );
    $menuArr[] = array(
        'levelOneHeading' => 'Finish Goods',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(FINISH_CATEGORY_PAGE, FINISH_PRODUCT_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => FINISH_CATEGORY_PAGE, 'levelTwoHeading' => 'Product Category', 'levelTwoUrl' => 'FinishGood/category'),
            array('levelTwoCode' => FINISH_PRODUCT_PAGE, 'levelTwoHeading' => 'Product', 'levelTwoUrl' => 'FinishGood/product')
        )
    );
    $menuArr[] = array(
        'levelOneHeading' => 'Formulation',
        'levelOneIcon' => 'fa fa-user',
        'levelTwoLi' => array(PRODUCT_FURMULATION_PAGE, MIXING_RAW_MATERIAL_PAGE, EXTRA_RAW_LIFTING_PAGE),
        'levelTwo' => array(
            array('levelTwoCode' => PRODUCT_FURMULATION_PAGE, 'levelTwoHeading' => 'Product Formulation', 'levelTwoUrl' => 'Formulation/productFormulation', 'action' => array('Formulation Add' => FORMULA_ADD, 'Formulation Edit' => FORMULA_EDIT, 'Formulation Check' => FORMULA_CHECKED, 'Formulation Approve' => FORMULA_APPRV, 'Formulation Approve Unlock' => FORMULA_APPRV_UNLOCK, 'Formulation Rate' => FORMULA_RATE, 'Formulation Active & Inactive' => FORMULA_ACTIVE_INACTIVE)),
            array('levelTwoCode' => MIXING_RAW_MATERIAL_PAGE, 'levelTwoHeading' => 'Mixing Raw Material', 'levelTwoUrl' => 'Formulation/mixingRawMaterial', 'action' => array('Mixing Add' => MIXING_ADD, 'Mixing Edit' => MIXING_EDIT, 'Mixing Check' => MIXING_CHECKED, 'Mixing Approve' => MIXING_APPRV, 'Mixing Approve Unlock' => MIXING_APPRV_UNLOCK)),
            array('levelTwoCode' => EXTRA_RAW_LIFTING_PAGE, 'levelTwoHeading' => 'Extra Raw Lifting', 'levelTwoUrl' => 'Formulation/extraRawLifting', 'action' => array('Extra Raw Lifting Add' => RAW_LIFTING_ADD, 'Extra Raw Lifting Edit' => RAW_LIFTING_EDIT, 'Extra Raw Lifting Check' => RAW_LIFTING_CHECKED, 'Extra Raw Lifting Approve' => RAW_LIFTING_APPRV, 'Extra Raw Lifting Approve Unlock' => RAW_LIFTING_APPRV_UNLOCK))
        )
    );

    $menuArr[] = array(
        'levelOneHeading' => 'Reports',
        'levelOneIcon' => 'fa fa-file-text-o',
        'levelTwoLi' => array(RAW_STOCK_REPORT_PAGE,REPORT_RAW_STOCK, REPORT_RAW_STOCK_IN_OUT),
        'levelTwo' => array(
            array('levelTwoCode' => RAW_STOCK_REPORT_PAGE, 'levelTwoHeading' => 'Stock Report', 'levelTwoUrl' => 'Reports/stockReport'),
            array('levelTwoCode' => REPORT_RAW_STOCK, 'levelTwoHeading' => 'Raw Product Stock', 'levelTwoUrl' => 'Reports/rawProductStock', 'action' => array('Show Rate' => REPORT_RAW_RATE)),
            array('levelTwoCode' => REPORT_RAW_STOCK_IN_OUT, 'levelTwoHeading' => 'Stock In & Out Report', 'levelTwoUrl' => 'Reports/rawProductStockInOut')
        )
    );
    return $menuArr;
}

//function getCode($code = null) {
//    $CI = & get_instance();
//    $CI->load->database();
//    $tokenno = "0";
//    $query = $CI->db->get_where('code_table', array('element_code' => $code));
//    $row_array = $query->row_array();
//    $expMonth = date('Y-m', strtotime($row_array['serial_date']));
//    $todaysMonth = date('Y-m');
//    $todayMonth = strtotime($todaysMonth);
//
//    $expirationMonth = strtotime($expMonth);
//    if ($todayMonth > $expirationMonth) {
//        $qry = "UPDATE code_table SET serial_date='" . date('Y-m-d') . "',serial_no='0001' WHERE element_code='" . $code . "'";
//        $res1 = $CI->db->query($qry);
//        $tokenno = '0001';
//    } else {
//        $qry = "UPDATE code_table SET serial_date='" . date('Y-m-d') . "', serial_no='" . str_pad($row_array['serial_no'] + 1, 4, "0", STR_PAD_LEFT) . "' WHERE element_code='" . $code . "'";
//        $res1 = $CI->db->query($qry);
//        $tokenno = str_pad($row_array['serial_no'] + 1, 4, "0", STR_PAD_LEFT);
//    }
//    return date('my') . $tokenno;
//}
function getCode($code = null) {
    $CI = & get_instance();
    $CI->load->database();

    $CI->db->where('element_code', $code);
    $query = $CI->db->get('code_table');
    $row = $query->row();
    $tokenno = $row->serial_no + 1;

    $updateArr['serial_no'] = $tokenno;

    $CI->db->where('element_code', $code);
    $CI->db->update('code_table', $updateArr);
    return $tokenno;
}

function reference_no() {
    return uniqid("bm", false);
}

function getStockSummaryStatusName($status) {
    $statusName = "";
    if ($status == STOCK_ENTRY_PENDING) {
        $statusName = "Pending";
    } elseif ($status == STOCK_ENTRY_CHECKED) {
        $statusName = "Checked";
    } elseif ($status == STOCK_ENTRY_APPROVED) {
        $statusName = "Approved";
    } elseif ($status == STOCK_ENTRY_REJECTED) {
        $statusName = "Rejected";
    }
    return $statusName;
}

function getFormulaStatusName($status) {
    $statusName = "";
    if ($status == FORMULA_ENTRY_PENDING) {
        $statusName = "Pending";
    } elseif ($status == FORMULA_ENTRY_CHECKED) {
        $statusName = "Checked";
    } elseif ($status == FORMULA_ENTRY_APPROVED) {
        $statusName = "Approved";
    } elseif ($status == FORMULA_ENTRY_REJECTED) {
        $statusName = "Rejected";
    }
    return $statusName;
}

function getMixingStatusName($status) {
    $statusName = "";
    if ($status == MIXING_STATUS_PENDING) {
        $statusName = "Pending";
    } elseif ($status == MIXING_STATUS_CHECKED) {
        $statusName = "Checked";
    } elseif ($status == MIXING_STATUS_APPROVED) {
        $statusName = "Approved";
    } elseif ($status == MIXING_STATUS_REJECTED) {
        $statusName = "Rejected";
    }
    return $statusName;
}

function getLiftingStatusName($status) {
    $statusName = "";
    if ($status == LIFTING_STATUS_PENDING) {
        $statusName = "Pending";
    } elseif ($status == LIFTING_STATUS_CHECKED) {
        $statusName = "Checked";
    } elseif ($status == LIFTING_STATUS_APPROVED) {
        $statusName = "Approved";
    } elseif ($status == LIFTING_STATUS_REJECTED) {
        $statusName = "Rejected";
    }

    return $statusName;
}

function checkPermittedAction($actionCode = NULL) {
    $CI = & get_instance();
    $permittedActionCodeArr = explode(',', $CI->session->userdata('permittedActionCode'));

    if (!in_array($actionCode, $permittedActionCodeArr)) {
        return 0;
    }
    return 1;
}

function getFormulaActiveName($multiFormulaActiveFlag) {
    $name = '';
    if ($multiFormulaActiveFlag == 1) {
        $name = "<span class='text-success'>Active</span>";
    } else if ($multiFormulaActiveFlag == 0) {
        $name = "<span class='text-danger'>Inactive</span>";
    }
    return $name;
}
