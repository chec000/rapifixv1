<?php

return [
    'title' => 'Registro do Cliente',

    'months'        => [
        1   => 'Janeiro',
        2   => 'Fevereiro',
        3   => 'Março',
        4   => 'Abril',
        5   => 'Maio',
        6   => 'Junho',
        7   => 'Julho',
        8   => 'Agosto',
        9   => 'Setembro',
        10  => 'Outubro',
        11  => 'Novembro',
        12  => 'Dezembro',
    ],

    'error__box'    => 'Ocorreram um ou mais problemas',

    'error_rest'    => 'Foi detectada uma iconveniência, para mais informações contate o CREO.',

    'tabs' => [
        'account' => [
            'desktop'   => '1. Registro do Cliente',
            'mobile'    => 'Conta',
        ],

        'email' => [
            'desktop'   => '2. E-mail',
            'mobile'    => 'E-mail',
        ],

        'activation' => [
            'desktop'   => '3. Ativação',
            'mobile'    => 'Ativação',
        ],
    ],
    'account' => [
        'country' => [
            'label'     => 'País',
            'default'   => 'Selecione um país',
        ],

        'invited' => [
            'label' => [
                'desktop'   => 'Você foi convidado por um Empresário OMNILIFE',
                'mobile'    => 'Você foi convidado',
            ],

            'answer' => [
                'yes'   => 'Sim',
                'no'    => 'Não'
            ],
        ],

        'businessman_code' => [
            'label'         => 'Código do Empresário',
            'placeholder'   => 'Inserir código',
        ],

        'meet_us' => [
            'label'     => 'Como você nos conheceu?',
        ],

        'sex' => [
            'label'     => 'Sexo',
            'male'      => 'Masculino',
            'female'    => 'Feminino',
        ],

        'borndate' => [
            'label' => 'Data de nascimento',
            'day'   => 'Dia',
            'month' => 'Mês',
            'year'  => 'Ano',
            'alert' => 'O campo Data de Nascimento não corresponde a uma data válida',
        ],

        'full_name' => [
            'name'      => [
                'label'         => 'Nome Completo',
                'placeholder'   => 'Nome',
            ],

            'lastname'  => [
                'placeholder'   => 'Sobrenome Paterno',
            ],

            'lastname2' => [
                'placeholder'   => 'Sobrenome Materno',
            ],
        ],

        'identification' => [
            'label'         => 'Identidade',
            'option'        => 'Tipo de identidade',
            'placeholder'   => 'Número da Identidade',
        ],

        'expiration' => [
            'placeholder'   => 'Data de Validade',
        ],

        'address' => [
            'label'         => 'Address',
            'placeholders'  => [
                'zip'               => 'CEP',
                'ext_num'           => 'Número',
                'int_num'           => 'Complemento',
                'county'            => 'Bairro',
                'suburb'            => 'Bairro',
                'betweem_streets'   => 'Entre ruas',
                'state'             => 'Estado',
                'city'              => 'Cidade',
                'street'            => 'Rua',
                'shipping_company'  => 'Shipping Company',
            ],
        ],
    ],

    'mail_address' => [
        'mail' => [
            'label'         => 'E-mail',
            'placeholder'   => 'Inserir e-mail',
        ],

        'confirm_mail' => [
            'label'         => 'Confirmar e-mail',
            'placeholder'   => 'Inserir e-mail',
        ],

        'tel' => [
            'label'         => 'Telefone',
            'placeholder'   => 'Inserir telefone',
        ],

        'cel' => [
            'label'         => 'Celular',
            'placeholder'   => 'Inserir celular',
        ],

        'info_send'     => 'Verifique seu e-mail para continuar o processo de registro',
        'title'         => 'Suporte OMNILIFE',
        'subject'       => 'Solicitação para validar seu e-mail',
    ],

    'activation' => [
        'question'      => 'Pergunta Secreta',
        'answer'        => 'Resposta',
        'option'        => 'Selecione uma pergunta',
        'placeholder'   => 'Escreva sua resposta',
        'label'         => 'Registro completado com sucesso, seus dados são os seguintes',
        'code'          => 'Código do cliente',
        'password'      => 'Senha',
    ],

    'mail' => [
         'verify' => [
            'title'     => 'Verify your account',
            'subject'   => 'Verify your account',
            'h6'        => 'Verify your account',
            'h3'        => 'Oi, :name!',
            'p1'        => 'Para completar seu registro, por favor, verifique sua conta clique no seguinte botão',
            'p2'        => 'Esta é uma resposta automática da Omnilife. Por favor, não responda este e-mail.',
            'a1'        => 'CONFIRMAR MEU E-MAIL',
            'a2'        => 'Aviso de privacidade',
        ],

        'customer'      => [
            'title'     => 'Bem-vindo à OMNILIFE!',
            'subject'   => 'Bem-vindo',
            'h6'        => 'Bem-vindo',
            'h3'        => 'Bem-vindo à OMNILIFE!',
            'p5'        => 'Te informamos que seu registro como Cliente foi bem-sucedido. A partir de agora, você pode fazer suas compras e desfrutar dos benefícios de ser cliente OMNILIFE.',
            'p1'        => 'Esta é a informação de sua conta',
            'li'        => [
                1   => 'Código de Cliente',
                2   => 'Senha',
                3   => 'Pergunta Secreta',
                4   => 'Resposta da pergunta secreta',
            ],
            'p2'        => 'Te sugerimos não compartilhar seu código de cliente e senha, já que são dados privados e necessários para realizar suas compras no nosso site.',
            'p3'        => [
                'text1' => 'Te convidamos a visitar nosso site e realizar',
                'text2' => 'sua primeira compra agora!',
            ],
            'p4'        => [
                'text1' => '“Se você não reconhece essa operação ou quer se opor ao tratamento de seus Dados Pessoais, nos reenvie esse e-mail no endereço',
                'text2' => 'com o assunto Direito de Oposição, seu nome completo, país e número telefônico, ou comunique-se com nossas linhas de atenção {CREO}”.',
            ],
            'a1'        => 'Privacy Policies',
        ],

        'sponsor'   => [
            'title'     => 'New customer in your Distributor Network',
            'subject'   => 'New customer in your Distributor Network',
            'h6'        => 'New customer in your Distributor Network',
            'h3'        => 'Felicidades, :name!',
            'p1'        => [
                'text1' => 'Seu Negócio Independente conosco está crescendo,',
                'text2' => 'se registrou na sua rede como Cliente.',
            ],
            'p2'        => 'Mantenha-se em contato para alcançar mais facilmente sua meta mensal',
            'li'        => [
                1   => 'Código de Empresário',
                2   => 'Nome',
                3   => 'Telefone',
                4   => 'Email',
            ],
            'ul'        => 'Motive seu novo Cliente a manter-se ativo, já que por cada uma de suas compras você obterá mais pontos para ir além e alcançar suas metas.',
            'p3'        => [
                'text1' => '“Se você não reconhece essa operação ou quer se opor ao tratamento de seus Dados Pessoais, nos reenvie esse e-mail no endereço',
                'text2' => 'com o assunto Direito de Oposição, seu nome completo, país e número telefônico, ou comunique-se com nossas linhas de atenção {CREO}”.',
            ],
            'a1'        => 'Privacy Policies',
        ],

        'hello'             => 'Hello',
        'title'             => 'Email Confirmation',
        'text'              => 'To continue with the registration process, click on the next button. .',
        'confirm'           => 'Go to Email Confirmation',
        'regards'           => 'Best regards',
        'team'              => 'Team Omnilife',
        'privacy_policy'    => 'Privacy Policy',
    ],

    'fields' => [
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

    'btn' => [
        'back'          => 'Voltar',
        'continue'      => 'Avançar',
        'activate'      => 'Ativar',
        'resend_mail'   => 'Reenviar E-mail',
        'finish'        => [
            'shopping'  => 'Continuar comprando',
            'login'     => 'Login'
        ],
    ],

    'modal_exit' => [
        'title' => 'Registro incompleto',
        'body'  => 'Ao sair desta página sem concluir sua inscrição, você perderá as informações correspondentes, deseja continuar? ',
        'btn' => [
            'accept'    => 'Aceitar',
            'cancel'    => 'Cancelar',
        ],
    ]
];
