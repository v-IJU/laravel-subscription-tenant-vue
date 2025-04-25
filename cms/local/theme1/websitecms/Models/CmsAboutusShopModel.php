<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class CmsAboutusShopModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = "aboutus_shop";

    protected $appends = ["image_url"];

    protected $fillable = ["category","title", "image", "description", "status"];

    public const CMS_ABOUTUSSHOP_PATH = "cms_aboutushop";

    public function getImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return $this->value;
    }
}
