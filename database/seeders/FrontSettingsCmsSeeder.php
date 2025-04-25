<?php

namespace Database\Seeders;

use cms\websitecms\Models\FrontSettingCmsModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontSettingsCmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "key" => "home_page_title",
                "value" => "Cms Admin",
                "type" => FrontSettingCmsModel::HOME_PAGE,
            ],
            [
                "key" => "home_page_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ac sed dui velit odio",
                "type" => FrontSettingCmsModel::HOME_PAGE,
            ],
            [
                "key" => "home_page_image",
                "value" => "images/home_banner.png",
                "type" => FrontSettingCmsModel::HOME_PAGE,
            ],
            [
                "key" => "about_us_banner_title",
                "value" => "About Us",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_banner_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ac sed dui velit odio",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_banner_image",
                "value" => "images/bannerImages/about_banner.svg",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us",
                "value" => "About Us",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_title",
                "value" => "About Vivek Tailors",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section1_title",
                "value" => "What We Tailor For Students",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section1_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section1_image",
                "value" => "images/about/image1.svg",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section2_title",
                "value" => "QUALITY COMMITMENT",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section2_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section2_image",
                "value" => "images/about/image2.svg",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section3",
                "value" => "GET STARTED & IMPROVE YOUR LIVING STANDARDS",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section3_title",
                "value" => "What do You Get From Our Tailor Shop?",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "about_us_section3_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::ABOUT_US,
            ],
            [
                "key" => "services_banner_title",
                "value" => "Services",
                "type" => FrontSettingCmsModel::SERVICES,
            ],
            [
                "key" => "services_banner_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ac sed dui velit odio",
                "type" => FrontSettingCmsModel::SERVICES,
            ],
            [
                "key" => "services_banner_image",
                "value" => "images/bannerImages/service_banner.svg",
                "type" => FrontSettingCmsModel::SERVICES,
            ],
            [
                "key" => "services",
                "value" => "Services",
                "type" => FrontSettingCmsModel::SERVICES,
            ],
            [
                "key" => "services_title",
                "value" => "Services We Offering",
                "type" => FrontSettingCmsModel::SERVICES,
            ],
            [
                "key" => "services_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::SERVICES,
            ],
            [
                "key" => "industries",
                "value" => "Industries",
                "type" => FrontSettingCmsModel::INDUSTRIES,
            ],
            [
                "key" => "industries_title",
                "value" => "Industries We Serve",
                "type" => FrontSettingCmsModel::INDUSTRIES,
            ],
            [
                "key" => "industries_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::INDUSTRIES,
            ],
            [
                "key" => "associator",
                "value" => "Associator",
                "type" => FrontSettingCmsModel::ASSOCIATOR,
            ],
            [
                "key" => "associator_title",
                "value" => "Our Associators",
                "type" => FrontSettingCmsModel::ASSOCIATOR,
            ],
            [
                "key" => "associator_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::ASSOCIATOR,
            ],
            [
                "key" => "feedback",
                "value" => "Feed Back",
                "type" => FrontSettingCmsModel::FEEDBACK,
            ],
            [
                "key" => "feedback_title",
                "value" => "What Our Beloved Parents Say About Us!",
                "type" => FrontSettingCmsModel::FEEDBACK,
            ],
            [
                "key" => "feedback_description",
                "value" =>
                    "Lorem ipsum dolor sit amet consectetur. Ut odio sollicitudin elementum viverra nullam...",
                "type" => FrontSettingCmsModel::FEEDBACK,
            ],
        ];

        foreach ($data as $item) {
            FrontSettingCmsModel::updateOrCreate(
                ["key" => $item["key"], "type" => $item["type"]],
                ["value" => $item["value"]]
            );
        }
    }
}
