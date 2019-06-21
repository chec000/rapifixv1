<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'title' => 'Afiliación',
    
    'tabs' => [
      'account' => [
        'desktop' => '1.Registro',
        'mobile' => 'Cuenta'
      ],
      'info' => [
        'desktop' => '2. Información',
        'mobile' => 'Información'
      ],
      'kit' => [
        'desktop' => '3. Selecciona tu kit',
        'mobile' => 'Kit'
      ],
      'confirm' => [
        'desktop' => '4. Confirmar',
        'mobile' => 'Confirmar'
      ],
    ],

    'account' => [
      'invited' => [
        'label' => [
          'desktop' => '¿Fuiste invitado por un empresario OMNILIFE?',
          'mobile' => 'Fuiste invitado',
        ],
        'answer' => [
          'yes' => 'Si',
          'no' => 'No'
        ]
      ],
      'businessman_code' => [
        'label' => 'Código de Patrocinador',
        'label_sponsored' => 'Código de Patrocinador',
        'placeholder' => 'Introduce tu Código de Patrocinador'
      ],
      'meet_us' => [
        'label' => '¿Cómo nos conociste?',
        'default' => '¿Cómo nos conociste?',
      ],
      'country' => [
        'label' => 'País',
        'default' => 'Selecciona tu país',
        'empty_countries' => 'The country was not found.',
        'emptydata' => 'No se encontraron datos del país.',
        'emptypool' => 'No se encontraron datos de distribuidores.',
      ],
      'email' => [
        'label' => 'Correo',
        'placeholder' => 'Ingresa correo'
      ],
      'confirm_email' => [
        'label' => 'Confirmar correo',
        'placeholder' => 'Confirmar correo'
      ],
      'phone' => [
        'label' => 'Teléfono',
        'placeholder' => 'Ingresa teléfono'
      ],
      'cel' => [
        'label' => 'Celular',
        'placeholder' => 'Ingresa celular'
      ],
        'pool' => [
          'empty_country' => 'País vacío',
      ],
      'secret_question' => [
        'label' => 'Pregunta secreta',
        'default' => 'Selecciona una pregunta',
        'emptydata' => 'No se encontró información de la pregunta secreta.'
      ],
      'secret_answer' => [
        'label' => 'Respuesta',
        'placeholder' => 'Escribe tu respuesta'
      ],
      'parameters' => [
        'emptydata' => 'No se encontró configuración de parámetros',
      ],
      'kit' => [
        'placeholder' => 'Kit',
      ],
      'shipping' => [
        'placeholder' => 'Envío',
      ],
      'payment' => [
        'placeholder' => 'Pago',
      ],
      'fields' => [
              'name'      => [
                  'label'         => 'Nombre completo',
                  'placeholder'   => 'Nombre',
              ],
              'lastname'  => [
                  'placeholder'   => 'Apellido paterno',
              ],
              'lastname2' => [
                  'placeholder'   => 'Apellido materno',
              ],
              'email'      => [
                  'placeholder'   => 'Correo electrónico',
              ],
              'email2'      => [
                  'placeholder'   => 'Correo electrónico',
              ],
              'invited'      => [
                  'placeholder'   => 'Invitado',
              ],
              'confirm-email'      => [
                  'placeholder'   => 'Confirmar correo electrónico',
              ],
              'tel'      => [
                  'placeholder'   => 'Teléfono',
              ],
              'cel' => [
                  'placeholder' => 'Celular',
              ],
              'secret-question'      => [
                  'placeholder'   => 'Pregunta secreta',
              ],
              'response-question'      => [
                  'placeholder'   => 'Respuesta',
              ],
             'day' => [
                 'placeholder' => 'Día',
             ],
             'month' => [
                 'placeholder' => 'Mes',
             ],
             'year' => [
                 'placeholder' => 'Año',
             ],
            'zip' => [
                'placeholder' => 'Código postal',
             ],
             'terms1' => [
                 'placeholder' => 'Términos y Condiciones',
             ],
             'ext_num' => [
                 'placeholder' => 'Número exterior'
             ],
             'terms2' => [
                 'placeholder' => 'Transferir datos',
             ],
            'city' => [
                'placeholder' => 'Ciudad',
            ],
            'state' => [
                'placeholder' => 'Estado',
            ],
            'street' => [
                'placeholder' => 'Domicilio',
            ],

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
    ],

    'info' => [
      'full_name' => [
        'label' => 'Nombre completo',
        'placeholders' => [
          'name' => 'Nombre',
          'last_name' => 'Apellido paterno',
          'last_name2' => 'Apellido materno',
          'sex' => 'Sexo',
        ]
      ],
      'birth_date' => [
        'label' => 'Fecha de nacimiento',
        'defaults' => [
          'day' => 'dia',
          'month' => 'mes',
          'year' => 'año',
        ]
      ],
      'id' => [
        'label' => 'ID',
        'defaults' => [
          'type' => 'Tipo de identificación',
        ],
        'placeholders' => [
          'number' => 'Número de Identificación',
        ]
      ],
      'address' => [
        'label' => 'Dirección',
          'street_message' => 'Ingresa tu información, considera que el envío a PO BOX no está disponible.',
          'street_message_fail' => 'Dirección inválida. El envío a PO BOX no está disponible.',
          'placeholders' => [
          'street' => 'Dirección',
          'ext_num' => 'Número exterior',
          'int_num' => 'Número interior',
          'colony' => 'Colonia',
          'streets' => 'Entre calles',
          'state' => 'Estado',
          'city' => 'Ciudad',
          'zip' => 'Código Postal',
           'choose_zip' => 'Elige una opción',
        ]
      ],
      'terms_contract' => [
        'text' => 'Acepto',
        'link' => 'Terminos y condiciones del contrato',
      ],
      'terms_payment' => [
        'text' => 'Acepto',
        'link' => 'Terminos y condiciones de pago',
      ],
       'terms_information' => [
        'text' => 'Acepto',
        'link' => 'recibir información relacionada con productos, servicios, promociones y/o eventos OMNILIFE a la información de contacto que he compartido.'
      ],
      'mandatory' => [
          'label' => 'El campo es requerido',
      ]
    ],

    'kit' => [
      'types' => 'Selecciona tu kit',
      'emptydata' => 'No hay kits disponibles',
      'emptywarehouse' => 'Almacen no enviado',
      'shipping' => 'Selecciona tu método de envío',
      'shippingCompanies_empty' => 'No se encontraron compañías de envío bajo el estado y ciudad señalados, por favor reporta el problema e intenta con una ciudad y estado diferentes.',
      'payment' => 'Selecciona tu método de pago',
        'choose' => 'Choose a kit',
      'sendby' => 'Send By ',
      'bill' => [
        'subtotal' => 'Subtotal',
        'management' => 'Administración',
        'taxes' => 'Impuestos',
        'points' => 'Pts',
        'total' => 'Total',
          'resume' => 'Resumen',
        'discount' => 'Descuento',
        'shipping_cost' => 'Envío',
          'shopping_cart' => 'Carrito de compras'
      ]
    ],

    'confirm' => [
      'email' => 'Revisa tu correo electrónico para finalizar la creación de la cuenta.',
       'businessman_code' => 'Tú código de Empresario es',
      'thank_you' => 'Gracias por tu compra.',
      'payment_successful' => 'Pago exitoso',
      'no_data_in_tables' => 'No existen datos'
    ],

    'modal' => [
      'header' => 'Procesando pago',
      'text_highlight' => '¡Estás cerca de tu libertad financiera!',
      'text' => 'No cerrar o refrescar esta ventana'
    ],

    'terms' => [
        'title' => "Al dar clic en Aceptar confirma que está de acuerdo con nuestros Términos y condiciones.",
        'cancel' => 'Cancelar',
        'accept' => 'Aceptar',
        'download' => 'descargar políticas de contrato',
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
            'title'         => 'Bienvenido a Omnilife',
            'subject'       => '¡Bienvenido(a) a OMNILIFE! a esta gran familia de Emprendedores, en la que cada quien fija sus propios objetivos.',
            'h6'            => '¡Bienvenido!',
            'p1'            => 'Gracias<strong> :name</strong> por completar tu registro, estás en camino para una vida más saludable y feliz disfrutando los productos Omnilife',
            'h4'            => 'Te informamos que tu registro como Empresario ha sido exitoso, esta es la información de tu cuenta: ',
            'p2'            => 'Save your Client Code and Password, which will be necessary to make your purchases.',
            'p3'            => 'This is your account information',
            'client_code'   => 'Código de empresario:',
            'password'      => 'Contraseña:',
            'question'      => 'Pregunta secreta:',
            'answer'        => 'Respuesta de pregunta secreta:',
            'recommend'      => 'Te sugerimos no compartir tu código de Empresario y contraseña, ya que son datos privados y necesarios para realizar tus compras y operaciones como Empresario OMNILIFE.',
            'recommend2'    => 'Estamos listos para ayudarte a Emprender y apoyarte a crecer hasta donde tu quieras. Te recomendamos tener los siguientes puntos en mente ahora que empiezas tu negocio independiente.',
            'list1'         => 'Usa y comparte un día sí y el otro también.',
            'list2'         => 'Busca resultados y el dinero llegará por consecuencia.',
            'list3'         => 'Persigue tus sueños.',
            'list4'         => 'Mantén en mente que las crisis traen nuevas oportunidades.',
            'list5'         => 'Invierte en tu propio negocio independiente.',
            'visitplatform' => 'No olvides iniciar cuanto antes tu capacitación presencial o en línea a través de la plataforma de aprendizaje en',
            'linkplatform'  => 'Zona de empresarios',
            'visitweb'      => '¡Visita nuestro sitio y realiza',
            'firstpurchase' => '¡tu primer compra ahora!',
            'unrecognized'  => '“Si no reconoces esta operación o quieres oponerte al tratamiento de tus Datos Personales, reenvíanos este correo a la dirección ',
            'mailprivacy'   => 'privacidad@omnilife.com',
            'subjectprivacy' => 'con el asunto Derecho de Oposición, tu nombre completo, país y número telefónico o comunícate a nuestras líneas de atención {CREO}”.',
            'privacypolicies' => 'Póliticas de privacidad',
            'dist_area'    =>       'Zona de empresarios',
        ],

        'sponsor'           => [
            'title'         => 'Nuevo Empresario en Red de eO',
            'subject'       => '¡Felicidades!, :name_sponsor',
            'p1'            => '¡Tu Negocio Independiente con nosotros está creciendo ! <strong>:name_customer </strong> se ha registrado a tu red como Empresario/a.',
            'p2'            => 'Mantente en contacto para alcanzar más fácilmente tu meta mensual .',
            'text1'         => 'It is very important to remember that as a presenter, you can',
            'text2'         => 'Motiva a este nuevo Empresario/a a mantenerse activo, ya que por cada una de sus compras obtendrás más puntos para ir más allá y alcanzar tus metas.',
            'client_code'   => 'Código de empresario',
            'name'          => 'Nombre',
            'telephone'     => 'Teléfono',
            'email'         => 'Email',
            'li1'           => 'Responde las dudas del empresario',
            'li2'           => 'Promueve la compra de productos omnilife',
            'li3'           => 'Recomienda el uso de los produtos',
            'li4'           => 'Apoyalos en el proceso de compra',
        ],

        'prospect'  => [
            'title'     => '¡Un contacto está por terminar su registro!',
            'subject'   => 'Empresario no terminó su registro',
            'h6'        => 'Empresario no terminó su registro',
            'h3'        => 'Empresario no terminó su registro',
            'p1'        => '<strong>:name</strong>, ¡no pierdas la oportunidad de crecer tu negocio con nosotros! ',
            'p2'        => [
                'text1' => 'Te informamos que',
                'text2' => 'está interesado/a en unirse a tu red como Empresario y no logró completar su registro.',
            ],
            'p3'        => 'Contáctala ahora y aumenta la posibilidad de llegar más fácilmente tu meta mensual',
            'li'        => [
                1   => 'Nombre',
                2   => 'Teléfono',
                3   => 'Email',
            ],
            'p4'        => 'Recuerda que por cada una de sus compras, obtendrás más puntos para ir más allá y alcanzar las metas de tu Negocio Independiente.',
            'p5'        => [
                'text1' => '“Si no reconoces esta operación o quieres oponerte al tratamiento de tus Datos Personales, reenvíanos este correo a la dirección',
                'text2' => 'con el asunto Derecho de Oposición, tu nombre completo, país y número telefónico o comunícate a nuestras líneas de atención {CREO}”.',
            ],
            'a1'        => 'Politica de Privacidad',
        ],
    ],

    'warehouse' => [
        'empty' => 'Almacen vacio, modifica tu información de envio',
    ],

    'next_button' => 'Continuar',
    'prev_button' => 'Regresar',
    'checkout_button' => 'Proceder a pago',
    'errors' => 'Errores',
];
