<?php

use Laraflash\DAL\Models\CategoryMap;
use Illuminate\Database\Migrations\Migration;

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
