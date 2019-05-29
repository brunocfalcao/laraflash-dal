<?php

use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;

class UpdateLaraflashSchema011 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::create(['name' => 'Alfred Nutile Blog',
                            'description' => 'Laravel, Angular practical solutions',
                            'website_url' => 'https://alfrednutile.info',
                            'feed_url' => 'https://alfrednutile.info/rss',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\AlfredNutileCrawler', ]);

        DataSource::create(['name' => 'Simon Archer Blog',
                            'description' => 'Manchester-based Freelance and Contract Web Developer',
                            'website_url' => 'https://www.archybold.com',
                            'feed_url' => 'http://www.archybold.com/rss.xml',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\SimonArcherCrawler', ]);

        DataSource::create(['name' => 'Christoph Rumpel Blog',
                            'description' => 'Manchester-based Freelance and Contract Web Developer',
                            'website_url' => 'https://christoph-rumpel.com',
                            'feed_url' => 'https://christoph-rumpel.com/feed',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\ChristophRumpelCrawler', ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DataSource::where('name', 'Alfred Nutile Blog')->forceDelete();
        DataSource::where('name', 'Simon Archer Blog')->forceDelete();
        DataSource::where('name', 'Christoph Rumpel Blog')->forceDelete();
    }
}
