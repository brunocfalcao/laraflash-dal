<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class LaraningCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        // In Laraning we need to get the item link, then navigate to it and
        // extract the meta property og:image.
        $htmlDom = file_get_html($item->get_link());
        $this->sanitized->thumbnail = optional($htmlDom->find("meta[property='og:image']", 0))
                                              ->getAttribute('content');
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->category = 'tutorials';
        $this->article->displayed_author = $this->source->name;
    }
}
