<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Formulation_model extends CI_Model {

    function getFinishGoodForFormulation($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
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
        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        foreach ($records as $record) {
//           s
            $data[] = array(
                'finish_good_details' => '<span class="td-f-l"><i class="fa fa-link"></i> <b class="template-green">' . $record['product_code'] . '</b><br><i class="fa fa-bars"></i> ' . $record['product_name'] . '<br><i class="fa fa-list"></i> <i><small>' . $record['category_name'] . '</small></i></span>',
                'finish_good_title' => $record['product_name'] . ' (' . $record['product_code'] . ')',
                'finish_good_code' => $record['product_code'],
                'pack_size' => $record['pack_size']
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

    function getRawProductForFormulation($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
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
                'avg_purchase_rate' => $record['avg_purchase_rate'],
                'category_name' => $record['category_name']
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

    function formulaDuplicateCheck($arr) {
        if ($arr['addEditFlag'] == 'edit') {
            $this->db->where_not_in('formula_code', $arr['formulaCode']);
        }
        $this->db->where('finish_product', $arr['finishProduct']);
        $this->db->where('is_active', FORMULA_ENTRY_APPROVED);
        $query = $this->db->get('formula_summary');
        if ($query->num_rows() > 0) {
            return 2;
        }
        return 1;
    }

    function addFormula($formulaSummary, $formulaDetails) {
//        $arr['finishProduct'] = $formulaSummary['finish_product'];
//        $arr['addEditFlag'] = 'add';
//        $duplicateFlag = $this->formulaDuplicateCheck($arr);
//        if ($duplicateFlag == 2) {
//            return 3;
//        }

        $this->db->insert('formula_summary', $formulaSummary);
        if ($formulaDetails) {
            $this->db->insert_batch('formula_details', $formulaDetails);
        }
        return 1;
    }

    function getFormulaDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $query = $this->db->get('formula_summary');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('formula_summary.formula_code,formula_summary.finish_product,formula_summary.is_active,formula_summary.multi_formula_active,finish_product.product_name as finish_product_name');
        $this->db->from('formula_summary');
        $this->db->join('finish_product', 'finish_product.product_code = formula_summary.finish_product');
        if ($searchValue != '') {
            $this->db->like('formula_summary.formula_code', $searchValue);
            $this->db->or_like('finish_product.product_name', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        if ($columnName == 'serial') {
            $this->db->order_by('formula_summary.finish_product', 'ASC');
        }

        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
            $statusName = getFormulaStatusName($record['is_active']);
            $data[] = array('serial' => $i,
                'formula_code' => $record['formula_code'],
                'finish_product_name' => $record['finish_product_name'],
                'status_name' => $statusName,
                'multi_formula_active' => getFormulaActiveName($record['multi_formula_active']));
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

    function getFormulaSummary($formulaCode) {
        $this->db->select('formula_summary.*,finish_product.product_name as finish_product_name,finish_product.pack_size');
        $this->db->from('formula_summary');
        $this->db->join('finish_product', 'finish_product.product_code = formula_summary.finish_product');
        $this->db->where('formula_summary.formula_code', $formulaCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getFormulaDetails($formulaCode) {
        $this->db->select('formula_details.*,raw_product.product_name,raw_category.category_name,raw_product.avg_purchase_rate');
        $this->db->from('formula_details');
        $this->db->join('raw_product', 'raw_product.product_code = formula_details.raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('formula_details.formula_code', $formulaCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    function editFormula($formulaSummary, $formulaDetails, $formulaCode) {
//        $arr['finishProduct'] = $formulaSummary['finish_product'];
//        $arr['formulaCode'] = $formulaCode;
//        $arr['addEditFlag'] = 'edit';
//        $duplicateFlag = $this->formulaDuplicateCheck($arr);
//        if ($duplicateFlag == 2) {
//            return 3;
//        }

        $this->db->where('formula_code', $formulaCode);
        $this->db->delete('formula_summary');

        $this->db->where('formula_code', $formulaCode);
        $this->db->delete('formula_details');

        $this->db->insert('formula_summary', $formulaSummary);
        if ($formulaDetails) {
            $this->db->insert_batch('formula_details', $formulaDetails);
        }
        return 1;
    }

    function formulaChecked($formulaSummaryArr, $formulaDetailsArr, $formulaCode) {
        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_summary', $formulaSummaryArr);

        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_details', $formulaDetailsArr);
        return 1;
    }

    function formulaApproved($formulaSummaryArr, $formulaDetailsArr, $formulaCode, $finishProduct) {
        $this->db->where('finish_product', $finishProduct);
        $this->db->where('is_active', FORMULA_ENTRY_APPROVED);
        $query = $this->db->get('formula_summary');
        if ($query->num_rows() == 0) {
            $formulaSummaryArr['multi_formula_active'] = 1;
//            return 7;
        }

        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_summary', $formulaSummaryArr);

        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_details', $formulaDetailsArr);
        return 5;
    }

    function formulaRejectd($formulaSummaryArr, $formulaDetailsArr, $formulaCode) {
        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_summary', $formulaSummaryArr);

        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_details', $formulaDetailsArr);
        return 1;
    }

    function multiFormulaStatusChange($formulaSummaryArr, $formulaCode, $multiFormulaStatus, $finishProduct) {
        if ($multiFormulaStatus == 1) {
//            $this->db->where_not_in('formula_code', $formulaCode);
            $this->db->where('finish_product', $finishProduct);
            $this->db->where('is_active', FORMULA_ENTRY_APPROVED);
            $this->db->where('multi_formula_active', 1);
            $query = $this->db->get('formula_summary');
            if ($query->num_rows() > 0) {
                return 11;
            }
        }

        $this->db->where('formula_code', $formulaCode);
        $this->db->update('formula_summary', $formulaSummaryArr);

        return 9;
    }

    function getRawProductForFinishGood($productCode) {
        $this->db->where('finish_product', $productCode);
        $this->db->where('is_active', FORMULA_ENTRY_APPROVED);
        $this->db->where('multi_formula_active', 1);
        $query = $this->db->get('formula_summary');
        if ($query->num_rows() == 0) {
            return array('response' => 2);
        }
        $result = $query->result_array();
        $formulaCode = $result[0]['formula_code'];

        $this->db->select('formula_details.raw_product,formula_details.quantity,raw_product.product_name,raw_product.avg_purchase_rate,raw_category.category_name');
        $this->db->from('formula_details');
        $this->db->join('raw_product', 'raw_product.product_code = formula_details.raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('formula_details.formula_code', $formulaCode);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return array('response' => 1, 'data' => $query->result_array());
        }
        return array('response' => 3);
    }

    function checkMixingAmount($finishProductCode, $finishGoodQuantity, $packegingArr, $packegingRawProductCodeArr) {
        // --------- Raw Product of Finish Goods ---------//
        $this->db->where('finish_product', $finishProductCode);
        $this->db->where('is_active', FORMULA_ENTRY_APPROVED);
        $query = $this->db->get('formula_summary');
        if ($query->num_rows() == 0) {
            return array('response' => 2);  // formula summary not exsists
        }

        $formulaCode = $query->row()->formula_code;

        $this->db->select('COUNT(id) as raw_product_count');
        $this->db->where('formula_code', $formulaCode);
        $query = $this->db->get('formula_details');
        $formulationRawProductCount = $query->row()->raw_product_count;

        $this->db->select('formula_details.raw_product,formula_details.quantity,stock_view.current_stock_quantity');
        $this->db->from('formula_details');
        $this->db->join('stock_view', 'stock_view.product = formula_details.raw_product');
        $this->db->where('formula_details.formula_code', $formulaCode);
        $query = $this->db->get();
        $formulationStockCount = $query->num_rows();
        if ($formulationStockCount == 0) {
            return array('response' => 2);  // stock view has no value
        }
        if ($formulationRawProductCount != $formulationStockCount) {
            return array('response' => 4);  // formulation details table has rows, but stock_view has not the same row
        }
        $results = $query->result_array();
        $responseArr = array();
        foreach ($results as $result) {
            $totalQuantity = $result['quantity'] * $finishGoodQuantity;
            if ($totalQuantity > $result['current_stock_quantity']) {
                $arr['rawProduct'] = $result['raw_product'];
                $responseArr[] = $arr;
            }
        }
        if ($responseArr) {
            return array('response' => 3, 'lowQuantityArr' => $responseArr);  // those products have low quantity
        }

        // --------- Packeging Material ---------//
        if ($packegingRawProductCodeArr) {
            $responseArr = array();
            $packegingRawProductCount = count($packegingRawProductCodeArr);
            $this->db->where_in('product', $packegingRawProductCodeArr);
            $query = $this->db->get('stock_view');
            if ($packegingRawProductCount != $query->num_rows()) {
                return array('response' => 5);  // the number of packeging materials that has taken is not same like as stock view
            }
            $results = $query->result_array();
            for ($i = 0; $i < count($packegingArr); $i++) {
                $x = explode(',', $packegingArr[$i]);
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
        }
        return array('response' => 1);  // success//
    }

    function addMixingRawMaterial($mixingSummary, $mixingDetails, $stockSummary, $stockDetails) {
        if ($mixingDetails) {
            $this->db->insert('mixing_summary', $mixingSummary);
            $this->db->insert_batch('mixing_details', $mixingDetails);

            $this->db->insert('stock_summary', $stockSummary);
            $this->db->insert_batch('stock_details', $stockDetails);
        }
    }

    function getMixingDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $query = $this->db->get('mixing_summary');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('mixing_summary.mixing_code,mixing_summary.finish_product, mixing_summary.finish_good_quantity, mixing_summary.mixing_date,
                       mixing_summary.created_dt_tm, mixing_summary.batch_no,mixing_summary.is_active,finish_product.product_name as finish_product_name');
        $this->db->from('mixing_summary');
        $this->db->join('finish_product', 'finish_product.product_code = mixing_summary.finish_product');
        if ($searchValue != '') {
            $this->db->like('mixing_summary.mixing_code', $searchValue);
            $this->db->or_like('mixing_summary.finish_product', $searchValue);
            $this->db->or_like('mixing_summary.finish_good_quantity', $searchValue);
            $this->db->or_like('mixing_summary.mixing_date', $searchValue);
            $this->db->or_like('mixing_summary.batch_no', $searchValue);
            $this->db->or_like('finish_product.product_name', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $this->db->order_by('mixing_summary.created_dt_tm', 'DESC');
        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
            $statusName = getMixingStatusName($record['is_active']);
            $data[] = array('serial' => $i,
                'mixing_date' => $record['mixing_date'],
                'mixing_code' => $record['mixing_code'],
                'finish_product_name' => $record['finish_product_name'],
                'finish_good_quantity' => $record['finish_good_quantity'],
                'batch_no' => $record['batch_no'],
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

    function getMixingSummary($mixingCode) {
        $this->db->select('mixing_summary.*,finish_product.product_name as finish_product_name,finish_product.pack_size');
        $this->db->from('mixing_summary');
        $this->db->join('finish_product', 'finish_product.product_code = mixing_summary.finish_product');
        $this->db->where('mixing_summary.mixing_code', $mixingCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getMixingDetails($mixingCode) {
        $this->db->select('mixing_details.*,raw_product.category,raw_product.product_name as raw_product_name,raw_category.category_name as raw_category_name');
        $this->db->from('mixing_details');
        $this->db->join('raw_product', 'raw_product.product_code = mixing_details.raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('mixing_details.mixing_code', $mixingCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    function editMixingRawMaterial($mixingSummary, $mixingDetails, $stockSummary, $stockDetails, $stockCode, $mixingCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->delete('stock_summary');

        $this->db->where('stock_code', $stockCode);
        $this->db->delete('stock_details');

        $this->db->where('mixing_code', $mixingCode);
        $this->db->delete('mixing_summary');

        $this->db->where('mixing_code', $mixingCode);
        $this->db->delete('mixing_details');

        if ($mixingDetails) {
            $this->db->insert('mixing_summary', $mixingSummary);
            $this->db->insert_batch('mixing_details', $mixingDetails);

            $this->db->insert('stock_summary', $stockSummary);
            $this->db->insert_batch('stock_details', $stockDetails);
        }
    }

    function mixingChecked($mixingSummaryArr, $mixingDetailsArr, $stockSummaryArr, $stockDetailsArr, $mixingCode, $stockCode) {
        $this->db->where('mixing_code', $mixingCode);
        $this->db->update('mixing_summary', $mixingSummaryArr);

        $this->db->where('mixing_code', $mixingCode);
        $this->db->update('mixing_details', $mixingDetailsArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function mixingRejected($mixingSummaryArr, $mixingDetailsArr, $stockSummaryArr, $stockDetailsArr, $mixingCode, $stockCode) {
        $this->db->where('mixing_code', $mixingCode);
        $this->db->update('mixing_summary', $mixingSummaryArr);

        $this->db->where('mixing_code', $mixingCode);
        $this->db->update('mixing_details', $mixingDetailsArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function mixingApproved($mixingSummaryArr, $mixingDetailsArr, $stockSummaryArr, $stockDetailsArr, $mixingCode, $stockCode) {
        $this->db->where('mixing_code', $mixingCode);
        $this->db->update('mixing_summary', $mixingSummaryArr);

        $this->db->where('mixing_code', $mixingCode);
        $this->db->update('mixing_details', $mixingDetailsArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function getLiftingDataForDataTable($draw, $row, $rowperpage, $columnName, $columnSortOrder, $searchValue) {
        ## Total number of records without filtering
        $this->db->select('COUNT(id) as allcount');
        $query = $this->db->get('extra_raw_lifting_summary');
        $totalRecords = $query->row()->allcount;

        ## Fetch records
        $this->db->limit($rowperpage, $row);  // number of records, start from
        $this->db->select('extra_raw_lifting_summary.lifting_code,extra_raw_lifting_summary.lifting_date,extra_raw_lifting_summary.is_active,extra_raw_lifting_summary.created_dt_tm');
        $this->db->from('extra_raw_lifting_summary');
        if ($searchValue != '') {
            $this->db->like('extra_raw_lifting_summary.lifting_code', $searchValue);
            $this->db->or_like('extra_raw_lifting_summary.lifting_date', $searchValue);
        }
        if ($columnName != 'serial') {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $this->db->order_by('extra_raw_lifting_summary.created_dt_tm', 'DESC');
        $query = $this->db->get();
        $records = $query->result_array();

        $data = array();
        $i = 1;
        foreach ($records as $record) {
            $statusName = getLiftingStatusName($record['is_active']);
            $data[] = array('serial' => $i,
                'lifting_date' => $record['lifting_date'],
                'lifting_code' => $record['lifting_code'],
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

    function checkRawLiftingAmount($rawMaterialArr, $rawProductCodeArr) {
        $responseArr = array();
        $rawProductCount = count($rawProductCodeArr);
        $this->db->where_in('product', $rawProductCodeArr);
        $query = $this->db->get('stock_view');

        //return $rawProductCount . ' ' . $query->num_rows() . ' ' . json_encode($rawProductCodeArr);

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

    function addExtraRawLifting($liftingSummary, $liftingDetails, $stockSummary, $stockDetails) {
        if ($liftingDetails) {
            $this->db->insert('extra_raw_lifting_summary', $liftingSummary);
            $this->db->insert_batch('extra_raw_lifting_details', $liftingDetails);

            $this->db->insert('stock_summary', $stockSummary);
            $this->db->insert_batch('stock_details', $stockDetails);
        }
    }

    function editExtraRawLifting($liftingSummary, $liftingDetails, $stockSummary, $stockDetails, $stockCode, $liftingCode) {
        $this->db->where('stock_code', $stockCode);
        $this->db->delete('stock_summary');

        $this->db->where('stock_code', $stockCode);
        $this->db->delete('stock_details');

        $this->db->where('lifting_code', $liftingCode);
        $this->db->delete('extra_raw_lifting_summary');

        $this->db->where('lifting_code', $liftingCode);
        $this->db->delete('extra_raw_lifting_details');

        if ($liftingDetails) {
            $this->db->insert('extra_raw_lifting_summary', $liftingSummary);
            $this->db->insert_batch('extra_raw_lifting_details', $liftingDetails);

            $this->db->insert('stock_summary', $stockSummary);
            $this->db->insert_batch('stock_details', $stockDetails);
        }
    }

    function getRawLiftingSummary($liftingCode) {
        $this->db->select('extra_raw_lifting_summary.*');
        $this->db->from('extra_raw_lifting_summary');
        $this->db->where('extra_raw_lifting_summary.lifting_code', $liftingCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getRawLiftingDetails($liftingCode) {
        $this->db->select('extra_raw_lifting_details.*,raw_product.category,raw_product.product_name as raw_product_name,raw_category.category_name as raw_category_name');
        $this->db->from('extra_raw_lifting_details');
        $this->db->join('raw_product', 'raw_product.product_code = extra_raw_lifting_details.raw_product');
        $this->db->join('raw_category', 'raw_category.category_code = raw_product.category');
        $this->db->where('extra_raw_lifting_details.lifting_code', $liftingCode);
        $query = $this->db->get();
        return $query->result_array();
    }

    function liftingChecked($liftingSummaryArr, $liftingDetailsArr, $stockSummaryArr, $stockDetailsArr, $liftingCode, $stockCode) {
        $this->db->where('lifting_code', $liftingCode);
        $this->db->update('extra_raw_lifting_summary', $liftingSummaryArr);

        $this->db->where('lifting_code', $liftingCode);
        $this->db->update('extra_raw_lifting_details', $liftingDetailsArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function liftingRejected($liftingSummaryArr, $liftingDetailsArr, $stockSummaryArr, $stockDetailsArr, $liftingCode, $stockCode) {
        $this->db->where('lifting_code', $liftingCode);
        $this->db->update('extra_raw_lifting_summary', $liftingSummaryArr);

        $this->db->where('lifting_code', $liftingCode);
        $this->db->update('extra_raw_lifting_details', $liftingDetailsArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

    function liftingApproved($liftingSummaryArr, $liftingDetailsArr, $stockSummaryArr, $stockDetailsArr, $liftingCode, $stockCode) {
        $this->db->where('lifting_code', $liftingCode);
        $this->db->update('extra_raw_lifting_summary', $liftingSummaryArr);

        $this->db->where('lifting_code', $liftingCode);
        $this->db->update('extra_raw_lifting_details', $liftingDetailsArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_summary', $stockSummaryArr);

        $this->db->where('stock_code', $stockCode);
        $this->db->update('stock_details', $stockDetailsArr);
        return 1;
    }

}
