<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements CanResetPasswordContract
{
    use CanResetPassword, HasFactory, Notifiable;

    // Usa il prefisso del DB (mor_) + questo nome tabella => mor_clienti_new
    protected $table = 'clienti_new';

    protected $fillable = [
        'data_iscr',
        'nome',
        'cognome',
        'email',
        'password',
        'nome_sped',
        'cognome_sped',
        'indirizzo',
        'citta',
        'provincia',
        'cap',
        'nazione',
        'is_company',
        'cod_fiscale',
        'codice',
        'rag_sociale',
        'partita_iva',
        'pec_sdu',
        'telefono',
        'news',
        'confermato',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;
}

