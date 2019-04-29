<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('man_id')->comment('漫画ID');
            $table->string('title')->comment('标题');
            $table->json('chapter')->comment('章节');
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
        Schema::dropIfExists('man_list');
    }
}
