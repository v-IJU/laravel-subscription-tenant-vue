<?php

namespace cms\core\user\Models;

use cms\core\configurations\helpers\Configurations;
use Illuminate\Database\Eloquent\Model;
use Arr;
class AddressModel extends Model
{
    protected $table = "addresses";
    protected $fillable = [
        "address1",
        "address2",
        "city",
        "zip",
        "owner_id",
        "owner_type",
        "state",
        "country",
        "parent_id",
        "latitude",
        "longitude",
        "is_parent_delivery_address",
        "phone_number",
        "name",
    ];
    protected $guarded = [];

    public function owner()
    {
        return $this->morphTo();
    }

    public static function prepareAddressArray($input)
    {
        return Arr::only(array_filter($input), [
            "address1",
            "address2",
            "city",
            "zip",
            "state",
            "country",
        ]);
    }
}
