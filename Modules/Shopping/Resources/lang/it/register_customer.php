<?php

return [
    'title' => 'Registrazione cliente',

    'months'        => [
        1   => 'Gennaio',
        2   => 'Febbraio',
        3   => 'Marzo',
        4   => 'Aprile',
        5   => 'Maggio',
        6   => 'Giugno',
        7   => 'Luglio',
        8   => 'Agosto',
        9   => 'Settembre',
        10  => 'Ottobre',
        11  => 'Novembre',
        12  => 'Dicembre',
    ],

    'error__box'    => 'Si è verificato un problema',

    'error_rest'    => 'È stato rilevato un inconveniente, per maggiori informazioni mettiti in contatto con il call center CREO.',

    'tabs' => [
        'account' => [
            'desktop'   => '1. Registrazione Cliente',
            'mobile'    => 'Account',
        ],

        'email' => [
            'desktop'   => '2. Indirizzo Email',
            'mobile'    => 'Indirizzo Email  ',
        ],

        'activation' => [
            'desktop'   => '3. Attivazione',
            'mobile'    => 'Attivazione',
        ],
    ],
    'account' => [
        'country' => [
            'label'     => 'Stato',
            'default'   => 'Seleziona il tuo Stato',
        ],

        'invited' => [
            'label' => [
                'desktop'   => 'Sei stato invitato da un Imprenditore OMNILIFE',
                'mobile'    => 'Sei stato Invitato',
            ],

            'answer' => [
                'yes'   => 'Si',
                'no'    => 'No'
            ],
        ],

        'businessman_code' => [
            'label'         => 'Codice Imprenditore',
            'placeholder'   => 'Inserire codice',
        ],

        'meet_us' => [
            'label'     => 'Come hai conosciuto OMNILIFE?',
        ],

        'sex' => [
            'label'     => 'Sesso',
            'male'      => 'Uomo',
            'female'    => 'Donna',
        ],

        'borndate' => [
            'label' => 'Data di Nascita',
            'day'   => 'Giorno',
            'month' => 'Mese',
            'year'  => 'Anno',
            'alert' => 'Il campo Data di Nascita non corrisponde ad una data valida',
        ],

        'full_name' => [
            'name'      => [
                'label'         => 'Nome e cognome',
                'placeholder'   => 'Nome',
            ],

            'lastname'  => [
                'placeholder'   => 'Cognome',
            ],

            'lastname2' => [
                'placeholder'   => 'Mother\'s Last Name',
            ],
        ],

        'identification' => [
            'label'         => 'Documento d’identità',
            'option'        => 'Tipo di documento d’identità',
            'placeholder'   => 'Numero del documento d’identità',
        ],

        'expiration' => [
            'placeholder'   => 'Data di Validità',
        ],

        'address' => [
            'label'         => 'Address',
            'placeholders'  => [
                'zip'               => 'CAP',
                'ext_num'           => 'Numero',
                'int_num'           => 'Interno',
                'county'            => 'Paese',
                'suburb'            => 'Paese',
                'betweem_streets'   => 'On the streets',
                'state'             => 'Stato',
                'city'              => 'Città',
                'street'            => 'Via',
                'shipping_company'  => 'Shipping Company',
            ],
        ],
    ],

    'mail_address' => [
        'mail' => [
            'label'         => 'Email',
            'placeholder'   => 'Ingresa correo',
        ],

        'confirm_mail' => [
            'label'         => 'Confermare indirizzo email',
            'placeholder'   => 'Inserisci indirizzo email',
        ],

        'tel' => [
            'label'         => 'Telefono',
            'placeholder'   => 'Inserisci telefono',
        ],

        'cel' => [
            'label'         => 'Cellulare',
            'placeholder'   => 'Inserisci cellulare',
        ],

        'info_send'     => 'Controlla il tuo indirizzo email per continuare la procedura di registrazione',
        'title'         => 'Assistenza OMNILIFE',
        'subject'       => 'Richiesta per convalidare il tuo indirizzo email',
    ],

    'activation' => [
        'question'      => 'Domanda Segreta',
        'answer'        => 'Risposta',
        'option'        => 'Seleziona una domanda',
        'placeholder'   => 'Scrivi la tua risposta ',
        'label'         => 'Registrazione avvenuta con successo, i tuoi dati sono i seguenti',
        'code'          => 'Codice Cliente',
        'password'      => 'Password',
    ],

    'mail' => [
        'verify' => [
            'title'     => 'Verify your account',
            'subject'   => 'Verify your account',
            'h6'        => 'Verify your account',
            'h3'        => 'Ciao, :name!',
            'p1'        => 'Per completare la registrazione, verifica il tuo account facendo clic sul seguente pulsante',
            'p2'        => 'Questa è una risposta automatica da OMNILIFE. Per favore, non rispondere a questa email.',
            'a1'        => 'CONFERMA LA TUA MIA E-MAIL',
            'a2'        => 'Informativa sulla Privacy',
        ],

        'customer' => [
            'title'     => 'OMNILIFE ti dà il benvenuto!',
            'subject'   => 'Benvenuto',
            'h6'        => 'Benvenuto',
            'h3'        => 'OMNILIFE ti dà il benvenuto!',
            'p5'        => 'Ti informiamo che la tua registrazione come Cliente è avvenuta con successo. A partire da adesso potrai effettuare i tuoi acquisti e ottenere tutti i benefici che OMNILIFE offre ai suoi clienti.',
            'p1'        => 'Questi sono i dati del tuo account',
            'li'        => [
                1   => 'Codice Cliente',
                2   => 'Password',
                3   => 'Domanda Segreta',
                4   => 'Risposta alla domanda segreta',
            ],
            'p2'        => 'Ti suggeriamo di non far sapere a nessuno il tuo codice cliente e la relativa password, dato che queste sono informazioni private e necessarie per effettuare i tuoi acquisti mediante il nostro sito web.',
            'p3'        => [
                'text1' => 'Visita il nostro sito ed effettua subito',
                'text2' => 'il tuo primo acquisto!',
            ],
            'p4'        => [
                'text1' => '“Se non sei al corrente della suddetta procedura o se vuoi opporti al trattamento dei tuoi Dati Personali, inoltra questa email all’indirizzo',
                'text2' => 'indicando come oggetto Diritto di Opposizione, nome e cognome, Stato di residenza e numero telefonico o mettiti in contatto con il nostro call center {CREO}”.',
            ],
            'a1'        => 'Privacy Policies',
        ],

        'sponsor' => [
            'title'         => 'Nuovo Cliente della tua rete',
            'subject'       => 'Complimenti, uno nuovo cliente speciale è stato iscritto alla tua rete',
            'h6'            => 'New customer in your Distributor Network',
            'h3'            => 'Complimenti, :name!',
                'p1'        => [
                'text1' => 'La tua Attività Indipendente sta crescendo,',
                'text2' => 'si è iscritto/a alla tua rete come Cliente.',
            ],
            'p2'        => 'Mantieniti in contatto con lui/lei per raggiungere più facilmente il tuo obiettivo mensile',
            'li'        => [
                1   => 'Codice Imprenditore',
                2   => 'Nome',
                3   => 'Telefono',
                4   => 'Email',
            ],
            'ul'        => 'Motiva il tuo nuovo Cliente affinché faccia acquisti spesso, dato che ognuno di essi ti porterà sempre più punti per avanzare nella carriera e per raggiungere le mete prefissate.',
            'p3'        => [
                'text1' => '“Se non sei al corrente della suddetta procedura o se vuoi opporti al trattamento dei tuoi Dati Personali, inoltra questa email all’indirizzo',
                'text2' => 'indicando come oggetto Diritto di Opposizione, nome e cognome, Stato di residenza e numero telefonico o mettiti in contatto con il nostro call center {CREO}”.',
            ],
            'a1'        => 'Pol&iacute;tica de Privacidad',
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
        'required'      => 'Il campo :attribute è obbligatorio.',
        'in'            => 'Il campo  :attribute  non è valido',
        'not_in'        => 'Il campo  :attribute selezionato non è valido.',
        'email'         => 'Il campo :attribute deve essere un indirizzo di posta elettronica valido.',
        'numeric'       => 'Il campo :attribute  deve essere un numero.',
        'same'          => 'Il campo :attribute e :other   devono coincidere.',
        'min'           => 'Il campo :attribute non deve contenere più di  :min caratteri.',
        'max'           => 'Il campo :attribute may not be greater than :max characters.',
        'date'          => 'Il campo :attribute non corrisponde ad una data valida.',
        'date_format'   => 'Il campo :attribute non corrisponde al formato della  :format.',
        'unique'        => 'Il campo :attribute è già in uso.',
        'regex'         => 'Il campo :attribute selezionato non è valido.',
        'street_corbiz' => 'Wrong Address',
    ],

    'btn' => [
        'back'          => 'Tornare indietro',
        'continue'      => 'Continuare',
        'activate'      => 'Attivare',
        'resend_mail'   => 'Inviare nuovamente l’indirizzo Email',
        'finish'        => [
            'shopping'  => 'Continuare con gli acquisti',
            'login'     => 'Accesso'
        ],
    ],

    'modal_exit' => [
        'title' => 'Registrazione incompleta',
        'body'  => 'Uscendo da questa pagina senza aver concluso l’iscrizione perderai tutti i tuoi dati, vuoi continuare? ',
        'btn' => [
            'accept'    => 'Accettare',
            'cancel'    => 'Annullare',
        ],
    ],
];
