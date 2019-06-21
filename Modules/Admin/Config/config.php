<?php

return [
    'name' => 'Admin',
    'config' => [
        'url' => 'admin',
        'help_link' => 'https://www.coastercms.org/documentation/user-documentation',
        'public' => '/cms',
        'bootstrap_version' => '3', // for pagination (supports 3 or 4)
        'title_block' => 'title',
        'default_template' => '1',
        'publishing' => '0',
        'advanced_permissions' => '0',
        'undo_time' => 3600, // limit for which deleted items can be restored for
        'always_load_routes' => '0',
    ],
    'locale' => [
        'defaultLocale' => 'es'
    ],
    'role_sections' => [
        1 => 'admin::roles.sections.cms',
        2 => 'admin::roles.sections.settings',
        3 => 'admin::roles.sections.users',
        4 => 'admin::roles.sections.shopping',
        5 => 'admin::roles.sections.distributorarea',
        5 => 'admin::roles.sections.gym'
    ],
    'reports' => [
        1 => [
            'action'=>route('admin.report.orders'),
            'name'=>'order'
        ],
        2 =>  [
            'action'=>route('admin.report.surveyindex'),
            'name'=>'survey_report'
        ]
    
        ],   
    'sources' => [
        'web',
        'mobile'
    ],
    'block_text_options' => array(1, 5, 25, 30, 31),
];
