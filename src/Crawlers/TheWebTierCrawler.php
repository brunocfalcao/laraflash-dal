<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class TheWebTierCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        $this->sanitized->thumbnail = $this->fetchImage($item->get_link());
    }

    public function fetchImage($link)
    {
        $htmlDom = file_get_html($link);

        return rescue(function () use ($htmlDom) {
            return explode('?', optional($htmlDom->find('img.wp-post-image', 0))->getAttribute('src'))[0];
        });
    }
}
