<?php

use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;

class UpdateLaraflashSchema013 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::where('name', 'Bruno Falcao Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=brunocfalcao&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Taylor Otwell Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=taylorotwell&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Laravel Php Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=laravelphp&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Laravel News Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=laravelnews&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Daily Laravel Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=DailyLaravel&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Caleb Porzio Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=calebporzio&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Nuno Maduro Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=enunomaduro&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);

        DataSource::where('name', 'Nuno Maduro Tweets')
                  ->update(['feed_url' => 'https://rssbridge.waygou.com/?action=display&bridge=Twitter&context=By+username&u=enunomaduro&norep=on&noretweet=on&nopic=on&noimg=on&noimgscaling=on&format=Atom']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
