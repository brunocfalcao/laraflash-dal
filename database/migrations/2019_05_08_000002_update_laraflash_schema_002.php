<?php

use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\CategoryMap;

class UpdateLaraflashSchema002 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CategoryMap::whereIn('feed_category', ['php', 'cloudflare', 'uncategorized'])
                   ->update(['article_category' => 'Others']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        CategoryMap::whereIn('feed_category', ['php', 'cloudflare', 'uncategorized'])->forceDelete();
    }
}
