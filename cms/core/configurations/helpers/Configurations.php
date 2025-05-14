<?php

namespace cms\core\configurations\helpers;

//helpers
use cms\core\module\Models\ModuleModel;
use Cms;
use Illuminate\Support\Facades\Schema;
//models
use cms\core\configurations\Models\ConfigurationModel;

class Configurations
{
    function __construct()
    {
    }
    const EXCLUDEMODULES = [
        "candidate",
        "schoolmanagement",
        "subscription",
        "Demo",
        "helpdesk",
        "notification_settings",
    ];

    const DEFAULTMODULES = [
        "admin",
        "configurations",
        "layout",
        "menu",
        "user",
        "usergroup",
        "plugins",
        "academicyear",
        "gate",
        "module",
    ];
    const EXCLUDEMODULESBASEBATH = [
        "\cms\core\institute",
        "/cms/core/institute",
        "\cms\core\subscription",
        "/cms/core/subscription",
    ];
    const ADMIN_NAME = "Administrator";
    const ISSUE_ACCESS_TOKEN = "SchoolUniform#$";
    const ACCESS_API = "access-api";
    const EXLUDEFROMPERMISSION = ["gate", "layout", "menu", "module"];
    const RAZORPAY_MODE = ["live" => "Live", "sandbox" => "Sandbox"];
    const TIMEZONES = [
        "Asia/Dubai" => "Asia/Dubai",
        "Asia/Kolkata" => "Asia/Kolkata",
    ];

    const GENDER = [
        "1" => "Male",
        "2" => "Female",
        "3" => "Any",
    ];
    const CURRENCY = [
        "₹" => "₹",
        "$" => "$",
    ];
    const SCHOOL_TYPES = [
        "all" => "All",
        "nursery" => "Nursery",
        "primary" => "Primary",
        "secondary" => "Secondary",
        "higher-secondary" => "Higher Secondary",
    ];
    const RELATIONSHIP = [
        "father" => "Father",
        "mother" => "Mother",
        "guardian" => "Guardian",
        "others" => "Others",
    ];

    const DRESS_SIZES = [
        "26" => "26",
        "28" => "28",
        "30" => "30",
        "32" => "32",
        "34" => "34",
        "36" => "36",
        "38" => "38",
        "40" => "40",
        "42" => "42",
        "44" => "44",
        "46" => "46",
    ];

    const LOGO_PATH = "https://schoolmanagegit.webbazaardevelopment.com/school/profiles/1748204780466456.png";

    const SHIPPING_EMAIL_TITLE = "Shipment Update: Your Order is Out for Delivery";

    const SHIPPING_EMAIL_MSG = " Great news! Your item(s) have been shipped and are on their way. 
                            If you need to return an item from this shipment or manage other orders, 
                            please visit the 'Your Orders' section on website";

    /*
     * get module configuration parm
     * type=1 is core,type =2 is local
     */
    public static function getParm($module, $type = 2)
    {
        $parm = ModuleModel::select("configuration_parm")
            ->where("name", "=", $module)
            ->where("type", "=", $type)
            ->first();
        if ($parm) {
            $parm = json_decode($parm->configuration_parm);
        }

        return $parm;
    }
    public static function getCoreModuleMigrationPath($basepath = true)
    {
        $cms = Cms::allModulesPath(false);

        $CorePaths = [];
        foreach ($cms as $module) {
            if (!in_array($module, self::EXCLUDEMODULESBASEBATH)) {
                if (
                    \File::exists(
                        base_path() .
                            $module .
                            DIRECTORY_SEPARATOR .
                            "Database" .
                            DIRECTORY_SEPARATOR .
                            "Migration" .
                            DIRECTORY_SEPARATOR
                    )
                ) {
                    $CorePaths[] =
                        base_path() .
                        $module .
                        DIRECTORY_SEPARATOR .
                        "Database" .
                        DIRECTORY_SEPARATOR .
                        "Migration";
                }
            }
        }
        return $CorePaths;
    }
    public static function getConfig($name)
    {
        $parm = ConfigurationModel::where("name", $name)
            ->select("parm")
            ->first();

        if ($parm) {
            $parm = json_decode($parm->parm);
        }

        return $parm;
    }

    public static function getAllConfig()
    {
        $parm = ConfigurationModel::pluck("parm", "name");

        foreach ($parm as $key => $value) {
            $parm[$key] = json_decode($value);
        }

        return $parm;
    }

    public static function getCurrentTheme()
    {
        if (Schema::hasTable("configurations")) {
            $data = ConfigurationModel::where("name", "=", "site")->first();

            if (count((array) $data) > 0 && isset($data->parm)) {
                $data = json_decode($data->parm);

                if (isset($data->active_theme)) {
                    return $data->active_theme;
                }
            }
        }

        return Cms::getThemeConfig()["active"];
    }
    public static function Generatepassword($length)
    {
        //password generate
        $random_string = '0123456789ABCDEFGHI$#@!%^JKXYZabcdefghijklstuvwxyz';

        $password__string = substr(str_shuffle($random_string), 0, $length);

        $password = "DOMAIN" . date("Y") . $password__string;
        //password encrypt
        //$hash_password = Hash::make($password);
        return $password;
    }

    public static function GenerateUsername($data, $textstring)
    {
        if ($data) {
            $code = substr($data, strpos($data, "-") + 1);

            $newcode_string = str_pad(++$code, 3, "0", STR_PAD_LEFT);

            $newcode = "DB" . $textstring . date("Y") . "-" . $newcode_string;

            return $newcode;
        } else {
            $emp_code = "DB" . $textstring . date("Y") . "-001";

            return $emp_code;
        }
    }

    public static function getUserImageInitial($userId, $name)
    {
        $avatar_url = "//ui-avatars.com/api/";
        return $avatar_url .
            "?name=$name&size=100&rounded=true&color=fff&background=" .
            Configurations::getRandomColor($userId);
    }

    public static function getRandomColor($userId)
    {
        $colors = ["329af0", "fc6369", "ffaa2e", "42c9af", "7d68f0"];
        $index = $userId % 5;

        return $colors[$index];
    }
    public static function getTimeZone()
    {
        return "Asia/Kolkata";
    }

    public static function convertRupeesToWords($number)
    {
        $ones = [
            0 => "Zero",
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen",
        ];

        $tens = [
            2 => "Twenty",
            3 => "Thirty",
            4 => "Forty",
            5 => "Fifty",
            6 => "Sixty",
            7 => "Seventy",
            8 => "Eighty",
            9 => "Ninety",
        ];

        $words = "";

        if ($number < 20) {
            $words .= $ones[$number];
        } elseif ($number < 100) {
            $words .= $tens[floor($number / 10)];
            $remainder = $number % 10;
            if ($remainder > 0) {
                $words .= " " . $ones[$remainder];
            }
        } elseif ($number < 1000) {
            $words .= $ones[floor($number / 100)] . " Hundred";
            $remainder = $number % 100;
            if ($remainder > 0) {
                $words .=
                    " " . Configurations::convertRupeesToWords($remainder);
            }
        } elseif ($number < 1000000) {
            $words .=
                Configurations::convertRupeesToWords(floor($number / 1000)) .
                " Thousand";
            $remainder = $number % 1000;
            if ($remainder > 0) {
                $words .=
                    " " . Configurations::convertRupeesToWords($remainder);
            }
        } elseif ($number < 1000000000) {
            $words .=
                Configurations::convertRupeesToWords(floor($number / 1000000)) .
                " Million";
            $remainder = $number % 1000000;
            if ($remainder > 0) {
                $words .=
                    " " . Configurations::convertRupeesToWords($remainder);
            }
        } else {
            $words .=
                Configurations::convertRupeesToWords(
                    floor($number / 1000000000)
                ) . " Billion";
            $remainder = $number % 1000000000;
            if ($remainder > 0) {
                $words .=
                    " " . Configurations::convertRupeesToWords($remainder);
            }
        }

        return $words;
    }
}
