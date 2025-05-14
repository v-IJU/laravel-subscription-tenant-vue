<?php

namespace cms\core\institute\Models;

use Illuminate\Database\Eloquent\Model;

class InstituteModel extends Model
{
    protected $table = "institute";

    protected $guarded = [];
    protected $connection = "mysql";
}
