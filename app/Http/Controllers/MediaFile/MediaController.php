<?php

namespace App\Http\Controllers\MediaFile;

use Hashids\Hashids;
use App\Modules\Group\Group;
use Illuminate\Http\Request;
use App\Modules\Course\Lesson;
use App\Modules\Media\MediaFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\MediaManagerService;
use Illuminate\Support\Facades\Storage;
use App\Services\FileAssetManagerService;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;

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
        $user = getAuthUser();
//        $mediaItems = $user->getMedia('file_manager')->sortDesc('created_at');
//        $mediaItems = \Spatie\MediaLibrary\Models\MediaFile::where('model_type', 'App\User')->where('model_id', $user->id)->where('collection_name', 'file_manager')->get()->sortByDesc('created_at');
//        dd($mediaItems);
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
        $group = $request->group;
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
            return MediaManagerService::attachMedia($save->getFile(), $modal, $group);
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
        $status = MediaFile::UPLOAD_TYPE_IN_PROCESS; // 0 pending, 1 success,  2 not allowed
        $mediaType = $input['type'];
        $file = $request->file;;
        $mediaName = isset($input['media_name']) && !empty($input['media_name']) ? $input['media_name'] : null;

        // associated model collection
        $itemId = $input['item_id'];
        $model = $input['model_type'];

        if (empty($itemId) && empty($model)){
            // error
            $message = 'Undefiled model';
            $status = MediaFile::UPLOAD_TYPE_REFUSED;
        }
        $lesson = $model::find($itemId);

        if (empty($lesson)){
            $message = 'Undefiled model item';
            $status = MediaFile::UPLOAD_TYPE_REFUSED;
        }
        if (empty($mediaType)){
            $message = 'Undefiled media type';
            $status = MediaFile::UPLOAD_TYPE_REFUSED;
        }
        if ($mediaType == MediaFile::TYPE_VIDEO){
            if (!empty($file)){
                // check if its allowed to upload the file
                $fileExtension = $file->getClientOriginalExtension();
                if (!MediaFile::isExtensionAllowed($fileExtension)){
                    $message = 'MediaFile file is not supported';
                    $status = MediaFile::UPLOAD_TYPE_REFUSED;

                }
                $mediaFile = $file;
            }else{
                $message = 'Undefiled media file';
                $status = MediaFile::UPLOAD_TYPE_REFUSED;
            }
        } elseif ($mediaType == MediaFile::TYPE_YOUTUBE){
            if (empty($youtubeUrl)){
                $message = 'Undefiled youtube url';
                $status = MediaFile::UPLOAD_TYPE_REFUSED;
            }

            // $mediaFile = $youtubeUrl;
            $mediaFile = str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'], 'https://www.youtube.com/embed/', $youtubeUrl);
        } elseif ($mediaType == MediaFile::TYPE_HTML_PAGE){
            if (empty($htmlUrl)){
                $message = 'Undefiled HTML url';
                $status = MediaFile::UPLOAD_TYPE_REFUSED;
            }
            $mediaFile = $htmlUrl;
        }

        // if allowed to upload
        if ($status == MediaFile::UPLOAD_TYPE_IN_PROCESS){
            if ($mediaType == MediaFile::TYPE_VIDEO){
                $media =  MediaManagerService::store($lesson, $mediaType, $mediaFile, $mediaName);
                if (!empty($media)){
                    $status = MediaFile::UPLOAD_TYPE_COMPLETED;
                    $message = 'MediaFile has attached successfully';
                    $mediaId = $media->id;
                    $mediaUrl = $media->getFullUrl();
                    $mediaName = $media->name;
                }
            } else {
                $mediaId = generateRandomString(4);;
                $mediaUrl = $mediaFile;
                $message = 'MediaFile has attached successfully';

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
     * @param  \App\Modules\Media\MediaFile  $media
     * @return \Illuminate\Http\Response
     */
    public function show(MediaFile $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modules\Media\MediaFile  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(MediaFile $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modules\Media\MediaFile  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MediaFile $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modules\Media\MediaFile  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(MediaFile $media)
    {
        //
    }

    public function getMediaLibrary(Request $request)
    {
        $input = $request->all();
        $user = getAuthUser();
        $group = $input['group'];
        $mediaItems = $user->getMedia('file_manager');
        $mediaItems = $mediaItems->filter(function ($mediaItem) use($group){
            if ($mediaItem->getCustomProperty('group') == $group){
                return true;
            }
            return false;
        })->map(function ($item) {
            $item->url = $item->getFullUrl();
            $item->creation_date = date_html($item->created_at);
            return $item->only(['id', 'name', 'url','creation_date', 'custom_properties']);

        })->toArray();
        return response()->json($mediaItems);

    }

    public function getItems(Request $request)
    {
        $input = $request->all(['group','type']);
        $user = getAuthUser();
        $items = array();
//        $mediaItems = $user->getMedia('file_manager')->sortBy('name');
        $mediaItems = Media::where('model_type', 'App\User')->where('model_id', $user->id)->where('collection_name', 'file_manager')->get();
        $group = isset($input['group']) ? $input['group'] : null;
        $mediaItems = $mediaItems->sortBy('name')->filter(function ($mediaItem) use($group){
            if ($mediaItem->getCustomProperty('group') == $group){
                return true;
            }
            return false;
        });
        foreach ($mediaItems as $item){
            $items[] = [
                'id'=> $item->id,
                'name'=> $item->name,
                'url'=> $item->getFullUrl(),
                'creation_date'=> date_html($item->created_at),
                'custom_properties'=> $item->custom_properties,
            ];
        }
        return response()->json($items);
    }
    public function ajaxDestroy(MediaFile $media)
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


    public function ajaxMove(Request $request)
    {
        $user = getAuthUser();
        $input = $request->only(['id', 'title', 'group_slug']);
        $id = $input['id'];
        $inputGroupSlug = isset($input['group_slug']) ? $input['group_slug'] : null;
        $mediaItem = $user->getMedia('file_manager')->where('id', $id)->first();
        if ($mediaItem){
            // current group slug
            $mediaItemGroupSlug = $mediaItem->getCustomProperty('group');
            if (!empty($mediaItemGroupSlug) || $mediaItemGroupSlug != 'null' || $mediaItemGroupSlug != null){
                // remove from current group group item
                if ($currentGroup = Group::where('slug',$mediaItemGroupSlug)->first()){
                    $currentGroup->mediaItems()->detach([
                        [
                            'model_id' => $mediaItem->id,
                        ]
                    ]);
                }

            }
            // move to the new
            if (!empty($inputGroupSlug)){
                if ($nextGroup = Group::where('slug', $inputGroupSlug)->first()){
                    $nextGroup->mediaItems()->attach([
                        [
                            'model_id' => $mediaItem->id,
                        ]
                    ]);
                    $mediaItem->setCustomProperty('group', $inputGroupSlug);
                }


            }else{
                $mediaItem->setCustomProperty('group', null);

            }
            if (isset($input['title'])){
                $mediaItem->name = $input['title'];
            }
            $mediaItem->save();
        }

        return response('success', 200);

    }

    function editorImageUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            $user = getAuthUser();
            $mediaInfo = $path = $url = null;
            $file = $request->file;
            $hashids = new Hashids();
            $companyHashId = $hashids->encode(1);
            $fileName = $file->getClientOriginalName();

            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // same-origin requests won't set an origin. If the origin is set, it must be valid.
                if ($_SERVER['HTTP_ORIGIN'] == url('/')) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    header("HTTP/1.0 403 Origin Denied");
                    return;
                }
            }

            /*
              If your script needs to receive cookies, set images_upload_credentials : true in
              the configuration and enable the following two headers.
            */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $fileName)) {
                header("HTTP/1.0 500 Invalid file name.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $image = $file;
//            $location =  'attachments/'.$companyHashId.'/images';
//            $path = FileAssetManagerService::ImageStore($image,$location);
            $media = MediaManagerService::attachMedia($image, $user);
            if (!empty($media)){
                $mediaInfo = $media->original;
                $path = $mediaInfo['path'];
                $url =  $mediaInfo['url'];
            }
            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
//            $attachmentUrl = url('storage/'.$path);
            $item = [
                'path' =>  $path,
                'url' =>  $url,
            ];
            echo json_encode(array('item' => $item));
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.0 500 Server Error");
        }

    }
}
