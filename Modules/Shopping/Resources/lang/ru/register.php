<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'Registry',

    'tabs' => [
      'account' => [
        'desktop' => '1. Создать аккаунт',
        'mobile' => 'Аккаунт'
      ],
      'info' => [
        'desktop' => '2. Информация',
        'mobile' => 'Информация'
      ],
      'kit' => [
        'desktop' => '3. Выберите Набор Дистрибьютора',
        'mobile' => 'Набор Дистрибьютора'
      ],
      'confirm' => [
        'desktop' => '4. Подтвердить',
        'mobile' => 'Подтвердить'
      ],
    ],

    'account' => [
      'invited' => [
        'label' => [
          'desktop' => 'Вас пригласил в компаниюю Дистрибьютор OMNILIFE?',
          'mobile' => 'Вас пригласили?',
        ],
        'answer' => [
          'yes' => 'Да',
          'no' => 'Нет'
        ]
      ],
      'businessman_code' => [
        'label' => 'Номер Дистрибьютора',
        'label_sponsored' => 'Sponsor Code',
        'placeholder' => 'Enter your businessman code'
      ],
      'meet_us' => [
        'label' => 'Как Вы узнали о нас?',
        'default' => 'Как Вы узнали о нас?',
      ],
      'country' => [
        'label' => 'Страна',
        'default' => 'Выберите свою страну',
        'empty_countries' => 'Страна не найдена',
        'emptydata' => 'Данные по стране не найдены',
        'emptypool' => 'Данные по Дистрибьютору не найдены',
      ],
      'email' => [
        'label' => 'Email',
        'placeholder' => 'Введите свой e-mail'
      ],
      'confirm_email' => [
        'label' => 'Подтвердите e-mail',
        'placeholder' => 'Подтвердите свой e-mail'
      ],
      'phone' => [
        'label' => 'Телефон',
        'placeholder' => 'Введите номер телефона'
      ],
        'cel' => [
            'label' => 'Мобильный телефон',
            'placeholder' => 'Введите номер мобильного телефон'
        ],
      'pool' => [
          'empty_country' => 'Очистить поле Страна',
      ],
      'secret_question' => [
        'label' => 'Контрольный вопрос',
        'default' => 'Выберите контрольный вопрос',
        'emptydata' => 'Информация о контрольном вопросе не найдена',
      ],
      'secret_answer' => [
        'label' => 'Ответ',
        'placeholder' => 'Введите свой ответ'
      ],
      'parameters' => [
        'emptydata' => 'Параметры конфигурации не найдены',
      ],
      'kit' => [
        'placeholder' => 'Набор Дистрибьютора',
      ],
      'shipping' => [
        'placeholder' => 'Доставка',
      ],
      'payment' => [
        'placeholder' => 'платеж',
      ],
      'fields' => [
              'name'      => [
                  'label'         => 'Полное Имя',
                  'placeholder'   => 'Имя',
              ],
              'lastname'  => [
                  'placeholder'   => 'Фамилия',
              ],
              'lastname2' => [
                  'placeholder'   => 'Н/Д',
              ],
              'email'      => [
                  'placeholder'   => 'E-mail',
              ],
              'email2'      => [
                  'placeholder'   => 'E-mail',
              ],
              'invited'      => [
                  'placeholder'   => 'Приглашенный',
              ],
              'confirm-email'      => [
                  'placeholder'   => 'Подтвердить e-mail',
              ],
              'tel'      => [
                  'placeholder'   => 'Телефон',
              ],
              'cel' => [
                  'placeholder' => 'Мобильный телефон',
              ],
              'secret-question'      => [
                  'placeholder'   => 'Контрольный вопрос',
              ],
              'response-question'      => [
                  'placeholder'   => 'Ответ',
              ],
             'day' => [
                 'placeholder' => 'день',
             ],
             'month' => [
                 'placeholder' => 'месяц',
             ],
             'year' => [
                 'placeholder' => 'год',
             ],
            'zip' => [
                'placeholder' => 'Индекс',
             ],
             'terms1' => [
                 'placeholder' => 'Пользовательское Соглашение',
             ],
             'ext_num' => [
                 'placeholder' => 'exterior number'
             ],
             'terms2' => [
                 'placeholder' => 'Передача данных',
             ],
            'city' => [
                'placeholder' => 'город',
            ],
            'state' => [
                'placeholder' => 'регион/область',
            ],
            'street' => [
                'placeholder' => 'улица',
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
        'label' => 'Полное имя',
        'placeholders' => [
          'name' => 'Имя',
          'last_name' => 'Фамилия',
          'last_name2' => 'Фамилия',
          'sex' => 'Пол',
        ]
      ],
      'birth_date' => [
        'label' => 'Дата рождения',
        'defaults' => [
          'day' => 'день',
          'month' => 'месяц',
          'year' => 'месяц',
        ]
      ],
      'id' => [
        'label' => 'Удостоверение личности',
        'defaults' => [
          'type' => 'Вид удостоверения личности',
        ],
        'placeholders' => [
          'number' => 'Номер удостоверения личности',
        ]
      ],
      'address' => [
        'label' => 'Адрес',
        'placeholders' => [
          'street' => 'Улица',
          'ext_num' => 'Exterior number',
          'int_num' => 'Interior number',
          'colony' => 'County',
          'streets' => 'On the streets',
          'state' => 'Регион/область',
          'city' => 'Город',
          'zip' => 'Индекс',
           'choose_zip' => 'Выберите способ',
        ]
      ],
      'terms_contract' => [
        'text' => 'Я принимаю',
        'link' => 'Условия и положения договора.',
      ],
      'terms_payment' => [
        'text' => 'Я согласен',
        'link' => 'передавать моих данных в Мексику, операционный центр OMNILIFE.',
      ],
      'terms_information' => [
        'text' => 'Я принимаю',
        'link' => 'получать информацию о продуктах, услугах, акциях и/или событиях OMNILIFE через предоставленную мною контактную информацию.'
      ],
      'mandatory' => [
          'label' => 'Обязательное поле',
      ]
    ],

    'kit' => [
      'types' => 'Выберите Набор Дистрибьютора',
      'emptydata' => 'No kits available',
      'emptywarehouse' => 'Must send a warehouse',
      'shipping' => 'Выберите свой способ доставки',
      'shippingCompanies_empty' => 'Транспортные компании не найдены. Просим Вас обратиться с данной проблемой к нам или попробовать выбрать другой город',
      'payment' => 'Выберите способ доставки',
      'choose' => 'Выберите Набор Дистрибьютора',
      'sendby' => 'Отправить с',
      'bill' => [
        'subtotal' => 'Промежуточный Итог',
        'management' =>'Сервисный сбор',
        'taxes' => 'Налоги',
        'points' => 'Баллы',
        'total' => 'Итого',
        'resume' => 'Resume',
        'discount' => 'Скидка',
        'shipping_cost' => 'Доставка',
        'shopping_cart' => 'Shopping cart',
      ]
    ],

    'confirm' => [
      'email' => 'Проверьте свой e-mail, чтобы закончить создание аккаунта',
      'businessman_code' => 'Ваш Номер Дистрибьютора -',
      'thank_you' => 'Спасибо за покупку',
      'payment_successful' => 'Платеж прошел успешно',
      'no_data_in_tables' => 'No data found it on local tables'
    ],

    'modal' => [
      'header' => 'Платеж обрабатывается',
      'text_highlight' => 'Ты все ближе к своей финансовой свободе!',
      'text' => 'Не закрывайте и не обновляйте страницу'
    ],

    'terms' => [
        'title' => "Нажимая на 'Принять' вы соглашаетесь с условиями Пользовательского Соглашения",
        'cancel' => 'Отмена',
        'accept' => 'Принять',
        'download' => 'загрузить контрактную политику',
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
            'fistspurchase' => 'your first purchase today!',
            'unrecognized'  => '"If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to ',
            'mailprivacy'   => 'privacidad@omnilife.com',
            'subjectprivacy' => 'with subject line: Right to Oppose, your full name, country and telephone number, or call our {CREO} service lines".',
            'privacypolicies' => 'Privacy Policies',
            'dist_area' => 'Distributor area',
        ],

        'sponsor'           => [
            'title'         => 'В твоей структуре новый Привелегированный Клиент',
            'subject'       => 'Поздравляем! Привелегированный Клиент зарегистрировался в твою Структуру',
            'p1'            => 'Сообщаем тебе, что  <strong>:name_sponsor</strong>, теперь является частью твоей Структуры. Теперь, когда он/она находится на его/ее дороге к более здоровой и более красивейшей жизни, ',
            'p2'            => 'Информация о новом Клиенте',
            'text1'         => 'Очень важно помнить, что как Спонсор ты можешь',
            'text2'         => 'Работай со своими клиентами, чтобы двигаться вперед; и достигай своих целей!',
            'client_code'   => 'Номер Клиента',
            'name'          => 'Им',
            'telephone'     => 'Телефон',
            'email'         => 'E-mail',
            'li1'           => 'Ответ на контрольный вопрос',
            'li2'           => 'Рассказать о продукции OMNILIFE',
            'li3'           => 'Дать рекомендацию к использованию продуктов',
            'li4'           => 'Поддерживать во время совершения покупки',
        ],

        'prospect'  => [
            'title'     => 'A contact is about to end his registration!',
            'subject'   => 'Дистрибьютор не завершил регистрацию.',
            'h6'        => 'Дистрибьютор не завершил регистрацию.',
            'h3'        => 'Дистрибьютор не завершил регистрацию.',
            'p1'        => '<strong>:name</strong>, не упусти возможность расширить свой бизнес! ',
            'p2'        => [
                'text1' => 'Сообщаем тебе, что',
                'text2' => 'заинтересован в присоединении к твоей дистрибьюторской сети и не завершил регистрацию.',
            ],
            'p3'        => 'Свяжись с ним сейчас и увеличь свои шансы',
            'li'        => [
                1   => 'Имя',
                2   => 'Номер телефона',
                3   => 'Email',
            ],
            'p4'        => 'Помни, что за каждую покупку, совершенную твоим Дистрибьютором, ты получаешь больше баллов и двигаешься вперед к осуществлению своих целей в Независимом Бизнесе.',
            'p5'        => [
                'text1' => '"Если ты не согласен с этой операцией или не хочешь, чтобы твои персональные данные участвовали в обработке данных, отправь это письмо по адресу',
                'text2' => 'с темой: Возражение, твое полное имя, страна и номер телефона, или позвони в центр поддержки Дистрибьюторов – {CREO}".',
            ],
            'a1'   => 'Privacy Policy',
        ],
    ],

    'warehouse' => [
        'empty' => 'Empty warehouse, modify your shippping information',
    ],

    'next_button' => 'Продолжить',
    'prev_button' => 'Назад',
    'checkout_button' => 'Проверить',
    'errors' => 'Ошибки',
];
