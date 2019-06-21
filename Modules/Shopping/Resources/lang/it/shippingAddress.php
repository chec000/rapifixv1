<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'select_new_shipping_address' => 'Seleziona un indirizzo di spedizione ',
    'we_have_a_problem' => 'Si è verificato un problema',
    'success' => 'Successo',
    'add_address' => 'Agregar Nueva Dirección', //Nueva
    'edit_address' => 'Modificare indirizzo',
    'delete_address' => 'Eliminare indirizzo',
    'msg_confirm_delete_address' => 'Sei sicuro di voler eliminare quest’indirizzo?',
    'save'       => 'Salvare',
    'accept'     =>'Accettare',
    'cancel'     => 'Annullare',
    'delete'    => 'Eliminare',
    'edit'      => 'Modificare',
    'close'      => 'Chiudere',
    'tag_shipping_address'  => "<span class='desk'>1. </span> Indirizzo   <span class='desk'>di spedizione</span>",
    'tag_way_to_pay'    => "<span class='desk'>2. Metodo di pagamento </span>",
    'tag_confirm'   => "<span class='desk'>3.</span> Conferma",
    'new_address'   => "Nuovo Indirizzo",
    'enter_new_data'  => "Inserisci i dati per fare arrivare gli ordini ad un altro indirizzo.",
    'msg_new_address_change'    => '*Quest’indirizzo potrebbe far variare le spese di gestione e spedizione.',
    'msg_address_error' => 'Indirizzo non corretto, ti chiediamo cortesemente di modificarlo.',
    'msg_address_add_success'   => 'L’indirizzo ":attribute" è stato registrato con successo.',
    'msg_address_delete_success'      => 'L’indirizzo è stato eliminato con successo.',
    'msg_address_edit_success' => 'L’indirizzo":attribute" è stato modificato con successo.',
    'msg_error_getAddress' => 'Si è verificato un errore al momento di ottenere gli indirizzi, prova più tardi.',
    'msg_not_address' => 'No cuenta con direcciones de envío para este país, por favor agregue una nueva dirección para continuar.', //NUEVA
    'success_delete'      => 'Indirizzo eliminato con successo.',
    'error_deleted'     => 'Errore al momento dell’eliminazione ',
    'success_add'      => 'Indirizzo aggiunto con successo ',
    'error_add'     => 'Errore, non si è potuto aggiungere l’indirizzo',
    'success_edit'      => 'Indirizzo modificato ',
    'error_edit'     => 'Errore nella modifica  ',
    'success_selected'      => 'Indirizzo selezionato',
    'error_selected'     => 'Indirizzo non trovato. Per favore, prova più tardi.',
    'session_eo_expired' => 'La sessione è scaduta',

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
        'name'      => [
            'label'         => 'Nome e cognome',
            'placeholder'   => 'Nome',
        ],
        'description'   => [
            'label'         => 'Descrizione',
            'placeholder'   => 'Descrizione',
        ],
        'zip' => [
            'placeholder' => 'CAP',
        ],
        'city' => [
            'label'         => 'Seleziona città ',
            'placeholder' => 'Città',
        ],
        'state' => [
            'label'         => 'Seleziona Stato ',
            'placeholder' => 'Stato',
        ],
        'county' => [
            'label'         => 'Paese',
            'placeholder' => 'paese',
        ],
        'address' => [
            'placeholder' => 'Indirizzo',
            'example' => '(Example: 960 North Tenth Street)'
        ],
        'email' => [
            'placeholder' => 'Email',
        ],
        'phone' => [
            'placeholder' => 'Telefono',
        ],
        'shippingCompany' => [
            'placeholder' => 'Ditta di spedizione',
        ],
        'suburb' => [
            'placeholder' => 'Suburb',
        ],
        'complement' => [ //Nueva
            'placeholder' => 'Entre calles',
        ],
        'required'  => 'Il :attribute è obbligatorio..',
        'min' => 'El campo :attribute debe contener al menos :min caracteres.', //Nueva
        'max'       => 'The :attribute may not be greater than :max characters.', //Nueva
    ],
    'labels_error' => [
        'address' => 'Address',//Nueva
        'main_address' => 'Main'//Nueva
    ],
];
