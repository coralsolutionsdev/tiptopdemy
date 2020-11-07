<?php


namespace App\Services;


use App\Modules\Media\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
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

    public static function uploadChunkFiles($receiver)
    {
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return self::saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
//        $handler = $save->handler();

        return response()->json();
    }
    protected static function saveFile(UploadedFile $file)
    {
        $fileName = self::createFilename($file);

        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        $type = strstr($file->getMimeType(), '/', true);
        $fileExtension = $file->getClientOriginalExtension();

        // Group files by the date (week
        $dateFolder = md5($fileName);

        // Build the file path
        $filePath = "public/media/temp/{$dateFolder}/";
        $finalPath = storage_path("app/".$filePath);
        $storageFilePath = "media/temp/{$dateFolder}/";

        // move the file name
        $file->move($finalPath, $fileName);
        $fullPath = $finalPath.$fileName;
        $duration =  self::getDuration($fullPath);
        return response()->json([
            'path' => $storageFilePath,
            'name' => $fileName,
            'file_type' => $type,
            'mime_type' => $mime,
            'extension' => $fileExtension,
            'duration' => $duration,
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected static function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
    protected static function getDuration($full_video_path)
    {
        $getID3 = new \getID3;
        $file = $getID3->analyze($full_video_path);
        $playtime_seconds = $file['playtime_seconds'];
        return date('H:i:s', $playtime_seconds);
    }

}