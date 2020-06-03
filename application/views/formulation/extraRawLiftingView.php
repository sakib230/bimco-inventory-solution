<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <?php if (checkPermittedAction(RAW_LIFTING_ADD)) { ?>  
            <a href="<?php echo base_url() ?>Formulation/newRawLifting" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Raw Lifting</a>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        var liftingTable = $('#liftingTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>Formulation/getLiftingData'
            },
            'columns': [
                {data: 'serial'},
                {data: 'lifting_date'},
                {data: 'lifting_code'},
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
        $('#liftingTable tbody').on('click', 'tr', function () {
            var data = liftingTable.row(this).data();
            showLiftingDetails(data.lifting_code);
        });
    });
    function showLiftingDetails(liftingCode) {
        window.location.href = BASE_URL + "Formulation/showRawLiftingDetails?liftingCode=" + liftingCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='liftingTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Date</th>
                    <th>Lifting ID</th>
                    <th class="no-sort">Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>