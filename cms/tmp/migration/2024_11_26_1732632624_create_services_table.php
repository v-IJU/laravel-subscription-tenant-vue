<?php

use cms\websitecms\Models\CmsSeviceModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("cms_services", function (Blueprint $table) {
            $table->id();
            $table->string("service_name");
            $table->text("description")->nullable();
            $table->integer("status")->default(1);

            $table->timestamps();
        });

        // add data

        $data = [
            [
                "service_name" => "Custom Patterns",
                "description" =>
                    "Vivek Tailorscreates individualized patterns to ensure that every garment fits perfectly and complements the customer's body Shape",
                "status" => 1,
            ],
            [
                "service_name" => "Personalized Fittings",
                "description" =>
                    "Clients benefit from personalized fitting sessions, where tailors make sure that clothes are adjusted to perfection for both comfort and style.",
                "status" => 1,
            ],
            [
                "service_name" => "Style Consultations",
                "description" =>
                    "Clients benefit from personalized fitting sessions, where tailors make sure that clothes are adjusted to perfection for both comfort and style.",
                "status" => 1,
            ],
        ];

        foreach ($data as $key => $service) {
            # code...

            CmsSeviceModel::create($service);
        }
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
