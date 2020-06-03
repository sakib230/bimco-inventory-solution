<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>FinishGood/newCategory" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Category</a>
    </div>
</div>

<script>
    $(document).ready(function () {
        var categoryTable = $('#categoryTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>FinishGood/getCategory'
            },
            'columns': [
                {data: 'serial'},
                {data: 'category_code'},
                {data: 'category_name'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            },
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
        });

        $('#categoryTable tbody').on('click', 'tr', function () {
            var data = categoryTable.row(this).data();
            showCategoryDetails(data.category_code);
        });
    });

    function showCategoryDetails(categoryCode) {
        window.location.href = BASE_URL + "FinishGood/showCategoryDetails?categoryCode=" + categoryCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='categoryTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Category Id</th>
                    <th>Category Name</th>
                </tr>
            </thead>
        </table>
    </div>
</div>