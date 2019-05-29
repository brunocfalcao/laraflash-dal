<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class LaracastsCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        $mixed = collect(explode('/', $item->get_link()));
        $mixed = $mixed->slice(0, -2)->implode('/');
        $this->sanitized->thumbnail = $this->fetchImage($mixed);
    }

    public function fetchImage($link)
    {
        $htmlDom = file_get_html($link);

        return rescue(function () use ($htmlDom) {
            return 'https://www.laracasts.com'.
                   optional($htmlDom->find('img.series-thumbnail', 0))->getAttribute('data-cfsrc');
        });
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->category = 'tutorials';
        $this->article->displayed_author = $this->source->name;
    }
}
