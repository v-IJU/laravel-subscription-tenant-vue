<?php

namespace cms\websitecms\Repositories;

use cms\websitecms\Models\FrontSettingCmsModel;
use Illuminate\Support\Arr;
use Carbon\Carbon;


class FrontSettingsCmsRepository
{
    // Repository methods go here
    public function update($input, $id)
    {
        // if (
        //     isset($input["about_us_section1_image"]) &&
        //     !empty($input["about_us_section1_image"])
        // ) {
        //     /** @var FrontSetting $frontSetting */
        //     $frontSetting = FrontSettingCmsModel::where(
        //         "key",
        //         "=",
        //         "about_us_section1_image"
        //     )->first();
        //     $frontSetting->clearMediaCollection(FrontSettingCmsModel::PATH);
        //     $frontSetting
        //         ->addMedia($input["about_us_section1_image"])
        //         ->toMediaCollection(
        //             FrontSettingCmsModel::PATH,
        //             config("app.media_disc")
        //         );

        //     $frontSetting->update(["value" => $frontSetting->image_url]);
        // }

        $frontSettingInputArray = [];

        //for homepage

        if ($id == 1) {
            if (
                isset($input["home_page_image"]) &&
                !empty($input["home_page_image"])
            ) {
                $frontSetting = FrontSettingCmsModel::where(
                    "key",
                    "=",
                    "home_page_image"
                )->first();
                $frontSetting->clearMediaCollection(
                    FrontSettingCmsModel::HOME_IMAGE_PATH
                );
                $frontSetting
                    ->addMedia($input["home_page_image"])
                    ->toMediaCollection(
                        FrontSettingCmsModel::HOME_IMAGE_PATH,
                        config("app.media_disc")
                    );

                $frontSetting->update(["value" => $frontSetting->image_url]);
            }
            $frontSettingInputArray = Arr::only($input, [
                "home_page_title",
                "home_page_description",
            ]);
        } elseif ($id == 2) {
            if (
                isset($input["about_us_banner_image"]) &&
                !empty($input["about_us_banner_image"])
            ) {
                $frontSetting = FrontSettingCmsModel::where(
                    "key",
                    "=",
                    "about_us_banner_image"
                )->first();
                $frontSetting->clearMediaCollection(
                    FrontSettingCmsModel::ABOUT_US_IMAGE_PATH
                );
                $frontSetting
                    ->addMedia($input["about_us_banner_image"])
                    ->toMediaCollection(
                        FrontSettingCmsModel::ABOUT_US_IMAGE_PATH,
                        config("app.media_disc")
                    );

                $frontSetting->update(["value" => $frontSetting->image_url]);
            }
            if (
                isset($input["about_us_section1_image"]) &&
                !empty($input["about_us_section1_image"])
            ) {
                $frontSetting = FrontSettingCmsModel::where(
                    "key",
                    "=",
                    "about_us_section1_image"
                )->first();
                $frontSetting->clearMediaCollection(
                    FrontSettingCmsModel::ABOUT_US_IMAGE_PATH
                );
                $frontSetting
                    ->addMedia($input["about_us_section1_image"])
                    ->toMediaCollection(
                        FrontSettingCmsModel::ABOUT_US_IMAGE_PATH,
                        config("app.media_disc")
                    );

                $frontSetting->update(["value" => $frontSetting->image_url]);
            }
            if (
                isset($input["about_us_section2_image"]) &&
                !empty($input["about_us_section2_image"])
            ) {
                $frontSetting = FrontSettingCmsModel::where(
                    "key",
                    "=",
                    "about_us_section2_image"
                )->first();
                $frontSetting->clearMediaCollection(
                    FrontSettingCmsModel::ABOUT_US_IMAGE_PATH
                );
                $frontSetting
                    ->addMedia($input["about_us_section2_image"])
                    ->toMediaCollection(
                        FrontSettingCmsModel::ABOUT_US_IMAGE_PATH,
                        config("app.media_disc")
                    );

                $frontSetting->update(["value" => $frontSetting->image_url]);
            }
            $frontSettingInputArray = Arr::only($input, [
                "about_us_baner_title",
                "about_us_baner_description",
                "about_us",
                "about_us_title",
                "about_us_section1_title",
                "about_us_section1_description",
                "about_us_section2_title",
                "about_us_section2_description",
                "about_us_section3",
                "about_us_section3_title",
                "about_us_section3_description",
            ]);
        } elseif ($id == 3) {
            if (
                isset($input["services_banner_image"]) &&
                !empty($input["services_banner_image"])
            ) {
                $frontSetting = FrontSettingCmsModel::where(
                    "key",
                    "=",
                    "services_banner_image"
                )->first();
                $frontSetting->clearMediaCollection(
                    FrontSettingCmsModel::SERVICES_IMAGE_PATH
                );
                $frontSetting
                    ->addMedia($input["services_banner_image"])
                    ->toMediaCollection(
                        FrontSettingCmsModel::SERVICES_IMAGE_PATH,
                        config("app.media_disc")
                    );

                $frontSetting->update(["value" => $frontSetting->image_url]);
            }
            $frontSettingInputArray = Arr::only($input, [
                "services_banner_title",
                "services_banner_description",
                "services",
                "services_title",
                "services_description",
            ]);
        } elseif ($id == 4) {
            $frontSettingInputArray = Arr::only($input, [
                "industries",
                "industries_title",
                "industries_description",
            ]);
        } elseif ($id == 5) {
            $frontSettingInputArray = Arr::only($input, [
                "associator",
                "associator_title",
                "associator_description",
            ]);
        } elseif ($id == 7) {
            if (
                isset($input["contactus_banner_image"]) &&
                !empty($input["contactus_banner_image"])
            ) {
                $frontSetting = FrontSettingCmsModel::where(
                    "key",
                    "=",
                    "contactus_banner_image"
                )->first();
                if(($frontSetting != null)) {
                    $frontSetting->clearMediaCollection(
                    FrontSettingCmsModel::CONTACT_US_IMAGE_PATH
                );
                }
                //dd($input);
                $frontSetting
                    ->addMedia($input["contactus_banner_image"])
                    ->toMediaCollection(
                        FrontSettingCmsModel::CONTACT_US_IMAGE_PATH,
                        config("app.media_disc")
                    );

                $frontSetting->update(["value" => $frontSetting->image_url]);
            }
            $frontSettingInputArray = Arr::only($input, [
                "contactus_banner_title",
                "contactus_banner_description",
                "contactus_section1_title",
                "contactus_section1_description",
                "contactus_section2_title",
                "contactus_section2_description",
                "contactus_section3_title",
                "contactus_section3_subtitle",
                "contactus_section3_description",
            ]);

        }
        elseif ($id == 8) {

            $frontSettingInputArray = Arr::only($input, [
                "address_1",
                "address_2",
                "phone_number_1",
                "phone_number_2",
                "working_hrs",
                "map_embed_url",
                "footer_description",
                "facebook_url",
                "instagram_url",
                "twitter_url",
                "linkedin_url",
            ]);
        }

        else {
            $frontSettingInputArray = Arr::only($input, [
                "feedback",
                "feedback_title",
                "feedback_description",
            ]);
        }

        //for about us

        foreach ($frontSettingInputArray as $key => $value) {
            $FrontSettings_fields = FrontSettingCmsModel::where(
                "key",
                "=",
                $key
            )->exists();
            if ($value) {
                if (!$FrontSettings_fields) {
                    $info = [
                        "key" => $key,
                        "value" => $value,
                        "type" => $id,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                        // "tenant_id" => getLoggedInUser()->tenant_id,
                    ];
                    FrontSettingCmsModel::insert($info);
                } else {
                    FrontSettingCmsModel::where("key", "=", $key)
                        ->first()
                        ->update(["value" => $value]);
                }
            }
        }
    }
}
