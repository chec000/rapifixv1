<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'select_new_shipping_address' => 'Select a shipping address or add a new one to receive your order.',
    'we_have_a_problem' => 'One or several problems were encountered',
    'success' => 'Success',
    'add_address' => 'Add New Address',
    'edit_address' => 'Edit address',
    'delete_address' => 'Delete address',
    'msg_confirm_delete_address' => 'Are you sure you want to delete this address?',
    'save'       => 'Save',
    'accept'     => 'Accept',
    'cancel'     => 'Cancel',
    'delete'    => 'Delete',
    'edit'      => 'Edit',
    'close'      => 'close',
    'tag_shipping_address'  => "<span class='desk'>1. Shipping Address</span> <span class='mov'>1. Shipping</span>",
    'tag_way_to_pay'    => "<span class='desk'>2. Payment</span> <span class='mov'>2. Payment</span>",
    'tag_confirm'   => "<span class='desk'>3. Confirm</span> <span class='mov'>3. Confirm</span>",
    'new_address'   => "New address",
    'enter_new_data'  => "Enter information to ship to a different address.",
    'msg_new_address_change'    => '*This address may change costs of shipping.',
    'msg_address_error' => 'Incorrect address, please edit it.',
    'msg_address_add_success'   => 'The address ":attribute" has been registered successfully.',
    'msg_address_delete_success'      => 'The address has been deleted successfully.',
    'msg_address_edit_success' => 'The address ":attribute" has been edited successfully.',
    'msg_error_getAddress' => 'We have a problem to obtain shipping address, try later.',
    'msg_not_address' => 'Do not have shipping addresses for this country, please add a new address to continue.',
    'success_delete'      => 'Address deleted succesfully',
    'error_deleted'     => 'error when deleting',
    'success_add'      => 'Address added succesfully',
    'error_add'     => 'error when adding',
    'success_edit'      => 'Address edited',
    'error_edit'     => 'Error when editing',
    'success_selected'      => 'Address selected',
    'error_selected'     => 'Address not found. Please try later.',
    'session_eo_expired' => 'Session has expired',

    'modal_alerts' => [
        'title_empty_list_address' => 'ADD AN ADDRESS ',
        'empty_list_address' => 'To proceed with your payment in '. \Illuminate\Support\Facades\Session::get('portal.main.country_name'). ' it is mandatory to add a valid address from the country.',
        'title_auto_quatotion_zip_start' => 'CONFIRM YOUR QUOTE ',
        'auto_quatotion_zip_start' => 'Order quoted with the Zip Code {zipCode}. To refresh the shipment information, select a saved address or click on + Add new address, to register a new one.',
        'title_auto_quotation_one_address' => 'CONFIRM YOUR QUOTE',
        'auto_quotation_one_address' => 'Order quoted with the Zip Code {zipCode}. To refresh the shipment information click on + Add new address, to register a new one.',
        'title_no_match_zip_listAddress' => 'CHOOSE AN ADDRESS',
        'no_match_zip_listAddress' => ' To proceed with your payment in '. \Illuminate\Support\Facades\Session::get('portal.main.country_name'). ' choose a saved address or click on + Add a new address to register a new one. Consider that quoting your order with a different Zip Code may modify your selected products.',
        'title_select_add_no_match_zip' => 'CONFIRM YOUR QUOTE ',
        'select_add_no_match_zip' => 'The selected/added address doesn´t match with the  previously entered '. \Illuminate\Support\Facades\Session::get('portal.main.zipCode'). ' Zip Code, quoting your order may modify your selected products. Do you want to continue?',

        'title_msg_error_get_quotation' => 'Check your shipping address',
        'msg_error_get_quotation' => 'We´re sorry, there was a problem processing your order. Check that your selected shipping address contains all the necessary information for the purchase process.',
    ],

    'fields' => [
        'description'   => [
            'label'         => 'Description',
            'placeholder'   => 'Description',
        ],
        'name'      => [
            'label'         => 'Full Name',
            'placeholder'   => 'Name',
        ],
        'zip' => [
            'placeholder' => 'Zip code',
        ],
        'city' => [
            'label'         => 'Select city',
            'placeholder' => 'City',
        ],
        'state' => [
            'label'         => 'Select state',
            'placeholder' => 'State',
        ],
        'county' => [
            'label'         => 'County',
            'placeholder' => 'County',
        ],
        'address' => [
            'placeholder' => 'Address',
            'example' => '(Example: 960 North Tenth Street)'
        ],
        'email' => [
            'placeholder' => 'Email',
        ],
        'phone' => [
            'placeholder' => 'Phone',
        ],
        'shippingCompany' => [
            'placeholder' => 'Shipping company',
        ],
        'suburb' => [
            'placeholder' => 'Suburb',
        ],
        'complement' => [
            'placeholder' => 'On the streets',
        ],
        'required'  => 'The :attribute field is required.',
        'min' => 'The :attribute must be at least :min characters.',
        'max'       => 'The :attribute may not be greater than :max characters.',
    ],
    'labels_error' => [
        'address' => 'Address',//Nueva
        'main_address' => 'Main'//Nueva
    ],
];
