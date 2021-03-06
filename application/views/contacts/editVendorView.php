<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>Contacts/newVendor" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Vendor</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="vendorEditForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>Contacts/editVendor" method="POST">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Vendor Id</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="displayContactId" id="displayContactId" class="form-control col-md-7 col-xs-12" value="<?php echo $vendorDetail[0]['display_contact_id']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Vendor Name</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="fullName" id="fullName" class="form-control col-md-7 col-xs-12" value="<?php echo $vendorDetail[0]['contact_name']; ?>">
                <span id="fullNameReqError" class="text-danger hidden"><small>Please enter vendor name</small></span>
            </div>

        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Mobile No</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="mobile" id="mobile" onchange="mobileNoValidation(this.value, this.id)" class="form-control col-md-7 col-xs-12" value="<?php echo $vendorDetail[0]['mobile_no']; ?>">
                <span id="fullNameReqError" class="text-danger hidden"><small>Please enter mobile no</small></span>
            </div>

        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="email" name="email" id="email" class="form-control col-md-7 col-xs-12" value="<?php echo $vendorDetail[0]['email']; ?>" onchange="emailValidation(this.value, this.id)">

            </div>

        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="address" id="address" class="form-control" rows="2"><?php echo $vendorDetail[0]['address']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Opening Balance</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" min="0" name="openingBalance" id="openingBalance" class="form-control col-md-7 col-xs-12" value="<?php echo $vendorDetail[0]['opening_balance']; ?>">
            </div>
            <div class="help-block with-errors"></div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="button" class="btn btn-success btn-sm" onclick="editVendor()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>Contacts/vendor" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
        <input type="hidden" name="vendorId" id="vendorId" value="<?php echo $vendorDetail[0]['contact_code'] ?>">
    </form>
</div>
<script>
    function editVendor() {
        var fieldsArr = new Array("fullName|fullNameReqError", "displayContactId|displayContactIdReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }
        showLoader();
        $.ajax({
            type: 'POST',
            data: {displayContactId: $.trim($('#displayContactId').val()), contactCode: $.trim($('#vendorId').val()), addEditFlag: 'edit'},
            url: BASE_URL + 'Contacts/vendorDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#vendorEditForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate Vendor');
                    return false;
                }
            }
        });
    }


</script>
