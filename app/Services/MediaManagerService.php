<?php


namespace App\Services;


use App\Modules\Group\Group;
use App\Modules\Media\Media;
use Illuminate\Http\JsonResponse;
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


    /**
     * upload big files with chunking
     * @param $receiver
     * @return JsonResponse
     * @throws UploadMissingFileException
     */
    public static function uploadChunkFiles($receiver): JsonResponse
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


    /**
     * upload big files with chunking
     * @param $receiver
     * @return array
     * @throws UploadMissingFileException
     */
    public static function uploadChunkedFile($receiver): ?array
    {

        $media = null;
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
            $media = self::saveChunkedFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
//        $handler = $save->handler();

        return $media;
    }

    /**
     * save uploaded file
     * @param UploadedFile $file
     * @return JsonResponse
     */
    public static function saveFile(UploadedFile $file)
    {
        $fileName = self::createFilename($file);
        $duration = null;
        $user = getAuthUser();
        if (empty($user)){
            abort('500');
        }
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        $fileExtension = $file->getClientOriginalExtension();
        $type = strstr($file->getMimeType(), '/', true);
        $mediaType = Media::TYPE_VIDEO;

        // Group files by the date (week
        $userPath = md5($user->getTenancyId()).'/'.md5($user->id);
        $fileFolder = md5($fileName);

        // Build the file path
        $filePath = "public/media/temp/{$userPath}/{$fileFolder}/";
        $finalPath = storage_path("app/".$filePath);
        $storageFilePath = "media/temp/{$userPath}/{$fileFolder}/";

        // move the file name
        $file->move($finalPath, $fileName);
        $fullPath = $finalPath.$fileName;
        if ($type == Media::TYPE_VIDEO){
            $duration =  self::getDuration($fullPath);
        }
        return response()->json([
            'path' => $storageFilePath,
            'name' => $fileName,
            'file_type' => $type,
            'media_type' => $mediaType,
            'mime_type' => $mime,
            'extension' => $fileExtension,
            'duration' => $duration,
        ]);
    }


    /**
     * save uploaded file
     * @param UploadedFile $file
     * @return array
     */
    public static function saveChunkedFile(UploadedFile $file)
    {
        $fileName = self::createFilename($file);
        $duration = null;
        $user = getAuthUser();
        if (empty($user)){
            abort('500');
        }
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        $fileExtension = $file->getClientOriginalExtension();
        $type = strstr($file->getMimeType(), '/', true);
        $mediaType = Media::TYPE_VIDEO;

        // Group files by the date (week
        $userPath = md5($user->getTenancyId()).'/'.md5($user->id);
        $fileFolder = md5($fileName);

        // Build the file path
        $filePath = "public/media/temp/{$userPath}/{$fileFolder}/";
        $finalPath = storage_path("app/".$filePath);
        $storageFilePath = "media/temp/{$userPath}/{$fileFolder}/";

        // move the file name
        $file->move($finalPath, $fileName);
        $fullPath = $finalPath.$fileName;
        if ($type == Media::TYPE_VIDEO){
            $duration =  self::getDuration($fullPath);
        }
        return [
            'path' => $storageFilePath,
            'name' => $fileName,
            'file_type' => $type,
            'media_type' => $mediaType,
            'mime_type' => $mime,
            'extension' => $fileExtension,
            'duration' => $duration,
        ];
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     * @param $modal
     * @return JsonResponse
     */
    public static function attachMedia(UploadedFile $file, $modal, $groupSlug =  null): JsonResponse
    {
        $user = getAuthUser();
        if (empty($user) || empty($modal)){
            abort(500);
        }

        $filePlaytimeString = $filePlaytimeSeconds = $fileSize = null;
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // File extension
        $fileExtension = $file->getClientOriginalExtension();
        // File Type
        $fileType = strstr($file->getMimeType(), '/', true);
        // File properties
        if ($fileType == 'video'){
            $filePlaytimeString = MediaManagerService::getProperties($file, 'playtime_string');
            $filePlaytimeSeconds = MediaManagerService::getProperties($file, 'playtime_seconds');
        }
        $fileSize = MediaManagerService::getProperties($file, 'filesize');

        // attach media file name
        $mediaFile = $modal->addMedia($file)
            ->withCustomProperties([
                'group' => $groupSlug,
                'extension' => !empty($fileExtension) ? $fileExtension : null,
                'file_type' => !empty($fileType) ? $fileType : null,
                'mime_type' => !empty($mime) ? $mime : null,
                'playtime_string' => $filePlaytimeString,
                'playtime_seconds' => $filePlaytimeSeconds,
                'file_size' => $fileSize,
                'file_size_string' => getFileSize($fileSize, 1),
            ])->toMediaCollection('file_manager');

        if (!is_null($groupSlug)){
            $group = Group::where('slug', $groupSlug)->first();
                $group->mediaItems()->sync([
                [
                    'model_id' => $mediaFile->id,
                ]
            ]);
        }

        if (!empty($mediaFile)){
            return response()->json([
                'id' => $mediaFile->id,
                'name' => $mediaFile->name,
                'url' => $mediaFile->getFullUrl(),
                'path' => $mediaFile->getPath(),
                'mime_type' => $mime,
                'file_type' => $fileType,
                'extension' => $fileExtension,
                'playtime_string' => $filePlaytimeString,
                'playtime_seconds' => $filePlaytimeSeconds,
                'file_size' => $fileSize,
                'file_size_string' => getFileSize($fileSize, 1),
                'created_at' => date_html($mediaFile->created_at),
            ]);
        }
        return response()->json();

    }


    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    public static function createFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }
    /**
     * calculate video duration
     * @param $full_video_path
     * @return false|string
     */
    protected static function getDuration($full_video_path)
    {
        $getID3 = new \getID3;
        $file = $getID3->analyze($full_video_path);
        $playtime_seconds = $file['playtime_seconds'];
        return date('H:i:s', $playtime_seconds);
    }

    /**
     * get properties by key
     * @param $full_video_path
     * @param $propertiesValue
     * @return mixed|null
     */
    public static function getProperties($full_video_path, $propertiesValue)
    {
        $getID3 = new \getID3;
        $file = $getID3->analyze($full_video_path);
        if (!empty($propertiesValue) && !empty($file[$propertiesValue])){
            return $file[$propertiesValue];
        }
        return null;
    }

}