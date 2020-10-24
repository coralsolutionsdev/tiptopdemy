<?php


namespace App\Services;


use App\Modules\Media\Media;

class MediaManagerService
{
    /**
     * media store
     * @param $modelItem
     * @param $mediaType
     * @param $mediaFile
     * @param null $mediaName
     * @return null
     */
    public static function store($modelItem, $mediaType, $mediaFile, $mediaName = null)
    {
        $media = null;
        if (!empty($modelItem) && !empty($mediaType) && !empty($mediaFile)){
            if (in_array($mediaType, [Media::TYPE_VIDEO, Media::TYPE_IMAGE, Media::TYPE_PRODUCT_IMAGE, Media::TYPE_PROFILE_IMAGE])){
                $media = $modelItem
                    ->addMedia($mediaFile)
                    ->toMediaCollection(Media::getGroup($mediaType));
            } elseif (in_array($mediaType, [Media::TYPE_YOUTUBE, Media::TYPE_HTML_PAGE])){
                $media = $modelItem
                    ->addMediaFromUrl($mediaFile)
                    ->toMediaCollection(Media::getGroup($mediaType));
            }
            if (!empty($media) && !empty($mediaName)){
                $media->name = $mediaName;
                $media->save();
            }
        }

        return $media;

    }

}