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
        'dist_pool'     => 'Distributors pool',
        'country'       => 'Country',
        'dist_code'     => 'Distributor code',
        'dist_name'     => 'Distributor name',
        'dist_email'    => 'Distributor email',
        'dist_used'     => 'Used',
        'dist_not_used' => 'Not used',
        'add_dist'      => 'Add distributor',
        'delete_dist'   => 'Delete distributor',
        'edit_dist'     => 'Edit distributor',
        'load_csv'      => 'Load CSV',
        'download_csv'  => 'Download CSV example',
        'yes'           => 'Yes',
        'no'            => 'No',
        'are_sure'      => 'Are you sure?',
        'cancel'        => 'Cancel',
        'delete'        => 'Delete',
        'success'       => 'Success',
        'error'         => 'Error',
        'close'         => 'Close',
    ],
    'add' => [
        'new_dist'       => 'Add new distributor',
        'success_save'   => 'The distributor has been created successfully',
        'success_update' => 'The distributor has been updated successfully',
        'success_delete' => 'The distributor has been deleted successfully',
    ],
    'edit' => [
        'edit_dist'       => 'Edit distributor',
    ],
    'validation' => [
        'code_req'    => 'The distributor code is required',
        'code_uniq'   => 'The distributor code already exists',
        'name'        => 'The name is required',
        'email_req'   => 'The email is required',
        'email_ema'   => 'The email must be valid',
        'client_adm'  => 'Can not add to an admirable client',
        'country'     => 'The country is required',
        'country_2'   => 'The country is required to validate the sponsor',
        'code_valid'  => 'The distributor code must be valid',
        'file'        => 'The file is required',
        'file_type'   => 'The file must be a CSV',
        'incomplete'  => 'The data is incomplete',
        'name_limit'  => 'The maximum number of characters for the name is 200',
        'email_limit' => 'The maximum number of characters for the email is 200',
        'limit_chars' => 'The name or email exceeds 200 characters',
    ],
    'csv' => [
        'dist_file'          => 'Distributors\' file by country',
        'file_ext'           => 'Upload a file with a .csv extension',
        'file_demo'          => 'Base file',
        'download_base_file' => 'Download base file',
        'instructions'       => 'Instructions',
        'inst_01'            => 'Download CSV demo file by clicking below',
        'inst_02'            => 'Fill with the corresponding information the columns of the Entrepreneur Code, Name and Email. Depending on the number of entrepreneurs in the pool, it will be the number of rows that the file will have',
        'inst_03'            => 'Save the changes and upload the updated file from here',
        'upload'             => 'Upload'
    ]
];
