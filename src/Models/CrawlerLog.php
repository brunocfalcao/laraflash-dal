<?php

namespace Laraflash\DAL\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class CrawlerLog extends Model
{
    use Cachable;

    protected $guarded = [];

    public function dataSource()
    {
        return $this->belongsTo('Laraflash\DAL\Models\DataSource');
    }
}
