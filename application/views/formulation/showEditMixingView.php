<link href="<?php echo base_url() ?>assets/css/listing_datatable.css" rel="stylesheet">
<script>
    function showRawProduct() {
        $("#rawProduct-modal").modal('show');
    }

    function showFinishGoods() {
        $("#finishGoods-modal").modal('show');
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <?php if (checkPermittedAction(MIXING_ADD)) { ?>  
            <a href="<?php echo base_url() ?>Formulation/newMixingRawMaterial" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Mixing Raw Material</a>
        <?php } ?>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 p-t-20">
    <form id="mixingForm" class="form-horizontal" action="<?php echo base_url() ?>Formulation/editMixingRawMaterial" method="post">

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Date <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div class="input-group dateTxt">
                                <input type="text" name="mixingDate" id="mixingDate" value="<?php echo $mixingSummary[0]['mixing_date'] ?>" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>

                            </div>
                            <span id="mixingDateReqError" class="text-danger hidden"><small>Please provide a date</small></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Finished Good <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <input type="text" id="finishGoodsDetails" class="form-control" value="<?php echo $mixingSummary[0]['finish_product_name'] . ' (' . $mixingSummary[0]['finish_product'] . ')' ?>"  readonly>
                                <input type="hidden" id="finishProductCode" name="finishProductCode" value="<?php echo $mixingSummary[0]['finish_product'] ?>"  class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-warning" onclick="showFinishGoods()"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            <span id="finishProductCodeReqError" class="text-danger hidden"><small>Please choose a finish goods</small></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Pack Size</label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input type="text" id="packSize" name="packSize" class="form-control col-md-7 col-xs-12" value="<?php echo $mixingSummary[0]['pack_size'] ?>"  readonly="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Finish Goods Quantity <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input type="text" id="finishGoodQuantity" name="finishGoodQuantity"  value="<?php echo $mixingSummary[0]['finish_good_quantity'] ?>"  onchange="allCalculation()" onkeyup="allCalculation()" class="form-control col-md-7 col-xs-12">
                            <span id="finishGoodQuantityReqError" class="text-danger hidden"><small>Please enter quantity</small></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Batch No <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <input type="text" id="batchNo" name="batchNo"  value="<?php echo $mixingSummary[0]['batch_no'] ?>"  class="form-control col-md-7 col-xs-12">
                            <span id="batchNoReqError" class="text-danger hidden"><small>Please enter batch no</small></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Manufacture Date <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div class="input-group dateTxt">
                                <input type="text" name="manufactureDate" onchange="setExpiryDate()"  value="<?php echo $mixingSummary[0]['manufacture_date'] ?>"  id="manufactureDate" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <span id="manufactureDateReqError" class="text-danger hidden"><small>Please enter manufacture date</small></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12">Year <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <select class="form-control" name="year" id="year" onchange="setExpiryDate()">
                                <?php
                                echo "<option value='" . $mixingSummary[0]['mixing_for_year'] . "'>" . $mixingSummary[0]['mixing_for_year'] . " year</option>";
                                ?>
                                <option value=""></option>
                                <option value="1">1 Year</option>
                                <option value="1.5">1.5 Year</option>
                                <option value="2">2 Year</option>
                                <option value="3">3 Year</option>
                            </select>
                            <span id="yearReqError" class="text-danger hidden"><small>Please select year</small></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Expiry Date <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div class="input-group dateTxt">
                                <input type="text" name="expiryDate"  value="<?php echo $mixingSummary[0]['expiry_date'] ?>"  id="expiryDate" class="form-control" readonly>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            <span id="expiryDateReqError" class="text-danger hidden"><small>Please enter expiry date</small></span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row">
            <hr>
            <div class="table-custom-responsive">
                <table id="rawProductForFinishGoodTable" class="table table-bordered custom-table">
                    <tr class="bg-gray">
                        <th colspan="7"><h5><b>Raw Product of Finish Goods</b></h5></th>
                    </tr>
                    <tr class="bg-gray">
                        <th style="width:10%!important">Raw ID</th>
                        <th style="width:10%!important">Raw Product</th>
                        <th style="width:10%!important">Category</th>
                        <th style="width:10%!important">Quantity</th>
                        <th style="width:10%!important">Rate <br>(BDT)</th>
                        <th style="width:10%!important">Amount <br>(BDT)</th>
                    </tr>
                    <?php
                    $rawProductForFinishCount = 1;
                    foreach ($mixingDetails as $mixingDetail) {
                        if ($mixingDetail['raw_type'] == RAW_TYPE_FINISH_GOOD) {
                            echo '<tr id="rawForFinishTr' . $rawProductForFinishCount . '">
                                        <td>' . $mixingDetail['raw_product'] . '</td>
                                        <td>' . $mixingDetail['raw_product_name'] . '</td>
                                        <td>' . $mixingDetail['raw_category_name'] . '</td>
                                        <td>' . $mixingDetail['quantity'] . '</td>
                                        <td>' . $mixingDetail['raw_rate'] . '</td>
                                        <td>' . $mixingDetail['amount'] . '</td>
                                        <input type="hidden" id="fomulationRawProduct' . $rawProductForFinishCount . '" name="fomulationRawProduct' . $rawProductForFinishCount . '"  value="' . $mixingDetail['raw_product'] . '">
                                        <input type="hidden" id="formualtionRawRate' . $rawProductForFinishCount . '" name="formualtionRawRate' . $rawProductForFinishCount . '"  value="' . $mixingDetail['raw_rate'] . '">
                                        <input type="hidden" id="formulationRawQuantity' . $rawProductForFinishCount . '" name="formulationRawQuantity' . $rawProductForFinishCount . '"  value="' . $mixingDetail['quantity'] . '">
                                        <input type="hidden" id="formulationRawAmount' . $rawProductForFinishCount . '" name="formulationRawAmount' . $rawProductForFinishCount . '"  value="' . $mixingDetail['amount'] . '">
                                  </tr>';
                            $rawProductForFinishCount++;
                        }
                    }
                    ?>
<!--                    <tr id="noItemFinishGoodTr">
                        <td colspan="6">No product</td>
                    </tr>-->
                </table>
            </div>
            <div id="rawProductQuantityError" class="text-danger"></div>
        </div>

        <div class="row">
            <hr>
            <div class="table-custom-responsive">
                <table id="itemDetailsTable" class="table table-bordered custom-table">
                    <tr class="bg-gray">
                        <th colspan="5"><h5><b>Packeging Material</b></h5></th>
                    </tr>
                    <tr class="bg-gray">
                        <th style="width:10%!important">Raw Product</th>
                        <th style="width:10%!important">Quantity</th>
                        <th style="width:10%!important">Rate <br>(BDT)</th>
                        <th style="width:10%!important">Amount <br>(BDT)</th>
                        <th style="width:10%!important"></th>
                    </tr>
                    <?php
                    $applyItemCount = 1;
                    foreach ($mixingDetails as $mixingDetail) {
                        if ($mixingDetail['raw_type'] == RAW_TYPE_PACKEGING) {
                            echo '<tr id="itemDetailsTr' . $applyItemCount . '">
                                    <td>' . $mixingDetail['raw_product_name'] . ' (' . $mixingDetail['raw_product'] . ')</td>
                                    <td>' . $mixingDetail['quantity'] . '</td>
                                    <td>' . $mixingDetail['raw_rate'] . '</td>
                                    <td>' . $mixingDetail['amount'] . '</td>
                                    <td><span class="text-danger pointer" onclick="removeItem(' . $applyItemCount . ')"><i class="fa fa-remove"></i></span></td>
                                    <input type="hidden" id="product' . $applyItemCount . '" name="product' . $applyItemCount . '"  value="' . $mixingDetail['raw_product'] . '">
                                    <input type="hidden" id="rate' . $applyItemCount . '" name="rate' . $applyItemCount . '"  value="' . $mixingDetail['raw_rate'] . '">
                                    <input type="hidden" id="quantity' . $applyItemCount . '" name="quantity' . $applyItemCount . '"  value="' . $mixingDetail['quantity'] . '">
                                    <input type="hidden" id="amount' . $applyItemCount . '" name="amount' . $applyItemCount . '"  value="' . $mixingDetail['amount'] . '">
                                  </tr>';
                            $applyItemCount++;
                        }
                    }
                    if ($applyItemCount == 1) {
                        echo '<tr id="noItemTr">
                        <td colspan="5">No product has been taken</td>
                    </tr>';
                    }
                    ?>
<!--                    <tr id="noItemTr">
                        <td colspan="5">No product has been taken</td>
                    </tr>-->
                </table>
                <span class="pointer template-green" onclick="showRawProductEntryModal()"><i class="fa fa-plus"></i> Add Extra Product</span>
            </div>
            <div id="packegingRawProductError" class="text-danger"></div>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-7 col-sm-offset-7">
                <span><b>Formulation Cost (BDT)</b></span>
                <span class="float-right" id="formulationCost"><?php echo $mixingSummary[0]['formulation_cost'] ?></span>
                <hr>
                <span><b>Extra Cost (BDT)</b></span>
                <span class="float-right" id="extraCost"><?php echo $mixingSummary[0]['extra_cost'] ?></span>
                <hr>
                <span><b>Total Cost (BDT)</b></span>
                <span class="float-right" id="total"><?php echo $mixingSummary[0]['total_cost'] ?></span>
                <hr>
                <span><b>Purchase Cost Per Unit (BDT)</b></span>
                <span class="float-right" id="perUnitPurchaseCost"><?php echo $mixingSummary[0]['purchase_cost_per_unit'] ?></span>
                <hr>
            </div>


        </div>


        <div class="row">
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-success btn-sm" onclick="newMixing()"><i class="fa fa-check"></i> Save</button>
                    <a href="<?php echo base_url() ?>Formulation/newMixingRawMaterial" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
                </div>
            </div>
        </div>
        <input type="hidden" id="applyItemCount" name="applyItemCount">
        <input type="hidden" id="rawProductForFinishCount" name="rawProductForFinishCount">
        <input type="hidden" name="mixingCode" value="<?php echo $mixingSummary[0]['mixing_code'] ?>">
        <input type="hidden" name="updatedDtTmHidden" value="<?php echo $mixingSummary[0]['updated_dt_tm'] ?>">
    </form>
</div>

<!-- ---------- Entry Raw Product Modal ------------- -->
<div class="modal fade" id="raw-product-entry-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Extra Product</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label" >Raw Product <span class="danger">*</span></label> <span id="productReqError" class="text-danger hidden"><small>Required</small></span>
                            <div class="input-group">
                                <input type="text" id="rawProductDetails" class="form-control" readonly>
                                <input type="hidden" id="rawProductCode" class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-warning" onclick="showRawProduct()"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label" >Quantity <span class="text-danger">*</span></label><span id="quantityReqError" class="text-danger hidden"><small>Required</small></span>
                        <input type="text" min="0" class="form-control" id="quantity" onchange="calculateTotalAmountPerItem()" onkeyup="calculateTotalAmountPerItem()">
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" >Rate <small><i> (BDT)</i></small></label>
                            <input type="text" class="form-control" id="rate" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label">Amount <small><i>(BDT) <span class="text-muted">(Rate X Quantity)</span></i></small> </label>
                        <input type="text" class="form-control" id="amount" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" onclick="applyItems()"><i class="fa fa-check"></i> Apply</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
            </div>

        </div>
    </div>
</div>
<!-- ---------- end Raw Product Modal ------------- -->

<!-- ---------- Raw Product Modal ------------- -->
<div class="modal fade" id="rawProduct-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel1">Raw Product</h4>
            </div>
            <div class="modal-body">
                <div class="table-custom-responsive">
                    <table class="table table-hover table-striped custom-table" id="rawProduct-datatable">
                        <thead class="hidden">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>

            </div>

        </div>
    </div>
</div>
<!-- ---------- end raw product Modal ------------- -->
<!-- ---------- Finish good Modal ------------- -->
<div class="modal fade" id="finishGoods-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel2">Finished Goods</h4>
            </div>
            <div class="modal-body">
                <div class="table-custom-responsive">
                    <table class="table table-hover table-striped custom-table" id="finishedGoods-datatable">
                        <thead class="hidden">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
            </div>

        </div>
    </div>
</div>
<!-- ---------- end finish good Modal ------------- -->

<script>
//    $('#finishGoodsDetails').val('');
//    $('#packSize').val('');
    var selectedItemCount = 1;
    var rawProductForFinishCount = '<?php echo $rawProductForFinishCount ?>';
    var applyItemCount = '<?php echo $applyItemCount ?>';
    $(document).ready(function () {
        //---------- raw product modal ------------------//
        var rawProductTable = $('#rawProduct-datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "bDestroy": true,
            "ajax": '<?php echo base_url() ?>RawProduct/getProductForStockEntry',
            "deferRender": true,
            "paging": true,
            "dom": "<'row'<'col-sm-12 col-md-12 col-xs-12'l><'col-sm-12 col-md-12 col-xs-12'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'i><'col-sm-12'p>>",
            "aaSorting": [],
            "iDisplayLength": 5,
            "bLengthChange": false,
            'columns': [
                {data: 'product_details'},
                {data: 'product_title'},
                {data: 'product_code'},
                {data: 'avg_purchase_rate'}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": true
                },
                {
                    "targets": [1],
                    "visible": false
                },
                {
                    "targets": [2],
                    "visible": false
                },
                {
                    "targets": [3],
                    "visible": false
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            }

        });
        $('#rawProduct-datatable tbody').on('click', 'tr', function () {
            var data = rawProductTable.row(this).data();
            setRawProduct(data.product_code, data.product_title, data.avg_purchase_rate);
        });

        //---------- finish good modal ------------------//
        var finishGoodTable = $('#finishedGoods-datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "bDestroy": true,
            "ajax": '<?php echo base_url() ?>Formulation/getFinishGoodForFormulation',
            "deferRender": true,
            "paging": true,
            "dom": "<'row'<'col-sm-12 col-md-12 col-xs-12'l><'col-sm-12 col-md-12 col-xs-12'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'i><'col-sm-12'p>>",
            "aaSorting": [],
            "iDisplayLength": 5,
            "bLengthChange": false,
            'columns': [
                {data: 'finish_good_details'},
                {data: 'finish_good_title'},
                {data: 'finish_good_code'},
                {data: 'pack_size'}
            ],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": true
                },
                {
                    "targets": [1],
                    "visible": false
                },
                {
                    "targets": [2],
                    "visible": false
                },
                {
                    "targets": [3],
                    "visible": false
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            }

        });
        $('#finishedGoods-datatable tbody').on('click', 'tr', function () {
            var data = finishGoodTable.row(this).data();
            setFinishGoods(data.finish_good_code, data.finish_good_title, data.pack_size);
        });
    });

    function setFinishGoods(productCode, productTitle, packSize) {
        showLoader();
        $.ajax({
            type: 'POST',
            data: {productCode: productCode},
            url: BASE_URL + 'Formulation/getRawProductForFinishGood',
            success: function (result) {
                hideLoader();
                var resultObj = jQuery.parseJSON(result);
                var responseFlag = resultObj.response;
                $("#rawProductForFinishGoodTable").find("tr:gt(1)").remove();
                if (responseFlag === 2 || responseFlag === 3) {
                    sweetAlert('There is no formula of this product');
                    $('#rawProductForFinishGoodTable').append("<tr><td colspan='6'>No Product</td></tr>");
                    return false;
                }

                var rawProduct;
                var rawProductName;
                var categoryName;
                var quantity;
                var rate;
                var rawProductHtml = "";
                var amount;
                for (var i = 0; i < resultObj.data.length; i++) {
                    rawProduct = resultObj.data[i].raw_product;
                    rawProductName = resultObj.data[i].product_name;
                    categoryName = resultObj.data[i].category_name;
                    quantity = resultObj.data[i].quantity;
                    rate = resultObj.data[i].avg_purchase_rate;
                    amount = parseFloat(quantity) * parseFloat(rate);
                    rawProductHtml += '<tr id="rawForFinishTr' + rawProductForFinishCount + '">\n\
                                        <td>' + rawProduct + '</td>\n\
                                        <td>' + rawProductName + '</td>\n\
                                        <td>' + categoryName + '</td>\n\
                                        <td>' + quantity + '</td>\n\
                                        <td>' + rate + '</td>\n\
                                        <td>' + amount + '</td>\n\
                                        <input type="hidden" id="fomulationRawProduct' + rawProductForFinishCount + '" name="fomulationRawProduct' + rawProductForFinishCount + '"  value="' + rawProduct + '">\n\
                                        <input type="hidden" id="formualtionRawRate' + rawProductForFinishCount + '" name="formualtionRawRate' + rawProductForFinishCount + '"  value="' + rate + '">\n\
                                        <input type="hidden" id="formulationRawQuantity' + rawProductForFinishCount + '" name="formulationRawQuantity' + rawProductForFinishCount + '"  value="' + quantity + '">\n\
                                        <input type="hidden" id="formulationRawAmount' + rawProductForFinishCount + '" name="formulationRawAmount' + rawProductForFinishCount + '"  value="' + amount + '">\n\
                                  </tr>';
                    rawProductForFinishCount++;
                }
                $('#finishProductCode').val(productCode);
                $('#finishGoodsDetails').val(productTitle);
                $('#packSize').val(packSize);

                $('#rawProductForFinishGoodTable').append(rawProductHtml);
                $('#finishGoods-modal').modal('hide');
                allCalculation();
            }
        });
    }

    function setRawProduct(productCode, rawProductTitle, avgPurchaseRate) {
        var packegingRaw;
        for (var i = 1; i <= applyItemCount; i++) {
            packegingRaw = $('#product' + i).val();
            if (typeof packegingRaw !== "undefined") {
                if (productCode === packegingRaw) {
                    sweetAlert('You have already taken this product');
                    return false;
                }
            }
        }
        $('#rawProductCode').val(productCode);
        $('#rawProductDetails').val(rawProductTitle);
        $('#rate').val(avgPurchaseRate);
        $('#rawProduct-modal').modal('hide');
        calculateTotalAmountPerItem();
    }

    function showRawProductEntryModal() {
        $('#rawProductDetails').val('');
        $('#rawProductCode').val('');
        $('#quantity').val('');
        $('#rate').val('');
        $('#amount').val('');

        $("#productReqError").attr('class', 'hidden text-danger');
        $("#quantityReqError").attr('class', 'hidden text-danger');
        $("#rateReqError").attr('class', 'hidden text-danger');

        $("#raw-product-entry-modal").modal('show');
    }

    function applyItems() {
        var fieldsArr = new Array("rawProductCode|productReqError", "quantity|quantityReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }

        var rawProductCode = $.trim($('#rawProductCode').val());
        var rawProductDetails = $.trim($('#rawProductDetails').val());
        var quantity = $.trim($('#quantity').val());
        var rate = $.trim($('#rate').val());
        var amount = $.trim($('#amount').val());

        var itemDetailsStr = '<tr id="itemDetailsTr' + applyItemCount + '">\n\
                                    <td>' + rawProductDetails + '</td>\n\
                                    <td>' + quantity + '</td>\n\
                                    <td>' + rate + '</td>\n\
                                    <td>' + amount + '</td>\n\
                                    <td><span class="text-danger pointer" onclick="removeItem(' + applyItemCount + ')"><i class="fa fa-remove"></i></span></td>\n\
                                    <input type="hidden" id="product' + applyItemCount + '" name="product' + applyItemCount + '"  value="' + rawProductCode + '">\n\
                                    <input type="hidden" id="rate' + applyItemCount + '" name="rate' + applyItemCount + '"  value="' + rate + '">\n\
                                    <input type="hidden" id="quantity' + applyItemCount + '" name="quantity' + applyItemCount + '"  value="' + quantity + '">\n\
                                    <input type="hidden" id="amount' + applyItemCount + '" name="amount' + applyItemCount + '"  value="' + amount + '">\n\
                                  </tr>';

        if (itemDetailsStr === "") {
            itemDetailsStr = "<tr id='noItemTr'><td colspan='5'>No Product Has Been Taken</td></tr>";
        }
        $('#noItemTr').remove();
        $('#itemDetailsTable').append(itemDetailsStr);
        applyItemCount++;
        allCalculation();
        $('#raw-product-entry-modal').modal('hide');
    }

    function removeItem(itemNumber) {
        $('#itemDetailsTr' + itemNumber).remove();
        allCalculation();
        var amount = "";
        var flag = 0;
        for (var i = 1; i <= applyItemCount; i++) {
            amount = $('#amount' + i).val();
            if (typeof amount !== "undefined") {
                flag = 1;
            }
        }
        if (flag === 0) {
            var itemDetailsStr = "<tr id='noItemTr'><td colspan='5'>No Product Has Been Taken</td></tr>";
            $('#itemDetailsTable').append(itemDetailsStr);
        }
    }

    function calculateTotalAmountPerItem() {
        var quantity = $.trim($('#quantity').val());
        if (!$.isNumeric(quantity)) {
            quantity = 0;
            $('#quantity').val('');
        }
        if (quantity < 0) {
            quantity = 0;
            $('#quantity').val('');
        }
        var rate = $.trim($('#rate').val());
        if (!$.isNumeric(rate)) {
            rate = 0;
            $('#rate').val('');
        }
        if (rate < 0) {
            rate = 0;
            $('#rate').val('');
        }
        var amount = parseFloat(rate) * parseFloat(quantity);
        $('#amount').val(amount);
    }

    function allCalculation() {

        var finishGoodQuantity = $.trim($('#finishGoodQuantity').val());
        if (!$.isNumeric(finishGoodQuantity)) {
            finishGoodQuantity = 0;
            $('#finishGoodQuantity').val('');
        }
        if (finishGoodQuantity < 0) {
            finishGoodQuantity = 0;
            $('#finishGoodQuantity').val('');
        }
        if (finishGoodQuantity === "") {
            finishGoodQuantity = 0;
        }
        // amount
        var amount;
        var totalExtraAmount = 0;
        for (var i = 1; i <= applyItemCount; i++) {
            amount = $('#amount' + i).val();
            if (typeof amount !== "undefined") {
                totalExtraAmount = totalExtraAmount + parseFloat(amount);
            }
        }
        var formulationCost = 0;
        for (var i = 1; i <= rawProductForFinishCount; i++) {
            amount = $('#formulationRawAmount' + i).val();
            if (typeof amount !== "undefined") {
                formulationCost = formulationCost + parseFloat(amount);
            }
        }
        formulationCost = formulationCost * finishGoodQuantity;
        var totalCost = formulationCost + totalExtraAmount;
        var perUnitPurchaseCost = 0;

        if (totalCost !== 0 && finishGoodQuantity !== 0) {
            perUnitPurchaseCost = totalCost / finishGoodQuantity;
        }

        $('#extraCost').text(totalExtraAmount);
        $('#formulationCost').text(formulationCost);
        $('#total').text(totalCost);
        $('#perUnitPurchaseCost').text(perUnitPurchaseCost);
    }

    function newMixing() {
        var fieldsArr = new Array("mixingDate|mixingDateReqError", "finishProductCode|finishProductCodeReqError", "finishGoodQuantity|finishGoodQuantityReqError", "batchNo|batchNoReqError", "manufactureDate|manufactureDateReqError", "expiryDate|expiryDateReqError", "year|yearReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false;
        }

        var amount = "";
        var flag = 0;
        for (var i = 1; i <= rawProductForFinishCount; i++) {
            amount = $('#formulationRawAmount' + i).val();
            if (typeof amount !== "undefined") {
                flag = 1;
            }
        }
        if (flag === 0) {
            sweetAlert('There is no raw product of this finish goods');
            return false;
        }

        var formilationRaw;
        for (var i = 1; i <= rawProductForFinishCount; i++) {
            formilationRaw = $('#fomulationRawProduct' + i).val();
            if (typeof formilationRaw !== "undefined") {
                $("#rawForFinishTr" + i).removeClass("bg-danger");
                $("#rawForFinishTr" + i).addClass("bg-white");
            }
        }
        $('#rawProductQuantityError').text('');

        var packegingRaw;
        for (var i = 1; i <= applyItemCount; i++) {
            packegingRaw = $('#product' + i).val();
            if (typeof packegingRaw !== "undefined") {
                $("#itemDetailsTr" + i).removeClass("bg-danger");
                $("#itemDetailsTr" + i).addClass("bg-white");
            }
        }
        $('#packegingRawProductError').text('');

        var product = "";
        var quantity = "";
        var packegingRawMaterial = new Array();
        for (var i = 1; i <= applyItemCount; i++) {
            product = $('#product' + i).val();
            if (typeof product !== "undefined") {
                quantity = $('#quantity' + i).val();
                packegingRawMaterial.push(product + ',' + quantity);
            }
        }
        var packegingRawMaterialStr = "";
        if (packegingRawMaterial.length > 0) {
            packegingRawMaterialStr = packegingRawMaterial.join('|');
        }
        //console.log(packegingRawMaterialStr);

        var title = "Are you sure to save?";
        swal({
            title: title,
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, Sure !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            showLoader();
            $.ajax({
                type: 'POST',
                data: {finishProductCode: $('#finishProductCode').val(), quantity: $('#finishGoodQuantity').val(), packegingRawMaterialStr: packegingRawMaterialStr},
                url: BASE_URL + 'Formulation/checkMixingAmount',
                success: function (result) {
                    hideLoader();

                    var resultObj = jQuery.parseJSON(result);
                    var responseFlag = resultObj.response;
                    if (responseFlag === 1) {
                        $('#applyItemCount').val(applyItemCount);
                        $('#rawProductForFinishCount').val(rawProductForFinishCount);
                        $('#mixingForm').submit();
                    } else if (responseFlag === 2) {

                        for (var i = 1; i <= rawProductForFinishCount; i++) {
                            amount = $('#formulationRawAmount' + i).val();
                            if (typeof amount !== "undefined") {
                                $("#rawForFinishTr" + i).addClass("bg-danger");
                            }
                            $('#rawProductQuantityError').text('*** There is not enough quantity of these products');

                        }
                    } else if (responseFlag === 3) {
                        var rawProductDb;
                        var formilationRaw;
                        flag = 0;
                        for (var i = 0; i < resultObj.lowQuantityArr.length; i++) {
                            flag = 1;
                            rawProductDb = resultObj.lowQuantityArr[i].rawProduct;
                            for (var j = 1; j <= rawProductForFinishCount; j++) {
                                formilationRaw = $('#fomulationRawProduct' + j).val();
                                if (typeof formilationRaw !== "undefined") {
                                    if (rawProductDb === formilationRaw) {
                                        $("#rawForFinishTr" + j).removeClass("bg-white");
                                        $("#rawForFinishTr" + j).addClass("bg-danger");
                                    }
                                }
                            }
                        }
                        if (flag === 1) {
                            $('#rawProductQuantityError').text('*** There is not enough quantity of these products');
                        }
                    } else if (responseFlag === 4) {
                        $('#rawProductQuantityError').text('*** You do not make stock entry of formulation raw products yet');
                    } else if (responseFlag === 5) {
                        $('#packegingRawProductError').text('*** You do not make stock entry of packeging raw products yet');
                    } else if (responseFlag === 6) {
                        var rawProductDb;
                        var packegingRaw;

                        flag = 0;
                        for (var i = 0; i < resultObj.lowQuantityArr.length; i++) {
                            flag = 1;
                            rawProductDb = resultObj.lowQuantityArr[i].product;
                            for (var j = 1; j <= applyItemCount; j++) {
                                packegingRaw = $('#product' + j).val();
                                if (typeof packegingRaw !== "undefined") {
                                    if (rawProductDb === packegingRaw) {
                                        $("#itemDetailsTr" + j).removeClass("bg-white");
                                        $("#itemDetailsTr" + j).addClass("bg-danger");
                                    }
                                }
                            }
                        }
                        if (flag === 1) {
                            $('#packegingRawProductError').text('*** There is not enough quantity of these products');
                        }
                    }
                }
            });
        });
    }


    function setExpiryDate() {
        var manufactureDate = $('#manufactureDate').val();
        var year = $('#year').val();

        if (manufactureDate === "" || year === "") {
            $('#expiryDate').val('');
            return false;
        }

        showLoader();
        $.ajax({
            type: 'POST',
            data: {manufactureDate: manufactureDate, year: year},
            url: BASE_URL + 'Formulation/setExpiryDate',
            success: function (result) {
                hideLoader();
                $('#expiryDate').val(result);
            }
        });

    }
</script>