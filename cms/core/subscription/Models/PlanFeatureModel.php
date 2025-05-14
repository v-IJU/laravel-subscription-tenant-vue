<?php

namespace cms\core\subscription\Models;

use Illuminate\Database\Eloquent\Model;

class PlanFeatureModel extends Model
{
    protected $table = "plan_features";

    protected $guarded = [];
    protected $connection = "mysql";
}
