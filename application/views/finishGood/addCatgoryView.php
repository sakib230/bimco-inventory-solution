<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="categoryAddForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>FinishGood/addCategory" method="POST">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Category Name</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="categoryName" id="categoryName" maxlength="100" class="form-control col-md-7 col-xs-12">
                <span id="categoryNameReqError" class="text-danger hidden"><small>Please enter category name</small></span>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-success btn-sm" onclick="addCategory()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>FinishGood/category" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>
<script>
    function addCategory() {
        var fieldsArr = new Array("categoryName|categoryNameReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }
        showLoader();
        $.ajax({
            type: 'POST',
            data: { categoryName: $.trim($('#categoryName').val()), addEditFlag: 'add'},
            url: BASE_URL + 'FinishGood/categoryDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#categoryAddForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate category');
                    return false;
                }
            }
        });
    }


</script>
