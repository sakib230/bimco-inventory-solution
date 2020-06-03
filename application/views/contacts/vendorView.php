<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>Contacts/newVendor" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Vendor</a>
    </div>
</div>

<script>
    $(document).ready(function () {
        var contactTable = $('#contactTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>Contacts/getVendorList'
            },
            'columns': [
                {data: 'serial'},
                {data: 'display_contact_id'},
                {data: 'contact_name'},
                {data: 'mobile_no'},
                {data: 'email'},
                {data: 'contact_code'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            },
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }]
        });

        $('#contactTable tbody').on('click', 'tr', function () {
            var data = contactTable.row(this).data();
            showVendorDetails(data.contact_code);
        });
    });

    function showVendorDetails(vendorId) {
        window.location.href = BASE_URL + "Contacts/showVendorDetails?vendorId=" + vendorId;
    }


</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='contactTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Vendor Id</th>
                    <th>Vendor Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                  
                </tr>
            </thead>
        </table>
    </div>
</div>

<!--
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table class="table table-hover table-bordered custom-table" id="vendor-datatable">
            <thead>
                <tr>
                    <th style="width: 30px">#</th>
                    <th>Vendor Id</th>
                    <th>Vendor Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

                </tr>
            </tfoot>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#vendor-datatable tfoot th').each(function () {
            $(this).html('<input type="text" placeholder="Search" />');
        });
        var userTable = $('#vendor-datatable').DataTable({
            "bDestroy": true,
            "ajax": '<?php //echo base_url()    ?>Contacts/getVendorList',
            "deferRender": true,
            "aaSorting": [],
//            "columnDefs": [
//                {
//                    "targets": [6],
//                    "visible": false,
//                    "searchable": false
//                }
//            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            }

        });
        userTable.columns().every(function () {
            var that = this;
            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
        $('#vendor-datatable tbody').on('click', 'tr', function () {
            var data = userTable.row(this).data();
            showUserDetails(data[1]);
        });
    });

    function showUserDetails(vendorId) {
        window.location.href = BASE_URL + "Contacts/showVendorDetails?vendorId=" + vendorId;
    }
</script>
-->
