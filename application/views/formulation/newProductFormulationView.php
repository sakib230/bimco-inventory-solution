<link href="<?php echo base_url() ?>assets/css/listing_datatable.css" rel="stylesheet">
<script>
    function showRawProduct() {
        $("#rawProduct-modal").modal('show');
    }
    function showFinishGoods() {
        $("#finishGoods-modal").modal('show');
    }
</script>

<div class="col-md-12 col-sm-12 col-xs-12 p-t-20">
    <form id="formulaForm" class="form-horizontal" action="<?php echo base_url() ?>Formulation/addFormula" method="post">
        <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" >Finished Good <span class="danger">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                        <input type="text" id="finishGoodsDetails" class="form-control" readonly>
                        <input type="hidden" id="finishProductCode" name="finishProductCode" class="form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-warning" onclick="showFinishGoods()"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2 col-sm-3 col-xs-12" >Pack Size</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="packSize" class="form-control col-md-7 col-xs-12" readonly="">
                </div>
            </div>
            <hr>
        </div>
        <div class="row">
            <div class="table-custom-responsive">
                <table id="itemDetailsTable" class="table table-bordered custom-table">
                    <tr class="bg-gray">
                        <th style="width:10%!important">Raw Product ID</th>
                        <th style="width:10%!important">Raw Product Name</th>
                        <th style="width:10%!important">Category</th>
                        <th style="width:10%!important">Quantity</th>
                        <th style="width:10%!important"></th>
                    </tr>
                    <tr id="noItemTr">
                        <td colspan="5">No product has been taken</td>
                    </tr>
                </table>
                <span class="pointer template-green" onclick="showRawProductEntryModal()"><i class="fa fa-plus"></i> Entry Raw Product</span>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-success btn-sm" onclick="newFormulation()"><i class="fa fa-check"></i> Save</button>
                    <a href="<?php echo base_url() ?>Formulation/productFormulation" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
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
                <h4 class="modal-title" id="myModalLabel">Entry Raw Product</h4>
            </div>
            <div class="modal-body">
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
                            <label class="control-label" >Category</label>
                            <input type="text" id="categoryName" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label" >Quantity <span class="text-danger">*</span></label><span id="quantityReqError" class="text-danger hidden"><small>Required</small></span>
                        <input type="text" min="0" class="form-control" id="quantity" onchange="calculateTotalAmountPerItem()" onkeyup="calculateTotalAmountPerItem()">
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
    $('#finishGoodsDetails').val('');
    $('#packSize').val('');
    var selectedItemCount = 1;
    var applyItemCount = 1;
    $(document).ready(function () {
        //---------- raw product modal ------------------//
        var rawProductTable = $('#rawProduct-datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "bDestroy": true,
            "ajax": '<?php echo base_url() ?>Formulation/getRawProductForFormulation',
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
                {data: 'avg_purchase_rate'},
                {data: 'category_name'}
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
                },
                {
                    "targets": [4],
                    "visible": false
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            }

        });
        $('#rawProduct-datatable tbody').on('click', 'tr', function () {
            var data = rawProductTable.row(this).data();
            setRawProduct(data.product_code, data.product_title, data.avg_purchase_rate, data.category_name);
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

    function setRawProduct(productCode, rawProductTitle, avgPurchaseRate, categoryName) {
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
        $('#categoryName').val(categoryName);

        $('#rawProduct-modal').modal('hide');
    }

    function setFinishGoods(productCode, productTitle, packSize) {
        $('#finishProductCode').val(productCode);
        $('#finishGoodsDetails').val(productTitle);
        $('#packSize').val(packSize);
        $('#finishGoods-modal').modal('hide');
    }

    function showRawProductEntryModal() {
        $('#rawProductDetails').val('');
        $('#rawProductCode').val('');
        $('#categoryName').val('');
        $('#quantity').val('');

        $("#productReqError").attr('class', 'hidden text-danger');
        $("#quantityReqError").attr('class', 'hidden text-danger');

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
        var categoryName = $.trim($('#categoryName').val());

        var quantity = $.trim($('#quantity').val());

        var itemDetailsStr = '<tr id="itemDetailsTr' + applyItemCount + '">\n\
                                    <td>' + rawProductCode + '</td>\n\
                                    <td>' + rawProductDetails + '</td>\n\
                                    <td>' + categoryName + '</td>\n\
                                    <td>' + quantity + '</td>\n\
                                    <td><span class="text-danger pointer" onclick="removeItem(' + applyItemCount + ')"><i class="fa fa-remove"></i></span></td>\n\
                                    <input type="hidden" id="product' + applyItemCount + '" name="product' + applyItemCount + '"  value="' + rawProductCode + '">\n\
                                    <input type="hidden" id="quantity' + applyItemCount + '" name="quantity' + applyItemCount + '"  value="' + quantity + '">\n\
                                  </tr>';

        if (itemDetailsStr === "") {
            itemDetailsStr = "<tr id='noItemTr'><td colspan='5'>No Product Has Been Taken</td></tr>";
        }
        $('#noItemTr').remove();
        $('#itemDetailsTable').append(itemDetailsStr);
        applyItemCount++;
        //allCalculation();
        $('#raw-product-entry-modal').modal('hide');
    }

    function removeItem(itemNumber) {
        $('#itemDetailsTr' + itemNumber).remove();
        //allCalculation();
        var product = "";
        var flag = 0;
        for (var i = 1; i <= applyItemCount; i++) {
            product = $('#product' + i).val();
            if (typeof product !== "undefined") {
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
    }

//    function allCalculation() {
//        // amount
//        var amount;
//        var totalAmount = 0;
//        for (var i = 1; i <= applyItemCount; i++) {
//            amount = $('#amount' + i).val();
//            if (typeof amount !== "undefined") {
//                totalAmount = totalAmount + parseFloat(amount);
//            }
//        }
//        $('#total').text(parseFloat(totalAmount).toFixed(2));
//    }



    function newFormulation() {
        var finishProductCode = $.trim($('#finishProductCode').val());

        if (finishProductCode === "") {
            sweetAlert('Finish Good is required');
            return false;
        }
        var product = "";
        var flag = 0;
        for (var i = 1; i <= applyItemCount; i++) {
            product = $('#product' + i).val();
            if (typeof product !== "undefined") {
                flag = 1;
            }
        }

        if (flag === 0) {
            sweetAlert('Please take at least one raw product');
            return false;
        }

        var title = "Do you want to create a new formula?";

        swal({
            title: title,
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, I Do !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            $('#applyItemCount').val(applyItemCount);
            $('#formulaForm').submit();
//            showLoader();
//            $.ajax({
//                type: 'POST',
//                data: {finishProduct: finishProductCode, addEditFlag: 'add'},
//                url: BASE_URL + 'Formulation/formulaDuplicateCheck',
//                success: function (result) {
//                    
////                    return false;
//                    hideLoader();
//                    if (result === '1') {
//                        $('#applyItemCount').val(applyItemCount);
//                        $('#formulaForm').submit();
//                    } else if (result === '2') {
//                        console.log(result);
//                        sweetAlert('You have already made a formula for this Finish Goods');
//                       
//                    }
//                }
//            });

        });
    }
</script>