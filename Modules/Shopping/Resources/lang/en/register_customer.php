<?php

return [
    'title' => 'Client Register',

    'months'        => [
        1   => 'January',
        2   => 'February',
        3   => 'March',
        4   => 'April',
        5   => 'May',
        6   => 'June',
        7   => 'July',
        8   => 'August',
        9   => 'September',
        10  => 'October',
        11  => 'November',
        12  => 'December',
    ],

    'error__box'    => 'One or more problems occurred',

    'error_rest'    => 'An inconvenience has been detected, for more information contact CREO.',

    'tabs' => [
        'account' => [
            'desktop'   => '1. Create Account',
            'mobile'    => 'Account',
        ],

        'email' => [
            'desktop'   => '2. Mail Address',
            'mobile'    => 'Mail',
        ],

        'activation' => [
            'desktop'   => '3. Activation',
            'mobile'    => 'Activation',
        ],
    ],
    'account' => [
        'country' => [
            'label'     => 'Country',
            'default'   => 'Select your country',
        ],

        'invited' => [
            'label' => [
                'desktop'   => 'Were you invited by an OMNILIFE Distributor?',
                'mobile'    => 'Were you invited',
            ],

            'answer' => [
                'yes'   => 'Yes',
                'no'    => 'No'
            ],
        ],

        'businessman_code' => [
            'label'         => 'Distributor Code',
            'placeholder'   => 'Enter code',
        ],

        'meet_us' => [
            'label'     => 'How did you hear about us? ',
        ],

        'sex' => [
            'label'     => 'Gender',
            'male'      => 'Male',
            'female'    => 'Female',
        ],

        'borndate' => [
            'label' => 'Date of birth',
            'day'   => 'Day',
            'month' => 'Month',
            'year'  => 'Year',
            'alert' => 'The Date of birth field is not valid.',
        ],

        'full_name' => [
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
        ],

        'identification' => [
            'label'         => 'Identification',
            'option'        => 'ID Type',
            'placeholder'   => 'Identification number',
        ],

        'expiration' => [
            'placeholder'   => 'Expiration date',
        ],

        'address' => [
            'label'         => 'Address',
            'placeholders'  => [
                'zip'               => 'Zip Code',
                'ext_num'           => 'Exterior Number',
                'int_num'           => 'Interior Number',
                'county'            => 'County',
                'suburb'            => 'Suburb',
                'betweem_streets'   => 'On the streets',
                'state'             => 'State',
                'city'              => 'City',
                'street'            => 'Street',
                'shipping_company'  => 'Shipping Company',
            ],
        ],
    ],

    'mail_address' => [
        'mail' => [
            'label'         => 'Mail',
            'placeholder'   => 'Enter your mail',
        ],

        'confirm_mail' => [
            'label'         => 'Confirm Mail',
            'placeholder'   => 'Enter your mail',
        ],

        'tel' => [
            'label'         => 'Telephone',
            'placeholder'   => 'Enter your telephone',
        ],

        'cel' => [
            'label'         => 'Cellphone',
            'placeholder'   => 'Enter your cellphone',
        ],

        'info_send'     => 'Check your email to continue the registration process.',
        'title'         => 'Support Omnilife',
        'subject'       => 'Request to validate your email',
    ],

    'activation' => [
        'question'      => 'Secret Question',
        'answer'        => 'Answer',
        'option'        => 'Select one question',
        'placeholder'   => 'Write your answer',
        'label'         => 'Registration completed successfully, your data are as follows',
        'code'          => 'Customer Code',
        'password'      => 'Password',
    ],

    'mail' => [
        'verify' => [
            'title'     => 'Verify your account',
            'subject'   => 'Verify your account',
            'h6'        => 'Verify your account',
            'h3'        => 'Hello, :name!',
            'p1'        => 'To complete your register, please verify your account by clicking on the following button',
            'p2'        => 'This is an automatic response from OMNILIFE. Please, do not reply to this e-mail address.',
            'a1'        => 'CONFIRM MY E-MAIL ADDRESS',
            'a2'        => 'Privacy Policy',
        ],

        'customer'      => [
            'title'     => 'Welcome to OMNILIFE',
            'subject'   => 'Welcome',
            'h6'        => 'Welcome',
            'h3'        => 'Welcome to OMNILIFE!',
            'p5'        => 'We\'d like to let you know that your registration as a Customer has been successful. Starting now, you are able to make purchases and enjoy the benefits of being an OMNILIFE customer.',
            'p1'        => 'This is your account information',
            'li'        => [
                1   => 'Customer Code',
                2   => 'Password',
                3   => 'Security question',
                4   => 'Answer to security question',
            ],
            'p2'        => 'We recommend that you do not share your customer code and password as it is considered private and necessary information to make purchases on our website',
            'p3'        => [
                'text1' => 'We invite you to visit our website and make',
                'text2' => 'your first purchase today!',
            ],
            'p4'        => [
                'text1' => '"If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to',
                'text2' => 'with subject line: Right to Oppose, your full name, country and telephone number, or call our {CREO} service lines".',
            ],
            'a1'        => 'Privacy Policies',
        ],

        'sponsor' => [
            'title'     => 'New customer in your Distributor Network',
            'subject'   => 'New customer in your Distributor Network',
            'h6'        => 'New customer in your Distributor Network',
            'h3'        => 'Congratulations, :name!',
            'p1'        => [
                'text1' => 'Your Independent Business with us is growing,',
                'text2' => 'has registered under your network as a Customer.',
            ],
            'p2'        => 'Stay in touch to reach your monthly goal more easily',
            'li'        => [
                1   => 'Distributor Code',
                2   => 'Name',
                3   => 'Telephone',
                4   => 'Email',
            ],
            'ul'        => 'Encourage your new Customer to stay active because with every purchase she makes, you make more points to move you forward and reach your goals.',
            'p3'        => [
                'text1' => '"If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to',
                'text2' => 'with subject line: Right to Oppose, your full name, country and telephone number, or call our {CREO} service lines".',
            ],
            'a1'        => 'Privacy Policies',
        ],

        'hello'             => 'Hello',
        'title'             => 'Email Confirmation',
        'text'              => 'To continue with the registration process, click on the next button. .',
        'confirm'           => 'Go to Email Confirmation',
        'regards'           => 'Best regards',
        'team'              => 'Team Omnilife',
        'privacy_policy'    => 'Privacy Policy',
    ],

    'fields' => [
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

    'btn' => [
        'back'          => 'Go Back',
        'continue'      => 'Continue',
        'activate'      => 'Activate',
        'resend_mail'   => 'Resend Mail',
        'finish'        => [
            'shopping'  => 'Continue Shopping',
            'login'     => 'Login'
        ],
    ],

    'modal_exit' => [
        'title' => 'Incomplete register',
        'body'  => 'You haven\'t completed the register. If you leave this page, you will lose the unsaved information. Do you want to continue?',
        'btn' => [
            'accept'    => 'Accept',
            'cancel'    => 'Cancel',
        ],
    ],
];
