<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use App\Models\Product;

class CartItem extends Model
{
    protected $table = 'cart_items'; 

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price_snapshot'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'entity_id');
    }
}
