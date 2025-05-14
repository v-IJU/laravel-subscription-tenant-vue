<?php
namespace cms\core\module\helpers;

//helpers
use Cms;

//models
use cms\core\module\Models\ModuleModel;
use cms\core\configurations\helpers\Configurations;
use cms\core\subscription\Models\ModuleModel as SubscriptionModuleModel;
class Module
{
    public static function registerModule($moduletype = "all")
    {
        $modules = Cms::allModules();
        \Log::channel("debug")->error("ModuleTenantUpdate2: ");
        //print_r($modules);exit;
        if ($moduletype == "tenant") {
            $exclude = Configurations::EXCLUDEMODULES;

            foreach ($modules as $key => $value) {
                if (in_array($value["name"], $exclude)) {
                    unset($modules[$key]);
                }
            }
            \Log::channel("debug")->error(
                "ModuleTenantsesion1: " . json_encode(Session("module_list"))
            );
            foreach ($modules as $key => $value) {
                if (!in_array($value["name"], Session("module_list"))) {
                    unset($modules[$key]);
                }
            }
            \Log::channel("debug")->error(
                "ModuleTenantsesion: " . json_encode(Session("module_list"))
            );
            // Reindex the array
            $modules = array_values($modules);
            \Log::channel("debug")->error(
                "ModuleTenantUpdate2: " . json_encode($modules)
            );
        }

        if ($moduletype == "all" || $moduletype == "tenant") {
            \Log::channel("debug")->error("ModuleTenantUpdate3: ");
            foreach ($modules as $module) {
                $type = $module["type"] == "core" ? 1 : 2;
                $old = ModuleModel::select("version", "id")
                    ->where("name", "=", $module["name"])
                    ->where("type", "=", $type)
                    ->first();
                //already available
                if (count((array) $old) > 0) {
                    //check version is same
                    if ($old->version != $module["version"]) {
                        $obj = ModuleModel::find($old->id);
                        $obj->version = $module["version"];
                        if (isset($module["configuration"])) {
                            $obj->configuration_view = $module["configuration"];
                        }
                        if (isset($module["configuration_data"])) {
                            $obj->configuration_data =
                                $module["configuration_data"];
                        }
                        $obj->save();
                    }
                } else {
                    $obj = new ModuleModel();
                    $obj->name = $module["name"];
                    $obj->type = $type;
                    $obj->version = $module["version"];
                    if (isset($module["configuration"])) {
                        $obj->configuration_view = $module["configuration"];
                    }
                    if (isset($module["configuration_data"])) {
                        $obj->configuration_data =
                            $module["configuration_data"];
                    }
                    $obj->status = 1;
                    $obj->save();
                }
            }
        } else {
            \Log::channel("debug")->error("ModuleTenantUpdate4: ");
            foreach ($modules as $module) {
                // if ($module["type"] == $moduletype) {
                //     $type = $module["type"] == "core" ? 1 : 2;
                //     $old = ModuleModel::select("version", "id")
                //         ->where("name", "=", $module["name"])
                //         ->where("type", "=", $type)
                //         ->first();
                //     //already available
                //     if (count((array) $old) > 0) {
                //         //check version is same
                //         if ($old->version != $module["version"]) {
                //             $obj = ModuleModel::find($old->id);
                //             $obj->version = $module["version"];
                //             if (isset($module["configuration"])) {
                //                 $obj->configuration_view =
                //                     $module["configuration"];
                //             }
                //             if (isset($module["configuration_data"])) {
                //                 $obj->configuration_data =
                //                     $module["configuration_data"];
                //             }
                //             $obj->save();
                //         }
                //     } else {
                //         $obj = new ModuleModel();
                //         $obj->name = $module["name"];
                //         $obj->type = $type;
                //         $obj->version = $module["version"];
                //         if (isset($module["configuration"])) {
                //             $obj->configuration_view = $module["configuration"];
                //         }
                //         if (isset($module["configuration_data"])) {
                //             $obj->configuration_data =
                //                 $module["configuration_data"];
                //         }
                //         $obj->status = 1;
                //         $obj->save();
                //     }
                // }
                $type = $module["type"] == "core" ? 1 : 2;
                $old = ModuleModel::select("version", "id")
                    ->where("name", "=", $module["name"])
                    ->where("type", "=", $type)
                    ->first();
                //already available
                if (count((array) $old) > 0) {
                    //check version is same
                    if ($old->version != $module["version"]) {
                        $obj = ModuleModel::find($old->id);
                        $obj->version = $module["version"];
                        if (isset($module["configuration"])) {
                            $obj->configuration_view = $module["configuration"];
                        }
                        if (isset($module["configuration_data"])) {
                            $obj->configuration_data =
                                $module["configuration_data"];
                        }
                        $obj->save();
                    }
                } else {
                    $obj = new ModuleModel();
                    $obj->name = $module["name"];
                    $obj->type = $type;
                    $obj->version = $module["version"];
                    if (isset($module["configuration"])) {
                        $obj->configuration_view = $module["configuration"];
                    }
                    if (isset($module["configuration_data"])) {
                        $obj->configuration_data =
                            $module["configuration_data"];
                    }
                    $obj->status = 1;
                    $obj->save();
                }
            }
        }
        \Log::channel("debug")->error("ModuleTenantUpdate3: ");
    }

    public static function getId($module_name, $type = 2)
    {
        $data = ModuleModel::where("name", "=", $module_name)
            ->where("type", $type)
            ->select("id")
            ->first();
        if (count((array) $data)) {
            return $data->id;
        } else {
            return 0;
        }
    }

    public static function registerModuleTenant($moduletype = "all")
    {
        $modules = Cms::allModules();
        \Log::channel("debug")->error("ModuleTenantUpdate4: ");
        if ($moduletype == "tenant") {
            $exclude = Configurations::EXCLUDEMODULES;

            foreach ($modules as $key => $value) {
                if (in_array($value["name"], $exclude)) {
                    unset($modules[$key]);
                }
            }
            foreach ($modules as $key => $value) {
                if (!in_array($value["name"], Session("module_list"))) {
                    unset($modules[$key]);
                }
            }
            \Log::channel("debug")->error("ModuleTenantUpdate4: ");
            // Reindex the array
            $modules = array_values($modules);
        }
        \Log::channel("debug")->error("ModuleTenantUpdate5: ");
        // get All tenants

        # code...
        foreach ($modules as $module) {
            $type = $module["type"] == "core" ? 1 : 2;
            $old = ModuleModel::select("version", "id")
                ->where("name", "=", $module["name"])
                ->where("type", "=", $type)
                ->first();
            //already available
            if (count((array) $old) > 0) {
                //check version is same
                $exist_sub_module = SubscriptionModuleModel::where(
                    "module_name",
                    "=",
                    $module["name"]
                )->first();
                if (!$exist_sub_module) {
                    $sub_obj = new SubscriptionModuleModel();
                    $sub_obj->module_name = $module["name"];
                    $sub_obj->module_description = $module["name"];
                    $sub_obj->module_slug = Str::slug($module["name"]);
                    $sub_obj->type = 2;
                    $sub_obj->save();
                }
                if ($old->version != $module["version"]) {
                    $obj = ModuleModel::find($old->id);
                    $obj->version = $module["version"];
                    if (isset($module["configuration"])) {
                        $obj->configuration_view = $module["configuration"];
                    }
                    if (isset($module["configuration_data"])) {
                        $obj->configuration_data =
                            $module["configuration_data"];
                    }
                    $obj->save();
                }
            } else {
                $obj = new ModuleModel();
                $obj->name = $module["name"];
                $obj->type = $type;
                $obj->version = $module["version"];
                if (isset($module["configuration"])) {
                    $obj->configuration_view = $module["configuration"];
                }
                if (isset($module["configuration_data"])) {
                    $obj->configuration_data = $module["configuration_data"];
                }
                $obj->status = 1;
                $obj->save();
            }
        }
        \Log::channel("debug")->error("ModuleTenantUpdate6: ");
    }
}
