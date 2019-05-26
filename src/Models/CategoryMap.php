<?php

namespace Laraflash\DAL\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class CategoryMap extends Model
{
    use Cachable;

    protected $guarded = [];

    public function category_position()
    {
        return $this->HasOne('Laraflash\DAL\Models\CategoryPosition', 'article_category', 'article_category');
    }
}
