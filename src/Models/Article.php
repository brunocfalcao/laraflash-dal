<?php

namespace Laraflash\DAL\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Cachable;

    protected $guarded = [];

    public function dataSource()
    {
        return $this->belongsTo('Laraflash\DAL\Models\DataSource');
    }

    public function category()
    {
        return $this->hasOne('Laraflash\DAL\Models\CategoryMap', 'feed_category', 'category');
    }

    public function thumbnail()
    {
        // Empty model? Return the kebab case.
        return $this->belongsTo('Laraflash\DAL\Models\Thumbnail')->withDefault(['hash' => kebab_case($this->dataSource->name),
            'filename' => kebab_case($this->dataSource->name), ]);
    }

    public function scopeNewest($query)
    {
        return $query->orderBy('posted_at', 'desc');
    }

    public function getCategoryAttribute($value)
    {
        // Check if there is a category mapping. If not, then show the original. If null, then show 'Blog'.
        $mappedCategory = optional(CategoryMap::where('feed_category', $value)->first())->article_category;

        if (is_null($mappedCategory)) {
            if (is_null($value)) {
                return 'undefined';
            } else {
                return $value;
            }
        }

        return $mappedCategory;
    }

    public function getUrlContributorAttribute($value)
    {
        if (blank($value)) {
            return $this->dataSource->website_url;
        }

        return $value;
    }
}
