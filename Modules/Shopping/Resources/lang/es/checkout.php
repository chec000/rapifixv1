<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'checkout'              => 'Dirección de Envío',
    'title'                 => 'OMNILIFE - Proceso de Compra',
    'keep_buying'           => 'Seguir comprando',
    'return'                => 'Regresar',
    'continue_payment'      => 'Continuar a pago',
    'finish_purchase'       => 'Finalizar Compra',

    'payment' => [
        'select_payment' => 'Selecciona una forma de pago',
        'resume_payment' => 'Resumen de compra',
        'no_items'       => 'No hay artículos',
        'handling'       => 'Manejo',
        'taxes'          => 'Impuestos',
        'attention'      => 'Atención',
        'total'          => 'Total',
        'discount'       => 'Descuento',
        'points'         => 'Puntos',
        'shopping_cart'  => 'Carrito de compras',

        'card_pplus'     => 'Tarjeta de crédito/débito',
        'pay_pplus'      => 'Pagar con Paypal Plus',

        'errors' => [
            # Generales
            'cancel_paypal' => 'La transacción ha sido cancelada. Procede al pago nuevamente dando clic en el botón de pago',
            'default' => 'Se produjo uno o varios problemas',
            'address' => 'Ha ocurrido un error al verificar sus productos, por favor verifique que su dirección este completa',
            'general' => '¡Lo sentimos! Algo salió mal. Por favor vuelve a cargar la página. Si el problema persiste, no dudes en contactarnos.',

            # Programación
            'sys001' => 'Err: SYS001 Ha ocurrido un problema, por favor contacte al servicio de soporte técnico',
            'sys002' => 'Err: SYS002 Ha ocurrido un problema, por favor contacte al servicio de soporte técnico',
            'sys003' => 'Err: SYS003 Ha ocurrido un problema, por favor contacte al servicio de soporte técnico',
            'sys004' => 'Err: SYS004 Ha ocurrido un problema, por favor contacte al servicio de soporte técnico',
            'sys005' => 'Err: SYS005 Ocurrió un problema con tu dirección de envío. Regresa al paso anterior y selecciona nuevamente; si el error persiste intenta seleccionar otro domicilio.',
            'sys006' => 'Err: SYS006 Ha ocurrido un problema, por favor contacte al servicio de soporte técnico',
            # Paypal
            'sys101' => 'Err: SYS101 Ha ocurrido un problema al procesar tu pago, por favor intenta nuevamente.',
            'sys102' => 'Err: SYS102 Ha ocurrido un problema al procesar tu pago, por favor intenta nuevamente.',
            'sys103' => 'Err: SYS103 Ha ocurrido un problema al procesar tu pago, por favor intenta nuevamente.',
            # Paypal Plus
            'sys104' => 'Err: SYS104 Ha ocurrido un problema al procesar tu pago, por favor intenta nuevamente.',
            'sys105' => 'Err: SYS105 Ha ocurrido un problema al procesar tu pago, por favor intenta nuevamente.',
            'sys106' => 'Err: SYS106 Ha ocurrido un problema al procesar tu pago, por favor intenta nuevamente.',

            'payment_rejected'               => 'Su pago ha sido rechazado, intente nuevamente o use otro método de pago',
            'instrument_declined'            => 'El procesador o el banco rechazaron el método de pago o no se puede usar para este pago. Inténtalo de nuevo',
            'bank_account_validation_failed' => 'La validación de la cuenta bancaria falló. Inténtalo de nuevo',
            'credit_card_cvv_check_failed'   => 'La verificación de la tarjeta de crédito falló. Verifica tu información y vuelve a intentarlo',
            'credit_card_refused'            => 'Tarjeta de crédito fue rechazada. Inténtalo de nuevo con otra tarjeta de crédito',
            'credit_payment_not_allowed'     => 'No se puede usar el crédito para completar el pago. Por favor, selecciona otro método de pago y vuelve a intentarlo',
            'insufficient_funds'             => 'Fondos insuficientes. Por favor, selecciona otro método de pago y vuelve a intentarlo',
            'payment_denied'                 => 'Pago denegado Por favor, selecciona otro método de pago y vuelve a intentarlo',
            'internal_service_error'         => 'Ha ocurrido un problema, espere un momento y vuelva a intentarlo',
            'payment_expired'                => 'El pago ha expirado. Inténtalo de nuevo',
            'payment_already_done'           => 'El pago ya se ha realizado para esta compra',
            'duplicate_transaction'          => 'El número de transacción del banco esta duplicado',
            'default_paypal'                 => 'Ha ocurrido un problema al validar su pago, por favor contacte al equipo de soporte.'
        ],

        'modal' => [
            'loader' => [
                'title' => 'Procesando tu pago',
                'p1'    => 'Estás un paso más cerca de tu libertad financiera.',
                'p2'    => 'No cerrar o refrescar esta ventana hasta recibir tu confirmación de pago.'
            ]
        ],
    ],

    'confirmation' => [
        'success' => [
            'thank_you'       => 'Gracias por comprar con nosotros',
            'success_pay'     => 'Pago exitoso',
            'order_number'    => 'Número de pedido',
            'corbiz_order'    => 'Número de confirmación',
            'corbiz_number'   => 'Número de confirmación',
            'order_arrive_in' => 'Tu pedido llegará en',
            'business_days'   => 'días hábiles',
            'pay_with_card'   => 'Pago con tarjeta',
            'pay_with_paypal' => 'Pago con Paypal',
            'pay_with_paypal_plus' => 'Pago con Paypal Plus',
            'pay_auth'        => 'Autorización del pago',
            'total'           => 'Total de compra',
            'send_to'         => 'Enviado a',
            'product_name'    => 'Nombre del producto',
            'points'          => 'pts',
            'Eonumber'        => 'Numero de empresario',
            'password'        => 'Contraseña',
            'secretquestion'  => 'Pregunta de seguridad',
            'message_inscription' => 'Ahora puedes comprar en línea y disfrutar los beneficios de ser parte de'
        ],

        'pending' => [
            'info'    => 'Tu pago está siendo validado. <br> Una vez que tu pago sea aprobado, recibirás un correo electrónico con la información de tu orden.',
            'pending' => 'Pago pendiente',
        ],

        'no_order' => [
            'info' => 'Tu pago ha sido procesado pero ocurrió un problema al generar tu orden. <br> Te contactaremos en breve vía correo electrónico con la confirmación.'
        ],

        'error' => [
            'info' => 'Tu pago ha sido procesado pero ocurrió un problema al generar tu orden. <br> Te contactaremos en breve vía correo electrónico con la confirmación.'
        ],

    'emails' => [
            'confirmation_title' => 'El pago de su pedido ha sido exitoso',
            'order_success'      => 'Confirmación de orden'
        ]
    ],

    'email' => [
        'entepreneur' => 'Omnilife Entepreneur,',

        'confirmation' => [
            'title'   => 'Shopping Omnilife | Su pago fue exitoso',
            'title_2' => 'Confirmación de pago',
            'p_hi'    => '¡Hola {name}!',
            'p_1'     => 'Te confirmamos que el pago de tu pedido ha sido exitoso.',
            'p_2'     => 'Tu orden será enviada al domicilio indicado.',
            'p_3'     => '<small>*Los días de envío son determinados dependiendo del método de envío elegido.</small>',
            'p_4'     => 'Información del pedido:',
            'p_5'     => 'Número de pedido: {order}',
            'p_6'     => 'Nombre: {name}',
            'p_7'     => 'Domicilio: {address}',
            'p_8'     => '<small>“Si no reconoces esta operación o quieres oponerte al tratamiento de tus Datos Personales, reenvíanos este correo a la dirección <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a> con el asunto Derecho de Oposición, tu nombre completo, país y número telefónico o comunícate a nuestras líneas de atención <strong>{CREO}</strong>”.</small>',
            'p_9'     => 'Política de Privacidad',
        ],

     'success_order' => [
            'title'   => 'Shopping Omnilife | Su pago fue exitoso',
            'title_2' => 'Confirmación de pedido',
            'title_3' => 'Nuevo empresario a tu red',
            'p_hi'    => '¡Hola {name}!',
            'p_1'     => '¡Gracias por comprar con nosotros! El pago de tu orden ha sido exitoso.',
            'p_2'     => 'Tu orden será enviada al domicilio indicado.',
            'p_3'     => '<small>*Los días de envío son determinados dependiendo del método de envío elegido.</small>',
            'p_4'     => 'Información del pedido:',
            'p_5'     => 'Número de pedido: {order}',
            'p_6'     => 'Nombre: {name}',
            'p_7'     => 'Domicilio: {address}',
            'p_8'     => 'Al recibir tu mercancía, te sugerimos comprobar el embalaje.',
            'p_9'     => '<small>“Si no reconoces esta operación o quieres oponerte al tratamiento de tus Datos Personales, reenvíanos este correo a la dirección <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a> con el asunto Derecho de Oposición, tu nombre completo, país y número telefónico o comunícate a nuestras líneas de atención <strong>{CREO}</strong>”.</small>',
            'p_10'    => 'Política de Privacidad',
            'p_11'    => 'Este es el detalle de tu pedido:',
            'p_12'    => 'Resumen de compra',
        ]
    ],

    'quotation' => [
        'resume_cart' => [
            'remove_all' => 'Eliminar todos',
            'code' => 'Código',
            'pts' => 'pts',
            'subtotal' => 'Subtotal',
            'handling' => 'Manejo',
            'taxes' => 'Impuestos',
            'points' => 'Puntos',
            'total' => 'Total',
            'no_items' => 'No se han agregado productos al carrito',
            'delete_items' => 'No es posible enviar algunos productos seleccionados, por lo tanto se han eliminado de la cesta.',
            'purchase_summary' => 'Resumen de compra',
            'discount' => 'Descuento',
        ],
        'change_period' => '¿Cambiar a periodo anterior?',
        'change_period_yes' => 'Si',
        'change_period_no' => 'No',
        'change_period_success_msg' => 'Cambio de periodo exitoso',
        'change_period_fail_msg' => 'Cambio de periodo fallo, intente mas tarde',
    ],

    'promotions' => [
        'title_modal' => 'Promociones',
        'msg_select_promotions' => 'Tus compras te han generado las siguientes promociones',
        'msg_promo_required' => '(Obligatorio)',
        'label_quantity' => 'Cantidad',

        'btn_select' => 'Seleccionar',
        'btn_accept' => 'Aceptar',

        'msg_promo_obliga' => 'Para continuar, elige un producto de la promocion: :name_promo',
        'msg_promo_qty' => 'Sólo puedes elegir :qty_promo producto(s) de la promoción: :name_promo',

        'msg_promo_A' => 'Agrega a tu carrito uno de los siguientes paquetes. Sólo puedes elegir un máximo de :qty del paquete seleccionado.',
        'msg_promo_B' => 'Agrega a tu carrito uno de los siguientes paquetes. Sólo puedes elegir un máximo de :qty del paquete seleccionado.',
        'msg_promo_C' => '{1} Agrega a tu carrito hasta :qty productos de la promoción de tu elección. | [2,*] Agrega a tu carrito hasta :qty productos de la promoción de tu elección, si la cantidad lo permite, pueden ser 1 o más de cada producto.',
    ]
];
