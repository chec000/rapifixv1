<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'checkout'              => 'Pagar',
    'title'                 => 'Seguir comprando',
    'keep_buying'           => 'Keep buying',
    'return'                => 'Voltar',
    'continue_payment'      => 'Continuar para o pagamento',
    'finish_purchase'       => 'Finalizar Compra',

    'payment' => [
        'select_payment' => 'Selecionar uma forma de pagamento',
        'resume_payment' => 'Resumo da compra',
        'no_items'       => 'Não há artigos',
        'handling'       => 'Tratamento',
        'taxes'          => 'Impostos',
        'attention'      => 'Atenção',
        'total'          => 'Total',
        'discount'       => 'Discount',
        'points'         => 'Pontos',
        'shopping_cart'  => 'Carrinho de compras',

        'card_pplus'     => 'Credit/debit card',
        'pay_pplus'      => 'Pay with Paypal Plus',

        'errors' => [
            # Generales
            'cancel_paypal' => 'Ação de pagamento cancelada. Você pode reiniciar seu processo de pagamento clicando no botão PayPal.',
            'default' => 'Um ou vários problemas ocorreram.',
            'address' => 'Ocorreu um erro ao verificar seus produtos, verifique se seu endereço está completo',
            'general' => 'We´re sorry, but something went wrong. Please try again. If the problem persists, contact us.',

            # Programación
            'sys001' => 'Err: SYS001 Ocorreu um problema, por favor entre em contato com o serviço de suporte técnico. ',
            'sys002' => 'Err: SYS002 Ocorreu um problema, por favor entre em contato com o serviço de suporte técnico. ',
            'sys003' => 'Err: SYS003 Ocorreu um problema, por favor entre em contato com o serviço de suporte técnico. ',
            'sys004' => 'Err: SYS004 Ocorreu um problema, por favor entre em contato com o serviço de suporte técnico. ',
            'sys005' => 'Err: SYS005 Ocorreu um problema com seu endereço de entrega. Retorne à etapa anterior e selecione novamente; caso o erro persista, tente selecionar outro endereço.',
            'sys006' => 'Err: SYS006 Ocorreu um problema, por favor entre em contato com o serviço de suporte técnico. ',
            # Paypal
            'sys101' => 'Err: SYS101  Ocorreu um problema ao processar seu pagamento, por favor tente novamente.',
            'sys102' => 'Err: SYS102  Ocorreu um problema ao processar seu pagamento, por favor tente novamente.',
            'sys103' => 'Err: SYS103  Ocorreu um problema ao processar seu pagamento, por favor tente novamente.',
            # Paypal Plus
            'sys104' => 'Err: SYS104  Ocorreu um problema ao processar seu pagamento, por favor tente novamente.',
            'sys105' => 'Err: SYS105  Ocorreu um problema ao processar seu pagamento, por favor tente novamente.',
            'sys106' => 'Err: SYS106  Ocorreu um problema ao processar seu pagamento, por favor tente novamente.',

            'payment_rejected'               => 'Seu pagamento foi recusado, tente novamente ou use outro método de pagamento.',
            'instrument_declined'            => 'Tente novamente',
            'bank_account_validation_failed' => 'A validação da conta bancária falhou. Tente novamente.',
            'credit_card_cvv_check_failed'   => 'Credit card verification was rejected. Verify your information and try again. ',
            'credit_card_refused'            => 'O cartão de crédito foi recusado. Tente com outro cartão de crédito.',
            'credit_payment_not_allowed'     => 'Cartão de crédito não pode ser usado para completar o pagamento. Por favor, selecione outro método de pagamento e tente novamente.',
            'insufficient_funds'             => 'Insufficient funds. Please select another method of payment and try again.',
            'payment_denied'                 => 'Fundos insuficientes. Por favor, selecione outro método de pagamento e tente novamente.',
            'internal_service_error'         => 'Ocorreu um problema, aguarde um momento e tente novamente.',
            'payment_expired'                => 'O pagamento expirou. Tente novamente.',
            'payment_already_done'           => 'Payment has expired. Try again.',
            'duplicate_transaction'          => 'O número de transações bancárias é dobrado.',
            'default_paypal'                 => 'Houve um problema ao validar seu pagamento. Entre em contato com a equipe de suporte.'
        ],

        'modal' => [
            'loader' => [
                'title' => 'Realizando pagamento',
                'p1'    => "Você está um passo mais próximo de sua liberdade financeira.",
                'p2'    => 'Não fechar ou atualizar esta janela até a confirmação de compra.'
            ]
        ],
    ],

    'confirmation' => [
        'success' => [
            'thank_you'       => 'Obrigado por sua compra!',
            'success_pay'     => 'Débito bem sucedido',
            'order_number'    => 'Número de pedido',
            'corbiz_order'    => 'Order Corbiz',
            'corbiz_number'   => 'Corbiz order number',
            'order_arrive_in' => 'Seu pedido chegará em',
            'business_days'   => 'dias úteis',
            'pay_with_card'   => 'Pagamento com cartão',
            'pay_with_paypal' => 'Pagamento com Paypal',
            'pay_with_paypal_plus' => 'Pagamento com Paypal Plus',
            'pay_auth'        => 'Payment Authorization',
            'total'           => 'Purchase total',
            'send_to'         => 'Enviado para',
            'product_name'    => 'Nome do produto',
            'points'          => 'pts',
            'Eonumber'        => 'Número do Empresário',
            'password'        => 'Password',
            'secretquestion'  => 'Pergunta de segurança',
            'message_inscription' => 'Verifique sua caixa de e-mail para concluir a criação da conta.'
        ],

        'pending' => [
            'info'    => 'Seu pagamento está sendo validado.<br>Uma vez aprovado, você receberá um e-mail com as informações de seu pedido.',
            'pending' => 'Pagamento pendente',
        ],

        'no_order' => [
            'info' => 'Seu pagamento foi processado mas ocorreu um problema ao gerar seu pedido.<br>Entraremos em contato por e-mail em breve com a confirmação.'
        ],

        'error' => [
            'info' => 'Seu pagamento foi processado mas ocorreu um problema ao gerar seu pedido.<br>Entraremos em contato por e-mail em breve com a confirmação.'
        ],

        'emails' => [
            'confirmation_title' => 'Your payment is in verification',
            'order_success'      => 'Confirmação de pedido'
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
            'p_11'    => 'Detalhes do seu pedido:',
            'p_12'    => 'Riepilogo degli acquisti',
        ]
    ],

    'quotation' => [
        'resume_cart' => [
            'remove_all' => 'Remover todos',
            'code' => 'Código',
            'pts' => 'points',
            'subtotal' => 'Subtotal',
            'discount' => 'Descuento', //Nueva
            'handling' => 'Tratamento',
            'taxes' => 'Impostos',
            'points' => 'Pontos',
            'total' => 'Total',
            'no_items' => 'Não foram adicionados produtos ao carrinho',
            'delete_items' => 'Não é possível enviar alguns dos produtos para o código postal selecionado; foram removidos do carrinho.',
            'purchase_summary' => 'Resumo da compra',
            'discount'       => 'Discount',
        ],
        'change_period' => 'Mudar para período anterior?',
        'change_period_yes' => 'Sim',
        'change_period_no' => 'Não',
        'change_period_success_msg' => 'Mudança de período bem sucedida.',
        'change_period_fail_msg' => 'Mudança período falhou, tente mais tarde.',
    ],

    'promotions' => [
        'title_modal' => 'Promoções',
        'msg_select_promotions' => 'Selecione um produto ou pacote das seguintes promoções',
        'msg_promo_required' => '(Necessário)',
        'label_quantity' => 'Quantidade',

        'btn_select' => 'Selecionar',
        'btn_accept' => 'Aceitar',

        'msg_promo_obliga' => 'Para prosseguir, escolha um produto: :name_promo',
        'msg_promo_qty' => 'Você pode escolher apenas :qty_promo produtos da promoção: :name_promo',

        'msg_promo_A' => 'Choose one of the following packages, You can choose the maximum quantity of :qty of the selected package.',
        'msg_promo_B' => 'Choose one of the following packages, You can choose the maximum quantity of :qty of the selected package.',
        'msg_promo_C' => '{1} Você pode escolher :qty dos seguintes produtos | [2,*] Pode escolher até :qty dos seguintes produtos, se permitido, pode escolher um ou mais de cada um dos produtos.',
    ]
];
