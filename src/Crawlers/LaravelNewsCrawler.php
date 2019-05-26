<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class LaravelNewsCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        // In Laravel News the image comes in the get_description(),
        // in the first img tag.
        $start = strpos($item->get_description(), 'img src') + 9;
        $end = strpos($item->get_description(), '?');
        if ($start!== false && $end !== false) {
            $this->sanitized->thumbnail = substr($item->get_description(), $start, $end-$start);
        };
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->displayed_author = $this->source->name;
    }
}
