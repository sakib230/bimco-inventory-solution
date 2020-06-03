<script>
    function deleteCategory(categoryCode) {
        swal({
            title: "Do you want to delete this category?",
            text: "If you delete this category, all products according to this category will also be deleted",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Yes, I Do !",
            confirmButtonColor: "#ec6c62"
        }, function () {
            showLoader();
            $.ajax({
                type: 'POST',
                data: {categoryCode: categoryCode},
                url: '<?php echo base_url() ?>FinishGood/deleteCategory',
                success: function (result) {
                    window.location.href = BASE_URL + "FinishGood/category?response=" + result;
                }
            });

        });
    }
</script>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="float-right">
        <div class="btn-group  btn-group-sm">
            <a href="<?php echo base_url() ?>FinishGood/showEditCategory?categoryCode=<?php echo $categoryDetail[0]['category_code'] ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil font-15"></i></a>
            <button class="btn btn-default" type="button" onclick="deleteCategory('<?php echo $categoryDetail[0]['category_code'] ?>')" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash font-15"></i></button>
        </div>
        <a href="<?php echo base_url() ?>FinishGood/newCategory" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> New Category</a>
    </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-t-20">
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Category Id <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $categoryDetail[0]['category_code']; ?>
        </div>
    </div>
    <div class="row">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Category Name <span class="pull-right hidden-xs">:</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?php echo $categoryDetail[0]['category_name']; ?>
        </div>
    </div>
</div>
