<?php


namespace App\Services;


use App\Modules\Media\Media;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
                try {
                    $media = $modelItem
                        ->addMedia($mediaFile)
                        ->toMediaCollection(Media::getGroup($mediaType));
                } catch (FileException $e){
                    Log::error($e);
                }
            } elseif (in_array($mediaType, [Media::TYPE_YOUTUBE, Media::TYPE_HTML_PAGE])){
                try {
                    $media = $modelItem
                        ->addMediaFromUrl($mediaFile)
                        ->toMediaCollection(Media::getGroup($mediaType));
                } catch (FileException $e){
                    Log::error($e);
                }

            }
            if (!empty($media) && !empty($mediaName)){
                $media->name = $mediaName;
                $media->save();
            }
        }

        return $media;

    }

    /**
     * remove media from storage
     * @param $media
     */
    public static function deleteMedia($media)
    {
        $user = getAuthUser();
        if (empty($user) || empty($media)){
            abort(500);
        }
        Storage::deleteDirectory('media/'.$user->getTenancyId().'/'.$user->id.'/'.md5($media->id).'/');
    }

}