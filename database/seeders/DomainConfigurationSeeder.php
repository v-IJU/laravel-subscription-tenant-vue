<?php

namespace Database\Seeders;

use cms\core\configurations\Models\ConfigurationModel;
use Illuminate\Database\Seeder;

class DomainConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = ConfigurationModel::where("name", "=", "site")->first();
        if (count((array) $obj) == 0) {
            $obj = new ConfigurationModel();

            $form_data = [
                "site_name" => "Cms Vue Admin",
                "site_logo" => "/build/images/logo-dark.png",
                "site_icon" => "/build/images/favicon.ico",
                "site_email" => "cms@yahoo.com",
                "site_phone" => "",
            ];

            $obj->name = "site";
            $obj->parm = json_encode($form_data);
            $obj->save();
        }
    }
}
