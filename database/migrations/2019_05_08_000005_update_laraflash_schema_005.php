<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laraflash\DAL\Models\Article;
use Laraflash\DAL\Models\CategoryMap;

class UpdateLaraflashSchema005 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CategoryMap::where('feed_category', 'books')
                   ->update(['article_category' => 'Tutorial']);

        CategoryMap::where('feed_category', 'jquery')
                   ->update(['article_category' => 'Blog']);

        CategoryMap::where('feed_category', 'bootstrap')
                   ->update(['article_category' => 'Blog']);

        CategoryMap::where('feed_category', 'javascript')
                   ->update(['article_category' => 'Blog']);

        Schema::table('articles', function (Blueprint $table) {
            $table->string('category_mapped')
                  ->default('Blog')
                  ->after('category');
        });

        // Update all category_mapped articles.
        Article::all()->each(function ($article, $key) {
            $article->category_mapped = CategoryMap::where('feed_category', $article->category)
                                                       ->first()
                                                       ->article_category;
            $article->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('category_mapped');
        });

        DB::raw("delete from category_maps where feed_category in ('books',
                                                                   'jquery',
                                                                   'bootstrap',
                                                                   'javascript')");
    }
}
