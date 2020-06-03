<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>UserManagement/newUserRole" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New User Role</a>
    </div>
</div>

<script>
    $(document).ready(function () {
        var roleTable = $('#roleTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>UserManagement/getUserRole'
            },
            'columns': [
                {data: 'serial'},
                {data: 'role_code'},
                {data: 'role_title'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            },
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
        });

        $('#roleTable tbody').on('click', 'tr', function () {
            var data = roleTable.row(this).data();
            showEditUserRole(data.role_code);
        });
    });

    function showEditUserRole(roleCode) {
        window.location.href = BASE_URL + "UserManagement/showEditUserRole?roleCode=" + roleCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='roleTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Role ID</th>
                    <th>User Role</th>
                </tr>
            </thead>
        </table>
    </div>
</div>