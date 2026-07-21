<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $table = 'prodotti_gallery'; // nome tabella reale

    protected $primaryKey = 'entity_id'; // SOLO se esiste

    public $timestamps = false; // se la tabella non ha created_at / updated_at

    protected $fillable = [
        'id_product',
        'image',
        'ordine'
    ];

    public function getImageUrlAttribute(): string
    {
        return product_image_url($this->image, 'full');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return product_image_url($this->image, 'thumb');
    }
}
