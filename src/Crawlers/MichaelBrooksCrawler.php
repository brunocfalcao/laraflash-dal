<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Abstracts\RssCrawler;

class MichaelBrooksCrawler extends RssCrawler
{
    public function validate($item)
    {
        // Continue only if news id doesn't exist and 'laravel' appears on title or description.
        return ! Article::where('uid', $item->get_id())
                        ->where('data_source_id', $this->source->id)
                        ->exists() && (strpos(strtolower($item->get_title()), 'laravel') !== false ||
                                       strpos(strtolower($item->get_description()), 'laravel') !== false);
    }

    public function thumbnail($item)
    {
        $this->sanitized->thumbnail = $this->fetchImage($item->get_link());
    }

    public function fetchImage($link)
    {
        $htmlDom = file_get_html($link);

        return rescue(function () use ($htmlDom) {
            return optional($htmlDom->find('img.attachment-twentyseventeen-featured-image', 0))->getAttribute('data-orig-file');
        });
    }

    public function parse($item)
    {
        parent::parse($item);
    }
}
