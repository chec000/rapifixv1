<h1> <?php echo e(trans('admin::shopping.registrationreferences.add.new_registrationreferences')); ?></h1>
<p class="text-right"><a href="<?php echo e(route('admin.registrationreferences.list')); ?>"><?php echo e(trans('admin::shopping.registrationreferences.add.back_list')); ?></a></p>
<?php echo Form::open( ['id'=>'form_add_registrationreferences']); ?>



<fieldset class="fieldset_gray">
    <legend class="legend_gray"><?php echo trans('admin::shopping.registrationreferences.add.legend_add'); ?></legend>
        <div class="col-md-6">
            <div  class= "form-group <?php echo FormMessage::getErrorClass('key'); ?>">
                <?php echo Form::label('key', trans('admin::shopping.registrationreferences.add.key'), ['class' => 'control-label']); ?>


                <?php echo Form::text('key', isset($registrationreferences->key)? $registrationreferences->key:'', ['required','class' => 'form-control','id'=>'key']); ?>

                <span class="help-block"><?php echo FormMessage::getErrorMessage('key'); ?></span>
            </div>

        </div>

        <div class="col-md-6">
            <div class="form-group   <?php echo FormMessage::getErrorClass('country_id'); ?>">
                <?php echo Form::label('country_id', trans('admin::shopping.registrationreferences.add.countries'), ['class' => 'control-label']); ?>

                <?php echo Form::select('country_id[]', $countries, Request::input('country_id'),array('required','class' => 'form-control'
                , 'multiple'=>true, 'name' => 'country_id[]', 'id' => 'multiselect_country_id')); ?>

                <span class="help-block"><?php echo FormMessage::getErrorMessage('country_id'); ?></span>
            </div>
        </div>

        



        <div class="row">
                    <div class="col-md-12">

                        <p class="text-danger"><?php echo $validacion; ?></p>

                    </div>
    </div>
</fieldset>





<?php if(isset($add)): ?>
<h3><?php echo e(trans('admin::shopping.registrationreferences.add.oe_translates')); ?></h3>
<p class="text-danger" style="font-style: italic;"><?php echo e(trans('admin::shopping.registrationreferences.add.oe_disclaimer')); ?></p>
<?php if($errors->any()): ?>
    <div class="alert alert-danger"><span class="text-capitalize text-danger"><?php echo e($errors->first()); ?></span></div>
<?php endif; ?>
<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div role="panel-group" id="accordion-<?php echo e($lan['id']); ?>">
    <div class="panel panel-default">
        <div role="tab" class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-<?php echo e($lan['id']); ?>" href="#brand-language-<?php echo e($lan['id']); ?>"><?php echo e(trans('admin::roles.modal_add.country-language-title') . $lan['language']); ?></a>
            </h4>
        </div>
        <div role="tabpanel" data-parent="#accordion-<?php echo e($lan['id']); ?>" id="brand-language-<?php echo e($lan['id']); ?>"
             class="panel-collapse <?php echo e(($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'); ?>" >
                     <div class="panel-body">
                        <h3><?php echo $lan->language_country; ?></h3>
                        <!-- language name field -->
                        <div class="row">
                                <div class="form-group col-sm-6">
                            <label for="language_lang" class="control-label"><?php echo e(trans('admin::shopping.registrationreferences.add.name')); ?></label>
                            <input  class="form-control" name="registrationreferences_name[<?php echo e($lan->locale_key); ?>]" value="<?php echo e(old('registrationreferences_name.'.$lan->locale_key)); ?>" type="text">

                        </div>
                        <!-- language country field -->
                        <div class="form-group col-sm-6">


                            <input type="hidden" name="registrationreferences_locale[]" value="<?php echo $lan->locale_key; ?>">

                        </div>
                        </div>
                        <div class="row">

                            <span class="help-block"><?php echo FormMessage::getErrorMessage('flag'); ?></span>
                        </div>
                    </div>
            

            </div>
        </div>
    </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php endif; ?>
<div class="form-group">
        <button class='btn btn-primary addButton' type="submit">
        <?php echo e(trans('admin::shopping.registrationreferences.add.btn_add')); ?>

    </button>

</div>

<?php echo Form::close(); ?>


<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">



    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_country_id').select2();
        $('#multiselect_domain').select2();
          var country= $('#multiselect_country_id');
          var span=country.siblings('span');
          span.css('width', '100%');

    });








    $('#parent_id').on('change', function (e) {
        //  var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        $.ajax({
            url: route('admin.menu.order'),
            type: 'POST',
            data: {menu_id: valueSelected},
            success: function (data) {
                if (data !== null) {
                    $('#order').val(data.order + 1);
                }
            }
        });
    });


</script>
<?php $__env->stopSection(); ?>