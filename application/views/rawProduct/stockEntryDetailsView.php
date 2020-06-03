<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <?php if ($stockSummary[0]['is_active'] == STOCK_ENTRY_REJECTED && checkPermittedAction(RAW_STOCK_EDIT)) { ?>
                <a href="<?php echo base_url() ?>RawProduct/showEditStock?stockCode=<?php echo $stockSummary[0]['stock_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil"></i></a>
            <?php } ?>

        </div>
        <?php if (checkPermittedAction(RAW_STOCK_ADD)) { ?>
            <a href="<?php echo base_url() ?>RawProduct/newStock" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Stock</a>
        <?php } ?>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <section class="content invoice" style="">
        <div class="row">
            <div class="col-xs-12 invoice-header">
                <h3>
                    <i class="fa fa-globe"></i> Stock ID:  <?php echo $stockSummary[0]['stock_code'] ?>
                    <small><i> (<?php echo getStockSummaryStatusName($stockSummary[0]['is_active']) ?>)</i></small>
                    <small class="pull-right">Date: <?php echo $stockSummary[0]['stock_date'] ?></small>
                </h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 table">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th class='td-left' style="width: 20%">Vendor</th>
                            <th class='td-left' style="width: 20%">Raw Product</th>
                            <th class='td-left' style="width: 20%">Particulars</th>
                            <th  style="width: 12%">Quantity</th>
                            <th style="width: 12%">Rate <small class="text-muted">(BDT)</small></th>
                            <th class='td-right' style="width: 11%">Amount <small class="text-muted">(BDT)</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($stockDetails as $stockDetail) {
                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td class='td-left'>" . $stockDetail['vendor_name'] . '<br><small>' . $stockDetail['vendor'] . "<small></td>";
                            echo "<td class='td-left'>" . $stockDetail['product_name'] . '<br><small>' . $stockDetail['product'] . "<small></td>";
                            echo "<td class='td-left'>" . $stockDetail['particulars'] . "</td>";
                            echo "<td>" . $stockDetail['stock_in_quantity'] . "</td>";
                            echo "<td>" . $stockDetail['rate'] . "</td>";
                            echo "<td class='td-right'>" . $stockDetail['amount'] . "</td>";
                            echo "<tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12 col-md-offset-9 col-sm-offset-9">
                <span class="font-12"><b>Total <small class="text-muted">(BDT)</small></b></span>
                <span class="float-right"><?php echo $stockSummary[0]['total_amount'] ?></span>
                <br>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo $stockSummary[0]['description'] ?>
            </div>
        </div>
    </section>
    <br>
    <?php if ($stockSummary[0]['is_active'] == STOCK_ENTRY_PENDING && checkPermittedAction(RAW_STOCK_CHECKED)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="checked()"><i class="fa fa-check"></i> Checked</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="checkedForm" action="<?php echo base_url() ?>RawProduct/stockEntryChecked" method="post">
            <input type="hidden" name="stockCode" value="<?php echo $stockSummary[0]['stock_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>RawProduct/stockEntryRejected" method="post">
            <input type="hidden" name="stockCode" value="<?php echo $stockSummary[0]['stock_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($stockSummary[0]['is_active'] == STOCK_ENTRY_CHECKED && checkPermittedAction(RAW_STOCK_APPRV)) { ?>
        <button type="button" class="btn btn-success btn-sm" onclick="approve()"><i class="fa fa-check"></i> Approved</button>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="approvedForm" action="<?php echo base_url() ?>RawProduct/stockEntryApproved" method="post">
            <input type="hidden" name="stockCode" value="<?php echo $stockSummary[0]['stock_code'] ?>">
        </form>
        <form id="rejectedForm" action="<?php echo base_url() ?>RawProduct/stockEntryRejected" method="post">
            <input type="hidden" name="stockCode" value="<?php echo $stockSummary[0]['stock_code'] ?>">
        </form>
    <?php } ?>

    <?php if ($stockSummary[0]['is_active'] == STOCK_ENTRY_APPROVED && checkPermittedAction(RAW_STOCK_APPRV_UNLOCK)) { ?>
        <button type="button" class="btn btn-danger btn-sm" onclick="rejected()"><i class="fa fa-remove"></i> Rejected</button>
        <form id="rejectedForm" action="<?php echo base_url() ?>RawProduct/stockEntryRejected" method="post">
            <input type="hidden" name="stockCode" value="<?php echo $stockSummary[0]['stock_code'] ?>">
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