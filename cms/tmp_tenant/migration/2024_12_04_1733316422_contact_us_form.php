<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use cms\websitecms\Models\FrontSettingCmsModel;


class ContactUsForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("subject")->nullable();
            $table->longText("description");
            $table->timestamps();
        });

        //contact info default data
        $data = [
            [
                "key" => "address_1",
                "value" => "Rajajinagar: 1214, 1st Floor, 18th C Main road, Rajajinagar 5th Block, behind Variar Bakery on West of Chord Road, Bangalore - 560010",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "address_2",
                "value" => "Indiranagar: 498, 7th Cross, 8th Main,  Jeevanbimanagar, HAL 3rd Stage,Bangalore - 560075.",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "phone_number_1",
                "value" => "+91 6360494990",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "phone_number_2",
                "value" => "+91 8073956133",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "working_hrs",
                "value" =>
                    "We will be available from Monday to Saturday between 9AM to 4.30PM.",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "map_embed_url",
                "value" => "https://www.google.com/maps/place/Vivek+Tailors/@12.9865548,77.5489989,18.5z/data=!4m14!1m7!3m6!1s0x3bae3ded9f4c4e29:0x1eecb4562efa9e03!2sVivek+Tailors!8m2!3d12.9872733!4d77.5502077!16s%2Fg%2F11stvfxtcl!3m5!1s0x3bae3ded9f4c4e29:0x1eecb4562efa9e03!8m2!3d12.9872733!4d77.5502077!16s%2Fg%2F11stvfxtcl?entry=ttu&g_ep=EgoyMDI0MTIwMi4wIKXMDSoASAFQAw%3D%3D",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "footer_description",
                "value" => "Lorem ipsum dolor sit amet consectetur. At ac eros lacus sit erat tincidunt ut viverra. Amet volutpat nunc nec morbi. Ut tortor quam vitae gravida. Hendrerit aenean eu ultricies sagittis aliquam duis ultricies. Arcu amet lacinia elementum sed lectus augue massa eleifend.",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "facebook_url",
                "value" =>
                    "https://www.facebook.com/",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "instagram_url",
                "value" => "https://www.instagram.com/",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "twitter_url",
                "value" =>
                    "https://www.x.com/",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],
            [
                "key" => "linkedin_url",
                "value" => "https://www.linkedin.com/",
                "type" => FrontSettingCmsModel::CONTACT_INFO,
            ],

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
        Schema::dropIfExists('contact_us');
    }
}
