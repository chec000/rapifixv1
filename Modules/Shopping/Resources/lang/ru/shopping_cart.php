<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'tabs' => [
      'address' => [
        'desktop' => '1. Адрес доставк',
        'mobile' => 'Адрес'
      ],
      'payment' => [
        'desktop' => '2. Способ оплаты',
        'mobile' => 'Оплата'
      ],
      'confirm' => [
        'desktop' => '3. Подтверждение',
        'mobile' => 'Подтверждение'
      ],
    ],

    'header' => [
      'title' => 'Checkout',
      'subtitles' => [
        'step1' => 'Выберите адрес доставки',
        'step2' => 'Выберите способ оплаты'
      ],
    ],

    'new_address' => [
      'header' => 'Новый адрес',
      'subheader1' => 'Заполнить из другого адреса доставки',
      'subheader2' => 'Этот адрес может повлиять на цену доставки',
      'placeholders' => [
        'name' => 'Имя',
        'last_name' => 'Фамилия',
        'last_name2' => 'Фамилия',
        'street' => 'Street',
        'ext_num' => 'Exterior number',
        'int_num' => 'Interior number',
        'streets' => 'On the streets',
        'colony' => 'Colony',
        'state' => 'Регион/Область',
        'city' => 'Город',
        'zip' => 'Индекс',
      ],
      'save_button' => 'Созранить адрес',
      'save_fav_button' => 'Мой адрес доставки по умолчанию',
    ],

    'continue_buying' => 'Продолжить покупки',
    'continue_payment' => 'Оплата',

    'accept_conditions' => [
      'text' => 'Принимаю',
      'link' => 'Условия Пользовательского Соглашения',
    ],

    'checkout' => 'Check out',

    'cart' => [
      'header' => 'Оплатить заказ',
      'product_code' => 'Номер',
      'points' => 'баллы',
      'bill' => [
        'subtotal' => 'Промежуточный Итог',
        'management' => 'Сервисный сбор',
        'taxes' => 'налоги',
        'points' => 'Баллы',
        'total' => 'Итог',
      ]
    ],

    'modal' => [
      'header' => 'Обработка платежа',
      'text_highlight' => 'Ты все ближе к своей финансовой свободе',
      'text' => 'Не закрывайте и не перезагружайте это окно'
    ],

    'confirm' => [
      'header' => 'Спасибо за заказ',
      'subheader' => 'Платеж проведен успешно',
      'order_arrive' => 'Ваш заказ будет доставлен в',
      'order_number' => 'Номер заказа',
      'card_payment' => 'Оплата картой',
      'total' => 'Итог',
      'send_to' => 'Отправить',
    ]

];
