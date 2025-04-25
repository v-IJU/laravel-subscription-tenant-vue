<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class CmsAssociatorModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = "cms_associators";

    protected $appends = ["image_url"];

    protected $fillable = ["image", "status"];

    public const CMS_ASSOCIATOR_PATH = "cms_associator";

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
