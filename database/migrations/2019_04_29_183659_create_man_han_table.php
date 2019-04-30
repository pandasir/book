<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManHanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('man_id')->comment('漫画ID');
            $table->tinyInteger('platform_id')->comment('平台ID');
            $table->string('url')->comment('漫画地址');
            $table->json('chapter_url')->comment('章节URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('man_han');
    }
}
