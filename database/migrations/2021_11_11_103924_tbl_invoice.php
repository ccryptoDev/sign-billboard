<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('client_id');
            $table->integer('campaign_id')->nullable();
            $table->integer('status');  // 0 : Draft, 1 : Paid
            $table->string('invoice_date');
            $table->longtext('description')->nullable();
            $table->longtext('data');  // Content Body
            $table->float('discount', 10, 2)->default(0); // Discount when generate in client side
            $table->float('amount', 10, 2); // Total Amount
            $table->integer('sch')->default(0); // 0 : Full, 1 : Every week 2 : 4 weeks
            $table->integer('pay_method')->default(0); // 0 : Credit Card, 2 : Invoice, 2 : Free
            $table->float('part_amount', 10, 2)->default(0);
            $table->integer('paid')->default(0); // Number of remaining weeks
            $table->string('ach')->nullable();
            $table->string('extra')->nullable(); // notes : Send
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
        Schema::dropIfExists('tbl_invoice');
    }
}
