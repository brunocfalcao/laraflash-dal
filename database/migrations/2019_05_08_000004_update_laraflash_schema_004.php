<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Laraflash\DAL\Models\DataSource;
use Illuminate\Database\Migrations\Migration;
use Laraflash\DAL\Models\CategoryMap;
use Laraflash\DAL\Models\CategoryPosition;

class UpdateLaraflashSchema004 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');

            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'MyISAM';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('newsletters');
    }
}
