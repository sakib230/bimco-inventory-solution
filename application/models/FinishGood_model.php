<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FinishGood_model extends CI_Model {

    function getCategory($arr = array()) {
        $this->db->select('finish_category.*');
        $this->db->from('finish_category');
        if ($arr['categoryCode']) {
            $this->db->where('finish_category.category_code', $arr['categoryCode']);
        }
        if (isset($arr['isActive'])) {
            $this->db->where('finish_category.is_active', $arr['isActive']);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCategoryForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $query = $this->db->get('finish_category');
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
        $query = $this->db->get('finish_category');
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
//            if ($record['is_active'] == 0) {
//                continue;
//            }
            $data[] = array('serial' => $i,
                'category_code' => $record['category_code'],
                'category_name' => $record['category_name']);
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
        $this->db->where('category_name', $arr['categoryName']);
        $this->db->where('is_active', 1);
        $query = $this->db->get('finish_category');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addCategory($categoryInfo) {
        $arr['categoryName'] = $categoryInfo['category_name'];
        $arr['addEditFlag'] = 'add';
        $duplicateFlag = $this->categoryDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $categoryInfo['category_code'] = getCode(FINISH_PRODUCT_CATEGORY_CODE);
        $this->db->insert('finish_category', $categoryInfo);

        return 1;
    }

    function editCategory($categoryInfo) {
        $arr['categoryName'] = $categoryInfo['category_name'];
        $arr['categoryCode'] = $categoryInfo['category_code'];
        $arr['addEditFlag'] = 'edit';
        $duplicateFlag = $this->categoryDuplicateCheck($arr);
        if ($duplicateFlag == 2) {
            return 3;
        }
        $this->db->where('category_code', $categoryInfo['category_code']);
        $this->db->update('finish_category', $categoryInfo);
        return 1;
    }

    function deleteCategory($categoryInfo, $categoryCode, $productInfo) {
        $this->db->where('category_code', $categoryCode);
        $this->db->update('finish_category', $categoryInfo);

        $this->db->where('category', $categoryCode);
        $this->db->update('finish_product', $productInfo);
        return 1;
    }

    function getProductForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(finish_product.id) as allcount');
        $this->db->from('finish_product');
        $this->db->join('finish_category', 'finish_category.category_code = finish_product.category');
        $this->db->where('finish_product.is_active', 1);
        $this->db->where('finish_category.is_active', 1);
        $query = $this->db->get();
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('finish_product.*,finish_category.category_name');
        $this->db->from('finish_product');
        $this->db->join('finish_category', 'finish_category.category_code = finish_product.category');
        $this->db->like('finish_product.is_active', 1, 'none');
        if ($searchValue != '') {
            $this->db->like('finish_product.product_code', $searchValue);
            $this->db->or_like('finish_product.product_name', $searchValue);
            $this->db->or_like('finish_product.trade_price', $searchValue);
            $this->db->or_like('finish_product.unit_name', $searchValue);
            $this->db->or_like('finish_product.pack_size', $searchValue);
            $this->db->or_like('finish_category.category_name', $searchValue);
        }
        if ($columnName != 'serial') {
            if ($columnName == 'category') {
                $columnName = 'finish_category.' . $columnName;
            } elseif ($columnName == 'product_code') {
                $columnName = 'finish_product.' . $columnName;
            } elseif ($columnName == 'product_name') {
                $columnName = 'finish_product.' . $columnName;
            } elseif ($columnName == 'trade_price') {
                $columnName = 'finish_product.' . $columnName;
            } elseif ($columnName == 'pack_size') {
                $columnName = 'finish_product.' . $columnName;
            } elseif ($columnName == 'unit_name') {
                $columnName = 'finish_product.' . $columnName;
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
                'pack_size' => $record['pack_size'],
                'unit_name' => $record['unit_name'],
                'trade_price' => $record['trade_price']);
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
        $query = $this->db->get('finish_product');
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
        $productInfo['product_code'] = getCode(FINISH_PRODUCT_CODE);
        $this->db->insert('finish_product', $productInfo);

        return 1;
    }

    function getProduct($arr = array()) {
        $this->db->select('finish_product.*,finish_category.category_name');
        $this->db->from('finish_product');
        $this->db->join('finish_category', 'finish_category.category_code = finish_product.category');
        $this->db->where('finish_product.is_active', 1);
        $this->db->where('finish_category.is_active', 1);
        if ($arr['productCode']) {
            $this->db->where('finish_product.product_code', $arr['productCode']);
        }
        if (isset($arr['isActive'])) {
            $this->db->where('finish_product.is_active', $arr['isActive']);
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
        $this->db->update('finish_product', $productInfo);
        return 1;
    }

    function deleteProduct($productInfo, $productCode) {
        $this->db->where('product_code', $productCode);
        $this->db->update('finish_product', $productInfo);
        return 1;
    }

}
