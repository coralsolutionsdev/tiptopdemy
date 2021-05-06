<?php

namespace App\Http\Controllers\Store;

use App\Category;
use App\GalleryImage;
use App\Modules\ColorPattern\ColorPattern;
use App\Modules\Media\Media;
use App\Product;
use App\ProductImage;
use App\ProductType;
use App\Services\FileAssetManagerService;
use App\Services\MediaManagerService;
use Blueprint\Builder;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Tags\Tag;
use App\Http\Resources\Store\Products as ProductsResource;

//use Spatie\Tags\Tag;

class ProductController extends Controller
{
    protected $breadcrumb;
    protected $page_title;
    protected $modelName;

    public function __construct()
    {
        $this->page_title = 'Products';
        $this->modelName = 'Store';
        $this->breadcrumb = [
            'Store' => '',
            'Products' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title = __('main.Products');
        $breadcrumb =  Breadcrumbs::render('admin.store');
        $modelName = $this->modelName;
        $products = Product::latest()->paginate(15);
        return view('store.products.index', compact('page_title', 'breadcrumb', 'products', 'modelName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title =  trans('main.Products') . ' - ' .__('main.Create');
        $breadcrumb =  Breadcrumbs::render('admin.store.create');
        $modelName = $this->modelName;
        $types = ProductType::pluck('name', 'id')->toArray();
        $visibility = Product::STATUS_ARRAY;
//        $categories = Category::getRootProductCategories()->pluck('name', 'id');
        $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id', 0)->get();
        $selectedCategories = array();
        $tags = Tag::getWithType('product')->pluck('name', 'name');
        $selectedTags = array();
        $colorPatterns = ColorPattern::where('status', 1)->get();
        $mediaType = Media::TYPE_PRODUCT_IMAGE;
        $modelItem = new Product();
        return view('store.products.create', compact('page_title', 'breadcrumb', 'types', 'visibility', 'tree_categories', 'selectedCategories', 'tags', 'selectedTags', 'colorPatterns', 'mediaType', 'modelItem', 'modelName'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if (empty($input['manage_stock'])) {
            $input['manage_stock'] = 0;
        }
        $product = Product::createOrUpdate($input);
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
        $page_title =  trans('main.Products') . ' - ' .__('main.Edit');
        $breadcrumb =  Breadcrumbs::render('admin.store.edit', $product);
        $modelName = $this->modelName;
        $types = ProductType::pluck('name', 'id')->toArray();
        $visibility = Product::STATUS_ARRAY;
        $tree_categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id', 0)->get();
        $categories = $tree_categories; //TODO: this is temp
        $selectedCategories = $product->categories()->pluck('id')->toArray();
        $tags = Tag::getWithType('product')->pluck('name', 'name');
        $selectedTags = $product->getTags();
        $colorPatterns = ColorPattern::where('status', 1)->get();
        $mediaType = Media::TYPE_PRODUCT_IMAGE;
        $modelItem = $product;
        return view('store.products.create', compact('page_title', 'breadcrumb', 'product', 'categories', 'types', 'visibility', 'tree_categories', 'selectedCategories', 'tags', 'selectedTags', 'colorPatterns', 'mediaType', 'modelItem', 'modelName'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        Product::createOrUpdate($input, $product);
        session()->flash('success',__('Updated Successfully'));
        return redirect()->route('store.products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        if (!empty($product)){
            $mediaType = Media::TYPE_PRODUCT_IMAGE;
            $product->clearMediaCollection(Media::getGroup($mediaType));
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
     **************************************
     * @param Request $request
     * @return Application|Factory|View
     */

    public function getIndex(Request $request)
    {
        $page_title =  __('main.Store\'s products');
        $modelName = $this->modelName;
        $breadcrumb =  Breadcrumbs::render('store');
        $input = $request->input();
        $user = getAuthUser();
        // get collection by search
        $searchKey = ltrim(rtrim($request->input('search'), ' '), ' ');
        $search_in_category = $request->input('category') ? : 0;
         //get collection
        if (!empty($searchKey)){
            $products = Product::where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('sku', 'LIKE', '%' . $searchKey . '%')->latest()->get();
        }else{
            $products = Product::latest()->get();
        }
        // check if product available for user
        $products = $products->filter(function ($product) use($user){
            $result = false;
            if (!empty($user) && ($user->hasRole('superadministrator') || $user->hasRole('administrator'))){
                $result = true;
            }else{
                if ($product->status == Product::STATUS_AVAILABLE){
                    $result = true;
                } elseif (!empty($user) && $product->status == Product::STATUS_AVAILABLE_FOR_INSTITUTIONS){
                    if ($product->scope_id == $user->scope_id && $product->field_id == $user->field_id && $product->field_option_id == $user->field_option_id && $product->level == $user->level){
                        $result = true;
                    }
                }
            }

            return $result;
        });
        if (!empty($search_in_category != 0)){ // 0 is searching in all categories
            $products = $products->filter(function ($product) use($search_in_category){
                if ($product->status == Product::STATUS_AVAILABLE || $product->status == Product::STATUS_AVAILABLE_FOR_INSTITUTIONS){
                    $categories =  $product->categories->where('id',$search_in_category);
                    if (!empty($categories) && $categories->count() > 0){
                        return true;
                    }else{
                        return false;
                    }
                }
                return false;
            });
        }
        // is between prices filter
        if (!empty($input['min']) || !empty($input['max'])) {
            $minPrice =  $input['min'];
            $maxPrice =  $input['max'];
            $products = $products->filter(function ($product) use($minPrice, $maxPrice){
                $isBetween = true;
                if (!empty($minPrice)){
//                  $product->getNumericPrice();
                    if ($product->price >= $minPrice){
                        $isBetween =  true;
                    }else{
                        $isBetween = false;
                    }
                }
                if ($isBetween == true && !empty($maxPrice)){
                    if ($product->price <= $maxPrice){
                        $isBetween =  true;
                    }else{
                        $isBetween = false;
                    }
                }
                return $isBetween;
            });
        }

        return view('store.products.frontend.index', compact('products','page_title', 'modelName','breadcrumb', 'searchKey'));
    }

    public function getItems(Request $request)
    {
        // TODO: improve this
        $input = $request->input();
        $user = getAuthUser();
        // get collection by search
        $searchKey = ltrim(rtrim($request->input('search'), ' '), ' ');
        $search_in_category = $request->input('category') ? : 0;
        //get collection
        if (!empty($searchKey)){
            $products = Product::where('name', 'LIKE', '%' . $searchKey . '%')->orWhere('sku', 'LIKE', '%' . $searchKey . '%')->latest()->get();
        }else{
            $products = Product::latest()->get();
        }
        $products->map(function ($product){
            $product->link = route('store.product.show', $product->slug);
            $product->primary_image = $product->getProductPrimaryImage();
            $product->alternative_image = $product->getProductAlternativeImage();
            $product->sub_description = subContent($product->description, 130);
            $product->user_name = $product->user->name;
            $product->user_profile_pic = $product->user->getProfilePicURL();
            $product->has_purchased = $product->hasPurchased();
            $product->in_cart = $product->isInCart();
        });
        // check if product available for user
        $products = $products->filter(function ($product) use($user){
            $result = false;
            if (!empty($user) && ($user->hasRole('superadministrator') || $user->hasRole('administrator'))){
                $result = true;
            }else{
                if ($product->status == Product::STATUS_AVAILABLE){
                    $result = true;
                } elseif (!empty($user) && $product->status == Product::STATUS_AVAILABLE_FOR_INSTITUTIONS){
                    if ($product->scope_id == $user->scope_id && $product->field_id == $user->field_id && $product->field_option_id == $user->field_option_id && $product->level == $user->level){
                        $result = true;
                    }
                }
            }

            return $result;
        });
        if (!empty($search_in_category != 0)){ // 0 is searching in all categories
            $products = $products->filter(function ($product) use($search_in_category){
                if ($product->status == Product::STATUS_AVAILABLE || $product->status == Product::STATUS_AVAILABLE_FOR_INSTITUTIONS){
                    $categories =  $product->categories->where('id',$search_in_category);
                    if (!empty($categories) && $categories->count() > 0){
                        return true;
                    }else{
                        return false;
                    }
                }
                return false;
            });
        }
        // is between prices filter
        if (!empty($input['min']) || !empty($input['max'])) {
            $minPrice =  $input['min'];
            $maxPrice =  $input['max'];
            $products = $products->filter(function ($product) use($minPrice, $maxPrice){
                $isBetween = true;
                if (!empty($minPrice)){
//                  $product->getNumericPrice();
                    if ($product->price >= $minPrice){
                        $isBetween =  true;
                    }else{
                        $isBetween = false;
                    }
                }
                if ($isBetween == true && !empty($maxPrice)){
                    if ($product->price <= $maxPrice){
                        $isBetween =  true;
                    }else{
                        $isBetween = false;
                    }
                }
                return $isBetween;
            });
        }

        // Pagination work
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 10;
        $products = new LengthAwarePaginator(
            $products->forPage($page, $perPage), $products->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );

        return ProductsResource::collection($products);

    }
    public function getSidebarInfo()
    {
        $categories = Category::where('type', Category::TYPE_PRODUCT)->where('parent_id', 0)->where('status',Category::STATUS_ENABLED)->get();

        $categories->map(function ($category){
            $category->link = route('store.category.show', $category->slug);
            $category->items_count = $category->getAvailableItems()->count();
            return $category->only(['id', 'name', 'link','items_count']);
        });
        $tags = Tag::where('type', 'product')->get();
        return response([
            'categories' => $categories,
            'tags' => $tags,
        ],200);
    }

    /**
     * Display the specified resource.
     * @param Product $product
     * @return Application|Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function show(Product $product)
    {
        $page_title =  $product->name;
        $breadcrumb =  Breadcrumbs::render('store.product', $product);
        $productGroups = $product->groups->first();
        $firstLesson =  !empty($productGroups) ? $productGroups->getLessons->first() : null;
        if (!empty($firstLesson)){
            return redirect()->route('store.lesson.show', [$product->slug, $firstLesson->slug]);
        }else{
            return view('store.products.frontend.show', compact('product','page_title','breadcrumb'));
        }
    }
}
