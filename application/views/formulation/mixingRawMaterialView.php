<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <?php if (checkPermittedAction(MIXING_ADD)) { ?>  
            <a href="<?php echo base_url() ?>Formulation/newMixingRawMaterial" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Mixing Raw Material</a>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        var mixingTable = $('#mixingTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>Formulation/getMixingData'
            },
            'columns': [
                {data: 'serial'},
                {data: 'mixing_date'},
                {data: 'mixing_code'},
                {data: 'finish_product_name'},
                {data: 'finish_good_quantity'},
                {data: 'batch_no'},
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
        $('#mixingTable tbody').on('click', 'tr', function () {
            var data = mixingTable.row(this).data();
            showMixingDetails(data.mixing_code);
        });
    });
    function showMixingDetails(mixingCode) {
        window.location.href = BASE_URL + "Formulation/showMixingDetails?mixingCode=" + mixingCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='mixingTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Date</th>
                    <th>Mixing ID</th>
                    <th>Finish Goods</th>
                    <th>Finish Goods Quantity</th>
                    <th>Batch No</th>
                    <th class="no-sort">Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>