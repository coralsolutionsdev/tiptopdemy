<?php

namespace App\Http\Controllers\Media;

use App\Modules\Course\Lesson;
use App\Modules\Media\Media;
use App\Http\Controllers\Controller;
use App\Services\MediaManagerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * upload media TODO: change function name and controller
     * @param Request $request
     * @return JsonResponse
     * @throws UploadFailedException
     * @throws UploadMissingFileException
     */
    public function storeNaN(Request $request)
    {
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        return MediaManagerService::uploadChunkFiles($receiver);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws UploadFailedException
     * @throws UploadMissingFileException
     */
    public function store(Request $request) {
        // Response for the files - completed and uncompleted
        $files = $mediaFile = $mediaFileInfo = [];
        $user = getAuthUser();
        if (empty($user)){
            abort(500);
        }
        // Get array of files from request
        $files = $request->file('file');

        if (!empty($files)){
            if (is_array($files)) {
            //throw new UploadMissingFileException();
                // Loop sent files
                foreach ($files as $file) {
                    // Instead of passing the index name, pass the UploadFile object from the $files array we are looping
                    // Exception is thrown if file upload is invalid (size limit, etc)
                    // Create the file receiver via dynamic handler
                    $receiver = new FileReceiver($file, $request, HandlerFactory::classFromRequest($request));
                    // or via static handler usage
//            $receiver = new FileReceiver($file, $request, ContentRangeUploadHandler::class);

                    if ($receiver->isUploaded()) {
                        continue;
                    }
                    // receive the file
                    $save = $receiver->receive();

                    // check if the upload has finished (in chunk mode it will send smaller files)
                    if ($save->isFinished()) {
                        // save the file and return any response you need
//                $files[] = $this->saveFile($save->getFile());
                        $files[] = MediaManagerService::saveFile($save->getFile());;
                    } else {
                        // we are in chunk mode, lets send the current progress

                        /** @var ContentRangeUploadHandler $handler */
                        $handler = $save->handler();

                        // Add the completed file
                        $files[] = [
                            "progress" => $handler->getPercentageDone(),
                            "finished" => false
                        ];
                    }
                }
            }else{
                $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
                $media =  MediaManagerService::uploadChunkedFile($receiver);
                if (file_exists(storage_path("app/public/".$media['path'].$media['name']))){
                    $fileUrl = 'storage/'.$media['path'].$media['name'];
                    $mediaType = isset($media['media_type']) ? $media['media_type'] : null;

                    // create media record
                    $mediaFile = $user
                        ->addMediaFromUrl($fileUrl)
                        ->withCustomProperties([
                            'group' => null,
                            'extension' => !empty($media['extension']) ? $media['extension'] : null,
                            'duration' => !empty($media['duration']) ? $media['duration'] : null,
                        ])->toMediaCollection('file_manager');
                    if (!empty($media)){
                        $mediaFileInfo = [
                            'id' =>  $mediaFile->id,
                            'url' => $mediaFile->getFullUrl(),
                            'name' => $mediaFile->name,
                            'type' => $mediaType,
                        ];
                    }
                    Storage::deleteDirectory($media['path']);
                }
            }
        }
        return response()->json($mediaFileInfo);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxStore(Request $request)
    {
        $input =  $request->all();
        $message = null;
        $media = null;
        $mediaFile = null;
        $mediaId = null;
        $mediaUrl = null;
        $mediaName = null;
        $mediaType = null;
        $mediaFileName = null;
        $status = Media::UPLOAD_TYPE_IN_PROCESS; // 0 pending, 1 success,  2 not allowed
        $mediaType = $input['type'];
        $file = $request->file;;
        $mediaName = isset($input['media_name']) && !empty($input['media_name']) ? $input['media_name'] : null;

        // associated model collection
        $itemId = $input['item_id'];
        $model = $input['model_type'];

        if (empty($itemId) && empty($model)){
            // error
            $message = 'Undefiled model';
            $status = Media::UPLOAD_TYPE_REFUSED;
        }
        $lesson = $model::find($itemId);

        if (empty($lesson)){
            $message = 'Undefiled model item';
            $status = Media::UPLOAD_TYPE_REFUSED;
        }
        if (empty($mediaType)){
            $message = 'Undefiled media type';
            $status = Media::UPLOAD_TYPE_REFUSED;
        }
        if ($mediaType == Media::TYPE_VIDEO){
            if (!empty($file)){
                // check if its allowed to upload the file
                $fileExtension = $file->getClientOriginalExtension();
                if (!Media::isExtensionAllowed($fileExtension)){
                    $message = 'Media file is not supported';
                    $status = Media::UPLOAD_TYPE_REFUSED;

                }
                $mediaFile = $file;
            }else{
                $message = 'Undefiled media file';
                $status = Media::UPLOAD_TYPE_REFUSED;
            }
        } elseif ($mediaType == Media::TYPE_YOUTUBE){
            if (empty($youtubeUrl)){
                $message = 'Undefiled youtube url';
                $status = Media::UPLOAD_TYPE_REFUSED;
            }

            // $mediaFile = $youtubeUrl;
            $mediaFile = str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'], 'https://www.youtube.com/embed/', $youtubeUrl);
        } elseif ($mediaType == Media::TYPE_HTML_PAGE){
            if (empty($htmlUrl)){
                $message = 'Undefiled HTML url';
                $status = Media::UPLOAD_TYPE_REFUSED;
            }
            $mediaFile = $htmlUrl;
        }

        // if allowed to upload
        if ($status == Media::UPLOAD_TYPE_IN_PROCESS){
            if ($mediaType == Media::TYPE_VIDEO){
                $media =  MediaManagerService::store($lesson, $mediaType, $mediaFile, $mediaName);
                if (!empty($media)){
                    $status = Media::UPLOAD_TYPE_COMPLETED;
                    $message = 'Media has attached successfully';
                    $mediaId = $media->id;
                    $mediaUrl = $media->getFullUrl();
                    $mediaName = $media->name;
                }
            } else {
                $mediaId = generateRandomString(4);;
                $mediaUrl = $mediaFile;
                $message = 'Media has attached successfully';

            }
            // add media to lesson resources
            $resources = $lesson->resources;
            $resources[] = [
                'id' => $mediaId,
                'url' => $mediaUrl,
                'name' => $mediaName,
                'type' => $mediaType,
            ];
            $lesson->resources = $resources;
            $lesson->save();
        }

        $media = [
            'message' => $message,
            'status' => $status,
            'id' => $mediaId,
            'url' => $mediaUrl,
            'name' => $mediaName,
            'type' => $mediaType,
        ];
        return response( ['media' => $media], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modules\Media\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modules\Media\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modules\Media\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modules\Media\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }

    public function getMediaLibrary()
    {
        $user = getAuthUser();
        $mediaItems = $user->getMedia('file_manager');
        $mediaItems = $mediaItems->map(function ($item) {
            $item->url = $item->getFullUrl();
            return $item->only(['id', 'name', 'url', 'custom_properties']);

        })->toArray();

//        $mediaItems = $mediaItems->get();
        return response()->json($mediaItems);

    }
}
