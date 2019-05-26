<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class MurzeCrawler extends RssCrawler
{
    public function parse($item)
    {
        parent::parse($item);
        $this->article->category = 'blog';
        $this->article->displayed_author = $this->source->name;
    }
}
