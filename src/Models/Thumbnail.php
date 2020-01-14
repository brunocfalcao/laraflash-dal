<?php

namespace Laraflash\DAL\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use Cachable;

    protected $guarded = [];
}
