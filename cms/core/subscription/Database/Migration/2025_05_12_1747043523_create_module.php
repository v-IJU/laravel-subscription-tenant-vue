<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("module", function (Blueprint $table) {
            $table->increments("id");
            $table->string("module_name")->unique();
            $table->string("module_description")->nullable();
            $table->string("module_slug")->nullable();
            $table->integer("type")->comment("1=>core,2=>local");
            $table->timestamp("created_at")->useCurrent();
            $table
                ->timestamp("updated_at")
                ->default(
                    DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
                );
            $table
                ->integer("status")
                ->default(1)
                ->comment("-1=>trash,0=>disable,1=>active");
        });

        Artisan::call("db:seed", [
            "--class" => "cms\\core\\subscription\\seeds\\ModuleSeeder",
            "--force" => true, // If you're running in production, you might need this
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("module");
    }
}
