<?php

namespace App\Http\Controllers\Store;

use App\StoreItem;
use App\StoreCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStoreItem;
use auth;
use Image;
use Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = StoreItem::latest()->get();
        return view('store.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pageTitle = '';
        $categories = StoreCategory::where('type',StoreCategory::CATEGORY_PRODUCTS)->get();
        return view('store.items.create',compact('pageTitle','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStoreItem $request)
    {
        //
        $input = $request->input();
        //Update Image
        if ($request->hasFile('image')) {
            // Add the new image
            $string = str_random(20);
            $image = $request->file('image');
            $filename = time() . $string . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/store/images/', $filename);
            // image resize
            $post_image = Image::make('uploads/store/images/'. $filename);
            $post_image->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('uploads/store/images/'. $filename);
            $input['image'] = $filename;
        }
        StoreItem::create($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $pageTitle = '';
        $item = StoreItem::find($id);
        $categories = StoreCategory::where('type',StoreCategory::CATEGORY_PRODUCTS)->get();
        return view('store.items.create',compact('item','categories','pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->input();
        $item = StoreItem::find($id);
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        if(!empty($input['featured'])){
            $featured = 1;
        }else{
            $featured = 0;
        }
        $input['featured'] = $featured;
        if ($request->hasFile('image')) {
            // Add the new image
            $string = str_random(20);
            $image = $request->file('image');
            $filename = time() . $string . '.' . $image->getClientOriginalExtension();
            $image->move('uploads/store/images/', $filename);
            // image resize
            $post_image = Image::make('uploads/store/images/'. $filename);
            $post_image->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save('uploads/store/images/'. $filename);
            // Delete old image
            if (!empty ( $item->image )) {
                $oldImage = $item->image;
                Storage::delete('store/images/'. $oldImage);
            }
            $input['image'] = $filename;
        }
        $item->update($input);
        session()->flash('success',trans('main._update_msg'));
        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        StoreItem::where('id',$id)->delete();
        session()->flash('success',trans('main._delete_msg'));
        return redirect()->route('items.index');
    }
}
