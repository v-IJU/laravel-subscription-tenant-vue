<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotmanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('botman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("category")->nullable();
            $table->string("name")->nullable();
            $table->longText("value")->nullable();
            $table->string("type")->nullable();
            $table->timestamps();
        });
        Artisan::call("db:seed", [
            "--class" => "BotmanSeeder",
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('botman');
    }
}
