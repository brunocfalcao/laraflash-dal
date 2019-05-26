<?php

namespace Laraflash\DAL\Abstracts;

use Zttp\Zttp;
use \Exception;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Laraflash\DAL\Models\Thumbnail;
use Laraflash\DAL\Models\CrawlerLog;
use Laraflash\DAL\Models\DataSource;
use Laraflash\DAL\Models\CategoryMap;
use Laraflash\DAL\Contracts\Crawlable;

abstract class Crawler implements Crawlable
{
    protected $references; // Medium json payload references.
    protected $sanitized; // Items sanitized, to be used in the parse().
    protected $article; // Current Article model.
    protected $thumbnail; // Possible Thumbnail model.
    protected $process_uid; // The Crawler process uid.
    protected $source; // The data source model.
    protected $error; // Latest crawl error.
    public $date; // Possible customized date before starting crawling.
    public $url; // Url to crawl.

    function __construct(DataSource $source)
    {
        $this->sanitized = new \StdClass;
        $this->source = $source;
        $this->log = new CrawlerLog();
        $this->process_uid = str_random(10);
        $this->url = $this->source->feed_url;
        $this->error = new \StdClass();
    }

    public function process()
    {
        try {
            $this->crawl();
        /**
         * Each crawl process passes by the following steps:
         *
         * reset()
         * Resets model and sanitization variables.
         *
         * sanitize()
         * Sanitizes the default medium items (trims, remove emoticons, etc.).
         *
         * thumbnail()
         * Transforms any data into a thumbnail on the $item->sanitized->thumbnail string.
         *
         * parse()
         * Maps the Medium fields to the Article model.
         *
         * validate()
         * Applies validations to continue or not.
         *
         * backup()
         * Saves the raw medium feed in the medium_feed_crawls table.
         *
         * prepare()
         * Prepares assets before inserting the article (e.g. fetches thumbnail).
         *
         * insert()
         * Inserts the new article in the articles table.
         *
         * complete()
         * Finalizes other relations if needed (E.g. associates article id with thumbnail).
         *
         * error()
         * After a succesfull crawl of all items, we run this method.
         *
         * finish()
         * After a succesfull crawl of all items, we run this method.
         *
         */
            if ($this->items->count() > 0) {
                $this->items->each(function ($item, $key) {
                    $this->start($item);
                    $this->sanitize($item);
                    $this->parse($item);
                    if ($this->validate($item)) {
                        $this->thumbnail($item);
                        $this->prepare();
                        $this->insert();
                        $this->complete();
                    };
                });
            };
            $this->finish();
        } catch (\Exception $e) {
            $this->error($e);
        }
    }

    public function start($item)
    {
        $this->article = null;
        $this->thumbnail = null;
        $this->sanitized = new \StdClass;
    }

    public function thumbnail($item)
    {
    }

    public function sanitizeField($value, $default = null)
    {
        if (blank($value)) {
            return $default;
        }

        return substr(htmlspecialchars_decode(trim(remove_emoji($value)), ENT_QUOTES), 0, 255);
    }

    function prepare()
    {
        // Default image association, in case there is a sanitized thumbnail item.
        // $this->sanitized->thumbnail must be a string: E.g. "http://...?profile.jpg".
        if (!empty($this->sanitized->thumbnail) && !is_null($this->sanitized->thumbnail)) {
            // Thumbnail already exists? Then just get Thumbnail model.
            if (Thumbnail::where('url', $this->sanitized->thumbnail)->exists()) {
                $this->thumbnail = Thumbnail::where('url', $this->sanitized->thumbnail)->first();
            } else {
                // Thumbnail don't exist.
                // Fetch thumbnail from $this->sanitized->thumbnail and save it in the database.
                try {
                    $response = Zttp::get($this->sanitized->thumbnail);
                    if ($response->status() == 200) {
                        $extension = substr($this->sanitized->thumbnail, strrpos($this->sanitized->thumbnail, ".") + 1);
                        if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'gif', 'png'])) {
                            //Undiscoverable extension. Let's encode it as JPEG.
                            $image = Image::make($response->body())->stream('jpg', 100);
                            $extension = 'jpg';
                        } else {
                            $image = $response->body();
                        };

                        // Grab image ->body().
                        $thumbnail = $image;
                        $hash = strtolower(str_random(10));
                        // Save image in the rss feed filename path.
                        if (!File::exists(storage_path('app/public/images/'))) {
                            File::makeDirectory(storage_path('app/public/images/'));
                        };

                        $saved = File::put(storage_path("app/public/images/{$hash}.{$extension}"), $thumbnail);
                        if ($saved) {
                            // Insert a new image.
                            $this->thumbnail = new Thumbnail();
                            $this->thumbnail->url = $this->sanitized->thumbnail;
                            $this->thumbnail->hash = $hash;
                            $this->thumbnail->filename = "{$hash}.{$extension}";
                            $this->thumbnail->save();
                        };
                    };
                } catch (\Exception $e) {
                    $this->log('Non-blocking error saving thumbnail', $e);
                };
            };
        };
    }

    function insert()
    {
        // Thumbnail exists? Get id.
        if ($this->thumbnail instanceof \Laraflash\DAL\Models\Thumbnail) {
            $this->article->thumbnail_id = $this->thumbnail->id;
        };

        // Compute the category mapped attribute.
        $this->article->category_mapped = optional(CategoryMap::where('feed_category', $this->article->category)
                                                              ->first())
                                                              ->article_category;

        if (is_null($this->article->category_mapped)) {
            $this->article->category_mapped = 'unknown';
        };

        $this->article->save();
    }

    function complete()
    {
        // Verify if this category exists in category mappings. If not, insert it.
        if (!is_null($this->article->category)) {
            if (!CategoryMap::where('feed_category', strtolower($this->article->category))->exists()) {
                CategoryMap::create(['feed_category' => strtolower($this->article->category)]);
            };
        };

        $this->log('Article inserted with id ' . $this->article->id);
    }

    function log(string $message, \Exception $e = null)
    {
        if (isset($e)) {
            $error_message = $e->getMessage();
            $status = $e->getCode();
            $trace = $e->getTraceAsString();
        };

        $this->log::create(['uid' => $this->process_uid,
                            'data_source_id' => $this->source->id,
                            'friendly_message' => $message,
                            'error_message' => $error_message ?? null,
                            'status' => $status ?? 'ok',
                            'trace' => $trace ?? null
        ]);
    }

    public function finish()
    {
        // Update data source last crawl at.
        $this->source->last_crawl_at = date('Y-m-d H:i:s');
        $this->source->save();
        $this->log('Crawl ended.');
    }

    function error(\Exception $e)
    {
        $this->log('Error!', $e);
    }
}
