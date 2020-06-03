<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RawProduct extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('RawProduct_model');
    }

    public function index() {
        redirect('Home');
    }

    public function category() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully deleted";
            $this->data['msgFlag'] = "success";
        }
        $this->data['currentPageCode'] = RAW_CATEGORY_PAGE;
        $this->data['pageHeading'] = 'Raw Product Category';
        $this->data['pageUrl'] = 'rawProduct/categoryView';
        $this->loadView($this->data);
    }

    public function getCategory() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);

        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getCategoryForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function newCategory() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully created a category";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate category";
            $this->data['msgFlag'] = "danger";
        }

        $this->data['currentPageCode'] = RAW_CATEGORY_PAGE;
        $this->data['pageHeading'] = 'New Raw Product Category';
        $this->data['pageUrl'] = 'rawProduct/addCatgoryView';
        $this->loadView($this->data);
    }

    public function categoryDuplicateCheck() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $arr['categoryCode'] = $this->getInputValue('categoryCode', 'POST', 'int', NULL, 0);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'int', NULL, 1);
        $arr['categoryDisplayId'] = $this->getInputValue('categoryDisplayId', 'POST', 'string', 30, 1);
        $result = $this->RawProduct_model->categoryDuplicateCheck($arr);
        echo $result;
    }

    public function addCategory() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $categoryInfo['category_name'] = $this->getInputValue('categoryName', 'POST', 'string', 100, 1);
        $categoryInfo['display_category_id'] = $this->getInputValue('categoryDisplayId', 'POST', 'string', 30, 1);
        $categoryInfo['created_by'] = $this->user;
        $categoryInfo['created_dt_tm'] = $this->dateTime;
        $categoryInfo['updated_by'] = $this->user;
        $categoryInfo['updated_dt_tm'] = $this->dateTime;
        $result = $this->RawProduct_model->addCategory($categoryInfo);
        redirect('RawProduct/newCategory?response=' . $result);
    }

    public function showCategoryDetails() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $categoryCode = $this->getInputValue('categoryCode', 'GET', 'string', NULL, 1);
        $this->data['categoryDetail'] = $this->RawProduct_model->getCategory(array('categoryCode' => $categoryCode, 'isActive' => 1));
        if ($this->data['categoryDetail']) {
            $this->data['currentPageCode'] = RAW_CATEGORY_PAGE;
            $this->data['pageHeading'] = 'Raw Product Category Details';
            $this->data['pageUrl'] = 'rawProduct/categoryDetailView';
            $this->loadView($this->data);
        } else {
            redirect('RawProduct/category');
        }
    }

    public function showEditCategory() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully edited a category";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate category";
            $this->data['msgFlag'] = "danger";
        }
        $categoryCode = $this->getInputValue('categoryCode', 'GET', 'string', NULL, 1);
        $this->data['categoryDetail'] = $this->RawProduct_model->getCategory(array('categoryCode' => $categoryCode, 'isActive' => 1));
        if ($this->data['categoryDetail']) {
            $this->data['currentPageCode'] = RAW_CATEGORY_PAGE;
            $this->data['pageHeading'] = 'Edit Raw Product Category';
            $this->data['pageUrl'] = 'rawProduct/editCategoryView';
            $this->loadView($this->data);
        } else {
            redirect('RawProduct/category');
        }
    }

    public function editCategory() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $categoryInfo['category_code'] = $this->getInputValue('categoryCode', 'POST', 'string', 30, 1);
        $categoryInfo['display_category_id'] = $this->getInputValue('categoryDisplayId', 'POST', 'string', 30, 1);
        $categoryInfo['category_name'] = $this->getInputValue('categoryName', 'POST', 'string', 100, 1);
        $categoryInfo['updated_by'] = $this->user;
        $categoryInfo['updated_dt_tm'] = $this->dateTime;

        $categoryDetail = $this->RawProduct_model->getCategory(array('categoryCode' => $categoryInfo['category_code'], 'isActive' => 1));
        if ($categoryDetail) {
            $result = $this->RawProduct_model->editCategory($categoryInfo);
            redirect('RawProduct/showEditCategory?categoryCode=' . $categoryInfo['category_code'] . '&response=' . $result);
        } else {
            redirect('RawProduct/category');
        }
    }

    public function deleteCategory() {
        $this->userRoleAuthentication(RAW_CATEGORY_PAGE);
        $categoryCode = $this->getInputValue('categoryCode', 'POST', 'string', NULL, 1);
        $categoryInfo['is_active'] = 0;
        $categoryInfo['updated_by'] = $this->user;
        $categoryInfo['updated_dt_tm'] = $this->dateTime;

        $productInfo['is_active'] = 0;
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;
        $response = $this->RawProduct_model->deleteCategory($categoryInfo, $categoryCode, $productInfo);
        echo $response;
    }

    public function product() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully deleted";
            $this->data['msgFlag'] = "success";
        }
        $this->data['currentPageCode'] = RAW_PRODUCT_PAGE;
        $this->data['pageHeading'] = 'Raw Product';
        $this->data['pageUrl'] = 'rawProduct/productView';
        $this->loadView($this->data);
    }

    public function getProduct() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);

        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getProductForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);

        //$this->db->insert('test_table', array('test' => json_encode($response)));
        //echo '{"draw":1,"iTotalRecords":10,"iTotalDisplayRecords":"156","aaData":[{"serial":"' . $draw . '","category":"' . $row . '","product_code":"' . $rowperpage . '","product_name":"' . $columnIndex . '","current_stock_quantity":"' . $columnName . '","avg_pur_rate":"' . $columnSortOrder . '"},{"serial":"' . $searchValue . '","category":"Vitamin (Liquid)","product_code":"2","product_name":"Vitamin A Palmitate Liquid","current_stock_quantity":null,"avg_pur_rate":"0"},{"serial":3,"category":"Vitamin (Powder)","product_code":"3","product_name":"Vitamin B1 Powder","current_stock_quantity":null,"avg_pur_rate":"0"},{"serial":4,"category":"Vitamin (Powder)","product_code":"4","product_name":"Vitamin B2 Powder","current_stock_quantity":"1.9998999985124102","avg_pur_rate":"4250"},{"serial":5,"category":"Vitamin (Powder)","product_code":"5","product_name":"Vitamin B5 (Calcium Pantothnate) Powder","current_stock_quantity":null,"avg_pur_rate":"0"},{"serial":6,"category":"Vitamin (Powder)","product_code":"6","product_name":"Vitamin B6 Powder","current_stock_quantity":null,"avg_pur_rate":"0"},{"serial":7,"category":"Vitamin (Powder)","product_code":"7","product_name":"Vitamin B12 Powder","current_stock_quantity":"99.9999999","avg_pur_rate":"550"},{"serial":8,"category":"Vitamin (Powder)","product_code":"8","product_name":"Vitamin C Powder","current_stock_quantity":null,"avg_pur_rate":"0"},{"serial":9,"category":"Vitamin (Powder)","product_code":"9","product_name":"Vitamin D3 Powder","current_stock_quantity":"24.899999998509884","avg_pur_rate":"4000"},{"serial":10,"category":"Vitamin (Liquid)","product_code":"10","product_name":"Vitamin D3 Liquid","current_stock_quantity":null,"avg_pur_rate":"0"}]}';

        echo json_encode($response);
    }

    public function newProduct() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully added a product";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate category";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['categories'] = $this->RawProduct_model->getCategory(array('isActive' => 1));
        $this->data['currentPageCode'] = RAW_PRODUCT_PAGE;
        $this->data['pageHeading'] = 'New Raw Product';
        $this->data['pageUrl'] = 'rawProduct/addProductView';
        $this->loadView($this->data);
    }

    public function productDuplicateCheck() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $arr['productCode'] = $this->getInputValue('productCode', 'POST', 'string', NULL, 0);
        $arr['productName'] = $this->getInputValue('productName', 'POST', 'string', 100, 1);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'string', NULL, 1);
        $result = $this->RawProduct_model->productDuplicateCheck($arr);
        echo $result;
    }

    public function addProduct() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $productInfo['category'] = $this->getInputValue('category', 'POST', 'string', 30, 1);
        $productInfo['product_name'] = $this->getInputValue('productName', 'POST', 'string', 100, 1);
        $productInfo['avg_purchase_rate'] = $this->getInputValue('avgPurchaseRate', 'POST', 'float', NULL, 1);
        $productInfo['created_by'] = $this->user;
        $productInfo['created_dt_tm'] = $this->dateTime;
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;
        $result = $this->RawProduct_model->addProduct($productInfo);
        redirect('RawProduct/newProduct?response=' . $result);
    }

    public function showProductDetails() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $productCode = $this->getInputValue('productCode', 'GET', 'string', NULL, 1);
        $this->data['productDetail'] = $this->RawProduct_model->getProduct(array('productCode' => $productCode, 'isActive' => 1));
        if ($this->data['productDetail']) {
            $this->data['currentPageCode'] = RAW_PRODUCT_PAGE;
            $this->data['pageHeading'] = 'Raw Product Details';
            $this->data['pageUrl'] = 'rawProduct/productDetailView';
            $this->loadView($this->data);
        } else {
            redirect('RawProduct/product');
        }
    }

    public function showEditProduct() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "You have successfully edited a product";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Duplicate product";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['categories'] = $this->RawProduct_model->getCategory(array('isActive' => 1));
        $productCode = $this->getInputValue('productCode', 'GET', 'string', NULL, 1);
        $this->data['productDetail'] = $this->RawProduct_model->getProduct(array('productCode' => $productCode, 'isActive' => 1));
        if ($this->data['productDetail']) {
            $this->data['currentPageCode'] = RAW_PRODUCT_PAGE;
            $this->data['pageHeading'] = 'Edit Raw Product';
            $this->data['pageUrl'] = 'rawProduct/editProductView';
            $this->loadView($this->data);
        } else {
            redirect('RawProduct/product');
        }
    }

    public function editProduct() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $productInfo['product_code'] = $this->getInputValue('productCode', 'POST', 'string', NULL, 1);
        $productInfo['category'] = $this->getInputValue('category', 'POST', 'string', 30, 1);
        $productInfo['product_name'] = $this->getInputValue('productName', 'POST', 'string', 100, 1);
        $productInfo['avg_purchase_rate'] = $this->getInputValue('avgPurchaseRate', 'POST', 'float', NULL, 1);
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;

        $productDetail = $this->RawProduct_model->getProduct(array('productCode' => $productInfo['product_code'], 'isActive' => 1));
        if ($productDetail) {
            $result = $this->RawProduct_model->editProduct($productInfo);
            redirect('RawProduct/showEditProduct?productCode=' . $productInfo['product_code'] . '&response=' . $result);
        } else {
            redirect('RawProduct/product');
        }
    }

    public function deleteProduct() {
        $this->userRoleAuthentication(RAW_PRODUCT_PAGE);
        $productCode = $this->getInputValue('productCode', 'POST', 'string', NULL, 1);
        $productInfo['is_active'] = 0;
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;
        $response = $this->RawProduct_model->deleteProduct($productInfo, $productCode);
        echo $response;
    }

    public function stockEntry() {
        $this->userRoleAuthentication(NULL, array(RAW_STOCK_ENTRY_PAGE, RAW_STOCK_CHECK_PAGE));
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        $this->data['currentPageCode'] = RAW_STOCK_ENTRY_PAGE;
        $this->data['pageHeading'] = 'Raw Product Stock Entry';
        $this->data['pageUrl'] = 'rawProduct/stockEntryView';
        $this->loadView($this->data);
    }

    public function stockEntryCheck() {
        $this->userRoleAuthentication(RAW_STOCK_CHECK_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        $this->data['currentPageCode'] = RAW_STOCK_CHECK_PAGE;
        $this->data['pageHeading'] = 'Raw Product Stock Check';
        $this->data['pageUrl'] = 'rawProduct/stockEntryCheckView';
        $this->loadView($this->data);
    }

    public function stockEntryApprove() {
        $this->userRoleAuthentication(RAW_STOCK_APPROVE_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        $this->data['currentPageCode'] = RAW_STOCK_APPROVE_PAGE;
        $this->data['pageHeading'] = 'Raw Product Stock Approve';
        $this->data['pageUrl'] = 'rawProduct/stockEntryView';
        $this->loadView($this->data);
    }

    public function newStock() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE . '|' . RAW_STOCK_ADD);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Stock entry has been completed";
            $this->data['msgFlag'] = "success";
        }
        $this->data['currentPageCode'] = RAW_STOCK_ENTRY_PAGE;
        $this->data['pageHeading'] = 'New Stock Entry';
        $this->data['pageUrl'] = 'rawProduct/newStockEntryView';
        $this->loadView($this->data);
    }

    public function getProductForStockEntry() {
        $this->userRoleAuthentication(NULL, array(RAW_STOCK_ENTRY_PAGE, MIXING_RAW_MATERIAL_PAGE));
        //$this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getProductForStockEntry($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function getVendorForStockEntry() {
        $this->userRoleAuthentication(NULL, array(RAW_STOCK_ENTRY_PAGE, RAW_RETURN_PAGE));
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getVendorForStockEntry($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function addRawProductStock() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE . '|' . RAW_STOCK_ADD);
        $stockSummary['stock_code'] = getCode(STOCK_CODE);
        $stockSummary['stock_date'] = $this->getInputValue('stockDate', 'POST', 'date', NULL, 1);
        $stockSummary['description'] = $this->getInputValue('description', 'POST', 'string', NULL, 0);
        $stockSummary['stock_type'] = STOCK_IN;
        $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
        $stockSummary['stock_variant_type'] = STOCK_VARIANT_ADD_RAW;
        $stockSummary['created_by'] = $this->user;
        $stockSummary['created_dt_tm'] = $this->dateTime;
        $stockSummary['updated_by'] = $this->user;
        $stockSummary['updated_dt_tm'] = $this->dateTime;

        $totalAmount = 0;
        $stockDetails = array();
        $itemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $itemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            //$this->getInputValue('product' . $i, 'POST', 'string', 30, 1);
            if ($product) {
                $itemArr['stock_code'] = $stockSummary['stock_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['product'] = $product;
                $itemArr['vendor'] = $this->getInputValue('vendor' . $i, 'POST', 'string', 30, 1);
                $itemArr['particulars'] = $this->getInputValue('particulars' . $i, 'POST', 'string', 300, 0);
                $itemArr['rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['stock_in_quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $this->getInputValue('amount' . $i, 'POST', 'string', NULL, 1);
                $itemArr['stock_type'] = STOCK_IN;
                $itemArr['stock_variant_type'] = STOCK_VARIANT_ADD_RAW;
                $itemArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemArr['created_by'] = $this->user;
                $itemArr['created_dt_tm'] = $this->dateTime;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemArr;
                $totalAmount = $totalAmount + $itemArr['amount'];
            }
        }
        $stockSummary['total_amount'] = $totalAmount;
        if (!$stockDetails) {
            redirect('RawProduct/newStock');
        }
        $result = $this->RawProduct_model->addRawProductStock($stockSummary, $stockDetails);
        redirect('RawProduct/newStock?response=' . $result);
    }

    public function getStockEntryData() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getStockEntryDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function showStockEntryDetails() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE);
        $stockCode = $this->getInputValue('stockCode', 'GET', 'string', 30, 1);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully edited";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Edited Failed because of another use has already updated this entry";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "This stock has checked successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 4) {
            $this->data['msg'] = "This stock has approved successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 5) {
            $this->data['msg'] = "This stock has rejected successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 6) {
            $this->data['msg'] = "You can not reject this because you have already made stock out from these products";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['stockSummary'] = $this->RawProduct_model->getStockInSummary($stockCode);
        $this->data['stockDetails'] = $this->RawProduct_model->getStockInDetails($stockCode);
//        echo "<pre>";
//        print_r($this->data['stockDetails']);
//        exit();
        if ($this->data['stockSummary'] && $this->data['stockDetails']) {
            $this->data['currentPageCode'] = RAW_STOCK_ENTRY_PAGE;
            $this->data['pageHeading'] = 'Stock Entry Details';
            $this->data['pageUrl'] = 'rawProduct/stockEntryDetailsView';
            $this->loadView($this->data);
        } else {
            redirect('RawProduct/stockEntry');
        }
    }

    public function showEditStock() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE . '|' . RAW_STOCK_EDIT);
        $stockCode = $this->getInputValue('stockCode', 'GET', 'string', 30, 1);
//        $response = (int) $this->input->get('response', true);
//        $this->data['msgFlag'] = "";
//        if ($response == 1) {
//            $this->data['msg'] = "Successfully deleted";
//            $this->data['msgFlag'] = "success";
//        }
        $this->data['stockSummary'] = $this->RawProduct_model->getStockInSummary($stockCode);
        $this->data['stockDetails'] = $this->RawProduct_model->getStockInDetails($stockCode);

        if ($this->data['stockSummary'] && $this->data['stockDetails']) {
            if ($this->data['stockSummary'][0]['is_active'] == STOCK_ENTRY_REJECTED) {
                $this->data['currentPageCode'] = RAW_STOCK_ENTRY_PAGE;
                $this->data['pageHeading'] = 'Edit Stock Entry';
                $this->data['pageUrl'] = 'rawProduct/showEditStockView';
                $this->loadView($this->data);
            } else {
                redirect('RawProduct/stockEntry');
            }
        } else {
            redirect('RawProduct/stockEntry');
        }
    }

    public function editRawProductStock() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE . '|' . RAW_STOCK_EDIT);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', 30, 1);
        $updatedDtTmHidden = $this->getInputValue('updatedDtTmHidden', 'POST', 'dateTime', NULL, 1);
        $stockSummaryDb = $this->RawProduct_model->getStockInSummary($stockCode);

        if (!$stockSummaryDb) {
            redirect('RawProduct/stockEntry');
        }
        if ($stockSummaryDb[0]['is_active'] == STOCK_ENTRY_REJECTED) {
            if ($updatedDtTmHidden != $stockSummaryDb[0]['updated_dt_tm']) {
                redirect('RawProduct/showStockEntryDetails?response=2&stockCode=' . $stockCode);
            }
            $createdBy = $stockSummaryDb[0]['created_by'];
            $createdDtTm = $stockSummaryDb[0]['created_dt_tm'];

            $stockSummary['stock_code'] = $stockCode;
            $stockSummary['stock_date'] = $this->getInputValue('stockDate', 'POST', 'date', NULL, 1);
            $stockSummary['description'] = $this->getInputValue('description', 'POST', 'string', NULL, 0);
            $stockSummary['stock_type'] = STOCK_IN;
            $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
            $stockSummary['stock_variant_type'] = STOCK_VARIANT_ADD_RAW;
            $stockSummary['created_by'] = $createdBy;
            $stockSummary['created_dt_tm'] = $createdDtTm;
            $stockSummary['updated_by'] = $this->user;
            $stockSummary['updated_dt_tm'] = $this->dateTime;

            $totalAmount = 0;
            $stockDetails = array();
            $itemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
            for ($i = 1; $i <= $itemCount; $i++) {
                $product = $this->input->post('product' . $i, true);
                if ($product) {
                    $itemArr['stock_code'] = $stockSummary['stock_code'];
                    $itemArr['reference_no'] = reference_no();
                    $itemArr['product'] = $product;
                    $itemArr['vendor'] = $this->getInputValue('vendor' . $i, 'POST', 'string', 30, 1);
                    $itemArr['particulars'] = $this->getInputValue('particulars' . $i, 'POST', 'string', 300, 0);
                    $itemArr['rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                    $itemArr['stock_in_quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                    $itemArr['amount'] = $this->getInputValue('amount' . $i, 'POST', 'string', NULL, 1);
                    $itemArr['stock_type'] = STOCK_IN;
                    $itemArr['is_active'] = STOCK_ENTRY_PENDING;
                    $itemArr['stock_variant_type'] = STOCK_VARIANT_ADD_RAW;
                    $itemArr['created_by'] = $createdBy;
                    $itemArr['created_dt_tm'] = $createdDtTm;
                    $itemArr['updated_by'] = $this->user;
                    $itemArr['updated_dt_tm'] = $this->dateTime;
                    $stockDetails[] = $itemArr;
                    $totalAmount = $totalAmount + $itemArr['amount'];
                }
            }
            $stockSummary['total_amount'] = $totalAmount;
            if (!$stockDetails) {
                redirect('RawProduct/stockEntry');
            }
            $result = $this->RawProduct_model->editRawProductStock($stockSummary, $stockDetails, $stockCode);
            redirect('RawProduct/showStockEntryDetails?response=' . $result . '&stockCode=' . $stockCode);
        } else {
            redirect('RawProduct/stockEntry');
        }
    }

    public function stockEntryChecked() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE . '|' . RAW_STOCK_CHECKED);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', NULL, 1);
        $stockSummary = $this->RawProduct_model->getStockInSummary($stockCode);
        if ($stockSummary[0]['is_active'] == STOCK_ENTRY_PENDING) {
            $stockSummaryArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
            $this->RawProduct_model->stockEntryChecked($stockSummaryArr, $stockDetailsArr, $stockCode);
            redirect('RawProduct/showStockEntryDetails?response=3&stockCode=' . $stockCode);
        } else {
            redirect('RawProduct/stockEntry');
        }
    }

    public function stockEntryApproved() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE . '|' . RAW_STOCK_APPRV);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', NULL, 1);
        $stockSummary = $this->RawProduct_model->getStockInSummary($stockCode);
        if ($stockSummary[0]['is_active'] == STOCK_ENTRY_CHECKED) {
            $stockSummaryArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;

            $this->RawProduct_model->stockEntryApproved($stockSummaryArr, $stockDetailsArr, $stockCode);
            redirect('RawProduct/showStockEntryDetails?response=4&stockCode=' . $stockCode);
        } else {
            redirect('RawProduct/stockEntry');
        }
    }

    public function stockEntryRejected() {
        $this->userRoleAuthentication(RAW_STOCK_ENTRY_PAGE);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', NULL, 1);
        $stockSummary = $this->RawProduct_model->getStockInSummary($stockCode);
        if ($stockSummary[0]['is_active'] == STOCK_ENTRY_REJECTED) {
            redirect('RawProduct/stockEntry');
        }
        $stockSummaryArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockSummaryArr['updated_by'] = $this->user;
        $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

        $stockDetailsArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockDetailsArr['updated_by'] = $this->user;
        $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
        $response = $this->RawProduct_model->stockEntryRejectd($stockSummaryArr, $stockDetailsArr, $stockCode, $stockSummaryArr['is_active']);
        redirect('RawProduct/showStockEntryDetails?response=' . $response . '&stockCode=' . $stockCode);
    }

    public function rawReturn() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
//        if ($response == 1) {
//            $this->data['msg'] = "Successfully deleted";
//            $this->data['msgFlag'] = "success";
//        }
        $this->data['currentPageCode'] = RAW_RETURN_PAGE;
        $this->data['pageHeading'] = 'Raw Return';
        $this->data['pageUrl'] = 'rawProduct/rawReturnView';
        $this->loadView($this->data);
    }

    public function getRawReturnData() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getRawReturnDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function showRawReturnDetails() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE);
        $stockCode = $this->getInputValue('stockCode', 'GET', 'string', 30, 1);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully edited";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Edited Failed because of another use has already updated this entry";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "This raw return has checked successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 4) {
            $this->data['msg'] = "This raw return has approved successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 5) {
            $this->data['msg'] = "This raw return has rejected successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 7) {
            $this->data['msg'] = "Approve failed because of there have not enough product in stock";
            $this->data['msgFlag'] = "danger";
        }

//        elseif ($response == 6) {
//            $this->data['msg'] = "You can not reject this because you have already made stock out from these products";
//            $this->data['msgFlag'] = "danger";
//        }
        $this->data['stockSummary'] = $this->RawProduct_model->getRawReturnSummary($stockCode);
        $this->data['stockDetails'] = $this->RawProduct_model->getRawReturnDetails($stockCode);
//        echo "<pre>";  
//        print_r($this->data['stockDetails']);
//        exit();
        if ($this->data['stockSummary'] && $this->data['stockDetails']) {
            $this->data['currentPageCode'] = RAW_RETURN_PAGE;
            $this->data['pageHeading'] = 'Stock Entry Details';
            $this->data['pageUrl'] = 'rawProduct/rawReturnDetailsView';
            $this->loadView($this->data);
        } else {
            redirect('RawProduct/rawReturn');
        }
    }

    public function newRawReturn() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE . '|' . RAW_RETURN_ADD);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Raw Return entry successfully done";
            $this->data['msgFlag'] = "success";
        } else if ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['currentPageCode'] = RAW_RETURN_PAGE;
        $this->data['pageHeading'] = 'New Raw Return Entry';
        $this->data['pageUrl'] = 'rawProduct/newRawReturnView';
        $this->loadView($this->data);
    }

    public function getProductForRawReturn() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->RawProduct_model->getProductForRawReturn($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function checkRawReturnQuantity() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE);
        $rawMaterialStr = $this->getInputValue('rawMaterialStr', 'POST', 'string', NULL, 1);
        $rawProductCodeArr = array();

        $rawMaterialArr = explode('|', $rawMaterialStr);
        for ($i = 0; $i < count($rawMaterialArr); $i++) {
            $x = explode(',', $rawMaterialArr[$i]);
            $rawProductCodeArr[] = $x[0];
        }

        $response = $this->RawProduct_model->checkRawReturnQuantity($rawMaterialArr, $rawProductCodeArr);
        echo json_encode($response);
    }

    public function addRawReturn() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE . '|' . RAW_RETURN_ADD);
        $stockSummary['stock_code'] = getCode(STOCK_CODE);
        $stockSummary['stock_date'] = $this->getInputValue('stockDate', 'POST', 'date', NULL, 1);
        $stockSummary['description'] = $this->getInputValue('description', 'POST', 'string', NULL, 0);
        $stockSummary['stock_type'] = STOCK_OUT;
        $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
        $stockSummary['stock_variant_type'] = STOCK_VARIANT_RAW_RETURN;
        $stockSummary['is_raw_return'] = 1;
        $stockSummary['created_by'] = $this->user;
        $stockSummary['created_dt_tm'] = $this->dateTime;
        $stockSummary['updated_by'] = $this->user;
        $stockSummary['updated_dt_tm'] = $this->dateTime;

        $totalAmount = 0;
        $stockDetails = array();
        $itemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        $rawMaterialArr = array();
        $rawProductCodeArr = array();
        for ($i = 1; $i <= $itemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            if ($product) {
                $itemArr['stock_code'] = $stockSummary['stock_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['product'] = $product;
                $itemArr['vendor'] = $this->getInputValue('vendor' . $i, 'POST', 'string', 30, 1);
                $itemArr['particulars'] = $this->getInputValue('particulars' . $i, 'POST', 'string', 300, 0);
                $itemArr['rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['stock_out_quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $this->getInputValue('amount' . $i, 'POST', 'string', NULL, 1);
                $itemArr['stock_type'] = STOCK_OUT;
                $itemArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemArr['is_raw_return'] = 1;
                $itemArr['stock_variant_type'] = STOCK_VARIANT_RAW_RETURN;
                $itemArr['created_by'] = $this->user;
                $itemArr['created_dt_tm'] = $this->dateTime;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemArr;
                $totalAmount = $totalAmount + $itemArr['amount'];

                $rawMaterialArr[] = $product . ',' . $itemArr['stock_out_quantity'];
                $rawProductCodeArr[] = $product;
            }
        }
        $stockSummary['total_amount'] = $totalAmount;
        if (!$stockDetails) {
            redirect('RawProduct/newRawReturn');
        }
        $response = $this->RawProduct_model->checkRawReturnQuantity($rawMaterialArr, $rawProductCodeArr);
        if ($response['response'] == 1) {
            $result = $this->RawProduct_model->addRawReturn($stockSummary, $stockDetails);
            redirect('RawProduct/newRawReturn?response=' . $result);
        } else {
            redirect('Formulation/newRawReturn?response=2');
        }
    }

    public function rawReturnChecked() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE . '|' . RAW_RETURN_CHECKED);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', NULL, 1);
        $stockSummary = $this->RawProduct_model->getRawReturnSummary($stockCode);
        if ($stockSummary[0]['is_active'] == STOCK_ENTRY_PENDING) {
            $stockSummaryArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
            $this->RawProduct_model->rawReturnChecked($stockSummaryArr, $stockDetailsArr, $stockCode);
            redirect('RawProduct/showRawReturnDetails?response=3&stockCode=' . $stockCode);
        } else {
            redirect('RawProduct/rawReturn');
        }
    }

    public function rawReturnRejected() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', NULL, 1);
        $stockSummary = $this->RawProduct_model->getRawReturnSummary($stockCode);
        if ($stockSummary[0]['is_active'] == STOCK_ENTRY_REJECTED) {
            redirect('RawProduct/rawReturn');
        }
        $stockSummaryArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockSummaryArr['updated_by'] = $this->user;
        $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

        $stockDetailsArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockDetailsArr['updated_by'] = $this->user;
        $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
        $response = $this->RawProduct_model->rawReturnRejected($stockSummaryArr, $stockDetailsArr, $stockCode);
        redirect('RawProduct/showRawReturnDetails?response=' . $response . '&stockCode=' . $stockCode);
    }

    public function rawReturnApproved() {
        $this->userRoleAuthentication(RAW_RETURN_PAGE . '|' . RAW_RETURN_APPRV);
        $stockCode = $this->getInputValue('stockCode', 'POST', 'string', NULL, 1);
        $stockSummary = $this->RawProduct_model->getRawReturnSummary($stockCode);
        if ($stockSummary[0]['is_active'] == STOCK_ENTRY_CHECKED) {
            $stockSummaryArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
            $stockDetails = $this->RawProduct_model->getRawReturnDetails($stockCode);
            $rawMaterialArr = array();
            $rawProductCodeArr = array();
            foreach ($stockDetails as $stockDetail) {
                $rawMaterialArr[] = $stockDetail['product'] . ',' . $stockDetail['stock_out_quantity'];
                $rawProductCodeArr[] = $stockDetail['product'];
            }

//            echo "<pre>";
//            print_r($stockDetails);
//            print_r($rawProductCodeArr);
//            exit();

            $response = $this->RawProduct_model->checkRawReturnQuantity($rawMaterialArr, $rawProductCodeArr);
            if ($response['response'] == 1) {
                $this->RawProduct_model->rawReturnApproved($stockSummaryArr, $stockDetailsArr, $stockCode);
                redirect('RawProduct/showRawReturnDetails?response=4&stockCode=' . $stockCode);
            } else {
                redirect('RawProduct/showRawReturnDetails?response=7&stockCode=' . $stockCode);
            }
        } else {
            redirect('RawProduct/rawReturn');
        }
    }

}
