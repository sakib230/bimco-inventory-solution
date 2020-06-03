<script>
    function editUser() {
        if ($.trim($('#fullName').val()) === "" || $.trim($('#mobile').val()) === "" || $.trim($('#userRole').val()) === "") {
            sweetAlert('Fields are required');
            return false;
        }


        showLoader();
        $.ajax({
            type: 'POST',
            data: {userId: $.trim($('#userId').val()), mobileNo: $.trim($('#mobile').val()), addEditFlag: 'edit'},
            url: BASE_URL + 'UserManagement/userDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#userEditForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate User');
                    return false;
                }
            }
        });
    }

</script>

<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-6">
    <div class="float-right">
        <a href="<?php echo base_url() ?>UserManagement/newUser" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New User</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="userEditForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>UserManagement/editUser" method="post">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Full Name <span class="danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="fullName" id="fullName" value="<?php echo $userDetails[0]['full_name'] ?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Mobile No <span class="danger">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="mobile" name="mobile" required="required" value="<?php echo $userDetails[0]['mobile_no'] ?>" onchange="mobileNoValidation(this.value, this.id)"  class="form-control col-md-7 col-xs-12">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" class="form-control col-md-7 col-xs-12" value="<?php echo $userDetails[0]['email'] ?>" onchange="emailValidation(this.value, this.id)" type="text" name="email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">User Role <span class="danger">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control" name="userRole" id="userRole" required="">
                    <option value="<?php echo $userDetails[0]['user_role'] ?>"><?php echo $userDetails[0]['role_title'] ?></option>
                    <option value=""></option>
                    <?php
                    foreach ($userRoles as $userRole) {
                        echo "<option value='" . $userRole['role_code'] . "'>" . $userRole['role_title'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <input type="hidden" name="userId" id="userId" value="<?php echo $userDetails[0]['user_id'] ?>">
                <button type="button" class="btn btn-success btn-sm" onclick="editUser()"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>UserManagement/user" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>

    </form>
</div>
