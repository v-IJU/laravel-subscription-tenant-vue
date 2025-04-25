<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use cms\websitecms\Models\CmsAboutusShopModel;

class AboutusShop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aboutus_shop', function (Blueprint $table) {
            $table->id();
            $table->string("category");
            $table->string("image")->nullable();
            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->integer("status")->default(1);
            $table->timestamps();
        });

        $data = [
            [
                "category" => "Qualified Fabric",
                "image" => "images/getStarted/image.svg",
                "title" => "Qualified Fabric",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis. Arcu quam faucibus nulla aliquet faucibus sed faucibus auctor. Hac nibh magnis cras amet. Sed lectus quis leo donec tempor et. Sit commodo vulputate ut feugiat amet at volutpat.Malesuada phasellus morbi pharetra consequat porttitor. Volutpat quis tristique id dolor. Egestas arcu est sed enim nulla scelerisque vitae purus. Id iaculis sapien quis.",
                "status" => 1,
            ],
            [
                "category" => "HomeDelivery",
                "image" => "images/getStarted/image3.svg",
                "title" => "HomeDelivery",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis. Arcu quam faucibus nulla aliquet faucibus sed faucibus auctor. Hac nibh magnis cras amet. Sed lectus quis leo donec tempor et. Sit commodo vulputate ut feugiat amet at volutpat.Malesuada phasellus morbi pharetra consequat porttitor. Volutpat quis tristique id dolor. Egestas arcu est sed enim nulla scelerisque vitae purus. Id iaculis sapien quis.",
                "status" => 1,
            ],
            [
                "category" => "OnlineSupport",
                "image" => "images/getStarted/image.svg",
                "title" => "OnlineSupport",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis. Arcu quam faucibus nulla aliquet faucibus sed faucibus auctor. Hac nibh magnis cras amet. Sed lectus quis leo donec tempor et. Sit commodo vulputate ut feugiat amet at volutpat.Malesuada phasellus morbi pharetra consequat porttitor. Volutpat quis tristique id dolor. Egestas arcu est sed enim nulla scelerisque vitae purus. Id iaculis sapien quis.",
                "status" => 1,
            ],
            [
                "category" => "VintageTailoring",
                "image" => "images/getStarted/image3.svg",
                "title" => "VintageTailoring",
                "description" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam. Tellus faucibus aliquam nisl sit. Quam est non tellus sagittis. Arcu quam faucibus nulla aliquet faucibus sed faucibus auctor. Hac nibh magnis cras amet. Sed lectus quis leo donec tempor et. Sit commodo vulputate ut feugiat amet at volutpat.Malesuada phasellus morbi pharetra consequat porttitor. Volutpat quis tristique id dolor. Egestas arcu est sed enim nulla scelerisque vitae purus. Id iaculis sapien quis.",
                "status" => 1,
            ],

        ];

        foreach ($data as $key => $shop) {
            # code...

            CmsAboutusShopModel::create($shop);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aboutus_shop');
    }
}
