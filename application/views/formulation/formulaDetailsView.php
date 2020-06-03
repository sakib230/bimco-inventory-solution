<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <?php if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_REJECTED && checkPermittedAction(FORMULA_EDIT)) { ?>
                <a href="<?php echo base_url() ?>Formulation/showEditFormula?formulaCode=<?php echo $formulaSummary[0]['formula_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>
            <?php } ?>

        </div>
        <?php if (checkPermittedAction(FORMULA_ADD)) { ?>
            <a href="<?php echo base_url() ?>Formulation/newProductFormulation" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Product Formulation</a>
        <?php } ?>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <section class="content invoice" style="">
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                    <i class="fa fa-globe"></i> Formulation ID:  <?php echo $formulaSummary[0]['formula_code'] ?>
                    <small><i> (<?php echo '<b>' . getFormulaActiveName($formulaSummary[0]['multi_formula_active']) . '</b> & ' . getFormulaStatusName($formulaSummary[0]['is_active']) ?>)</i></small>
                    <small class="pull-right">Finish Good: <?php echo $formulaSummary[0]['finish_product_name'] ?></small>
                </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 table">

                <?php
                $formulaRatePermissionFlag = checkPermittedAction(FORMULA_RATE);
                ?>

                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width:10%!important">Raw Product ID</th>
                            <th class='td-left' style="width:10%!important">Raw Product Name</th>
                            <th class='td-left' style="width:10%!important">Category</th>
                            <th style="width:10%!important">Quantity</th>
                            <?php if ($formulaRatePermissionFlag) { ?>
                                <th style="width:10%!important">Avg Purchase Rate<br><small class="text-muted">(BDT)</small></th>
                                <th class='td-right' style="width: 11%">Amount <small class="text-muted">(BDT)</small></th>
                            <?php } ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $amount = 0;
                        $totalAmount = 0;
                        foreach ($formulaDetails as $formulaDetail) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $formulaDetail['raw_product'] . "</td>";
                            echo "<td class='td-left'>" . $formulaDetail['product_name'] . "<small></td>";
                            echo "<td class='td-left'>" . $formulaDetail['category_name'] . "<small></td>";
                            echo "<td>" . $formulaDetail['quantity'] . "</td>";
                            $amount = $formulaDetail['quantity'] * $formulaDetail['avg_purchase_rate'];
                            if ($formulaRatePermissionFlag) {
                                echo "<td>" . $formulaDetail['avg_purchase_rate'] . "</td>";
                                echo "<td class='td-right'>" . $amount . "</td>";
                            }

                            echo "<tr>";
                            $i++;
                            $totalAmount = $totalAmount + $amount;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($formulaRatePermissionFlag) { ?>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-9 col-sm-offset-9">
                    <span class="font-12"><b>Total <small class="text-muted">(BDT)</small></b></span>
                    <span class="float-right"><?php echo $totalAmount ?></span>
                    <br>
                </div>
            </div>
        <?php } ?>
    </section>
    <br>
    <?php if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_PENDING && checkPermittedAction(FORMULA_CHECKED)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="checked()"><i class="fa fa-check"></i> Checked</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="checkedForm" action="<?php echo base_url() ?>Formulation/formulaChecked" method="post">
            <input type="hidden" name="formulaCode" value="<?php echo $formulaSummary[0]['formula_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/formulaRejected" method="post">
            <input type="hidden" name="formulaCode" value="<?php echo $formulaSummary[0]['formula_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_CHECKED && checkPermittedAction(FORMULA_APPRV)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="approve()"><i class="fa fa-check"></i> Approved</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="approvedForm" action="<?php echo base_url() ?>Formulation/formulaApproved" method="post">
            <input type="hidden" name="formulaCode" value="<?php echo $formulaSummary[0]['formula_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/formulaRejected" method="post">
            <input type="hidden" name="formulaCode" value="<?php echo $formulaSummary[0]['formula_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_APPROVED && checkPermittedAction(FORMULA_APPRV_UNLOCK)) { ?>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/formulaRejected" method="post">
            <input type="hidden" name="formulaCode" value="<?php echo $formulaSummary[0]['formula_code'] ?>">
        </form>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
    <?php } ?>

    <?php
    if ($formulaSummary[0]['is_active'] == FORMULA_ENTRY_APPROVED && checkPermittedAction(FORMULA_ACTIVE_INACTIVE)) {
        if ($formulaSummary[0]['multi_formula_active'] == 1) {
            ?>
            <button type="button" class="btn btn-danger btn-sm" onclick="multiFormulaStatusChange('0')"><i class="fa fa-remove"></i> Inactive</button>
            <?php
        } else if ($formulaSummary[0]['multi_formula_active'] == 0) {
            ?>
            <button type="button" class="btn btn-success btn-sm" onclick="multiFormulaStatusChange('1')"><i class="fa fa-remove"></i> Active</button>
            <?php
        }
        ?>
        <form id="activeInactiveForm" action="<?php echo base_url() ?>Formulation/multiFormulaStatusChange" method="post">
            <input type="hidden" name="formulaCode" value="<?php echo $formulaSummary[0]['formula_code'] ?>">
            <input type="hidden" name="multiFormulaStatusHidden" id="multiFormulaStatusHidden">
        </form>
    <?php } ?>
</div>

<script>
    function approve() {
        swal({
            title: "Are you sure to approve this formula?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, Sure !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            $('#approvedForm').submit();
        });
    }

    function checked() {
        swal({
            title: "Are you sure to check this formula?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, Sure !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            $('#checkedForm').submit();
        });
    }

    function rejected() {
        swal({
            title: "Are you sure to reject this formula?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, Sure !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            $('#rejectedForm').submit();
        });
    }

    function multiFormulaStatusChange(flag) {
        var title = '';
        if (flag === '1') {
            title = 'Are you sure to active this entry?';
        } else if (flag === '0') {
            title = 'Are you sure to inactive this formula?';
        }
        swal({
            title: title,
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, Sure !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            $('#multiFormulaStatusHidden').val(flag);
            $('#activeInactiveForm').submit();
        });
    }
</script>