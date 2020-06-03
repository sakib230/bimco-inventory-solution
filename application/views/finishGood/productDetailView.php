<script>
    function deleteProduct(productCode) {
        swal({
            title: "Do you want to delete this product?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, I Do !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            showLoader();
            $.ajax({
                type: 'POST',
                data: {productCode: productCode},
                url: '<?php echo base_url() ?>FinishGood/deleteProduct',
                success: function (result) {
                    window.location.href = BASE_URL + "FinishGood/product?response=" + result;
                }
            });

        });
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <a href="<?php echo base_url() ?>FinishGood/showEditProduct?productCode=<?php echo $productDetail[0]['product_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil font-15"></i></a>
            <button class="btn btn-default" type="button" onclick="deleteProduct('<?php echo $productDetail[0]['product_code'] ?>')" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash font-15"></i></button>
        </div>
        <a href="<?php echo base_url() ?>FinishGood/newProduct" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Product</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Category <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $productDetail[0]['category_name']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Product ID <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $productDetail[0]['product_code']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Product Name <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $productDetail[0]['product_name']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Pack Size<span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $productDetail[0]['pack_size']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Unit Name<span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $productDetail[0]['unit_name']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Trade Price <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            BDT <?php echo $productDetail[0]['trade_price']; ?>
        </div>
    </div>
</div>
