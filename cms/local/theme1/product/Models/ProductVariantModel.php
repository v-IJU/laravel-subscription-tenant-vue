<?php

namespace cms\product\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use cms\product\Models\ProductModel;
use cms\core\user\Models\AddressModel;
use cms\sizecategory\Models\SizecategoryModel;
use cms\sizecategory\Models\SizeModel;

use Illuminate\Database\Eloquent\Model;

class ProductVariantModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = "product_variants";

    public const COLLECTION_PRODUCT_VARIANT_PICTURES = "productvariants/profile";

    protected $guarded = [];

    protected $appends = ["image_url"];

    protected $fillable = [
        "product_id",
        "category_id",
        "product_size_id",
        "rate",
        "gst",
        "item_code",
        "base_rate",
    ];

    public function getImageUrlAttribute()
    {
        $mediaItems = $this->getMedia(
            self::COLLECTION_PRODUCT_VARIANT_PICTURES
        );
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        if ($mediaItems->isNotEmpty()) {
            return $mediaItems
                ->map(function ($media) {
                    return $media->getFullUrl();
                })
                ->toArray();
        }
        return [];
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

    /**
     * Get the parent that owns the ProductVariantModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductModel::class, "product_id", "id");
    }

    public function sizecategoryinfo()
    {
        return $this->belongsTo(SizecategoryModel::class, "category_id", "id");
    }

    public function sizeinfo()
    {
        return $this->belongsTo(SizeModel::class, "product_size_id", "id");
    }
}
