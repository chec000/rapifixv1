<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 16/04/2018
 * Time: 02:47 PM
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

    'user_list' => [
        'usr_lst' => 'User list',
        'user' => 'User',
        'name' => 'Name',
        'role' => 'Role',
        'lang' => 'Language',
        'brands' => 'Brands',
        'countries' => 'Countries',
        'actions' => 'Actions',
        'active' => 'Active',
        'disabled' => 'Disabled',
        'enable_user' => 'Enable User',
        'disable_user' => 'Disable User',
        'edit_user' => 'Edit User',
        'delete_user' => 'Delete user',

        'msg_cant_disabled_own_account' => 'Can\'t disable your own account',
        'msg_cant_disabled_user' => 'Can\'t disable this user.',
        'msg_cant_delete_own_account' => 'Can\'t delete your own account',

    ],
    'form_add' => [
        'title_form_add' => 'Add New User',
        'account_password' => 'Account Password:',
        'add_another_user' => 'Add Another User',
        'back_user_list' => 'Back To User List',
        'user_name' => 'User Name',
        'user_position' => 'User Position',
        'user_email' => 'User Email',
        'user_role' => 'User Role',
        'language' => 'Language',
        'brands' => 'Brands',
        'countries' => 'Countries',
        'int_password' => 'Password',
        'confirm_int_password' => 'Confirm password',
        'send_email' => 'Send Email',
        'add_user' => 'Add User',

        'msg_account_created' => 'The account :email has been successfully created!',
        'msg_error_bd' => 'An error occurred while trying to save your user, Please inform the IT area.',
        'msg_email_sent' => 'An email has been sent to the new user with their login details.',
        'msg_error_email_sent' => 'There was an error sending the login details to the new user.',
        'msg_no_permission_create' => 'Don\'t have permission to create user with this role, or doesn\'t exist.',
    ],
    'form_edit' => [
        'title_form_edit' => 'Edit User',

        'date_created' => 'Date Created',
        'account_status' => 'Account Status',

        'active' => 'Active',
        'disabled' => 'Disabled',

        'account_password' => 'Account Password:',
        'back_user_list' => 'Back To User List',
        'user_name' => 'User Name',
        'user_position' => 'User Position',
        'user_email' => 'User Email',
        'user_role' => 'User Role',
        'language' => 'Language',
        'brands' => 'Brands',
        'countries' => 'Countries',
        'int_password' => 'Password',
        'current_pass' => 'Current Password',
        'new_pass' => 'New Password',
        'confirm_int_password' => 'Confirm password',
        'send_email' => 'Send Email',
        'edit_user' => 'Edit User',

        'change_pass' => 'Change Password',
        'update_pass' => 'Update Password',
        'btn_update' => 'Update',

        'msg_account_updated' => 'The account :email has been successfully updated!',
        'msg_error_bd' => 'An error occurred while trying to save your user, Please inform the IT area.',
        'msg_email_sent' => 'An email has been sent to the user with their login details.',
        'msg_error_email_sent' => 'There was an error sending the login details to the new user.',
        'msg_no_permission_create' => 'Don\'t have permission to create user with this role, or doesn\'t exist.',
        'msg_cant_edit' => 'Can\'t edit this user',
        'msg_user_not_found' => 'User not found'
    ]
];