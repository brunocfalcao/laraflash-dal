<?php

namespace Laraflash\DAL\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CrawlerLog extends Model
{
    use Cachable;

    protected $guarded = [];

    public function dataSource()
    {
        return $this->belongsTo('Laraflash\DAL\Models\DataSource');
    }
}
