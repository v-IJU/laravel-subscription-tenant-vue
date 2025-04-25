<?php

namespace cms\customer\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class CustomerModel extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = "customers";

    protected $fillable = ["name", "email", "password", "type"];
    protected $hidden = ["password"];
}
