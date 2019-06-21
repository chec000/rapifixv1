<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'select_new_shipping_address' => 'Selecione um endereço de envio',
    'we_have_a_problem' => 'Um ou vários problemas ocorreram',
    'success' => 'Sucesso',
    'add_address' => 'Agregar Nueva Dirección', //Nueva
    'edit_address' => 'Editar endereço',
    'delete_address' => 'Remover endereço',
    'msg_confirm_delete_address' => 'Tem certeza de que deseja remover este endereço?',
    'save'       => 'Salvar',
    'accept'     =>'Aceitar',
    'cancel'     => 'Cancelar',
    'delete'    => 'Remover',
    'edit'      => 'Editar',
    'close'      => 'Fechar',
    'tag_shipping_address'  => "<span class='desk'>1. </span> Endereço de  <span class='desk'>envio</span>",
    'tag_way_to_pay'    => "<span class='desk'>2. Forma de pagamento</span>",
    'tag_confirm'   => "<span class='desk'>3.</span> Confirmação",
    'new_address'   => "Novo endereço",
    'enter_new_data'  => "Insira os dados para que cheguem a você por outro endereço.",
    'msg_new_address_change'    => '*Este endereço poderá alterar as despesas de envio.',
    'msg_address_error' => 'Endereço incorreto, favor editá-lo. ',
    'msg_address_add_success'   => 'O endereço ":attribute" foi registrado com sucesso.',
    'msg_address_delete_success'      => 'O endereço foi removido com sucesso.',
    'msg_address_edit_success' => 'O endereço ":attribute" foi editado com sucesso',
    'msg_error_getAddress' => 'Ocorreu um erro ao obter os endereços, tente mais tarde',
    'msg_not_address' => 'No cuenta con direcciones de envío para este país, por favor agregue una nueva dirección para continuar.', //NUEVA
    'success_delete'      => 'Endereço removido com sucesso',
    'error_deleted'     => 'Erro ao remover',
    'success_add'      => 'Endereço adicionado com sucesso',
    'error_add'     => 'Erro ao adicionar',
    'success_edit'      => 'Endereço editado',
    'error_edit'     => 'Erro ao editar ',
    'success_selected'      => 'Endereço selecionado',
    'error_selected'     => 'Endereço não encontrado. Por favor, tente mais tarde.',
    'session_eo_expired' => 'A sessão expirou',

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
            'label'         => 'Descrição',
            'placeholder'   => 'Descrição',
        ],
        'name'      => [
            'label'         => 'Nome Completo',
            'placeholder'   => 'Nome',
        ],
        'zip' => [
            'placeholder' => 'Código postal (CEP)',
        ],
        'city' => [
            'label'         => 'Selecione a cidade',
            'placeholder' => 'Cidade',
        ],
        'state' => [
            'label'         => 'Selecione o estado',
            'placeholder' => 'Estado',
        ],
        'county' => [
            'label'         => 'County',
            'placeholder' => 'County',
        ],
        'address' => [
            'placeholder' => 'Endereço',
            'example' => '(Example: 960 North Tenth Street)'
        ],
        'email' => [
            'placeholder' => 'Email',
        ],
        'phone' => [
            'placeholder' => 'Telefone',
        ],
        'shippingCompany' => [
            'placeholder' => 'Transportadora',
        ],
        'suburb' => [
            'placeholder' => 'Bairro ',
        ],
        'complement' => [ //Nueva
            'placeholder' => 'Entre calles',
        ],
        'required'  => 'O campo  :attribute  é necessário.',
        'min' => 'El campo :attribute debe contener al menos :min caracteres.', //Nueva
        'max'       => 'The :attribute may not be greater than :max characters.', //Nueva
    ],
    'labels_error' => [
        'address' => 'Address',//Nueva
        'main_address' => 'Main',//Nueva
    ],
];
