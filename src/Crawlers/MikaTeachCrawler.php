<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;
use Laraflash\DAL\Models\Article;

class MikaTeachCrawler extends RssCrawler
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
        $htmlDom = file_get_html($item->get_link());
        $this->sanitized->thumbnail = optional($htmlDom->find('img.td-backstretch', 0))
                                              ->getAttribute('src');
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->displayed_author = $this->source->name;
    }
}
