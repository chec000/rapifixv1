       
<h1><?php echo trans('admin::menu.update_menu'); ?></h1>
<p class="text-right"><a href="<?php echo e(route('admin.menuadmin.list')); ?>"><?php echo e(trans('admin::menu.return')); ?></a></p>
<?php echo Form::open(); ?>

<div>
       <span class="text-danger"><?php echo FormMessage::getErrorMessage('parent'); ?></span>
       <br>
              <span class="text-danger"><?php echo FormMessage::getErrorMessage('action'); ?></span>

</div>

<div class="row">
    <div class="col-md-6">
        <input type="hidden" name="id_menu" value="<?php echo $menu->id; ?>">
        <div class="form-group <?php echo FormMessage::getErrorClass('isPrincipal'); ?>">
            <?php echo Form::label('isPrincipal',  trans('admin::menu.is_action'), ['class' => 'control-label']); ?>

            <div class="radio" style="display: inline-block">
                <!--<?php echo e($menu); ?>-->
                <label onclick="displayAction()">
                    <!--<?php echo e($menu); ?>-->

                    <input type="radio" <?php echo e(($menu->action_id>0)? 'checked':''); ?>  name='isPrincipal' value="1"> 
                    <?php echo trans('admin::brand.form_add.is_principal'); ?> 
                </label> 
            </div>
            <div class="radio" style="display: inline-block">
                <label onclick="hideAction()">
                    <input type="radio" name='isPrincipal' value="0"  <?php echo ($menu->action_id==0)? 'checked':''; ?> >               
                    <?php echo trans('admin::brand.form_add.isnot_principal'); ?> 
                </label>         
            </div>    
            <span class="help-block"><?php echo FormMessage::getErrorMessage('isPrincipal'); ?></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group <?php echo FormMessage::getErrorClass('action'); ?>" id="div_action" style="display:<?php echo ($menu->action_id==0)? 'none':''; ?>">
            <?php echo Form::label('isPrincipal',  trans('admin::menu.select_action'), ['class' => 'control-label']); ?>

            <div class="">             
                <select class='form-control' name="action"  >
                    <option value="" id="no_selected_action"><?php echo trans('admin::menu.select'); ?></option>             
                    <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo ($a->id==$menu->action_id)?'selected':''; ?> value="<?php echo e($a->id); ?>"> <?php echo e($a->name); ?> </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>   
            </div>
                <span class="help-block"><?php echo FormMessage::getErrorMessage('action'); ?></span>
        </div>  
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">   
            <?php echo Form::label('isPrincipal',  trans('admin::menu.parent_action'), ['class' => 'control-label']); ?>


            <div class="radio" style="display: inline-block">
                <label onclick="displayParent()">
                    <input type="radio" <?php echo ($menu->parent>=0)? 'checked':''; ?>   name='parent_r' value="1"> 
                    <?php echo trans('admin::brand.form_add.is_principal'); ?> 
                </label>    
            </div>
            <div class="radio" style="display: inline-block">
                <label onclick="hideParent()">
                    <input type="radio" name='parent_r' value="0"  <?php echo ($menu->parent==0)? 'checked':''; ?>   > 

                    <?php echo trans('admin::brand.form_add.isnot_principal'); ?> 
                </label>         
            </div>    

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group <?php echo FormMessage::getErrorClass('parent'); ?>" id="parent_div" style="display:<?php echo ($menu->parent==0)? 'none':''; ?>">
            <?php echo Form::label('isPrincipal',  trans('admin::menu.select_parent'), ['class' => 'control-label']); ?>

            <div class="">             
                <select class='form-control' name="parent" id="parent_id">
                    <option value="" id="no_selected_parent"><?php echo trans('admin::menu.select'); ?></option>
                    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option  <?php echo ($a->id==$menu->parent)?'selected':''; ?>  value="<?php echo e($a->id); ?>"> <?php echo e($a->item_name); ?> </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
             <span class="help-block"><?php echo FormMessage::getErrorMessage('parent'); ?></span>
        </div>  
    </div>
</div>
<div class="row panel">
    <div class="col-md-6">
        <div  class="form-group <?php echo FormMessage::getErrorClass('icon'); ?>" id="" >
            <?php echo Form::label('parent_brand', trans('admin::menu.add_icon'), ['class' => 'control-label']); ?>

            <div class="">
                <?php echo Form::text('icon', $menu->icon, ['class' => 'form-control','required'] ); ?>

                <span class="help-block"><?php echo FormMessage::getErrorMessage('icon'); ?></span>
            </div>             
        </div>
    </div>
        <div class="col-md-6">
            <div class="form-group" id="order_menu" style="display:<?php echo ($menu->parent==0)? 'none':''; ?>">
            <?php echo Form::label('isPrincipal','orden', ['class' => 'control-label']); ?>     
            <!--<?php echo e($menu); ?>-->
            <select class='form-control' name="order" id="order">
                <option value=""><?php echo trans('admin::menu.select'); ?></option>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option   <?php echo e(($a->order==$menu->order)?'selected':''); ?> value="<?php echo e($a->order); ?>"> <?php echo e($a->order); ?> </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>

<div>
    <h3><?php echo e(trans('admin::language.lang_add_trans')); ?></h3>
    <p class="text-danger" style="font-style: italic;"><?php echo e(trans('admin::menu.mesagge_traslations')); ?></p>

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
                            <div class="form-group  <?php echo FormMessage::getErrorClass('name_lang'); ?>">
                                <label class="control-label"><?php echo e(trans('admin::countries.add_name')); ?></label>
                                <input   class="form-control" name="name_lang[]" value="<?php echo $lan->item_name; ?>" type="text">
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
<button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; <?php echo e(isset($countryEdit->id) ? trans('admin::countries.add_button') : trans('admin::countries.edit_button')); ?></button>

<?php echo Form::close(); ?>


<?php $__env->startSection('scripts'); ?>

<script type='text/javascript'>
    $(document).ready(function () {
        load_editor_js();
        $('#multiselect_language_id').select2();
    });
    function displayAction(){
            $("#div_action").css("display", "block");

}
function hideAction(){
        $("#div_action").css("display", "none");
        $("#no_selected_action").prop("selected", true);
}
function displayParent(){
            $("#parent_div").css("display", "block");
                $("#order_menu").css("display", "block");
}
function hideParent(){
        $("#parent_div").css("display", "none");
                $("#no_selected_parent").prop("selected", true);
                $("#order_menu").css("display", "none");
}
    $('#parent_id').on('change', function (e) {
        //  var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        var ruta=route('admin.menuadmin.order');
          $.ajax({
            url: ruta,
            type: 'POST',
            data: {menu_id: valueSelected},
            success: function (data) {
                if (data !== null) {
                    
                   var option_default=  '<option value=""><?php echo trans('admin::menu.select'); ?></option>';
                  var select_menu_order=  $("#order");
                     select_menu_order.empty();
                     select_menu_order.append(option_default);
                     
                     $.each( data, function( index, value ){                         
                        select_menu_order.append( '<option value='+value.id+'>'+value.order+'</option>');                               
                        });                  
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>


