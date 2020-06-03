<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <a href="<?php echo base_url() ?>RawProduct/newProduct" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Product</a>
    </div>
</div>

<script>
    $(document).ready(function () {
        var productTable = $('#productTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>RawProduct/getProduct'
            },
            'columns': [
                {data: 'serial'},
                {data: 'category'},
                {data: 'product_code'},
                {data: 'product_name'},
                {data: 'current_stock_quantity'},
                {data: 'avg_pur_rate'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            },
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
        });

        $('#productTable tbody').on('click', 'tr', function () {
            var data = productTable.row(this).data();
            showProductDetails(data.product_code);
        });
    });

    function showProductDetails(productCode) {
        window.location.href = BASE_URL + "RawProduct/showProductDetails?productCode=" + productCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='productTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Category</th>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Current Stock</th>
                    <th>Average Purchase Rate</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
