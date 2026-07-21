<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductGallery;
use App\Models\Category;
use App\Services\ProductAvailabilityService;


class Product extends Model
{
    protected $table = 'prodotti';
	protected $primaryKey = 'entity_id';
    public $incrementing = true;
    protected $keyType = 'int';
	protected $appends = ['final_price'];

    protected bool $resolvedAvailableQuantitySet = false;

    protected int $resolvedAvailableQuantity = 0;

	public function gallery()
    {
        return $this->hasMany(ProductGallery::class, 'id_product', 'entity_id')
            ->orderByDesc('ordine');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id');
    }

   public function getIsOnSaleAttribute()
	{
		return $this->special_price && $this->special_price > 0;
	}

    /**
     * Badge "NEW": novità attiva e periodo non scaduto (data_fine_novita o +7 giorni da inserimento).
     */
    public function getIsNewAttribute(): bool
    {
        if ((string) ($this->novita ?? '0') !== '1') {
            return false;
        }

        $today = now()->toDateString();

        if (! empty($this->data_fine_novita)) {
            return $this->data_fine_novita >= $today;
        }

        if (! empty($this->data_inserimento)) {
            return Carbon::parse($this->data_inserimento)->addDays(7)->toDateString() >= $today;
        }

        return false;
    }

	public function getFinalPriceAttribute()
	{
		return $this->is_on_sale
			? $this->special_price
			: $this->price;
	}

	public function formatPrice($value)
	{
		return format_price($value);
	}

	public function getFormattedFinalPriceAttribute()
	{
		return $this->formatPrice($this->final_price);
	}

	public function getFormattedOriginalPriceAttribute()
	{
		return $this->formatPrice($this->price);
	}
	
	public function getUrlAttribute()
	{
		return product_url($this);
	}
	
	public function getTitleAttribute()
	{
		$locale = app()->getLocale();

		 $name = $this->{'name_'.$locale} ?? $this->name;

		return $name . ' | ' . config('app.name');
	}

	public function getImageUrlAttribute(): string
	{
		return product_image_url($this->image, 'full');
	}

	public function getThumbnailUrlAttribute(): string
	{
		return product_image_url($this->image, 'thumb');
	}

    public function setResolvedAvailableQuantity(int $quantity): void
    {
        $this->resolvedAvailableQuantitySet = true;
        $this->resolvedAvailableQuantity = $quantity;
    }

    public function hasResolvedAvailableQuantity(): bool
    {
        return $this->resolvedAvailableQuantitySet;
    }

    public function getResolvedAvailableQuantity(): int
    {
        return $this->resolvedAvailableQuantity;
    }

    /**
     * Quantità disponibile considerando ordini e carrelli attivi.
     */
    public function availableQuantity(): int
    {
        return app(ProductAvailabilityService::class)->availableQuantity($this);
    }

    /**
     * Disponibilità per conferma ordine: esclude il carrello in checkout
     * (la quantità in quel carrello non è ancora un ordine).
     */
    public function availableQuantityExcludingCart(?int $cartId = null): int
    {
        return app(ProductAvailabilityService::class)->computeForProduct($this, $cartId);
    }

    public function localizedName(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return (string) ($this->{'name_'.$locale} ?? $this->name ?? '');
    }
}
