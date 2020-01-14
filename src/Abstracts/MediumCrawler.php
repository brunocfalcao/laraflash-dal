<?php

namespace Laraflash\DAL\Abstracts;

use Illuminate\Support\Carbon;
use Laraflash\DAL\Models\Article;
use Zttp\Zttp;

class MediumCrawler extends Crawler
{
    public function start($item)
    {
        parent::start($item);
    }

    public function crawl()
    {
        // Compute the crawl feed url (by date.
        if (isset($this->date) && is_null($this->url)) {
            $this->date = new Carbon($this->date);
            [$day, $month, $year] = [$this->date->format('d'), $this->date->format('m'), $this->date->format('Y')];
            $this->url = "https://medium.com/tag/laravel/archive/{$year}/{$month}/{$day}?format=json";
        }

        $this->log('Crawl started');
        $this->log($this->url);
        $response = Zttp::get($this->url);
        // Remove the first 17 chars (Medium Json security reasons).
        $json = json_decode(substr($response->body(), 16));
        if (! is_null($json)) {
            $this->references = isset(optional($json->payload)->references) ? $json->payload->references : $json->references;
            $this->items = collect($this->references->Post);
        } else {
            $this->log('No crawable items found.');
            $this->items = collect();
            $this->references = null;
        }
    }

    public function thumbnail($item)
    {
        /*
         * Computed thumbnail.
         * 1. We try to find a thumbnail in the article (first image).
         * 2. Not found, then we grab the thumbnail from the user.
         * 3. Computes the $this->sanitized->thumbnail.
         */
        $this->sanitized->thumbnail = $this->fetchBlogImage($this->sanitized->url);
        if (is_null($this->sanitized->thumbnail)) {
            $this->sanitized->thumbnail = 'https://miro.medium.com/fit/c/240/240/'.
                                          $this->references->User->{$item->creatorId}->imageId;
        }
    }

    public function fetchBlogImage($url)
    {
        try {
            $htmlDom = file_get_html($url);
        } catch (\Exception $e) {
            $this->log('Non-blocking error fetching url '.$url, $e);

            return;
        }

        return rescue(function () use ($htmlDom) {
            return $htmlDom->find('img.graf-image', 0)->getAttribute('src');
        });
    }

    public function sanitize($item)
    {
        $this->sanitized->url = 'https://medium.com/@'.
                                $this->references->User->{$item->creatorId}->username.
                                '/'.
                                $item->uniqueSlug;

        $this->sanitized->contributor = $this->references
                                             ->User
                                             ->{$item->creatorId}
                                             ->name;

        $this->sanitized->posted_at = date('Y-m-d H:i:s', $item->createdAt / 1000);

        // Sanitize fields.
        $this->sanitized->title = $this->sanitizeField($item->title);
        $this->sanitized->subtitle = $this->sanitizeField(optional($item->content)->subtitle);
    }

    public function uid($item)
    {
        return $item->id;
    }

    public function parse($item)
    {
        $this->article = new Article();
        $this->article->uid = $this->uid($item);
        $this->article->data_source_id = $this->source->id;
        $this->article->title = $this->sanitized->title;
        $this->article->subtitle = $this->sanitized->subtitle;
        $this->article->type = 'blog';
        $this->article->category = 'blog'; // To be improved later -- dynamic.
        $this->article->website = 'Medium';
        $this->article->contributor = $this->sanitized->contributor;
        $this->article->url_contributor = 'https://medium.com/@'.$this->references->User->{$item->creatorId}->username;
        $this->article->displayed_author = $this->sanitized->contributor;
        $this->article->url = $this->sanitized->url;
        $this->article->posted_at = $this->sanitized->posted_at;
        $this->article->feed_type = 'medium/json';
    }

    public function validate($item)
    {
        // Continue only if news id doesn't exist.
        return ! Article::where('uid', $item->id)->exists();
    }
}
