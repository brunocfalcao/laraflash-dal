<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laraflash\DAL\Models\CategoryMap;
use Laraflash\DAL\Models\CategoryPosition;
use Laraflash\DAL\Models\DataSource;

class UpdateLaraflashSchema001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->comment('Data Source brand name.');

            $table->text('description')
                  ->nullable();

            $table->string('website_url')
                  ->nullable();

            $table->string('feed_url')
                  ->unique();

            $table->string('crawl_interval')
                  ->default('everyThirtyMinutes')
                  ->comment('Values like the ones in the Laravel scheduled task values.');

            $table->string('crawler_class');
            $table->datetime('last_crawl_at')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        Schema::create('crawler_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid');
            $table->integer('data_source_id');
            $table->text('error_message')
                  ->nullable();

            $table->text('friendly_message')
                  ->nullable();

            $table->string('status');
            $table->text('trace')
                  ->nullable();

            $table->string('line')
                  ->nullable();

            $table->string('filename')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')
                  ->comment('The unique id from the content source.');

            $table->integer('data_source_id');

            $table->string('title');
            $table->text('subtitle')
                  ->nullable();

            $table->string('type')
                  ->comment('video, tweet, blog, etc.');

            $table->string('category')
                  ->nullable()
                  ->comment('tutorial, tricks, blog, interview, podcast, etc.');

            $table->string('website')
                  ->comment('Medium, Laraning, Laravel News, Laracasts, etc.');

            $table->string('contributor')
                  ->comment('The real user name that wrote the article.');

            $table->string('displayed_author')
                  ->comment('The displayed author in the webpage. Some cases can be the website, others the author.');

            $table->integer('thumbnail_id')
                  ->nullable();

            $table->string('url');

            $table->string('url_contributor')
                  ->nullable()
                  ->comment('Sometimes we want to point instead of the article data source website to the contributor page, E.g. Medium contributor.');

            $table->datetime('posted_at')
                  ->comment('The computed posted at given the feed source.');

            $table->string('feed_type')
                  ->comment('medium/json, atom/rss, twitter/api, etc.');

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        Schema::create('category_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('feed_category');
            $table->string('article_category')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        Schema::create('thumbnails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('filename');
            $table->string('hash');

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        Schema::create('category_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('article_category');
            $table->integer('navbar_position')
                  ->nullable();

            $table->integer('square_position')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });

        // Data seed.
        CategoryPosition::create(['article_category' => 'Other',
                                  'navbar_position' => 99,
                                  'square_position' => 99, ]);

        CategoryPosition::create(['article_category' => 'Podcast',
                                  'navbar_position' => 90,
                                  'square_position' => 90, ]);

        CategoryPosition::create(['article_category' => 'Blog',
                                  'navbar_position' => 10,
                                  'square_position' => 10, ]);

        CategoryPosition::create(['article_category' => 'Interview',
                                  'navbar_position' => 70,
                                  'square_position' => 70, ]);

        CategoryPosition::create(['article_category' => 'Tutorial',
                                  'navbar_position' => 20,
                                  'square_position' => 20, ]);

        CategoryPosition::create(['article_category' => 'Job',
                                  'navbar_position' => 50,
                                  'square_position' => 50, ]);

        CategoryPosition::create(['article_category' => 'Package',
                                  'navbar_position' => 40,
                                  'square_position' => 40, ]);

        CategoryPosition::create(['article_category' => 'Tips & Tricks',
                                  'navbar_position' => 30,
                                  'square_position' => 30, ]);

        CategoryMap::create(['feed_category' => 'life',
                             'article_category' => 'Other', ]);

        CategoryMap::create(['feed_category' => 'podcast',
                             'article_category' => 'Podcast', ]);

        CategoryMap::create(['feed_category' => 'laravel business',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'interviews',
                             'article_category' => 'Interview', ]);

        CategoryMap::create(['feed_category' => 'featured',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'programming',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'web development',
                            'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'Learn Laravel Tutorials, Tips And Guides',
                            'article_category' => 'Tutorial', ]);

        CategoryMap::create(['feed_category' => 'Job',
                            'article_category' => 'Job', ]);

        CategoryMap::create(['feed_category' => 'Laravel Tech',
                            'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'Laravel Packages',
                            'article_category' => 'Package', ]);

        CategoryMap::create(['feed_category' => 'blog',
                            'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'tutorials',
                            'article_category' => 'Tutorial', ]);

        CategoryMap::create(['feed_category' => 'news',
                            'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'tricks',
                            'article_category' => 'Tips & Tricks', ]);

        CategoryMap::create(['feed_category' => 'tutorial',
                            'article_category' => 'Tutorial', ]);

        CategoryMap::create(['feed_category' => 'package',
                            'article_category' => 'Package', ]);

        CategoryMap::create(['feed_category' => 'other',
                            'article_category' => 'Other', ]);

        CategoryMap::create(['feed_category' => 'tips & tricks',
                            'article_category' => 'Tips & Tricks', ]);

        CategoryMap::create(['feed_category' => 'interview',
                            'article_category' => 'Interview', ]);

        // Load primary data sources.
        DataSource::create(['name' => 'Laraning',
                                      'description' => 'Laraning - You don\'t need to be an expert to learn Laravel!',
                                      'website_url' => 'https://www.laraning.com',
                                      'feed_url' => 'https://www.laraning.com/feed',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaraningCrawler', ]);

        DataSource::create(['name' => 'Laracasts',
                                      'description' => 'Laracasts - It\'s kinda like Netflix for your Career!',
                                      'website_url' => 'htps://www.laracasts.com',
                                      'feed_url' => 'https://laracasts.com/feed',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaracastsCrawler', ]);

        DataSource::create(['name' => 'Laravel News',
                                      'description' => 'The official Laravel News source',
                                      'website_url' => 'https://www.laravel-news.com',
                                      'feed_url' => 'https://feed.laravel-news.com/',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaravelNewsCrawler', ]);

        DataSource::create(['name' => 'Laravel Daily',
                                      'description' => 'Laravel Solutions for your Business',
                                      'website_url' => 'http://laraveldaily.com',
                                      'feed_url' => 'http://laraveldaily.com/feed/',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaravelDailyCrawler', ]);

        DataSource::create(['name' => 'Murze.be',
                                      'description' => 'A blog on Laravel and PHP from Freek Van der Herten',
                                      'website_url' => 'http://murze.be',
                                      'feed_url' => 'https://murze.be/feed',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MurzeCrawler', ]);

        DataSource::create(['name' => 'LaraJobs',
                                      'description' => 'The Artisan Employment Connection',
                                      'website_url' => 'https://larajobs.com',
                                      'feed_url' => 'https://larajobs.com/feed',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaraJobsCrawler', ]);

        DataSource::create(['name' => 'Matt Stauffer Blog',
                                      'description' => 'Partner at Tighten',
                                      'website_url' => 'http://mattstauffer.com',
                                      'feed_url' => 'https://mattstauffer.com/blog/feed.atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MattStaufferBlogCrawler', ]);

        DataSource::create(['name' => 'Vegibit',
                                      'description' => 'Technology and Development website that offers detailed tutorials, inspiration, tips and tricks for Professionals in the Technology Space',
                                      'website_url' => 'http://vegibit.com/tag/laravel',
                                      'feed_url' => 'https://vegibit.com/tag/laravel/feed/',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\VegibitCrawler', ]);

        DataSource::create(['name' => 'Eric L Barnes',
                                      'description' => 'Journal & Notebook',
                                      'website_url' => 'https://ericlbarnes.com/tag/laravel/',
                                      'feed_url' => 'https://ericlbarnes.com/tag/laravel/feed/',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\EricBarnesCrawler', ]);

        DataSource::create(['name' => 'Neon Tsunami',
                                      'description' => 'A Blog on Laravel & Rails',
                                      'website_url' => 'https://www.neontsunami.com/tags/laravel',
                                      'feed_url' => 'https://www.neontsunami.com/rss',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\NeonTsunamiCrawler', ]);

        DataSource::create(['name' => 'Laravel Tricks',
                                      'description' => 'Laravel tricks, from Tighten',
                                      'website_url' => 'https://laravel-tricks.com',
                                      'feed_url' => 'https://laravel-tricks.com/feed',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaravelTricksCrawler', ]);

        DataSource::create(['name' => 'Cloudways',
                                      'description' => 'Laravel Tips and Tricks',
                                      'website_url' => 'https://www.cloudways.com/blog/laravel/',
                                      'feed_url' => 'https://www.cloudways.com/blog/laravel/feed/',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\CloudwaysCrawler', ]);

        DataSource::create(['name' => 'Larastream',
                                      'description' => 'Larastream - Like Twitch, but for Laravel. ',
                                      'website_url' => 'https://www.larastream.com',
                                      'feed_url' => 'https://www.larastream.com/feed',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LarastreamCrawler', ]);

        DataSource::create(['name' => 'Full Stack Radio',
                                      'description' => 'Full Stack Radio, by Adam Wathan',
                                      'website_url' => 'http://www.fullstackradio.com/',
                                      'feed_url' => 'https://rss.simplecast.com/podcasts/279/rss',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\FullStackRadioPodcastCrawler', ]);

        DataSource::create(['name' => 'Laracasts Snippets',
                                      'description' => 'Laracasts snippets by Jeffrey Way',
                                      'website_url' => 'https://laracasts.simplecast.fm/',
                                      'feed_url' => 'https://rss.simplecast.com/podcasts/1486/rss',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaracastsPodcastCrawler', ]);

        DataSource::create(['name' => 'Laravel Podcast',
                                      'description' => 'Official Laravel Podcasts',
                                      'website_url' => 'http://www.laravelpodcast.com/',
                                      'feed_url' => 'https://rss.simplecast.com/podcasts/3894/rss',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaravelPodcastCrawler', ]);

        DataSource::create(['name' => 'Laravel Portugal Podcast',
                                      'description' => 'Official Laravel Portugal Podcast',
                                      'website_url' => 'http://www.laravel.pt/',
                                      'feed_url' => 'https://rss.simplecast.com/podcasts/4397/rss',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\LaravelPortugalPodcastCrawler', ]);

        DataSource::create(['name' => 'North Meets South Podcast',
                                      'description' => 'Jacob Bennett and Michael Dyrynda conquer a 14.5 hour time difference to talk about life as web developers',
                                      'website_url' => 'http://www.northmeetssouth.audio/',
                                      'feed_url' => 'https://rss.simplecast.com/podcasts/2072/rss',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\NorthMeetsSouthPodcastCrawler', ]);

        DataSource::create(['name' => 'Medium',
                                      'description' => 'Laravel Medium blogs',
                                      'website_url' => 'https://medium.com/tag/laravel/',
                                      'feed_url' => 'https://medium.com/tag/laravel/latest?format=json',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MediumJsonCrawler', ]);

        DataSource::create(['name' => 'Taylor Otwell Tweets',
                                      'description' => 'Taylor Otwell Tweets',
                                      'website_url' => 'https://twitter.com/taylorotwell',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=taylorotwell&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsTaylorOtwellCrawler', ]);

        DataSource::create(['name' => 'Laravel Php Tweets',
                                      'description' => 'Laravel PHP Tweets',
                                      'website_url' => 'https://twitter.com/laravelphp',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=laravelphp&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsLaravelPhpCrawler', ]);

        DataSource::create(['name' => 'Laravel News Tweets',
                                      'description' => 'Laravel News Tweets',
                                      'website_url' => 'https://twitter.com/laravelnews',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=laravelnews&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsLaravelNewsCrawler', ]);

        DataSource::create(['name' => 'Daily Laravel Tweets',
                                      'description' => 'Daily Laravel Tweets',
                                      'website_url' => 'https://twitter.com/dailylaravel',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=dailylaravel&norep=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsDailyLaravelCrawler', ]);

        DataSource::create(['name' => 'Caleb Porzio Tweets',
                                      'description' => 'Caleb Porzio Tweets',
                                      'website_url' => 'https://twitter.com/dailylaravel',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=calebporzio&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsCalebPorzioCrawler', ]);

        DataSource::create(['name' => 'Nuno Maduro Tweets',
                                      'description' => 'Nuno Maduro Tweets',
                                      'website_url' => 'https://twitter.com/enunomaduro',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=enunomaduro&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsNunoMaduroCrawler', ]);

        DataSource::create(['name' => 'Bruno Falcao Tweets',
                                      'description' => 'Bruno Falcao Tweets',
                                      'website_url' => 'https://twitter.com/enunomaduro',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=brunocfalcao&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsBrunoFalcaoCrawler', ]);

        DataSource::create(['name' => 'Freek Murze Tweets',
                                      'description' => 'Freek Murze Tweets',
                                      'website_url' => 'https://twitter.com/freekmurze',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=freekmurze&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsFreekMurzeCrawler', ]);

        // Clean thumbnails.
        File::cleanDirectory(storage_path('app/public/images'));

        // Clear cache.
        File::cleanDirectory(storage_path('app/public/cache'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
        Schema::drop('crawler_logs');
        Schema::drop('data_sources');
        Schema::drop('thumbnails');
        Schema::drop('category_positions');
        Schema::drop('category_maps');
    }
}
