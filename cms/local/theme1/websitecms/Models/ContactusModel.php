<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;

class ContactusModel extends Model
{


    protected $table = "contact_us";

    protected $fillable = ["first_name","last_name", "subject", "description", "phone", "email"];

}
