<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
    'general' => [
        'list_cedis'     => 'CEDIS List',
        'add_cedis'      => 'Add CEDIS',
        'name'           => 'Name',
        'country'        => 'Country',
        'latitude'       => 'Latitude',
        'longitude'      => 'Longitude',
        'status'         => 'Status',
        'actions'        => 'Actions',
        'active'         => 'Active CEDIS',
        'inactive'       => 'Inactive CEDIS',
        'edit'           => 'Edit CEDIS',
        'delete'         => 'Delete CEDIS',
        'general_info'   => 'General information',
        'images'         => 'Images',
    ],
    'add' => [
        'new'               => 'Add new CEDIS',
        'description'       => 'Description',
        'city'              => 'City',
        'state'             => 'State',
        'schedule'          => 'Schedule',
        'banner'            => 'Banner image',
        'banner_link'       => 'Banner image link',
        'address'           => 'Address',
        'neighborhood'      => 'Neighborhood/County',
        'postal_code'       => 'Postal code',
        'phone_number_01'   => 'Phone number 01',
        'phone_number_02'   => 'Phone number 02',
        'telemarketing'     => 'Telemarketing number',
        'fax'               => 'Fax number',
        'email'             => 'Email',
        'image_01'          => 'Image 01',
        'image_02'          => 'Image 02',
        'image_03'          => 'Image 03',
        'select_country'    => 'Select country',
        'success_save'      => 'The CEDIS has been created successfully',
        'success_update'    => 'The CEDIS has been updated successfully',
        'success_delete'    => 'The CEDIS has been deleted successfully',
        'empty_lang_fields' => 'You must fill at least one language with the following fields: name, state, city and schedule',
        'save'              => 'Save'
    ],
    'edit' => [
        'edit' => 'Edit CEDIS',
    ],
    'validation' => [
        'country'         => 'The country is required',
        'address'         => 'The address is required',
        'neighborhood'    => 'The neighborhood/county is required',
        'phone_number_01' => 'The phone number 01 is required',
        'latitude'        => 'The latitude is required',
        'longitude'       => 'The longitude is required',
        'image_01'        => 'The image 01 is required',
        'global_name'     => 'The global name is required',
    ],
    'errors' => [
        'not_ajax'   => 'The request must be AJAX',
        'not_params' => 'The params are incomplete'
    ]
];
