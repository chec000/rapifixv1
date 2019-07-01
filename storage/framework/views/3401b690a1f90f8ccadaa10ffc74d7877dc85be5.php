<style>
    .loader {
        border: 8px solid #C8C8C8; /* Light grey */
        border-top: 8px solid #3b2453; /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        position: absolute;
        left: 0;
        right: 0;
        z-index: 1500;
        margin: auto;
        top: 0;
        bottom: 50%;
    }
    @keyframes  spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="row textbox">
    <div class="col-sm-6">
        <h1> <?php echo e(trans('admin::shopping.products.index.title')); ?> </h1>
        <?php if(Auth::action('products.uploadfile')): ?>
            <a href="<?php echo e(asset('files/productos.csv')); ?>"><?php echo e(trans('admin::distributorsPool.csv.download_base_file')); ?></a>
        <?php endif; ?>
    </div>
    <div class="col-sm-6 text-right">
        <?php if(Auth::action('products.uploadfile')): ?>
            <a href="#" class="btn btn-success addButton" data-toggle="modal" data-target="#csv-modal"><i class="fa fa-upload"></i> &nbsp;
                <?php echo e(trans('admin::shopping.products.updateproduct.label.load_csv')); ?>

            </a>
        <?php endif; ?>
        <?php if(Auth::action('products.create')): ?>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                 <?php echo e(trans('admin::shopping.products.index.form-add-button')); ?> 
            </a>
        <?php endif; ?>
    </div>
</div>
<div class="table">
    <?php if(session('msg')): ?>
        <div class="alert alert-warning alert-dismissible text-center" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo e(session('msg')); ?></div>
    <?php endif; ?>
    <?php if(session()->exists('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo e(session()->get('success')); ?>

        </div>
    <?php endif; ?>

    <table class="table table-striped" id="tb_products">
        <thead>
        <tr>
            <th><?php echo e(trans('admin::shopping.products.index.thead-product-sku')); ?></th>
            <th><?php echo e(trans('admin::shopping.products.index.thead-product-brand')); ?></th>
            <th><?php echo e(trans('admin::shopping.products.index.thead-product-countries')); ?></th>
            <th><?php echo e(trans('admin::shopping.products.index.thead-product-global_name')); ?></th>
            <th><?php echo e(trans('admin::shopping.products.index.thead-product-active')); ?></th>
            <?php if(Auth::action('products.edit') || Auth::action('products.delete')): ?>
                <th><?php echo e(trans('admin::shopping.products.index.thead-product-actions')); ?></th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
           
        <?php $__currentLoopData = $countryProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countryProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="product_<?php echo $countryProduct->product->id; ?>">
                <td><?php echo $countryProduct->product->sku; ?></td>
                <td><?php echo $countryProduct->product->brandProduct->brand->name; ?></td>
                <td>
                    <?php $__currentLoopData = $countryProduct->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="label label-default"><?php echo e($c->country->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td><?php echo e($countryProduct->product->global_name); ?></td>
                <td>
                    <?php if($countryProduct->actives == 1): ?>
                        <span class="label label-success cActive"><?php echo e(trans('admin::shopping.products.index.product_active')); ?></span>
                        <span class="label label-default cInactive" style="display: none"><?php echo e(trans('admin::shopping.products.index.product_inactive')); ?></span>
                    <?php else: ?>
                        <span class="label label-success cActive" style="display: none"><?php echo e(trans('admin::shopping.products.index.product_active')); ?></span>
                        <span class="label label-default cInactive"><?php echo e(trans('admin::shopping.products.index.product_inactive')); ?></span>
                    <?php endif; ?>
                </td>
                <td data-cid="<?php echo $countryProduct->product->id; ?>">
                    <a href="<?php echo e(route('admin.products.listWarehouses', ['id' => $countryProduct->product->id])); ?>"
                       title="<?php echo e(trans('admin::shopping.products.index.edit_product')); ?>" style="text-decoration: none;color: #000;">
                        <i class="fa fa-building" aria-hidden="true" style="padding: 3px 5px;"></i>
                    </a>
                        <?php $enable = ($countryProduct->actives == 1) ? null : ' hide' ?>
                        <?php $disable = ($countryProduct->actives == 1) ? ' hide' : null ?>
                        <?php if(Auth::action('products.changeStatus')): ?>
                            <i onclick="activate(<?php echo $countryProduct->product->id; ?>)" class="glyphicon glyphicon-play itemTooltip<?php echo $disable; ?>" title="<?php echo e(trans('admin::shopping.products.index.enable_product')); ?>"></i>
                            <i onclick="inactivate(<?php echo $countryProduct->product->id; ?>)" class="glyphicon glyphicon-stop itemTooltip<?php echo $enable; ?>" title="<?php echo e(trans('admin::shopping.products.index.disable_product')); ?>"></i>
                        <?php endif; ?>
                        <?php if(Auth::action('products.edit')): ?>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="<?php echo e(route('admin.products.edit', ['productId' => $countryProduct->product->id])); ?>" title="<?php echo e(trans('admin::shopping.products.index.edit_product')); ?>"></a>
                        <?php endif; ?>
                        <?php if(Auth::action('products.destroy')): ?>
                        <form id="delete-product-form-<?php echo e($countryProduct->product->id); ?>" action="<?php echo e(route('admin.products.destroy', $countryProduct->product->id)); ?>", method="POST" style="display: inline">
                            <?php echo e(csrf_field()); ?>

                            <a onclick="deleteElement(this)" data-id="<?php echo e($countryProduct->product->id); ?>" data-element="<?php echo e($countryProduct->product->global_name); ?>" class=" glyphicon glyphicon-trash itemTooltip" href="javascript:{}" title="<?php echo e(trans('admin::shopping.products.index.delete_product')); ?>"></a>
                        </form>
                        <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<div id="loader" class="loader" style="display: none;"></div>

<?php $__env->startSection('scripts'); ?>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">

        $('#upload-file').click(function ()
        {
            $('#loader').show();
            var data = new FormData($('#csv_form')[0]);
            axios.post('<?php echo e(route("admin.products.uploadfile")); ?>', data )
                .then(function (response) {
                    $('#loader').hide();
                    if (response.data.data.length) {
                        $('#modal-messages').html(getResponseBlock(response.data.data));
                    }
                })
                .catch(function (error) {
                    $('#loader').hide();
                    var errorList = [];
                    if(error.response.status == 500){
                        errorList += "<li>Error 500</li>";
                    }else{
                        $.each(error.response.data.errors, function( index, value ) { errorList += '<li>'+value+'</li>'; });
                    }
                    $('#modal-messages').html(getErrorsBlock(errorList));
                    $('#upload-file').prop('disabled', false);
                });
        });

        function deleteElement(element) {
            var id = $(element).data('id');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('<?php echo e(trans('admin::shopping.products.index.confirm')); ?>');
            $('#accept-confirm').text('<?php echo e(trans('admin::shopping.products.index.confirm_yes')); ?>');
            $('#cancel-confirm').text('<?php echo e(trans('admin::shopping.products.index.confirm_no')); ?>');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                document.getElementById('delete-product-form-'+id).submit();
            });
        }

        function getResponseBlock(data) {
            var responseList = '';
            $.each(data, function (i, element) {
                var label = 'Success';
                if (element.class == 'danger') {
                    label = 'Error';
                }

                responseList += '<p class="message-label"><span class="label label-'+element.class+'">'+label+'</span>Line: '+element.line+', '+element.message+'</p>';
            });

            return responseList;
        }

        function getErrorsBlock(errors) {
            return errorsBlock = '\
                <div class="alert alert-danger alert-dismissible">\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="top: -12px;">&times;</a>\
                        <ul>\
                        '+errors+'\
                        </ul>\
                </div>';
        }

        function activate(id) {
            disable_product(0,id);
        }

        function inactivate(id) {
            disable_product(1,id);
        }

        $('#tb_products').DataTable({
            "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "<?php echo e(trans('admin::datatables.lang')); ?>"
               }
        });

        function disable_product(active,productId) {
            var url  = '<?php echo e(route('admin.products.changeStatus')); ?>';
            var type = 'deactivate';

            if (active == 0) {
                type = 'activate';
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: {id: productId, type: type},
                success: function (r) {
                    console.log(r.status);
                    if (r.status == 'on') {
                        $("#product_" + productId + " .glyphicon-play").addClass('hide');
                        $("#product_" + productId + " .glyphicon-stop").removeClass('hide');
                        $("#product_" + productId + " .cActive").show();
                        $("#product_" + productId + " .cInactive").hide();
                    }
                    else {
                        $("#product_" + productId + " .glyphicon-stop").addClass('hide');
                        $("#product_" + productId + " .glyphicon-play").removeClass('hide');
                        $("#product_" + productId + " .cActive").hide();
                        $("#product_" + productId + " .cInactive").show();

                    }
                }
            });
        }

    </script>
    <?php $__env->stopSection(); ?>



