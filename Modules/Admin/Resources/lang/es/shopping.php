<?php

/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 16/04/2018
 * Time: 02:47 PM
 */
return [
    /*
      |--------------------------------------------------------------------------
      | Pagination Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines are used by the paginator library to build
      | the simple pagination links. You are free to change them to anything
      | you want to customize your views to better match your application.
      |
     */

    'products' => [
        'index' => [            
            'title'=>'Lista de productos',
            'form-add-button'=>'Agregar nuevo producto',
            'thead-product-key'=>'Codigo de pais ',
            'thead-product-sku'=>'Producto SKU',
            'thead-product-brand'=>'Marca',
            'thead-product-countries'=>'Paises en los cuales el producto esta activo',
            'thead-product-languages'=>'Idioma del Producto',
            'thead-product-active'=>'Estado',
            'thead-product-actions'=>'Acciones',
            'product_active'=>'Activo',
            'product_inactive'=>'Inactivo',
            'edit_product'=>'Editar producto',
            'enable_product'=>'Habilitar producto',
            'disable_product'=>'Deshabilitar producto',
            'delete_product'=>'Eliminar producto',
            'delete_product_message'=>'El producto ha sido eliminado exitosamente',
            'thead-product-global_name' => 'Nombre Global (support)',
            'confirm' => '¿Estás seguro de eliminar este producto? Esta acción no puede revertirse.',
            'confirm_yes' => 'Sí ELIMINAR.',
            'confirm_no' => 'CANCELAR'
        ],
        'add' => [
            'input' => [
                'product'                   => 'Seleccionar un producto ',
            ],
            'first_general_tab' => [
                'title'                     => 'Información básica',
                'form-global-name-label'    => 'Nombre Global (support)',
                'form-sku-label'            =>'Producto SKU',
                'form-is-kit-label'         =>'Este producto es un Kit de inscripción',
                'select-country-label'      =>'Por favor seleccione los países en los que desea gestionar el producto',
                'select-brand-label'        =>'Por favor seleccione las marcas en los que desea gestionar el producto',
                'form-next-button'          => 'Siguiente ',
                'form-cancell-button'       => 'Cancelar',
                'Product'                   => 'Producto',
            ],
            'second_general_tab' => [
                'title'=>'Detalles de información del pais',
                'first-text'=>'Por favor ingrese la información del producto como el precio y los puntos especificos para cada pais. ',
                'country-tab-title'=>'Editar información para:',
                'country-form-price-label'=>'Precio:',
                'country-form-points-label'=>'Puntos:',
                'country-form-category-label'=>'Categoria:',
                'second-text'=>'Porfavor ingrese la información de producto en los idiomas disponibles para el pais, tome en cuenta que si no completa los campos completamente, la información no se mostrará correctamente. ',
                'country-language-title'=>'Editar para idioma:',
                'form-product-name-label'=>'Nombre de producto:',
                'form-product-description-label'=>'Descripción del producto:',
                'form-product-comments-label'=>'Comentarios del producto:',
                'form-product-short-description-label'=>'Descripción corta del producto:',
                'form-product-benefits-label'=>'Beneficios del producto:',
                'form-product-ingredients-label'=>'Ingredientes de producto:',
                'form-product-image-label'=>'Imagen del producto:',
                'form-product-nutritional-info-label'=>'Imagen del producto nutrimental:',
                'form-save-button'=>'Guardar',
                'form-cancell-button'=>'Cancelar',
                'country-form-active-product'=>'Activar producto'
            ],
            'alerts'=>[
                'empty-sku'=>'Debe ingresar un SKU valido ',
                'empty-sku-exist'               => 'El SKU ya existe',
                'empty-global-name'             => 'Debe escribir un nombre global',
                'empty-brand'=>'Debe seleccionar la marca ',
                'empty-country'=>'Debe seleccionar por lo menos un pais',
                'empty-country-price'=>'Debe ingresar un precio valido para el pais',
                'empty-country-points'=>'Debe ingresar puntos validos para el pais',
                'empty-country-category'=>'Debe seleccionar por lo menos una categoria de producto para el pais',
                'empty-country-language-item'=>'Informacion faltante en el campo de pais, pais:',
                'product-saved'=>'El producto ha sido agregado exitosamente',
                'error-saving-product'=>'Ocurrio un error mientras se guardaba el producto, por favor verificar la información e intentar de nuevo, si el problema persiste, por favor contactar a centro del servicio.',
                'errorQuantityRelated'=>'Debe seleccionar los productos relacionados. ',
                'error-info'=>'Debe ingresar toda la informacion en por lo menos un idioma por pais.',
                'cancell-dialog-title'=>'Confirmar',
                'cancell-dialog-content'=>'Esta seguro que quiere cancelar?',
                'cancell-dialog-button-yes'=>'Si',
                'cancell-dialog-button-no'=>'No',
                'warning-limit-chars'           => 'Limitado a 140 caracteres',
            ],
        ],
        'updateproduct' => [
            'label' => [
                'select_country' => 'Seleccionar país',
                'inst_01'   => 'Descargar archivo CSV de prueba haciendo click debajo',
                'file_demo' => 'Archivo base',
                'inst_02'   => 'Edite la información correspondiente en las columnas de Código de producto, Precio, Puntos y Estado.
                               Dependiendo de la cantidad de productos será el número de filas que tendrá el archivo.',
                'inst_03'   => 'Guarde los cambios y cargue el archivo actualizado desde aquí',
                'success'   => 'El producto ha sido actualizado correctamente.',
                'load_csv'     => 'Cargar CSV de precios',
            ],
            'error' => [
                'empty_file' => 'El archivo cargado no contiene registros',
                'incomplete' => 'Los datos son incompletos',
                'price'      => 'El precio debe ser un valor numerico mayor a 0',
                'point'      => 'Los puntos deben ser representados por un valor numerico',
                'status'     => 'El estatus debe ser: 1 activo o 0 inactivo',
                'notexist'   => 'El SKU del registro no existe',
            ]
        ],
    ],
    'categories' => [
        'index' => [
            'parent_category'=>'Seleccionar categoria padre',
            'title'=>'Lista de categoria',
            'form-add-button'=>'Agregar categoria',
            'thead-category-name'=>'Categoria:',
            'thead-category-name-global' => 'Nombre global de categoría (support)',
            'thead-category-brand'=>'Marca',
            'thead-category-countries'=>'Pais',
            'thead-category-languages'=>'Idiomas',
            'thead-category-active'=>'Estado',
            'thead-category-actions'=>'Acciones',
            'category_active'=>'Activo',
            'category_inactive'=>'Inactivo',
            'edit_category'=>'Editar categoria',
            'enable_category'=>'Habilitar categoria',
            'disable_category'=>'Inhabilitar categoria',
            'delete_category'=>'Eliminar categoria',
            'btn_return'=>'Regresar',
            'confirm' => '¿Estás seguro que deseas eliminar esta categoría? Esta acción no puede revertirse.',
            'confirm_yes' => 'Sí, ELIMINAR',
            'confirm_no' => 'CANCELAR'
        ],
        'add' => [
            'view' => [
                'title-add'=>'Agregar nuevas categorias',
                'title-edit'=>'Editar nuevas categorias',
                'form-brand'=>'Seleccionar marca que pertenece a la categoria',
                'form-country'=>'Pulsar en el nombre de pais y despues en el idioma para ingresar su informacion',
                'form-active'=>'Activar categoria',
                'form-product-select'=>'Agregar productos relacionados al producto',
                'form-product-list'=>'Lista de productos agregados al producto',
                'form-error'=>'Debe de ingresar por lo menos la informacion obligatoria de un idioma por pais',
                'form-list-banner'=>'Producto para banner',
                'form-list-home'=>'Producto para seccion de inicio',
                'form-list-category'=>'Productos para sección de categoria',
                'form-banner-link'=>'Enlace para banner',
                'form-list-delete'=>'Eliminar',
                'form-add-button'=>'Agregar',
                'form-save-button'=>'Guardar',
                'form-next-button'=>'Siguiente',
                'form-cancell-button'=>'Cancelar',
                'form-brands'=>'Marcas',
                'form-countries'       => 'Seleccione paises para editar',
                'form-list-id'         => 'ID',
                'form-list-sku'        => 'SKU',
            ],
            'input' => [
                'category'               => 'Nombre de la categoría',
                'yes'                    => 'Si',
                'no'                     => 'No',
                'title'                  => 'Titulo',
                'subtitle'               => 'Subtitulo',
                'description'            => 'Descripción',
                'product'                => 'Seleccionar producto',
                'select_banner'          => 'Seleccionar el banner principal',
                'banner-link'            => 'Ingresar enlace para el banner',
            ],
            'error'=>[
                'select-product-error'  => 'Seleccionar un producto.',
                'select-category'       => 'Solo puede agregar un maximo de 3 productos.',
                'select-banner'         => 'Solo puede agregar 1 articulo principal.',
                'select-home'           => 'Solo puede agregar '. config('settings::categories.home') .' articulo principal.',
                'category-error'        => 'Error al actualizar la categoría',
                'controller-success'    => 'Categoría creada correctamente',
                'controller-country'    => 'Error al intentar guardar la categoría en el país',
                'controller-info'       => 'Error al guardar la información de la categoría',
                'controller-product'    => 'Error al guardar el producto en la categoría',
            ],
        ],
        'edit' => [
            'error'=>[
                'controller-success'    => 'La categoría se actualizo correctamente',
                'controller-category-info'       => 'Error al editar información de la categoría',
                'controller-category-product'    => 'Error al editar producto en la categoría',
            ],
        ]
    ],
    'systems' => [
        'index' => [
            'title'=>'Lista de sistemas',
            'form-add-button'=>'Agregar sistema',
            'thead-category-name'=>'Sistemas',
            'thead-category-name-global' => 'Nombre global de sistemas (support)',
            'thead-category-brand'=>'Marca',
            'thead-category-countries'=>'Pais',
            'thead-category-languages'=>'Idiomas',
            'thead-category-active'=>'Estado',
            'thead-category-actions'=>'Acciones',
            'category_active'=>'Activo',
            'category_inactive'=>'Inactivo',
            'edit_category'=>'Editar sistema',
            'enable_category'=>'Habilitar sistema',
            'disable_category'=>'Inhabilitar sistema',
            'delete_category'=>'Eliminar sistema',
            'btn_return'=>'Regresar',
            'confirm' => '¿Estás seguro de eliminar este sistema? Esta acción no puede revertirse.',
            'confirm_yes' => 'Sí ELIMINAR',
            'confirm_no' => 'CANCELAR'
        ],
        'add' => [
            'view' => [
                'title-add'=>'Agregar sistema',
                'title-edit'=>'Editar sistema',
                'form-brand'=>'Seleccionar marca que pertenece al sistema',
                'form-country'=>'Hacer click en el nombre del pais y luego en el idioma para ingresar su ingormacion ',
                'form-active'=>'Activar sistema',
                'form-product-select'=>'Agregar productos al sistema',
                'form-product-list'=>'Lista de productos agregada al sistema',
                'form-error'=>'Debe ingresar minimo la informacion obligatoria (*) de un idioma para cada pais',
                'form-error-prod-sys'=>'Debe seleccionar por lo menos un producto para el sistema',
                'form-list-banner'=>'Producto para banner',
                'form-list-home'=>'Producto para seccion de inicio',
                'form-list-category'=>'Producto para seccion de sistema',
                'form-link-one'=>'Enlace para banner principal',
                'form-link-two'=>'Enlace para banner de sistema',
                'form-list-delete'=>'Eliminar',
                'form-add-button'=>'Agregar',
                'form-save-button'=>'Guardar',
                'form-next-button'=>'Siguiente',
                'form-cancell-button'=>'Cancelar',
                'form-list-id'         => 'ID',
                'form-list-sku'        => 'SKU',
            ],
            'input' => [
                'category'=>'Nombre del sistema',
                'yes'=>'Si',
                'no'=>'No',
                'title'=>'Titulo',
                'benefit'=>'Beneficio',
                'description'=>'Descripción',
                'product'=>'Seleccionar un producto ',
                'select_banner_one'=>'Seleccionar banner principal',
                'select_banner_two'=>'Seleccionar banner de sistema',
                'link_one'=>'Enlazar banner principal',
                'link_two'=>'Enlazar banner de sistema',
                'banner-link'=>'Ingreasar el enlace para el banner'
            ],
            'error'=>[
                'select-product'=>'Seleccionar producto',
                'select-category'=>'Solo puede agregar un maximo de 3 productos',
                'select-banner'=>'Solo puede agregar 1 articulo principal',
                'select-home'=>'Solo puede agregar'. config('settings::categories.home'),
                'category-error'=>'Error al actualizar el sistema',
                'controller-success'=>'Sistema creado correctamente',
                'controller-country'=>'Error al intentar guardar el sistema en el pais',
                'controller-info'=>'Error al guardar la informacion del sistema',
                'controller-product'=>'Error al guardar el producto en el sistema'
            ],
        ],
        'edit' => [
            'error'=>[
                'controller-success'=>'El sistema se actualizo correctamente',
                'controller-category-info'=>'Error al editar la información del sistema',
                'controller-category-product'=>'Error al editar el producto en el sistema'
            ],
        ]
    ],
    'filters' => [
        'view' => [
            'title_add'        => 'Agregar nuevo filtro',
            'title_edit'       => 'Editar filtro',
            'title_rel'        => 'Relacionar filtros con marcas',
            'title_popup'      => 'Seleccionar marca y países a los que pertenecerá el filtro',
            'form-country'     => 'Haga clic en el nombre del país y luego en el idioma para ingresar su información',
            'filter'           => 'Filtrar',
            'product'          => 'Productos',
            'delete'           => 'Borrar',
            'brand'            => 'Marcas',
            'country'          => 'Países',
        ],
        'input' => [
            'label' => [
                'filter'  => 'Ingrese el nombre del filtro',
                'active'  => 'Seleccione si el filtro estará activo',
                'country'  => 'Seleccione un país para cargar su información',
                'category'  => 'Seleccione la categoría',
                'product'  => 'Seleccione el producto',
            ],
            'placeholder' => [
                'filter'  => 'Nombre del filtro',
                'yes'     => 'Si',
                'no'      => 'No',
            ]
        ],
        'buttons' => [
            'back_list'   => 'Regresar al listado',
            'save' => 'Guardar'
        ],
        'message' => [
            'success' => [
                'filter_category' => 'La información se ha guardado correctamente',
            ],
            'error'=> [
                'brand' => 'Seleccione una marca y un país como mínimo',
                'not_countries' => 'No tiene permiso en ningún país de los filtros asignados',
            ],
        ],

        'index' => [
            'title'=>'Lista de filtros',
            'form-add-button'=>'Agregar filtro',
            'thead-name'=>'Filtros',
            'thead-name-global' => 'Filtro de nombre global(support)',
            'thead-brand'=>'Marca',
            'thead-country'=>'Pais',
            'thead-languages'=>'Idiomas',
            'thead-active'=>'Estado',
            'thead-actions'=>'Acciones',
            'category_active'=>'Activo',
            'category_inactive'=>'Inactivo',
            'edit_category'=>'Editar filtro',
            'enable_category'=>'Habilitar filtro',
            'disable_category'=>'Inhabilitar filtro',
            'delete_category'=>'Eliminar filtro',
            'btn_return'=>'Regresar'
        ],
        'add' => [
            'label' =>[
                'title1'=>'Agregar filtro nuevo',
                'brands'=>'Seleccionar marca que permanece al sistema',
                'categories'=>'Seleccionar categoria',
                'button-next'=>'Siguiente',
                'title'=>'Agregar nuevo filtro para la categoria',
                'filter'=>'Nombre de filtro ',
                'active'=>'Activar filtro',
                'select'=>'Agregar productos al filtro',
                'button-add'=>'Agregar',
                'product-list'=>'Lista de productos agregados al filtro',
                'list-id'=>'Id',
                'list-sku'=>'SKU',
                'list-delete'=>'Eliminar',
                'button-save'=>'Guardar',
            ],
            'input' => [
                'filter'=>'Filter',
                'categories'=>'Seleccione una categoría.',
                'yes'=>'Si',
                'no'=>'No',
                'product'=>'Seleccione un producto de la categoría'
            ],
        ],
        'edit' => [
        ],
        'error' => [
            'bd'=>'Error en la base de datos',
            'brands'=>'Seleccionar una marca',
            'categories'=>'Seleccionar una categoria',
            'select'=>'Primero seleccione un producto ',
            'required-fields'=>'Debe ingresar minimo la informacion obligatoria (*) de un idioma para cada pais',
            'product-filter'=>'Debe seleccionar por lo menos un producto para el filtro',
            'controller-success'=>'El filtro se actualizo correctamente',
            'controller-category-info'=>'Error al editar informacion de filtro',
            'controller-category-product'=>'Error al editar el producto en el filtro'
        ],
    ],
    'warehouses' => [
        'index' => [
            'title'                          => 'Lista de almacenes',
            'form-add-button'                => 'Agregar almacen',
            'thead-name'                     => 'Almacenes',
            'thead-country'                  => 'País',
            'thead-active'                   => 'Status',
            'thead-actions'                  => 'Acciones',
            'active'                         => 'Activo',
            'inactive'                       => 'Inactivo',
            'edit'                           => 'Editar almacen',
            'enable'                         => 'Activar almacen',
            'disable'                        => 'Desactivar almacen',
            'delete'                         => 'Borrar almacen',
            'btn_return'                     => 'Regresar'
        ],
        'add' => [
            'label' =>[
                'title'                      => 'Agregar nevo almacen',
                'title-edit'                 => 'Editar almacen',
                'legend_add'                 => 'Campos globales',
                'back_list'                  => 'Lista',
                'warehouse'                  => 'Nombre de almacen',
                'country'                    => 'Paises',
                'button-save'                => 'Guardar',
            ],
            'input' => [
                'warehouse'                  => 'Nombre almacen',
            ],
        ],
        'product' => [
            'label' =>[
                'title'        => 'Añadir almacenes al producto',
                'countries'    => 'Seleccione un país para cargar los almacenes',
                'product'      => 'Producto seleccionado',
                'wherehouses'  => 'Almacenes def',
                'wherehouse'   => 'Almacén',
                'status'       => 'Estado',
                'action'       => 'Acciones
',
            ],
        ],
        'error' => [
            'bd'                             => 'Error en la base de datos',
            'country'                        => '*Seleccione un país mínimo',
            'controller-success'             => 'La información se ha guardado correctamente',
            'controller-category-info'       => 'Error al editar la información del filtro',
            'controller-category-product'    => 'Error al editar el producto en el filtro',
        ],
    ],
    'bulkload' => [
        'views' => [
            'title_index' => 'Iniciar carga',
            'load-product' => 'Leer productos',
            'load-related' => 'Leer productos relacionados',
            'load-category' => 'Leer categorias',
            'load-system' => 'Leer sistema',
            'load-warehouses'=>'Leer almacenes',
            'response' => 'Respuesta',
        ],
        'inputs' => [
            'labels' => [
                'product' => 'Seleccionar el archivo de productos',
                'related' => 'Seleccionar el archivo de productos relacionados',
                'category' => 'Seleccionar el archivo de categorias',
                'system' => 'Seleccionar el archivo para leer el sistema',
                'warehouse'=>'Seleccionar el archivo para leer los almacenes'
            ],
            'placeholders' => [
                'file' => 'Seleccionar su archivo .csv',
            ],
        ],
        'buttons' =>[
            'save' => 'Guardar',
            'submit' => 'Enviar',
        ],
        'messages' => [
            'success' => [
                'product' => 'El producto se ha guardado correctamente',
            ],
            'errors' => [
                '500' => 'Póngase en contacto con el administrador del sistema',
                'empty_file' => 'El archivo no contiene registros'
            ],
        ],
    ],
    'reports' => [
        'views' => [
            'title_index' => 'Reportes',
            'title_order' => 'Reporte de ordenes',
            'order' => 'Reporte de ordenes',
            'filter' => 'Filtros',
            'survey_report'=>'Reporte de encuesta',
            'type_survey_label'=>'Tipo de reporte',
            'type_survay_report'=>'Tipo de encuesta',
             'general'=>'General',
            'detail'=>'Detallado',
            'portal'=>'Portal',
            'oe'=>'Zona de empresarios'
            
        ],
        'modals' => [
            'title' => 'Reportes',
            'select' => 'Selecciona el reporte que deseas descargar:',
            'select_report'=>'Selecciona el reporte'
        ],
        'inputs' => [
            'labels' => [
                'from' => 'Fecha inicio',
                'to' => 'Fecha fin',
                'eo' => 'Código de Empresario',
                'country' => 'País',
            ],
            'placeholders' => [
                'from' => '2018-06-01',
                'to' => '2018-06-01',
                'eo' => 'Código de Empresario',
            ],
        ],
        'buttons' =>[
            'save' => 'Guardar',
            'submit' => 'Descargar',
        ],
        'messages' => [
            'success' => [
                'exportFile' => 'El archivo .xlsx fue generado',
            ],
            'errors' => [
                'noInfo' => 'No existe datos',
            ],
        ],
    ],
    'productsrestriction' => [
        'label' => [
            'title' => 'Productos restringidos por país',
            'fieldset_tit' => 'Products',
            'countries' => 'Selecciona un país',
            'state' => 'Selecciona un estado',
            'delete' => 'Eliminar búsqueda',
            'product' => 'Selecciona un producto',
            'button-save' => 'Guardar',
            'back_list' => 'Regresar al listado',
            'table' => [
                'product' => 'Producto',
                'state' => 'Estado',
                'delete' => 'Eliminar',
            ],
        ],
    ],
    'orderestatus' => [
        'index' => [
            'list_estatus'              => 'Lista de estatus de ordenes',
            'add_new_orderestatus'      => 'Agregar nuevo estado de orden',
            'key_estatus'               => 'Clave de Estados de Orden',
            'countries'                 => 'Paises',
            'actions'                   => 'Acciones',
            'status'                    => 'Estados',
            'enable'                    => 'Habilitar',
            'disable'                   => 'Inhabilitar',
            'delete'                    => 'Eliminar',
        ],
        'add' => [
            'new_orderestatus' => 'Agregar nuevo estado de orden',
            'key'              => 'Clave Estados',
            'country'          => 'País',
            'countries'        => 'Paises',
            'oe_translates'    => 'Traducciones de estados de orden',
            'oe_disclaimer'    => 'Por favor ingrese la información del estado de orden en los idiomas disponibles, tome en cuenta que si no completa todos los campos, la información no se mostrará correctamente.',
            'name_orderestatus'=> 'Nombre',
            'description'      => 'Descripción',
            'btn_add'          => 'Agregar estado de orden',
            'back_list'        => 'Regresar',
            'legend_add'       => 'Campos globales',
            'comment'          => 'Comentario',
            'keyempty'         => 'Clave vacia',
            'success'          => 'Estado de orden creado exitosamente',
            'failed'           => 'No se puede actualizar el estado del pedido, intente de nuevo',
        ],
        'update' => [
            'updateoe'         => 'Actualizar estado de pedido',
            'btn_update'       => 'Actualizar',
            'keyempty'        => 'Clave vacia',
            'success'          => 'Estado de pedido actualizado exitosamente',
            'failed'           => 'No se puede actualizar el estado del pedido, intente de nuevo',
        ]

    ],
    'registrationreferences' => [
        'index' => [
            'list_estatus'              => 'Lista de referencias de registro',
            'add_new_registrationreferences'      => 'Agregar nueva referencia de registro',
            'key_estatus'               => 'Clave de referencia',
            'countries'                 => 'Paises',
            'actions'                   => 'Acciones',
            'status'                    => 'Estado',
            'enable'                    => 'Habilitar',
            'disable'                   => 'Inhabilitar',
            'delete'                    => 'Eliminar',
            'close'                     => 'Cerrar',
            'save'                      => 'Guardar cambios',
        ],
        'add' => [
            'new_registrationreferences' => 'Agregar nueva referencia de registro',
            'key'              => 'Clave de referencia',
            'countries'        => 'Paises',
            'oe_translates'    => 'Traducciones de referencias de registro',
            'oe_disclaimer'    => 'Por favor ingresa la información de referencia de registro en los idiomas disponibles, si no son llenados todos los campos la información de las referencias no será mostrada correctamente.',
            'name'             => 'Nombre referencia',
            'description'      => 'Descripción',
            'btn_add'          => 'Agregar referencia de registro',
            'back_list'        => 'Regresar',
            'legend_add'       => 'Campos globales',
            'comment'          => 'Comentario',
            'keyempty'         => 'Clave vacia',
            'success'          => 'Referencia de registro creada exitosamente',
            'failed'           => 'No fue posible crear el registro, intente de nuevo',
        ],
        'update' => [
            'updateoe'         => 'Actualize referencia de registro',
            'btn_update'       => 'Actualizar',
            'keyempty'        => 'Clave vacia',
            'success'          => 'Referencia de registro actualizada exitosamente',
            'failed'           => 'No se pudo actualizar la referencia de registro, intente de nuevo',
        ]

    ],
    'securityquestions' => [
        'index' => [
            'list_estatus'              => 'Lista de preguntas de seguridad',
            'add_new_securityquestions'      => 'Agregar pregunta de seguridad',
            'key_question'               => 'Pregunta clave',
            'countries'                 => 'Paises',
            'actions'                   => 'Acciones',
            'status'                    => 'Estado',
            'enable'                    => 'Habilitar',
            'disable'                   => 'Inhabilitar',
            'delete'                    => 'Eliminar',
        ],
        'add' => [
            'new_securityquestions' => 'Agregar nueva pregunta de seguridad',
            'key'              => 'Pregunta clave',
            'countries'        => 'Paises',
            'oe_translates'    => 'Traducciones de preguntas de seguridad',
            'oe_disclaimer'    => 'Por favor ingresa la información de preguntas de seguridad en los idiomas disponibles, si no son llenados todos los campos la información de las preugntas no será mostrada correctamente.',
            'name'             => 'Preguntas',
            'btn_add'          => 'Agregar pregunta de seguridad',
            'back_list'        => 'Regresar',
            'legend_add'       => 'Campos globales',
            'comment'          => 'Comentario',
            'keyempty'         => 'Clave vacia',
            'success'          => 'La pregunta de seguridad se ha creado exitosamente',
            'failed'           => 'No se pudo crear la pregunta de seguridad, intente de nuevo',
        ],
        'update' => [
            'updateoe'         => 'Actualizar pregunta de seguridad',
            'btn_update'       => 'Actualizar',
            'keyempty'        => 'Clave vacia',
            'success'          => 'La pregunta de seguridad se actualizo exitosamente',
            'failed'           => 'No se pudo actualizar la pregunta de seguridad, intente de nuevo',
        ]

    ],
    'registrationparameters' => [
        'index' => [
            'list_estatus'              => 'Lista de parametros de registro',
            'add_new_registrationparameters'      => 'Agregar nuevo parametro de registro',
            'key_question'              => 'Pregunta clave',
            'countries'                 => 'Paises',
            'actions'                   => 'Acciones',
            'status'                    => 'Estado',
            'enable'                    => 'Habilitar',
            'disable'                   => 'Inhabilitar',
            'delete'                    => 'Eliminar',
            'country'                   => 'Páis',
            'min_age'                   => 'Edad minima',
            'max_age'                   => 'Edad máxima',
            'has_documents'             => '¿Tiene documentos?',
        ],
        'add' => [
            'new_registrationparameters' => 'Agregar nuevo parametro de registro',
            'key'              => 'Pregunta clave',
            'country'          =>'País',
            'min_age'          => 'Edad minima',
            'max_age'          => 'Edad máxima',
            'has_documents'    => '¿Tiene documentos?',
            'has_documents_yes'=> 'Si',
            'has_documents_no' => 'No',
            'btn_add'          => 'Agregar parametro de registro',
            'back_list'        => 'Regresar',
            'legend_add'       => 'Campos globales',
            'comment'          => 'Comentario',
            'keyempty'         => 'Clave vacia',
            'success'          => 'Perimetro de registro creado exitosamente',
            'failed'           => 'No se puede crear parametro de registro, intente de nuevo',
            'max_age_validation' => 'La edad minimia no puede ser igual o mayor a la máxima y viceversa',
            'countryempty'    => 'País debe ser seleccionado',
            'minageempty'     => 'Edad minima',
            'maxagempty'      => 'Edad máxima',
            'hundredvalidation' => 'La edad minima y máxima no pueden ser menores que 1 ni mayores a 100',
        ],
        'update' => [
            'updateoe'         => 'Actualizar parametro de registro',
            'btn_update'       => 'Actualizar',
            'keyempty'         => 'Clave vacia',
            'success'          => 'Parametro de registro actualizado exitosamente',
            'failed'           => 'No se pudo actualizar el parametro de registro, intente de nuevo',
        ]

    ],
    'blacklist' => [
        'index' => [
            'list_estatus'              => 'Lista negra',
            'add_new_blacklist'      => 'Agregar a lista negra',
            'eo_number'                 =>'Numero de distribuidor',
            'country'                   => 'Páis',
            'countries'                 => 'Paises',
            'actions'                   => 'Acciones',
            'status'                    => 'Estado',
            'enable'                    => 'Habilitar',
            'disable'                   => 'Inhabilitar',
            'delete'                    => 'Eliminar',
            'eo_numberempty'           => 'Numero de distribuidor vacío ',
        ],
        'add' => [
            'new_blacklist'    => 'Agregar a lista negra',
            'eo_number'        => 'Numero de distribuidor',
            'country'          => 'País',
            'min_age'          => 'Edad minima',
            'max_age'          => 'Edad maxima',
            'has_documents'    => '¿Tiene documentos?',
            'btn_add'          => 'Agregar a la lista negra',
            'back_list'        => 'Regresar',
            'legend_add'       => 'Campos globales',
            'comment'          => 'Comentario',
            'eo_numberempty'   => 'Número de distribuidor vacio',
            'success'          => 'Agregado exitosamente',
            'failed'           => 'No se puede agregar al distribuidor, intente de nuevo',
            'option'           => 'Seleccione una opción',
            'valid'            => 'Empresario valido',
        ],
        'update' => [
            'updateoe'         => 'Actualizar lista negra',
            'btn_update'       => 'Actualizar',
            'eo_numberempty'   => 'Numero de distribuidor vacío ',
            'success'          => 'Se actualizo exitosamente',
            'failed'           => 'No se puede actualizar la lista negra, intente de nuevo'
        ]

    ],
    'banks' => [
        'index' => [
            'list_estatus'              => 'Bancos',
            'add_new_banks'              => 'Agregar banco',
            'bank_key'                 =>  'Identificador de banco',
            'instructions'              => 'Marca la casilla para activar el país. desmarcarla para inactivarlo',
            'url'                       => 'Url',
            'logo'                      => 'Logo',
            'actions'                   => 'Acciones',
            'status'                    => 'Estatus',
            'enable'                    => 'Activar',
            'disable'                   => 'Desactivar',
            'delete'                    => 'Eliminar',
            'countries'                   => 'País',
            'bank_keyempty'             =>  'Identificador de banco vacío',
            'country_idempty'           => 'País Vacio',
            'urlempty'                  => 'Url vacia',
            'countriesupdated'          => 'El estatus de los paises fue modificado correctamente',
            'failedcountries'           => 'No se pudo actualizar el estatus de los paises, intente de nuevo',
            'close'                     => 'Cerrar',
            'save'                      => 'Guardar cambios',


        ],
        'add' => [
            'new_banks'                 => 'Agregar Banco',
            'countries'                 => 'País',
            'bank_key'                  => 'Identificador banco',
            'url'                       => 'Url',
            'logo'                      => 'Logo',
            'btn_add'                   => 'Agregar banco',
            'back_list'                 => 'Regresar a lista',
            'legend_add'                => 'Campos globales',
            'comment'                   => 'Comment',
            'translates'                => 'Traducciones bancos',
            'disclaimer'                => 'Please enter the banks information in the available languages, please note that if you do not fill in all the fields the banks information will not be displayed correctly.',
            'success'                   => 'Agregado correctamente',
            'failed'                    => 'No se puedo agregar el registro, intente de nuevo',
            'option'                    => 'Elige un opción',
            'bank_keyempty'             =>  'Identificado de banco vacio',
            'country_idempty'           => 'País vacio',
            'urlempty'                  => 'Url vacia',
            'image'                     => 'Imagen',
            'name'                      => 'Nombre',
            'description'               => 'Descripción',

        ],
        'update' => [
            'updateoe'         => 'Actualziar banco',
            'btn_update'       => 'Actualizar',
            'bank_keyempty'             =>  'Identificador de banco vacio',
            'country_idempty'           => 'País vacio',
            'urlempty'                  => 'Url vacia',
            'success'          => 'Actualizado correctamente',
            'failed'           => 'No fue posible actualiza, intente nuevamente',
        ]

    ],
    'orders' => [
        'index' => [
            'distributor_number' => 'Número distribuidor',
            'order_number'       => 'Número de orden',
            'corbiz_order_number' => 'Orden Corbiz',
            'date_created'        => 'Fecha de la orden',
            'payment_type'        => 'Tipo de pago',
            'status'              => 'Estatus',
            'actions'             => 'Acciones',
            'countries'           => 'País',
            'list_orders'         => 'Ordenes',
            'payment_trans'       => 'Autorizaci&oacute;n Banco',
            'corbiz_transaction'  => 'Transacción Corbiz',
            'order_type'          => 'Tipo de Orden',
            'activate'            => 'Activar reintentos',
            'detail'              => 'Ver detalles',
            'activated'           => 'Reintentos activados correctamente',
            'notactivated'        => 'No se pudo activa, intente de nuevo',
            'list_orders_detail'  => 'Detalle de ordenes',
            'list_orders_logs'    => 'Estatus log',
            'inscription'         => '(Inscripción)',
            'source'              => 'Origen',
            'country'              => 'País',

        ],
        'detail' => [
            'ord_date' => 'Fecha de orden',
            'save_changes' => 'Guardar cambios',
            'added'      => 'producto agregado',
            'change_status' => 'Cambiar estatus',
            'payment_log'   => 'Log de estatus',
            'qty'           => 'Cant',
            'product'       => 'Producto',
            'sku'           => 'Sku',
            'description'   => 'Descripción',
            'points'        => 'Puntos',
            'subtotal'      => 'Subtotal',
            'Action'        => 'Acciones',
            'corbiz_error'  => 'Error corbiz',
            'user_error'    => 'Error usuario',
            'oid'           => 'Id orden',
            'corbiz_transaction' => 'Transacción corbiz',
            'phone'         => 'Télefono',
            'cellphone'     => 'Celular',
            'email'         => 'Email',
            'sponsor'       => 'Patrocinador',
            'sponsor_name'  => 'Nombre patrocinador',
            'status'        => 'Estatus',
            'corbiz_order'  => 'Orden Corbiz',
            'bank_transaction' => 'Transacción banco',
            'tax'           => 'Impuestos',
            'total'         => 'Total',
            'last_modifier' => 'Último en modificar',
            'change_products' => 'Cambiar productos',
            'payment_methods' => 'Métodos de pago',
            'add_product'       => 'Agregar producto',
            'system'            => 'Sistemas',
            'action'        => 'Acción',
            'zip'           => 'Código postal: ',
            'suburb'        => 'Colonia: ',
            'city'          => 'Ciudad: ',
            'state'         => 'Estado: ',
            'bank_auth'         => 'Autorización bancaria',
            'go_back'           => 'Regresar',
            'log_date'          => 'Fecha de log',
            'id'                => 'Identificador',
            'empty-qty'         => 'La cantidad es requerida',
            'empty-prod'        => 'Debes seleccionar al menos un producto',
            'product-error-saving' => 'La orden no pudo ser guardada, intenta nuevamente',
            'product-saved' => 'Orden actualizada correctamente',
            'birth' => 'Fecha nacimiento: ',
            'gender' => 'Genero: ',
            'logs' => 'Estatus Log',
            'chooseoption'      => [
                0 => 'País',
                1 => 'Orden',
                2 => 'Eo',
                3 => 'Tipo',
                4 => 'Origen',
                5 => 'Estatus',
                6 => 'Seleccione Producto',
            ],
            'contract' => 'Descargar Contrato',
            'reference' => 'Referencia'
        ]
    ],
    'customer' => [
        'index' => [
            'id' => 'Id',
            'country' => 'Páis',
            'sponsor' => 'Patrocinadpr',
            'sponsor_name' => 'Nombre patrocinador',
            'customer_code' => 'Código cliente',
            'name' => 'Nombre cliente',
            'date_created' => 'Fecha creación',
            'actions' => 'Acciones',
            'detail' => 'Detalles de cliente',
            'list_orders' => 'Listado de clientes',
            'status' => 'Estatus',
        ],
        'detail' => [
            'phone' => 'Télefono',
            'cellphone' => 'Celular',
            'email' => 'Correo',
            'sponsor' => 'Patrocinador',
            'sponsor_name' => 'Nombre patrocinador',
            'suburb' => 'Colonia: ',
            'zip' => 'Código postal:',
            'city' => 'Ciudad: ',
            'state' => 'Estado: ',
            'corbiz_transaction' => 'Transacción corbiz',
            'go_back' => 'Regresar',
            'birth' => 'Fecha nacimiento: ',
            'gender' => 'Genero: ',
            'ord_date' => 'Fecha de registro',
            'chooseoption'  => [
                0 => 'Country',
                1 => 'Sponsor',


            ],
        ]
    ],
    'legals' => [
        'index' => [
            'thead-legals-countries' => 'País',
            'thead-legals-activecontract' => 'Contrato Activo',
            'thead-legals-activedisclaimer' => 'Disclaimer Activo',
            'thead-legals-activepolicies' => 'Politicas Activas',
            'thead-legals-active' => 'Activo',
            'legal_active' => 'Activo',
            'legal_inactive' => 'Inactivo',
            'thead-legals-actions' => 'Acciones',
            'form-add-button' => 'Agregar documentos',
            'title' => 'Documentos legales',
            'btn_return' => 'Regresar',
            'disable' => 'Inactivar',
            'enable' => 'Activar',
            'delete' => 'Eliminar',
            'edit' => 'Editar',
        ],
        'add' => [
            'view' => [
                'form-countries' => 'Elige los países donde agregar los documentos legales',
                'title-add' => 'Agregar documentos legales',
                'form-country' => 'Paises seleccionados',
                'form-save-button' => 'Guardar',
                'form-active' => 'Activo',
                'form-error' => 'Es necesario completar los campos requeridos',
                'form-error-pdf' => 'El contrato y las politicas deben ser archivos pdf',
                'title-edit' => 'Editar documentos legales',
            ],
            'input' => [
                'contract' => 'Términos y condiciones de contrato',
                'contractvars' => 'Información contrato',
                'disclaimer' => 'Disclaimer',
                'yes' => 'Si',
                'no' => 'No',
                'activecontract' => 'Contrato Activo',
                'activedisclaimer' => 'Disclaimer activo',
                'activepolicies' => 'Politicas activas',
                'see_example' => 'Previsualización ejemplo',
                'btn-pdf' => 'Select PDF',
                'contract-pdf' => 'Contract pdf',
                'examplecontract' => 'Ejemplo contrato',
                'exampleterms' => 'Ejemplo términos y condiciones',
                'terms-pdf' => 'Póliticas y Cookies pdf',
                'instructions' => 'Es necesario que use la siguiente estructura de los contratos para una creación correcta cuando el contrato se genere de manera automática.',

            ],
            'error' => [
                'controller-success' => 'Documento legal agregado exitosamente',
                'controller-pdfextension' => 'El contrato debe ser un PDF',
            ]
        ],
        'edit' => [
            'error' => [
                'controller-success' => 'Documento legal actualizado exitosamente',
                'controller-pdfextension' => 'El contrato debe ser un PDF',
            ]
        ],
    ],
    'confirmationbanners' => [
        'index' => [
            'btn_return' => 'Regresar',
            'link' => 'Link',
            'purpose' => 'Objetivo del banner (ejemplo: éxito)',
            'type' => 'Tipo de banner (Inscripción, Compras, Cliente)',
            'image' => 'Imagen',
            'choose_option' => 'Elegir',
            'shopping_option' => 'Carrito de compras',
            'inscription_option' => 'Inscripción',
            'customer_option' => 'Registro de Clientes',
            'success_option' => 'Éxito',
            'error_option' => 'Error',
            'warning_option' => 'Advertencia',
            'thead-confirmation-type' => 'Tipo',
            'thead-confirmation-purpose' => 'Caso',
            'thead-confirmation-countries' => 'Paises',
            'thead-confirmation-link' => 'Link',
            'thead-confirmation-active' => 'Estatus',
            'thead-confirmation-actions' => 'Acciones',
            'disable' => 'Inhabilitar',
            'enable' => 'Habilitar',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'title' => 'Banners de confirmación',
            'form-add-button' => 'Añadir banner de confirmación',



        ],
        'add' => [
            'view' =>  [
                'title-add' => 'Añadir banner de confirmación',
                'form-active' => 'Activo',
                'form-save-button' => 'Guardar',
                'form-countries' => 'Elija los países donde desea agregar los banners',
                'form-country' => 'Paises',
                'form-error' => 'Es necesario completar los campos requeridos',
                'title-edit' => 'Editar banners de confirmación',
            ],
            'input' => [
                'yes' => 'Si',
                'no' => 'No',
                'image' => 'Imagen',
            ],
            'error' => [
                'controller-success' => 'Banner de confirmación agregado con éxito
',
            ]

        ],
        'edit' => [
            'error' => [
                'controller-success' => 'Banner de confirmación agregado con éxito
',
            ]
        ]

    ],
    'promoprods' => [
        'index' => [
            'btn_return' => 'Regresar',
            'name' => 'Nombre',
            'desription' => 'Description',
            'parentid' => 'Parent id',
            'choose_option' => 'Eligir',
            'shopping_option' => 'Carrito de compras',
            'inscription_option' => 'Inscripción',
            'customer_option' => 'Registro de Clientes',
            'success_option' => 'Éxito',
            'error_option' => 'Error',
            'warning_option' => 'Advertencia',
            'thead-confirmation-type' => 'Tipo',
            'thead-confirmation-purpose' => 'Caso',
            'thead-confirmation-countries' => 'Paises',
            'thead-confirmation-link' => 'Link',
            'thead-confirmation-active' => 'Estado',
            'thead-confirmation-actions' => 'Acciones',
            'disable' => 'Inhabilitar',
            'enable' => 'Habilitar',
            'edit' => 'Editar',
            'delete' => 'Eliminar',
            'title' => 'Banners de confirmación',
            'form-add-button' => 'Agregar banner de confirmación',
            'product_code' => 'Código de producto'



        ],
        'add' => [
            'view' =>  [
                'title-add' => 'Agregar banner de confirmación',
                'form-active' => 'Activo',
                'form-save-button' => 'Guardaad',
                'form-countries' => 'Elija los países donde desea agregar los banners',
                'form-country' => 'Paises',
                'form-error' => 'Es necesario completar los campos requeridos',
                'title-edit' => 'Editar la información de los banners',
                'form-ismain' => 'Es producto principal',
            ],
            'input' => [
                'yes' => 'Si',
                'no' => 'No',
                'image' => 'Imagen',
            ],
            'error' => [
                'controller-success' => 'Banner de confirmación agregado con éxito',
            ]

        ],
        'edit' => [
            'error' => [
                'controller-success' => 'Banner de confirmación actualizado con éxito',
            ]
        ]

    ]
];
