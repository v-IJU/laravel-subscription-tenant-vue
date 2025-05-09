<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
class CreateWebsitecmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("front_settings_cms", function (Blueprint $table) {
            $table->id();
            $table->string("key");
            $table->text("value");
            $table->text("type");

            $table->timestamps();
        });

        Artisan::call("db:seed", [
            "--class" => "FrontSettingsCmsSeeder",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("front_settings_cms");
    }
}
