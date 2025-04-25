<?php

namespace cms\product\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;
use cms\core\user\Models\AddressModel;
use cms\schoolclass\Models\SchoolclassModel;
use cms\core\configurations\Traits\FileUploadTrait;
use cms\school\Models\SchoolModel;
use cms\product\Models\ProductVariantModel;
use cms\sizecategory\Models\SizeModel;


class ProductModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    use FileUploadTrait;

    protected $table = "products";

    public const COLLECTION_PRODUCT_PICTURES = "product/profile";

    public const PRODUCT_SIZE_CHART = "/schooluniform/sizechart/size_chart.pdf";

    protected $guarded = [];

    protected $appends = ["image_url", "sizepdf_url"];

    protected $fillable = [
        "school_id",
        "class_id",
        "product_code",
        "product_name",
        "product_description",
        "is_variable_product",
        "gender_id",
        "rate",
        "gst",
        "status",
        "category_attribute_id",
        "base_rate",
    ];

    public function getImageUrlAttribute()
    {
        $mediaFiles = $this->retrieveMediaFiles(
            $this, self::COLLECTION_PRODUCT_PICTURES
        );

        return !empty($mediaFiles) ? $mediaFiles[0]["url"] : null;
    }

    public function getSizepdfUrlAttribute()
    {
        return self::PRODUCT_SIZE_CHART;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    //calling morphTo() in address model class
    public function addressess()
    {
        return $this->morphOne(AddressModel::class, "owner");
    }

    public function address()
    {
        return $this->morphOne(AddressModel::class, "owner");
    }

    public function variant()
    {
        return $this->hasMany(ProductVariantModel::class, "product_id", "id");
    }

    public function school()
    {
        return $this->belongsTo(SchoolModel::class, "school_id", "id");
    }

    public function classes()
    {
        return $this->belongsTo(SchoolclassModel::class, "class_id");
    }

    public function sizes()
    {
        return $this->belongsTo(SizeModel::class, "category_attribute_id", "id");
    }



}
