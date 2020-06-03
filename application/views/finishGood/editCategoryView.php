<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>FinishGood/newCategory" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Category</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="categoryEditForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>FinishGood/editCategory" method="POST">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Category Name</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="categoryName" id="categoryName" maxlength="100"  class="form-control col-md-7 col-xs-12" value="<?php echo $categoryDetail[0]['category_name']; ?>">
                <span id="categoryNameReqError" class="text-danger hidden"><small>Please enter category name</small></span>
            </div>

        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-success btn-sm" onclick="editCategory()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>FinishGood/category" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
        <input type="hidden" name="categoryCode" id="categoryCode" value="<?php echo $categoryDetail[0]['category_code'] ?>">
    </form>
</div>
<script>
    function editCategory() {
        var fieldsArr = new Array("categoryName|categoryNameReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }
        showLoader();
        $.ajax({
            type: 'POST',
            data: {categoryName: $.trim($('#categoryName').val()), categoryCode: $.trim($('#categoryCode').val()), addEditFlag: 'edit'},
            url: BASE_URL + 'FinishGood/categoryDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#categoryEditForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate Category');
                    return false;
                }
            }
        });
    }


</script>
