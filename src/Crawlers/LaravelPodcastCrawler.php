<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class LaravelPodcastCrawler extends RssCrawler
{
    public function parse($item)
    {
        parent::parse($item);
        $this->article->category = 'podcast';
        $this->article->type = 'podcast';
        $this->article->contributor = 'Matt Stauffer';
        $this->article->displayed_author = $this->source->name;
    }
}
