<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class CmsFeedbackModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = "cms_feedback";

    protected $appends = ["image_url"];

    protected $fillable = ["name","designation", "image", "description", "status"];

    public const CMS_FEEDBACK_PATH = "cms_feedback";

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
