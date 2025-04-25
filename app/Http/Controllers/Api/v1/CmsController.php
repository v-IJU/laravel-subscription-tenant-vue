<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use cms\websitecms\Models\CmsAboutusShopModel;
use cms\websitecms\Models\CmsFeedbackModel;
use cms\websitecms\Models\CmsIndustiresModel;
use cms\websitecms\Models\CmsSeviceModel;
use cms\websitecms\Models\FrontSettingCmsModel;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    use ApiResponse;

    public function cmsPages(Request $request, $type = "homepage")
    {
        try {
            $cms_type = null;

            switch ($type) {
                case "homepage":
                    # code...
                    $cms_type = FrontSettingCmsModel::HOME_PAGE;
                    break;

                case "aboutus":
                    # code...
                    $cms_type = FrontSettingCmsModel::ABOUT_US;
                    break;

                case "services":
                    # code...
                    $cms_type = FrontSettingCmsModel::SERVICES;
                    break;

                case "contactus":
                    # code...
                    $cms_type = FrontSettingCmsModel::CONTACT_US;
                    break;

                default:
                    # code...
                    $cms_type = FrontSettingCmsModel::HOME_PAGE;
                    break;
            }

            //industires

            $industries = CmsIndustiresModel::where(["status" => 1])
                ->select("id", "industry_name", "image", "description")
                ->get();

            $services = CmsSeviceModel::where(["status" => 1])
                ->select("id", "service_name", "description")
                ->get();

            if ($cms_type == 1) {
                $frontSettings = FrontSettingCmsModel::whereNotIn("type", [
                    FrontSettingCmsModel::CONTACT_US,
                ])
                    ->pluck("value", "key")
                    ->toArray();

                return $this->success(
                    [
                        "homepage" => $frontSettings,
                        "industries" => $industries,
                        "services" => $services,
                    ],
                    "Fetched Successfully"
                );
            } elseif ($cms_type == 2) {
                $frontSettings = FrontSettingCmsModel::whereIn("type", [
                    FrontSettingCmsModel::ABOUT_US,
                    FrontSettingCmsModel::SERVICES,
                ])
                    ->pluck("value", "key")
                    ->toArray();

                $shops_category = CmsAboutusShopModel::where("status", 1)
                    ->get()
                    ->reduce(function ($acc, $item) {
                        $acc[$item->category] = $item->toArray();

                        return $acc;
                    });

                return $this->success(
                    [
                        "aboutus" => $frontSettings,

                        "services" => $services,

                        "shops_category" => $shops_category,
                    ],
                    "Fetched Successfully"
                );
            } elseif ($cms_type == 3) {
                $frontSettings = FrontSettingCmsModel::whereIn("type", [
                    FrontSettingCmsModel::SERVICES,
                    FrontSettingCmsModel::INDUSTRIES,
                    FrontSettingCmsModel::FEEDBACK,
                ])
                    ->pluck("value", "key")
                    ->toArray();

                $feedbacks = CmsFeedbackModel::where("status", 1)
                    ->select("id", "image", "designation", "message")
                    ->get();

                return $this->success(
                    [
                        "services_cms" => $frontSettings,
                        "services" => $services,
                        "industries" => $industries,
                        "feedbacks" => $feedbacks,
                    ],
                    "Fetched Successfully"
                );
            } elseif ($cms_type == 7) {
                //contact us
                $frontSettings = FrontSettingCmsModel::whereIn("type", [
                    FrontSettingCmsModel::CONTACT_US,
                    FrontSettingCmsModel::CONTACT_INFO,
                ])
                    ->pluck("value", "key")
                    ->toArray();

                unset(
                    $frontSettings["footer_description"],
                    $frontSettings["facebook_url"],
                    $frontSettings["instagram_url"],
                    $frontSettings["linkedin_url"],
                    $frontSettings["twitter_url"]
                );

                return $this->success(
                    [
                        "contactus" => $frontSettings,
                    ],
                    "Fetched Successfully"
                );
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
