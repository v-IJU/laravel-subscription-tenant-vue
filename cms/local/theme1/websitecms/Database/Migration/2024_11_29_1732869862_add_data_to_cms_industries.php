<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use cms\websitecms\Models\CmsIndustiresModel;

class AddDataToCmsIndustries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            [
                "industry_name" => "Schools",
                "image" => "images/industries/industries-img_1.svg",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis.",
                "status" => 1,
            ],
            [
                "industry_name" => "Corporate",
                "image" => "images/industries/industries-img_2.svg",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis.",
                "status" => 1,
            ],
            [
                "industry_name" => "Hotels",
                "image" => "images/industries/industries-img_3.svg",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis.",
                "status" => 1,
            ],
            [
                "industry_name" => "Hospitals",
                "image" => "images/industries/industries-img_4.svg",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis.",
                "status" => 1,
            ],
        ];

        foreach ($data as $key => $industry) {
            # code...

            CmsIndustiresModel::create($industry);
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
