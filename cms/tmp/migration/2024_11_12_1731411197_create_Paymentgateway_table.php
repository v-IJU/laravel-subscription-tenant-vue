<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePaymentgatewayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('payment_gateway', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gateway_name');
            $table->string('razorpay_mode');
            $table->string('test_key_id')->nullable();
            $table->longText('test_key_secret')->nullable();
            $table->string('live_key_id')->nullable();
            $table->longText('live_key_secret')->nullable();
            $table->integer('status')->default(1)->comment('-1=>trash,0=>disable,1=>active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateway');
    }
}
