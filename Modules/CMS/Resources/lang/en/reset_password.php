<?php

return [
    'title' => 'Reset Password',

    'step1' => [
        'title'         => 'Recover your <span>password</span>',
        'subtitle'      => 'Enter your distributor number',
        'placeholder'   => 'Dealer Number',
        'contact1'      => 'If you need help please',
        'contact2'      => 'Contact Us',
    ],

    'step2' => [
        'title'             => 'How do you wish to reestablish your <span>password?</span>',
        'subtitle'          => 'Choose an option',
        'option1_title'     => 'Receive an email',
        'option1_subtitle'  => 'We will send instructions to your email address that ends in:',
        'option2_title'     => 'Answer your security question',
        'option2_subtitle'  => 'Answer the security question you chose when you registering.',
    ],

    'step3' => [
        'title'             => 'Recover your <span>password</span>',
        'subtitle'          => 'Confirm your born date',
        'born_date'         => 'Born Date',
        'day'               => 'Day*',
        'month'             => 'Month*',
        'year'              => 'Year*',
        'error_borndate'    => 'The born date does not match.',
    ],

    'step3_1' => [
        'title'         => 'Recover your <span>password</span>',
        'subtitle'      => 'Check your email for the verification code we sent you and enter it here:',
        'code'          => 'Verification Code',
        'code_error'    => 'The Verification Code does not match.',
        'forwarding'    => 'If you have not received the email, ',
        'forwarding_2'  => 'click here.'
    ],

    'step4' => [
        'title'             => 'Recover your <span>password</span>',
        'subtitle'          => 'Answer this security question that you chose when registering',
        'answer'            => 'Answer',
        'answer_required'   => 'The Answer field is required.',
        'error_answer'      => 'The answer is incorrect.',
        'answer_no_exist'   => 'An inconvenience has been detected, for more information contact CREO.',
    ],

    'step5' => [
        'title'                         => 'Recover your <span>password</span>',
        'subtitle'                      => 'Enter a new password to',
        'alert'                         => 'Avoid passwords that you use on other websites or that someone can easily guess.',
        'new_password'                  => 'New password 4 digits',
        'new_password_confirm'          => 'Password Confirm',
    ],

    'step6' => [
        'title'     => 'Password reset <span>correctly</span>',
        'subtitle'  => 'You can now login to your account with your new password'
    ],

    'email' => [
        'title'             => 'Shopping Omnilife',
        'subject'           => 'Reset Password request in Omnilife',
        'heading'           => "We have received your request to reset your password. To complete this process, enter the following verification code in the password reset webpage.",
        'heading2'          => 'We&#039;d like to confirm that the password for your account (:email_heading) has been successfully updated',
        'footer'            => 'Best regards,',
        'footer_omni'       => 'Team Omnilife',
        'footer_sub'        => 'If you did not make this update request, please notify us at :email to resolve any inconvenience.',
        'privacy_policy'    => 'Privacy Policy',
    ],

    'fields' => [
        'required'  => 'The :attribute field is required.',
        'in'        => 'The selected :attribute is invalid.',
        'min'       => 'The :attribute must be at least :min characters.',
        'max'       => 'The :attribute may not be greater than :max characters.',
        'same'      => 'The :attribute and :other must match.',
    ],

    'btnContinue'   => 'Continue',
    'btnBack'       => 'Back',
    'btnLogin'      => 'Log in',
    'errors'        => 'One or more problems occurred:',
    'error_rest'    => 'An inconvenience has been detected, for more information contact CREO.',
];