<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\CategoryMap;

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
                            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\FiveBalloonsCrawler']);
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
