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
        'desktop' => '1. Criar conta',
        'mobile' => 'Conta'
      ],
      'info' => [
        'desktop' => '2. Informações',
        'mobile' => 'Info'
      ],
      'kit' => [
        'desktop' => '3. Selecione seu kit',
        'mobile' => 'Kit'
      ],
      'confirm' => [
        'desktop' => '4. Confirmar',
        'mobile' => 'Confirmar E-Mail'
      ],
    ],

    'account' => [
      'invited' => [
        'label' => [
          'desktop' => 'Distribuidor OMNILIFE?',
          'mobile' => 'Você foi convidado?',
        ],
        'answer' => [
          'yes' => 'Sim',
          'no' => 'Não'
        ]
      ],
      'businessman_code' => [
        'label' => 'Código de Empresário',
        'label_sponsored' => 'Sponsor Code',
        'placeholder' => 'Como você nos conheceu?'
      ],
      'meet_us' => [
        'label' => 'Como você nos conheceu?',
        'default' => 'Como você nos conheceu?',
      ],
      'country' => [
        'label' => 'País',
        'default' => 'Selecione seu país',
        'empty_countries' => 'Nenhum país encontrado.',
        'emptydata' => 'Nenuma informação do país encontrada.',
        'emptypool' => 'Nenhuma informação do Empresário encontrada.',
      ],
      'email' => [
        'label' => 'Email',
        'placeholder' => 'Insira seu e-mail'
      ],
      'confirm_email' => [
        'label' => 'Confirme seu e-mail',
        'placeholder' => 'Confirme seu e-mail'
      ],
      'phone' => [
        'label' => 'Telefone',
        'placeholder' => 'Insira seu telefone'
      ],
        'cel' => [
            'label' => 'Celular ',
            'placeholder' => 'Insira seu celular'
        ],
      'pool' => [
          'empty_country' => 'Limpar o país',
      ],
      'secret_question' => [
        'label' => 'Pergunta Secreta',
        'default' => 'Selecione uma pergunta secreta',
        'emptydata' => 'Não encontramos informações sobre a pergunta secreta.',
      ],
      'secret_answer' => [
        'label' => 'Resposta',
        'placeholder' => 'Escreva sua resposta'
      ],
      'parameters' => [
        'emptydata' => 'Nenhum parâmetro de configuração encontrado.',
      ],
      'kit' => [
        'placeholder' => 'Kit',
      ],
      'shipping' => [
        'placeholder' => 'Entrega',
      ],
      'payment' => [
        'placeholder' => 'Pagamento',
      ],
      'fields' => [
              'name'      => [
                  'label'         => 'Nome completo',
                  'placeholder'   => 'Nome',
              ],
              'lastname'  => [
                  'placeholder'   => 'Sobrenome',
              ],
              'lastname2' => [
                  'placeholder'   => 'Sobrenome materno',
              ],
              'email'      => [
                  'placeholder'   => 'Email',
              ],
              'email2'      => [
                  'placeholder'   => 'Email',
              ],
              'invited'      => [
                  'placeholder'   => 'Convidado',
              ],
              'confirm-email'      => [
                  'placeholder'   => 'Confirmar e-mail',
              ],
              'tel'      => [
                  'placeholder'   => 'Telefone',
              ],
              'cel' => [
                  'placeholder' => 'Celular',
              ],
              'secret-question'      => [
                  'placeholder'   => 'Pergunta secreta',
              ],
              'response-question'      => [
                  'placeholder'   => 'Resposta',
              ],
             'day' => [
                 'placeholder' => 'Dia',
             ],
             'month' => [
                 'placeholder' => 'Mês',
             ],
             'year' => [
                 'placeholder' => 'Ano',
             ],
            'zip' => [
                'placeholder' => 'Código Postal',
             ],
             'terms1' => [
                 'placeholder' => 'Termos e condições',
             ],
             'ext_num' => [
                 'placeholder' => 'Número Externo'
             ],
             'terms2' => [
                 'placeholder' => 'Transferir dados',
             ],
            'city' => [
                'placeholder' => 'Cidade',
            ],
            'state' => [
                'placeholder' => 'Estado',
            ],
            'street' => [
                'placeholder' => 'Rua',
            ],

          'required'      => 'O campo  :attribute é obrigatório',
          'in'            => 'O campo :attribute   é inválido',
          'not_in'        => 'O campo :attribute  selecionado é inválido.',
          'email'         => 'O campo :attribute  deve ser um endereço de e-mail válido.',
          'numeric'       => 'O campo :attribute  deve ser um número.',
          'same'          => 'The :attribute and :other must match.',
          'min'           => 'O ca :attribute must be at least :min characters.',
          'max'           => 'O campo :attribute não deve conter mais de  :min caracteres',
          'date'          => 'O campo :attribute  não corresponde a uma data válida.',
          'date_format'   => 'O campo :attribute não corresponde ao formato de data :format.',
          'unique'        => 'O valor do campo :attribute   já está em uso',
          'regex'         => 'The :attribute format is invalid.',
          'street_corbiz' => 'Wrong Address',
        ],
    ],

    'info' => [
      'full_name' => [
        'label' => 'Nome completo',
        'placeholders' => [
          'name' => 'Nome',
          'last_name' => 'Sobrenome',
          'last_name2' => 'Sobrenome',
          'sex' => 'Sexo',
        ]
      ],
      'birth_date' => [
        'label' => 'Data de nascimento',
        'defaults' => [
          'day' => 'Dia',
          'month' => 'Mês',
          'year' => 'Ano',
        ]
      ],
      'id' => [
        'label' => 'Identidade',
        'defaults' => [
          'type' => 'Tipo de identidade',
        ],
        'placeholders' => [
          'number' => 'Número de identidade',
        ]
      ],
      'address' => [
        'label' => 'Endereço',
        'placeholders' => [
          'street' => 'Rua',
          'ext_num' => 'Número',
          'int_num' => 'Complemento',
          'colony' => 'County',
          'streets' => 'On the streets',
          'state' => 'Estado',
          'city' => 'Cidade',
          'zip' => 'Código postal (CEP)',
           'choose_zip' => 'Escolha uma opção',
        ]
      ],
      'terms_contract' => [
        'text' => 'Eu aceito',
        'link' => 'Termos e condições de contrato',
      ],
      'terms_payment' => [
        'text' => 'Eu aceito',
        'link' => 'o uso de minhas informações pessoais no México, Centro de Operações da OMNILIFE.',
      ],
      'terms_information' => [
        'text' => 'Eu aceito',
        'link' => 'receber informações relacionadas a produtos, serviços, promoções e/ou eventos da OMNILIFE através das informações de contato que compartilhei..'
      ],
      'mandatory' => [
          'label' => 'Este campo é obrigatório.',
      ]
    ],

    'kit' => [
      'types' => 'Selecione seu kit',
      'emptydata' => 'No hay kits disponibles',
      'emptywarehouse' => 'Almacen no enviado',
      'shipping' => 'Escolha sua forma de envio',
      'shippingCompanies_empty' => 'Não foram encontradas transportadoras no estado e cidade assinalados, por favor informe o problema e tente com uma cidade e estado diferentes.',
      'payment' => 'Selecione sua forma de pagamento',
      'choose' => 'Escolha um kit',
      'sendby' => 'Enviar por',
      'bill' => [
        'subtotal' => 'Subtotal',
        'management' => 'Manuseio',
        'taxes' => 'Impostos',
        'points' => 'Pontos',
        'total' => 'Total',
        'resume' => 'Resumo',
        'discount' => 'Desconto',
        'shipping_cost' => 'Envio',
        'shopping_cart' => 'Shopping cart',
      ]
    ],

    'confirm' => [
      'email' =>'Revise seu e-mail para finalizar a criação da conta.' ,
      'businessman_code' => 'Seu código de Empresário é',
      'thank_you' => 'Obrigado por sua compra.',
      'payment_successful' => 'Pagamento realizado com sucesso',
      'no_data_in_tables' => 'No data found it on local tables'
    ],

    'modal' => [
      'header' => 'Processando pagamento',
      'text_highlight' => 'Você está perto de sua liberdade financeira!',
      'text' => 'Não fechar ou atualizar esta janela'
    ],

    'terms' => [
        'title' => "Ao clicar em Aceito, você está aceitando nossos Termos e Condições.",
        'cancel' => 'Cancelar',
        'accept' => 'Aceitar',
        'download' => 'baixar políticas de contrato',
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
            'subject'       => 'Congratulations! You are now an Entepreneur Omnilife.',
            'h6'            => 'Welcome',
            'p1'            => 'Thank you<strong> :name</strong> By having completed your registration, you are on the road to a healthier and more beautiful life enjoying Omnilife products',
            'h4'            => 'Your life is about to change!',
            'p2'            => 'Save your Client Code and Password, which will be necessary to make your purchases.',
            'p3'            => 'This is your account information',
            'client_code'   => 'Client Code',
            'password'      => 'Password',
            'question'      => 'Secret Question',
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
            'firstpurchase' => 'your first purchase today!',
            'unrecognized'  => '"If you don\'t recognize this operation or would like to oppose to the handling of your Personal Data, forward this email to ',
            'mailprivacy'   => 'privacidad@omnilife.com',
            'subjectprivacy' => 'with subject line: Right to Oppose, your full name, country and telephone number, or call our {CREO} service lines".',
            'privacypolicies' => 'Privacy Policies',
            'dist_area' => 'Distributor area',
        ],

         'sponsor'           => [
            'title'         => 'Novo Cliente Admirável em sua rede',
            'subject'       => '¡Felicidades!, :name_sponsor',
            'p1'            => '<strong>:name_sponsor</strong>, Gostaríamos de lhe informar que <strong>:name_customer </strong> agora faz parte de sua rede. Agora que ele/ela está no caminho para uma vida mais saudável e mais bonita, aproveitando os produtos nutricionais da Omnilife, você receberá pontos pelas compras que realize para poder alcançar sua meta mensal com mais facilidade',
            'p2'            => 'Informações do Novo Cliente',
            'text1'         => 'É muito importante lembrar que, como apresentador, você pode',
            'text2'         => 'Trabalhe com seus clientes, para ir mais além; e alcançar seus objetivos!',
            'client_code'   => 'Código do Cliente',
            'name'          => 'Name',
            'telephone'     => 'Nome',
            'email'         => 'Email',
            'li1'           => 'Responda as dúvidas do cliente',
            'li2'           => 'Promover a compra de produtos Omnilife',
            'li3'           => 'Recomende o uso de produtos',
            'li4'           => 'Dê suporte no processo de compra',
        ],

        'prospect'  => [
            'title'     => 'A contact is about to end his registration!',
            'subject'   => 'Empresário não terminou seu registro',
            'h6'        => 'Empresário não terminou seu registro',
            'h3'        => 'Empresário não terminou seu registro',
            'p1'        => '<strong>:name</strong>, não perca a oportunidade de fazer seu negócio crescer conosco!',
            'p2'        => [
                'text1' => 'Te informamos que',
                'text2' => 'está interessada em unir-se à sua rede como Empresário e não conseguiu completar o seu registro.',
            ],
            'p3'        => 'Entre em contato com ela agora e aumente a possibilidade de alcançar mais facilmente sua meta mensal',
            'li'        => [
                1   => 'Nome',
                2   => 'Telefone',
                3   => 'Email',
            ],
            'p4'        => 'Lembre-se que, para cada uma de suas compras, você obterá mais pontos para ir mais longe e alcançar as metas do seu Negócio Independente.',
            'p5'        => [
                'text1' => '“Se você não reconhece essa operação ou quer se opor ao tratamento de seus Dados Pessoais, nos reenvie esse e-mail no endereço ',
                'text2' => 'com o assunto Direito de Oposição, seu nome completo, país e número telefônico, ou comunique-se com nossas linhas de atenção {CREO}”.',
            ],
            'a1'        => 'Privacy Policy',
        ],
    ],

    'warehouse' => [
        'empty' => 'Empty warehouse, modify your shippping information',
    ],

    'next_button' => 'Continuar',
    'prev_button' => 'Voltar',
    'checkout_button' => 'Checkout',
    'errors' => 'Erros',
];
