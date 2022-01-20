<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContentDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->references('id')->on('content');
            $table->tinyInteger('section', false, true);
            $table->string('thumbnail');
            $table->string('video_url');
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
        Schema::dropIfExists('table_content_detail');
    }
}
