<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'ordini';

    protected $fillable = [
        'id_cliente',
        'nome',
        'cognome',
        'email',
        'cognome_spe',
        'nome_spe',
        'indirizzo_spe',
        'cap_spe',
        'citta_spe',
        'prov_spe',
        'paese_spe',
        'azienda_spe',
        'piva',
        'pec_sdu',
        'cod_fiscale',
        'telefono_spe',
        'note_spe',
        'spedizione',
        'pagamento',
        'totale',
        'spese',
        'data_ord',
        'data_pagato',
        'data_mod',
        'status',
        'ipn',
        'pp_response',
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_cliente');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_ord');
    }
}

