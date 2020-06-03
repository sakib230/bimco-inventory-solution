<link href="<?php echo base_url() ?>assets/css/listing_datatable.css" rel="stylesheet">
<script>
    function showRawProduct() {
        $("#rawProduct-modal").modal('show');
    }
    function showVendor() {
        $("#vendor-modal").modal('show');
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <?php if (checkPermittedAction(RAW_STOCK_ADD)) { ?>
            <a href="<?php echo base_url() ?>RawProduct/newStock" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Stock</a>
        <?php } ?>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 p-t-20">
    <form id="stockEntryForm" class="form-horizontal" action="<?php echo base_url() ?>RawProduct/editRawProductStock" method="post">

        <div class="row">

            <div class="form-group">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" >Date <span class="danger">*</span></label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="input-group dateTxt">
                        <input type="text" name="stockDate" id="stockDate" value="<?php echo $stockSummary[0]['stock_date'] ?>" class="form-control">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="table-custom-responsive">
                <table id="itemDetailsTable" class="table table-bordered custom-table">
                    <tr class="bg-gray">
                        <th style="width:10%!important">Vendor</th>
                        <th style="width:10%!important">Raw Product</th>
                        <th style="width:10%!important">Avg Rate <br>(BDT)</th>
                        <th style="width:10%!important">Particulars</th>
                        <th style="width:10%!important">Quantity</th>
                        <th style="width:10%!important">Rate <br>(BDT)</th>
                        <th style="width:10%!important">Amount <br>(BDT)</th>
                        <th style="width:10%!important"></th>
                    </tr>
                    <?php
                    $applyItemCount = 1;
                    foreach ($stockDetails as $stockDetail) {
                        echo '<tr id="itemDetailsTr' . $applyItemCount . '">
                                    <td>' . $stockDetail['vendor_name'] . ' (' . $stockDetail['vendor'] . ')</td>
                                    <td>' . $stockDetail['product_name'] . ' (' . $stockDetail['product'] . ')</td>
                                    <td>' . $stockDetail['avg_purchase_rate'] . '</td>
                                    <td>' . $stockDetail['particulars'] . '</td>
                                    <td>' . $stockDetail['stock_in_quantity'] . '</td>
                                    <td>' . $stockDetail['rate'] . '</td>
                                    <td>' . $stockDetail['amount'] . '</td>
                                    <td><span class="text-danger pointer" onclick="removeItem(' . $applyItemCount . ')"><i class="fa fa-remove"></i></span></td>
                                    <input type="hidden" id="vendor' . $applyItemCount . '" name="vendor' . $applyItemCount . '"  value="' . $stockDetail['vendor'] . '">
                                    <input type="hidden" id="product' . $applyItemCount . '" name="product' . $applyItemCount . '"  value="' . $stockDetail['product'] . '">
                                    <input type="hidden" id="avgPurchaseRate' . $applyItemCount . '" name="avgPurchaseRate' . $applyItemCount . '"  value="' . $stockDetail['avg_purchase_rate'] . '">
                                    <input type="hidden" id="particulars' . $applyItemCount . '" name="particulars' . $applyItemCount . '"  value="' . $stockDetail['particulars'] . '">
                                    <input type="hidden" id="rate' . $applyItemCount . '" name="rate' . $applyItemCount . '"  value="' . $stockDetail['rate'] . '">
                                    <input type="hidden" id="quantity' . $applyItemCount . '" name="quantity' . $applyItemCount . '"  value="' . $stockDetail['stock_in_quantity'] . '">
                                    <input type="hidden" id="amount' . $applyItemCount . '" name="amount' . $applyItemCount . '"  value="' . $stockDetail['amount'] . '">
                                  </tr>';
                        $applyItemCount++;
                    }
                    ?>
<!--                    <tr id="noItemTr">
    <td colspan="8">No product has been taken</td>
</tr>-->
                </table>
                <span class="pointer template-green" onclick="showRawProductEntryModal()"><i class="fa fa-plus"></i> Entry Raw Product</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-7 col-sm-offset-7">
                <span><b>Total Amount (BDT)</b></span>
                <span class="float-right" id="total"></span>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>

        <div class="row">
            <!--<div class="">-->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="control-label"> Description</label>
                    <textarea class="form-control" name="description" rows="5" style="resize: none"><?php echo $stockSummary[0]['description'] ?></textarea>
                </div>
            </div>

            <!--</div>-->
        </div>
        <div class="row">
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-success btn-sm" onclick="editStock()"><i class="fa fa-check"></i> Save</button>
                    <a href="<?php echo base_url() ?>RawProduct/stockEntry" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
                </div>
            </div>
        </div>
        <input type="hidden" id="applyItemCount" name="applyItemCount">
        <input type="hidden" name="stockCode" value="<?php echo $stockSummary[0]['stock_code'] ?>">
        <input type="hidden" name="updatedDtTmHidden" value="<?php echo $stockSummary[0]['updated_dt_tm'] ?>">
    </form>
</div>

<!-- ---------- Entry Raw Product Modal ------------- -->
<div class="modal fade" id="raw-product-entry-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Entry Raw Product</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label" > Vendor<span class="danger">*</span></label> <span id="vendorReqError" class="text-danger hidden"><small>Required</small></span>
                            <div class="input-group">
                                <input type="text" id="vendorDetails" class="form-control" readonly>
                                <input type="hidden" id="vendorCode" class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-warning" onclick="showVendor()"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label class="control-label" >Raw Product <span class="danger">*</span></label> <span id="productReqError" class="text-danger hidden"><small>Required</small></span>
                            <div class="input-group">
                                <input type="text" id="rawProductDetails" class="form-control" readonly>
                                <input type="hidden" id="rawProductCode" class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-warning" onclick="showRawProduct()"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <label class="control-label" >Average Purchase Rate (BDT)</label>
                            <input type="text" id="avgPurchaseRate" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" >Particulars</label>
                            <input type="text" max="300" class="form-control" id="particulars">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label" >Quantity <span class="text-danger">*</span></label><span id="quantityReqError" class="text-danger hidden"><small>Required</small></span>
                        <input type="text" min="0" class="form-control" id="quantity" onchange="calculateTotalAmountPerItem()" onkeyup="calculateTotalAmountPerItem()">
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" >Rate <small><i> (BDT)</i></small> <span class="text-danger">*</span></label><span id="rateReqError" class="text-danger hidden"><small>Required</small></span>
                            <input type="text" class="form-control" id="rate" onchange="calculateTotalAmountPerItem()" onkeyup="calculateTotalAmountPerItem()">
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

<!-- ---------- Vendor Modal ------------- -->
<div class="modal fade" id="vendor-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel2">Vendor</h4>
            </div>
            <div class="modal-body">
                <div class="table-custom-responsive">
                    <table class="table table-hover table-striped custom-table" id="vendor-datatable">
                        <thead class="hidden">
                            <tr>
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
<!-- ---------- end vendor Modal ------------- -->
<script>
    var selectedItemCount = 1;
    var applyItemCount = '<?php echo count($stockDetails) ?>';
    applyItemCount++;
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

        //---------- vendor modal ------------------//
        var vendorTable = $('#vendor-datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "bDestroy": true,
            "ajax": '<?php echo base_url() ?>RawProduct/getVendorForStockEntry',
            "deferRender": true,
            "paging": true,
            "dom": "<'row'<'col-sm-12 col-md-12 col-xs-12'l><'col-sm-12 col-md-12 col-xs-12'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'i><'col-sm-12'p>>",
            "aaSorting": [],
            "iDisplayLength": 5,
            "bLengthChange": false,
            'columns': [
                {data: 'vendor_details'},
                {data: 'vendor_title'},
                {data: 'vendor_code'}
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
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            }

        });
        $('#vendor-datatable tbody').on('click', 'tr', function () {
            var data = vendorTable.row(this).data();
            setVendor(data.vendor_code, data.vendor_title);
        });
    });

    function setRawProduct(productCode, rawProductTitle, avgPurchaseRate) {
        var rawProduct;
        for (var i = 1; i <= applyItemCount; i++) {
            rawProduct = $('#product' + i).val();
            if (typeof rawProduct !== "undefined") {
                if (productCode === rawProduct) {
                    sweetAlert('You have already taken this product');
                    return false;
                }
            }
        }
        $('#rawProductCode').val(productCode);
        $('#rawProductDetails').val(rawProductTitle);
        $('#avgPurchaseRate').val(avgPurchaseRate);
        $('#rawProduct-modal').modal('hide');
    }

    function setVendor(vendorCode, vendorTitle) {
        $('#vendorCode').val(vendorCode);
        $('#vendorDetails').val(vendorTitle);
        $('#vendor-modal').modal('hide');
    }

    function showRawProductEntryModal() {
        $('#vendorDetails').val('');
        $('#vendorCode').val('');
        $('#rawProductDetails').val('');
        $('#rawProductCode').val('');
        $('#avgPurchaseRate').val('');
        $('#particulars').val('');
        $('#quantity').val('');
        $('#rate').val('');
        $('#amount').val('');

        $("#vendorReqError").attr('class', 'hidden text-danger');
        $("#productReqError").attr('class', 'hidden text-danger');
        $("#quantityReqError").attr('class', 'hidden text-danger');
        $("#rateReqError").attr('class', 'hidden text-danger');

        $("#raw-product-entry-modal").modal('show');
    }

    function applyItems() {
        var fieldsArr = new Array("vendorCode|vendorReqError", "rawProductCode|productReqError", "quantity|quantityReqError", "rate|rateReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }
        var vendorCode = $.trim($('#vendorCode').val());
        var vendorDetails = $.trim($('#vendorDetails').val());
        var rawProductCode = $.trim($('#rawProductCode').val());
        var rawProductDetails = $.trim($('#rawProductDetails').val());
        var avgPurchaseRate = $.trim($('#avgPurchaseRate').val());
        var particulars = $.trim($('#particulars').val());
        var quantity = $.trim($('#quantity').val());
        var rate = $.trim($('#rate').val());
        var amount = $.trim($('#amount').val());

        var itemDetailsStr = '<tr id="itemDetailsTr' + applyItemCount + '">\n\
                                    <td>' + vendorDetails + '</td>\n\
                                    <td>' + rawProductDetails + '</td>\n\
                                    <td>' + avgPurchaseRate + '</td>\n\
                                    <td>' + particulars + '</td>\n\
                                    <td>' + quantity + '</td>\n\
                                    <td>' + rate + '</td>\n\
                                    <td>' + amount + '</td>\n\
                                    <td><span class="text-danger pointer" onclick="removeItem(' + applyItemCount + ')"><i class="fa fa-remove"></i></span></td>\n\
                                    <input type="hidden" id="vendor' + applyItemCount + '" name="vendor' + applyItemCount + '"  value="' + vendorCode + '">\n\
                                    <input type="hidden" id="product' + applyItemCount + '" name="product' + applyItemCount + '"  value="' + rawProductCode + '">\n\
                                    <input type="hidden" id="avgPurchaseRate' + applyItemCount + '" name="avgPurchaseRate' + applyItemCount + '"  value="' + avgPurchaseRate + '">\n\
                                    <input type="hidden" id="particulars' + applyItemCount + '" name="particulars' + applyItemCount + '"  value="' + particulars + '">\n\
                                    <input type="hidden" id="rate' + applyItemCount + '" name="rate' + applyItemCount + '"  value="' + rate + '">\n\
                                    <input type="hidden" id="quantity' + applyItemCount + '" name="quantity' + applyItemCount + '"  value="' + quantity + '">\n\
                                    <input type="hidden" id="amount' + applyItemCount + '" name="amount' + applyItemCount + '"  value="' + amount + '">\n\
                                  </tr>';

        if (itemDetailsStr === "") {
            itemDetailsStr = "<tr id='noItemTr'><td colspan='8'>No Product Has Been Taken</td></tr>";
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
            var itemDetailsStr = "<tr id='noItemTr'><td colspan='8'>No Product Has Been Taken</td></tr>";
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
        // amount
        var amount;
        var totalAmount = 0;
        for (var i = 1; i <= applyItemCount; i++) {
            amount = $('#amount' + i).val();
            if (typeof amount !== "undefined") {
                totalAmount = totalAmount + parseFloat(amount);
            }
        }
        $('#total').text(totalAmount);
    }

    function editStock() {
        var stockDate = $.trim($('#stockDate').val());

        if (stockDate === "") {
            sweetAlert('Stock Date is required');
            return false;
        }
        var amount = "";
        var flag = 0;
        for (var i = 1; i <= applyItemCount; i++) {
            amount = $('#amount' + i).val();
            if (typeof amount !== "undefined") {
                flag = 1;
            }
        }
        if (flag === 0) {
            sweetAlert('Please take at least one raw product');
            return false;
        }
        var title = "Are you sure to save this Stock Entry?";
        swal({
            title: title,
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, Sure !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            $('#applyItemCount').val(applyItemCount);
            $('#stockEntryForm').submit();
        });
    }
</script>

<style>
    .selected-item-table tbody tr td{
        border-bottom:1px solid white!important;
        /*text-align: left!important;*/
    }
    .input-number{
        text-align: center;
    }
    .width-40{width: 40%!important}
    .width-20{width: 20%!important}
</style>
