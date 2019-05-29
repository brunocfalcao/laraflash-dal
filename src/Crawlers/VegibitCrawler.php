<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Abstracts\RssCrawler;

class VegibitCrawler extends RssCrawler
{
    public function validate($item)
    {
        // Continue only if news id doesn't exist and laravel appears on title or description.
        return ! Article::where('uid', $item->get_id())
                            ->where('data_source_id', $this->source->id)
                            ->exists() && (strpos(strtolower($item->get_title()), 'laravel') !== false ||
                                           strpos(strtolower($item->get_description()), 'laravel') !== false);
    }

    public function thumbnail($item)
    {
        // In Vegibit the image comes in the get_description(),
        // in the first img tag.
        $start = strpos($item->get_description(), 'img src') + 9;
        $end = strpos($item->get_description(), '" ');
        if ($start !== false && $end !== false) {
            $this->sanitized->thumbnail = substr($item->get_description(), $start, $end - $start);
        }
    }
}
