<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Abstracts\RssCrawler;

class SimonArcherCrawler extends RssCrawler
{
    function validate($item)
    {
        // Continue only if news id doesn't exist and laravel appears on title or description.
        return (!Article::where('uid', $item->get_id())
                            ->where('data_source_id', $this->source->id)
                            ->exists() && (strpos(strtolower($item->get_title()), 'laravel') !== false ||
                                           strpos(strtolower($item->get_description()), 'laravel') !== false)) ;
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->contributor = 'Simon Archer';
        $this->article->displayed_author = $this->source->name;
    }
}
