<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Models\DataSource;
use Laraflash\DAL\Abstracts\MediumCrawler;

class MediumOndrejMirtesCrawler extends MediumCrawler
{
    public function validate($item)
    {
        // Continue only if news id doesn't exist and laravel appears on title or description.
        return ! Article::where('uid', $this->uid($item))
                            ->where('data_source_id', $this->source->id)
                            ->exists() && (strpos(strtolower($item->title), 'laravel') !== false ||
                                           strpos(strtolower(optional($item->content)->subtitle), 'laravel') !== false);
    }

    public function __construct(DataSource $source)
    {
        parent::__construct($source);
        $this->url = $source->feed_url;
    }
}
