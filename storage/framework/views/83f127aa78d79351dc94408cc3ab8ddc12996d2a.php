<h1><?php echo e(trans('admin::shopping.productsrestriction.label.title')); ?></h1>
<?php if(session('msg')): ?>
    <div class="alert alert-success" role="alert"><?php echo e(session('msg')); ?></div>
<?php elseif(session('errors') != null): ?>
    <div class="alert alert-danger" role="alert"><?php echo e(session('errors')->first('msg')); ?></div>
<?php endif; ?>
<div class="form-group">
        <fieldset class="fieldset_gray">
            <legend class="legend_gray">
                <?php echo e(trans('admin::shopping.productsrestriction.label.fieldset_tit')); ?> <?php echo e($countryUser[$id]); ?>

            </legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo Form::label('id_country', trans('admin::shopping.productsrestriction.label.countries'), ['class' => 'control-label']); ?>

                        <?php echo Form::select('id_country', $countryUser, $id, ['required','class' => 'form-control', 'id' => 'country_id']); ?>

                    </div>
                </div>
                <?php echo Form::open( ['route' => ['admin.productRestrictions.update','id' => $id], 'method' => 'PUT']); ?>

                <div class="col-md-6">
                    <div class="form-group <?php if(!$response['status']): ?> has-error <?php endif; ?>">
                        <label for="code_state" class="control-label">
                            <?php echo e(trans('admin::shopping.productsrestriction.label.state')); ?>

                            <span onclick="deleteSearch()" class="btn btn-warning" style="padding: 1px 5px; font-size: 10px; font-weight: normal" >
                            <?php echo e(trans('admin::shopping.productsrestriction.label.delete')); ?> <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                        </label>
                        <?php echo Form::select('code_state', $response['data'], session('code') != null ? session('code'): "" , ['required','class' => 'form-control', 'id'=>'code_state']); ?>

                        <span class="help-block" style="color: red"><?php echo e($errors->first('code_state')); ?></span>
                        <?php if(!$response['status']): ?>
                            <span class="help-block">
                                <?php $__currentLoopData = $response['messages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $i == (sizeof($response['messages'])-1) ? '<i>'.$msg.'</i>' : $msg.'<br>'; ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-10">
                    <?php echo Form::label('product_id', trans('admin::shopping.productsrestriction.label.product'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('product_id', $prodCountry, null,array('class' => 'form-control', 'id' => 'select_product_id')); ?>

                    <span class="help-block" style="color: red"><?php echo e($errors->first('country')); ?></span>
                </div>
                <div class="col-md-2 text-center">
                    <button class='btn btn-primary addButton' type="submit">
                        <?php echo e(trans('admin::shopping.productsrestriction.label.button-save')); ?>

                    </button>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </fieldset>
</div><br />
<div class="form-group">
    <div class="table">
        <table class="table table-striped" id="tb_products">
            <thead>
                <tr>
                    <th><?php echo e(trans('admin::shopping.productsrestriction.label.table.product')); ?></th>
                    <th><?php echo e(trans('admin::shopping.productsrestriction.label.table.state')); ?></th>
                    <th class="text-center"><?php echo e(trans('admin::shopping.productsrestriction.label.table.delete')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $productRestrictions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pR): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $pR->productsRestriction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>  <?php echo e($pR->product->sku); ?> - <?php echo e($pR->name); ?>  </td>
                        <td>  <?php echo e($p->state); ?>  </td>
                        <td class="text-center">
                            <?php if(Auth::action('productRestrictions.destroy')): ?>
                                <?php echo Form::open( ['route' => ['admin.productRestrictions.destroy','id' => $p->id], 'id' => 'delete_form'.$pR->id, 'method' => 'DELETE']); ?>

                                <i class="fa fa-trash" aria-hidden="true" onclick="document.getElementById('delete_form<?php echo e($pR->id); ?>').submit();"></i>
                                <?php echo Form::hidden('idCountry', $id); ?>

                                <?php echo Form::hidden('code', session('code') != null ?  session('code') : "",['id'=>'id_state_delete']); ?>

                                <?php echo Form::close(); ?>

                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->startSection('scripts'); ?>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        var table = $('#tb_products').DataTable({ "responsive": true, });
        $( document ).ready(function() {
            $('#code_state').select2();
            $('#select_product_id').select2();
            $('#country_id').change(function(){
                countryChange($(this).val())
            });
            $('#code_state').change(function () {
                var optSel = $(this).val();
                table.search(optSel).draw();
            });
            var codeState = "<?php echo e(session('code') != null ?  session('code') : ""); ?>";
            if(codeState != ""){
                table.search(codeState).draw();
            }
        });
        function countryChange(id){
            var url = window.location.origin;
            var splitUrl = window.location.pathname.split('/');
            splitUrl.shift();
            splitUrl.length == 3 ? splitUrl[splitUrl.length-1] = id : splitUrl.push(id);
            for (i = 0; i < splitUrl.length; i++){ url = url + "/" + splitUrl[i]; }
            $( location ).attr("href", url);
        }
        function deleteSearch() {
            table.search("").draw();
        }
    </script>
<?php $__env->stopSection(); ?>