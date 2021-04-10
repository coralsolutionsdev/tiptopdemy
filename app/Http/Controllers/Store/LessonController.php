<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Form\Form;
use App\Modules\Form\FormItem;
use App\Modules\Form\FormResponse;
use App\Modules\Media\Media;
use App\Product;
use App\Services\MediaManagerService;
use Carbon\Carbon;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
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
        $prevLessonLink = null;
        $nextLessonLink = null;
        $group = $lesson->groups->first();
        foreach ($group->getLessons as $itemKey => $lessonItem){
            if ($lessonItem->id == $lesson->id){
                $preItem = !empty($group->getLessons[$itemKey-1]) ? $group->getLessons[$itemKey-1] : null;
                $nextItem = !empty($group->getLessons[$itemKey+1]) ? $group->getLessons[$itemKey+1] : null;

            }
        }
        if (!empty($preItem)){
            $prevLessonLink = route('store.lesson.show', [$product->slug, $preItem->slug]);
        }
        if (!empty($nextItem)){
            $nextLessonLink = route('store.lesson.show', [$product->slug, $nextItem->slug]);
        }
        $attachments = $lesson->attachments()->get();
        $content = !empty($lesson->content) && !empty($lesson->content['html']) ? $lesson->content['html'] : '';
        return view('store.lessons.frontend.show', compact('modelName','product','page_title','breadcrumb', 'lesson', 'prevLessonLink', 'nextLessonLink', 'attachments', 'content'));

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
        $attachments = $lesson->attachments()->get();

        return view('store.lessons.create', compact('page_title','breadcrumb', 'product', 'groups', 'selectedGroups', 'lesson', 'selectedTags', 'categories', 'attachments'));

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
     * upload media TODO: change function name and controller
     * @param Request $request
     * @return JsonResponse
     * @throws UploadFailedException
     * @throws UploadMissingFileException
     */
    public function attachMedia(Request $request) {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        return MediaManagerService::uploadChunkFiles($receiver);
    }

    /**
     * @param Request $request
     * @param Lesson $lesson
     * @return JsonResponse
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws FileCannotBeAdded
     */
    public function addResourcesItem(Request $request, Lesson $lesson){
        $input = $request->only(['name', 'path', 'mime_type', 'file_type', 'media_type', 'extension', 'duration']);
        $message = $mediaId = $mediaUrl = $mediaType = $mediaName = null;
        $status = Media::UPLOAD_TYPE_REFUSED;
        $mediaType = isset($input['media_type']) ? $input['media_type'] : null;

        if (!empty($mediaType)){
            if ($mediaType == Media::TYPE_VIDEO){
                // save media from file url
                // check if file is already exist
                if (!empty($lesson) && file_exists(storage_path("app/public/".$input['path'].$input['name']))){

                    $fileUrl = 'storage/'.$input['path'].$input['name'];
                    // create media record
                    $media = $lesson
                        ->addMediaFromUrl($fileUrl)
                        ->withCustomProperties([
                            'extension' => !empty($input['extension']) ? $input['extension'] : null,
                            'duration' => !empty($input['duration']) ? $input['duration'] : null,
                        ])
                        ->toMediaCollection($input['file_type']);

                    if (!empty($media)){
                        $mediaId = $media->id;
                        $status = Media::UPLOAD_TYPE_COMPLETED;
                        $message = 'Media has attached successfully';
                        $mediaUrl = $media->getFullUrl();
                        $mediaName = $media->name;
                    }
                    // remove file from storage
                    Storage::deleteDirectory($input['path']);
                }
            } elseif (in_array($mediaType, [Media::TYPE_YOUTUBE, Media::TYPE_HTML_PAGE])){
                $embedUrl = $input['path'];
                if ($mediaType == Media::TYPE_YOUTUBE){
                    $embedUrl = str_replace(['https://www.youtube.com/watch?v=','https://youtu.be/'], 'https://www.youtube.com/embed/', $input['path']);
                }
                $mediaId = generateRandomString(6);
                $status = Media::UPLOAD_TYPE_COMPLETED;
                $message = 'Media has attached successfully';
                $mediaUrl = $embedUrl;
                $mediaName = $input['name'];
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

        return response()->json([
            'status' => $status,
            'message' => $message,
            'id' => $mediaId,
            'url' => $mediaUrl,
            'name' => $mediaName,
            'type' => $mediaType,
        ]);
    }

    /**
     * edit lesson content
     * @param Product $product
     * @param Lesson $lesson
     * @return Application|Factory|View
     */
    public function editContent(Product $product, Lesson $lesson)
    {
        $mediaOwner = $lesson->getClassName();
        $htmlContent = '';
        if (!empty($lesson) && !empty($lesson->content) && !empty($lesson->content['html'])){
            $htmlContent = $lesson->content['html'];
        }
        $updateRoute = route('store.lesson.update.content', [$product->slug, $lesson->slug]);
        return view('system.page-builder.index', compact('mediaOwner', 'product', 'lesson', 'htmlContent', 'updateRoute'));
    }

    /**
     * update lesson content
     * @param Request $request
     * @param Product $product
     * @param Lesson $lesson
     * @return RedirectResponse
     */
    public function updateContent(Request $request, Product $product, Lesson $lesson): RedirectResponse
    {
        $input = $request->only(['content']);
        $search = 'controls="controls"';
        $replace = 'controls controlsList="nodownload"';
        $html = str_replace($search, $replace, $input['content']);
        $contentArr = [
            'html' => $html,
            'editor_version' => 1.00,
        ];
        $lesson->content = $contentArr;
        $lesson->save();
        session()->flash('success',__('Updated Successfully'));
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);
    }

    /**
     * delete attachment
     * @param Lesson $lesson
     * @param $key
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    function attachmentDelete(Lesson $lesson, $key)
    {
        $attachment = $lesson->attachment($key);
        if ($attachment){
            $attachment->delete();
        }
        return response($key, 200);
    }

    public function getItems(Lesson $lesson)
    {
        $product = $lesson->product;
        $content = !empty($lesson->content) && !empty($lesson->content['html']) ? $lesson->content['html'] : '';
        $description = !empty($lesson->description) ? $lesson->description : '';
        $resources = !empty($lesson->resources) ? $lesson->resources : array();
        $forms = $lesson->getAvailableForms(Form::STATUS_PUBLISHED);
        $formsArray = [];
        if (!empty($forms)){
            foreach ($forms as $form){
                $evaluationStatus = 0;
                $evaluationMark = 0;
                $responseLink = '';
                if (!empty($form->getLastResponse()) && $form->getLastResponse()->status == FormResponse::STATUS_FULLY_EVALUATED){
                    $evaluationStatus = 1;
                    $evaluationMark = $form->getLastResponse()->score_info['achieved_score'].'/'.$form->getLastResponse()->score_info['total_score'];
                    $responseLink = route('form.response.show', $form->getLastResponse()->hash_id);
                }
                $formsArray[] = [
                    'title' => $form->title,
                    'description' => $form->description,
                    'items_count' => $form->items->where('type', '!=', FormItem::TYPE_SECTION)->count(),
                    'has_time_limit' => !empty($form->properties['has_time_limit']) && $form->properties['has_time_limit'] == 1 ? 1 : 0,
                    'time_limit' => $form->properties['time_limit'].' '.trans_choice('main.Minutes', $form->properties['time_limit']),
                    'evaluation_status' => $evaluationStatus,
                    'evaluation_mark' => $evaluationMark,
                    'response_link' => $responseLink,
                    'form_url' => route('store.form.show',[$lesson->slug, $form->hash_id]),
                ];
            }
        }

        // attachments
        $attachments = $lesson->attachments()->get();
        $attachmentsArray = array();
        foreach ($attachments as $attachment){
            $attachmentsArray[] = [
                'filename' => $attachment->filename,
                'filetype' => $attachment->filetype,
                'link' => $attachment->getTemporaryUrl(Carbon::parse(date('y-m-d'))->addDay()),
            ];
        }

        // groups
        $groups = $product->groups;
        $groupsArray = [];
        foreach ($groups as $key => $group){
            $groupNumber = $key + 1;
            // lessons
            $groupLessonsArray = [];
            foreach ($group->getLessons as $itemKey => $lessonItem){
                $lessonNumber = $itemKey + 1;
                $link = null;
                if ($groupNumber == 1){
                    $link = route('store.lesson.show', [$product->slug, $lessonItem->slug]);
                }else{
                    if ($product->hasPurchased()){
                        $link = route('store.lesson.show', [$product->slug, $lessonItem->slug]);
                    }
                }
                $groupLessonsArray[$lessonNumber] = [
                    'id' => $lessonItem->id,
                    'title' => $lessonItem->title,
                    'link' => $link,
                ];
            }

            $groupsArray[$groupNumber] = [
                'id' => $group->id,
                'title' => $group->title,
                'items' => $groupLessonsArray,
            ];
        }
        $lessonGroupId = $lesson->groups() && $lesson->groups()->first() ? $lesson->groups()->first()->id : null;

        $productArray = [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $product->price,
            'has_purchased' => $product->hasPurchased() ? true : false,
            'in_cart' => $product->isInCart(),
            'primary_image' => $product->getProductPrimaryImage(),
        ];
        return response([
            'lesson_id' => $lesson->id,
            'product' => $productArray,
            'content' => $content,
            'description' => $description,
            'resources' => $resources,
            'forms' => $formsArray,
            'attachments' => $attachmentsArray,
            'groups' => $groupsArray,
            'lesson_group_id' => $lessonGroupId
        ], 200);
    }

}
