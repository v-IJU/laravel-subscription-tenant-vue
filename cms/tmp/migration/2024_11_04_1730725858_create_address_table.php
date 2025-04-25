<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("addresses", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer("owner_id")->nullable();
            $table->string("owner_type")->nullable();
            $table->string("address1")->nullable();
            $table->string("address2")->nullable();
            $table->string("city")->nullable();
            $table->string("zip")->nullable();
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
        Schema::dropIfExists("addresses");
    }
}
