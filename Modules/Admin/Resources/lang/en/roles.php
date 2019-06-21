<?php
return [
    'sections' => [
        'cms' => 'Content Management',
        'settings' => 'Settings',
        'users' => 'User Admin',
        'shopping' => 'Shopping Support',
        'distributorarea' => 'Distributor Area'
    ],
    'view_roles' => [
        'roles' => 'Roles',
        'loading' => 'Loading ...',
        'saving' => 'Saving...',
        'view_role' => 'View Role:',
        'active' => 'Active',
        'disabled' => 'Disabled',
        'none' => '-- None --',
        ],
    'msgs' => [
        'error_bd' => 'An error occurred while trying to save to the BD',
        'error_bd_disable' => 'An error occurred while trying to enable the Role in the DB',
        'register_saved' => 'Register saved successful.',
        'register_updated' => 'Register updated successful.',
        'disabled_success' => 'Role disabled successful.',
        'error_bd_activated' => 'An error occurred when trying to activate the Role in the BD',
        'activated_success' => 'Rol successful activated.',
        'role_could_not_activated' => 'The selected role could not be activated, please try again later.',
        'page_permission_updated' => 'Page Permissions Updated',
        'msg_modal_empty_data_role' => 'Please enter the data of the role in a language.',
    ],
    'modal_add' => [
        'add_role' => 'Add Role',
        'copy_of' => 'Copy of',
        'lang_disclaimer' => 'Please enter the role information in the available languages, please note that if you do not fill in all the fields the language information will not be displayed correctly.',
        'role_name' => 'Role Name',
        'description' => 'Role Description',
        'country-language-title' => 'Edit for language: '
    ],
    'modal_edit' => [
        'edit_role' => 'Edit Role',
        'lang_disclaimer' => 'Please enter the role information in the available languages, please note that if you do not fill in all the fields the language information will not be displayed correctly.',
        'role_name' => 'Role Name',
        'description' => 'Role Description',
        'country-language-title' => 'Edit for language: '
    ],
    'modal_disable' => [
        'disable_role' => 'Disable Role',
        'msg_assigned_another_role' => 'User\'s who currently have this role will need to be assigned another role.',
        'new_role' => 'New role',
    ],
    'modal_active' => [
        'active_role' => 'Active Role',
        'msg_active_role' => 'Are you sure to active this role?'
    ],
    'buttons' => [
        'active_role' => 'Active current Role',
        'disabled_role' => 'Disable current Role',
        'add_role' => 'Add Role',
        'cancel' => 'Cancel',
        'disable' => 'Disabled',
        'active' => 'Active',
        'edit_role' => 'Edit current Role'
    ]

];
