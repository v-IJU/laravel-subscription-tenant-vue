<?php
namespace cms\core\configurations\Models;

use Illuminate\Database\Eloquent\Model;

class BotmanModel extends Model
{
    protected $table = 'botman';
    
    protected $fillable = [
        "category",
        "name",
        "value",
        "type",       
    ];
}
