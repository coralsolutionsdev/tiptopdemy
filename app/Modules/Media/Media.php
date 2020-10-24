<?php

namespace App\Modules\Media;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const TYPE_IMAGE = 1;
    const TYPE_PRODUCT_IMAGE = 2;
    const TYPE_PROFILE_IMAGE = 3;
    const TYPE_VIDEO = 10;
    const TYPE_YOUTUBE = 20;
    const TYPE_HTML_PAGE = 30;

    const TYPES_ARRAY = [
        self::TYPE_IMAGE => 'image',
        self::TYPE_PRODUCT_IMAGE => 'product_image',
        self::TYPE_PROFILE_IMAGE => 'profile_image',
        self::TYPE_VIDEO => 'video',
        self::TYPE_YOUTUBE => 'youtube_video',
        self::TYPE_HTML_PAGE => 'html_page',
    ];

    const UPLOAD_TYPE_IN_PROCESS = 0;
    const UPLOAD_TYPE_COMPLETED = 1;
    const UPLOAD_TYPE_REFUSED = 2;

    const ALLOWED_vid_EXTENSIONS = [
        'mov',
        'mpeg4',
        'mp4',
        'avi',
        'wmi',
        'mpegps',
        'flv',
        '3gpp',
        'webm',
        'webm',
    ];

    /**
     * check is extinction allowed
     * TODO: replace it with collection define method
     * @param $fileExtension
     * @param null $type
     * @return bool
     */
    public static function isExtensionAllowed($fileExtension, $type = null){
        return in_array($fileExtension, self::ALLOWED_vid_EXTENSIONS);
    }

    /**
     * @param $type
     * @return string
     */
    public static function getGroup($type){
        $group = self::TYPES_ARRAY[$type];
        if (!empty($group)){
            return $group;
        }
        return '';
    }
}
