<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\CategoryMap;

class UpdateLaraflashSchema008 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CategoryMap::where('feed_category', 'cloudflare')
                   ->update(['article_category' => 'Others']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CategoryMap::where(' feed_category', 'cloudflare')->forceDelete();
    }
}
