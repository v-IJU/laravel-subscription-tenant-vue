<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use cms\websitecms\Models\CmsAssociatorModel;

class Associator extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("cms_associators", function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->integer("status")->default(1);
            $table->timestamps();
        });

        $data = [
            [
                "image" => "images/associators/associators_img_1.svg",
                "status" => 1,
            ],
            [
                "image" => "images/associators/associators_img_2.svg",
                "status" => 1,
            ],
            [
                "image" => "images/associators/associators_img_3.svg",
                "status" => 1,
            ],
        ];

        foreach ($data as $key => $associators) {
            CmsAssociatorModel::create($associators);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("cms_associators");
    }
}
