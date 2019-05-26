<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Abstracts\RssCrawler;

class ChristophRumpelCrawler extends RssCrawler
{
    public function thumbnail($item)
    {
        $this->sanitized->thumbnail = $this->fetchImage($item->get_link());
    }

    public function fetchImage($link)
    {
        $htmlDom = file_get_html($link);
        return rescue(function () use ($htmlDom) {
            $imgPath = optional($htmlDom->find("img.blogimage", 0))->getAttribute('src');
            if ($imgPath != null) {
                return 'https://christoph-rumpel.com' . $imgPath;
            };
        });
    }
}
