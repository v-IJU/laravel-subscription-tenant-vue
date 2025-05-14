<?php

namespace cms\core\subscription\Models;

use Illuminate\Database\Eloquent\Model;
use cms\core\subscription\Models\PlanFeatureModel;
class SubscriptionModel extends Model
{
    protected $table = "subscription_plans";

    protected $guarded = [];
    protected $connection = "mysql";

    public function features()
    {
        return $this->hasMany(PlanFeatureModel::class, "subscription_plan_id");
    }
}
