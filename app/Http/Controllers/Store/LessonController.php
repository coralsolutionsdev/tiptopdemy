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
use Spatie\Tags\Tag;
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
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);

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

//        dd($lesson, $mediaItems, $mediaItems[0]->getFullUrl());
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
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);
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
        return redirect()->route('store.products.edit', $product->slug);

    }

    /**
     * attach lesson media
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */

    public function attachMedia(Request $request)
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
        $youtubeUrl = $input['youtube_url'];
        $htmlUrl = $input['html_url'];
        $mediaName = isset($input['media_name']) && !empty($input['media_name']) ? $input['media_name'] : null;

        // associated model collection
        $itemId = $input['item_id'];
        $model = $input['model_type'];

        if (empty($itemId) && empty($model)){
            // error
            $message = 'Undefiled model';
            $status = Media::UPLOAD_TYPE_REFUSED;
        }
        $lesson = Lesson::find($itemId);
//        $lesson = $model::find($itemId);

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
}
