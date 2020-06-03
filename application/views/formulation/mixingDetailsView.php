<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <?php if ($mixingSummary[0]['is_active'] == MIXING_STATUS_REJECTED && checkPermittedAction(MIXING_EDIT)) { ?>
                <a href="<?php echo base_url() ?>Formulation/showEditMixing?mixingCode=<?php echo $mixingSummary[0]['mixing_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>
            <?php } ?>

        </div>
        <?php if (checkPermittedAction(MIXING_ADD)) { ?>
            <a href="<?php echo base_url() ?>Formulation/newMixingRawMaterial" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Mixing Raw Material</a>
        <?php } ?>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <section class="content invoice" style="">
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                    <i class="fa fa-globe"></i> Mixing ID:  <?php echo $mixingSummary[0]['mixing_code'] ?>
                    <small><i> (<?php echo getMixingStatusName($mixingSummary[0]['is_active']) ?>)</i></small>
                    <small class="pull-right">Finish Good: <?php echo $mixingSummary[0]['finish_product_name'] ?></small>
                </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <hr>
            <div class="col-md-4 col-sm-3 col-xs-12">
                <div class="m-b-10">
                    <span class="font-12"><b>Date <small class="text-muted">(yyyy-mm-dd)</small></b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['mixing_date'] ?></span>
                </div>
                <div class="m-b-10">
                    <span class="font-12"><b>Finished Good</b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['finish_product_name'] ?></span>
                </div>
                <div class="m-b-10">
                    <span class="font-12"><b>Pack Size</b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['pack_size'] ?></span>
                </div>
                <div class="m-b-10">
                    <span class="font-12"><b>Finish Goods Quantity</b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['finish_good_quantity'] ?></span>
                </div>
            </div>
            <div class="col-md-4 col-sm-3 col-xs-12">
                
            </div>
            <div class="col-md-4 col-sm-3 col-xs-12">
                <div class="m-b-10">
                    <span class="font-12"><b>Batch No </b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['batch_no'] ?></span>
                </div>
                <div class="m-b-10">
                    <span class="font-12"><b>Manufacture Date<small class="text-muted">(yyyy-mm-dd)</small></b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['manufacture_date'] ?></span>
                </div>
                <div class="m-b-10">
                    <span class="font-12"><b>Expiry Date <small class="text-muted">(yyyy-mm-dd)</small></b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['expiry_date'] ?></span>
                </div>
                <div class="m-b-10">
                    <span class="font-12"><b>Year</b></span>
                    <span class="float-right"><?php echo $mixingSummary[0]['mixing_for_year'] ?> year</span>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 table">
                <table class="table custom-table">
                    <thead>
                        <tr class="bg-gray">
                            <th colspan="7">Raw Product of Finish Goods</th>
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
                        foreach ($mixingDetails as $mixingDetail) {
                            if ($mixingDetail['raw_type'] == RAW_TYPE_FINISH_GOOD) {
                                echo "<tr>";
                                echo "<td>" . $i . "</td>";
                                echo "<td>" . $mixingDetail['raw_product'] . "</td>";
                                echo "<td class='td-left'>" . $mixingDetail['raw_product_name'] . "<small></td>";
                                echo "<td class='td-left'>" . $mixingDetail['raw_category_name'] . "<small></td>";
                                echo "<td>" . $mixingDetail['quantity'] . "</td>";
                                echo "<td>" . $mixingDetail['raw_rate'] . "</td>";
                                echo "<td class='td-right'>" . $mixingDetail['amount'] . "</td>";
                                echo "<tr>";
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <br>
                <table class="table custom-table">
                    <thead>
                        <tr class="bg-gray">
                            <th colspan="7">Packeging Material</th>
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
                        foreach ($mixingDetails as $mixingDetail) {
                            if ($mixingDetail['raw_type'] == RAW_TYPE_PACKEGING) {
                                echo "<tr>";
                                echo "<td>" . $i . "</td>";
                                echo "<td>" . $mixingDetail['raw_product'] . "</td>";
                                echo "<td class='td-left'>" . $mixingDetail['raw_product_name'] . "<small></td>";
                                echo "<td class='td-left'>" . $mixingDetail['raw_category_name'] . "<small></td>";
                                echo "<td>" . $mixingDetail['quantity'] . "</td>";
                                echo "<td>" . $mixingDetail['raw_rate'] . "</td>";
                                echo "<td class='td-right'>" . $mixingDetail['amount'] . "</td>";
                                echo "<tr>";
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <hr>
            <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-9 col-sm-offset-9">
                <span class="font-12"><b>Formulation Cost <small class="text-muted">(BDT)</small></b></span>
                <span class="float-right"><?php echo $mixingSummary[0]['formulation_cost'] ?></span>
                <hr>
                <span class="font-12"><b>Extra Cost <small class="text-muted">(BDT)</small></b></span>
                <span class="float-right"><?php echo $mixingSummary[0]['extra_cost'] ?></span>
                <hr>
                <span class="font-12"><b>Total Cost <small class="text-muted">(BDT)</small></b></span>
                <span class="float-right"><?php echo $mixingSummary[0]['total_cost'] ?></span>
                <hr>
                <span class="font-12"><b>Purchase Cost Per Unit <small class="text-muted">(BDT)</small></b></span>
                <span class="float-right"><?php echo $mixingSummary[0]['purchase_cost_per_unit'] ?></span>
            </div>
        </div>

    </section>
    <br>
    <?php if ($mixingSummary[0]['is_active'] == MIXING_STATUS_PENDING && checkPermittedAction(MIXING_CHECKED)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="checked()"><i class="fa fa-check"></i> Checked</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="checkedForm" action="<?php echo base_url() ?>Formulation/mixingChecked" method="post">
            <input type="hidden" name="mixingCode" value="<?php echo $mixingSummary[0]['mixing_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/mixingRejected" method="post">
            <input type="hidden" name="mixingCode" value="<?php echo $mixingSummary[0]['mixing_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($mixingSummary[0]['is_active'] == MIXING_STATUS_CHECKED && checkPermittedAction(MIXING_APPRV)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="approve()"><i class="fa fa-check"></i> Approved</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="approvedForm" action="<?php echo base_url() ?>Formulation/mixingApproved" method="post">
            <input type="hidden" name="mixingCode" value="<?php echo $mixingSummary[0]['mixing_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/mixingRejected" method="post">
            <input type="hidden" name="mixingCode" value="<?php echo $mixingSummary[0]['mixing_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($mixingSummary[0]['is_active'] == MIXING_STATUS_APPROVED && checkPermittedAction(MIXING_APPRV_UNLOCK)) { ?>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="rejectedForm" action="<?php echo base_url() ?>Formulation/mixingRejected" method="post">
            <input type="hidden" name="mixingCode" value="<?php echo $mixingSummary[0]['mixing_code'] ?>">
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