<?php

use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\DataSource;

class UpdateLaraflashSchema009 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::create(['name' => '5 Balloons',
            'description' => '5 Balloons',
            'website_url' => 'http://www.5balloons.info/',
            'feed_url' => 'http://www.5balloons.info/feed/',
            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\FiveBalloonsCrawler', ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DataSource::where('name', '5 Balloons')->forceDelete();
    }
}
