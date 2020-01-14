<?php

namespace Laraflash\DAL\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CategoryPosition extends Model
{
    use Cachable;

    protected $guarded = [];

    public function categoryMap()
    {
        return $this->hasMany('Laraflash\DAL\Models\CategoryMap', 'article_category', 'article_category');
    }
}
