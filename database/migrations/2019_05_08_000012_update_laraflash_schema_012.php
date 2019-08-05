<?php

use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;

class UpdateLaraflashSchema012 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DataSource::where('name', 'Simon Archer Blog')->forceDelete();
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
