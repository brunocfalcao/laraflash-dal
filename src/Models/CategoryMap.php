<?php

namespace Laraflash\DAL\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CategoryMap extends Model
{
    use Cachable;

    protected $guarded = [];

    public function category_position()
    {
        return $this->HasOne('Laraflash\DAL\Models\CategoryPosition', 'article_category', 'article_category');
    }
}
