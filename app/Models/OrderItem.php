<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'ordini_prod';

    protected $fillable = [
        'id_prod',
        'id_ord',
        'cod_prod',
        'nome',
        'prezzo',
        'prezzo_f',
        'peso',
        'peso_f',
        'quantita',
    ];

    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_ord');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_prod', 'entity_id');
    }
}

