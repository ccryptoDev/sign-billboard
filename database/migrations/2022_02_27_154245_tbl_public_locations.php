<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblPublicLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_public_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location_id')->nullable();
            $table->string('type')->nullable();  // 0: public, 1 : private
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
        Schema::dropIfExists('tbl_public_locations');
    }
}
