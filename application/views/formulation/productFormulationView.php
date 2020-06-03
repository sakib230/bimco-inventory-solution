<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <?php if (checkPermittedAction(FORMULA_ADD)) { ?>  
            <a href="<?php echo base_url() ?>Formulation/newProductFormulation" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Product Formulation</a>
        <?php } ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        var formulaTable = $('#formulaTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url': '<?php echo base_url() ?>Formulation/getFormulaData'
            },
            'columns': [
                {data: 'serial'},
                {data: 'formula_code'},
                {data: 'finish_product_name'},
                {data: 'status_name'},
                {data: 'multi_formula_active'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('pointer');
            },
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
        });

        $('#formulaTable tbody').on('click', 'tr', function () {
            var data = formulaTable.row(this).data();
            showFormulaDetails(data.formula_code);
        });
    });

    function showFormulaDetails(formulaCode) {
        window.location.href = BASE_URL + "Formulation/showFormulaDetails?formulaCode=" + formulaCode;
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="table-custom-responsive">
        <table id='formulaTable' class='table table-hover table-bordered custom-table'>
            <thead>
                <tr>
                    <th class="no-sort">#</th>
                    <th>Formulation ID</th>
                    <th>Finish Goods</th>
                    <th class="no-sort">Status</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
        </table>
    </div>
</div>