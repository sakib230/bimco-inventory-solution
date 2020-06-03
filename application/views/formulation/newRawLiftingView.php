<link href="<?php echo base_url() ?>assets/css/listing_datatable.css" rel="stylesheet">
<script>
    function showRawProduct() {
        $("#rawProduct-modal").modal('show');
    }
</script>

<div class="col-md-12 col-sm-12 col-xs-12 p-t-20">
    <form id="rawLiftingForm" class="form-horizontal" action="<?php echo base_url() ?>Formulation/addExtraRawLifting" method="post">

        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-3 col-xs-12" >Date <span class="danger">*</span></label>
                        <div class="col-md-7 col-sm-6 col-xs-12">
                            <div class="input-group dateTxt">
                                <input type="text" name="liftingDate" id="liftingDate" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>

                            </div>
                            <span id="liftingDateReqError" class="text-danger hidden"><small>Please provide a date</small></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <hr>
            <div class="table-custom-responsive">
                <table id="itemDetailsTable" class="table table-bordered custom-table">
                    <tr class="bg-gray">
                        <th style="width:10%!important">Raw Product</th>
                        <th style="width:10%!important">Quantity</th>
                        <th style="width:10%!important">Rate <br>(BDT)</th>
                        <th style="width:10%!important">Amount <br>(BDT)</th>
                        <th style="width:10%!important"></th>
                    </tr>
                    <tr id="noItemTr">
                        <td colspan="5">No product has been taken</td>
                    </tr>
                </table>
                <span class="pointer template-green" onclick="showRawProductEntryModal()"><i class="fa fa-plus"></i> Add Extra Product</span>
            </div>
            <div id="rawProductError" class="text-danger"></div>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-7 col-sm-offset-7">
                <span><b>Total Cost (BDT)</b></span>
                <span class="float-right" id="total"></span>
            </div>
        </div>


        <div class="row">
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-success btn-sm" onclick="newLifting()"><i class="fa fa-check"></i> Save</button>
                    <a href="<?php echo base_url() ?>Formulation/newRawLifting" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
                </div>
            </div>
        </div>
        <input type="hidden" id="applyItemCount" name="applyItemCount">

    </form>
</div>

<!-- ---------- Entry Raw Product Modal ------------- -->
<div class="modal fade" id="raw-product-entry-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Raw Product</h4>
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

<script>
    //$('#finishGoodsDetails').val('');
    //$('#packSize').val('');
    //var selectedItemCount = 1;

    var applyItemCount = 1;
    $(document).ready(function () {  // done
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

    });

    function setRawProduct(productCode, rawProductTitle, avgPurchaseRate) {  // done
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

    function showRawProductEntryModal() {  // done
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

    function applyItems() {  // done
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

    function removeItem(itemNumber) {  // done
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

    function calculateTotalAmountPerItem() {  // done
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

    function allCalculation() {  // done
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

    function newLifting() {
        var fieldsArr = new Array("liftingDate|liftingDateReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false;
        }
        var flag = 0;
        var product = "";
        var quantity = "";
        var rawMaterial = new Array();
        for (var i = 1; i <= applyItemCount; i++) {
            product = $('#product' + i).val();
            if (typeof product !== "undefined") {
                flag = 1;
                $("#itemDetailsTr" + i).removeClass("bg-danger");
                $("#itemDetailsTr" + i).addClass("bg-white");

                quantity = $('#quantity' + i).val();
                rawMaterial.push(product + ',' + quantity);
            }
        }
        if (flag === 0) {
            sweetAlert('Please select a raw product');
            return false;
        }
        $('#rawProductError').text('');

        var rawMaterialStr = rawMaterial.join('|');

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
                data: {rawMaterialStr: rawMaterialStr},
                url: BASE_URL + 'Formulation/checkRawLiftingAmount',
                success: function (result) {
                    hideLoader();
                    var resultObj = jQuery.parseJSON(result);
                    var responseFlag = resultObj.response;
                    if (responseFlag === 1) {
                        $('#applyItemCount').val(applyItemCount);
                        $('#rawLiftingForm').submit();
                    } else if (responseFlag === 5) {
                        $('#rawProductError').text('*** You do not make stock entry of raw products yet');
                    } else if (responseFlag === 6) {
                        var rawProductDb;
                        var rawProductCode;

                        flag = 0;
                        for (var i = 0; i < resultObj.lowQuantityArr.length; i++) {
                            flag = 1;
                            rawProductDb = resultObj.lowQuantityArr[i].product;
                            for (var j = 1; j <= applyItemCount; j++) {
                                rawProductCode = $('#product' + j).val();
                                if (typeof rawProductCode !== "undefined") {
                                    if (rawProductDb === rawProductCode) {
                                        $("#itemDetailsTr" + j).removeClass("bg-white");
                                        $("#itemDetailsTr" + j).addClass("bg-danger");
                                    }
                                }
                            }
                        }
                        if (flag === 1) {
                            $('#rawProductError').text('*** There is not enough quantity of these products');
                        }
                    }
                }
            });
        });
    }
</script>
