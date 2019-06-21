<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'Register',

    'tabs' => [
      'account' => [
        'desktop' => '1. Create account',
        'mobile' => 'Account'
      ],
      'info' => [
        'desktop' => '2. Information',
        'mobile' => 'Info'
      ],
      'kit' => [
        'desktop' => '3. Select your kit',
        'mobile' => 'Kit'
      ],
      'confirm' => [
        'desktop' => '4. Confirm',
        'mobile' => 'Confirm'
      ],
    ],

    'account' => [
      'invited' => [
        'label' => [
          'desktop' => 'Were you invited by an OMNILIFE Distributor?',
          'mobile' => 'Were you invited?',
        ],
        'answer' => [
          'yes' => 'Yes',
          'no' => 'No'
        ]
      ],
      'businessman_code' => [
        'label' => 'Sponsor Code',
        'label_sponsored' => 'Sponsor Code',
        'placeholder' => 'Enter your Sponsor code'
      ],
      'meet_us' => [
        'label' => 'How did you hear about us?',
        'default' => 'How did you hear about us?',
      ],
      'country' => [
        'label' => 'Country',
        'default' => 'Select your country',
        'empty_countries' => 'The country was not found.',
        'emptydata' => 'No country data found.',
        'emptypool' => 'No distributor data found.',
      ],
      'email' => [
        'label' => 'Email',
        'placeholder' => 'Enter your email'
      ],
      'confirm_email' => [
        'label' => 'Confirm email',
        'placeholder' => 'Confirm your email'
      ],
      'phone' => [
        'label' => 'Phone',
        'placeholder' => 'Enter your phone'
      ],
      'cel' => [
        'label' => 'cellphone',
        'placeholder' => 'Enter your cellphone'
      ],
      'pool' => [
          'empty_country' => 'Empty Country',
      ],
      'secret_question' => [
        'label' => 'Secret question',
        'default' => 'Select a secret question',
        'emptydata' => 'No secret question information found.',
      ],
      'secret_answer' => [
        'label' => 'Answer',
        'placeholder' => 'Write your answer'
      ],
      'parameters' => [
        'emptydata' => 'No parameters configuration found it',
      ],
      'kit' => [
        'placeholder' => 'Kit',
      ],
      'shipping' => [
        'placeholder' => 'Shipping',
      ],
      'payment' => [
        'placeholder' => 'payment',
      ],
      'fields' => [
              'name'      => [
                  'label'         => 'Full Name',
                  'placeholder'   => 'Name',
              ],
              'lastname'  => [
                  'placeholder'   => 'Last Name',
              ],
              'lastname2' => [
                  'placeholder'   => 'Mother\'s Last Name',
              ],
              'email'      => [
                  'placeholder'   => 'Email',
              ],
              'email2'      => [
                  'placeholder'   => 'Email',
              ],
              'invited'      => [
                  'placeholder'   => 'Invited',
              ],
              'confirm-email'      => [
                  'placeholder'   => 'Confirm email',
              ],
              'tel'      => [
                  'placeholder'   => 'Phone',
              ],
              'cel' => [
                  'placeholder' => 'Cellphone',
              ],
              'secret-question'      => [
                  'placeholder'   => 'Secret Question',
              ],
              'response-question'      => [
                  'placeholder'   => 'Answer',
              ],
             'day' => [
                 'placeholder' => 'Day',
             ],
             'month' => [
                 'placeholder' => 'Month',
             ],
             'year' => [
                 'placeholder' => 'Year',
             ],
            'zip' => [
                'placeholder' => 'Zip Code',
             ],
             'terms1' => [
                 'placeholder' => 'Terms and conditions',
             ],
             'ext_num' => [
                 'placeholder' => 'Exterior number'
             ],
             'terms2' => [
                 'placeholder' => 'Transfer data',
             ],
            'city' => [
                'placeholder' => 'City',
            ],
            'state' => [
                'placeholder' => 'State',
            ],
            'street' => [
                'placeholder' => 'Street',
            ],

          'required'      => 'The :attribute field is required.',
          'in'            => 'The selected :attribute is invalid.',
          'not_in'        => 'The selected :attribute is invalid.',
          'email'         => 'The :attribute must be a valid email address.',
          'numeric'       => 'The :attribute must be a number.',
          'same'          => 'The :attribute and :other must match.',
          'min'           => 'The :attribute must be at least :min characters.',
          'max'           => 'The :attribute may not be greater than :max characters.',
          'date'          => 'The :attribute is not a valid date.',
          'date_format'   => 'The :attribute does not match the format :format.',
          'unique'        => 'The :attribute has already been taken.',
          'regex'         => 'The :attribute format is invalid.',
          'street_corbiz' => 'Wrong Address',
        ],
    ],

    'info' => [
      'full_name' => [
        'label' => 'Full name',
        'placeholders' => [
          'name' => 'Name',
          'last_name' => 'Last name',
          'last_name2' => 'Last name',
          'sex' => 'Sex',
        ]
      ],
      'birth_date' => [
        'label' => 'Birth date',
        'defaults' => [
          'day' => 'day',
          'month' => 'month',
          'year' => 'year',
        ]
      ],
      'id' => [
        'label' => 'ID',
        'defaults' => [
          'type' => 'ID type',
        ],
        'placeholders' => [
          'number' => 'ID number',
        ]
      ],
      'address' => [
        'label' => 'Address',
        'street_message' => 'Enter your information, consider that shipping to PO BOX is not available.',
        'street_message_fail' => 'Invalid address. Shipping to PO BOX is not available.',
        'placeholders' => [
          'street' => 'Street',
          'ext_num' => 'Exterior number',
          'int_num' => 'Interior number',
          'colony' => 'County',
          'streets' => 'On the streets',
          'state' => 'State',
          'city' => 'City',
          'zip' => 'Zip code',
           'choose_zip' => 'Choose an option',
        ]
      ],
      'terms_contract' => [
        'text' => 'I accept',
        'link' => 'Contract terms and conditions',
      ],
      'terms_payment' => [
        'text' => 'I accept',
        'link' => 'the transfer of my data to the country of Mexico, Operations Center of the OMNILIFE business.',
      ],
      'terms_information' => [
        'text' => 'I accept',
        'link' => 'receive information related to products, services, promotions and / or OMNILIFE events through my contact information provided.'
      ],
      'mandatory' => [
          'label' => 'The field is required',
      ]
    ],

    'kit' => [
      'types' => 'Select your kit',
      'emptydata' => 'No kits available',
      'emptywarehouse' => 'Must send a warehouse',
      'shipping' => 'Select your shipping method',
      'shippingCompanies_empty' => 'No shipping companies were found with the state and city entered, please report the problem and try another state and city',
      'payment' => 'Select payment method',
      'choose' => 'Choose a kit',
      'sendby' => 'Send By ',
      'bill' => [
        'subtotal' => 'Subtotal',
        'management' => 'Management',
        'taxes' => 'Taxes',
        'points' => 'Points',
        'total' => 'Total',
        'resume' => 'Resume',
        'discount' => 'Discount',
        'shipping_cost' => 'Shipping',
        'shopping_cart' => 'Shopping cart',
      ]
    ],

    'confirm' => [
      'email' => 'Check your email to finish account creation.',
      'businessman_code' => 'Your businessman code is',
      'thank_you' => 'Thanks for your purchase',
      'payment_successful' => 'Payment successful',
      'no_data_in_tables' => 'No data found it on local tables'
    ],

    'modal' => [
      'header' => 'Processing payment',
      'text_highlight' => 'You are closer from your financial freedom.',
      'text' => 'Don\'t close or reload this window.'
    ],

    'terms' => [
        'title' => "When click on \"Accept\", you confirm that you agree with our Terms and Conditions.",
        'cancel' => 'Cancel',
        'accept' => 'Accept',
        'download' => 'download contract policies',
    ],

    'mail' => [
        'hello'             => 'Hello',
        'title'             => 'Email Confirmation',
        'regards'           => 'Regards',
        'team'              => 'Team Omnilife',
        'privacy_policy'    => 'Privacy Policy',

        'order' => [
            'title' => 'Order Confirmation',
        ],

        'customer'          => [
            'title'         => 'Welcome to Omnilife',
            'subject'       => 'Welcome to OMNILIFE! A great family of Entrepreneurs where you get to define your own objectives.',
            'h6'            => 'Welcome!',
            'p1'            => 'Thank you<strong> :name</strong> By having completed your registration, you are on the road to a healthier and more beautiful life enjoying Omnilife products',
            'h4'            => 'We\'d like to let you know that your registration as a Distributor has been successful, this is your account information:',
            'p2'            => 'Save your Client Code and Password, which will be necessary to make your purchases.',
            'p3'            => 'This is your account information',
            'client_code'   => 'Distributor Code:',
            'password'      => 'Password:',
            'question'      => 'Secret Question:',
            'answer'        => 'Answer to security question:',
            'recommend'      => 'We recommend that you do not share your customer code and password as it is considered private and necessary information to make purchases and other operations as an OMNILIFE Distributor.',
            'recommend2'    => 'We are prepared to help you undertake your business and support the growth you wish to have. We recommend you keep the following points in mind now that you\'re starting your independent business:',
            'list1'         => 'Use and share day in and day out.',
            'list2'         => 'Seek results and the money will arrive by default.',
            'list3'         => 'Follow your dreams.',
            'list4'         => 'Keep in mind that crisis often brings new opportunities.',
            'list5'         => 'Invest in your own independent business. ',
            'visitplatform' => 'Don\'t forget to start your face-to-face training as soon as possible or online through the Learning Platform in your ',
            'linkplatform'  => 'Distributor Area',
            'visitweb'      => 'Visit our website and make ',
            'firstpurchase' => 'your first purchase today!',
            'unrecognized'  => '"If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to ',
            'mailprivacy'   => 'privacidad@omnilife.com',
            'subjectprivacy' => 'with subject line: Right to Oppose, your full name, country and telephone number, or call our {CREO} service lines".',
            'privacypolicies' => 'Privacy Policies',
            'dist_area' => 'Distributor area',
        ],

        'sponsor'           => [
            'title'         => 'New Entepreneur on your network',
            'subject'       => 'Congratulations!, :name_sponsor',
            'p1'            => 'Your Independent Business with us is growing! <strong>:name_customer </strong> has registered under your network as a Distributor.',
            'p2'            => 'Stay in touch to reach your monthly goal more easily: ',
            'text1'         => 'It is very important to remember that as a presenter, you can',
            'text2'         => 'Encourage your new Distributor to stay active because with each purchase he/she makes, you make more points to move you forward and reach your goals.',
            'client_code'   => 'Distributor Code',
            'name'          => 'Name',
            'telephone'     => 'Telephone',
            'email'         => 'Email',
            'li1'           => 'Answer the entepreneur doubts',
            'li2'           => 'Promoting the purchase of Omnilife products',
            'li3'           => 'Recommend the use of products',
            'li4'           => 'Support in the buying process',
        ],

        'prospect'  => [
            'title'     => 'A contact is about to end his registration!',
            'subject'   => 'The distributor didn\'t complete his/her registration',
            'h6'        => 'The distributor didn\'t complete his/her registration',
            'h3'        => 'The distributor didn\'t complete his/her registration',
            'p1'        => '<strong>:name</strong>, don\'t miss the opportunity to expand your business with us!',
            'p2'        => [
                'text1' => 'We\'d like to let you know that',
                'text2' => 'is interested in joining your Distributor network and didn\'t complete his/her registration.',
            ],
            'p3'        => 'Contact his/her now and increase your chances of reaching your monthly goal easier',
            'li'        => [
                1   => 'Name',
                2   => 'Telephone',
                3   => 'Email',
            ],
            'p4'        => 'Remember that for every purchase she/he makes, you make more points to move you forward and reach the goals of your Independent Business',
            'p5'        => [
                'text1' => '"If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to',
                'text2' => 'with subject line: Right to Oppose, your full name, country and telephone number, or call our {CREO} service lines".',
            ],
            'a1'        => 'Privacy Policy',
        ],
    ],

    'warehouse' => [
        'empty' => 'Empty warehouse, modify your shippping information',
    ],

    'next_button' => 'Continue',
    'prev_button' => 'Go back',
    'checkout_button' => 'Checkout',
    'errors' => 'Errors',
];
