<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
             $table->bigIncrements('id');
        $table->string('title');
       $table->bigInteger('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users');
        $table->date('post_date')->nullable();
        $table->boolean('published')->default(0);
        $table->text('content')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
