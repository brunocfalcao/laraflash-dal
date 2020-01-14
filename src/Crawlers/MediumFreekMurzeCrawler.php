<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\MediumCrawler;
use Laraflash\DAL\Models\DataSource;

class MediumFreekMurzeCrawler extends MediumCrawler
{
    public function __construct(DataSource $source)
    {
        parent::__construct($source);
        $this->url = $source->feed_url;
    }
}
