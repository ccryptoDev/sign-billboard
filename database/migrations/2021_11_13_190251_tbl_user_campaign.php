<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblUserCampaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_user_campaign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('campaign_name');
            $table->string('start_date');
            $table->integer('weeks');
            $table->integer('end_flag'); // 0 : No End Date, 1 : End Date
            $table->string('end_date');
            $table->string('temp_end_date')->nullable();
            $table->string('days');  // Mon, Tue 
            $table->string('locations'); // List of Location id by comma
            $table->string('slots');  // Number of slots
            $table->string('price');  // Default Price
            $table->string('sub_total');  // Discount
            $table->string('total');  // Total Price
            $table->integer('status');  // 
            $table->integer('free_plan')->default(0); // 1 : Free Plan, 2 : Contract
            $table->integer('coupon')->nullable();
            $table->float('coupon_amount', 10, 2)->default(0);
            $table->integer('sch')->default(0); // 0 : Full, 1 : Every week 2 : 4 weeks
            $table->integer('pay_method')->default(0); // 0 : Credit Card, 2 : Invoice, 2 : Free
            $table->float('part_amount', 10, 2);
            $table->integer('notification')->default(0); // 0 : false, 1 : send before end
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
        Schema::dropIfExists('tbl_user_campaign');
    }
}
