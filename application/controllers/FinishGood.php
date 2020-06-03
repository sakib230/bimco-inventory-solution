<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FinishGood extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('FinishGood_model');
    }

    public function index() {
        redirect('Home');
    }

    public function category() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully deleted";
            $this->data['msgFlag'] = "success";
        }
        $this->data['currentPageCode'] = FINISH_CATEGORY_PAGE;
        $this->data['pageHeading'] = 'Finish Product Category';
        $this->data['pageUrl'] = 'finishGood/categoryView';
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

        $response = $this->FinishGood_model->getCategoryForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function newCategory() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
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

        $this->data['currentPageCode'] = FINISH_CATEGORY_PAGE;
        $this->data['pageHeading'] = 'New Finish Product Category';
        $this->data['pageUrl'] = 'finishGood/addCatgoryView';
        $this->loadView($this->data);
    }

    public function categoryDuplicateCheck() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
        $arr['categoryCode'] = $this->getInputValue('categoryCode', 'POST', 'string', NULL, 0);
        $arr['categoryName'] = $this->getInputValue('categoryName', 'POST', 'string', 100, 1);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'string', NULL, 1);
        $result = $this->FinishGood_model->categoryDuplicateCheck($arr);
        echo $result;
    }

    public function addCategory() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
        $categoryInfo['category_name'] = $this->getInputValue('categoryName', 'POST', 'string', 100, 1);
        $categoryInfo['created_by'] = $this->user;
        $categoryInfo['created_dt_tm'] = $this->dateTime;
        $categoryInfo['updated_by'] = $this->user;
        $categoryInfo['updated_dt_tm'] = $this->dateTime;
        $result = $this->FinishGood_model->addCategory($categoryInfo);
        redirect('FinishGood/newCategory?response=' . $result);
    }

    public function showCategoryDetails() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
        $categoryCode = $this->getInputValue('categoryCode', 'GET', 'string', NULL, 1);
        $this->data['categoryDetail'] = $this->FinishGood_model->getCategory(array('categoryCode' => $categoryCode, 'isActive' => 1));
        if ($this->data['categoryDetail']) {
            $this->data['currentPageCode'] = FINISH_CATEGORY_PAGE;
            $this->data['pageHeading'] = 'Finish Product Category Details';
            $this->data['pageUrl'] = 'finishGood/categoryDetailView';
            $this->loadView($this->data);
        } else {
            redirect('FinishGood/category');
        }
    }

    public function showEditCategory() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
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
        $this->data['categoryDetail'] = $this->FinishGood_model->getCategory(array('categoryCode' => $categoryCode, 'isActive' => 1));
        if ($this->data['categoryDetail']) {
            $this->data['currentPageCode'] = FINISH_CATEGORY_PAGE;
            $this->data['pageHeading'] = 'Edit Finish Product Category';
            $this->data['pageUrl'] = 'finishGood/editCategoryView';
            $this->loadView($this->data);
        } else {
            redirect('FinishGood/category');
        }
    }

    public function editCategory() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
        $categoryInfo['category_code'] = $this->getInputValue('categoryCode', 'POST', 'string', NULL, 1);
        $categoryInfo['category_name'] = $this->getInputValue('categoryName', 'POST', 'string', 100, 1);
        $categoryInfo['updated_by'] = $this->user;
        $categoryInfo['updated_dt_tm'] = $this->dateTime;

        $categoryDetail = $this->FinishGood_model->getCategory(array('categoryCode' => $categoryInfo['category_code'], 'isActive' => 1));
        if ($categoryDetail) {
            $result = $this->FinishGood_model->editCategory($categoryInfo);
            redirect('FinishGood/showEditCategory?categoryCode=' . $categoryInfo['category_code'] . '&response=' . $result);
        } else {
            redirect('FinishGood/category');
        }
    }

    public function deleteCategory() {
        $this->userRoleAuthentication(FINISH_CATEGORY_PAGE);
        $categoryCode = $this->getInputValue('categoryCode', 'POST', 'string', NULL, 1);
        $categoryInfo['is_active'] = 0;
        $categoryInfo['updated_by'] = $this->user;
        $categoryInfo['updated_dt_tm'] = $this->dateTime;

        $productInfo['is_active'] = 0;
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;
        $response = $this->FinishGood_model->deleteCategory($categoryInfo, $categoryCode, $productInfo);
        echo $response;
    }

    public function product() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully deleted";
            $this->data['msgFlag'] = "success";
        }
        $this->data['currentPageCode'] = FINISH_PRODUCT_PAGE;
        $this->data['pageHeading'] = 'Finish Goods';
        $this->data['pageUrl'] = 'finishGood/productView';
        $this->loadView($this->data);
    }

    public function getProduct() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);

        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->FinishGood_model->getProductForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function newProduct() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
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
        $this->data['categories'] = $this->FinishGood_model->getCategory(array('isActive' => 1));
        $this->data['currentPageCode'] = FINISH_PRODUCT_PAGE;
        $this->data['pageHeading'] = 'New Finished Goods';
        $this->data['pageUrl'] = 'finishGood/addProductView';
        $this->loadView($this->data);
    }

    public function productDuplicateCheck() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
        $arr['productCode'] = $this->getInputValue('productCode', 'POST', 'string', NULL, 0);
        $arr['productName'] = $this->getInputValue('productName', 'POST', 'string', 100, 1);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'string', NULL, 1);
        $result = $this->FinishGood_model->productDuplicateCheck($arr);
        echo $result;
    }

    public function addProduct() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
        $productInfo['category'] = $this->getInputValue('category', 'POST', 'string', 30, 1);
        $productInfo['product_name'] = $this->getInputValue('productName', 'POST', 'string', 100, 1);
        $productInfo['pack_size'] = $this->getInputValue('packSize', 'POST', 'string', 200, 1);
        $productInfo['unit_name'] = $this->getInputValue('unitName', 'POST', 'string', 200, 1);
        $productInfo['trade_price'] = $this->getInputValue('tradePrice', 'POST', 'float', NULL, 1);
        $productInfo['created_by'] = $this->user;
        $productInfo['created_dt_tm'] = $this->dateTime;
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;
        $result = $this->FinishGood_model->addProduct($productInfo);
        redirect('FinishGood/newProduct?response=' . $result);
    }

    public function showProductDetails() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
        $productCode = $this->getInputValue('productCode', 'GET', 'string', NULL, 1);
        $this->data['productDetail'] = $this->FinishGood_model->getProduct(array('productCode' => $productCode, 'isActive' => 1));
        if ($this->data['productDetail']) {
            $this->data['currentPageCode'] = FINISH_PRODUCT_PAGE;
            $this->data['pageHeading'] = 'Finish Goods Details';
            $this->data['pageUrl'] = 'finishGood/productDetailView';
            $this->loadView($this->data);
        } else {
            redirect('FinishGood/product');
        }
    }

    public function showEditProduct() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
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
        $this->data['categories'] = $this->FinishGood_model->getCategory(array('isActive' => 1));
        $productCode = $this->getInputValue('productCode', 'GET', 'string', NULL, 1);
        $this->data['productDetail'] = $this->FinishGood_model->getProduct(array('productCode' => $productCode, 'isActive' => 1));
        if ($this->data['productDetail']) {
            $this->data['currentPageCode'] = FINISH_PRODUCT_PAGE;
            $this->data['pageHeading'] = 'Edit Finish Goods';
            $this->data['pageUrl'] = 'finishGood/editProductView';
            $this->loadView($this->data);
        } else {
            redirect('FinishGood/product');
        }
    }

    public function editProduct() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
        $productInfo['product_code'] = $this->getInputValue('productCode', 'POST', 'string', NULL, 1);
        $productInfo['category'] = $this->getInputValue('category', 'POST', 'string', 30, 1);
        $productInfo['product_name'] = $this->getInputValue('productName', 'POST', 'string', 100, 1);
        $productInfo['pack_size'] = $this->getInputValue('packSize', 'POST', 'string', 200, 1);
        $productInfo['unit_name'] = $this->getInputValue('unitName', 'POST', 'string', 200, 1);
        $productInfo['trade_price'] = $this->getInputValue('tradePrice', 'POST', 'float', NULL, 1);
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;

        $productDetail = $this->FinishGood_model->getProduct(array('productCode' => $productInfo['product_code'], 'isActive' => 1));
        if ($productDetail) {
            $result = $this->FinishGood_model->editProduct($productInfo);
            redirect('FinishGood/showEditProduct?productCode=' . $productInfo['product_code'] . '&response=' . $result);
        } else {
            redirect('FinishGood/product');
        }
    }

    public function deleteProduct() {
        $this->userRoleAuthentication(FINISH_PRODUCT_PAGE);
        $productCode = $this->getInputValue('productCode', 'POST', 'string', NULL, 1);
        $productInfo['is_active'] = 0;
        $productInfo['updated_by'] = $this->user;
        $productInfo['updated_dt_tm'] = $this->dateTime;
        $response = $this->FinishGood_model->deleteProduct($productInfo, $productCode);
        echo $response;
    }

}
