<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Course\Lesson;
use App\Modules\Media\Media;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Tags\Tag;
use Vinkla\Hashids\Facades\Hashids;

class LessonController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['GetIndex','show', 'getComments']]);
        $this->page_title = 'Store Lessons';
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
        $input['creator_id'] = getAuthUser()->id;
        $input['editor_id'] = getAuthUser()->id;
        $input['product_id'] = $product->id;

        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        if (false){
            // allow comments
            if(!empty($input['allow_comments_status'])){
                $allow_comments_status = 1;
            }else{
                $allow_comments_status = 0;
            }
            $input['allow_comments_status'] = $allow_comments_status;
            //
            if(!empty($input['default_comment_status'])){
                $default_comment_status = 1;
            }else{
                $default_comment_status = 0;
            }
            $input['default_comment_status'] = $default_comment_status;
        }

        $lesson = Lesson::create($input);
        $lesson->slug = Hashids::encode(1,$product->id,$lesson->id);
        $lesson->save();
        // update Category
        $groups = $request->input('groups', array());
        $lesson->groups()->sync($groups);

        // update tags
//        $tags = $request->input('tags', array());
//        $lesson->syncTagsWithType($tags, 'lesson');

        // attachments
        if (isset($input['attachments'])){
            $attachments = $input['attachments'];
            foreach ($attachments as $attachment){
                $lesson->attach($attachment);
            }
        }
        // add new media items
        if (isset($input['new_media_url'])){
            foreach ($input['new_media_url'] as $key => $newMedia){
                $mediaInput['title'] = '';
                $mediaInput['type'] = $input['new_media_type'][$key];
                $mediaInput['storage_type'] = $input['new_media_type'][$key];
                $mediaInput['source'] = $newMedia;
                $mediaInput['status'] = 1;
                $mediaInput['position'] = 0;
                $media = Media::create($mediaInput);
                $lesson->media()->attach($media->id);
            }
        }


        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('store.products.edit', $product->slug);

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
        $breadcrumb =  [
            __('main.Store') => '',
            __('main.Products') => '',
            $product->name => '',
            __('main.Lessons') => '',
            $lesson->title => '',
        ];
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
        return view('store.lessons.frontend.show', compact('product','page_title','breadcrumb', 'lesson', 'prevLesson', 'nextLesson'));

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
        return view('store.lessons.create', compact('page_title','breadcrumb', 'product', 'groups', 'selectedGroups', 'lesson', 'selectedTags'));

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
        $input['editor_id'] = getAuthUser()->id;

        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        if (false){
            // allow comments
            if(!empty($input['allow_comments_status'])){
                $allow_comments_status = 1;
            }else{
                $allow_comments_status = 0;
            }
            $input['allow_comments_status'] = $allow_comments_status;
            //
            if(!empty($input['default_comment_status'])){
                $default_comment_status = 1;
            }else{
                $default_comment_status = 0;
            }
            $input['default_comment_status'] = $default_comment_status;
        }

        $lesson->update($input);
        $lesson->save();
        // update Category
        $groups = $request->input('groups', array());
        $lesson->groups()->sync($groups);

        // update tags
//        $tags = $request->input('tags', array());
//        $lesson->syncTagsWithType($tags, 'lesson');

        // attachments
        if (isset($input['attachments'])){
            $attachments = $input['attachments'];
            foreach ($attachments as $attachment){
                $lesson->attach($attachment);
            }
        }

        // update existing media
        if (!empty($lesson->media) && $lesson->media->count() > 0){
            foreach ($lesson->media as $existingMedia){
                if (array_key_exists (  $existingMedia->id ,$input['media_url'])){ // if key exist update the item
                    $existingMedia->source = $input['media_url'][$existingMedia->id];
                    $existingMedia->type = $input['media_type'][$existingMedia->id];
                    $existingMedia->storage_type = $input['media_type'][$existingMedia->id];
                    $existingMedia->save();
                }else{ // if key exist remove the item
                    $existingMedia->delete();
                }
            }
        }
        // add new media items
        if (isset($input['new_media_url'])){
            foreach ($input['new_media_url'] as $key => $newMedia){
                $mediaInput['title'] = '';
                $mediaInput['type'] = $input['new_media_type'][$key];
                $mediaInput['storage_type'] = $input['new_media_type'][$key];
                $mediaInput['source'] = $newMedia;
                $mediaInput['status'] = 1;
                $mediaInput['position'] = 0;
                $media = Media::create($mediaInput);
                $lesson->media()->attach($media->id);
            }
        }
        session()->flash('success',__('Updated Successfully'));
        return redirect()->route('store.lessons.edit', [$product->slug, $lesson->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Lesson $lesson
     * @return void
     */
    public function destroy(Product $product, Lesson $lesson)
    {
        $lesson->deleteWithDependencies();
        session()->flash('success',__('Deleted Successfully'));
        return redirect()->route('store.products.edit', $product->slug);

    }
}
