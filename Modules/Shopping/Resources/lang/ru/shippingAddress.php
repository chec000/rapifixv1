<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'select_new_shipping_address' => 'Выбрать адрес доставки',
    'we_have_a_problem' => 'Возникли проблемы',
    'success' => 'Успех',
    'add_address' => 'Agregar Nueva Dirección', //Nueva
    'edit_address' => 'Редактировать адрес',
    'delete_address' => 'Удалить адрес',
    'msg_confirm_delete_address' => 'Вы уверены, что хотите удалить этот адрес?',
    'save'       => 'Сохранить',
    'accept'     =>'Принять',
    'cancel'     => 'Отменить',
    'delete'    => 'Удалить',
    'edit'      => 'Редактировать',
    'close'      => 'Закрыть',
    'tag_shipping_address'  => "<span class='desk'>1. </span> Адрес  <span class='desk'>доставки</span>",
    'tag_way_to_pay'    => "<span class='desk'>2. Способ оплаты</span>",
    'tag_confirm'   => "<span class='desk'>3.</span> Подтверждение",
    'new_address'   => "Новый адрес",
    'enter_new_data'  => "Введите информацию, чтобы доставить по другому адресу",
    'msg_new_address_change'    => '*Стоимость доставки может измениться из-за адреса доставки',
    'msg_address_error' => 'Адрес некорректный, пожалуйста, отредактируйте его',
    'msg_address_add_success'   => 'Адрес :attribute зарегистрирован успешно',
    'msg_address_delete_success'      => 'Адрес успешно удален',
    'msg_address_edit_success' => 'Адрес :attribute успешно отредактирован',
    'msg_error_getAddress' => 'Произошла ошибка при получении адреса, Повторите попытку позднее.',
    'msg_not_address' => 'No cuenta con direcciones de envío para este país, por favor agregue una nueva dirección para continuar.', //NUEVA
    'success_delete'      => 'Адрес успешно удален',
    'error_deleted'     => 'Произошла ошибка при удалении',
    'success_add'      => 'Адрес добавлен успешно',
    'error_add'     => 'Произошла ошибка при добавлении',
    'success_edit'      => 'Адрес отредактирован',
    'error_edit'     => 'Произошла ошибка при добавлении',
    'success_selected'      => 'Адрес выбран',
    'error_selected'     => 'Адрес не найден. Повторите попытку позднее',
    'session_eo_expired' => 'Время сеанса истекло',

    'modal_alerts' => [ //Nuevas traducciones
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

        'title_msg_error_get_quotation' => 'Check your shipping address',
        'msg_error_get_quotation' => 'We´re sorry, there was a problem processing your order. Check that your selected shipping address contains all the necessary information for the purchase process.',
    ],

    'fields' => [
        'description'   => [
            'label'         => 'Описание',
            'placeholder'   => 'Описание',
        ],
        'name'      => [
            'label'         => 'Полное имя',
            'placeholder'   => 'Имя',
        ],
        'zip' => [
            'placeholder' => 'Индекс',
        ],
        'city' => [
            'label'         => 'Выберите город',
            'placeholder' => 'Город',
        ],
        'state' => [
            'label'         => 'Выберите регион/область',
            'placeholder' => 'Регион/Область',
        ],
        'county' => [
            'label'         => 'Страна',
            'placeholder' => 'Страна',
        ],
        'address' => [
            'placeholder' => 'Адрес',
            'example' => '(Example: 960 North Tenth Street)'
        ],
        'email' => [
            'placeholder' => 'E-mail',
        ],
        'phone' => [
            'placeholder' => 'Телефон',
        ],
        'shippingCompany' => [
            'placeholder' => 'Транспортная компания',
        ],
        'suburb' => [
            'placeholder' => 'Suburb',
        ],
        'complement' => [ //Nueva
            'placeholder' => 'Entre calles',
        ],
        'required'  => 'Поле :attribute обяательно к заполнению',
        'min' => 'El campo :attribute debe contener al menos :min caracteres.', //Nueva
        'max'       => 'The :attribute may not be greater than :max characters.', //Nueva
    ],
    'labels_error' => [
        'address' => 'Address',//Nueva
        'main_address' => 'Main'//Nueva
    ],
];
