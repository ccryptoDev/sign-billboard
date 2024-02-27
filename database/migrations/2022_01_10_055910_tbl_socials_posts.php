<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblSocialsPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_socials_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_name');
            $table->integer('client_id');
            $table->text('ads');
            $table->text('imgs');
            $table->text('context');
            $table->string('post_date');
            $table->integer('status');
            $table->string('socials');
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
        Schema::dropIfExists('tbl_socials_posts');
    }
}
