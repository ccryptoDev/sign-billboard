<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblBanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('business_type');
            $table->string('company_type')->nullable();
            $table->string('company_name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('phone');
            $table->string('ein');
            $table->string('account_number');
            $table->string('route_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('front')->nullable();
            $table->string('back')->nullable();
            $table->integer('status')->default(0);
            $table->string('extra')->nullable();
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
        Schema::dropIfExists('tbl_banks');
    }
}
