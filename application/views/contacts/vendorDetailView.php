<script>
    function deleteVendor(vendorId) {
        swal({
            title: "Do you want to delete this vendor?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, I Do !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            showLoader();
            $.ajax({
                type: 'POST',
                data: {vendorId: vendorId},
                url: '<?php echo base_url() ?>Contacts/deleteVendor',
                success: function (result) {
                    window.location.href = BASE_URL + "Contacts/vendor?response=" + result;
                }
            });

        });
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <a href="<?php echo base_url() ?>Contacts/showEditVendor?vendorId=<?php echo $vendorDetail[0]['contact_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil font-15"></i></a>
            <button class="btn btn-default" type="button" onclick="deleteVendor('<?php echo $vendorDetail[0]['contact_code'] ?>')" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash font-15"></i></button>
        </div>
        <a href="<?php echo base_url() ?>Contacts/newVendor" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Vendor</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Vendor Id <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $vendorDetail[0]['display_contact_id']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Vendor Name <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $vendorDetail[0]['contact_name']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Mobile No <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $vendorDetail[0]['mobile_no']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $vendorDetail[0]['email']; ?>
        </div>
    </div> 
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $vendorDetail[0]['address']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Opening Balance <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $vendorDetail[0]['opening_balance']; ?>
        </div>
    </div>
</div>
