<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use cms\websitecms\Models\FrontSettingCmsModel;
use cms\websitecms\Models\CmsFeedbackModel;

class Feedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create("cms_feedback", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("designation")->nullable();
            $table->string("image")->nullable();
            $table->text("message")->nullable();
            $table->integer("status")->default(1);
            $table->timestamps();
        });

        //cms feedback default data
        $feedback_data = [
            [
                "name" => "Jenny Wilson",
                "designation" => "Web Designer",
                "image" => "images/feedback/img1.svg",
                "message" =>
                    "Lorem ipsum dolor sit amet consectetur. Vitae sed nisi ac commodo curabitur malesuada. Molestie id non fermentum et augue cras risus dictum suspendisse. Lectus amet nec elementum enim sollicitudin.",
                "status" => 1,
            ],
            [
                "name" => "Kristin Watson",
                "designation" => "Medical Assistant",
                "image" => "images/feedback/img2.svg",
                "message" =>
                    "Lorem ipsum dolor sit amet consectetur. Vitae sed nisi ac commodo curabitur malesuada. Molestie id non fermentum et augue cras risus dictum suspendisse. Lectus amet nec elementum enim sollicitudin.",
                "status" => 1,
            ],
             [   "name" => "Theresa webb",
                "designation" => "President of Sales",
                "image" => "images/feedback/img3.svg",
                "message" =>
                    "Lorem ipsum dolor sit amet consectetur. Vitae sed nisi ac commodo curabitur malesuada. Molestie id non fermentum et augue cras risus dictum suspendisse. Lectus amet nec elementum enim sollicitudin.",
                "status" => 1,
            ],

        ];
          // Insert the data into the cms_feedback table
        foreach ($feedback_data as $item) {
            CmsFeedbackModel::create($item);
        }


        //contact us default data
        $data = [

            [
                "key" => "contactus_banner_title",
                "value" => "Contact",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_banner_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ac sed dui velit odio",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_banner_image",
                "value" => "images/bannerImages/contact_banner.svg",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section1_title",
                "value" => "GET IN TOUCH",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section1_description",
                "value" =>
                    "We are ready to help yor and answer and questions",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section2_title",
                "value" => "ADDRESS",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section2_description",
                "value" =>
                    "Contact info",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section3_title",
                "value" => "REGISTER",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section3_subtitle",
                "value" => "Register Now to Start Shopping for Dresses!",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ],
            [
                "key" => "contactus_section3_description",
                "value" =>
                    "Join us today! Register now for special discounts, early access to sales, and a seamless shopping journey tailored just for you.",
                "type" => FrontSettingCmsModel::CONTACT_US,
            ]
        ];
         // Insert the data into the front_settings table
        foreach ($data as $item) {
            FrontSettingCmsModel::create($item);
        }
        
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_feedback');

        FrontSettingCmsModel::where('type', FrontSettingCmsModel::CONTACT_US)->delete();
    }
}

