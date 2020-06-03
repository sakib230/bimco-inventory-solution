<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <?php if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_REJECTED && checkPermittedAction(RAW_LIFTING_EDIT)) { ?>
                <a href="<?php echo base_url() ?>Formulation/showEditExtraRawLifting?liftingCode=<?php echo $liftingSummary[0]['lifting_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>
            <?php } ?>

        </div>
        <?php if (checkPermittedAction(RAW_LIFTING_ADD)) { ?>
            <a href="<?php echo base_url() ?>Formulation/newRawLifting" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Raw Lifting</a>
        <?php } ?>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <section class="content invoice" style="">
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                    <i class="fa fa-globe"></i> Lifting ID:  <?php echo $liftingSummary[0]['lifting_code'] ?>
                    <small><i> (<?php echo getLiftingStatusName($liftingSummary[0]['is_active']) ?>)</i></small>

                </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <hr>
            <div class="col-md-4 col-sm-3 col-xs-12">
                <div class="m-b-10">
                    <span class="font-12"><b>Date <small class="text-muted">(yyyy-mm-dd)</small></b></span>
                    <span class="float-right"><?php echo $liftingSummary[0]['lifting_date'] ?></span>
                </div>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 table">
                <table class="table custom-table">
                    <thead>
                        <tr class="bg-gray">
                            <th colspan="7">Extra Raw Material Lifting</th>
                        </tr>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width:10%!important">Raw Product ID</th>
                            <th class='td-left' style="width:10%!important">Raw Product Name</th>
                            <th class='td-left' style="width:10%!important">Category</th>
                            <th style="width:10%!important">Quantity</th>
                            <th style="width:10%!important"> Rate <small class="text-muted">(BDT)</small></th>
                            <th class='td-right' style="width: 11%">Amount <small class="text-muted">(BDT)</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($liftingDetails as $liftingDetail) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $liftingDetail['raw_product'] . "</td>";
                            echo "<td class='td-left'>" . $liftingDetail['raw_product_name'] . "<small></td>";
                            echo "<td class='td-left'>" . $liftingDetail['raw_category_name'] . "<small></td>";
                            echo "<td>" . $liftingDetail['quantity'] . "</td>";
                            echo "<td>" . $liftingDetail['raw_rate'] . "</td>";
                            echo "<td class='td-right'>" . $liftingDetail['amount'] . "</td>";
                            echo "<tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <hr>
            <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-9 col-sm-offset-9">
                <span class="font-12"><b>Total Cost <small class="text-muted">(BDT)</small></b></span>
                <span class="float-right"><?php echo $liftingSummary[0]['total_cost'] ?></span>
            </div>
        </div>

    </section>
    <br>
    <?php if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_PENDING && checkPermittedAction(RAW_LIFTING_CHECKED)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="checked()"><i class="fa fa-check"></i> Checked</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="checkedForm" action="<?php echo base_url() ?>Formulation/liftingChecked" method="post">
                <input type="hidden" name="liftingCode" value="<?php echo $liftingSummary[0]['lifting_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/liftingRejected" method="post">
            <input type="hidden" name="liftingCode" value="<?php echo $liftingSummary[0]['lifting_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_CHECKED && checkPermittedAction(RAW_LIFTING_APPRV)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="approve()"><i class="fa fa-check"></i> Approved</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="approvedForm" action="<?php echo base_url() ?>Formulation/liftingApproved" method="post">
            <input type="hidden" name="liftingCode" value="<?php echo $liftingSummary[0]['lifting_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/liftingRejected" method="post">
            <input type="hidden" name="liftingCode" value="<?php echo $liftingSummary[0]['lifting_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($liftingSummary[0]['is_active'] == LIFTING_STATUS_APPROVED && checkPermittedAction(RAW_LIFTING_APPRV_UNLOCK)) { ?>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/liftingRejected" method="post">
            <input type="hidden" name="liftingCode" value="<?php echo $liftingSummary[0]['lifting_code'] ?>">
        </form>
    <?php } ?>
</div>

<script>
    function approve() {
        swal({
            title: "Are you sure to approve this entry?",
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
            title: "Are you sure to checked this entry?",
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
            title: "Are you sure to rejected this entry?",
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
</script>