<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;

class CmsSeviceModel extends Model
{
    protected $table = "cms_services";

    protected $fillable = ["service_name", "description", "status"];
}
