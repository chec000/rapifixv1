<h1><?php echo e(trans('admin::countries.edit_title')); ?></h1>
<p class="text-right"><a href="<?php echo e(route('admin.countries.list')); ?>"><?php echo e(trans('admin::countries.back_list')); ?></a></p>
<?php echo Form::open(); ?>


<div class="row">
    <!-- country key field -->
    <div class="col-md-6">
            <div class="form-group <?php echo FormMessage::getErrorClass('country_key'); ?>">
        <?php echo Form::label('country_key',  trans('admin::countries.add_key') , ['required','maxlength'=>'5','class' => 'control-label']); ?>

        <?php echo Form::text('country_key', $country->country_key, ['class' => 'form-control'] ); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('country_key'); ?></span>
    </div>
    </div>

    <input type="hidden" name='country_id' value="<?php echo e($country->id); ?>" >
    <!-- country timezone field -->
    <div class="col-md-6">
<!--            <div class="form-group <?php echo FormMessage::getErrorClass('corbiz_key'); ?>">
        <?php echo Form::label('corbiz_key',  trans('admin::countries.corbiz_key') , ['class' => 'control-label']); ?>   
        <?php echo Form::text('corbiz_key',  old("country_key", $country->corbiz_key), ['required','class' => 'form-control','maxlength'=>8] ); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('corbiz_key'); ?></span>
    </div>-->

    </div>

</div>
<div class="row">
    <!-- country currency_key field -->
    <div class="col-md-6">
          <div class="form-group  <?php echo FormMessage::getErrorClass('currency_key'); ?>">
        <?php echo Form::label('currency_key',  trans('admin::countries.add_currencyKey') , ['required','class' => 'control-label']); ?>

        <?php echo Form::text('currency_key',  old("currency_key",$country->currency_key), ['class' => 'form-control'] ); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('currency_key'); ?></span>
    </div>
    </div>
  
    <!-- country currency_symbol field   <?php echo (isset($validacion)==true)?'has-error':''; ?> -->
    <div class="col-md-6">
            <div class=" form-group <?php echo FormMessage::getErrorClass('languages'); ?>">
                <?php echo Form::label('languages', trans('admin::countries.add_lang'), ['class' => 'control-label']); ?>

                <?php echo Form::select('languages[]', $langSelect,  array_pluck($languageSelected, 'id'),array('required','class' => 'form-control'
                , 'multiple'=>true, 'name' => 'languages[]', 'id' => 'multiselect_language_id')); ?>

                <span class="help-block"><?php echo FormMessage::getErrorMessage('languages'); ?></span>
                <span class="help-block"><?php echo e($validacion); ?></span>
            </div>        
    </div>
</div>
<div class="row">
    <div class="col-md-6">
          <div class="form-group  <?php echo FormMessage::getErrorClass('timezone'); ?>">
            <?php echo Form::label('timezone',  trans('admin::countries.add_timezone') , ['required','class' => 'control-label']); ?>

            <?php echo Form::text('timezone',  old("country_key", $country->timezone), ['class' => 'form-control'] ); ?>

            <span class="help-block"><?php echo FormMessage::getErrorMessage('timezone'); ?></span>
        </div>
    </div>    
    <div class="col-md-6">
<!--        <div class="form-group <?php echo FormMessage::getErrorClass('number_format'); ?>">
        <?php echo Form::label('number_format',  trans('admin::countries.add_numberf') , ['required','class' => 'control-label']); ?>

        <?php echo Form::text('number_format',  old("number_format",$country->number_format), ['class' => 'form-control'] ); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('number_format'); ?></span>
    </div>-->
     <div class="form-group  <?php echo FormMessage::getErrorClass('default_locale'); ?>">
        <?php echo Form::label('default_locale',  trans('admin::countries.add_locale') , ['required','class' => 'control-label']); ?>

        <?php echo Form::text('default_locale',  old("default_locale", $country->default_locale), ['class' => 'form-control'] ); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('default_locale'); ?></span>
    </div>
    </div>
</div>
<!--<div class="row">
        <div class="col-sm-12">
            <div class="form-group  <?php echo FormMessage::getErrorClass('webservice'); ?>">
        <?php echo Form::label('webservice',  trans('admin::countries.web_service') , ['required','class' => 'control-label']); ?>

        <?php echo Form::url('webservice',  old("webservice",$country->webservice), ['required','maxlength'=>'250','class' => 'form-control'] ); ?>

        <span class="help-block"><?php echo FormMessage::getErrorMessage('webservice'); ?></span>
    </div>
    </div>
</div>-->

<div class="row">
    <!-- country number_format field -->


    <!-- country default_locale field -->
    <div class="col-md-6">
<!--               <div class="form-group">
        <label><?php echo e(trans('admin::countries.add_flag')); ?></label>
        <div class="input-group">
            <input id="flag" class="img_src form-control" value='<?php echo e($country->flag); ?>'  name="flag"  type="text">
            <span class="input-group-btn">
                <a href="<?php echo URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag'); ?>" class="btn btn-default iframe-btn"><?php echo e(trans('admin::countries.add_btn_image')); ?></a>
            </span>
        </div>
    </div>-->
    </div>
    <div class="col-md-6">
     <div class="form-group">
<!--        <label for="shopping_active">
            <input type="checkbox" name="shopping_active" value="1" <?php echo ($country->shopping_active==1)?'checked':''; ?> ><span> <?php echo e(trans('admin::countries.add_shopping')); ?></span> 
            <span class="help-block"><?php echo FormMessage::getErrorMessage('shopping_active'); ?></span>
        </label>
        <label for="inscription_active">
            <input type="checkbox" name="inscription_active" value="1"  <?php echo ($country->inscription_active==1)?'checked':''; ?>><span><?php echo e(trans('admin::countries.add_inscription')); ?></span> 
            <span class="help-block"><?php echo FormMessage::getErrorMessage('inscription_active'); ?></span>
        </label>
             <label for="admirable_customer">
                 <input type="checkbox" name="admirable_customer" value="1"  <?php echo ($country->customer_active==1)?'checked':''; ?>><span><?php echo e(trans('admin::countries.add_admirable_customer')); ?></span> 
            <span class="help-block"><?php echo FormMessage::getErrorMessage('admirable_customer'); ?></span>
        </label>-->
         
    </div>
    </div>
   
</div>



<div>
    <h3><?php echo e(trans('admin::language.lang_add_trans')); ?></h3>
    <p class="text-danger" style="font-style: italic;"><?php echo e(trans('admin::countries.disclaimer')); ?></p>

    <?php $__currentLoopData = $traslations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div role="panel-group" id="accordion-<?php echo e($lan['id']); ?>">
        <div class="panel panel-default">
            <div role="tab" class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-<?php echo e($lan['id']); ?>" href="#country-language-<?php echo e($lan['id']); ?>"><?php echo e(trans('admin::roles.modal_add.country-language-title') . $lan['language']); ?></a>
                </h4>
            </div>
            <div role="tabpanel" data-parent="#accordion-<?php echo e($lan['id']); ?>" id="country-language-<?php echo e($lan['id']); ?>"
                 class="panel-collapse <?php echo e(($lan['id'] == Session::get('language') || $errors->has('role_data['.$lan->id.'][name]')) ? 'in' : 'collapse'); ?>" >
                <div class="panel-body">
                    <h3><?php echo $lan->language; ?></h3>
                    
                        <div class="form-group">
                            <label class="control-label"><?php echo e(trans('admin::countries.add_name')); ?></label>
                            <input class="form-control" name="name_lang[]" value="<?php echo $lan->name; ?>" type="text">
                            <input  name="locale[]" type="hidden"  value="<?php echo e($lan->locale_key); ?>">
                            <input  type="hidden" name='language_id[]' value="<?php echo e($lan->id); ?>">                      
 <!--<input  type="hidden" name='language_id[]' value="<?php echo e($lan->id); ?>">-->
                        </div>
                 
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<!-- submit button -->
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; <?php echo e(isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button')); ?></button>

<?php echo Form::close(); ?>


<?php $__env->startSection('scripts'); ?>

<script type='text/javascript'>
    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_language_id').select2();
            var lan= $('#multiselect_language_id');
            var span=lan.siblings('span');
          span.css('width', '100%');
    });
</script>
<?php $__env->stopSection(); ?>