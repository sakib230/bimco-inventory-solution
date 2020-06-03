<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="productAddForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>FinishGood/addProduct" method="POST">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="category" id="category">
                    <option></option>
                    <?php
                    foreach ($categories as $category) {
                        echo "<option value='$category[category_code]'>$category[category_name]</option>";
                    }
                    ?>
                </select>
                <span id="categoryReqError" class="text-danger hidden"><small>Please select a category</small></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Product Name</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="productName" id="productName" maxlength="100" class="form-control col-md-7 col-xs-12">
                <span id="productReqError" class="text-danger hidden"><small>Please enter product name</small></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Pack Size</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="packSize" id="packSize" maxlength="200" class="form-control col-md-7 col-xs-12">
                <span id="packSizeReqError" class="text-danger hidden"><small>Please enter pack size</small></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Unit Name</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="unitName" id="unitName" maxlength="200" class="form-control col-md-7 col-xs-12">
                <span id="unitNameReqError" class="text-danger hidden"><small>Please enter unit name</small></span>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Trade Price</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" min="0" name="tradePrice" id="tradePrice" class="form-control col-md-7 col-xs-12">
                <span id="tradePriceReqError" class="text-danger hidden"><small>Please enter trade price</small></span>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-success btn-sm" onclick="addProduct()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>FinishGood/product" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>
<script>
    function addProduct() {
        var fieldsArr = new Array("category|categoryReqError", "productName|productReqError", "tradePrice|tradePriceReqError", "packSize|packSizeReqError", "unitName|unitNameReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }

        var tradePrice = $('#tradePrice').val();
        if (!$.isNumeric(tradePrice)) {
            sweetAlert('Trade Price must be a numeric value');
            return false;
        }

        tradePrice = parseFloat(tradePrice);
        if (tradePrice < 0) {
            sweetAlert('Trade Price must be a positive value');
            return false;
        }

        showLoader();
        $.ajax({
            type: 'POST',
            data: {productName: $.trim($('#productName').val()), addEditFlag: 'add'},
            url: BASE_URL + 'FinishGood/productDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#productAddForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate product');
                    return false;
                }
            }
        });
    }


</script>
