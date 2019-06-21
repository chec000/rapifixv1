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
        //Input required and especial lenght in some cases or structure
        'MEX' => [

        ],
        'USA' => [
            'country' => true,
            'invited' => true,
            'businessman' => true,
            'phoneminlenght' => 8,
            'phonemaxlenght' => 12,
        ],


];