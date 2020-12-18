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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title =  'File Manager';
        $breadcrumb =  [];

        return view('system.file-manager.index', compact('page_title','breadcrumb'));
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
     * upload media
     * @param Request $request
     * @return JsonResponse
     * @throws UploadFailedException
     * @throws UploadMissingFileException
     */
    public function store(Request $request): JsonResponse
    {
        // create the file receiver
        $modal = getAuthUser();
        if (empty($modal)){
            abort(500);
        }
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

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
            return MediaManagerService::attachMedia($save->getFile(), $modal);
        }

        // we are in chunk mode, lets send the current progress
        // @var AbstractHandler $handler */
        // $handler = $save->handler();

        return response()->json();
    }


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
            $item->creation_date = date_html($item->created_at);
            return $item->only(['id', 'name', 'url','creation_date', 'custom_properties']);

        })->toArray();
        return response()->json($mediaItems);

    }
    public function ajaxDestroy(Media $media)
    {
        // TODO: check if use can remove this media item
        $user = getAuthUser();
        if (!empty($user)){
            $userMedia = $user->getMedia('file_manager')->where('id', $media->id)->first();
            if (!empty($userMedia) && $userMedia->id == $media->id){
                $media->delete();
                return response('success', 200);
            }
        }
        return response('error', 503);

    }
}
