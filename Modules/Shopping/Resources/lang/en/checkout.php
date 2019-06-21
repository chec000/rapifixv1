<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'checkout'              => 'Shipping Address',
    'title'                 => 'OMNILIFE - Check out',
    'keep_buying'           => 'Keep Shopping',
    'return'                => 'Go back ',
    'continue_payment'      => 'Proceed to payment',
    'finish_purchase'       => 'Complete purchase',

    'payment' => [
        'select_payment' => 'Select method of payment',
        'resume_payment' => 'Purchase summary',
        'no_items'       => 'There are no articles',
        'handling'       => 'Handling',
        'taxes'          => 'Taxes',
        'attention'      => 'Attention',
        'total'          => 'Total',
        'discount'       => 'Discount',
        'points'         => 'Points',
        'shopping_cart'  => 'Shopping cart',

        'card_pplus'     => 'Credit/debit card',
        'pay_pplus'      => 'Pay with Paypal Plus',

        'errors' => [
            # Generales
            'cancel_paypal' => 'The transaction has been cancelled. You may proceed to the payment by clicking in the payment button.',
            'default' => 'One or several problems were encountered',
            'address' => 'An error occurred when checking your products, please verify your address is complete',
            'general' => 'We´re sorry, but something went wrong. Please try again. If the problem persists, contact us.',

            # Programación
            'sys001' => 'Err: SYS001 A problem has occurred, please contact the technical support service',
            'sys002' => 'Err: SYS002 A problem has occurred, please contact the technical support service',
            'sys003' => 'Err: SYS003 A problem has occurred, please contact the technical support service',
            'sys004' => 'Err: SYS004 A problem has occurred, please contact the technical support service',
            'sys005' => 'Err: SYS005 A problem has occurred with your shipping address, go back to the previous step and select it again or try selecting another address',
            'sys006' => 'Err: SYS006 A problem has occurred, please contact the technical support service',
            # Paypal
            'sys101' => 'Err: SYS101 An error has occurred when attempting to process your payment, please try again.',
            'sys102' => 'Err: SYS102 An error has occurred when attempting to process your payment, please try again.',
            'sys103' => 'Err: SYS103 An error has occurred when attempting to process your payment, please try again.',
            # Paypal Plus
            'sys104' => 'Err: SYS104 An error has occurred when attempting to process your payment, please try again.',
            'sys105' => 'Err: SYS105 An error has occurred when attempting to process your payment, please try again.',
            'sys106' => 'Err: SYS106 An error has occurred when attempting to process your payment, please try again.',

            'payment_rejected'               => 'Your payment has been declined, try again or use a different method of payment.',
            'instrument_declined'            => 'The payment processor or bank declined your payment method or this method of payment can´t be used. Try again.',
            'bank_account_validation_failed' => 'Bank account verification failed. Try again.',
            'credit_card_cvv_check_failed'   => 'Credit card verification was rejected. Verify your information and try again. ',
            'credit_card_refused'            => 'Credit card was declined. Try again with another credit card.',
            'credit_payment_not_allowed'     => 'Credit cannot be used to complete payment. Please select another payment method and try again. ',
            'insufficient_funds'             => 'Insufficient funds. Please select another method of payment and try again.',
            'payment_denied'                 => 'Payment denied. Please select another method of payment and try again.',
            'internal_service_error'         => 'An error has occured, please wait a moment and try again.',
            'payment_expired'                => 'Payment has expired. Try again.',
            'payment_already_done'           => 'Payment has been done already for this purchase.',
            'duplicate_transaction'          => 'The number of bank transactions is duplicate.',
            'default_paypal'                 => 'There has been a problem validating your payment, please contact the support team.'
        ],

        'modal' => [
            'loader' => [
                'title' => 'Processing your payment',
                'p1'    => "You're a step away from financial liberty",
                'p2'    => 'Do not close or refresh this window until you receive your payment confirmation.'
            ]
        ],
    ],

    'confirmation' => [
        'success' => [
            'thank_you'       => 'Thank you for shopping with us',
            'success_pay'     => 'Successful payment',
            'order_number'    => 'Order number',
            'corbiz_order'    => 'Confirmation number',
            'corbiz_number'   => 'Confirmation number',
            'order_arrive_in' => 'Your order will arrive in',
            'business_days'   => 'business days',
            'pay_with_card'   => 'Payment with card',
            'pay_with_paypal' => 'Payment with PayPal',
            'pay_with_paypal_plus' => 'Payment with PayPal Plus',
            'pay_auth'        => 'Payment Authorization',
            'total'           => 'Purchase total',
            'send_to'         => 'Send to',
            'product_name'    => 'Product name',
            'points'          => 'Pts',
            'Eonumber'        => 'Eo Number',
            'password'        => 'Password',
            'secretquestion'  => 'Security Question',
            'message_inscription' => 'You may now shop online and enjoy the benefits of being part of'
        ],

        'pending' => [
            'info'    => 'Your payment is being validated.<br>Once your payment is approved, you will receive an e-mail with your order information.',
            'pending' => 'Pending payment',
        ],

        'no_order' => [
            'info' => 'Your payment has been processed but a problem has occurred when generating your order.<br>We will contact you via E-mail to provide you with the confirmation.'
        ],

        'error' => [
            'info' => 'Your payment has been processed but a problem has occurred when generating your register.<br>Soon you will be receiving a confirmation email',
        ],

        'emails' => [
            'confirmation_title' => 'The payment of your order has been successful',
            'order_success'      => 'Order confirmation'
        ]
    ],

    'email' => [
        'entepreneur' => 'Omnilife Entepreneur,',

        'confirmation' => [
            'title'   => 'Shopping Omnilife | Your payment was successful',
            'title_2' => 'Payment confirmation',
            'p_hi'    => 'Hello {name}!',
            'p_1'     => 'Thank you for shopping with us! The payment of your order has been successful.',
            'p_2'     => 'Your order will be shipped to the indicated address.',
            'p_3'     => '<small>*The days of delivery are determined depending on your shipping method.</small>',
            'p_4'     => 'Order information:',
            'p_5'     => 'Order number: {order}',
            'p_6'     => 'Name: {name}',
            'p_7'     => 'Address: {address}',
            'p_8'     => '<small>“If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a> with subject line: Right to Oppose, your full name, country and telephone number, or call our <strong>{CREO}</strong> service lines”.</small>',
            'p_9'     => 'Privacy Policy',
        ],

        'success_order' => [
            'title'   => 'Shopping Omnilife | Your payment was successful',
            'title_2' => 'Order confirmation',
            'title_3' => 'New Distributor on your Network',
            'p_hi'    => 'Hello {name}!',
            'p_1'     => 'Your order has been confirmed.',
            'p_2'     => 'Your order will be shipped to the indicated address.',
            'p_3'     => '<small>*The days of delivery are determined depending on your shipping method.</small>',
            'p_4'     => 'Order information:',
            'p_5'     => 'Order number: {order}',
            'p_6'     => 'Name: {name}',
            'p_7'     => 'Address: {address}',
            'p_8'     => 'Upon receiving your order, we suggest you check the packaging.',
            'p_9'     => '<small>“If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a> with subject line: Right to Oppose, your full name, country and telephone number, or call our <strong>{CREO}</strong> service lines”.</small>',
            'p_10'    => 'Privacy Policy',
            'p_11'    => 'Details of your order:',
            'p_12'    => 'Order summary',
        ]
    ],

    'quotation' => [
        'resume_cart' => [
            'remove_all' => 'Delete all',
            'code' => 'Code',
            'pts' => 'points',
            'subtotal' => 'Subtotal',
            'handling' => 'Handling',
            'taxes' => 'Taxes',
            'points' => 'Points',
            'total' => 'Total',
            'no_items' => 'No products have been added to the cart',
            'delete_items' => 'Certain products cannot be sent to the selected Zip Code; they have been eliminated from your cart.',
            'purchase_summary' => 'Purchase summary',
            'discount' => 'Discount',
        ],
        'change_period' => 'Change to previous period?',
        'change_period_yes' => 'Yes',
        'change_period_no' => 'No',
        'change_period_success_msg' =>'Period change successful.',
        'change_period_fail_msg' =>'Period change fail, try later.',
    ],
    
    'promotions' => [
        'title_modal' => 'Promotions',
        'msg_select_promotions' => 'Your purchases generated the following promotions',
        'msg_promo_required' => '(Required)',
        'label_quantity' => 'Quantity',

        'btn_select' => 'Select',
        'btn_accept' => 'Accept',

        'msg_promo_obliga' => 'To continue, it is necessary to choose a product/package of the promotion: :name_promo',
        'msg_promo_qty' => 'You can only choose :qty_promo product(s) of the promotion: :name_promo',

        'msg_promo_A' => 'Add to your shopping cart one of the following packages. You can choose the maximum quantity of :qty of the selected package.',
        'msg_promo_B' => 'Add to your shopping cart one of the following packages. You can choose the maximum quantity of :qty of the selected package.',
        'msg_promo_C' => '{1} Add to your shopping cart up to :qty products from the promotion of your choice. | [2,*] Add to your shopping cart up to :qty products from the promotion of your choice, if the quantity allows, can be 1 or more of each product.',
    ]
];
