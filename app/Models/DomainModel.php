<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainModel extends Model
{
    protected $table = "domains";
    protected $guarded = [];
    protected $connection = "mysql";
}
