<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblRevenue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_revenue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('account', 10, 2)->nullable();
            $table->float('franch', 10, 2)->nullable();
            $table->float('inex', 10, 2)->nullable();
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
        Schema::dropIfExists('tbl_revenue');
    }
}
