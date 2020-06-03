<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <?php if (checkPermittedAction(RAW_RETURN_ADD)) { ?>
            <a href="<?php echo base_url() ?>RawProduct/newRawReturn" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Raw Return</a>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        var stockEntryTable = $('#stockEntryTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>RawProduct/getRawReturnData'
            },
            'columns': [
                {data: 'serial'},
                {data: 'stock_date'},
                {data: 'stock_code'},
                {data: 'total_amount'},
                {data: 'status_name'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            },
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
        });

        $('#stockEntryTable tbody').on('click', 'tr', function () {
            var data = stockEntryTable.row(this).data();
            showStockEntryDetails(data.stock_code);
        });
    });

    function showStockEntryDetails(stockCode) {
        window.location.href = BASE_URL + "RawProduct/showRawReturnDetails?stockCode=" + stockCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='stockEntryTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Return Date <br><small class="text-muted">(yyyy-mm-dd)</small></th>
                    <th>Raw Return ID</th>
                    <th>Total Amount <br><small class="text-muted">(BDT)</small></th>
                    <th class="no-sort">Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
