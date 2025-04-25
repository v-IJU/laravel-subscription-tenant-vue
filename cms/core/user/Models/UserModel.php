<?php

namespace cms\core\user\Models;

use cms\core\configurations\helpers\Configurations;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserModel extends Model implements HasMedia
{
    use HasApiTokens, InteractsWithMedia, Notifiable;

    const COLLECTION_PROFILE_PICTURES = "user/profile";

    protected $appends = ["image_url", "full_name"];
    protected $table = "users";

    protected $hidden = ["password"];

    protected $guarded = [];

    public function group()
    {
        return $this->belongsToMany(
            "cms\core\usergroup\Models\UserGroupModel",
            "user_group_map",
            "user_id",
            "group_id"
        );

        //->withPivot([ ARRAY OF FIELDS YOU NEED FROM meta TABLE ]);
        //return $this->hasManyThrough('cms\core\usergroup\Models\UserGroupModel','cms\core\usergroup\Models\UserGroupMapModel',
        // 'user_id','id','id');
    }
    public function groupMap()
    {
        return $this->hasMany(
            "cms\core\usergroup\Models\UserGroupMapModel",
            "user_id",
            "id"
        );
    }

    public function owner()
    {
        return $this->morphTo();
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
    public function getImageUrlAttribute()
    {
        $media = $this->getMedia(self::COLLECTION_PROFILE_PICTURES)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return Configurations::getUserImageInitial($this->id, $this->full_name);
    }
}
