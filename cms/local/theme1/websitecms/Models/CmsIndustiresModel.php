<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class CmsIndustiresModel extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = "cms_industries";

    protected $fillable = ["industry_name", "image", "description", "status"];

    public const CMS_INDUSTRIES_PATH = "cms_industries";

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
