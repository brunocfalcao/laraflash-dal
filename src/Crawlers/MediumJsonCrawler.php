<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Models\DataSource;
use Laraflash\DAL\Abstracts\MediumCrawler;

class MediumJsonCrawler extends MediumCrawler
{
    public function __construct(DataSource $source)
    {
        parent::__construct($source);
    }
}
