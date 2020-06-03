<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>UserManagement/newUserRole" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New User Role</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <form id="userRoleForm" class="form-horizontal form-label-right" action="<?php echo base_url() ?>UserManagement/editUserRole" method="POST">

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" >User Role Title <span class="danger">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="userRoleTitle" id="userRoleTitle" value="<?php echo $userRoleDetails[0]['role_title'] ?>" maxlength="100" class="form-control col-md-7 col-xs-12">
                <span id="userRoleTitleReqError" class="text-danger hidden"><small>Please enter user role title</small></span>
            </div>
        </div>

        <div class="table-custom-responsive">
            <table id='userRoleTable' class='table table-bordered custom-table'>
                <thead>
                    <tr class="">
                        <th>Menu Group</th>
                        <th>Menu List</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $menuArr = getLeftMenuForUserRole();
                    $levelOneFlag = 1;
                    $menuListCheckBoxCount = 1;
                    $actionCheckBoxCount = 1;
                    $pageCodeArrDb = ($userRoleDetails[0]['permitted_page_code']) ? explode(',', $userRoleDetails[0]['permitted_page_code']) : array();
                    $actionCodeArrDb = ($userRoleDetails[0]['permitted_action_code']) ? explode(',', $userRoleDetails[0]['permitted_action_code']) : array();
                    foreach ($menuArr as $menu => $eachMenu) {
                        $menuChecked = "";
                        if (in_array($eachMenu['levelTwo'][0]['levelTwoCode'], $pageCodeArrDb)) {
                            $menuChecked = "checked";
                        }

                        $levelTwoCount = count($eachMenu['levelTwoLi']);
                        echo "<tr>";
                        echo "<td class='td-left' rowspan='$levelTwoCount'>" . $eachMenu['levelOneHeading'] . "</td>";
                        echo "<td class='td-left'><input type='checkbox' value='" . $eachMenu['levelTwo'][0]['levelTwoCode'] . "' name='menuListCheckbox$menuListCheckBoxCount' $menuChecked> " . $eachMenu['levelTwo'][0]['levelTwoHeading'] . "</td>";
                        echo "<td class='td-left'>";
                        if (isset($eachMenu['levelTwo'][0]['action'])) {
                            $actionArr = $eachMenu['levelTwo'][0]['action'];
                            foreach ($actionArr as $actionName => $actionCode) {

                                $actionChecked = "";
                                if (in_array($actionCode, $actionCodeArrDb)) {
                                    $actionChecked = "checked";
                                }

                                echo "<input type='checkbox' value='" . $actionCode . "' name='actionCodeCheckBox$actionCheckBoxCount' $actionChecked> " . $actionName . '<br>';
                                $actionCheckBoxCount++;
                            }
                        }
                        echo "</td>";
                        echo "</tr>";
                        $menuListCheckBoxCount++;

                        for ($j = 1; $j < $levelTwoCount; $j++) {
                            $menuChecked = "";
                            if (in_array($eachMenu['levelTwo'][$j]['levelTwoCode'], $pageCodeArrDb)) {
                                $menuChecked = "checked";
                            }
                            echo "<tr>";
                            echo "<td class='td-left'> <input type='checkbox' value='" . $eachMenu['levelTwo'][$j]['levelTwoCode'] . "' name='menuListCheckbox$menuListCheckBoxCount' $menuChecked> " . $eachMenu['levelTwo'][$j]['levelTwoHeading'] . "</td>";
                            echo "<td class='td-left'>";
                            if (isset($eachMenu['levelTwo'][$j]['action'])) {
                                $actionArr = $eachMenu['levelTwo'][$j]['action'];
                                foreach ($actionArr as $actionName => $actionCode) {
                                    $actionChecked = "";
                                    if (in_array($actionCode, $actionCodeArrDb)) {
                                        $actionChecked = "checked";
                                    }
                                    echo "<input type='checkbox' value='" . $actionCode . "' name='actionCodeCheckBox$actionCheckBoxCount' $actionChecked> " . $actionName . '<br>';
                                    $actionCheckBoxCount++;
                                }
                            }
                            echo "</td>";
                            echo "</tr>";
                            $menuListCheckBoxCount++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden" name="menuListCheckBoxCount" value="<?php echo $menuListCheckBoxCount ?>">
                <input type="hidden" name="actionCheckBoxCount" value="<?php echo $actionCheckBoxCount ?>">
                <input type="hidden" id="roleCode" name="roleCode" value="<?php echo $userRoleDetails[0]['role_code'] ?>">

                <button type="button" onclick="addUserRole()" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Save</button>
                <a href="<?php echo base_url() ?>UserManagement/userRole" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>

<script>
    function addUserRole() {
        var fieldsArr = new Array("userRoleTitle|userRoleTitleReqError");
        var inputFiledJsonData = getInputData(fieldsArr);
        if (!inputFiledJsonData) {
            return false; // required filed check
        }

        showLoader();
        $.ajax({
            type: 'POST',
            data: {userRoleTitle: $.trim($('#userRoleTitle').val()), roleCode: $.trim($('#roleCode').val()), addEditFlag: 'edit'},
            url: BASE_URL + 'UserManagement/userRoleTitleDuplicateCheck',
            success: function (result) {
                hideLoader();
                if (result === '1') {
                    $('#userRoleForm').submit();
                } else if (result === '2') {
                    sweetAlert('Duplicate title');
                    return false;
                }
            }
        });
    }


</script>