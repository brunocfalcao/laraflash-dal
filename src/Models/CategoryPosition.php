<?php

namespace Laraflash\DAL\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class CategoryPosition extends Model
{
    use Cachable;

    protected $guarded = [];

    public function categoryMap()
    {
        return $this->hasMany('Laraflash\DAL\Models\CategoryMap', 'article_category', 'article_category');
    }
}
