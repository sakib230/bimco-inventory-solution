<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>RawProduct/newProduct" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Product</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="productEditForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>RawProduct/editProduct" method="POST">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="category" id="category">
                    <option value="<?php echo $productDetail[0]['category'] ?>"><?php echo $productDetail[0]['category_name'] ?></option>
                    <?php
                    foreach ($categories as $category) {
                        if ($productDetail[0]['category'] == $category['category_code']) {
                            continue;
                        }
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
                <input type="text" name="productName" id="productName" maxlength="100" value="<?php echo $productDetail[0]['product_name'] ?>" class="form-control col-md-7 col-xs-12">
                <span id="productReqError" class="text-danger hidden"><small>Please enter product name</small></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Average Purchase Rate</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" min="0" name="avgPurchaseRate" id="avgPurchaseRate" value="<?php echo $productDetail[0]['avg_purchase_rate'] ?>" class="form-control col-md-7 col-xs-12">
                <span id="avgPurchaseRateReqError" class="text-danger hidden"><small>Please enter avarage purchase rate</small></span>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-success btn-sm" onclick="editProduct()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>RawProduct/product" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
        <input type="hidden" name="productCode" id="productCode" value="<?php echo $productDetail[0]['product_code'] ?>">
    </form>
</div>
<script>
    function editProduct() {
        var fieldsArr = new Array("category|categoryReqError", "productName|productReqError", "avgPurchaseRate|avgPurchaseRateReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }

        var avgPurchaseRate = $('#avgPurchaseRate').val();
        if (!$.isNumeric(avgPurchaseRate)) {
            sweetAlert('Average Purchase Rate must be a numeric value');
            return false;
        }

        avgPurchaseRate = parseFloat(avgPurchaseRate);
        if (avgPurchaseRate < 0) {
            sweetAlert('Average Purchase Rate must be a positive value');
            return false;
        }

        showLoader();
        $.ajax({
            type: 'POST',
            data: {productName: $.trim($('#productName').val()), productCode: $.trim($('#productCode').val()), addEditFlag: 'edit'},
            url: BASE_URL + 'RawProduct/productDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#productEditForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate product');
                    return false;
                }
            }
        });
    }
</script>
