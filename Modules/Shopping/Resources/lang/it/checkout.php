<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Language Lines
    |--------------------------------------------------------------------------
    */

    'checkout'              => 'Pagare',
    'title'                 => 'Continuare con gli acquisti',
    'keep_buying'           => 'Keep buying',
    'return'                => 'Tornare alla pagina precedente',
    'continue_payment'      => 'Continuare con gli acquisti  ',
    'finish_purchase'       => 'Complete purchase',

   'payment' => [
        'select_payment' => 'Seleziona un metodo di pagamento',
        'resume_payment' => 'Riepilogo degli acquisti',
        'no_items'       => 'Non ci sono articoli',
        'handling'       => 'Spese di gestione',
        'taxes'          => 'Tasse',
        'attention'      => 'Assistenza',
        'total'          => 'Totale',
        'discount'       => 'Discount',
        'points'         => 'Punti',
        'shopping_cart'  => 'Carrello degli acquisti',

       'card_pplus'      => 'Credit/debit card',
       'pay_pplus'      => 'Pay with Paypal Plus',

        'errors' => [
            # Generales
            'cancel_paypal' => 'Hai annullato la procedura di pagamento. Puoi iniziare nuovamente la procedura cliccando sul bottone PayPal.',
            'default' => 'Si è verificato un problema.',
            'address' => 'Si è verificato un errore durante il controllo dei tuoi prodotti, verifica che il tuo indirizzo sia completo',
            'general' => 'We´re sorry, but something went wrong. Please try again. If the problem persists, contact us.',

            # Programación
            'sys001' => 'Err: SYS001  Si è verificato un problema, per cortesia contatta il servizio di assistenza tecnica. ',
            'sys002' => 'Err: SYS002 Si è verificato un problema, per cortesia contatta il servizio di assistenza tecnica.',
            'sys003' => 'Err: SYS003  Si è verificato un problema, per cortesia contatta il servizio di assistenza tecnica. ',
            'sys004' => 'Err: SYS004  Si è verificato un problema, per cortesia contatta il servizio di assistenza tecnica.',
            'sys005' => 'Err: SYS005 Si è verificato un problema con il tuo indirizzo di spedizione. Torna al passaggio precedente e selezionalo di nuovo; Se l\'errore persiste, prova ad inserire un altro indirizzo.',
            'sys006' => 'Err: SYS006  Si è verificato un problema, per cortesia contatta il servizio di assistenza tecnica. ',
            # Paypal
            'sys101' => 'Err: SYS101  Si è verificato un problema al momento di effettuare il pagamento. Per favore, prova di nuovo.',
            'sys102' => 'Err: SYS102  Si è verificato un problema al momento di effettuare il pagamento. Per favore, prova di nuovo.',
            'sys103' => 'Err: SYS103  Si è verificato un problema al momento di effettuare il pagamento. Per favore, prova di nuovo.',
            # Paypal Plus
            'sys104' => 'Err: SYS104  Si è verificato un problema al momento di effettuare il pagamento. Per favore, prova di nuovo.',
            'sys105' => 'Err: SYS105  Si è verificato un problema al momento di effettuare il pagamento. Per favore, prova di nuovo.',
            'sys106' => 'Err: SYS106  Si è verificato un problema al momento di effettuare il pagamento. Per favore, prova di nuovo.',

            'payment_rejected'               => 'Il pagamento non è andato a buon fine, prova di nuovo o utilizza una altro metodo di pagamento.',
            'instrument_declined'            => 'Il programma di elaborazione o l’istituto bancario non ha accettato il metodo di pagamento o quest’ultimo non può essere utilizzato per questa operazione. Prova nuovamente.',
            'bank_account_validation_failed' => 'La verifica del conto bancario non è andata a buon fine. Prova nuovamente.',
            'credit_card_cvv_check_failed'   => 'La verifica della carta di credito non è andata a buon fine. Controlla i dati e prova nuovamente. ',
            'credit_card_refused'            => 'La carta di credito non è stata riconosciuta. Prova nuovamente con un’altra carta di crédito.',
            'credit_payment_not_allowed'     => 'Non può essere utilizzato il credito selezionato per completare il pagamento. Per favore seleziona un altro metodo di pagamento e prova di nuovo. ',
            'insufficient_funds'             => 'Credito insufficiente. Per favore seleziona un altro metodo di pagamento e prova di nuovo.',
            'payment_denied'                 => 'Pagamento non riuscito. Per favore seleziona un altro metodo di pagamento e prova di nuovo.',
            'internal_service_error'         => 'Si è verificato un problema, aspetta un momento e prova nuovamente.',
            'payment_expired'                => 'Il pagamento non è avvenuto correttamente. Prova di nuovo.',
            'payment_already_done'           => 'Payment has expired. Try again.',
            'duplicate_transaction'          => 'Il numero di transazioni bancarie è raddoppiato.',
            'default_paypal'                 => 'Si è verificato un problema durante la convalida del pagamento, contatta il team di assistenza.'
        ],

        'modal' => [
            'loader' => [
                'title' => 'Effettuando il pagamento.',
                'p1'    => "Hai fatto un ulteriore passo verso la libertà finanziaria.",
                'p2'    => 'Non chiudere o cliccare su refresh prima di aver ricevuto la conferma dell’acquisto.'
            ]
        ],
    ],

    'confirmation' => [
        'success' => [
            'thank_you'       => 'Grazie per il tuo acquisto!',
            'success_pay'     => 'Pagamento avvenuto con successo',
            'order_number'    => 'Numero ordine',
            'corbiz_order'    => 'Order Corbiz',
            'corbiz_number'   => 'Corbiz order number',
            'order_arrive_in' => 'Il tuo ordine arriverà in',
            'business_days'   => 'giorni feriali',
            'pay_with_card'   => 'Pagamento con carta di credito',
            'pay_with_paypal' => 'Pagamento con Paypal',
            'pay_with_paypal_plus' => 'Pagamento con Paypal Plus',
            'pay_auth'        => 'Payment Authorization',
            'total'           => 'Totale acquisti',
            'send_to'         => 'Inviato a',
            'product_name'    => 'Nome del prodotto',
            'points'          => 'pt',
            'Eonumber'        => 'Eo Number',
            'password'        => 'Password',
            'secretquestion'  => 'Domanda si sicurezza',
            'message_inscription' => 'Controlla la tua casella di posta elettronica.'
        ],

        'pending' => [
            'info'    => 'Il tuo pagamento sta per essere controllato.<br>Una volta approvato , riceverai un\'email con le informazioni del tuo ordine.',
            'pending' => 'Pagamento in sospeso',
        ],

        'no_order' => [
            'info' => 'Il pagamento è stato effettuato ma si è verificato un problema durante l`elaborazione del tuo ordine.<br>Vi contatteremo a breve via e-mail per la conferma.'
        ],
        'error' => [
            'info' => 'Il pagamento è stato effettuato ma si è verificato un problema durante l`elaborazione del tuo ordine.<br>Vi contatteremo a breve via e-mail per la conferma.',

        ],

        'emails' => [
            'confirmation_title' => 'Your payment is in verification',
            'order_success'      => 'Ordine confermato'
        ]
    ],

    'email' => [
        'entepreneur' => 'Omnilife Entepreneur,',

        'confirmation' => [
            'title'   => 'Shopping Omnilife | Il tuo pagamento è andato a buon fine',
            'title_2' => 'Conferma di pagamento',
            'p_hi'    => '¡Ciao {name}!',
            'p_1'     => 'Ti confermiamo che il pagamento dell’ordine è avvenuto con successo.',
            'p_2'     => 'Your order will be shipped to the indicated address.',
            'p_3'     => '<small>*The days of delivery are determined depending on your shipping method.</small>',
            'p_4'     => 'Informazioni sull\'ordine:',
            'p_5'     => 'Numero ordine: {order}',
            'p_6'     => 'Nome: {name}',
            'p_7'     => 'Indirizzo: {address}',
            'p_8'     => '<small>“Se non sei al corrente della suddetta procedura o se vuoi opporti al trattamento dei tuoi Dati Personali, inoltra questa email all’indirizzo <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a>, indicando come oggetto Diritto di Opposizione, nome e cognome, Stato di residenza e numero telefonico o mettiti in contatto con il nostro call center <strong>{CREO}</strong>”.</small>',
            'p_9'     => 'Politica sulla riservatezza',
        ],

        'success_order' => [
            'title'   => 'Shopping Omnilife | Il tuo pagamento è andato a buon fine',
            'title_2' => 'Conferma di pagamento',
            'title_3' => 'New Distributor on your Network',
            'p_hi'    => '!Ciao {name}!',
            'p_1'     => 'Ti informiamo che il tuo ordine è stato confermato.',
            'p_2'     => 'Your order will be shipped to the indicated address.',
            'p_3'     => '<small>*I tempi di consegna vengono considerati a partire dal momento della conferma del pagamento.</small>',
            'p_4'     => 'Informazioni sull\'ordine:',
            'p_5'     => 'Numero ordine: {order}',
            'p_6'     => 'Nome: {name}',
            'p_7'     => 'Indirizzo: {address}',
            'p_8'     => 'Non appena ricevuta la merce, ti suggeriamo di controllare lo stato dell’imballaggio.',
            'p_9'     => '<small>“Se non sei al corrente della suddetta procedura o se vuoi opporti al trattamento dei tuoi Dati Personali, inoltra questa email all’indirizzo <a href="mailto:privacidad@omnilife.com">privacidad@omnilife.com</a>, indicando come oggetto Diritto di Opposizione, nome e cognome, Stato di residenza e numero telefonico o mettiti in contatto con il nostro call center <strong>{CREO}</strong>”.</small>',
            'p_10'    => 'Politica sulla riservatezza',
            'p_11'    => 'Questi sono i dettagli del tuo ordine:',
            'p_12'    => 'Resumo da compra',
        ]
    ],

    'quotation' => [
        'resume_cart' => [
            'remove_all' => 'Eliminare tutti',
            'code' => 'Codice',
            'pts' => 'pt',
            'subtotal' => 'Subtotale',
            'discount' => 'Descuento', //Nueva
            'handling' => 'Spese di gestione',
            'taxes' => 'Tasse',
            'points' => 'Punti',
            'total' => 'Totale',
            'no_items' => 'Non sono stati aggiunti prodotti al carrello',
            'delete_items' => 'Non è possibile inviare alcuni prodotti al CAP selezionato; sono stati eliminati dal carrello.',
            'purchase_summary' => 'Riepilogo degli acquisti',
            'discount'       => 'Discount',
        ],
        'change_period' => 'Tornare al periodo precedente?',
        'change_period_yes' => 'Si',
        'change_period_no' => 'No',
        'change_period_success_msg' => 'Cambio di periodo effettuato',
        'change_period_fail_msg' => 'Cambio di periodo non riuscito, prova più tardi.',
    ],

    'promotions' => [
        'title_modal' => 'Promozioni',
        'msg_select_promotions' => 'Seleziona un prodotto o set dalle seguenti promozioni',
        'msg_promo_required' => '(Richiesto)',
        'label_quantity' => 'Quantità',

        'btn_select' => 'Selezionare',
        'btn_accept' => 'Accettare',

        'msg_promo_obliga' => 'Per continuare scelga i prodotti o il kit promozionale: :name_promo',
        'msg_promo_qty' => 'You can only choose :qty_promo product(s) of the promotion: :name_promo',

        'msg_promo_A' => 'Choose one of the following packages, You can choose the maximum quantity of :qty of the selected package.',
        'msg_promo_B' => 'Choose one of the following packages, You can choose the maximum quantity of :qty of the selected package.',
        'msg_promo_C' => '{1} Puoi scegliere  :qty dei seguenti prodotti | [2,*] Puoi scegliere fino a :qty dei seguenti prodotti, se desideri, puoi scegliere uno o più prodotti.',
    ]
];
