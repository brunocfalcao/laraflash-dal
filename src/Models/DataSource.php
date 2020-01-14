<?php

namespace Laraflash\DAL\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
    use Cachable;

    protected $casts = ['crawler_class' => 'object',
        'last_crawl_at' => 'datetime', ];

    protected $guarded = [];

    public function logs()
    {
        return $this->hasMany('Laraflash\DAL\Models\CrawlerLog');
    }
}
