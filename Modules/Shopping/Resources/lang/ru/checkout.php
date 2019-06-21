<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'checkout'              => 'Оплатить',
    'title'                 => 'Продолжить покупки',
    'keep_buying'           => 'Keep buying',
    'return'                => 'Назад ',
    'continue_payment'      => 'Перейти к оплате',
    'finish_purchase'       => 'Завершить покупку',

    'payment' => [
        'select_payment' => 'Выбрать способ оплаты',
        'resume_payment' => 'Содержание заказа',
        'no_items'       => 'В корзине пусто',
        'handling'       => 'Сервисный сбор',
        'taxes'          => 'Налоги',
        'attention'      => 'Внимание',
        'total'          => 'Итог',
        'discount'       => 'Discount',
        'points'         => 'Баллы',
        'shopping_cart'  => 'Корзина',

        'card_pplus'     => 'Credit/debit card',
        'pay_pplus'      => 'Pay with Paypal Plus',

        'errors' => [
            # Generales
            'cancel_paypal' => 'Вы отменили платеж. Вы можете начать процесс оплаты, нажав на кнопку PayPal.',
            'default' => 'Возникли проблемы',
            'address' => 'Произошла ошибка при проверке ваших продуктов, пожалуйста, подтвердите, что ваш адрес завершен',
            'general' => 'We´re sorry, but something went wrong. Please try again. If the problem persists, contact us.',

            # Programación
            'sys001' => 'Err: SYS001 A problem has occurred, please contact the technical support service',
            'sys002' => 'Err: SYS002 A problem has occurred, please contact the technical support service',
            'sys003' => 'Err: SYS003 A problem has occurred, please contact the technical support service',
            'sys004' => 'Err: SYS004 A problem has occurred, please contact the technical support service',
            'sys005' => 'Err: SYS005 С Вашим адресом доставки возникли проблемы, вернитесь на предыдущий шаг и выберите его снова, или попробуйте выбрать другой адрес',
            'sys006' => 'Err: SYS006 A problem has occurred, please contact the technical support service',
            # Paypal
            'sys101' => 'Err: SYS101 An error has occurred when attempting to process your payment, please try again.',
            'sys102' => 'Err: SYS102 An error has occurred when attempting to process your payment, please try again.',
            'sys103' => 'Err: SYS103 An error has occurred when attempting to process your payment, please try again.',
            # Paypal Plus
            'sys104' => 'Err: SYS104 An error has occurred when attempting to process your payment, please try again.',
            'sys105' => 'Err: SYS105 An error has occurred when attempting to process your payment, please try again.',
            'sys106' => 'Err: SYS106 An error has occurred when attempting to process your payment, please try again.',

            'payment_rejected'               => 'Ваш платеж был отклонен, попробуйте снова или выберите другой способ оплаты',
            'instrument_declined'            => 'Платежная система или банк отклонил Ваш платежный метод или этот платежный метод не может быть использован. Попробуйте снова.',
            'bank_account_validation_failed' => 'Сбой проверки банковского счета. Попробуйте снова',
            'credit_card_cvv_check_failed'   => 'Проверка банковской карты была отклонена. Проверьте свои данные и повторите попытку.',
            'credit_card_refused'            => 'Банковская карта была отклонена. Повторите попытку с другой картой',
            'credit_payment_not_allowed'     => 'Кредит не может быть использован для оплаты. Выберите другой способ оплаты и повторите попытку.',
            'insufficient_funds'             => 'Недостаточно средств. Выберите другой способ оплаты и попробуйте снова',
            'payment_denied'                 => 'Оплата отклонена. Выберите другой способ оплаты и попробуйте снова',
            'internal_service_error'         => 'Возникла ошибка. Повторите попытку позднее',
            'payment_expired'                => 'Срок платежа истек. Попробуйте еще раз.',
            'payment_already_done'           => 'Payment has expired. Try again.',
            'duplicate_transaction'          => 'Количество банковских транзакций удваивается.',
            'default_paypal'                 => 'Не удалось проверить ваш платеж, обратитесь в службу поддержки.'
        ],

        'modal' => [
            'loader' => [
                'title' => 'Платеж обрабатывается',
                'p1'    => "Ты в шаге от финансовой независимости",
                'p2'    => 'Не закрывайте и не обновляйте эту страницу пока платеж не будет подтвержден'
            ]
        ],
    ],

    'confirmation' => [
        'success' => [
            'thank_you'       => 'Спасибо за покупку!',
            'success_pay'     => 'Платеж прошел успешно',
            'order_number'    => 'Номер заказа',
            'corbiz_order'    => 'Order Corbiz',
            'corbiz_number'   => 'Corbiz order number',
            'order_arrive_in' => 'Ваш заказ будет отправлен по адресу',
            'business_days'   => 'рабочие дни',
            'pay_with_card'   => 'Оплатить с помощью карты',
            'pay_with_paypal' => 'Оплатить с помощью PayPal',
            'pay_with_paypal_plus' => 'Оплатить с помощью PayPal Plus',
            'pay_auth'        => 'Payment Authorization',
            'total'           => 'Сумма покупки',
            'send_to'         => 'Отправить',
            'product_name'    => 'Имя продукта',
            'points'          => 'Баллы',
            'Eonumber'        => 'Eo Number',
            'password'        => 'Password',
            'secretquestion'  => 'Контрольный Вопрос',
            'message_inscription' => 'Проверьте свои e-mail. Чтобы завершить создание аккаунта'
        ],

        'pending' => [
            'info'    => 'Ваш платеж проверяется.<br>После подтверждения оплаты вы получите электронное письмо с информацией о вашем заказе.',
            'pending' => 'Ожидается платеж',
        ],

        'no_order' => [
            'info' => 'Ваш платеж был обработан, но при создании заказа возникла проблема.<br>Мы свяжемся с вами по электронной почте для подтверждения.'
        ],

        'error' => [
            'info' => 'Ваш платеж был обработан, но при создании заказа возникла проблема.<br>Мы свяжемся с вами по электронной почте для подтверждения.'
        ],

        'emails' => [
            'confirmation_title' => 'Your payment is in verification',
            'order_success'      => 'Подтверждение заказа'
        ]
    ],

    'email' => [
        'entepreneur' => 'Omnilife Entepreneur,',//Nueva

        'confirmation' => [
            'title'   => 'Shopping Omnilife | Your payment was successful',
            'title_2' => 'Payment confirmation',
            'p_hi'    => 'Hello {name}!',
            'p_1'     => 'Payment for your order has been successful.',
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
            'title_2' => 'Payment confirmation',
            'title_3' => 'New Distributor on your Network',
            'p_hi'    => 'Hello {name}!',
            'p_1'     => 'Your order has been confirmed.',
            'p_2'     => 'Your order will be shipped to the indicated address.',
            'p_3'     => '<small>*Delivery times are determined as of this payment confirmation date.</small>',
            'p_4'     => 'Order information:',
            'p_5'     => 'Order number: {order}',
            'p_6'     => 'Name: {name}',
            'p_7'     => 'Address: {address}',
            'p_8'     => 'Upon receiving your order, we suggest you check the packaging.',
            'p_9'     => '<small>“If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a> with subject line: Right to Oppose, your full name, country and telephone number, or call our <strong>{CREO}</strong> service lines”.</small>',
            'p_10'    => 'Privacy Policy',
            'p_11'    => 'Детали заказа:',
            'p_12'    => 'Содержание заказа',
        ]
    ],

    'quotation' => [
        'resume_cart' => [
            'remove_all' => 'Удалить все',
            'code' => 'Номер',
            'pts' => 'Баллы',
            'subtotal' => 'Промежуточный итог',
            'discount' => 'Descuento', //Nueva
            'handling' => 'Сервисный сбор',
            'taxes' => 'Налоги',
            'points' => 'Баллы',
            'total' => 'Итог',
            'no_items' => 'В корзине пусто',
            'delete_items' => 'Некоторые продукты не могут быть отправлены по адресу с данным индексом; Они были удалены из корзины',
            'purchase_summary' => 'Содержание заказа',
            'discount'       => 'Discount',
        ],
        'change_period' => 'Изменить на предыдущий период',
        'change_period_yes' => 'Да',
        'change_period_no' => 'Нет',
        'change_period_success_msg' => 'Период успешно изменен',
        'change_period_fail_msg' => 'Не удалось изменить период. Попробуйте позднее',
    ],

    'promotions' => [
        'title_modal' => 'Промоакции',
        'msg_select_promotions' => 'Выберите один продукт или пакет из следующих промоакций',
        'msg_promo_required' => 'Обязательно',
        'label_quantity' => 'Количество',

        'btn_select' => 'Выбрать',
        'btn_accept' => 'Принять',

        'msg_promo_obliga' => 'Для продолжения необходимо выбрать товар/набор по промоакции :name_promo',
        'msg_promo_qty' => 'Вы можете выбрать только :qty_promo продукт промоакции :name_promo',

        'msg_promo_A' => 'Выберите один из следующих номер. Можно выбрать максимально :qty штук.',
        'msg_promo_B' => 'Выберите один из следующих номер. Можно выбрать максимально :qty штук.',
        'msg_promo_C' => 'Вы можете выбрать :qty следующих продуктов / [2,*] Вы можете выбрать до :qty следующих продуктов, если они имеются на складе в нужном количестве. Вы можете выбрать 1 или более упаковок каждого продукта.',
    ]
];
