
<h1><?php echo trans('admin::template.update_template'); ?></h1>
<p class="text-right"><a href="<?php echo e(route('admin.template.list')); ?>"><?php echo e(trans('admin::menu.return')); ?></a></p>
<?php echo Form::open(); ?>

<input type="hidden" name="template_id" value="<?php echo e($template->id); ?>">
<div class="row">
    <div class="col-md-12">
        <?php echo Form::label('template', trans('admin::template.add_template'), ['class' => 'control-label']); ?>               
        <div class="form-group <?php echo FormMessage::getErrorClass('template'); ?>">
    
            <input id="template" type="text" value="<?php echo e($template->template); ?>" class="form-control" name="template">
            <span class="help-block"><?php echo FormMessage::getErrorMessage('template'); ?></span>            

        </div>
    </div>                  
</div>
<div>
    <h3><?php echo e(trans('admin::language.lang_add_trans')); ?></h3>
    <p class="text-danger" style="font-style: italic;"><?php echo e(trans('admin::template.mesagge_traslations')); ?></p>


    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=> $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div role="panel-group" id="accordion-<?php echo e($lan['id']); ?>">
            <div class="panel panel-default">
                <div role="tab" class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-<?php echo e($lan['id']); ?>" href="#menu-language-<?php echo e($lan['id']); ?>"><?php echo e(trans('admin::language.country-language-title') . $lan['language']); ?></a>
                    </h4>
                </div>
                <div role="tabpanel" data-parent="#accordion-<?php echo e($lan['id']); ?>" id="menu-language-<?php echo e($lan['id']); ?>"
                     class="panel-collapse <?php echo e(($lan['id'] == Session::get('language') ? 'in' : 'collapse')); ?>" >
                    <div class="panel-body">
                        <h3><?php echo $lan->language; ?></h3>
                        <div class="form-group">
                            <!-- language name field -->
                            <div class="form-group">
                                <label class="control-label"><?php echo e(trans('admin::template.template')); ?></label>
                                <input   class="form-control" name="name_lang[]" value="<?php echo e($lan->label); ?>" type="text">
                                <input  name="locale[]" type="hidden"  value="<?php echo e($lan->locale_key); ?>">
                                <input  type="hidden" name='language_id[]' value="<?php echo e($lan->id); ?>">
                                <span class="text-danger"><?php echo $msg; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<!-- submit button -->
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-edit"></i> &nbsp; <?php echo e(isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button')); ?></button>

<?php echo Form::close(); ?>

