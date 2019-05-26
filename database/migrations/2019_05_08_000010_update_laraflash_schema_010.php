<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\CategoryMap;

class UpdateLaraflashSchema010 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::create(['name' => 'Asked.io',
                            'description' => 'Asked IO by Will Bowman',
                            'website_url' => 'https://medium.com/asked-io',
                            'feed_url' => 'https://medium.com/asked-io?format=json',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MediumAskedIoCrawler']);

        DataSource::create(['name' => 'Michael Brooks Blog',
                            'description' => 'Newton Abbot Website Developer',
                            'website_url' => 'https://michaelbrooks.co.uk/',
                            'feed_url' => 'https://michaelbrooks.co.uk/feed/',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MichaelBrooksCrawler']);

        DataSource::create(['name' => 'Pascal Baljet Blog',
                            'description' => 'Blogposts about PHP, Laravel and other development topics',
                            'website_url' => 'https://pascalbaljetmedia.com/en/blog',
                            'feed_url' => 'https://pascalbaljetmedia.com/rss',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\PascalBaljetCrawler']);

        DataSource::create(['name' => 'Sebastian De Deyne Blog',
                            'description' => 'Sebastian De Deyne Blog',
                            'website_url' => 'https://sebastiandedeyne.com/posts',
                            'feed_url' => 'https://sebastiandedeyne.com/feed',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\SebastianDeDeyneCrawler']);

        DataSource::create(['name' => 'Ondrej Mirtes Medium',
                            'description' => 'Ontrej Mirtes (Medium)',
                            'website_url' => 'https://medium.com/@ondrejmirtes/latest',
                            'feed_url' => 'https://medium.com/@ondrejmirtes/latest?format=json',
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MediumOndrejMirtesCrawler']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DataSource::where('name', 'Asked.io')->forceDelete();
        DataSource::where('name', 'Michael Brooks Blog')->forceDelete();
        DataSource::where('name', 'Pascal Baljet Blog')->forceDelete();
        DataSource::where('name', 'Sebastian De Deyne Blog')->forceDelete();
        DataSource::where('name', 'Ondrej Mirtes Medium')->forceDelete();
    }
}
