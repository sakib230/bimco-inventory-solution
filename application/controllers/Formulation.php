<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formulation extends My_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Formulation_model');
        //
    }

    public function index() {
        redirect('Home');
    }

    public function productFormulation() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
//        if ($response == 1) {
//            $this->data['msg'] = "Successfully deleted";
//            $this->data['msgFlag'] = "success";
//        }
        $this->data['currentPageCode'] = PRODUCT_FURMULATION_PAGE;
        $this->data['pageHeading'] = 'Product Formulation';
        $this->data['pageUrl'] = 'formulation/productFormulationView';
        $this->loadView($this->data);
    }

    public function newProductFormulation() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . "|" . FORMULA_ADD);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Product formula has been succesfully created";
            $this->data['msgFlag'] = "success";
        } else if ($response == 3) {
            $this->data['msg'] = "You have already made a formula for this Finish Goods";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['currentPageCode'] = PRODUCT_FURMULATION_PAGE;
        $this->data['pageHeading'] = 'New Product Formulation';
        $this->data['pageUrl'] = 'formulation/newProductFormulationView';
        $this->loadView($this->data);
    }

    public function getFinishGoodForFormulation() {
        $this->userRoleAuthentication(NULL, array(PRODUCT_FURMULATION_PAGE, MIXING_RAW_MATERIAL_PAGE));
        // $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Formulation_model->getFinishGoodForFormulation($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function getRawProductForFormulation() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Formulation_model->getRawProductForFormulation($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function formulaDuplicateCheck() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $arr['formulaCode'] = $this->getInputValue('formulaCode', 'POST', 'string', 30, 0);
        $arr['finishProduct'] = $this->getInputValue('finishProduct', 'POST', 'string', 30, 1);
        $arr['addEditFlag'] = $this->getInputValue('addEditFlag', 'POST', 'string', NULL, 1);
        $result = $this->Formulation_model->formulaDuplicateCheck($arr);
        echo $result;
    }

    public function addFormula() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . "|" . FORMULA_ADD);
        $formulaSummary['formula_code'] =  getCode(FORMULA_CODE);
        $formulaSummary['finish_product'] = $this->getInputValue('finishProductCode', 'POST', 'string', 30, 1);
        $formulaSummary['is_active'] = FORMULA_ENTRY_PENDING;
        $formulaSummary['created_by'] = $this->user;
        $formulaSummary['created_dt_tm'] = $this->dateTime;
        $formulaSummary['updated_by'] = $this->user;
        $formulaSummary['updated_dt_tm'] = $this->dateTime;

        $formulaDetails = array();
        $itemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $itemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            if ($product) {
                $itemArr['formula_code'] = $formulaSummary['formula_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                //$itemArr['rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                //$itemArr['amount'] = $this->getInputValue('amount' . $i, 'POST', 'string', NULL, 1);
                $itemArr['is_active'] = FORMULA_ENTRY_PENDING;
                $itemArr['created_by'] = $this->user;
                $itemArr['created_dt_tm'] = $this->dateTime;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $formulaDetails[] = $itemArr;
            }
        }
        if (!$formulaDetails) {
            redirect('Formulation/newProductFormulation');
        }
        $result = $this->Formulation_model->addFormula($formulaSummary, $formulaDetails);
        redirect('Formulation/newProductFormulation?response=' . $result);
    }

    public function getFormulaData() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Formulation_model->getFormulaDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function showFormulaDetails() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $formulaCode = $this->getInputValue('formulaCode', 'GET', 'string', 30, 1);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully edited";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Edited Failed because of another use has already updated this formula";
            $this->data['msgFlag'] = "danger";
        } else if ($response == 3) {
            $this->data['msg'] = "You have already made a formula for this Finish Goods";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 4) {
            $this->data['msg'] = "This formulation has checked successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 5) {
            $this->data['msg'] = "This formulation has approved successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 6) {
            $this->data['msg'] = "This formulation has rejected successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 7) {
            $this->data['msg'] = "You have already made a furmulation of this finished good";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 8) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 9) {
            $this->data['msg'] = "This formulation is active now";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 10) {
            $this->data['msg'] = "This formulation is inactive now";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 11) {
            $this->data['msg'] = "There is another active formulation of this finish good. Please inactive the all active formulations of this product first";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['formulaSummary'] = $this->Formulation_model->getFormulaSummary($formulaCode);
        $this->data['formulaDetails'] = $this->Formulation_model->getFormulaDetails($formulaCode);

//        echo "<pre>";
//        print_r($this->data['formulaSummary']);
//        print_r($this->data['formulaDetails']);
//        exit();
        if ($this->data['formulaSummary'] && $this->data['formulaDetails']) {
            $this->data['currentPageCode'] = PRODUCT_FURMULATION_PAGE;
            $this->data['pageHeading'] = 'Formula Details';
            $this->data['pageUrl'] = 'formulation/formulaDetailsView';
            $this->loadView($this->data);
        } else {
            redirect('Formulation/productFormulation');
        }
    }

    public function showEditFormula() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . '|' . FORMULA_EDIT);
        $formulaCode = $this->getInputValue('formulaCode', 'GET', 'string', 30, 1);

        $this->data['formulaSummary'] = $this->Formulation_model->getFormulaSummary($formulaCode);
        $this->data['formulaDetails'] = $this->Formulation_model->getFormulaDetails($formulaCode);

        if ($this->data['formulaSummary'] && $this->data['formulaDetails']) {
            if ($this->data['formulaSummary'][0]['is_active'] == FORMULA_ENTRY_REJECTED) {
                $this->data['currentPageCode'] = PRODUCT_FURMULATION_PAGE;
                $this->data['pageHeading'] = 'Edit Formulation';
                $this->data['pageUrl'] = 'formulation/showEditProductFormulationView';
                $this->loadView($this->data);
            } else {
                redirect('Formulation/productFormulation');
            }
        } else {
            redirect('Formulation/productFormulation');
        }
    }

    public function editFormula() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . '|' . FORMULA_EDIT);
        $formulaCode = $this->getInputValue('formulaCode', 'POST', 'string', 30, 1);
        $updatedDtTmHidden = $this->getInputValue('updatedDtTmHidden', 'POST', 'dateTime', NULL, 1);

        $formulaSummaryDb = $this->Formulation_model->getFormulaSummary($formulaCode);
        if (!$formulaSummaryDb) {
            redirect('Formulation/productFormulation');
        }
        if ($formulaSummaryDb[0]['is_active'] == FORMULA_ENTRY_REJECTED) {
            if ($updatedDtTmHidden != $formulaSummaryDb[0]['updated_dt_tm']) {
                redirect('Formulation/showFormulaDetails?response=2&formulaCode=' . $formulaCode);
            }
            $createdBy = $formulaSummaryDb[0]['created_by'];
            $createdDtTm = $formulaSummaryDb[0]['created_dt_tm'];

            $formulaSummary['formula_code'] = $formulaCode;
            $formulaSummary['finish_product'] = $this->getInputValue('finishProductCode', 'POST', 'string', 30, 1);
            $formulaSummary['is_active'] = FORMULA_ENTRY_PENDING;
            $formulaSummary['created_by'] = $createdBy;
            $formulaSummary['created_dt_tm'] = $createdDtTm;
            $formulaSummary['updated_by'] = $this->user;
            $formulaSummary['updated_dt_tm'] = $this->dateTime;

            $formulaDetails = array();
            $itemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
            for ($i = 1; $i <= $itemCount; $i++) {
                $product = $this->input->post('product' . $i, true);
                if ($product) {
                    $itemArr['formula_code'] = $formulaSummary['formula_code'];
                    $itemArr['reference_no'] = reference_no();
                    $itemArr['raw_product'] = $product;
                    $itemArr['quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                    $itemArr['is_active'] = FORMULA_ENTRY_PENDING;
                    $itemArr['created_by'] = $createdBy;
                    $itemArr['created_dt_tm'] = $createdDtTm;
                    $itemArr['updated_by'] = $this->user;
                    $itemArr['updated_dt_tm'] = $this->dateTime;
                    $formulaDetails[] = $itemArr;
                }
            }

            if (!$formulaDetails) {
                redirect('Formulation/productFormulation');
            }
            $result = $this->Formulation_model->editFormula($formulaSummary, $formulaDetails, $formulaCode);
            redirect('Formulation/showFormulaDetails?response=' . $result . '&formulaCode=' . $formulaCode);
        } else {
            redirect('Formulation/productFormulation');
        }
    }

    public function formulaChecked() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . '|' . FORMULA_CHECKED);
        $formulaCode = $this->getInputValue('formulaCode', 'POST', 'string', NULL, 1);
        $formulaSummary = $this->Formulation_model->getFormulaSummary($formulaCode);
        if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_PENDING) {
            $formulaSummaryArr['is_active'] = FORMULA_ENTRY_CHECKED;
            $formulaSummaryArr['updated_by'] = $this->user;
            $formulaSummaryArr['updated_dt_tm'] = $this->dateTime;

            $formulaDetailsArr['is_active'] = FORMULA_ENTRY_CHECKED;
            $formulaDetailsArr['updated_by'] = $this->user;
            $formulaDetailsArr['updated_dt_tm'] = $this->dateTime;
            $this->Formulation_model->formulaChecked($formulaSummaryArr, $formulaDetailsArr, $formulaCode);

            redirect('Formulation/showFormulaDetails?response=4&formulaCode=' . $formulaCode);
        } else {
            redirect('Formulation/productFormulation');
        }
    }

    public function formulaApproved() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . '|' . FORMULA_APPRV);
        $formulaCode = $this->getInputValue('formulaCode', 'POST', 'string', NULL, 1);
        $formulaSummary = $this->Formulation_model->getFormulaSummary($formulaCode);
        if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_CHECKED) {
            $formulaSummaryArr['is_active'] = FORMULA_ENTRY_APPROVED;
            $formulaSummaryArr['updated_by'] = $this->user;
            $formulaSummaryArr['updated_dt_tm'] = $this->dateTime;

            $formulaDetailsArr['is_active'] = FORMULA_ENTRY_APPROVED;
            $formulaDetailsArr['updated_by'] = $this->user;
            $formulaDetailsArr['updated_dt_tm'] = $this->dateTime;

            $response = $this->Formulation_model->formulaApproved($formulaSummaryArr, $formulaDetailsArr, $formulaCode, $formulaSummary[0]['finish_product']);
            redirect('Formulation/showFormulaDetails?response=' . $response . '&formulaCode=' . $formulaCode);
        } else {
            redirect('Formulation/productFormulation');
        }
    }

    public function formulaRejected() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE);
        $formulaCode = $this->getInputValue('formulaCode', 'POST', 'string', NULL, 1);
        $formulaSummary = $this->Formulation_model->getFormulaSummary($formulaCode);
        if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_REJECTED) {
            redirect('Formulation/productFormulation');
        }
        $formulaSummaryArr['is_active'] = FORMULA_ENTRY_REJECTED;
        $formulaSummaryArr['multi_formula_active'] = 0;
        $formulaSummaryArr['updated_by'] = $this->user;
        $formulaSummaryArr['updated_dt_tm'] = $this->dateTime;

        $formulaDetailsArr['is_active'] = FORMULA_ENTRY_REJECTED;
        $formulaDetailsArr['updated_by'] = $this->user;
        $formulaDetailsArr['updated_dt_tm'] = $this->dateTime;
        $this->Formulation_model->formulaRejectd($formulaSummaryArr, $formulaDetailsArr, $formulaCode);
        redirect('Formulation/showFormulaDetails?response=6&formulaCode=' . $formulaCode);
    }

    public function multiFormulaStatusChange() {
        $this->userRoleAuthentication(PRODUCT_FURMULATION_PAGE . '|' . FORMULA_ACTIVE_INACTIVE);
        $formulaCode = $this->getInputValue('formulaCode', 'POST', 'string', NULL, 1);
        $multiFormulaStatus = $this->getInputValue('multiFormulaStatusHidden', 'POST', 'int', NULL, 1);
        $formulaSummary = $this->Formulation_model->getFormulaSummary($formulaCode);
        if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_APPROVED) {
            $formulaSummaryArr['updated_by'] = $this->user;
            $formulaSummaryArr['updated_dt_tm'] = $this->dateTime;
            if ($multiFormulaStatus == 1 && $formulaSummary[0]['multi_formula_active'] == 0) { // do active
                $formulaSummaryArr['multi_formula_active'] = 1;
                $response = $this->Formulation_model->multiFormulaStatusChange($formulaSummaryArr, $formulaCode, $multiFormulaStatus, $formulaSummary[0]['finish_product']);
                redirect('Formulation/showFormulaDetails?response=' . $response . '&formulaCode=' . $formulaCode);
            } else if ($multiFormulaStatus == 0 && $formulaSummary[0]['multi_formula_active'] == 1) { // do inactive
                $formulaSummaryArr['multi_formula_active'] = 0;
                $this->Formulation_model->multiFormulaStatusChange($formulaSummaryArr, $formulaCode, $multiFormulaStatus, $formulaSummary[0]['finish_product']);
                redirect('Formulation/showFormulaDetails?response=10&formulaCode=' . $formulaCode);
            }
        }
        redirect('Formulation/showFormulaDetails?response=8&formulaCode=' . $formulaCode);
    }

    public function mixingRawMaterial() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
//        if ($response == 1) {
//            $this->data['msg'] = "Successfully deleted";
//            $this->data['msgFlag'] = "success";
//        }
        $this->data['currentPageCode'] = MIXING_RAW_MATERIAL_PAGE;
        $this->data['pageHeading'] = 'Mixing Raw Materials';
        $this->data['pageUrl'] = 'formulation/mixingRawMaterialView';
        $this->loadView($this->data);
    }

    public function getMixingData() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Formulation_model->getMixingDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function newMixingRawMaterial() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE . "|" . MIXING_ADD);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Mixing raw product has been succesfully done";
            $this->data['msgFlag'] = "success";
        } else if ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['currentPageCode'] = MIXING_RAW_MATERIAL_PAGE;
        $this->data['pageHeading'] = 'New Mixing Raw Material';
        $this->data['pageUrl'] = 'formulation/newMixingRawMaterialView';
        $this->loadView($this->data);
    }

    public function setExpiryDate() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $manufactureDate = $this->getInputValue('manufactureDate', 'POST', 'date', NULL, 1);
        $addYear = $this->getInputValue('year', 'POST', 'string', 10, 1);
        //$addYear = 2.5;
        $monthArr = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
        //$manufactureDate = '1990-08-31';
        $todayYear = date('Y', strtotime($manufactureDate));
        $todayMonth = date('m', strtotime($manufactureDate));
        $todayDay = date('d', strtotime($manufactureDate));
//        if (floor($addYear) == $addYear) {
//            echo "int";
//        } else {
//            echo 'float';
//        }
//        exit();
        if (floor($addYear) == $addYear) {
//            echo $addYear;
//            exit();
            $expireYear = $todayYear + $addYear;
            $expireDate = $expireYear . '-' . $todayMonth . '-' . $todayDay;
            if (checkdate($todayMonth, $todayDay, $expireYear)) {
                echo $expireDate;
                exit();
            } else {
                echo $expireYear . '-03-01';
                exit();
            }
        } else {
//            echo 'rakib';
//            exit();
            $addYear = (int) $addYear;
            $expireMonthIndex = array_search($todayMonth, $monthArr) + 6;
            if ($expireMonthIndex > 11) {
                $expireMonthIndex = $expireMonthIndex - 11 - 1;
                $expireMonth = $monthArr[$expireMonthIndex];
            } else {
                $expireMonth = $monthArr[$expireMonthIndex];
            }
            $expireYear = $todayYear + $addYear;
            $expireDate = $expireYear . '-' . $expireMonth . '-' . $todayDay;

            $addDate = 0;
            while (1) {
                if (checkdate($expireMonth, $todayDay, $expireYear)) {
                    $expireDate = date('Y-m-d', strtotime($expireDate . ' + ' . $addDate . ' days'));
                    echo $expireDate;
                    exit();
                    break;
                }
                $todayDay--;
                $addDate++;
                $expireDate = $expireYear . '-' . $expireMonth . '-' . $todayDay;
            }
        }
    }

    public function getRawProductForFinishGood() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $productCode = $this->getInputValue('productCode', 'POST', 'string', 30, 1);
        $response = $this->Formulation_model->getRawProductForFinishGood($productCode);
        echo json_encode($response);
    }

    public function addMixingRawMaterial() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE . "|" . MIXING_ADD);
        $mixingDate = $this->getInputValue('mixingDate', 'POST', 'date', NULL, 1);
        $stockSummary['stock_code'] = getCode(STOCK_CODE);
        $stockSummary['stock_date'] = $mixingDate;
        $stockSummary['stock_type'] = STOCK_OUT;
        $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
        $stockSummary['created_by'] = $this->user;
        $stockSummary['created_dt_tm'] = $this->dateTime;
        $stockSummary['updated_by'] = $this->user;
        $stockSummary['updated_dt_tm'] = $this->dateTime;
        $stockSummary['stock_variant_type'] = STOCK_VARIANT_MIXING;

        $mixingSummary['mixing_code'] =  getCode(MIXING_CODE);
        $mixingSummary['stock_code'] = $stockSummary['stock_code'];
        $mixingSummary['finish_product'] = $this->getInputValue('finishProductCode', 'POST', 'string', 30, 1);
        $mixingSummary['mixing_date'] = $mixingDate;
        $mixingSummary['pack_size'] = $this->getInputValue('packSize', 'POST', 'string', 200, 0);
        $mixingSummary['finish_good_quantity'] = $this->getInputValue('finishGoodQuantity', 'POST', 'string', NULL, 1);
        $mixingSummary['batch_no'] = $this->getInputValue('batchNo', 'POST', 'string', 100, 1);
        $mixingSummary['manufacture_date'] = $this->getInputValue('manufactureDate', 'POST', 'date', NULL, 1);
        $mixingSummary['expiry_date'] = $this->getInputValue('expiryDate', 'POST', 'date', NULL, 1);
        $mixingSummary['mixing_for_year'] = $this->getInputValue('year', 'POST', 'string', 1, 1);

        $mixingDetails = array();
        $stockDetails = array();
        $formulationCost = 0;
        $rawProductForFinishCount = $this->getInputValue('rawProductForFinishCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $rawProductForFinishCount; $i++) {
            $product = $this->input->post('fomulationRawProduct' . $i, true);
            if ($product) {
                $itemArr['mixing_code'] = $mixingSummary['mixing_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                $itemArr['raw_rate'] = $this->getInputValue('formualtionRawRate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('formulationRawQuantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $itemArr['raw_rate'] * $itemArr['quantity'];
                $itemArr['raw_type'] = RAW_TYPE_FINISH_GOOD;
                $itemArr['is_active'] = MIXING_STATUS_PENDING;
                $itemArr['created_by'] = $this->user;
                $itemArr['created_dt_tm'] = $this->dateTime;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $mixingDetails[] = $itemArr;
                $formulationCost = $formulationCost + $itemArr['amount'];

                $itemStockArr['stock_code'] = $stockSummary['stock_code'];
                $itemStockArr['reference_no'] = reference_no();
                $itemStockArr['product'] = $product;
                $itemStockArr['rate'] = $itemArr['raw_rate'];
                $itemStockArr['stock_out_quantity'] = $itemArr['quantity'];
                $itemStockArr['amount'] = $itemArr['amount'];
                $itemStockArr['stock_type'] = STOCK_OUT;
                $itemStockArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemStockArr['stock_variant_type'] = STOCK_VARIANT_MIXING;
                $itemStockArr['created_by'] = $this->user;
                $itemStockArr['created_dt_tm'] = $this->dateTime;
                $itemStockArr['updated_by'] = $this->user;
                $itemStockArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemStockArr;
            }
        }

        $formulationCost = $formulationCost * $mixingSummary['finish_good_quantity'];
        $packegingCost = 0;
        $packegingArr = array();
        $packegingRawProductCodeArr = array();
        $applyItemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $applyItemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            if ($product) {
                $itemArr['mixing_code'] = $mixingSummary['mixing_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                $itemArr['raw_rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $itemArr['raw_rate'] * $itemArr['quantity'];
                $itemArr['raw_type'] = RAW_TYPE_PACKEGING;
                $itemArr['is_active'] = MIXING_STATUS_PENDING;
                $itemArr['created_by'] = $this->user;
                $itemArr['created_dt_tm'] = $this->dateTime;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $mixingDetails[] = $itemArr;
                $packegingCost = $packegingCost + $itemArr['amount'];

                $itemStockArr['stock_code'] = $stockSummary['stock_code'];
                $itemStockArr['reference_no'] = reference_no();
                $itemStockArr['product'] = $product;
                $itemStockArr['rate'] = $itemArr['raw_rate'];
                $itemStockArr['stock_out_quantity'] = $itemArr['quantity'];
                $itemStockArr['amount'] = $itemArr['amount'];
                $itemStockArr['stock_type'] = STOCK_OUT;
                $itemStockArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemStockArr['stock_variant_type'] = STOCK_VARIANT_MIXING;
                $itemStockArr['created_by'] = $this->user;
                $itemStockArr['created_dt_tm'] = $this->dateTime;
                $itemStockArr['updated_by'] = $this->user;
                $itemStockArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemStockArr;

                $packegingArr[] = $product . ',' . $itemArr['quantity'];
                $packegingRawProductCodeArr[] = $product;
            }
        }

        $totalCost = $packegingCost + $formulationCost;
        $purchaseCostPerUnit = 0;
        if ($mixingSummary['finish_good_quantity'] != 0) {
            $purchaseCostPerUnit = $totalCost / $mixingSummary['finish_good_quantity'];
        }

        $stockSummary['total_amount'] = $totalCost;

        $mixingSummary['formulation_cost'] = $formulationCost;
        $mixingSummary['extra_cost'] = $packegingCost;
        $mixingSummary['total_cost'] = $totalCost;
        $mixingSummary['purchase_cost_per_unit'] = $purchaseCostPerUnit;
        $mixingSummary['is_active'] = MIXING_STATUS_PENDING;
        $mixingSummary['created_by'] = $this->user;
        $mixingSummary['created_dt_tm'] = $this->dateTime;
        $mixingSummary['updated_by'] = $this->user;
        $mixingSummary['updated_dt_tm'] = $this->dateTime;

        $response = $this->Formulation_model->checkMixingAmount($mixingSummary['finish_product'], $mixingSummary['finish_good_quantity'], $packegingArr, $packegingRawProductCodeArr);
        if ($response['response'] == 1) {
            $response = $this->Formulation_model->addMixingRawMaterial($mixingSummary, $mixingDetails, $stockSummary, $stockDetails);
            redirect('Formulation/newMixingRawMaterial?response=1');
        } else {
            redirect('Formulation/newMixingRawMaterial?response=2');
        }
    }

    public function checkMixingAmount() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $finishProductCode = $this->getInputValue('finishProductCode', 'POST', 'string', 30, 1);
        $quantity = $this->getInputValue('quantity', 'POST', 'string', NULL, 1);
        $packegingRawMaterialStr = $this->getInputValue('packegingRawMaterialStr', 'POST', 'string', NULL, 0);
        $packegingArr = array();
        $packegingRawProductCodeArr = array();
        if ($packegingRawMaterialStr) {
            $packegingArr = explode('|', $packegingRawMaterialStr);
            for ($i = 0; $i < count($packegingArr); $i++) {
                $x = explode(',', $packegingArr[$i]);
                $packegingRawProductCodeArr[] = $x[0];
            }
        }
        $response = $this->Formulation_model->checkMixingAmount($finishProductCode, $quantity, $packegingArr, $packegingRawProductCodeArr);
        echo json_encode($response);
    }

    public function showMixingDetails() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $mixingCode = $this->getInputValue('mixingCode', 'GET', 'string', 30, 1);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully edited";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Edited Failed because of another use has already updated this entry";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 4) {
            $this->data['msg'] = "This has checked successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 5) {
            $this->data['msg'] = "This has approved successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 6) {
            $this->data['msg'] = "This has rejected successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 7) {
            $this->data['msg'] = "Approve failed because of there have not enough product in stock";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['mixingSummary'] = $this->Formulation_model->getMixingSummary($mixingCode);
        $this->data['mixingDetails'] = $this->Formulation_model->getMixingDetails($mixingCode);

        if ($this->data['mixingSummary'] && $this->data['mixingDetails']) {
            $this->data['currentPageCode'] = MIXING_RAW_MATERIAL_PAGE;
            $this->data['pageHeading'] = 'Mixing Raw Material Details';
            $this->data['pageUrl'] = 'formulation/mixingDetailsView';
            $this->loadView($this->data);
        } else {
            redirect('Formulation/productFormulation');
        }
    }

    public function showEditMixing() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE . '|' . MIXING_EDIT);
        $mixingCode = $this->getInputValue('mixingCode', 'GET', 'string', 30, 1);

        $this->data['mixingSummary'] = $this->Formulation_model->getMixingSummary($mixingCode);
        $this->data['mixingDetails'] = $this->Formulation_model->getMixingDetails($mixingCode);

        if ($this->data['mixingSummary'] && $this->data['mixingDetails']) {
            if ($this->data['mixingSummary'][0]['is_active'] == MIXING_STATUS_REJECTED) {
                $this->data['currentPageCode'] = MIXING_RAW_MATERIAL_PAGE;
                $this->data['pageHeading'] = 'Edit Mixing Raw Material';
                $this->data['pageUrl'] = 'formulation/showEditMixingView';
                $this->loadView($this->data);
            } else {
                redirect('Formulation/mixingRawMaterial');
            }
        } else {
            redirect('Formulation/mixingRawMaterial');
        }
    }

    public function editMixingRawMaterial() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE . '|' . MIXING_EDIT);
        $mixingCode = $this->getInputValue('mixingCode', 'POST', 'string', 30, 1);
        $updatedDtTmHidden = $this->getInputValue('updatedDtTmHidden', 'POST', 'dateTime', NULL, 1);

        $mixingSummaryDb = $this->Formulation_model->getMixingSummary($mixingCode);
        if (!$mixingSummaryDb) {
            redirect('Formulation/mixingRawMaterial');
        }
        if ($mixingSummaryDb[0]['is_active'] == MIXING_STATUS_REJECTED) {
            if ($updatedDtTmHidden != $mixingSummaryDb[0]['updated_dt_tm']) {
                redirect('Formulation/showMixingDetails?response=2&mixingCode=' . $mixingCode);
            }
        }
        $createdBy = $mixingSummaryDb[0]['created_by'];
        $createdDtTm = $mixingSummaryDb[0]['created_dt_tm'];
        $stockCode = $mixingSummaryDb[0]['stock_code'];

        $mixingDate = $this->getInputValue('mixingDate', 'POST', 'date', NULL, 1);
        $stockSummary['stock_code'] = $stockCode;
        $stockSummary['stock_date'] = $mixingDate;
        $stockSummary['stock_type'] = STOCK_OUT;
        $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
        $stockSummary['stock_variant_type'] = STOCK_VARIANT_MIXING;
        $stockSummary['created_by'] = $createdBy;
        $stockSummary['created_dt_tm'] = $createdDtTm;
        $stockSummary['updated_by'] = $this->user;
        $stockSummary['updated_dt_tm'] = $this->dateTime;

        $mixingSummary['mixing_code'] = $mixingCode;
        $mixingSummary['stock_code'] = $stockCode;
        $mixingSummary['finish_product'] = $this->getInputValue('finishProductCode', 'POST', 'string', 30, 1);
        $mixingSummary['mixing_date'] = $mixingDate;
        $mixingSummary['pack_size'] = $this->getInputValue('packSize', 'POST', 'string', 200, 0);
        $mixingSummary['finish_good_quantity'] = $this->getInputValue('finishGoodQuantity', 'POST', 'string', NULL, 1);
        $mixingSummary['batch_no'] = $this->getInputValue('batchNo', 'POST', 'string', 100, 1);
        $mixingSummary['manufacture_date'] = $this->getInputValue('manufactureDate', 'POST', 'date', NULL, 1);
        $mixingSummary['expiry_date'] = $this->getInputValue('expiryDate', 'POST', 'date', NULL, 1);
        $mixingSummary['mixing_for_year'] = $this->getInputValue('year', 'POST', 'string', 1, 1);

        $mixingDetails = array();
        $stockDetails = array();
        $formulationCost = 0;
        $rawProductForFinishCount = $this->getInputValue('rawProductForFinishCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $rawProductForFinishCount; $i++) {
            $product = $this->input->post('fomulationRawProduct' . $i, true);
            if ($product) {
                $itemArr['mixing_code'] = $mixingSummary['mixing_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                $itemArr['raw_rate'] = $this->getInputValue('formualtionRawRate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('formulationRawQuantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $itemArr['raw_rate'] * $itemArr['quantity'];
                $itemArr['raw_type'] = RAW_TYPE_FINISH_GOOD;
                $itemArr['is_active'] = MIXING_STATUS_PENDING;
                $itemArr['created_by'] = $createdBy;
                $itemArr['created_dt_tm'] = $createdDtTm;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $mixingDetails[] = $itemArr;
                $formulationCost = $formulationCost + $itemArr['amount'];

                $itemStockArr['stock_code'] = $stockSummary['stock_code'];
                $itemStockArr['reference_no'] = reference_no();
                $itemStockArr['product'] = $product;
                $itemStockArr['rate'] = $itemArr['raw_rate'];
                $itemStockArr['stock_out_quantity'] = $itemArr['quantity'];
                $itemStockArr['amount'] = $itemArr['amount'];
                $itemStockArr['stock_type'] = STOCK_OUT;
                $itemStockArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemStockArr['stock_variant_type'] = STOCK_VARIANT_MIXING;
                $itemStockArr['created_by'] = $createdBy;
                $itemStockArr['created_dt_tm'] = $createdDtTm;
                $itemStockArr['updated_by'] = $this->user;
                $itemStockArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemStockArr;
            }
        }

        $formulationCost = $formulationCost * $mixingSummary['finish_good_quantity'];
        $packegingCost = 0;
        $packegingArr = array();
        $packegingRawProductCodeArr = array();
        $applyItemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $applyItemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            if ($product) {
                $itemArr['mixing_code'] = $mixingSummary['mixing_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                $itemArr['raw_rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $itemArr['raw_rate'] * $itemArr['quantity'];
                $itemArr['raw_type'] = RAW_TYPE_PACKEGING;
                $itemArr['is_active'] = MIXING_STATUS_PENDING;
                $itemArr['created_by'] = $createdBy;
                $itemArr['created_dt_tm'] = $createdDtTm;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $mixingDetails[] = $itemArr;
                $packegingCost = $packegingCost + $itemArr['amount'];

                $itemStockArr['stock_code'] = $stockSummary['stock_code'];
                $itemStockArr['reference_no'] = reference_no();
                $itemStockArr['product'] = $product;
                $itemStockArr['rate'] = $itemArr['raw_rate'];
                $itemStockArr['stock_out_quantity'] = $itemArr['quantity'];
                $itemStockArr['amount'] = $itemArr['amount'];
                $itemStockArr['stock_type'] = STOCK_OUT;
                $itemStockArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemStockArr['stock_variant_type'] = STOCK_VARIANT_MIXING;
                $itemStockArr['created_by'] = $createdBy;
                $itemStockArr['created_dt_tm'] = $createdDtTm;
                $itemStockArr['updated_by'] = $this->user;
                $itemStockArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemStockArr;

                $packegingArr[] = $product . ',' . $itemArr['quantity'];
                $packegingRawProductCodeArr[] = $product;
            }
        }

        $totalCost = $packegingCost + $formulationCost;
        $purchaseCostPerUnit = 0;
        if ($mixingSummary['finish_good_quantity'] != 0) {
            $purchaseCostPerUnit = $totalCost / $mixingSummary['finish_good_quantity'];
        }

        $stockSummary['total_amount'] = $totalCost;

        $mixingSummary['formulation_cost'] = $formulationCost;
        $mixingSummary['extra_cost'] = $packegingCost;
        $mixingSummary['total_cost'] = $totalCost;
        $mixingSummary['purchase_cost_per_unit'] = $purchaseCostPerUnit;
        $mixingSummary['is_active'] = MIXING_STATUS_PENDING;
        $mixingSummary['created_by'] = $createdBy;
        $mixingSummary['created_dt_tm'] = $createdDtTm;
        $mixingSummary['updated_by'] = $this->user;
        $mixingSummary['updated_dt_tm'] = $this->dateTime;

        $response = $this->Formulation_model->checkMixingAmount($mixingSummary['finish_product'], $mixingSummary['finish_good_quantity'], $packegingArr, $packegingRawProductCodeArr);
        if ($response['response'] == 1) {
            $this->Formulation_model->editMixingRawMaterial($mixingSummary, $mixingDetails, $stockSummary, $stockDetails, $stockCode, $mixingCode);
            redirect('Formulation/showMixingDetails?mixingCode=' . $mixingCode . '&response=1');
        } else {
            redirect('Formulation/showMixingDetails?response=2');
        }
    }

    public function mixingChecked() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE . '|' . MIXING_CHECKED);
        $mixingCode = $this->getInputValue('mixingCode', 'POST', 'string', '30', 1);
        $mixingSummary = $this->Formulation_model->getMixingSummary($mixingCode);
        if ($mixingSummary[0]['is_active'] == MIXING_STATUS_PENDING) {
            $stockCode = $mixingSummary[0]['stock_code'];
            $mixingSummaryArr['is_active'] = MIXING_STATUS_CHECKED;
            $mixingSummaryArr['updated_by'] = $this->user;
            $mixingSummaryArr['updated_dt_tm'] = $this->dateTime;

            $mixingDetailsArr['is_active'] = MIXING_STATUS_CHECKED;
            $mixingDetailsArr['updated_by'] = $this->user;
            $mixingDetailsArr['updated_dt_tm'] = $this->dateTime;

            $stockSummaryArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
            $this->Formulation_model->mixingChecked($mixingSummaryArr, $mixingDetailsArr, $stockSummaryArr, $stockDetailsArr, $mixingCode, $stockCode);

            redirect('Formulation/showMixingDetails?response=4&mixingCode=' . $mixingCode);
        } else {
            redirect('Formulation/mixingRawMaterial');
        }
    }

    public function mixingApproved() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE . '|' . MIXING_APPRV);
        $mixingCode = $this->getInputValue('mixingCode', 'POST', 'string', '30', 1);
        $mixingSummary = $this->Formulation_model->getMixingSummary($mixingCode);
        if ($mixingSummary[0]['is_active'] == MIXING_STATUS_CHECKED) {
            $stockCode = $mixingSummary[0]['stock_code'];
            $mixingSummaryArr['is_active'] = MIXING_STATUS_APPROVED;
            $mixingSummaryArr['updated_by'] = $this->user;
            $mixingSummaryArr['updated_dt_tm'] = $this->dateTime;

            $mixingDetailsArr['is_active'] = MIXING_STATUS_APPROVED;
            $mixingDetailsArr['updated_by'] = $this->user;
            $mixingDetailsArr['updated_dt_tm'] = $this->dateTime;

            $stockSummaryArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;

            $mixingDetails = $this->Formulation_model->getMixingDetails($mixingCode);
            $packegingArr = array();
            $packegingRawProductCodeArr = array();
            foreach ($mixingDetails as $mixingDetail) {
                if ($mixingDetail['raw_type'] == RAW_TYPE_PACKEGING) {
                    $packegingArr[] = $mixingDetail['raw_product'] . ',' . $mixingDetail['quantity'];
                    $packegingRawProductCodeArr[] = $mixingDetail['raw_product'];
                }
            }

            $response = $this->Formulation_model->checkMixingAmount($mixingSummary[0]['finish_product'], $mixingSummary[0]['finish_good_quantity'], $packegingArr, $packegingRawProductCodeArr);
            if ($response['response'] == 1) {
                $this->Formulation_model->mixingApproved($mixingSummaryArr, $mixingDetailsArr, $stockSummaryArr, $stockDetailsArr, $mixingCode, $stockCode);
                redirect('Formulation/showMixingDetails?response=5&mixingCode=' . $mixingCode);
            } else {
                redirect('Formulation/showMixingDetails?response=7&mixingCode=' . $mixingCode);
            }
        } else {
            redirect('Formulation/mixingRawMaterial');
        }
    }

    public function mixingRejected() {
        $this->userRoleAuthentication(MIXING_RAW_MATERIAL_PAGE);
        $mixingCode = $this->getInputValue('mixingCode', 'POST', 'string', '30', 1);
        $mixingSummary = $this->Formulation_model->getMixingSummary($mixingCode);
        if ($mixingSummary[0]['is_active'] == MIXING_STATUS_REJECTED) {
            redirect('Formulation/mixingRawMaterial');
        }
        $stockCode = $mixingSummary[0]['stock_code'];
        $mixingSummaryArr['is_active'] = MIXING_STATUS_REJECTED;
        $mixingSummaryArr['updated_by'] = $this->user;
        $mixingSummaryArr['updated_dt_tm'] = $this->dateTime;

        $mixingDetailsArr['is_active'] = MIXING_STATUS_REJECTED;
        $mixingDetailsArr['updated_by'] = $this->user;
        $mixingDetailsArr['updated_dt_tm'] = $this->dateTime;

        $stockSummaryArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockSummaryArr['updated_by'] = $this->user;
        $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

        $stockDetailsArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockDetailsArr['updated_by'] = $this->user;
        $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
        $this->Formulation_model->mixingRejected($mixingSummaryArr, $mixingDetailsArr, $stockSummaryArr, $stockDetailsArr, $mixingCode, $stockCode);
        redirect('Formulation/showMixingDetails?response=6&mixingCode=' . $mixingCode);
    }

    public function extraRawLifting() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
//        if ($response == 1) {
//            $this->data['msg'] = "Successfully deleted";
//            $this->data['msgFlag'] = "success";
//        }
        $this->data['currentPageCode'] = EXTRA_RAW_LIFTING_PAGE;
        $this->data['pageHeading'] = 'Extra Raw Lifting';
        $this->data['pageUrl'] = 'formulation/extraRawLiftingView';
        $this->loadView($this->data);
    }

    public function getLiftingData() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE);
        $draw = $this->input->post('draw', true); //$_POST['draw'];
        $row = $this->input->post('start', true); //$_POST['start'];
        $rowperpage = $this->input->post('length', true); //$_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $response = $this->Formulation_model->getLiftingDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue);
        echo json_encode($response);
    }

    public function newRawLifting() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE . "|" . RAW_LIFTING_ADD);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Succesfully Add";
            $this->data['msgFlag'] = "success";
        } else if ($response == 2) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['currentPageCode'] = EXTRA_RAW_LIFTING_PAGE;
        $this->data['pageHeading'] = 'New Extra Raw Lifting';
        $this->data['pageUrl'] = 'formulation/newRawLiftingView';
        $this->loadView($this->data);
    }

    public function addExtraRawLifting() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE . "|" . RAW_LIFTING_ADD);
        $liftingDate = $this->getInputValue('liftingDate', 'POST', 'date', NULL, 1);
        $stockSummary['stock_code'] =  getCode(STOCK_CODE);
        $stockSummary['stock_date'] = $liftingDate;
        $stockSummary['stock_type'] = STOCK_OUT;
        $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
        $stockSummary['stock_variant_type'] = STOCK_VARIANT_EXTRA_RAW;
        $stockSummary['created_by'] = $this->user;
        $stockSummary['created_dt_tm'] = $this->dateTime;
        $stockSummary['updated_by'] = $this->user;
        $stockSummary['updated_dt_tm'] = $this->dateTime;

        $liftingSummary['lifting_code'] = getCode(LIFTING_CODE);
        $liftingSummary['stock_code'] = $stockSummary['stock_code'];
        $liftingSummary['lifting_date'] = $liftingDate;

        $liftingDetails = array();
        $stockDetails = array();

        $packegingCost = 0;
        $packegingArr = array();
        $packegingRawProductCodeArr = array();
        $applyItemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $applyItemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            if ($product) {
                $itemArr['lifting_code'] = $liftingSummary['lifting_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                $itemArr['raw_rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $itemArr['raw_rate'] * $itemArr['quantity'];
                $itemArr['is_active'] = LIFTING_STATUS_PENDING;
                $itemArr['created_by'] = $this->user;
                $itemArr['created_dt_tm'] = $this->dateTime;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $liftingDetails[] = $itemArr;
                $packegingCost = $packegingCost + $itemArr['amount'];

                $itemStockArr['stock_code'] = $stockSummary['stock_code'];
                $itemStockArr['reference_no'] = reference_no();
                $itemStockArr['product'] = $product;
                $itemStockArr['rate'] = $itemArr['raw_rate'];
                $itemStockArr['stock_out_quantity'] = $itemArr['quantity'];
                $itemStockArr['amount'] = $itemArr['amount'];
                $itemStockArr['stock_type'] = STOCK_OUT;
                $itemStockArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemStockArr['stock_variant_type'] = STOCK_VARIANT_EXTRA_RAW;
                $itemStockArr['created_by'] = $this->user;
                $itemStockArr['created_dt_tm'] = $this->dateTime;
                $itemStockArr['updated_by'] = $this->user;
                $itemStockArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemStockArr;

                $packegingArr[] = $product . ',' . $itemArr['quantity'];
                $packegingRawProductCodeArr[] = $product;
            }
        }
        $totalCost = $packegingCost;
        $stockSummary['total_amount'] = $totalCost;

        $liftingSummary['total_cost'] = $totalCost;
        $liftingSummary['is_active'] = LIFTING_STATUS_PENDING;
        $liftingSummary['created_by'] = $this->user;
        $liftingSummary['created_dt_tm'] = $this->dateTime;
        $liftingSummary['updated_by'] = $this->user;
        $liftingSummary['updated_dt_tm'] = $this->dateTime;

        $response = $this->Formulation_model->checkRawLiftingAmount($packegingArr, $packegingRawProductCodeArr);
        if ($response['response'] == 1) {
            $response = $this->Formulation_model->addExtraRawLifting($liftingSummary, $liftingDetails, $stockSummary, $stockDetails);
            redirect('Formulation/newRawLifting?response=1');
        } else {
            redirect('Formulation/newRawLifting?response=2');
        }
    }

    public function checkRawLiftingAmount() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE);
        $rawMaterialStr = $this->getInputValue('rawMaterialStr', 'POST', 'string', NULL, 1);
        $rawProductCodeArr = array();

        $rawMaterialArr = explode('|', $rawMaterialStr);
        for ($i = 0; $i < count($rawMaterialArr); $i++) {
            $x = explode(',', $rawMaterialArr[$i]);
            $rawProductCodeArr[] = $x[0];
        }

        $response = $this->Formulation_model->checkRawLiftingAmount($rawMaterialArr, $rawProductCodeArr);
        echo json_encode($response);
    }

    public function showRawLiftingDetails() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE);
        $liftingCode = $this->getInputValue('liftingCode', 'GET', 'string', 30, 1);
        $response = (int) $this->input->get('response', true);
        $this->data['msgFlag'] = "";
        if ($response == 1) {
            $this->data['msg'] = "Successfully edited";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 2) {
            $this->data['msg'] = "Edited Failed because of another use has already updated this entry";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 3) {
            $this->data['msg'] = "Failed";
            $this->data['msgFlag'] = "danger";
        } elseif ($response == 4) {
            $this->data['msg'] = "This has checked successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 5) {
            $this->data['msg'] = "This has approved successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 6) {
            $this->data['msg'] = "This has rejected successfully";
            $this->data['msgFlag'] = "success";
        } elseif ($response == 7) {
            $this->data['msg'] = "Approve failed because of there have not enough product in stock";
            $this->data['msgFlag'] = "danger";
        }
        $this->data['liftingSummary'] = $this->Formulation_model->getRawLiftingSummary($liftingCode);
        $this->data['liftingDetails'] = $this->Formulation_model->getRawLiftingDetails($liftingCode);

        if ($this->data['liftingSummary'] && $this->data['liftingDetails']) {
            $this->data['currentPageCode'] = EXTRA_RAW_LIFTING_PAGE;
            $this->data['pageHeading'] = 'Extra Raw Lifting Details';
            $this->data['pageUrl'] = 'formulation/rawLiftingDetailsView';
            $this->loadView($this->data);
        } else {
            redirect('Formulation/extraRawLifting');
        }
    }

    public function showEditExtraRawLifting() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE . '|' . RAW_LIFTING_EDIT);
        $liftingCode = $this->getInputValue('liftingCode', 'GET', 'string', 30, 1);
        $this->data['liftingSummary'] = $this->Formulation_model->getRawLiftingSummary($liftingCode);
        $this->data['liftingDetails'] = $this->Formulation_model->getRawLiftingDetails($liftingCode);
        if ($this->data['liftingSummary'] && $this->data['liftingDetails']) {
            if ($this->data['liftingSummary'][0]['is_active'] == LIFTING_STATUS_REJECTED) {
                $this->data['currentPageCode'] = EXTRA_RAW_LIFTING_PAGE;
                $this->data['pageHeading'] = 'Edit Extra Raw Lifting';
                $this->data['pageUrl'] = 'formulation/showEditRawLiftingView';
                $this->loadView($this->data);
            } else {
                redirect('Formulation/extraRawLifting');
            }
        } else {
            redirect('Formulation/extraRawLifting');
        }
    }

    public function editExtraRawLifting() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE . '|' . RAW_LIFTING_EDIT);
        $liftingCode = $this->getInputValue('liftingCode', 'POST', 'string', 30, 1);
        $updatedDtTmHidden = $this->getInputValue('updatedDtTmHidden', 'POST', 'dateTime', NULL, 1);

        $liftingSummaryDb = $this->Formulation_model->getRawLiftingSummary($liftingCode);
        if (!$liftingSummaryDb) {
            redirect('Formulation/extraRawLifting');
        }
        if ($liftingSummaryDb[0]['is_active'] == LIFTING_STATUS_REJECTED) {
            if ($updatedDtTmHidden != $liftingSummaryDb[0]['updated_dt_tm']) {
                redirect('Formulation/showRawLiftingDetails?response=2&liftingCode=' . $liftingCode);
            }
        }
        $createdBy = $liftingSummaryDb[0]['created_by'];
        $createdDtTm = $liftingSummaryDb[0]['created_dt_tm'];
        $stockCode = $liftingSummaryDb[0]['stock_code'];

        $liftingDate = $this->getInputValue('liftingDate', 'POST', 'date', NULL, 1);
        $stockSummary['stock_code'] = $stockCode;
        $stockSummary['stock_date'] = $liftingDate;
        $stockSummary['stock_type'] = STOCK_OUT;
        $stockSummary['is_active'] = STOCK_ENTRY_PENDING;
        $stockSummary['stock_variant_type'] = STOCK_VARIANT_EXTRA_RAW;
        $stockSummary['created_by'] = $createdBy;
        $stockSummary['created_dt_tm'] = $createdDtTm;
        $stockSummary['updated_by'] = $this->user;
        $stockSummary['updated_dt_tm'] = $this->dateTime;

        $liftingSummary['lifting_code'] = $liftingCode;
        $liftingSummary['stock_code'] = $stockCode;
        $liftingSummary['lifting_date'] = $liftingDate;

        $liftingDetails = array();
        $stockDetails = array();

        $packegingCost = 0;
        $packegingArr = array();
        $packegingRawProductCodeArr = array();
        $applyItemCount = $this->getInputValue('applyItemCount', 'POST', 'int', NULL, 1);
        for ($i = 1; $i <= $applyItemCount; $i++) {
            $product = $this->input->post('product' . $i, true);
            if ($product) {
                $itemArr['lifting_code'] = $liftingSummary['lifting_code'];
                $itemArr['reference_no'] = reference_no();
                $itemArr['raw_product'] = $product;
                $itemArr['raw_rate'] = $this->getInputValue('rate' . $i, 'POST', 'string', NULL, 1);
                $itemArr['quantity'] = $this->getInputValue('quantity' . $i, 'POST', 'string', NULL, 1);
                $itemArr['amount'] = $itemArr['raw_rate'] * $itemArr['quantity'];
                $itemArr['is_active'] = LIFTING_STATUS_PENDING;
                $itemArr['created_by'] = $createdBy;
                $itemArr['created_dt_tm'] = $createdDtTm;
                $itemArr['updated_by'] = $this->user;
                $itemArr['updated_dt_tm'] = $this->dateTime;
                $liftingDetails[] = $itemArr;
                $packegingCost = $packegingCost + $itemArr['amount'];

                $itemStockArr['stock_code'] = $stockSummary['stock_code'];
                $itemStockArr['reference_no'] = reference_no();
                $itemStockArr['product'] = $product;
                $itemStockArr['rate'] = $itemArr['raw_rate'];
                $itemStockArr['stock_out_quantity'] = $itemArr['quantity'];
                $itemStockArr['amount'] = $itemArr['amount'];
                $itemStockArr['stock_type'] = STOCK_OUT;
                $itemStockArr['is_active'] = STOCK_ENTRY_PENDING;
                $itemStockArr['stock_variant_type'] = STOCK_VARIANT_EXTRA_RAW;
                $itemStockArr['created_by'] = $createdBy;
                $itemStockArr['created_dt_tm'] = $createdDtTm;
                $itemStockArr['updated_by'] = $this->user;
                $itemStockArr['updated_dt_tm'] = $this->dateTime;
                $stockDetails[] = $itemStockArr;

                $packegingArr[] = $product . ',' . $itemArr['quantity'];
                $packegingRawProductCodeArr[] = $product;
            }
        }

        $totalCost = $packegingCost;
        $stockSummary['total_amount'] = $totalCost;

        $liftingSummary['total_cost'] = $totalCost;
        $liftingSummary['is_active'] = LIFTING_STATUS_PENDING;
        $liftingSummary['created_by'] = $createdBy;
        $liftingSummary['created_dt_tm'] = $createdDtTm;
        $liftingSummary['updated_by'] = $this->user;
        $liftingSummary['updated_dt_tm'] = $this->dateTime;

        $response = $this->Formulation_model->checkRawLiftingAmount($packegingArr, $packegingRawProductCodeArr);
        if ($response['response'] == 1) {
            $this->Formulation_model->editExtraRawLifting($liftingSummary, $liftingDetails, $stockSummary, $stockDetails, $stockCode, $liftingCode);
            redirect('Formulation/showRawLiftingDetails?liftingCode=' . $liftingCode . '&response=1');
        } else {
            redirect('Formulation/showRawLiftingDetails?response=2');
        }
    }

    public function liftingChecked() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE . '|' . RAW_LIFTING_CHECKED);
        $liftingCode = $this->getInputValue('liftingCode', 'POST', 'string', '30', 1);
        $liftingSummary = $this->Formulation_model->getRawLiftingSummary($liftingCode);
        if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_PENDING) {
            $stockCode = $liftingSummary[0]['stock_code'];
            $liftingSummaryArr['is_active'] = LIFTING_STATUS_CHECKED;
            $liftingSummaryArr['updated_by'] = $this->user;
            $liftingSummaryArr['updated_dt_tm'] = $this->dateTime;

            $liftingDetailsArr['is_active'] = LIFTING_STATUS_CHECKED;
            $liftingDetailsArr['updated_by'] = $this->user;
            $liftingDetailsArr['updated_dt_tm'] = $this->dateTime;

            $stockSummaryArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_CHECKED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
            $this->Formulation_model->liftingChecked($liftingSummaryArr, $liftingDetailsArr, $stockSummaryArr, $stockDetailsArr, $liftingCode, $stockCode);

            redirect('Formulation/showRawLiftingDetails?response=4&liftingCode=' . $liftingCode);
        } else {
            redirect('Formulation/extraRawLifting');
        }
    }

    public function liftingRejected() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE);
        $liftingCode = $this->getInputValue('liftingCode', 'POST', 'string', '30', 1);
        $liftingSummary = $this->Formulation_model->getRawLiftingSummary($liftingCode);
        if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_REJECTED) {
            redirect('Formulation/extraRawLifting');
        }
        $stockCode = $liftingSummary[0]['stock_code'];
        $liftingSummaryArr['is_active'] = LIFTING_STATUS_REJECTED;
        $liftingSummaryArr['updated_by'] = $this->user;
        $liftingSummaryArr['updated_dt_tm'] = $this->dateTime;

        $liftingDetailsArr['is_active'] = LIFTING_STATUS_REJECTED;
        $liftingDetailsArr['updated_by'] = $this->user;
        $liftingDetailsArr['updated_dt_tm'] = $this->dateTime;

        $stockSummaryArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockSummaryArr['updated_by'] = $this->user;
        $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

        $stockDetailsArr['is_active'] = STOCK_ENTRY_REJECTED;
        $stockDetailsArr['updated_by'] = $this->user;
        $stockDetailsArr['updated_dt_tm'] = $this->dateTime;
        $this->Formulation_model->liftingRejected($liftingSummaryArr, $liftingDetailsArr, $stockSummaryArr, $stockDetailsArr, $liftingCode, $stockCode);
        redirect('Formulation/showRawLiftingDetails?response=6&liftingCode=' . $liftingCode);
    }

    public function liftingApproved() {
        $this->userRoleAuthentication(EXTRA_RAW_LIFTING_PAGE . '|' . RAW_LIFTING_APPRV);
        $liftingCode = $this->getInputValue('liftingCode', 'POST', 'string', '30', 1);
        $liftingSummary = $this->Formulation_model->getRawLiftingSummary($liftingCode);
        if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_CHECKED) {
            $stockCode = $liftingSummary[0]['stock_code'];
            $liftingSummaryArr['is_active'] = LIFTING_STATUS_APPROVED;
            $liftingSummaryArr['updated_by'] = $this->user;
            $liftingSummaryArr['updated_dt_tm'] = $this->dateTime;

            $liftingDetailsArr['is_active'] = LIFTING_STATUS_APPROVED;
            $liftingDetailsArr['updated_by'] = $this->user;
            $liftingDetailsArr['updated_dt_tm'] = $this->dateTime;

            $stockSummaryArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockSummaryArr['updated_by'] = $this->user;
            $stockSummaryArr['updated_dt_tm'] = $this->dateTime;

            $stockDetailsArr['is_active'] = STOCK_ENTRY_APPROVED;
            $stockDetailsArr['updated_by'] = $this->user;
            $stockDetailsArr['updated_dt_tm'] = $this->dateTime;

            $liftingDetails = $this->Formulation_model->getRawLiftingDetails($liftingCode);
            $packegingArr = array();
            $packegingRawProductCodeArr = array();
            foreach ($liftingDetails as $liftingDetail) {
                $packegingArr[] = $liftingDetail['raw_product'] . ',' . $liftingDetail['quantity'];
                $packegingRawProductCodeArr[] = $liftingDetail['raw_product'];
            }

            $response = $this->Formulation_model->checkRawLiftingAmount($packegingArr, $packegingRawProductCodeArr);
            if ($response['response'] == 1) {
                $this->Formulation_model->liftingApproved($liftingSummaryArr, $liftingDetailsArr, $stockSummaryArr, $stockDetailsArr, $liftingCode, $stockCode);
                redirect('Formulation/showRawLiftingDetails?response=5&liftingCode=' . $liftingCode);
            } else {
                redirect('Formulation/showRawLiftingDetails?response=7&liftingCode=' . $liftingCode);
            }
        } else {
            redirect('Formulation/extraRawLifting');
        }
    }

    function test() {
        $dateTime = '2019-02-12';
        $newDate = date('Y-m-d H:i:s', strtotime('+ ' . 2.5 . ' year', strtotime($dateTime)));
        echo $newDate;
    }

}
