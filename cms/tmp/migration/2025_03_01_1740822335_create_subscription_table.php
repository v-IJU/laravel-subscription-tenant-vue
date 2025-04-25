<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("subscription_plans", function (Blueprint $table) {
            $table->increments("id");
            $table
                ->string("currency")
                ->default("inr")
                ->nullable();
            $table->string("name");
            $table->double("price")->default(0);
            $table
                ->integer("frequency")
                ->default(1)
                ->comment("1=>Month,2=>Year");
            $table
                ->integer("duration")
                ->default(1)
                ->nullable();
            $table
                ->integer("is_default")
                ->default(0)
                ->comment("if any default plan means set here");
            $table
                ->integer("trail_period")
                ->default(7)
                ->comment("Default validity will be 7 trial days");
            $table->integer("status")->default(1);
            $table->timestamp("created_at")->useCurrent();
            $table
                ->timestamp("updated_at")
                ->default(
                    DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
                );
        });
        Schema::create("plan_features", function (Blueprint $table) {
            $table->increments("id");
            $table
                ->integer("subscription_plan_id")
                ->unsigned()
                ->nullable();

            $table
                ->integer("module_id")
                ->unsigned()
                ->nullable()
                ->comment("its link to modules table");

            //model id comes here
            $table->timestamp("created_at")->useCurrent();
            $table
                ->timestamp("updated_at")
                ->default(
                    DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
                );
        });

        Schema::create("subscriptions", function (Blueprint $table) {
            $table->increments("id");
            $table
                ->integer("user_id")
                ->unsigned()
                ->nullable();
            $table
                ->integer("subscription_plan_id")
                ->unsigned()
                ->nullable();
            $table->json("transaction_details")->nullable();
            $table->double("plan_amount")->default(0);
            $table
                ->integer("plan_frequency")
                ->default(1)
                ->comment("1=>Month,2=>Year");
            $table->dateTime("starts_at")->nullable();
            $table->dateTime("ends_at")->nullable();
            $table->dateTime("trail_ends_at")->nullable();
            $table->integer("status")->default(1);
            $table->timestamp("created_at")->useCurrent();
            $table
                ->timestamp("updated_at")
                ->default(
                    DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
                );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("subscription_plans");
        Schema::dropIfExists("plan_features");
        Schema::dropIfExists("subscriptions");
    }
}
