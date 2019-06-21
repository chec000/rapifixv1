<?php

return [
    'title' => 'Registro de Cliente',

    'months'        => [
        1   => 'Enero',
        2   => 'Febrero',
        3   => 'Marzo',
        4   => 'Abril',
        5   => 'Mayo',
        6   => 'Junio',
        7   => 'Julio',
        8   => 'Agosto',
        9   => 'Septiembre',
        10  => 'Octubre',
        11  => 'Noviembre',
        12  => 'Diciembre',
    ],

    'error__box'    => 'Se produjo uno o varios problemas',

    'error_rest'    => 'Se ha detectado un inconveniente, para m&aacute;s informaci&oacute;n comunícate a CREO.',

    'tabs' => [
        'account' => [
            'desktop'   => '1. Registro de Cliente',
            'mobile'    => 'Cuenta',
        ],

        'email' => [
            'desktop'   => '2. Correo Electr&oacute;nico',
            'mobile'    => 'Correo Electr&oacute;nico',
        ],

        'activation' => [
            'desktop'   => '3. Activaci&oacute;n',
            'mobile'    => 'Activaci&oacute;n',
        ]
    ],
    'account' => [
        'country' => [
            'label'     => 'Pa&iacute;s',
            'default'   => 'Selecciona un pa&iacute;s',
        ],

        'invited' => [
            'label' => [
                'desktop'   => 'Fuiste invitado por un Empresario Omnilife',
                'mobile'    => 'Fuiste invitado',
            ],

            'answer' => [
                'yes'   => 'Si',
                'no'    => 'No',
            ]
        ],

        'businessman_code' => [
            'label'         => 'C&oacute;digo de Empresario',
            'placeholder'   => 'Ingresar c&oacute;digo',
        ],

        'meet_us' => [
            'label'     => '¿C&oacute;mo nos conociste?',
        ],

        'sex' => [
            'label'     => 'Sexo',
            'male'      => 'Hombre',
            'female'    => 'Mujer',
        ],

        'borndate' => [
            'label' => 'Fecha de nacimiento',
            'day'   => 'D&iacute;a',
            'month' => 'Mes',
            'year'  => 'Año',
            'alert' => 'El campo Fecha de Nacimiento no corresponde con una fecha v&aacute;lida.',
        ],

        'full_name' => [
            'name'      => [
                'label'         => 'Nombre Completo',
                'placeholder'   => 'Nombre',
            ],

            'lastname'  => [
                'placeholder'   => 'Apellido Paterno',
            ],

            'lastname2' => [
                'placeholder'   => 'Apellido Materno',
            ],
        ],

        'identification' => [
            'label'         => 'Identificaci&oacute;n',
            'option'        => 'Tipo de identificaci&oacute;n',
            'placeholder'   => 'N&uacute;mero de Identificaci&oacute;n',
        ],

        'expiration' => [
            'placeholder'   => 'Fecha de Expiraci&oacute;n',
        ],

        'address' => [
            'label'         => 'Direcci&oacute;n',
            'placeholders'  => [
                'zip'               => 'C&oacute;digo Postal',
                'street'            => 'Direcci&oacute;n',
                'ext_num'           => 'N&uacute;mero Exterior',
                'int_num'           => 'N&uacute;mero Interior',
                'state'             => 'Estado',
                'city'              => 'Ciudad',
                'county'            => 'Condado',
                'suburb'            => 'Colonia',
                'betweem_streets'   => 'Entre Calles',
                'shipping_company'  => 'Compa&ntilde;ia de Env&iacute;o',
            ],
        ],
    ],

    'mail_address' => [
        'mail' => [
            'label'         => 'Correo',
            'placeholder'   => 'Ingresa correo',
        ],

        'confirm_mail' => [
            'label'         => 'Confirmar correo',
            'placeholder'   => 'Ingresa correo',
        ],

        'tel' => [
            'label'         => 'Tel&eacute;fono',
            'placeholder'   => 'Ingresa tel&eacute;fono',
        ],

        'cel' => [
            'label'         => 'Celular',
            'placeholder'   => 'Ingresa celular',
        ],

        'info_send'     => 'Revisa tu correo electr&oacute;nico para continuar el proceso de registro.',
        'title'         => 'Soporte Omnilife',
        'subject'       => 'Solicitud para validar tu correo electr&oacute;nico',
    ],

    'activation' => [
        'question'      => 'Pregunta Secreta',
        'answer'        => 'Respuesta',
        'option'        => 'Selecciona una pregunta',
        'placeholder'   => 'Escribe tu respuesta',
        'label'         => 'Registro completado con &eacute;xito, tus datos son los siguientes',
        'code'          => 'C&oacute;digo de cliente',
        'password'      => 'Contraseña',
    ],

    'mail' => [
        'verify' => [
            'title'     => 'Verificación de correo',
            'subject'   => 'Verifica tu cuenta',
            'h6'        => 'Verifica tu cuenta',
            'h3'        => '¡Hola, :name!',
            'p1'        => 'Para completar tu registro, por favor verifica tu cuenta dando clic al siguiente bot&oacute;n',
            'p2'        => 'Esta es una respuesta autom&aacute;tica de OMNILIFE. Por favor, no responda a este correo electr&oacute;nico.',
            'a1'        => 'CONFIRMAR MI CORREO ELECTR&Oacute;NICO',
            'a2'        => 'Pol&iacute;tica de Privacidad',
        ],

        'customer' => [
            'title'     => '¡Bienvenido a OMNILIFE!',
            'subject'   => 'Bienvenido',
            'h6'        => 'Bienvenido',
            'h3'        => '¡Bienvenido a OMNILIFE!',
            'p5'        => 'Te informamos que tu registro como Cliente ha sido exitoso. A partir de ahora, podrás realizar tus compras y disfrutar de los beneficios de ser cliente OMNILIFE.',
            'p1'        => 'Esta es la información de tu cuenta',
            'li'        => [
                1   => 'Código de Cliente',
                2   => 'Contraseña',
                3   => 'Pregunta Secreta',
                4   => 'Respuesta de pregunta secreta',
            ],
            'p2'        => 'Te sugerimos no compartir tu código de cliente y contraseña, ya que son datos privados y necesarios para realizar tus compras en nuestro sitio web.',
            'p3'        => [
                'text1' => '¡Te invitamos a visitar nuestro sitio y realizar',
                'text2' => '¡tu primera compra ahora!',
            ],
            'p4'    => [
                'text1' => '“Si no reconoces esta operación o quieres oponerte al tratamiento de tus Datos Personales, reenvíanos este correo a la dirección',
                'text2' => 'con el asunto Derecho de Oposición, tu nombre completo, país y número telefónico o comunícate a nuestras líneas de atención {CREO}”.',
            ],
            'a1'        => 'Pol&iacute;tica de Privacidad',
        ],

        'sponsor' => [
            'title'     => 'Nuevo Cliente en red de Empresario',
            'subject'   => 'Nuevo Cliente en red de Empresario',
            'h6'        => 'Nuevo Cliente en red de Empresario',
            'h3'        => '¡Felicidades, :name!',
            'p1'        => [
                'text1' => 'Tu Negocio Independiente con nosotros est&aacute; creciendo,',
                'text2' => 'se ha registrado a tu red como Cliente.',
            ],
            'p2'        => 'Mantente en contacto para alcanzar más f&aacute;cilmente tu meta mensual',
            'li'        => [
                1   => 'C&oacute;digo de Empresario',
                2   => 'Nombre',
                3   => 'Tel&eacute;fono',
                4   => 'Email',
            ],
            'ul'        => 'Motiva a tu nuevo Cliente a mantenerse activo, ya que por cada una de sus compras obtendr&aacute;s m&aacute;s puntos para ir m&aacute;s all&aacute; y alcanzar tus metas.',
            'p3'        => [
                'text1' => '“Si no reconoces esta operaci&oacute;n o quieres oponerte al tratamiento de tus Datos Personales, reenv&iacute;anos este correo a la direcci&oacute;n',
                'text2' => 'con el asunto Derecho de Oposici&oacute;n, tu nombre completo, pa&iacute;s y n&uacute;mero telef&oacute;nico o comun&iacute;cate a nuestras l&iacute;neas de atenci&oacute;n {CREO}”.',
            ],
            'a1'        => 'Pol&iacute;tica de Privacidad',
        ],

        'hello'             => 'Hola',
        'title'             => 'Confirmación de Correo Electrónico',
        'text'              => 'Para continuar con el proceso de registro, haz clic en el botón siguiente.',
        'confirm'           => 'Confirmar Correo Electrónico',
        'regards'           => 'Saludos cordiales',
        'team'              => 'Equipo Omnilife',
        'privacy_policy'    => 'Política de Privacidad',
    ],

    'fields' => [
        'required'      => 'El campo :attribute es obligatorio.',
        'in'            => 'El campo :attribute es inv&aacute;lido.',
        'not_in'        => 'El campo :attribute seleccionado es inv&aacute;lido.',
        'email'         => 'El campo :attribute debe ser una direcci&oacute;n de correo v&aacute;lida.',
        'numeric'       => 'El campo :attribute debe ser un n&uacute;mero.',
        'same'          => 'Los campos :attribute y :other deben coincidir.',
        'min'           => 'El campo :attribute debe contener al menos :min caracteres.',
        'max'           => 'El campo :attribute no debe contener más de :max caracteres.',
        'date'          => 'El campo :attribute no corresponde con una fecha v&aacute;lida.',
        'date_format'   => 'El campo :attribute no corresponde con el formato de fecha :format.',
        'unique'        => 'El valor del campo :attribute ya est&aacute; en uso.',
        'regex'         => 'El formato del campo :attribute es inválido.',
        'street_corbiz' => 'Direcci&oacute;n Incorrecta',
    ],

    'btn' => [
        'back'          => 'Regresar',
        'continue'      => 'Continuar',
        'activate'      => 'Activar',
        'resend_mail'   => 'Reenviar Correo',
        'finish'        => [
            'shopping'  => 'Continuar Comprando',
            'login'     => 'Iniciar Sesi&oacute;n'
        ],
    ],

    'modal_exit' => [
        'title' => 'Registro incompleto',
        'body'  => 'No has completado tu registro. Si abandonas esta p&aacute;gina se perder&aacute; tu informaci&oacute;n. ¿Deseas continuar?',
        'btn' => [
            'accept'    => 'Aceptar',
            'cancel'    => 'Cancelar',
        ],
    ],
];
