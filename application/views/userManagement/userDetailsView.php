<script>
    function statusChange(userId, flag) {
        var title;
        if (flag === '2') {  // do inactive
            title = 'Do you want to inactive this user?';
        } else if (flag === '3') {  // do active
            title = 'Do you want to active this user?';
        }
        swal({
            title: title,
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
                data: {userId: userId},
                url: '<?php echo base_url() ?>UserManagement/statusChange',
                success: function (result) {
                    window.location.href = BASE_URL + "UserManagement/showUserDetails?userId=" + userId + "&response=" + result;
                }
            });

        });
    }
</script>
<div class="col-md-6 col-sm-12 col-xs-12 col-md-offset-6">
    <div class="float-right">
        <a href="<?php echo base_url() ?>UserManagement/showUserEdit?userId=<?php echo $userDetails[0]['user_id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>
        <?php
        if ($this->user != $userDetails[0]['user_id']) {
            if ($userDetails[0]['is_active'] == 1) {
                ?>
                <button class="btn btn-danger btn-sm" onclick="statusChange('<?php echo $userDetails[0]['user_id'] ?>', '2')"><i class="fa fa-trash"> Inactive</i></button>
                <?php
            } else if ($userDetails[0]['is_active'] == 0) {
                ?>
                <button class="btn btn-success btn-sm" onclick="statusChange('<?php echo $userDetails[0]['user_id'] ?>', '3')"><i class="fa fa-check-circle"> Active</i></button>
                <?php
            }
        }
        ?>

        <a href="<?php echo base_url() ?>UserManagement/newUser" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New User</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">

    <div class="row">
        <label class="control-label col-md-2 col-sm-3 col-xs-6" >Full Name <span class="pull-right">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?php echo $userDetails[0]['full_name']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-2 col-sm-3 col-xs-6" >Mobile No <span class="pull-right">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?php echo $userDetails[0]['mobile_no']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-2 col-sm-3 col-xs-6" >Email <span class="pull-right">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?php echo $userDetails[0]['email']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-2 col-sm-3 col-xs-6" >User Role<span class="pull-right">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?php echo $userDetails[0]['role_title']; ?>
        </div>
    </div>
</div>
