<?php

use cms\customer\Models\CustomerModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("customers", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->unique();
            $table->string("password");
            $table->enum("type", ["website", "mobile"])->default("website"); // User type
            $table->timestamps();
        });

        //insert data

        CustomerModel::create([
            "name" => "Website User",
            "email" => "website@example.com",
            "password" => Hash::make("password123"),
            "type" => "website",
        ]);

        CustomerModel::create([
            "name" => "Mobile User",
            "email" => "mobile@example.com",
            "password" => Hash::make("password123"),
            "type" => "mobile",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("customers");
    }
}
