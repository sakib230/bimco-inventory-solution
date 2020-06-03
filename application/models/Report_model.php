<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    function getRawProductForDatatable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(raw_product.id) as allcount');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $query = $this->db->get();
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('raw_product.category,raw_product.product_name,raw_product.product_code,raw_product.avg_purchase_rate,raw_product.is_active,raw_category.category_name');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
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

    function getVendorForDatatable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $query = $this->db->get('contact');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        if ($searchValue != '') {
            $this->db->like('contact_code', $searchValue);
            $this->db->or_like('contact_name', $searchValue);
            $this->db->or_like('mobile_no', $searchValue);
        }
        $query = $this->db->get('contact');
        $records = $query->result_array();

        $data = array();
        foreach ($records as $record) {
            $data[] = array(
                'vendor_details' => '<span class="td-f-l"><i class="fa fa-link"></i> <b class="template-green">' . $record['contact_code'] . '</b><br><i class="fa fa-user"></i> ' . $record['contact_name'] . '<br><i class="fa fa-phone"></i> <i><small>' . $record['mobile_no'] . '</small></i></span>',
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

    function getRawProductStockData($productCodeStr, $start, $end) {
        $productArr = array();
        if ($productCodeStr) {
            $productArr = explode(',', $productCodeStr);
        }
        $stockRatePermissionFlag = checkPermittedAction(REPORT_RAW_RATE);
        $rawProductSelectStr = 'raw_product.*';
        if ($stockRatePermissionFlag == 0) {
            $rawProductSelectStr = 'raw_product.category,raw_product.product_code,raw_product.product_name,raw_product.is_active';
        }

        $this->db->limit($end, $start);
        $this->db->select($rawProductSelectStr . ',raw_category.category_name,stock_view.*');
        $this->db->from('raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->join('stock_view', 'stock_view.product = raw_product.product_code', 'left');
        $this->db->where('raw_product.is_active', 1);
        if ($productArr) {
            $this->db->where_in('raw_product.product_code', $productArr);
        }
        $this->db->order_by('raw_product.product_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getRawProductStockInData($productCodeStr, $vendorCodeStr, $fromDate, $toDate, $start, $end) {
        $this->db->limit($end, $start);
        $this->db->select('stock_details.stock_code,stock_details.product,stock_details.vendor,stock_details.particulars,stock_details.rate,
                        stock_details.vendor,stock_details.stock_in_quantity,stock_details.amount,stock_details.rate,stock_summary.stock_date,
                        contact.contact_name as vendor_name,raw_product.product_name');
        $this->db->from('stock_details');
        $this->db->join('stock_summary', 'stock_summary.stock_code = stock_details.stock_code');
        $this->db->join('contact', 'contact.contact_code = stock_details.vendor');
        $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
        $this->db->where('stock_summary.stock_date >=', $fromDate);
        $this->db->where('stock_summary.stock_date <=', $toDate);
        $this->db->where('stock_details.stock_type', STOCK_IN);
        $this->db->where('stock_details.is_active', STOCK_ENTRY_APPROVED);
        if ($productCodeStr) {
            $this->db->where_in('stock_details.product', explode(',', $productCodeStr));
        }
        if ($vendorCodeStr) {
            $this->db->where_in('stock_details.vendor', explode(',', $vendorCodeStr));
        }
        $this->db->order_by('stock_details.stock_code', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getRawProductStockOutData($productCodeStr, $start, $end, $fromDate, $toDate) {
        $productArr = array();
        if ($productCodeStr) {
            $productArr = explode(',', $productCodeStr);
        }
        $whereClause = "";
        $whereClauseArr = array($fromDate, $toDate);
        if ($productArr) {
            $whereClause .= " AND `stock_details`.`product` in ?";
            $whereClauseArr[] = $productArr;
        }

        $sql = "SELECT `stock_details`.`stock_code`, `stock_details`.`product`, `stock_details`.`vendor`,`stock_details`.`particulars`, `stock_details`.`rate`, `stock_details`.`stock_out_quantity`, `stock_details`.`amount`, `stock_details`.`stock_variant_type`, `raw_product`.`product_name` as `raw_product_name`, `stock_summary`.`stock_date`,`contact`.`contact_name` as `vendor_name` , `finish_product`.`product_name` as `finish_product_name`,`finish_product`.`product_code` as `finish_product_code`
                FROM `stock_details`
                JOIN `raw_product` ON `raw_product`.`product_code` = `stock_details`.`product`
                JOIN `stock_summary` ON `stock_summary`.`stock_code` = `stock_details`.`stock_code`
                LEFT OUTER JOIN `contact` ON (`contact`.`contact_code` = `stock_details`.`vendor` AND `stock_details`.`stock_variant_type` = 'raw_return_out')
                LEFT OUTER JOIN `mixing_summary` ON (`mixing_summary`.`stock_code` = `stock_details`.`stock_code` AND `stock_details`.`stock_variant_type` = 'mixing_out')
                LEFT OUTER JOIN `finish_product` ON `finish_product`.`product_code` = `mixing_summary`.`finish_product`
                WHERE `stock_summary`.`stock_date` >= ? AND `stock_summary`.`stock_date` <= ? AND `stock_details`.`stock_type`='stock_out' " . $whereClause . "
                ORDER BY `stock_details`.`stock_code` ASC 
                LIMIT " . $start . "," . $end;
        $query = $this->db->query($sql, $whereClauseArr);

        $results = $query->result_array();
        return $results;
    }

    function getRawProductStockInOutData($productCodeStr, $start, $end, $fromDate, $toDate) {
        $productArr = array();
        if ($productCodeStr) {
            $productArr = explode(',', $productCodeStr);
        }
        $whereClause = "";
        $whereClauseArr = array($fromDate, $toDate);
        if ($productArr) {
            $whereClause .= " AND `stock_details`.`product` in ?";
            $whereClauseArr[] = $productArr;
        }

        $sql = "SELECT `stock_details`.`stock_code`, `stock_details`.`id` as `details_id`, `stock_details`.`product`, `stock_details`.`vendor`,`stock_details`.`particulars`, `stock_details`.`rate`, `stock_details`.`stock_out_quantity`,`stock_details`.`stock_in_quantity`, `stock_details`.`amount`, `stock_details`.`stock_variant_type`, `raw_product`.`product_name` as `raw_product_name`, `stock_summary`.`stock_date`,IFNULL(`contact`.`contact_name`,`stock_in_vendor`.`contact_name`) as `vendor_name` ,`stock_in_vendor`.`display_contact_id`, `finish_product`.`product_name` as `finish_product_name`,`finish_product`.`product_code` as `finish_product_code`
                FROM `stock_details`
                JOIN `raw_product` ON `raw_product`.`product_code` = `stock_details`.`product`
                JOIN `stock_summary` ON `stock_summary`.`stock_code` = `stock_details`.`stock_code`
                LEFT OUTER JOIN `contact` ON (`contact`.`contact_code` = `stock_details`.`vendor` AND `stock_details`.`stock_variant_type` = 'raw_return_out')
                LEFT OUTER JOIN `contact` as `stock_in_vendor` ON (`stock_in_vendor`.`contact_code` = `stock_details`.`vendor` AND `stock_details`.`stock_variant_type` = 'add_raw_in')
                LEFT OUTER JOIN `mixing_summary` ON (`mixing_summary`.`stock_code` = `stock_details`.`stock_code` AND `stock_details`.`stock_variant_type` = 'mixing_out')
                LEFT OUTER JOIN `finish_product` ON `finish_product`.`product_code` = `mixing_summary`.`finish_product`
                WHERE `stock_summary`.`stock_date` >= ? AND `stock_summary`.`stock_date` <= ? " . $whereClause . "
                AND `stock_details`.`is_active` = 1
                ORDER BY `stock_summary`.`stock_date` ASC,
                `stock_details`.`id` ASC
                LIMIT " . $start . "," . $end;
        $query = $this->db->query($sql, $whereClauseArr);

        $results = $query->result_array();
        return $results;
    }

    function getStockReportData($productCodeStr, $start, $end, $fromDate, $toDate) {
        $productArr = array();
        if ($productCodeStr) {
            $productArr = explode(',', $productCodeStr);
        }
        $this->db->limit($end, $start);
        $this->db->select('SUM(stock_details.stock_in_quantity) as total_stock_in_quantity,SUM(stock_details.stock_out_quantity) as total_stock_out_quantity,stock_details.product,
          stock_summary.stock_date,raw_product.product_name,raw_product.avg_purchase_rate,raw_category.category_name,stock_view.current_stock_quantity as present_stock');
        $this->db->from('stock_details');
        $this->db->join('stock_summary', 'stock_summary.stock_code = stock_details.stock_code');
        $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->join('stock_view', 'stock_view.product = raw_product.product_code', 'left');
        $this->db->where('stock_details.is_active', 1);
        $this->db->group_by('stock_details.product');
        if ($productArr) {
            $this->db->where_in('raw_product.product_code', $productArr);
        }
        $this->db->where('stock_summary.stock_date >=', $fromDate);
        $this->db->where('stock_summary.stock_date <=', $toDate);
        $this->db->order_by('stock_summary.stock_date', 'ASC');
        $this->db->order_by('stock_details.id', 'ASC');
        $this->db->order_by('raw_product.product_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

}
