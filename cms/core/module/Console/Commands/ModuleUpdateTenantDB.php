<?php

namespace cms\core\module\Console\Commands;

use App\Models\MultiTenant;
use Illuminate\Console\Command;
use Module;
use cms\core\subscription\Models\PlanPriceModel;
use cms\core\module\Models\ModuleModel;
use cms\core\subscription\Models\PlanFeatureModel;
use Session;
use cms\core\institute\Models\InstituteModel;
use cms\core\subscription\Models\SubscriptionModel;
use cms\core\subscription\Models\SubscriptionUser;

class ModuleUpdateTenantDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "tenants:update-module";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update Tenant Databases Module if any new module created";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenants = MultiTenant::get();

        if (sizeof($tenants)) {
            foreach ($tenants as $multitenant) {
                $schoolProfileDB = InstituteModel::where(
                    "tenant_id",
                    $multitenant->id
                )->first();
                $subuser = SubscriptionUser::where(
                    "user_id",
                    $schoolProfileDB->id
                )->first();
                // $plan = SubscriptionModel::find($subuser->subscription_plan_id);
                $filterList = PlanFeatureModel::where(
                    "subscription_plan_id",
                    $subuser->subscription_plan_id
                )
                    ->pluck("module_id")
                    ->toArray();
                $modulesArray = ModuleModel::whereIn("id", $filterList)
                    ->pluck("name")
                    ->toArray();
                $moduleList = $modulesArray;
                Session::put(["module_list" => $moduleList]);
                $multitenant->run(function () {
                    Module::registerModuleTenant("tenant");
                });

                $this->info("Module Updated:" . $multitenant->id);
            }
        }
    }
}
