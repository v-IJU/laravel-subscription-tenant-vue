<?php

namespace cms\core\subscription\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    protected $table = "module";
    protected $connection = "mysql";
    protected $guarded = [];
}
