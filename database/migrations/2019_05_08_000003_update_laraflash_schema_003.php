<?php

use Illuminate\Support\Facades\DB;
use Laraflash\DAL\Models\DataSource;
use Laraflash\DAL\Models\CategoryMap;
use Laraflash\DAL\Models\CategoryPosition;
use Illuminate\Database\Migrations\Migration;

class UpdateLaraflashSchema003 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CategoryMap::create(['feed_category' => 'tweet',
                             'article_category' => 'Tweet', ]);

        CategoryMap::create(['feed_category' => 'main thread',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'git',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'investing',
                             'article_category' => 'Others', ]);

        CategoryMap::create(['feed_category' => 'heroku',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'database',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'deployment',
                             'article_category' => 'Blog', ]);

        CategoryMap::create(['feed_category' => 'laravel',
                             'article_category' => 'Blog', ]);

        CategoryPosition::create(['article_category' => 'Tweet',
                                  'navbar_position' => 50,
                                  'square_position' => 50, ]);

        DataSource::create(['name' => 'Michael Dyrynda',
                            'description' => 'Michael Dyrynda blog',
                            'website_url' => 'https://dyrynda.com.au/',
                            'feed_url' => 'https://dyrynda.com.au/blog/feed',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MichaelDyryndaCrawler', ]);

        DataSource::create(['name' => 'Jason McCreary',
                            'description' => 'Jason McCreary blog',
                            'website_url' => 'https://jason.pureconcepts.net/',
                            'feed_url' => 'https://jason.pureconcepts.net/feed.xml',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\JasonMcCrearyCrawler', ]);

        DataSource::create(['name' => 'Mika Teach',
                            'description' => 'Mika Teach blog',
                            'website_url' => 'https://mikateach.com/',
                            'feed_url' => 'https://mikateach.com/feed/',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MikaTeachCrawler', ]);

        DataSource::create(['name' => 'Chris Fidao',
                            'description' => 'Chris Fidao blog',
                            'website_url' => 'http://fideloper.com',
                            'feed_url' => 'http://fideloper.com/feed',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\FideloperCrawler', ]);

        DataSource::create(['name' => 'Ben Sampson',
                            'description' => 'Ben Sampson blog',
                            'website_url' => 'http://https://sampo.co.uk',
                            'feed_url' => 'https://sampo.co.uk/blog/feed',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\BenSampsonCrawler', ]);

        DataSource::create(['name' => 'Dayle Rees',
                            'description' => 'Dayle Rees blog',
                            'website_url' => 'https://www.daylerees.com',
                            'feed_url' => 'https://www.daylerees.com/rss/',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\DayleReesCrawler', ]);

        DataSource::create(['name' => 'Alex Vanderbist',
                            'description' => 'Alexander Vanderbist blog',
                            'website_url' => 'https://alexvanderbist.com',
                            'feed_url' => 'https://alexvanderbist.com/feed',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\AlexVanderbistCrawler', ]);

        DataSource::create(['name' => 'Scoopism',
                            'description' => 'Your daily dose of inspiration',
                            'website_url' => 'https://www.scoopism.com/category/laravel/',
                            'feed_url' => 'https://www.scoopism.com/category/laravel/feed/',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\ScoopismCrawler', ]);

        DataSource::create(['name' => 'The Web Tier',
                            'description' => 'Helps you with your gains about Web Technologies and Hacks',
                            'website_url' => 'https://thewebtier.com/category/laravel',
                            'feed_url' => 'https://thewebtier.com/category/laravel/feed/',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TheWebTierCrawler', ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::raw("delete from category_positions where article_category = 'Tweet'");
        DB::raw("delete from category_maps where feed_category in ('tweet',
                                                                   'main thread',
                                                                   'git',
                                                                   'investing',
                                                                   'heroku',
                                                                   'database',
                                                                   'deployment',
                                                                   'laravel')");

        DB::raw("delete from data_sources where name = 'Michael Dyrynda'");
        DB::raw("delete from data_sources where name = 'Jason McCreary'");
        DB::raw("delete from data_sources where name = 'Mika Teach'");
        DB::raw("delete from data_sources where name = 'Chris Fidao'");
    }
}
