<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="vendorAddForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>Contacts/addVendor" method="POST">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Vendor ID</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="displayContactId" id="displayContactId" class="form-control col-md-7 col-xs-12">
                <span id="displayContactIdReqError" class="text-danger hidden"><small>Please enter vendor id</small></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Vendor Name</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="fullName" id="fullName" maxlength="200" class="form-control col-md-7 col-xs-12">
                <span id="fullNameReqError" class="text-danger hidden"><small>Please enter vendor name</small></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Mobile No</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="mobile" id="mobile" onchange="mobileNoValidation(this.value, this.id)" class="form-control col-md-7 col-xs-12">
                <span id="mobileReqError" class="text-danger hidden"><small>Please enter mobile no</small></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="email" name="email" id="email" onchange="emailValidation(this.value, this.id)" class="form-control col-md-7 col-xs-12">
            </div>
            <div class="help-block with-errors"></div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="address" id="address" class="form-control" rows="2"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Opening Balance</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" min="0" name="openingBalance" id="openingBalance" class="form-control col-md-7 col-xs-12" >
            </div>
            <div class="help-block with-errors"></div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-success btn-sm" onclick="addVendor()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>Contacts/vendor" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>
<script>
    function addVendor() {
        var fieldsArr = new Array("fullName|fullNameReqError", "displayContactId|displayContactIdReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }
        showLoader();
        $.ajax({
            type: 'POST',
            data: {displayContactId: $.trim($('#displayContactId').val()), addEditFlag: 'add'},
            url: BASE_URL + 'Contacts/vendorDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#vendorAddForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate Serial No');
                    return false;
                }
            }
        });
    }


</script>
