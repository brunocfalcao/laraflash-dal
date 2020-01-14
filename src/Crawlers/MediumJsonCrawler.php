<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\MediumCrawler;
use Laraflash\DAL\Models\DataSource;

class MediumJsonCrawler extends MediumCrawler
{
    public function __construct(DataSource $source)
    {
        parent::__construct($source);
    }
}
