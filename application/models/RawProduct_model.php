<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RawProduct_model extends CI_Model {

    function getCategory($arr = array()) {
        $this->db->select('raw_category.*');
        $this->db->from('raw_category');
        if ($arr['categoryCode']) {
            $this->db->where('raw_category.category_code', $arr['categoryCode']);
        }
        if (isset($arr['isActive'])) {
            $this->db->where('raw_category.is_active', $arr['isActive']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCategoryForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $this->db->where('is_active', 1);
        $query = $this->db->get('raw_category');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->like('is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('category_code', $searchValue);
            $this->db->or_like('category_name', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $this->db->where('is_active', 1);
        $query = $this->db->get('raw_category');
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array('serial' => $i,
                'display_category_id' => $record['display_category_id'],
                'category_name' => $record['category_name'],
                'category_code' => $record['category_code']);
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

    function categoryDuplicateCheck($arr) {
        if ($arr['addEditFlag'] == 'edit') {
            $this->db->where_not_in('category_code', $arr['categoryCode']);
        }
        $this->db->where('display_category_id', $arr['categoryDisplayId']);
        $this->db->where('is_active', 1);
        $query = $this->db->get('raw_category');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addCategory($categoryInfo) {
        $arr['categoryDisplayId'] = $categoryInfo['display_category_id'];
        $arr['addEditFlag'] = 'add';
        $duplicateFlag = $this->categoryDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $categoryInfo['category_code'] = getCode(RAW_PRODUCT_CATEGORY_CODE);
        $this->db->insert('raw_category', $categoryInfo);

        return 1;
    }

    function editCategory($categoryInfo) {
        $arr['categoryDisplayId'] = $categoryInfo['display_category_id'];
        $arr['categoryCode'] = $categoryInfo['category_code'];
        $arr['addEditFlag'] = 'edit';
        $duplicateFlag = $this->categoryDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $this->db->where('category_code', $categoryInfo['category_code']);
        $this->db->update('raw_category', $categoryInfo);
        return 1;
    }

    function deleteCategory($categoryInfo, $categoryCode, $productInfo) {
        $this->db->where('category_code', $categoryCode);
        $this->db->update('raw_category', $categoryInfo);

        $this->db->where('category', $categoryCode);
        $this->db->update('raw_product', $productInfo);
        return 1;
    }

    function getProductForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(raw_product.id) as allcount');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('raw_product.is_active', 1);
        $this->db->where('raw_category.is_active', 1);
        $query = $this->db->get();
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('raw_product.category,raw_product.product_name,raw_product.product_code,raw_product.avg_purchase_rate,raw_product.is_active,raw_category.category_name,stock_view.current_stock_quantity');
        $this->db->from('raw_product');
        $this->db->join('stock_view', 'stock_view.product = raw_product.product_code', 'left');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->like('raw_product.is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('raw_product.product_code', $searchValue);
            $this->db->or_like('raw_product.product_name', $searchValue);
            $this->db->or_like('raw_product.avg_purchase_rate', $searchValue);
            $this->db->or_like('raw_category.category_name', $searchValue);
        }
        if ($columnName != 'serial') {
            if ($columnName == 'category') {
                $columnName = 'raw_category.' . $columnName;
            } elseif ($columnName == 'product_code') {
                $columnName = 'raw_product.' . $columnName;
            } elseif ($columnName == 'product_name') {
                $columnName = 'raw_product.' . $columnName;
            } elseif ($columnName == 'avg_pur_rate') {
                $columnName = 'raw_product.' . $columnName;
            } elseif ($columnName == 'current_stock_quantity') {
                $columnName = 'stock_view.' . $columnName;
            }
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array('serial' => $i,
                'category' => $record['category_name'],
                'product_code' => $record['product_code'],
                'product_name' => $record['product_name'],
                'current_stock_quantity' => $record['current_stock_quantity'],
                'avg_pur_rate' => $record['avg_purchase_rate']);
            $i++;
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($data), //$totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $response;
    }

    function productDuplicateCheck($arr) {
        if ($arr['addEditFlag'] == 'edit') {
            $this->db->where_not_in('product_code', $arr['productCode']);
        }
        $this->db->where('product_name', $arr['productName']);
        $this->db->where('is_active', 1);
        $query = $this->db->get('raw_product');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addProduct($productInfo) {
        $arr['productName'] = $productInfo['product_name'];
        $arr['addEditFlag'] = 'add';
        $duplicateFlag = $this->productDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $productInfo['product_code'] = getCode(RAW_PRODUCT_CODE);
        $this->db->insert('raw_product', $productInfo);

        return 1;
    }

    function getProduct($arr = array()) {
        $this->db->select('raw_product.category,raw_product.product_name,raw_product.product_code,raw_product.avg_purchase_rate,raw_category.category_name');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('raw_product.is_active', 1);
        $this->db->where('raw_category.is_active', 1);
        if ($arr['productCode']) {
            $this->db->where('raw_product.product_code', $arr['productCode']);
        }
        if (isset($arr['isActive'])) {
            $this->db->where('raw_product.is_active', $arr['isActive']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function editProduct($productInfo) {
        $arr['productName'] = $productInfo['product_name'];
        $arr['productCode'] = $productInfo['product_code'];
        $arr['addEditFlag'] = 'edit';
        $duplicateFlag = $this->productDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $this->db->where('product_code', $productInfo['product_code']);
        $this->db->update('raw_product', $productInfo);
        return 1;
    }

    function deleteProduct($productInfo, $productCode) {
        $this->db->where('product_code', $productCode);
        $this->db->update('raw_product', $productInfo);
        return 1;
    }

    function getProductForStockEntry($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(raw_product.id) as allcount');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('raw_product.is_active', 1);
        $this->db->where('raw_category.is_active', 1);
        $query = $this->db->get();
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('raw_product.category,raw_product.product_name,raw_product.product_code,raw_product.avg_purchase_rate,raw_product.is_active,raw_category.category_name');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->like('raw_product.is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('raw_product.product_code', $searchValue);
            $this->db->or_like('raw_product.product_name', $searchValue);
            $this->db->or_like('raw_product.avg_purchase_rate', $searchValue);
            $this->db->or_like('raw_category.category_name', $searchValue);
        }
        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array(
                'product_details' => '<span class="td-f-l"><i class="fa fa-link"></i> <b class="template-green">' . $record['product_code'] . '</b><br><i class="fa fa-bars"></i> ' . $record['product_name'] . '<br><i class="fa fa-list"></i> <i><small>' . $record['category_name'] . '</small></i></span>',
                'product_title' => $record['product_name'] . ' (' . $record['product_code'] . ')',
                'product_code' => $record['product_code'],
                'avg_purchase_rate' => $record['avg_purchase_rate']
            );
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($data), //$totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $response;
    }

    function getVendorForStockEntry($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $this->db->where('is_active', 1);
        $query = $this->db->get('contact');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->like('is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('contact_code', $searchValue);
            $this->db->or_like('contact_name', $searchValue);
            $this->db->or_like('mobile_no', $searchValue);
        }
        $query = $this->db->get('contact');
        $records = $query->result_array();

        $data = array();
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array(
                'vendor_details' => '<span class="td-f-l"><i class="fa fa-link"></i> <b class="template-green">' . $record['display_contact_id'] . '</b><br><i class="fa fa-user"></i> ' . $record['contact_name'] . '<br><i class="fa fa-phone"></i> <i><small>' . $record['mobile_no'] . '</small></i></span>',
                'vendor_title' => $record['contact_name'] . ' (' . $record['contact_code'] . ')',
                'vendor_code' => $record['contact_code']
            );
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($data), //$totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $response;
    }

    function addRawProductStock($stockSummary, $stockDetails) {
        $this->db->insert('stock_summary', $stockSummary);
        if ($stockDetails) {
            $this->db->insert_batch('stock_details', $stockDetails);
        }
        return 1;
    }

    function getStockEntryDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        $permittedActionCodeArr = explode(',', $this->session->userdata('permittedActionCode'));
        $isActive = "";
//        if (in_array(RAW_STOCK_ADD, $permittedActionCodeArr)) {
//            $isActiveArr[] = STOCK_ENTRY_APPROVED;
//            $isActiveArr[] = STOCK_ENTRY_REJECTED;
//            $isActiveArr[] = STOCK_ENTRY_PENDING;
//            $isActiveArr[] = STOCK_ENTRY_CHECKED;
//        }
        if (in_array(RAW_STOCK_CHECKED, $permittedActionCodeArr) && in_array(RAW_STOCK_APPRV, $permittedActionCodeArr)) {
            $isActive = "";
        } else if (in_array(RAW_STOCK_CHECKED, $permittedActionCodeArr)) {
            $isActive = STOCK_ENTRY_PENDING;
        } else if (in_array(RAW_STOCK_APPRV, $permittedActionCodeArr)) {
            $isActive = STOCK_ENTRY_CHECKED;
        }

        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $this->db->where('stock_type', STOCK_IN);
        if ($isActive) {
            $this->db->where('is_active', $isActive);
        }
        $query = $this->db->get('stock_summary');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->like('stock_type', STOCK_IN, 'none');
//        if ($isActive != NULL) {
//            $this->db->like('is_active', $isActive, 'none');
//        }
        if ($searchValue != '') {
            $this->db->like('stock_code', $searchValue);
            $this->db->or_like('stock_date', $searchValue);
            $this->db->or_like('total_amount', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $this->db->order_by('stock_summary.created_dt_tm', 'DESC');
        $query = $this->db->get('stock_summary');
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
            $statusName = getStockSummaryStatusName($record['is_active']);
            $data[] = array('serial' => $i,
                'stock_date' => $record['stock_date'],
                'stock_code' => $record['stock_code'],
                'total_amount' => $record['total_amount'],
                'status_name' => $statusName);
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

    function getStockInSummary($stockCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->where('stock_type', STOCK_IN);
        $query = $this->db->get('stock_summary');
        return $query->result_array();
    }

    function getStockInDetails($stockCode) {
        $this->db->select('stock_details.*,raw_product.product_name,raw_product.avg_purchase_rate ,contact.contact_name as vendor_name');
        $this->db->from('stock_details');
        $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
        $this->db->join('contact', 'contact.contact_code = stock_details.vendor');
        $this->db->where('stock_details.stock_code', $stockCode);
        $this->db->where('stock_details.stock_type', STOCK_IN);
//        $this->db->where('stock_details.is_raw_return', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    function editRawProductStock($stockSummary, $stockDetails, $stockCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->delete('stock_summary');

        $this->db->where('stock_code', $stockCode);
        $this->db->delete('stock_details');

        $this->db->insert('stock_summary', $stockSummary);
        if ($stockDetails) {
            $this->db->insert_batch('stock_details', $stockDetails);
        }
        return 1;
    }

    function stockEntryChecked($stockSummaryArr, $stockDetailsArr, $stockCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function stockEntryApproved($stockSummaryArr, $stockDetailsArr, $stockCode) {
        $this->db->select('stock_details.product,stock_details.rate,stock_details.stock_in_quantity,
                raw_product.avg_purchase_rate as current_purchase_rate,stock_view.current_stock_quantity');
        $this->db->from('stock_details');
        $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
        $this->db->join('stock_view', 'stock_view.product = stock_details.product', 'left');
        $this->db->where('stock_details.stock_code', $stockCode);
        $query = $this->db->get();
        $results = $query->result_array();

        $rawProductUpdateArr = array();
        foreach ($results as $result) {
            $x = 0;
            if ($result['current_stock_quantity'] != "" && $result['current_purchase_rate'] != "") {
                $x = $result['current_purchase_rate'] * $result['current_stock_quantity'];
            }
            $y = 0;
            if ($result['stock_in_quantity'] != "" && $result['rate'] != "") {
                $y = $result['rate'] * $result['stock_in_quantity'];
            }
            $totalAmount = $x + $y;
            $totalQuantity = $result['current_stock_quantity'] + $result['stock_in_quantity'];
            $averagePurchaseRate = 0;
            if ($totalQuantity) {
                $averagePurchaseRate = $totalAmount / $totalQuantity;
            }

            $arr['product_code'] = $result['product'];
            $arr['avg_purchase_rate'] = $averagePurchaseRate;
            $arr['updated_by'] = $this->user;
            $arr['updated_dt_tm'] = $this->dateTime;
            $rawProductUpdateArr[] = $arr;
        }

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);

        $this->db->update_batch('raw_product', $rawProductUpdateArr, 'product_code');

        return 1;
    }

    function stockEntryRejectd($stockSummaryArr, $stockDetailsArr, $stockCode, $isActive) {
        if ($isActive == STOCK_ENTRY_APPROVED) {
            $this->db->select('stock_details.product,stock_details.rate,stock_details.stock_in_quantity,
                raw_product.avg_purchase_rate as current_purchase_rate,stock_view.current_stock_quantity');
            $this->db->from('stock_details');
            $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
            $this->db->join('stock_view', 'stock_view.product = stock_details.product', 'left');
            $this->db->where('stock_details.stock_code', $stockCode);
            $query = $this->db->get();
            $results = $query->result_array();

            foreach ($results as $result) {
                if ($result['stock_in_quantity'] > $result['current_stock_quantity']) {
                    return 6; // you can not reject this because you have already made stock out from these products
                }
            }

            // $this->db->update_batch('raw_product', $rawProductUpdateArr, 'product_code');
        }

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);

        return 5;
    }

    function getRawReturnDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $this->db->where('stock_type', STOCK_OUT);
        $this->db->where('is_raw_return', 1);
        $query = $this->db->get('stock_summary');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->like('stock_type', STOCK_OUT, 'none');
        $this->db->like('is_raw_return', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('stock_code', $searchValue);
            $this->db->or_like('stock_date', $searchValue);
            $this->db->or_like('total_amount', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $this->db->order_by('stock_summary.created_dt_tm', 'DESC');
        $query = $this->db->get('stock_summary');
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
            $statusName = getStockSummaryStatusName($record['is_active']);
            $data[] = array('serial' => $i,
                'stock_date' => $record['stock_date'],
                'stock_code' => $record['stock_code'],
                'total_amount' => $record['total_amount'],
                'status_name' => $statusName);
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

    function addRawReturn($stockSummary, $stockDetails) {
        $this->db->insert('stock_summary', $stockSummary);
        if ($stockDetails) {
            $this->db->insert_batch('stock_details', $stockDetails);
        }
        return 1;
    }

    function getProductForRawReturn($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(raw_product.id) as allcount');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->join('stock_view', 'stock_view.product = raw_product.product_code');
        $this->db->where('raw_product.is_active', 1);
        $this->db->where('raw_category.is_active', 1);
        $this->db->where('stock_view.current_stock_quantity > ', 0);
        $query = $this->db->get();
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('raw_product.category,raw_product.product_name,raw_product.product_code,raw_product.avg_purchase_rate,raw_product.is_active,raw_category.category_name');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->join('stock_view', 'stock_view.product = raw_product.product_code');
        $this->db->like('raw_product.is_active', 1, 'none');
        $this->db->not_like('stock_view.current_stock_quantity', 0, 'none');
        if ($searchValue != '') {
            $this->db->like('raw_product.product_code', $searchValue);
            $this->db->or_like('raw_product.product_name', $searchValue);
            $this->db->or_like('raw_product.avg_purchase_rate', $searchValue);
            $this->db->or_like('raw_category.category_name', $searchValue);
        }
        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array(
                'product_details' => '<span class="td-f-l"><i class="fa fa-link"></i> <b class="template-green">' . $record['product_code'] . '</b><br><i class="fa fa-bars"></i> ' . $record['product_name'] . '<br><i class="fa fa-list"></i> <i><small>' . $record['category_name'] . '</small></i></span>',
                'product_title' => $record['product_name'] . ' (' . $record['product_code'] . ')',
                'product_code' => $record['product_code'],
                'avg_purchase_rate' => $record['avg_purchase_rate']
            );
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => count($data), //$totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );
        return $response;
    }

    function checkRawReturnQuantity($rawMaterialArr, $rawProductCodeArr) {
        $responseArr = array();
        $rawProductCount = count($rawProductCodeArr);
        $this->db->where_in('product', $rawProductCodeArr);
        $query = $this->db->get('stock_view');

        if ($rawProductCount != $query->num_rows()) {
            return array('response' => 5);  // the number of raw prduct that has taken is not same like as stock view
        }
        $results = $query->result_array();
        for ($i = 0; $i < count($rawMaterialArr); $i++) {
            $x = explode(',', $rawMaterialArr[$i]);
            $productCode = $x[0];
            $productQuantity = $x[1];

            foreach ($results as $result) {
                if ($productCode == $result['product']) {
                    if ($productQuantity > $result['current_stock_quantity']) {
                        $arr['product'] = $result['product'];
                        $responseArr[] = $arr;
                    }
                }
            }
        }
        if ($responseArr) {
            return array('response' => 6, 'lowQuantityArr' => $responseArr);   // those products have low quantity of packeging material
        }
        return array('response' => 1);  // success//
    }

    function getRawReturnSummary($stockCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->where('stock_type', STOCK_OUT);
        $this->db->where('is_raw_return', 1);
        $query = $this->db->get('stock_summary');
        return $query->result_array();
    }

    function getRawReturnDetails($stockCode) {
        $this->db->select('stock_details.*,raw_product.product_name,raw_product.avg_purchase_rate ,contact.contact_name as vendor_name');
        $this->db->from('stock_details');
        $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
        $this->db->join('contact', 'contact.contact_code = stock_details.vendor');
        $this->db->where('stock_details.stock_code', $stockCode);
        $this->db->where('stock_details.stock_type', STOCK_OUT);
        $this->db->where('stock_details.is_raw_return', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function rawReturnChecked($stockSummaryArr, $stockDetailsArr, $stockCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function rawReturnRejected($stockSummaryArr, $stockDetailsArr, $stockCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);

        return 5;
    }

    function rawReturnApproved($stockSummaryArr, $stockDetailsArr, $stockCode) {
        $this->db->select('stock_details.product,stock_details.rate,stock_details.stock_out_quantity,
                raw_product.avg_purchase_rate as current_purchase_rate,stock_view.current_stock_quantity');
        $this->db->from('stock_details');
        $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
        $this->db->join('stock_view', 'stock_view.product = stock_details.product', 'left');
        $this->db->where('stock_details.stock_code', $stockCode);
        $query = $this->db->get();
        $results = $query->result_array();

        $rawProductUpdateArr = array();
        foreach ($results as $result) {
            $x = 0;
            if ($result['current_stock_quantity'] != "" && $result['current_purchase_rate'] != "") {
                $x = $result['current_purchase_rate'] * $result['current_stock_quantity'];
            }
            $y = 0;
            if ($result['stock_out_quantity'] != "" && $result['rate'] != "") {
                $y = $result['rate'] * $result['stock_out_quantity'];
            }
            $totalAmount = $x - $y;
            $totalQuantity = $result['current_stock_quantity'] - $result['stock_out_quantity'];
            $averagePurchaseRate = 0;
            if ($totalQuantity) {
                $averagePurchaseRate = $totalAmount / $totalQuantity;
            }

            $arr['product_code'] = $result['product'];
            $arr['avg_purchase_rate'] = ($averagePurchaseRate < 0) ? 0 : $averagePurchaseRate;
            $arr['updated_by'] = $this->user;
            $arr['updated_dt_tm'] = $this->dateTime;
            $rawProductUpdateArr[] = $arr;
        }

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);

        $this->db->update_batch('raw_product', $rawProductUpdateArr, 'product_code');

        return 1;
    }

}
