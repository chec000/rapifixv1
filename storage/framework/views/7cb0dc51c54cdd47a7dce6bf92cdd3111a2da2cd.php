<div class="container">
    <a class="btn btn-info btn-sm pull-right" href="<?php echo e(route('admin.categories.index')); ?>" role="button">
        <?php echo app('translator')->getFromJson('admin::shopping.categories.index.btn_return'); ?>
    </a>
    <?php if(session('msg')): ?>
        <div class="alert alert-success" role="alert"><?php echo e(session('msg')); ?></div>
    <?php elseif(session('errors') != null): ?>
        <div class="alert alert-danger" role="alert"><?php echo e(session('errors')->first('msg')); ?></div>
    <?php endif; ?>
    <h1><?php echo trans('admin::shopping.categories.add.view.title-add'); ?></h1>
    <form id="categories" method="POST" action="<?php echo e(route('admin.categories.store')); ?>">
        <?php echo e(csrf_field()); ?>

        <p class="lead">Brand: <strong id="brandName"></strong></p>
        <input type="hidden" name="brand_id" id="brand_id" value="">
        <input type="hidden" name="locale" id="locale" value="<?php echo e($locale); ?>">
        <input type="hidden" id="countries_by_brand" value="<?php echo e($countriesByBrand); ?>">

        <div class="form-group">
            <label for="global_name"><?php echo e(trans('admin::shopping.products.index.thead-product-global_name')); ?> *</label>
            <input type="text" name="global_name" id="global_name" class="form-control" required="required">
        </div>
        <div class="form-group">
         <label for="global_name"><?php echo e(trans('admin::shopping.categories.index.parent_category')); ?> *</label>
          <select class="form-control" name="parent_category">
            <option value="0">Ninguna</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <option value="<?php echo e($c->id); ?>"><?php echo e($c->global_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
          </select>
            
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-country'); ?></label><br />

            <ul id="countryForm" class="nav nav-tabs" role="tablist">
                <?php $__currentLoopData = Auth::user()->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uC): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li role="presentation" data-country-tab="<?php echo e($uC->id); ?>">
                        <a href="#<?php echo e(str_replace(' ', '_', $uC->name)); ?>" aria-controls="home" role="tab" data-toggle="tab">
                            <?php echo e($uC->name); ?> <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="tab-content">
                <?php $__currentLoopData = Auth::user()->countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $uC): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div role="tabpanel" class="tab-pane" id="<?php echo e(str_replace(' ', '_', $uC->name)); ?>" data-country-pane="<?php echo e($uC->id); ?>"> <br />

                        <div data-id="c_omni" class="form-group">
                            <label for="color"><?php echo e(trans('admin::shopping.categories.index.color')); ?></label>
                            <div id="bcolor_<?php echo e($uC->id); ?>_1" class="products-page inner"></div>
                            <select class="form-control select-color" name="color_<?php echo e($uC->id); ?>" data-brand="1">
                                <option value=""><?php echo e(trans('admin::shopping.categories.index.default')); ?></option>
                                <?php $__currentLoopData = $colorsOmnilife; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($class); ?>"><?php echo e(ucfirst($class)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div data-id="c_seytu" class="form-group">
                            <label for="color"><?php echo e(trans('admin::shopping.categories.index.color')); ?></label>
                            <div id="bcolor_<?php echo e($uC->id); ?>_2" class="products-page inner"></div>
                            <select class="form-control select-color" name="color_<?php echo e($uC->id); ?>" data-brand="2">
                                <option value=""><?php echo e(trans('admin::shopping.categories.index.default')); ?></option>
                                <?php $__currentLoopData = $colorsSeytu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($class); ?>"><?php echo e(ucfirst($class)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="oder_<?php echo e($uC->id); ?>"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.order'); ?></label>
                            <input name="order_<?php echo e($uC->id); ?>"
                                   type="number" min="1" max="30"
                                   class="form-control"
                                   id="order_<?php echo e($uC->id); ?>"
                                   placeholder="<?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.category'); ?>"
                                   value="<?php echo e(old('order_'.$uC->id, 30)); ?>">
                        </div>

                        <?php $__currentLoopData = Auth::user()->getCountryLang($uC->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langCountry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div role="panel-group" id="accordion-<?php echo e($uC->id); ?>-<?php echo e($langCountry->id); ?>">
                                <div class="panel panel-default">
                                    <div role="tab" class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                               href="#product-language-<?php echo e($uC->id); ?>-<?php echo e($langCountry->id); ?>">
                                                <?php echo e(trans('admin::shopping.products.add.second_general_tab.country-language-title') . $langCountry->language); ?>

                                            </a>
                                        </h4>
                                    </div>
                                    <div role="tabpanel" data-parent="#accordion" class="panel-collapse collapse"
                                         id="product-language-<?php echo e($uC->id); ?>-<?php echo e($langCountry->id); ?>" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.category'); ?> *</label>
                                                        <input name="category_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?>"
                                                               type="text" rel="requerido_<?php echo e($uC->id); ?>"
                                                               class="requerido requerido_<?php echo e($uC->id); ?> requerido_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?> form-control"
                                                               id="requerido_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?>"
                                                               placeholder="<?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.category'); ?>"
                                                               value="<?php echo e(old('category_'.$uC->id.'_'.$langCountry->id)); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label"
                                                               for="product-image-<?php echo e($uC->id); ?>-<?php echo e($langCountry->id); ?>">
                                                            <?php echo e(trans('admin::shopping.categories.add.input.select_banner')); ?>

                                                        </label>
                                                        <div class="input-group">
                                                            <input name="image_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?>" readonly="true"
                                                                   type="text" id="image_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?>"
                                                                   class="img_src requerido_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?> form-control"
                                                                   value="<?php echo e(old('image_'.$uC->id.'_'.$langCountry->id)); ?>">
                                                            <span class="input-group-btn">
                                                                <a href="<?php echo URL::to(config('admin.config.public') . '/filemanager/dialog.php?type=1&field_id=image_'.$uC->id.'_'.$langCountry->id); ?>"
                                                                   class="btn btn-default iframe-btn">
                                                                    <?php echo e(trans('admin::countries.add_btn_image')); ?>

                                                                </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.description'); ?></label>
                                                        <textarea name="description_<?php echo e($uC->id); ?>_<?php echo e($langCountry->id); ?>"
                                                                  class="form-control" rows="3"
                                                                  placeholder="<?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.description'); ?>"
                                                        ><?php echo e(old('description_'.$uC->id.'_'.$langCountry->id)); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <hr />
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-banner-link'); ?></label>
                            <input name="bannerLink_<?php echo e($uC->id); ?>" type="text" class="form-control"
                                   placeholder="<?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.banner-link'); ?>"
                                   value="<?php echo e(old('bannerLink_'.$uC->id)); ?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-active'); ?></label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_<?php echo e($uC->id); ?>" value="1" <?php if(old('active_'.$uC->id) == null || old('active_'.$uC->id)): ?> checked <?php else: ?> '' <?php endif; ?>>
                                    <?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.yes'); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="active_<?php echo e($uC->id); ?>" value="0" <?php echo e(old('active_'.$uC->id) === 0 ? ' checked' : ''); ?>>
                                    <?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.no'); ?>
                                </label>
                            </div>
                        </div><br />
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-product-select'); ?></label>
                            <input type="hidden" name="products_<?php echo e($uC->id); ?>" id="products_<?php echo e($uC->id); ?>" class="form-control"
                                   value="<?php echo e(old('products_'.$uC->id)); ?>"/>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="alert_<?php echo e($uC->id); ?>" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                        <?php echo app('translator')->getFromJson('admin::shopping.categories.add.error.select-product-error'); ?>
                                    </div>
                                </div>
                                <div class="col-xs-10">
                                    <select class="form-control" id="sel_<?php echo e($uC->id); ?>">
                                        <option id="opt_<?php echo e($uC->id); ?>" value="">
                                            <?php echo app('translator')->getFromJson('admin::shopping.categories.add.input.product'); ?>
                                        </option>
                                        <?php $__currentLoopData = Auth::user()->activeProductsByCountry($uC->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option id="opt_<?php echo e($prod->id); ?>_<?php echo e($uC->id); ?>" value="<?php echo e($prod->id); ?>"><?php echo e($prod->sku); ?> - <?php echo e($prod->global_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <button type="button" class="btn btn-default"
                                            onclick="addProduct(<?php echo e($uC->id); ?>, <?php echo e(Auth::user()->activeProductsByCountry($uC->id)); ?>)">
                                        <?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-add-button'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="alert_limit_<?php echo e($uC->id); ?>" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                <?php echo app('translator')->getFromJson('admin::shopping.categories.add.error.select-category'); ?>
                            </div>
                            <div id="alert_limit_home<?php echo e($uC->id); ?>" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                <?php echo app('translator')->getFromJson('admin::shopping.categories.add.error.select-banner'); ?>
                            </div>
                            <div id="alert_limit_category<?php echo e($uC->id); ?>" class="alert alert-danger btn-xs" role="alert" style="display: none; padding: 5px">
                                <?php echo app('translator')->getFromJson('admin::shopping.categories.add.error.select-home'); ?>
                            </div>
                            <table class="table text-center">
                                <tr>
                                    <th class="text-center" colspan="5"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-product-list'); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-list-id'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-list-sku'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->getFromJson('admin::shopping.products.add.first_general_tab.form-global-name-label'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-list-home'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-list-category'); ?></th>
                                    <th class="text-center"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-list-delete'); ?></th>
                                </tr>
                                <?php $__currentLoopData = Auth::user()->activeProductsByCountry($uC->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="dis_<?php echo e($prod->id); ?>_<?php echo e($uC->id); ?>" style="display: none">
                                        <td><?php echo e($prod->id); ?></td>
                                        <td><?php echo e($prod->sku); ?></td>
                                        <td><?php echo e($prod->global_name); ?></td>
                                        <td class="text-center">
                                            <i id="favOff_<?php echo e($prod->id.'_'.$uC->id); ?>" class="fa fa-eye-slash fa-2x"
                                               aria-hidden="true" onclick="addFavorite(<?php echo e($prod->id); ?>,<?php echo e($uC->id); ?>)"></i>
                                            <i id="favOn_<?php echo e($prod->id.'_'.$uC->id); ?>" class="fa fa-eye fa-2x"
                                               aria-hidden="true" onclick="quitFavorite(<?php echo e($prod->id); ?>,<?php echo e($uC->id); ?>)"
                                               style="color: green;display: none"></i>
                                        </td>
                                        <td class="text-center">
                                            <i id="catOff_<?php echo e($prod->id.'_'.$uC->id); ?>" class="fa fa-eye-slash fa-2x"
                                               aria-hidden="true" onclick="addCat(<?php echo e($prod->id); ?>,<?php echo e($uC->id); ?>)"></i>
                                            <i id="catOn_<?php echo e($prod->id.'_'.$uC->id); ?>" class="fa fa-eye fa-2x"
                                               aria-hidden="true" onclick="quitCat(<?php echo e($prod->id); ?>,<?php echo e($uC->id); ?>)"
                                               style="color: green;display: none"></i>
                                        </td>
                                        <td>
                                            <i id="<?php echo e($prod->id); ?>|<?php echo e($uC->name); ?>" class="del_btn fa fa-trash fa-2x"
                                               aria-hidden="true" onclick="delProduct(<?php echo e($prod->id); ?>,'<?php echo e($uC->id); ?>')"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="form-group text-center">
            <div class="alert alert-danger alert-info-input" role="alert" style="display: none">
                <?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-error'); ?>
            </div>
            <button type="submit" id="formCategoryButton" class="btn btn-default">
                <span class="btn-submit-text"><?php echo app('translator')->getFromJson('admin::shopping.categories.add.view.form-save-button'); ?></span>
                <span class="btn-submit-spinner" style="display: none"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></span>
            </button>
        </div>
    </form>
</div>



<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        function deleteTabsFromAnotherCountry(brandId) {
            var countriesByBrand = jQuery.parseJSON($('#countries_by_brand').val());
            countriesByBrand = countriesByBrand[brandId];

            $.each($('[data-country-tab]'), function (i, element) {
                if (countriesByBrand.indexOf($(element).data('country-tab')) == -1) { $(element).remove(); }
            });

            $.each($('[data-country-pane]'), function (i, element) {
                if (countriesByBrand.indexOf($(element).data('country-pane')) == -1) { $(element).remove(); }
            });
        }

        // Eliminar las tabs de los paises que no fueron seleccionados
        function deleteTabsFromUnselectedCountries() {
            // $('.form-check-input:not(:checked)')
            // $('.form-check-input:checked')

            countriesToCreate = [];
            $.each($('.form-check-input:checked'), function (i, checkbox) {
                countriesToCreate.push(parseInt($(checkbox).val()));
            });

            $.each($('[data-country-tab]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-tab')) == -1) { $(element).remove(); }
            });

            $.each($('[data-country-pane]'), function (i, element) {
                if (countriesToCreate.indexOf($(element).data('country-pane')) == -1) { $(element).remove(); }
            });
        }

        // Generar el checkbox de para cada país
        function generateCountryCheckbox(countryId, languages, name) {
            return '<div data-country-checkbox="'+countryId+'" name="check-countries">\
                <input onclick="enableNextButton()" class="form-check-input" id="checkCountry_'+countryId+'" value="'+countryId+'" type="checkbox">\
                <input id="country-langs-'+countryId+'" value="'+languages+'" type="hidden">\
                <label for="checkCountry_'+countryId+'" id="label-langsCountry_'+countryId+'" class="form-check-label">'+name+'</label>\
                </div>';
        }

        // Obtener los paises por marca
        function showCountriesByBrand(brand) {
            $.ajax({
                url: '<?php echo e(route('admin.categories.getcountries')); ?>',
                dataType: 'JSON',
                method: 'POST',
                data: {brand_id: brand},
                statusCode: { 419: function() {window.location.href = '<?php echo e(route('admin.home')); ?>'} }
            }).done(function (response, textStatus, jqXHR) {
                if (response.status) {
                    $('[data-country-checkbox]').remove();
                    $.each(response.countriesByBrand, function (i, country) {
                        $('#products-check-countries').append(generateCountryCheckbox(country.id, country.languages, country.name));
                    });
                }
            }).fail(function (response, textStatus, errorThrown) {
                console.log(response, textStatus, errorThrown);
            });
        }

        // Activar el botón para continuar con el formulario
        function enableNextButton() {
            var enable = false;

            $.each($('.form-check-input'), function (i, check) {
                if ($(check).is(':checked')) {
                    enable = true;
                }
            });

            if (enable) {
                $('#accept-modal').removeClass('disabled');
            } else {
                $('#accept-modal').addClass('disabled');
            }
        }

        $( document ).ready(function() {
            load_editor_js();
            $("#countryForm li a:first").click();
            $(".accordion-toggle:first").click();

            $('[data-id=c_seytu]').hide();
            $('[data-id=c_omni]').hide();

            // Inactivar el botón para continuar con el llenado del formulario
            $('#accept-modal').addClass('disabled');

            // Si ya se encuentra una marca seleccionada, mostrar sus paises
            if ($('[name="brand-user"]:checked').val() != undefined && $('[name="brand-user"]:checked').val() != '') {
                showCountriesByBrand($('[name="brand-user"]:checked').val());
            }

            // Modal para seleccionar la marca
            $('#brand-modal').modal({
                show: true,
                keyboard: false,
                backdrop: 'static',
            });

            // Acción para cancelar el formulario
            $('#close-modal').click(function () {
                history.go(-1);
            });

            $('[data-country-tab]').click(function () {
                var id = $(this).data('country-tab');
                $('[data-country-pane='+id+'] div[role=tabpanel]').removeClass('in');
                $('[data-country-pane='+id+'] div[role=tabpanel]').first().addClass('in');
            });

            // Acción una vez seleccionada la marca y el país
            $('#accept-modal').click(function () {
                var brandId = $('[name="brand-user"]:checked').val();

                var selectedCountry = false;
                $.each($('.form-check-input'), function (i, check) {
                    if ($(check).is(':checked')) {
                        selectedCountry = true;
                    }
                });

                if ((brandId != undefined && brandId != '') && selectedCountry != false) {
                    $('#brand_id').val( brandId );
                    $('#brandName').text( $('[name="brand-user"]:checked').data('name') );
                    $('#brand-modal').modal('hide');

                    if (brandId == 1) {
                        $('<link/>', {rel: 'stylesheet', type: 'text/css', href: '<?php echo e(asset('cms/app/css/omnilife.css')); ?>'}).appendTo('head');
                        $('[data-id=c_seytu]').remove();
                        $('[data-id=c_omni]').show();
                    } else if (brandId == 2) {
                        $('<link/>', {rel: 'stylesheet', type: 'text/css', href: '<?php echo e(asset('cms/app/css/seytu.css')); ?>'}).appendTo('head');
                        $('[data-id=c_omni]').remove();
                        $('[data-id=c_seytu]').show();
                    }

                    //deleteTabsFromAnotherCountry(brandId);
                    deleteTabsFromUnselectedCountries();

                    $.ajax({
                        url: '<?php echo e(route('admin.categories.getproducts')); ?>',
                        dataType: 'JSON',
                        method: 'POST',
                        data: {brand_id: $('[name="brand-user"]:checked').val()},
                        statusCode: { 419: function() {window.location.href = '<?php echo e(route('admin.home')); ?>'} }
                    }).done(function (response, textStatus, jqXHR) {
                        if (response.status) {
                            $.each(response.data, function (i, country) {
                                $('#sel_'+country.countryId).empty();
                                $('#sel_'+country.countryId).append('<option><?php echo e(trans('admin::shopping.categories.add.input.product')); ?></option>');

                                $.each(country.products, function (j, product) {
                                    $('#sel_'+country.countryId).append('<option id="opt_'+product.id+'_'+country.countryId+'" value="'+product.id+'">'+product.sku+' - '+product.global_name+'</option>');
                                });
                            });
                        }
                    }).fail(function (response, textStatus, errorThrown) {
                        console.log(response, textStatus, errorThrown);
                    });
                }
            });

            // Mostrar los paises por marca
            $('[name="brand-user"]').change(function () {
                showCountriesByBrand($(this).val());
            });

            $('.select-color').change(function () {
                var color = $(this).val();
                console.log('#b'+$(this).attr('name')+'_'+$(this).data('brand'));
                $('#b'+$(this).attr('name')+'_'+$(this).data('brand')).removeAttr('class');
                $('#b'+$(this).attr('name')+'_'+$(this).data('brand')).attr('class', 'products-page inner '+color);
            });
        });

        $( "#categories" ).submit(function( event )
        {
            $('.btn-submit-text').hide();
            $('.btn-submit-spinner').show();
            $('.alert-info-input').hide();
            $('#formCategoryButton').prop('disabled', true);

            var banderaFinal = 2;
            var exit = 1;
            $('.requerido').each(function(i, elem)
            {
                var nameClass = '.'+$(elem).attr('rel');
                var banderaLang = 0;
                var banderaCountry = 0;
                $(nameClass).each(function(i1, elem1)
                {
                    var nameId = '.'+$(elem1).attr('id');
                    var inputLang = 0;
                    var contLang = 0;
                    $(nameId).each(function(i2, elem2)
                    {
                        contLang ++;
                        if($(elem2).val() != ''){
                            $(elem2).css({'border':'1px solid #ccc'});
                            inputLang ++;
                        } else {
                            $(elem2).css({'border':'1px solid red'});
                        }
                    });
                    if(inputLang == contLang){
                        banderaLang = 1;
                    }
                    if(banderaLang == 1){
                        banderaCountry = 1;
                    }
                });
                if(banderaFinal == 2 || banderaFinal == 1){
                    if (banderaCountry == 1 && banderaLang == 1){
                        exit = 0;
                        banderaFinal = 1;
                    }else{
                        exit = 1;
                        banderaFinal = 0;
                    }
                }else{
                    exit == 1;
                }
            });
            if(exit == 1){
                event.preventDefault();
                $('.alert-info-input').show();
                $('.btn-submit-text').show();
                $('.btn-submit-spinner').hide();
                $('#formCategoryButton').prop('disabled', false);
            }
        });
    </script>
    <script>
        this.loadListProduct();
        function loadListProduct()
        {
            var userCountries = <?= Auth::user()->countries ?>;
            userCountries.forEach(function(element) {
                var idProd = $("#products_"+element.id).val();
                if(idProd != "")
                {
                    var prod = jQuery.parseJSON(idProd);
                    prod.forEach(function(element1) {
                        if (element1.home == 1){
                            $("#homOff_"+element1.id+"_"+element.id).hide();
                            $("#homOn_"+element1.id+"_"+element.id).show();
                        }
                        if (element1.favorite == 1){
                            $("#favOff_"+element1.id+"_"+element.id).hide();
                            $("#favOn_"+element1.id+"_"+element.id).show();
                        }
                        if (element1.category == 1){
                            $("#catOff_"+element1.id+"_"+element.id).hide();
                            $("#catOn_"+element1.id+"_"+element.id).show();
                        }
                        $("#opt_"+element1.id+"_"+element.id).hide();
                        $("#dis_"+element1.id+"_"+element.id).show();
                    });
                }
            });
            //var prodSelect = "#products_"+idCountry;

        }
        function addProduct(idCountry,allProduct)
        {
            // Se optiene id del producto seleccionado
            var idProd = $("#sel_"+idCountry).val();
            // Se valida que este seleccionado un producto
            if(idProd != ""){
                // se oculta la alerta
                $("#alert_"+idCountry).hide();
                // Se oculta el producto seleccionado del select
                $("#opt_"+idProd+"_"+idCountry).hide();
                // Se cambia el de elemento el select
                $("#sel_"+idCountry).val("");
                // Se muestra en la tabla el producto agregado
                $("#dis_"+idProd+"_"+idCountry).show();
                // Se guarda el producto agregado en el json.
                this.saveProduct(idProd,idCountry,allProduct);
            }else {
                // Se muestra mensaje de error
                $("#alert_"+idCountry).show();
            }
        }
        function saveProduct(idProd,idCountry,allProduct)
        {
            var prodSelect = "#products_"+idCountry;
            // Se recorre el array para guardar el producto seleccionado
            allProduct.forEach(function(element) {
                var ar = [];
                if(element.id == idProd){
                    // Se optiene la informacion del input
                    var prodJson = $(prodSelect).val();
                    // Se valida que no este vacio para agregar los elementos al array
                    if(prodJson != ""){
                        var obj = jQuery.parseJSON(prodJson);
                        ar = obj;
                    }
                    // se crea el objecto para agregarlo al array
                    var productAdd = new Object();
                    productAdd.id = element.id;
                    productAdd.sku = element.sku;
                    productAdd.favorite = 0;
                    productAdd.home = 0;
                    productAdd.category = 0;
                    // Se agrega el producto al array
                    ar.push(productAdd);
                    // Se inserta en el input para su envio
                    $(prodSelect).val(JSON.stringify(ar));
                }
            });
        }
        function delProduct(idProd, idCountry)
        {
            var prodSelect = "#products_"+idCountry;
            var obj = jQuery.parseJSON($(prodSelect).val());
            $("#favOff_"+idProd+"_"+idCountry).show();
            $("#favOn_"+idProd+"_"+idCountry).hide();
            obj.forEach(function(element, index) {
                if(element.id == idProd){
                    obj.splice(index,1);
                }
            });
            if(obj.length == 0){
                $(prodSelect).val("")
            }else {
                $(prodSelect).val(JSON.stringify(obj))
            }
            $("#dis_"+idProd+"_"+idCountry).hide();
            $("#opt_"+idProd+"_"+idCountry).show();
        }
        function addFavorite(idProd,idCountry)
        {
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if (element.favorite == 1){
                    count++;
                }
            });
            if (count < <?php echo e(config('settings::categories.home')); ?>){
                obj.forEach(function(element) {
                    if(element.id == idProd){
                        element.favorite = 1;
                        $("#favOff_"+idProd+"_"+idCountry).hide();
                        $("#favOn_"+idProd+"_"+idCountry).show();
                    }
                });
            }else{
                $("#alert_limit_"+idCountry).show();
            }
            $(prodSelect).val(JSON.stringify(obj));
        }
        function quitFavorite(idProd, idCountry)
        {
            $("#alert_limit_"+idCountry).hide();
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if(element.id == idProd){
                    element.favorite = 0;
                    $("#favOff_"+idProd+"_"+idCountry).show();
                    $("#favOn_"+idProd+"_"+idCountry).hide();
                }
            });
            $(prodSelect).val(JSON.stringify(obj));
        }
        function addCat(idProd,idCountry)
        {
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if (element.category == 1){
                    count++;
                }
            });
            if (count < 3){
                obj.forEach(function(element) {
                    if(element.id == idProd){
                        element.category = 1;
                        $("#catOff_"+idProd+"_"+idCountry).hide();
                        $("#catOn_"+idProd+"_"+idCountry).show();
                    }
                });
            }else{
                $("#alert_limit_category"+idCountry).show();
            }
            $(prodSelect).val(JSON.stringify(obj));
        }
        function quitCat(idProd, idCountry)
        {
            $("#alert_limit_category"+idCountry).hide();
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if(element.id == idProd){
                    element.category = 0;
                    $("#catOff_"+idProd+"_"+idCountry).show();
                    $("#catOn_"+idProd+"_"+idCountry).hide();
                }
            });
            $(prodSelect).val(JSON.stringify(obj));
        }
        function addHome(idProd,idCountry) {
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if (element.home == 1){
                    count++;
                }
            });
            if (count < 1){
                obj.forEach(function(element) {
                    if(element.id == idProd){
                        element.home = 1;
                        $("#homOff_"+idProd+"_"+idCountry).hide();
                        $("#homOn_"+idProd+"_"+idCountry).show();
                    }
                });
            }else{
                $("#alert_limit_home"+idCountry).show();
            }
            $(prodSelect).val(JSON.stringify(obj));
        }
        function quitHome(idProd, idCountry) {
            $("#alert_limit_home"+idCountry).hide();
            var prodSelect = "#products_"+idCountry;
            var prodJson = $(prodSelect).val();
            var obj = jQuery.parseJSON(prodJson);
            var count = 0;
            obj.forEach(function(element) {
                if(element.id == idProd){
                    element.home = 0;
                    $("#homOff_"+idProd+"_"+idCountry).show();
                    $("#homOn_"+idProd+"_"+idCountry).hide();
                }
            });
            $(prodSelect).val(JSON.stringify(obj));
        }
    </script>
<?php $__env->stopSection(); ?>
