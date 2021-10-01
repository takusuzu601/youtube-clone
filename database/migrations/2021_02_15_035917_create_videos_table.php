<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('channel_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('uid');
            $table->string('thumbnail_image')->nullable();
            $table->text('path')->nullable();
            $table->string('proccessed_file')->nullable();
            $table->enum('visibility', ['private', 'public', 'unslited'])->default('private');

            $table->boolean('processed')->default(false);
            $table->boolean('allow_likes')->default(false);
            $table->boolean('allow_comments')->default(false);

            $table->string('processing_percentage')->default(false);

            $table->foreign('channel_id')->references('id')->on('channels')
                ->onDelete('cascade');


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
        Schema::dropIfExists('videos');
    }
}
