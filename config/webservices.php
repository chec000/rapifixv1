<?php
/*
  |--------------------------------------------------------------------------
  | Webservices Configuration Variables
  |--------------------------------------------------------------------------
  |
  | They are the configuration variables for the connection to the webservices.
  |  For example: the url of wsdl
  |
 */

return [
    'WSShoppingCart' => [
        'MEX' => [
            'local' => [
                'user' => '',
                'password'=>'',
            ],
            'qa' => [
                'user' => '',
                'password'=>'',
            ],
            'production' => [
                'user' => '',
                'password'=>'',
            ],
        ],
        'RUS' => [
            'local' => [
                'user' => 'restomni',
                'password'=>'Omnilife',
            ],
            'qa' => [
                'user' => '',
                'password'=>'',
            ],
            'production' => [
                'user' => '',
                'password'=>'',
            ],
        ],

    ],
];