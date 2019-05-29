<?php

use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;

class UpdateLaraflashSchema007 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::create(['name' => 'Laravel Links Tweets',
                                      'description' => 'Laravel Links Tweets',
                                      'website_url' => 'https://twitter.com/LaravelLinks',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=LaravelLinks&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsLaravelLinksCrawler', ]);

        DataSource::create(['name' => 'Laravel Portugal Tweets',
                                      'description' => 'Laravel Portugal Tweets',
                                      'website_url' => 'https://twitter.com/LaravelPortugal',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=LaravelPortugal&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsLaravelPortugalCrawler', ]);

        DataSource::create(['name' => 'Laravel Zero Tweets',
                                      'description' => 'Laravel Zero Tweets',
                                      'website_url' => 'https://twitter.com/LaravelZero',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=LaravelZero&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsLaravelZeroCrawler', ]);

        DataSource::create(['name' => 'Joseph Silber Tweets',
                                      'description' => 'Joseph Silber Tweets',
                                      'website_url' => 'https://twitter.com/joseph_silber',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=joseph_silber&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsJosephSilberCrawler', ]);

        DataSource::create(['name' => 'Paul Redmond Tweets',
                                      'description' => 'Paul Redmond Tweets',
                                      'website_url' => 'https://twitter.com/paulredmond',
                                      'feed_url' => 'http://rssbridge.waygou.com/?action=display&bridge=Twitter&u=paulredmond&norep=on&noretweet=on&format=Atom',
                                      'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\TweetsPaulRedmondCrawler', ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DataSource::whereIn('name', ['Laravel Links Tweets',
                                     'Paul Redmond Tweets',
                                     'Joseph Silber Tweets',
                                     'Laravel Zero Tweets',
                                     'Laravel Portugal Tweets', ])
                  ->delete();
    }
}
