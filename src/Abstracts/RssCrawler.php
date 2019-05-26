<?php

namespace Laraflash\DAL\Abstracts;

use Zttp\Zttp;
use \Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Abstracts\Crawler;
use Laraflash\DAL\Models\CategoryMap;
use willvincent\Feeds\Facades\FeedsFacade as Feeds;

class RssCrawler extends Crawler
{
    public function start($item)
    {
        parent::start($item);
        //$this->log('Computing item - ' . $item->get_title());
    }

    public function crawl()
    {
        $feed = Feeds::make($this->source->feed_url, 10, false);
        $this->items = collect($feed->get_items());

        $this->log('Crawl started.');
        $this->log($this->url);

        if ($this->items->count() == 0) {
            $this->log('No crawable items found.');
            $this->items = collect();
        };
    }

    function sanitize($item)
    {
        $this->sanitized->title = $this->sanitizeField($item->get_title());
        $this->sanitized->url = $this->sanitizeField($item->get_link());
        $this->sanitized->posted_at = (new Carbon($item->get_date()))->toDateTimeString();
        $this->sanitized->content = $this->sanitizeField($item->get_content());
        $this->sanitized->description = $this->sanitizeField($item->get_description());
        $this->sanitized->author = $this->sanitizeField(optional($item->get_author())->get_name());
        // Grab the default category from the rss source, if not then call it blog.
        $this->sanitized->category = $this->sanitizeField(optional($item->get_category())->get_term(), 'blog');
        $this->sanitized->contributor = $this->sanitizeField(optional($item->get_contributor())->get_name());
        $this->sanitized->displayed_author = $this->sanitized->author;
    }

    function uid($item)
    {
        return $item->get_id();
    }

    function parse($item)
    {
        $this->article = new Article();
        $this->article->uid = $this->uid($item);
        $this->article->data_source_id = $this->source->id;
        $this->article->title = $this->sanitized->title;
        $this->article->subtitle = blank($this->sanitized->content) ? null : $this->sanitized->content;
        $this->article->type = 'blog';
        $this->article->category = $this->sanitized->category;
        $this->article->website = $this->source->name;
        $this->article->contributor = blank($this->sanitized->contributor) ? $this->sanitized->author : $this->sanitized->contributor;
        $this->article->displayed_author = $this->sanitized->displayed_author;
        $this->article->url = $this->sanitized->url;
        $this->article->posted_at = $this->sanitized->posted_at;
        $this->article->feed_type = 'atom/rss';
    }

    function validate($item)
    {
        // Continue only if news id doesn't exist.
        return !Article::where('uid', $item->get_id())->exists();
    }
}
