<?php

namespace cms\product\Models;

use cms\parent\Models\ChildModel;
use cms\school\Models\SchoolModel;
use cms\sizecategory\Models\ColorModel;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $table = "cart";

    protected $fillable = [
        "parent_id",
        "school_id",
        "class_id",
        "child_id",
        "product_id",
        "variant_id",
        "product_size",
        "product_meta",
        "price",
        "gst",
        "gst_amount",
        "quantity",
        "total_amount",
        "color_id",
        "snitching_information",
        "price_inclusive_gst",
    ];
    protected $casts = ["product_meta" => "array"];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, "product_id", "id");
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariantModel::class, "variant_id", "id");
    }

    public function school()
    {
        return $this->belongsTo(SchoolModel::class, "school_id");
    }

    public function child()
    {
        return $this->belongsTo(ChildModel::class, "child_id");
    }

    public function housecolor()
    {
        return $this->belongsTo(ColorModel::class, "color_id");
    }
}
