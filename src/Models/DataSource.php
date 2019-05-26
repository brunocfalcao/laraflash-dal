<?php

namespace Laraflash\DAL\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class DataSource extends Model
{
    use Cachable;

    protected $guarded = [];

    public function logs()
    {
        return $this->hasMany('Laraflash\DAL\Models\CrawlerLog');
    }
}
