<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;
use Laraflash\DAL\Models\Article;

class TweetsBrunoFalcaoCrawler extends RssCrawler
{
    public function validate($item)
    {
        // Continue only if news id doesn't exist and laravel appears on title or description.
        return ! Article::where('uid', $item->get_id())
                            ->where('data_source_id', $this->source->id)
                            ->exists() && (strpos(strtolower($item->get_title()), 'laravel') !== false ||
                                           strpos(strtolower($item->get_description()), 'laravel') !== false);
    }

    public function parse($item)
    {
        parent::parse($item);
        $this->article->category = 'tweet';
        $this->article->type = 'tweet';
        $this->article->contributor = 'Bruno Falcao';
        $this->article->displayed_author = 'Bruno Falcao';
    }
}
