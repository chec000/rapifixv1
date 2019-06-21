<?php

return [
    'name' => 'CMS',
    'blog' => [
        'url' => '', // relative url ie. /blog/
        // db prefix used for search look ups
        'prefix' => 'wp_',
        // can be used for alternative db connection
        'connection' => '', // pdo conn string
        'username' => '', // db user
        'password' => '' // db password
    ],
    'cdn' => [
        'url' => '' // not added yet
    ],
    'date' => [
        'format' => [
            'jq_date' => 'dd/mm/yy',
            'jq_time' => 'h:mm TT',
            'jq_php' => 'g:i A d/m/Y', // (should match above 2 lines in php) required to convert jq dates
            'long' => 'g:i A d/m/Y',
            'short' => 'd/m/Y'
        ]
    ],
    'frontend' => [
        'croppa_handle' => 'cms.*|uploads.*|themes.*',
        'bootstrap_version' => '3', // for pagination (supports 3 or 4)
        'strong_tags' => '0',
        'form_error_class' => 'has-error',
        'external_form_input' => 'coaster',
        'language_fallback' => '0',
        'theme' => '1',
        'language' => '1',
        'lang_key' => 'en',
        'canonicals' => '1',
        'enabled_feed_extensions' => 'rss,xml,json',
        'cache' => '0' // fpc cache minutes
    ],
    'key' => [
        'bitly' => '',
        'kontakt' => '',
        'yt_server' => 'AIzaSyDAr_iWux0RaqLwfYsnzHkMUe5bZy_31Eo',
        'yt_browser' => 'AIzaSyCnaqD7R08rOUBq2PUusxASAAOjRgREqBI',
        'aviary' => ''
    ],
    'site' => [
        'name' => 'Gym CMS',
        'email' => 'info@example.com',
        'version' => 'v1.0.0',
        'pages' => '0',
        'groups' => '0',
        'secure_folders' => 'secure',
        'storage_path' => 'app/public'
    ],
    'countryKey_ue' => 'ES',
    'countries_ue' => [
        'DE',
        'AT',
        'BE',
        'BG',
        'CY',
        'HR',
        'DK',
        'SK',
        'SI',
        'EE',
        'FI',
        'FR',
        'GR',
        'HU',
        'IE',
        'LV',
        'LT',
        'LU',
        'MT',
        'NL',
        'PL',
        'PT',
        'GB',
        'CZ',
        'RO',
        'SE',
        'NO',
        'CH',
    ],
    'brand_css' => [
        1 => 'master',
        2 => 'master',
        3 => 'master'
    ],
    'success_stories_filters' => [
        0 => 'cms::get-inspired.success_stories_filters.all',
        1 => 'cms::get-inspired.success_stories_filters.freedom',
        2 => 'cms::get-inspired.success_stories_filters.award',
        3 => 'cms::get-inspired.success_stories_filters.quality_life',
        4 => 'cms::get-inspired.success_stories_filters.bonus',
        5 => 'cms::get-inspired.success_stories_filters.product',
        6 => 'cms::get-inspired.success_stories_filters.healty',
        7 => 'cms::get-inspired.success_stories_filters.success_stories',
    ],
    'prefix_redirect' => [
        'distributorarea',
    ],
    'prefix_logout' => [
        'distributorarea',
        'shopping',
    ],
    'email_send' => [
        'USA' => 'support@omnilife.com',
        'MEX' => 'support@omnilife.com'
    ],
    'email_contact' => [
        'USA' => 'creousa@omnilife.com',
    ],
    'countries_policies_except' => [
        9=>'ESP',
    ],
    'configurations_survey' => [
        'portal' => array(
            1 => array(
                'question' =>'cms::survey.portal.cuestions.cuestion-1',
                'type' => 'role',
                'id' => 1,
                'class' => 'role',
                'answers' => [
                    'distributor' => 'cms::survey.portal.answers.distributor',
                    'client' => 'cms::survey.portal.answers.client',
                    'guest' => 'cms::survey.portal.answers.guest'
                ],
                'comments' => ['apply' => false,
                    'label' => 'cms::survey.portal.comments.question2'],
                'active' => true,
                'countries' => ['MEX', 'USA', 'BRA', 'RUS']
            ),
            2 => array(
                'question' => 'cms::survey.portal.cuestions.cuestion-2',
                'type' => 'redesign',
                'class' => 'redesign',
                'id' => 2,
                'answers' => [
                    'worst' => 'cms::survey.portal.answers.worst',
                    'bad' => 'cms::survey.portal.answers.bad',
                    'regular' => 'cms::survey.portal.answers.meh',
                    'good' => 'cms::survey.portal.answers.good',
                    'excellent' => 'cms::survey.portal.answers.excellet',
                ],
                'comments' => ['apply' => true,
                       'label' => 'cms::survey.portal.comments.question2',
                ],
                'active' => true,
                'countries' => ['MEX', 'USA', 'BRA', 'RUS']
            ),

            3 => array(
                'question' => 'cms::survey.portal.cuestions.cuestion-3',
                'type' => 'performance',
                'class' => 'redesign looking',
                'id' => 3,
                'answers' => [
                    'veryHard' => 'cms::survey.portal.answers.veryHard',
                    'hard' => 'cms::survey.portal.answers.hard',
                    'normal' => 'cms::survey.portal.answers.normal',
                    'easy' =>'cms::survey.portal.answers.easy',
                    'veryEasy' => 'cms::survey.portal.answers.excellet',
                ],
                'comments' => ['apply' => false,
                    'label' => 'cms::survey.portal.comments.question2'],
                'active' => true,
                'countries' => ['MEX', 'USA', 'BRA', 'RUS']
            ),
        ),

        /*'oe'=>array (
                    1=> array(
                'question' =>trans('cms::get-inspired.success_stories_filters.all'),
                'answers' => ['worst' =>trans('cms::get-inspired.success_stories_filters.all') ],
                'comments' => ['apply' => true,
                                                'label' =>trans('cms::get-inspired.success_stories_filters.all'),
                 ],
                  'active' => true,
                  'countries' => ['MEX', 'USA', 'BRA']
                ),

                2=> array(
                'question' =>trans('cms::get-inspired.success_stories_filters.all'),
                'answers' => ['worst' =>trans('cms::get-inspired.success_stories_filters.all') ],
                'comments' => ['apply' => true,
                                                'label' =>trans('cms::get-inspired.success_stories_filters.all'),
                 ],
                  'active' => true,
                  'countries' => ['MEX', 'USA', 'BRA']
                ),

          3=> array(
                'question' =>trans('cms::get-inspired.success_stories_filters.all'),
                'answers' => ['worst' =>trans('cms::get-inspired.success_stories_filters.all') ],
                'comments' => ['apply' => true,
                                                'label' =>trans('cms::get-inspired.success_stories_filters.all'),
                 ],
                  'active' => true,
                  'countries' => ['MEX', 'USA', 'BRA']
                ),
                                 ),     */
    ],
    'analytics' => [
        1 => 'UA-59429835-5',
        2 => 'UA-59429835-6',
        3 => 'UA-59429835-7'
    ],
];
