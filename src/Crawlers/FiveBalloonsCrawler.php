<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class FiveBalloonsCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        $this->sanitized->thumbnail = $this->fetchImage($item->get_link());
    }

    public function fetchImage($link)
    {
        $htmlDom = file_get_html($link);

        return rescue(function () use ($htmlDom) {
            return optional($htmlDom->find('p > img', 0))->getAttribute('src');
        });
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->displayed_author = $this->source->name;
    }
}
