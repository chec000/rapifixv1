<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'select_new_shipping_address' => 'Selecciona la dirección de envío o agrega una nueva para recibir tu compra.',
    'we_have_a_problem' => 'Se produjo uno o varios problemas',
    'success' => 'Éxito',
    'add_address' => 'Agregar Nueva Dirección',
    'edit_address' => 'Editar dirección',
    'delete_address' => 'Eliminar dirección',
    'msg_confirm_delete_address' => '¿Estás seguro que deseas eliminar esta dirección?',
    'save'       => 'Guardar',
    'accept'     =>'Aceptar',
    'cancel'     => 'Cancelar',
    'delete'    => 'Eliminar',
    'edit'      => 'Editar',
    'close'      => 'close',
    'tag_shipping_address'  => "<span class='desk'>1. Dirección de envío</span> <span class='mov'>1. Dirección</span>",
    'tag_way_to_pay'    => "<span class='desk'>2. Pago </span> <span class='mov'>2. Pago</span>",
    'tag_confirm'   => "<span class='desk'>3. Confirmación</span> <span class='mov'>3. Confirmación</span>",
    'new_address'   => "Nueva dirección",
    'enter_new_data'  => "Ingresa los datos para que te llegue a otra dirección.",
    'msg_new_address_change'    => '*Esta dirección podrá cambiar el costo del manejo de envío.',
    'msg_address_error' => 'Direccion incorrecta, favor de editarla.',
    'msg_address_add_success'   => "La dirección :attribute ha sido registrada exitosamente.",
    'msg_address_delete_success'      => 'La dirección ha sido eliminada exitosamente.',
    'msg_address_edit_success' => "La dirección :attribute ha sido editada exitosamente.",
    'msg_error_getAddress' => 'Ocurrio un error al obtener las direcciones, intentelo mas tarde',
    'msg_not_address' => 'No cuenta con direcciones de envío para este país, por favor agregue una nueva dirección para continuar.',
    'success_delete'      => 'Dirección eliminada con éxito',
    'error_deleted'     => 'Error al eliminar',
    'success_add'      => 'Dirección agregada con éxito',
    'error_add'     => 'Error al agregar',
    'success_edit'      => 'Dirección editada',
    'error_edit'     => 'Error al editar',
    'success_selected'      => 'Dirección seleccionada',
    'error_selected'     => 'Dirección no encontrada. Por favor intente mas tarde.',
    'session_eo_expired' => 'La sessión ha expirado',

    'modal_alerts' => [
        'title_empty_list_address' => 'AGREGA UNA DIRECCIÓN',
        'empty_list_address' => 'Para continuar con tu proceso de compra en '. \Illuminate\Support\Facades\Session::get('portal.main.country_name'). ' es necesario que agregues una dirección del país.',
        'title_auto_quatotion_zip_start' => 'CONFIRMA TU COTIZACIÓN',
        'auto_quatotion_zip_start' => 'Pedido cotizado con el código postal {zipCode}. Para actualizar la información de envío, selecciona una dirección guardada o da clic en + Agregar Nueva Dirección, para añadir una nueva.',
        'title_auto_quotation_one_address' => 'CONFIRMA TU COTIZACIÓN ',
        'auto_quotation_one_address' => 'Pedido cotizado con el código postal {zipCode}. Para actualizar la información de envío da clic en + Agregar Nueva Dirección, para añadir una nueva.',
        'title_no_match_zip_listAddress' => 'ELIGE UNA DIRECCIÓN',
        'no_match_zip_listAddress' => 'Para continuar con tu proceso de compra en '. \Illuminate\Support\Facades\Session::get('portal.main.country_name'). ' selecciona una dirección guardada o da clic en + Agregar Nueva Dirección para añadir una nueva. Considera que cotizar tu orden con un Código Postal distinto podría modificar tu cesta.',
        'title_select_add_no_match_zip' => 'CONFIRMA TU COTIZACIÓN ',
        'select_add_no_match_zip' => 'La dirección seleccionada/agregada no coincide con el código postal previamente ingresado '. \Illuminate\Support\Facades\Session::get('portal.main.zipCode'). ', cotizar tu pedido podría modificar tus productos seleccionados. ¿Deseas continuar?',

        'title_msg_error_get_quotation' => 'Revisa tu dirección de envío',
        'msg_error_get_quotation' => '¡Lo sentimos! No podemos completar tu compra en este momento. Revisa que tu dirección de envío seleccionada contenga toda la información necesaria para el proceso de compra.',
    ],

    'fields' => [
        'description'      => [
            'label'         => 'Descipción',
            'placeholder'   => 'Descripción',
        ],
        'name'      => [
            'label'         => 'Nombre completo',
            'placeholder'   => 'Nombre',
        ],
        'zip' => [
            'placeholder' => 'Código postal',
        ],
        'city' => [
            'label' => 'Seleccione ciudad',
            'placeholder' => 'Ciudad',
        ],
        'state' => [
            'label' => 'Seleccione Estado',
            'placeholder' => 'Estado',
        ],
        'county' => [
            'label'         => 'Condado',
            'placeholder' => 'Condado',
        ],
        'address' => [
            'placeholder' => 'Dirección',
            'example' => ''
        ],
        'email' => [
            'placeholder' => 'Email',
        ],
        'phone' => [
            'placeholder' => 'Teléfono',
        ],
        'shippingCompany' => [
            'placeholder' => 'Compania de envío',
        ],
        'suburb' => [
            'placeholder' => 'Colonia',
        ],
        'complement' => [
            'placeholder' => 'Entre calles',
        ],
        'required'  => 'El campo :attribute es requerido.',
        'min' => 'El campo :attribute debe contener al menos :min caracteres.',
        'max' => 'El campo :attribute no debe contener más de :max caracteres.',

    ],
    'labels_error' => [
        'address' => 'Dirección',//Nueva
        'main_address' => 'Principal'//Nueva
    ],
];
