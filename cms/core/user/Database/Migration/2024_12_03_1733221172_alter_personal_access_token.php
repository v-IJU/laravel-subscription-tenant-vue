<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPersonalAccessToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("personal_access_tokens");
        Schema::create("personal_access_tokens", function (Blueprint $table) {
            $table->id();
            $table->morphs("tokenable");
            $table->string("name");
            $table->string("token", 64)->unique();
            $table->text("abilities")->nullable();
            $table->timestamp("last_used_at")->nullable();
            $table->timestamp("expires_at")->nullable();
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
        //
    }
}
