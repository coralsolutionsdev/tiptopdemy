<?php

namespace App\Http\Controllers\Media;

use App\Modules\Course\Lesson;
use App\Modules\Media\Media;
use App\Http\Controllers\Controller;
use App\Services\MediaManagerService;
use Illuminate\Http\Request;

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
                    $mediaUrl = $media->getUrl();
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
}
