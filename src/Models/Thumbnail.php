<?php

namespace Laraflash\DAL\Models;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Thumbnail extends Model
{
    use Cachable;

    protected $guarded = [];
}
