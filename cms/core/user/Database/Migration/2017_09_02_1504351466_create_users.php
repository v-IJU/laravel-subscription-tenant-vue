<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("users", function (Blueprint $table) {
            $table->increments("id");
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("username")->nullable();
            $table->string("email")->nullable();
            $table->string("mobile")->nullable();
            $table->string("images")->nullable();
            $table->string("password");
            $table->integer("owner_id")->nullable();
            $table->string("owner_type")->nullable();

            $table->rememberToken();
            $table->timestamp("created_at")->useCurrent();
            $table
                ->timestamp("updated_at")
                ->default(
                    DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
                );
            $table
                ->integer("online")
                ->default(0)
                ->comment("0=>offline,1=>online");
            $table
                ->string("ip")
                ->default("")
                ->comment("Ip address");
            $table
                ->string("lastactive")
                ->default("")
                ->comment("Last activate time stamp");
            $table
                ->integer("status")
                ->default(1)
                ->comment("-1=>trash,0=>disable,1=>active");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("users");
    }
}
