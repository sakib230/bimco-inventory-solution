<script>
    function changePassword() {
        if ($('#oldPassword').val() === "" || $('#newPassword').val() === "" || $('#reTypePassword').val() === "") {
            sweetAlert('Fields are required');
            return false;
        }

        if ($('#newPassword').val() !== $('#reTypePassword').val()) {
            sweetAlert('Passwoed and retype passord doesnot match');
            return false;
        }
        $('#passordChangeForm').submit();
    }

</script>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
        <form id="passordChangeForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>Home/changePassword" method="POST">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Old Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="oldPassword" class="form-control col-md-7 col-xs-12" type="password" name="oldPassword">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">New Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="newPassword" class="form-control col-md-7 col-xs-12" type="password" name="newPassword">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Re-Type Password</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="reTypePassword" class="form-control col-md-7 col-xs-12" type="password">
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="button" class="btn btn-success btn-sm" onclick="changePassword()"><i class="fa fa-check"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>