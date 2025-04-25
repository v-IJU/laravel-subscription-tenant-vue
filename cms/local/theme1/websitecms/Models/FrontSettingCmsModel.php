<?php

namespace cms\websitecms\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class FrontSettingCmsModel extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = "front_settings_cms";

    public const PATH = "front-settings";

    public const HOME_IMAGE_PATH = "homepage-image";

    public const ABOUT_US_IMAGE_PATH = "about-us-image";

    public const SERVICES_IMAGE_PATH = "services-image";

    public const CONTACT_US_IMAGE_PATH = "contact-us-image";

    const ABOUT_US = 2;

    const HOME_PAGE = 1;

    const SERVICES = 3;

    const INDUSTRIES = 4;

    const ASSOCIATOR = 5;

    const FEEDBACK = 6;

    const CONTACT_US = 7;

    const CONTACT_INFO = 8;


    public $fillable = ["key", "value", "type"];

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
