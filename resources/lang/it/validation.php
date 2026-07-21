<?php

return [
    'required' => 'Il campo :attribute è obbligatorio.',
    'accepted' => 'È necessario accettare :attribute per procedere.',
    'accepted_if' => 'È necessario accettare :attribute quando :other è :value.',
    'in' => 'Il valore selezionato per :attribute non è valido.',
    'integer' => 'Il campo :attribute deve essere un numero intero.',
    'min' => [
        'numeric' => 'Il campo :attribute deve essere almeno :min.',
        'string' => 'La :attribute deve contenere almeno :min caratteri.',
    ],
    'max' => [
        'numeric' => 'Il campo :attribute non può essere superiore a :max.',
        'string' => 'La :attribute non può superare :max caratteri.',
    ],
    'string' => 'Il campo :attribute deve essere un testo.',

    'unique' => 'La :attribute è già registrata.',

    'current_password' => 'La password attuale non è corretta.',
    'confirmed'        => 'La conferma della :attribute non coincide.',

    'attributes' => [
        'email'             => 'email',
        'password'          => 'password',
        'nome'              => 'nome',
        'cognome'           => 'cognome',
        'current_password'  => 'password attuale',
        'password_confirmation' => 'conferma password',

        'terms_accepted'   => 'le condizioni di vendita',
        'shipping_method'  => 'metodo di spedizione',
        'payment_method'   => 'metodo di pagamento',
        'note'             => 'note',

        'nome_sped'        => 'nome (spedizione)',
        'cognome_sped'     => 'cognome (spedizione)',
        'indirizzo'        => 'indirizzo',
        'citta'            => 'città',
        'provincia'        => 'provincia',
        'cap'              => 'CAP',
        'nazione'         => 'nazione',
        'cod_fiscale'      => 'codice fiscale',
        'rag_sociale'      => 'ragione sociale',
        'partita_iva'      => 'partita IVA',
        'pec_sdu'          => 'codice SDI o PEC',
        'telefono'         => 'telefono',

        'product_id'       => 'prodotto',
        'item_id'          => 'articolo',
        'quantity'         => 'quantità',
    ],
];

