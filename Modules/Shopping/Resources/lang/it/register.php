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
        'desktop' => '1. Creare account',
        'mobile' => 'Account'
      ],
      'info' => [
        'desktop' => '2. Informazioni',
        'mobile' => 'Informazioni'
      ],
      'kit' => [
        'desktop' => '3. Seleziona il tuo Kit',
        'mobile' => 'Kit'
      ],
      'confirm' => [
        'desktop' => '4. Confermare',
        'mobile' => 'Confermare'
      ],
    ],

    'account' => [
      'invited' => [
        'label' => [
          'desktop' => 'Sei stato invitato da un Imprenditore OMNILIFE?',
          'mobile' => 'Sei stato invitato?',
        ],
        'answer' => [
          'yes' => 'Si',
          'no' => 'No'
        ]
      ],
      'businessman_code' => [
        'label' => 'Codice Imprenditore',
        'label_sponsored' => 'Código de Patrocinador',
        'placeholder' => 'Enter your businessman code'
      ],
      'meet_us' => [
        'label' => 'Come hai conosciuto OMNILIFE?',
        'default' => 'Come hai conosciuto OMNILIFE?',
      ],
      'country' => [
        'label' => 'Stato',
        'default' => 'Seleziona il tuo Stato',
        'empty_countries' => 'Non abbiamo trovato lo Stato',
        'emptydata' => 'Non abbiamo trovato informazioni sullo Stato',
        'emptypool' => 'Non abbiamo trovato informazioni sull’Imprenditore',
      ],
      'email' => [
        'label' => 'Indirizzo email',
        'placeholder' => 'Inserisci il tuo indirizzo email'
      ],
      'confirm_email' => [
        'label' => 'Conferma il tuo indirizzo email',
        'placeholder' => 'Conferma il tuo indirizzo email'
      ],
      'phone' => [
        'label' => 'Telefono',
        'placeholder' => 'Inserisci il tuo numero di telefono'
      ],
        'cel' => [
            'label' => 'Cellulare',
            'placeholder' => 'Inserisci il tuo numero di cellulare'
        ],
      'pool' => [
          'empty_country' => 'Cancellare Stato',
      ],
      'secret_question' => [
        'label' => 'Domanda Segreta',
        'default' => 'Seleziona una domanda segreta',
        'emptydata' => 'Non riscontriamo informazioni relative alla domanda segreta',
      ],
      'secret_answer' => [
        'label' => 'Risposta',
        'placeholder' => 'Scrivi la risposta'
      ],
      'parameters' => [
        'emptydata' => 'Non abbiamo riscontrato parametri di configurazione.',
      ],
      'kit' => [
        'placeholder' => 'Kit',
      ],
      'shipping' => [
        'placeholder' => 'Spedizione',
      ],
      'payment' => [
        'placeholder' => 'Pagamento',
      ],
      'fields' => [
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
              'email'      => [
                  'placeholder'   => 'Email',
              ],
              'email2'      => [
                  'placeholder'   => 'Email',
              ],
              'invited'      => [
                  'placeholder'   => 'Invitato',
              ],
              'confirm-email'      => [
                  'placeholder'   => 'Confermare indirizzo',
              ],
              'tel'      => [
                  'placeholder'   => 'Telefono',
              ],
              'cel' => [
                  'placeholder' => 'Cellulare',
              ],
              'secret-question'      => [
                  'placeholder'   => 'Domanda segreta',
              ],
              'response-question'      => [
                  'placeholder'   => 'Risposta',
              ],
             'day' => [
                 'placeholder' => 'Giorno',
             ],
             'month' => [
                 'placeholder' => 'Mese',
             ],
             'year' => [
                 'placeholder' => 'Anno',
             ],
            'zip' => [
                'placeholder' => 'CAP',
             ],
             'terms1' => [
                 'placeholder' => 'Termini e condizioni',
             ],
             'ext_num' => [
                 'placeholder' => 'Numero'
             ],
             'terms2' => [
                 'placeholder' => 'Trasferire dati',
             ],
            'city' => [
                'placeholder' => 'Città',
            ],
            'state' => [
                'placeholder' => 'Stato',
            ],
            'street' => [
                'placeholder' => 'Via',
            ],

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
    ],

    'info' => [
      'full_name' => [
        'label' => 'Nome e cognome',
        'placeholders' => [
          'name' => 'Nome',
          'last_name' => 'Cognome',
          'last_name2' => 'Last name',
          'sex' => 'Sesso',
        ]
      ],
      'birth_date' => [
        'label' => 'Data di nascita',
        'defaults' => [
          'day' => 'Giorno',
          'month' => 'Mese',
          'year' => 'Anno',
        ]
      ],
      'id' => [
        'label' => 'Documento d’identità',
        'defaults' => [
          'type' => 'Tipo di documento d’identità ',
        ],
        'placeholders' => [
          'number' => 'Numero del documento d’identità',
        ]
      ],
      'address' => [
        'label' => 'Indirizzo',
        'placeholders' => [
          'street' => 'Via',
          'ext_num' => 'Numero',
          'int_num' => 'Interno',
          'colony' => 'County',
          'streets' => 'On the streets',
          'state' => 'Stato',
          'city' => 'Città',
          'zip' => 'CAP',
           'choose_zip' => 'Scegli un´opzione',
        ]
      ],
      'terms_contract' => [
        'text' => 'Accetto',
        'link' => 'Termini e Condizioni del contratto ',
      ],
      'terms_payment' => [
        'text' => 'Accetto',
        'link' => 'il trattamento dei miei dati personali in Messico, Centro Operativo di OMNILIFE.',
      ],
      'terms_information' => [
        'text' => 'Accetto',
        'link' => 'di ricevere informazioni relative a prodotti, servizi, promozioni e/o eventi OMNILIFE ai recapiti da me forniti'
      ],
      'mandatory' => [
          'label' => 'Questo campo è obbligatorio.',
      ]
    ],

    'kit' => [
      'types' => 'Seleziona il tuo Kit',
      'emptydata' => 'No hay kits disponibles',
      'emptywarehouse' => 'Almacen no enviado',
      'shipping' => 'Scegli il metodo di spedizione  ',
      'shippingCompanies_empty' => 'Non si trovano compagnie di spedizione relative allo stato e alla citta´indicati,si prega di segnalare il problema ed indicare uno stato e una citta´ diversi.',
      'payment' => 'Seleziona un metodo di pagamento   ',
      'choose' => 'Scegli un Kit',
      'sendby' => 'Inviare per',
      'bill' => [
        'subtotal' => 'Subtotale',
        'management' => 'Handling',
        'taxes' => 'Tasse',
        'points' => 'Punti',
        'total' => 'Totale',
        'resume' => 'Sintesi',
        'discount' => 'Sconto',
        'shipping_cost' => 'Invio',
        'shopping_cart' => 'Shopping cart',
      ]
    ],

    'confirm' => [
      'email' => 'Controlla il tuo indirizzo email per completare la procedura di creazione del tuo account.',
      'businessman_code' => 'Il tuo Codice Imprenditore è',
      'thank_you' => 'Grazie per il tuo acquisto.',
      'payment_successful' => 'Il pagamento è avvenuto con successo',
      'no_data_in_tables' => 'No data found it on local tables'
    ],

    'modal' => [
      'header' => 'Elaborando il pagamento',
      'text_highlight' => 'Sei sempre più vicino alla libertà finanziaria!  ',
      'text' => 'Non chiudere o cliccare su refresh'
    ],

    'terms' => [
        'title' => "Cliccando su Accetto, darai il tuo assenso a rispettare i nostri Termini e Condizioni.",
        'cancel' => 'Annullare',
        'accept' => 'Accettare',
        'download' => 'Scaricare le disposizioni del contratto',
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
            'privacypolicies' => 'Póliticas de privacidad',
            'dist_area'    =>       'Zona de empresarios',
        ],

        'sponsor'           => [
            'title'         => 'Nuovo Cliente della tua rete',
            'subject'       => '¡Felicidades!, :name_sponsor',
            'p1'            => '<strong>:name_sponsor</strong>, Siamo lieti di informarti che<strong>:name_customer </strong> è entrato/a a far parte della tua rete e che adesso è in cammino verso uno stile di vita più sano ed appagante grazie agli integratori alimentari OMNILIFE. Otterrai punti dagli acquisti effettuati per raggiungere più facilmente la tua meta mensile.',
            'p2'            => 'Dati del Nuovo Cliente',
            'text1'         => 'È molto importante ricordare che come sponsor, potrai ',
            'text2'         => 'lavorare insieme ai tuoi clienti per arrivare sempre più in alto e raggiungere i tuoi obiettivi!',
            'client_code'   => 'Codice Cliente',
            'name'          => 'Nome',
            'telephone'     => 'Telefono',
            'email'         => 'Email',
            'li1'           => 'Rispondi alle domande dei tuoi clienti',
            'li2'           => 'Promuovi l’acquisto dei prodotti OMNILIFE',
            'li3'           => 'Consiglia l’uso dei prodotti',
            'li4'           => 'Assistenza per la procedura di acquisto',
        ],

        'prospect'  => [
            'title'     => 'A contact is about to end his registration!',
            'subject'   => 'L’Imprenditore non ha terminato la registrazione',
            'h6'        => 'L’Imprenditore non ha terminato la registrazione',
            'h3'        => 'L’Imprenditore non ha terminato la registrazione',
            'p1'        => '<strong>:name</strong>, non perdere l’opportunità di far crescere la tua attività insieme a noi!',
            'p2'        => [
                'text1' => 'Ti comunichiamo che',
                'text2' => 'è interessato/a a unirsi alla tua rete di Imprenditori ma non ha completato la registrazione.',
            ],
            'p3'        => 'Contattalo/a subito per avere la possibilità di arrivare più facilmente alla tua meta mensile',
            'li'        => [
                1   => 'Nome',
                2   => 'Telefono',
                3   => 'Email',
            ],
            'p4'        => 'Ricorda che per ognuno dei suoi acquisti, otterrai più punti per avanzare nella carriera e raggiungere gli obiettivi che hai fissato per la tua Attività Indipendente.',
            'p5'        => [
                'text1' => '“Se non sei al corrente della suddetta procedura o se vuoi opporti al trattamento dei tuoi Dati Personali, inoltra questa email all’indirizzo ',
                'text2' => 'indicando come oggetto Diritto di Opposizione, nome e cognome, Stato di residenza e numero telefonico o mettiti in contatto con il nostro call center {CREO}”.',
            ],
            'a1'        => 'Privacy Policy',
        ],
    ],

    'warehouse' => [
        'empty' => 'Empty warehouse, modify your shippping information',
    ],

    'next_button' => 'Continuare',
    'prev_button' => 'Tornare indietro',
    'checkout_button' => 'Checkout',
    'errors' => 'Errori',
];
