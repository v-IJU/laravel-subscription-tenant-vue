<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituteRelatedInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("institute", function (Blueprint $table) {
            $table->increments("id");
            $table
                ->integer("user_id")
                ->unsigned()
                ->nullable();
            $table->string("tenant_id")->nullable();

            $table->integer("status")->default(1);
            $table->timestamp("created_at")->useCurrent();
            $table
                ->timestamp("updated_at")
                ->default(
                    DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
                );
            $table
                ->foreign("tenant_id")
                ->references("id")
                ->on("tenants")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });

        Schema::table("users", function (Blueprint $table) {
            $table
                ->string("tenant_id")
                ->after("ip")
                ->nullable();

            $table
                ->foreign("tenant_id")
                ->references("id")
                ->on("tenants")
                ->onUpdate("cascade")
                ->onDelete("cascade");
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
