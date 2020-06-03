<link href="<?php echo base_url() ?>assets/css/listing_datatable.css" rel="stylesheet">

<div class="col-md-12 col-sm-12 col-xs-12 hidden-lg hidden-md hidden-sm">
    <a href="javascript:void(0)" onclick="showCustomizeReportModal()"><i class="fa fa-cogs"></i> Customize Report</a><br><br>
    <div class="btn-group  btn-group-sm">
        <button class="btn btn-default" type="button" onclick="print()" id="printBtnSm"><i class="fa fa-print"></i></button>
    </div>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 hidden-xs">
    <div class="float-left m-t-5">
        <a href="javascript:void(0)" onclick="showCustomizeReportModal()"><i class="fa fa-cogs"></i> Customize Report</a>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 hidden-xs">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <button class="btn btn-default" type="button" onclick="print()" data-toggle="tooltip" data-placement="bottom" title="Print" id="printBtn" disabled><i class="fa fa-print font-15"></i></button>
        </div>

    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <hr>
    <div id="print">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="text-center">
                    <span class="font-18"><b><?php echo PROJECT_NAME ?></b></span><br>
                    <span class="font-20">Stock Out Report</span><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 m-t-30">
                <table class="table table-bordered custom-table" id="stockTable">
                    <tr>
                        <th class='td-center'>Date</th>
                        <th class='td-center'>Stock ID</th>
                        <th class='td-center'>Raw Product</th>
                        <th class='td-center'>Finished Goods</th>
                        <th class='td-center'>Vendor</th>
                        <th class='td-center'  style="width: 100px">Particular</th>
                        <th class='td-center'>Quantity</th>
                        <th class='td-center'>Rate<br><small><i class="text-muted">BDT</i></small></th>
                        <th class='td-center'>Amount<br><small><i class="text-muted">BDT</i></small></th>
                        <th class='td-center'>Type</th>
                    </tr>
                </table>

                <div id="showMoreProductDiv"></div>
                <div class="text-center"><h4 class="text-danger" id="noProductFound"></h4></div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="productCodeStr" value="<?php echo $productCodeStr ?>">
<!-- ---------- Customize Report Modal ------------- -->
<div class="modal fade" id="customize-report-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ddd">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel1">Customize Report</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="customizeForm" action="<?php echo base_url() ?>Reports/rawProductStockOut" method="post">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" >From Date <span class="danger">*</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-group dateTxt">
                                            <input type="text" name="fromDate" id="fromDate" value="<?php echo $fromDate ?>" class="form-control">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>

                                        </div>
                                        <span id="fromDateReqError" class="text-danger hidden"><small>Please provide from date</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" >To Date <span class="danger">*</span></label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-group dateTxt">
                                            <input type="text" name="toDate" id="toDate" value="<?php echo $toDate ?>" class="form-control">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>

                                        </div>
                                        <span id="toDateReqError" class="text-danger hidden"><small>Please provide to date</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
                            <b>Advance Filters</b>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12 m-t-10">

                            <table id="advanceFilterTable">
                                <tr id="advanceFilterTr1">
                                    <td class="p-b-15">
                                        <select id="filterType1" class="form-control" onchange="setFilterType('1')">
                                            <option value="1">Raw Product</option>
                                            <!--<option value="2">Customer</option>-->
                                        </select>
                                    </td>
                                    <td class="p-l-15 p-b-15" id="filterTypeElementTd1">
                                        <div class="input-group">
                                            <input type="text" id="productDetails1" placeholder="Raw Product" class="form-control" readonly>
                                            <input type="hidden" id="productCode1" name="productCode1">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-warning" onclick="showProduct('1')"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-l-15 p-b-15 font-18">
                                    </td>
                                </tr>
                            </table>
                            <input type="hidden" name="advanceFilterCount" id="advanceFilterCount">
                            <br>
                            <input type="hidden" id="filterTypeSerialHidden">
                            <span class="pointer template-green" onclick="showMoreFilter()"><i class="fa fa-plus"></i> Add More</span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" onclick="runReport()"><i class="fa fa-check"></i> Run Report</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
            </div>

        </div>
    </div>
</div>

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
    var advanceFilterCount = 2;
    var REPORT_MAX_WHERE_IN_ITEM = parseInt('<?php echo REPORT_MAX_WHERE_IN_ITEM ?>');
    $(document).ready(function () {
        //---------- raw product modal ------------------//
        var rawProductTable = $('#rawProduct-datatable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "bDestroy": true,
            "ajax": '<?php echo base_url() ?>Reports/getRawProductDataTable',
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

    function  setRawProduct(productCode, productTitle) {
        var filterTypeSerial = $('#filterTypeSerialHidden').val();
        $('#productCode' + filterTypeSerial).val(productCode);
        $('#productDetails' + filterTypeSerial).val(productTitle);
        $('#rawProduct-modal').modal('hide');
    }

    function showProduct(filterTypeSerial) {
        $('#filterTypeSerialHidden').val(filterTypeSerial);
        $("#rawProduct-modal").modal('show');
    }

    function showCustomizeReportModal() {
        $("#customize-report-modal").modal('show');
    }

    function showMoreFilter() {
        var moreFilterTr = '<tr class="p-b-10" id="advanceFilterTr' + advanceFilterCount + '">\n\
                                <td class="p-b-15">\n\
                                    <select id="filterType' + advanceFilterCount + '" class="form-control" onchange="setFilterType(' + advanceFilterCount + ')">\n\
                                        <option value="1">Raw Product</option>\n\
                                    </select>\n\
                                </td>\n\
                                <td class="p-l-15 p-b-15" id="filterTypeElementTd' + advanceFilterCount + '">\n\
                                    <input type="text" class="form-control" placeholder="Select Filter Type" readonly="">\n\
                                </td>\n\
                                <td class="p-l-15 p-b-15 font-18">\n\
                                    <i class="fa fa-minus-circle text-danger pointer" onclick="removeFilter(' + advanceFilterCount + ')"></i>\n\
                                </td>\n\
                            </tr>';
        $('#advanceFilterTable').append(moreFilterTr);
        setFilterType(advanceFilterCount);
        advanceFilterCount++;
    }

    function removeFilter(filterTypeSerial) {
        $('#advanceFilterTr' + filterTypeSerial).remove();
    }

    function setFilterType(filterTypeSerial) {
        var filterType = $('#filterType' + filterTypeSerial).val();
        var elementHtml = "";
        if (filterType === '1') {
            elementHtml = '<div class="input-group">\n\
                                <input type="text" id="productDetails' + filterTypeSerial + '" placeholder="Raw Product" class="form-control" readonly>\n\
                                <input type="hidden" id="productCode' + filterTypeSerial + '" name="productCode' + filterTypeSerial + '">\n\
                                <span class="input-group-btn">\n\
                                    <button type="button" class="btn btn-warning" onclick="showProduct(' + filterTypeSerial + ')"><i class="fa fa-search"></i></button>\n\
                                </span>\n\
                            </div>';
        } else {
            elementHtml = '<input type="text" class="form-control" placeholder="Select Filter Type" readonly="">';
        }

        $('#filterTypeElementTd' + filterTypeSerial).html(elementHtml);
    }


    function runReport() {
        var count = 1;
        var rawProduct;
        for (var i = 1; i <= advanceFilterCount; i++) {
            rawProduct = $('#productCode' + i).val();
            if (typeof rawProduct !== "undefined") {
                count++;
            }
        }
        count--;
        if (count > REPORT_MAX_WHERE_IN_ITEM) {
            sweetAlert('You can select max ' + REPORT_MAX_WHERE_IN_ITEM + ' product');
            return false;
        }

        $('#advanceFilterCount').val(advanceFilterCount);
        $('#customizeForm').submit();
    }


    var serial;
    var iterationNumber = 0;
    function getReportData() {
        serial = 0;
        iterationNumber = 0;
        loadData(1);
    }

    var getStockDataFlag = 1;
    function loadData(noProductflag) {
        if (getStockDataFlag === 0) {
            $("#printBtn").attr("disabled", false);
            $("#printBtn").attr("printBtnSm", false);
            return false;
        }
        if (noProductflag === 1) {
            showLoader();
        }
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();
        var productCodeStr = $('#productCodeStr').val();
        $.ajax({
            type: 'POST',
            data: {productCodeStr: productCodeStr, iterationNumber: iterationNumber, fromDate: fromDate, toDate: toDate},
            url: '<?php echo base_url() ?>Reports/getRawProductStockOutData',
            success: function (result) {
                console.log(result);
                iterationNumber++;
                hideLoader();
                var resultObj = jQuery.parseJSON(result);
                var productsLength = resultObj.products.length;
                var tableTd = "";
                var tableTr = "";
                var loopValue = productsLength;
                if (productsLength > SHOW_MORE_DATA_COUNT) {
                    loopValue = productsLength - 1;
                    $('#showMoreProductDiv').html('');
                } else {
                    getStockDataFlag = 0;
                    $('#showMoreBtn').remove();
                }

                var j;
                for (var i = 0; i < loopValue; i++) {
                    tableTd = "";
                    serial++;
                    tableTd += getProductTd(resultObj, i);
                    tableTr += "<tr>" + tableTd + "</tr>";
                }
                $('#stockTable').append(tableTr);
                if (tableTr === "" && noProductflag === 1) {
                    $('#noProductFound').text('No Product Found');
                }
            },
            complete: function () {
                loadData(2);
                getStockDataFlag++;
            }
        });
    }

    function getProductTd(resultObj, i) {
        var stockDate = "";
        var stockCode = "";
        var rawProductTitle = "";
        var finishProductTitle = "";
        var vendorTitle = "";
        var particular = "";
        var quantity = 0;
        var rate = 0;
        var amount = 0;
        var stockVariantTypeName = "";

        if (resultObj.products[i].stock_date) {
            stockDate = resultObj.products[i].stock_date;
        }
        if (resultObj.products[i].stock_code) {
            stockCode = resultObj.products[i].stock_code;
        }
        if (resultObj.products[i].raw_product_name) {
            rawProductTitle = resultObj.products[i].raw_product_name + ' <br>(' + resultObj.products[i].product + ')';
        }
        if (resultObj.products[i].finish_product_name) {
            finishProductTitle = resultObj.products[i].finish_product_name + ' <br>(' + resultObj.products[i].finish_product_code + ')';
        }
        if (resultObj.products[i].vendor_name) {
            vendorTitle = resultObj.products[i].vendor_name + ' <br>(' + resultObj.products[i].vendor + ')';
        }
        if (resultObj.products[i].particular) {
            particular = resultObj.products[i].particular;
        }
        if (resultObj.products[i].stock_out_quantity) {
            quantity = resultObj.products[i].stock_out_quantity;
        }
        if (resultObj.products[i].rate) {
            rate = resultObj.products[i].rate;
        }
        if (resultObj.products[i].amount) {
            amount = resultObj.products[i].amount;
        }
        var stockVariantType = resultObj.products[i].stock_variant_type;
        if (stockVariantType === '<?php echo STOCK_VARIANT_MIXING ?>') {
            stockVariantTypeName = 'Raw Mixing';
        } else if (stockVariantType === '<?php echo STOCK_VARIANT_EXTRA_RAW ?>') {
            stockVariantTypeName = 'Extra Raw Lifting';
        } else if (stockVariantType === '<?php echo STOCK_VARIANT_RAW_RETURN ?>') {
            stockVariantTypeName = 'Raw Return';
        }


//         <th class='td-center'>Date</th>
//                        <th class='td-center'>Stock ID</th>
//                        <th class='td-center'>Raw Product</th>
//                        <th class='td-center'>Finished Goods</th>
//                        <th class='td-center'>Vendor</th>
//                        <th class='td-center'  style="width: 100px">Particular</th>
//                        <th class='td-center'>Quantity</th>
//                        <th class='td-center'>Rate<br><small><i class="text-muted">BDT</i></small></th>
//                        <th class='td-center'>Amount<br><small><i class="text-muted">BDT</i></small></th>
        //<th class='td-center'>Type</th>

        var html = "<td class='td-center'>" + stockDate + "</td>\n\
                    <td class='td-center'>" + stockCode + "</td>\n\
                    <td class='td-left'>" + rawProductTitle + "</td>\n\
                    <td class='td-left'>" + finishProductTitle + "</td>\n\
                    <td class='td-left'>" + vendorTitle + "</td>\n\
                    <td class='td-left'>" + particular + "</td>\n\
                    <td class='td-right'>" + quantity + "</td>\n\
                    <td class='td-right'>" + rate + "</td>\n\
                    <td class='td-right'>" + amount + "</td>\n\
                    <td class='td-center'>" + stockVariantTypeName + "</td>";

        return html;
    }
    $(function () {
        getReportData();
    });

    function print() {
        $('#print').printThis();
    }

</script>