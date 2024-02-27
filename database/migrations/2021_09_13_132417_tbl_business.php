<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_business', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('company_name');
            $table->string('address');
            $table->string('name');
            $table->string('suite')->nullable();
            $table->string('phone');
            // $table->string('sub_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('email')->unique();
            $table->string('bill_name')->nullable();
            $table->string('bill_email')->nullable();
            $table->string('bill_phone')->nullable();
            $table->integer('category');
            $table->integer('super')->nullable();
            $table->integer('sales')->nullable();
            $table->integer('graphic')->nullable();
            $table->string('extra')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('tbl_business');
    }
}
