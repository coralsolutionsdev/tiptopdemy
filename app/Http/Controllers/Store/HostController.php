<?php

namespace App\Http\Controllers\Store;

use App\StoreHost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HostController extends Controller
{
    public function __construct()
    {
        $this->title = 'Host Plans';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $plans = StoreHost::latest()->get();
        return view('store.host.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $pageTitle = $this->title;
        return view('store.host.create',compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->input();
        StoreHost::create($input);
        session()->flash('success', trans('main._success_msg'));
        return redirect()->route('host.index');
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
        $pageTitle = $this->title;
        $plan = StoreHost::find($id);
        return view('store.host.create',compact('plan','pageTitle'));

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
        $plan = StoreHost::find($id);
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
        $plan->update($input);
        session()->flash('success',trans('main._update_msg'));
        return redirect()->route('host.index');
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
        StoreHost::where('id',$id)->delete();
        session()->flash('success',trans('main._delete_msg'));
        return redirect()->route('host.index');
    }
}
