<?php

use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\DataSource;

class UpdateLaraflashSchema006 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::create(['name' => 'Taylor Otwell Medium',
            'description' => 'Taylor Otwell (Medium)',
            'website_url' => 'https://medium.com/@taylorotwell/latest',
            'feed_url' => 'https://medium.com/@taylorotwell/latest?format=json',
            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MediumTaylorOtwellCrawler', ]);

        DataSource::create(['name' => 'Freek Van der Herten Medium',
            'description' => 'Freek Murze (Medium)',
            'website_url' => 'https://medium.com/@freekmurze/latest',
            'feed_url' => 'https://medium.com/@freekmurze/latest?format=json',
            'crawler_class' => '\\Laraflash\\DAL\\Crawlers\\MediumFreekMurzeCrawler', ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DataSource::where('name', 'Taylor Otwell Medium')
                  ->delete();
    }
}
