<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $table = 'categorie_new';
    protected $primaryKey = 'entity_id';
    public $timestamps = false;
	
	public function children()
	{
		return $this->hasMany(Category::class, 'parent_id', 'entity_id')
			->orderBy('position');
	}
	
	public function childrenRecursive()
	{
		return $this->children()->with('childrenRecursive');
	}

	public function parent()
	{
		return $this->belongsTo(Category::class, 'parent_id', 'entity_id');
	}

	/**
	 * Immagine effettiva: propria o ereditata dal genitore (risalendo l'albero).
	 */
	public function getEffectiveImageAttribute(): ?string
	{
		return $this->resolveEffectiveImage();
	}

	public function resolveEffectiveImage(?\Illuminate\Support\Collection $indexed = null): ?string
	{
		$category = $this;
		$visited = [];

		while ($category && !in_array($category->entity_id, $visited, true)) {
			$visited[] = $category->entity_id;

			$image = $category->image ?: ($category->image_categoria ?? null);
			if (!empty($image)) {
				return $image;
			}

			if (empty($category->parent_id) || (int) $category->parent_id <= 0) {
				break;
			}

			if ($indexed && $indexed->has($category->parent_id)) {
				$category = $indexed->get($category->parent_id);
				continue;
			}

			$category = $category->relationLoaded('parent')
				? $category->parent
				: static::query()
					->select(['entity_id', 'parent_id', 'image'])
					->where('entity_id', $category->parent_id)
					->first();
		}

		return null;
	}

	/**
	 * Mappa entity_id => immagine effettiva (con cache).
	 */
    public static function imageMap(): array
    {
        return Cache::remember('category_image_map', now()->addHours(12), function () {
            $indexed = static::query()
                ->select(['entity_id', 'parent_id', 'image'])
                ->get()
                ->keyBy('entity_id');

            $map = [];
            foreach ($indexed as $category) {
                $map[$category->entity_id] = $category->resolveEffectiveImage($indexed);
            }

            return $map;
        });
    }

    public static function forgetImageMapCache(): void
    {
        Cache::forget('category_image_map');
    }

    public function getCategoryImageUrlAttribute(): string
    {
        return category_image_url($this->effective_image, 'thumb');
    }

    public function getTranslatedNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'name_'.$locale} ?? $this->name;
    }

    public function getTranslatedLinkAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'link_'.$locale} ?? $this->link_it;
    }

    /**
     * Restituisce l'entity_id della categoria e di tutte le sottocategorie (per filtrare prodotti).
     */
    public static function getCategoryAndDescendantIds(int $entityId): array
    {
        $category = static::where('entity_id', $entityId)->first();
        if (!$category) {
            return [$entityId];
        }
        $ids = [$category->entity_id];
        $category->load('childrenRecursive');
        $collectIds = function ($node) use (&$collectIds, &$ids) {
            $ids[] = $node->entity_id;
            if ($node->relationLoaded('childrenRecursive') && $node->childrenRecursive) {
                foreach ($node->childrenRecursive as $child) {
                    $collectIds($child);
                }
            }
        };
        if ($category->childrenRecursive) {
            foreach ($category->childrenRecursive as $child) {
                $collectIds($child);
            }
        }
        return array_values(array_unique($ids));
    }
}

