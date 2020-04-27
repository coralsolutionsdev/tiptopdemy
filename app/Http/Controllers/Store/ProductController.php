<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\GalleryImage;
use App\Product;
use App\ProductImage;
use App\ProductType;
use App\Services\FileAssetManagerService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Tags\Tag;

//use Spatie\Tags\Tag;

class ProductController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Products';
        $this->breadcrumb = [
            'Store' => '',
            'Products' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = $this->page_title;
        $breadcrumb = $this->breadcrumb;
        $products = Product::latest()->paginate(15);
        return view('store.products.index', compact('page_title', 'breadcrumb', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = $this->page_title;
        $breadcrumb = $this->breadcrumb;
        $types = ProductType::pluck('name', 'id')->toArray();
        $visibility = Product::STATUS_ARRAY;
//        $categories = Category::getRootProductCategories()->pluck('name', 'id');
        $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id', 0)->get();
        $selectedCategories = array();
        $tags = Tag::getWithType('product')->pluck('name', 'name');
        $selectedTags = array();
//        $categories = ['0' => 'No parent'] + Category::getRootProductCategories()->pluck('name', 'id')->toArray();
        return view('store.products.create', compact('page_title', 'breadcrumb', 'categories', 'types', 'visibility', 'tree_categories', 'selectedCategories', 'tags', 'selectedTags'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if (!empty($input['sku'])) {
            if (Product::where('sku', $input['sku'])->count()) {
//                flash()->error('This SKU is already in use! Please use another SKU instead.');
                return back()->withInput();
            }
        }
        // TODO: created by

        if (empty($input['manage_stock'])) {
            $input['manage_stock'] = 0;
        }
        $input['user_id'] = Auth::user()->id;
        $product =  Product::create($input);

        // update Category
        $categories = $request->input('categories', array());
        $product->categories()->sync($categories);

        // upload new images
        if ($request->hasFile('new_image')) {
            $images = $request->file('new_image');
            foreach ($images as $key => $image) {
                # code...
                $new_product_image =  null;
                $location =  config('baseapp.product_image_storage_path');
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $new_product_image['path'] = $uploaded_image;
                $new_product_image['product_id'] = $product->id;
                $new_product_image['code'] = $input['new_image_code'][$key];
                $new_product_image['description'] = $input['new_image_description'][$key];
                $new_product_image['position'] = $input['new_image_position'][$key];
                ProductImage::create($new_product_image);

            }
        }
        // update tags
        $tags = $request->input('tags', array());
        $product->syncTagsWithType($tags, 'product');

        session()->flash('success',trans('main._success_msg'));
        return redirect()->route('store.products.edit', $product->slug);
    }


    /**
     * Show the form for editing the specified resource.
     * @param Product $product
     * @return Factory|View
     */
    public function edit(Product $product)
    {

        $page_title = $this->page_title;
        $breadcrumb = $this->breadcrumb;
        $types = ProductType::pluck('name', 'id')->toArray();
        $visibility = Product::STATUS_ARRAY;
//        $categories = Category::getRootProductCategories()->pluck('name', 'id');
        $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id', 0)->get();
        $selectedCategories = $product->categories()->pluck('id')->toArray();
        $tags = Tag::getWithType('product')->pluck('name', 'name');
        $selectedTags = $product->getTags();
//        $categories = ['0' => 'No parent'] + Category::getRootProductCategories()->pluck('name', 'id')->toArray();
        return view('store.products.create', compact('page_title', 'breadcrumb', 'product', 'categories', 'types', 'visibility', 'tree_categories', 'selectedCategories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        if (!empty($input['sku'])) {
            if (Product::where('sku', $input['sku'])->where('id', '<>', $product->id)->count()) {
//                flash()->error('This SKU is already in use! Please use another SKU instead.');
                return back()->withInput();
            }
        }
        // TODO: created by

        if (empty($input['manage_stock'])) {
            $input['manage_stock'] = 0;
        }

        // update slug
        if ($product->name != $request->input('name')){
            $slug = SlugService::createSlug(Product::class, 'slug', $request->input('name'), ['unique' => true]);
            $input['slug']= $slug;
        }
        $product->update($input);
        // update Category
        $categories = $request->input('categories', array());
        $product->categories()->sync($categories);
        // update Attribute
        $attributes = $product->getAllProductAttr();
        $attribute_values = [];
        foreach ($attributes as $attribute) {
            if ($value = $request->input($attribute->id)) {
                $attribute_values[$attribute->id] = ['value' => is_array($value) ? json_encode($value) : $value];
            }
        }
        $product->attributes()->sync($attribute_values);
        // update cache values
//        $product->updateAttributesCache();

        // images update
        if (!empty($input['image_code'] )){
            foreach ($input['image_code'] as $key => $image){
                $productImage =  null;
                $productImage = ProductImage::find($key);
                if (!empty($productImage)){
                    $productImage->description = $input['image_description'][$key];
                    $productImage->position = $input['image_position'][$key] ? : 0;
                    $productImage->save();
                }
            }
        }


        // upload new images
        if ($request->hasFile('new_image')) {
            $images = $request->file('new_image');
            foreach ($images as $key => $image) {
                # code...
                $new_product_image =  null;
                $location =  config('baseapp.product_image_storage_path');
                $uploaded_image = FileAssetManagerService::ImageStore($image,$location);
                $new_product_image['path'] = $uploaded_image;
                $new_product_image['product_id'] = $product->id;
                $new_product_image['code'] = $input['new_image_code'][$key];
                $new_product_image['description'] = $input['new_image_description'][$key];
                $new_product_image['position'] = $input['new_image_position'][$key];
                ProductImage::create($new_product_image);

            }
        }
        // remove images
        if (!empty($input['image_deleted'])){
            foreach ($input['image_deleted'] as $key => $deletedImage){
                $productImage =  null;
                $productImage = ProductImage::find($deletedImage);
                if (!empty($productImage)){
                    FileAssetManagerService::ImageDestroy($productImage->path);
                    $productImage->delete();
                }
            }
        }
        // update tags
        $tags = $request->input('tags', array());
        $product->syncTagsWithType($tags, 'product');


        session()->flash('success',__('Updated Successfully'));
        return redirect()->route('store.products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!empty($product)){
            $images = $product->getImages();
            if (!empty($images)){
                foreach ($images as $image){
                    FileAssetManagerService::ImageDestroy($image->path);
                    $image->delete();
                }
            }
        }
        $product->delete();
        session()->flash('success',__('Deleted Successfully'));
        return redirect()->route('store.products.index');
    }
    /**
     * @return Factory|View
     */
    public function indexTags()
    {
        $page_title = $this->page_title;
        $breadcrumb = $this->breadcrumb;
        $tags = Tag::getWithType('product');
        return view('store.tags.index', compact('page_title', 'breadcrumb', 'tags'));
    }

    public function destroyTag(Request $request, Tag $tag)
    {
        $tag->delete();
        session()->flash('success',__('Deleted Successfully'));
        return redirect()->route('store.tags.index');
    }

    /****************************************
     * Front end functions
     ***************************************/

    public function getIndex()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $products =  Product::where('status', Product::STATUS_AVAILABLE)->get();
        return view('store.products.frontend.index', compact('products','page_title','breadcrumb'));
    }

    /**
     * Display the specified resource.
     * @param $slug
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        $page_title =  $product->name;
        $breadcrumb =  $this->breadcrumb;

        $products =  Product::where('status', Product::STATUS_AVAILABLE)->get();
        return view('store.products.frontend.show', compact('product','page_title','breadcrumb'));


    }
}
