<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Report_model');
    }

    public function index() {
        redirect('Home');
    }

    public function rawProductStock() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK);
        $this->data['currentPageCode'] = REPORT_RAW_STOCK;
        $this->data['pageHeading'] = 'Raw Product Stock';

        $advanceFilterCount = (int) $this->input->post('advanceFilterCount', true);
        $rawProductArr = array();

        for ($i = 0; $i < $advanceFilterCount; $i++) {
            $rawProduct = $this->input->post('productCode' . $i, true);
            if ($rawProduct) {
                $rawProductArr[] = $rawProduct;
            }
        }
        if (count($rawProductArr) > REPORT_MAX_WHERE_IN_ITEM) {
            redirect('Reports/rawProductStock');
        }

        $this->data['productCodeStr'] = ($rawProductArr) ? implode(',', $rawProductArr) : "";
        $this->data['pageUrl'] = 'reports/rawProductStockView';
        $this->loadView($this->data);
    }

    public function getRawProductStockData() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK);
        $productCodeStr = $this->getInputValue('productCodeStr', 'POST', 'string', NULL, 0);
        $iterationNumber = ($this->input->post('iterationNumber', true)) ? $this->input->post('iterationNumber', true) : 0;
        $end = SHOW_MORE_ITEM;
        $start = ($iterationNumber * ($end - 1));

        $products = $this->Report_model->getRawProductStockData($productCodeStr, $start, $end);
        echo json_encode(array('products' => $products));
    }

    public function getRawProductDataTable() {
        $this->userRoleAuthentication(NULL, array(REPORT_RAW_STOCK, REPORT_RAW_STOCK_IN, REPORT_RAW_STOCK_OUT, REPORT_RAW_STOCK_IN_OUT, RAW_STOCK_REPORT_PAGE));
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Report_model->getRawProductForDatatable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function rawProductStockIn() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_IN);
        $this->data['currentPageCode'] = REPORT_RAW_STOCK_IN;
        $this->data['pageHeading'] = 'Raw Product Stock In';

        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');

        $advanceFilterCount = (int) $this->input->post('advanceFilterCount', true);
        $rawProductArr = array();
        $vendorArr = array();
        for ($i = 0; $i < $advanceFilterCount; $i++) {
            $rawProduct = $this->input->post('productCode' . $i, true);
            $vendorCode = $this->input->post('vendorCode' . $i, true);
            if ($rawProduct) {
                $rawProductArr[] = $rawProduct;
            }
            if ($vendorCode) {
                $vendorArr[] = $vendorCode;
            }
        }
        $totalCount = count($rawProductArr) + count($vendorArr);
        if ($totalCount > REPORT_MAX_WHERE_IN_ITEM) {
            redirect('Reports/rawProductStockIn');
        }

        $this->data['productCodeStr'] = ($rawProductArr) ? implode(',', $rawProductArr) : "";
        $this->data['vendorCodeStr'] = ($rawProductArr) ? implode(',', $vendorArr) : "";
        $this->data['fromDate'] = $fromDate;
        $this->data['toDate'] = $toDate;
        $this->data['pageUrl'] = 'reports/rawProductStockInView';
        $this->loadView($this->data);
    }

    public function getVendorDataTable() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_IN);
        //$this->userRoleAuthentication(NULL, array(RAW_STOCK_ENTRY_PAGE, RAW_RETURN_PAGE));
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Report_model->getVendorForDatatable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function getRawProductStockInData() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_IN);
        $productCodeStr = $this->getInputValue('productCodeStr', 'POST', 'string', NULL, 0);
        $vendorCodeStr = $this->getInputValue('vendorCodeStr', 'POST', 'string', NULL, 0);

        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');

        $iterationNumber = ($this->input->post('iterationNumber', true)) ? $this->input->post('iterationNumber', true) : 0;
        $end = SHOW_MORE_ITEM;
        $start = ($iterationNumber * ($end - 1));

        $products = $this->Report_model->getRawProductStockInData($productCodeStr, $vendorCodeStr, $fromDate, $toDate, $start, $end);
        echo json_encode(array('products' => $products));
    }

    public function rawProductStockOut() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_OUT);
        $this->data['currentPageCode'] = REPORT_RAW_STOCK_OUT;
        $this->data['pageHeading'] = 'Raw Product Stock Out';
        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');

        $advanceFilterCount = (int) $this->input->post('advanceFilterCount', true);
        $rawProductArr = array();

        for ($i = 0; $i < $advanceFilterCount; $i++) {
            $rawProduct = $this->input->post('productCode' . $i, true);
            if ($rawProduct) {
                $rawProductArr[] = $rawProduct;
            }
        }
        if (count($rawProductArr) > REPORT_MAX_WHERE_IN_ITEM) {
            redirect('Reports/rawProductStock');
        }

        $this->data['productCodeStr'] = ($rawProductArr) ? implode(',', $rawProductArr) : "";
        $this->data['fromDate'] = $fromDate;
        $this->data['toDate'] = $toDate;
        $this->data['pageUrl'] = 'reports/rawProductStockOutView';
        $this->loadView($this->data);
    }

    public function getRawProductStockOutData() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_OUT);
        $productCodeStr = $this->getInputValue('productCodeStr', 'POST', 'string', NULL, 0);
        $iterationNumber = ($this->input->post('iterationNumber', true)) ? $this->input->post('iterationNumber', true) : 0;
        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');
        $end = SHOW_MORE_ITEM;
        $start = ($iterationNumber * ($end - 1));

        $products = $this->Report_model->getRawProductStockOutData($productCodeStr, $start, $end, $fromDate, $toDate);
        echo json_encode(array('products' => $products));
    }

    public function rawProductStockInOut() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_IN_OUT);
        $this->data['currentPageCode'] = REPORT_RAW_STOCK_IN_OUT;
        $this->data['pageHeading'] = 'Raw Product Stock Out';
        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');

        $advanceFilterCount = (int) $this->input->post('advanceFilterCount', true);
        $rawProductArr = array();

        for ($i = 0; $i < $advanceFilterCount; $i++) {
            $rawProduct = $this->input->post('productCode' . $i, true);
            if ($rawProduct) {
                $rawProductArr[] = $rawProduct;
            }
        }
        if (count($rawProductArr) > REPORT_MAX_WHERE_IN_ITEM) {
            redirect('Reports/rawProductStock');
        }

        $this->data['productCodeStr'] = ($rawProductArr) ? implode(',', $rawProductArr) : "";
        $this->data['fromDate'] = $fromDate;
        $this->data['toDate'] = $toDate;
        $this->data['pageUrl'] = 'reports/rawProductStockInOutView';
        $this->loadView($this->data);
    }

    public function getRawProductStockInOutData() {
        $this->userRoleAuthentication(REPORT_RAW_STOCK_IN_OUT);
        $productCodeStr = $this->getInputValue('productCodeStr', 'POST', 'string', NULL, 0);
        $iterationNumber = ($this->input->post('iterationNumber', true)) ? $this->input->post('iterationNumber', true) : 0;
        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');
        $end = SHOW_MORE_ITEM;
        $start = ($iterationNumber * ($end - 1));

        $products = $this->Report_model->getRawProductStockInOutData($productCodeStr, $start, $end, $fromDate, $toDate);
        echo json_encode(array('products' => $products));
    }

    public function stockReport() {
        $this->userRoleAuthentication(RAW_STOCK_REPORT_PAGE);
        $this->data['currentPageCode'] = RAW_STOCK_REPORT_PAGE;
        $this->data['pageHeading'] = 'Stock Report';
        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');
        $advanceFilterCount = (int) $this->input->post('advanceFilterCount', true);
        $rawProductArr = array();

        for ($i = 0; $i < $advanceFilterCount; $i++) {
            $rawProduct = $this->input->post('productCode' . $i, true);
            if ($rawProduct) {
                $rawProductArr[] = $rawProduct;
            }
        }
        if (count($rawProductArr) > REPORT_MAX_WHERE_IN_ITEM) {
            redirect('Reports/stockReport');
        }

        $this->data['productCodeStr'] = ($rawProductArr) ? implode(',', $rawProductArr) : "";
        $this->data['pageUrl'] = 'reports/stockReportView';
        $this->data['fromDate'] = $fromDate;
        $this->data['toDate'] = $toDate;
        $this->loadView($this->data);

        /*
          $this->db->select('SUM(stock_details.stock_in_quantity) as total_stock_in_quantity,SUM(stock_details.stock_out_quantity) as total_stock_out_quantity,stock_details.product,
          stock_summary.stock_date,raw_product.product_name,raw_product.avg_purchase_rate,raw_category.category_name,stock_view.current_stock_quantity as present_stock');
          $this->db->from('stock_details');
          $this->db->join('stock_summary', 'stock_summary.stock_code = stock_details.stock_code');
          $this->db->join('raw_product', 'raw_product.product_code = stock_details.product');
          $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
          $this->db->join('stock_view', 'stock_view.product = raw_product.product_code', 'left');
          $this->db->where('stock_details.is_active', 1);
          $this->db->group_by('stock_details.product');
          //        $this->db->where('stock_summary.stock_date >=', $fromDate);
          //        $this->db->where('stock_summary.stock_date <=', $toDate);

          $query = $this->db->get();
          $results = $query->result_array();
         * 
         */
//        echo "<pre>";
//        print_r($results);
    }

    public function getStockReportData() {
        $this->userRoleAuthentication(RAW_STOCK_REPORT_PAGE);
        $productCodeStr = $this->getInputValue('productCodeStr', 'POST', 'string', NULL, 0);
        $iterationNumber = ($this->input->post('iterationNumber', true)) ? $this->input->post('iterationNumber', true) : 0;
        $fromDate = ($this->getInputValue('fromDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('fromDate', 'POST', 'date', NULL, 0) : date('Y-m-01');
        $toDate = ($this->getInputValue('toDate', 'POST', 'date', NULL, 0)) ? $this->getInputValue('toDate', 'POST', 'date', NULL, 0) : date('Y-m-t');
        $end = SHOW_MORE_ITEM;
        $start = ($iterationNumber * ($end - 1));

        $products = $this->Report_model->getStockReportData($productCodeStr, $start, $end, $fromDate, $toDate);
        echo json_encode(array('products' => $products));
    }

}
