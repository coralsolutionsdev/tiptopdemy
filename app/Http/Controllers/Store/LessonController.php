<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Media\Media;
use App\Product;
use App\Services\MediaManagerService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\Tags\Tag;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Vinkla\Hashids\Facades\Hashids;


class LessonController extends Controller
{
    protected $modelName;
    protected $page_title;
    protected $breadcrumb;

    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['GetIndex','show', 'getComments']]);
        $this->page_title = 'Store Lessons';
        $this->modelName = 'Store';
        $this->breadcrumb = [
            'Store' => '',
            'Lesson' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return Response
     */
    public function create(Product $product)
    {
        $page_title =  trans('main.Store Lessons') . ' - ' .__('main.Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                __('main.Create') => ''
            ];
        $groups = $product->groups->pluck('title', 'id')->toArray();
        $tags = Tag::getWithType('lesson')->pluck('name', 'name');
        $selectedTags =array();
        return view('store.lessons.create', compact('page_title','breadcrumb', 'product', 'groups','tags', 'selectedTags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return Response
     */
    public function store(Request $request, Product $product)
    {
        $input = $request->all();
        $input['product_id'] = $product->id;
        $lesson = Lesson::createOrUpdate($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect(route('store.products.edit', $product->slug). "/#lessons");

    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @param Lesson $lesson
     * @return Response
     */
    public function show(Product $product, Lesson $lesson)
    {
        if (!$product->isAvailable()){
            return redirect()->route('main');
        }
        $page_title =  $lesson->title;
        $modelName = $this->modelName;
        $breadcrumb =  Breadcrumbs::render('store.product.lesson', $lesson);
        $prevLesson = null;
        $nextLesson = null;
        $productLessons =  $product->lessons->sortBy('position');
        foreach ($productLessons as $key => $item){
            if ($item->id == $lesson->id){
                $prevLesson = $productLessons->get($key-1);
                $nextLesson = $productLessons->get($key+1);
                break;
            }
        }
        return view('store.lessons.frontend.show', compact('modelName','product','page_title','breadcrumb', 'lesson', 'prevLesson', 'nextLesson'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param Lesson $lesson
     * @return Response
     */
    public function edit(Product $product, Lesson $lesson)
    {
        $page_title =  trans('main.Store Lessons') . ' - ' .__('main.Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                __('main.Create') => ''
            ];
        $groups = $product->groups->pluck('title', 'id')->toArray();
        $selectedGroups = $lesson->groups->pluck('id')->toArray();
//        $tags = Tag::getWithType('lesson')->pluck('name', 'name');
//        $selectedTags = $lesson->getTags();
        $selectedTags = array();
        $categories = Category::where('type', Category::TYPE_FORM_TEMPLATE)->where('parent_id', 0)->get();
        $modelType = $lesson->getClassName();
        $mediaItems = $lesson->getMedia('youtube_video');
        return view('store.lessons.create', compact('page_title','breadcrumb', 'product', 'groups', 'selectedGroups', 'lesson', 'selectedTags', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @param Lesson $lesson
     * @return Response
     */
    public function update(Request $request, Product $product, Lesson $lesson)
    {
        $input = $request->all();
        Lesson::createOrUpdate($input, $lesson);
        session()->flash('success',__('Updated Successfully'));
        // re direct to courses
        return redirect(route('store.products.edit', $product->slug). "/#lessons");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Lesson $lesson
     * @return void
     * @throws Exception
     */
    public function destroy(Product $product, Lesson $lesson)
    {
        if (!empty($lesson)){
            $lesson->deleteWithDependencies();
        }
        session()->flash('success',__('Deleted Successfully'));
        return redirect(route('store.products.edit', $product->slug). "/#lessons");

    }

    /**
     * attach lesson media
     * @param Request $request
     * @return Application|ResponseFactory|Response
     * @throws UploadMissingFileException
     * @throws UploadFailedException
     */

    public function attachMediaOld(Request $request)
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
        $mediaType = isset($input['type']) ? $input['type'] : null;
        $embedUrl = isset($input['embed_url']) ?  $input['embed_url'] : null;
        $itemId = isset($input['item_id']) ? $input['item_id'] : null;
        $lesson = Lesson::find($itemId);

        // if request has file
        if ($request->hasFile('upload_file')) {
            $mediaType = Media::TYPE_VIDEO;
            // create the file receiver
            $receiver = new FileReceiver("upload_file", $request, HandlerFactory::classFromRequest($request));

            // check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            // receive the file
            $save = $receiver->receive();

            // check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                try {
                    $media = $lesson
                        ->addMedia($save->getFile())
                        ->toMediaCollection(Media::getGroup(Media::TYPE_VIDEO));
                } catch (FileException $e){
                    Log::error($e);
                }
            }
            if (!empty($media)){
                $status = Media::UPLOAD_TYPE_COMPLETED;
                $message = 'Media has attached successfully';
                $mediaId = $media->id;
                $mediaUrl = $media->getFullUrl();
                $mediaName = $media->name;
            }
        } else { // else
            if (!empty($input['embed_url'])){
                if (!empty($mediaType) && $mediaType == Media::TYPE_YOUTUBE){
                    $embedUrl = str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'], 'https://www.youtube.com/embed/', $embedUrl);
                }
                $mediaId = generateRandomString(4);
                $status = Media::UPLOAD_TYPE_COMPLETED;
                $message = 'Media has attached successfully';
                $mediaUrl = $embedUrl;
                $mediaName = '';
            }
        }
        if (!empty($lesson)){
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
            'status' => $status,
            'message' => $message,
            'id' => $mediaId,
            'url' => $mediaUrl,
            'name' => $mediaName,
            'type' => $mediaType,
        ];
        return response($media, 200);

    }
    public function attachMedia(Request $request, Lesson $lesson)
    {
        $media = array();
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            $file = $save->getFile();
            try {
                 $media = $this->saveFile($file);
            } catch (FileException $e){
                Log::error($e);
            }

        }


        return response()->json($media);

    }

    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path
        $filePath = "public/media/temp/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/".$filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }

//    protected function saveVideoFile(UploadedFile $file, $lesson)
//    {
////        $fileName = $this->createFilename($file);
//        // Group files by mime type
////        $mime = str_replace('/', '-', $file->getMimeType());
//        $type = strstr($file->getMimeType(), '/', true);
//        $mediaType = Media::TYPE_VIDEO;
//
//        // Group files by the date (week
//        $dateFolder = date("Y-m-W");
//
//        // Build the file path
////        $filePath = "upload/{$mime}/{$dateFolder}/";
////        $finalPath = storage_path("app/".$filePath);
////
////        // move the file name
////        $file->move($finalPath, $fileName);
//        $mediaFile = $lesson
//            ->addMedia($file)
//            ->toMediaCollection($type);
//
//        $status = Media::UPLOAD_TYPE_COMPLETED;
//        $message = 'Media has attached successfully';
//        $mediaId = $mediaFile->id;
//        $mediaUrl = $mediaFile->getFullUrl();
//        $mediaName = $mediaFile->name;
//
//        $media = [
//            'status' => $status,
//            'message' => $message,
//            'id' => $mediaId,
//            'url' => $mediaUrl,
//            'name' => $mediaName,
//            'type' => $mediaType,
//        ];
//
////        return response()->json($media);
//        return $media;
//    }

}
