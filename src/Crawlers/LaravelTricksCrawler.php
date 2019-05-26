<?php

namespace Laraflash\DAL\Crawlers;

use Laraflash\DAL\Abstracts\RssCrawler;

class LaravelTricksCrawler extends RssCrawler
{
    public function parse($item)
    {
        parent::parse($item);
        //posted_at = <id>tag:laravel-tricks.com,2018-02-27...</id>
        $this->article->posted_at = explode(',', explode(':', $item->get_id())[1])[1];
        $this->article->category = 'tricks';
        $this->article->displayed_author = $this->source->name;
        $this->article->contributor = $this->source->name; // Improve later.
    }
}
