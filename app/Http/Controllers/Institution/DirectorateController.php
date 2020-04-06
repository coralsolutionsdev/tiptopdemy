<?php

namespace App\Http\Controllers\Institution;

use App\Institution\Directorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Webpatser\Countries\Countries;

class DirectorateController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->page_title = 'Directorates';
        $this->breadcrumb = [
            'Directorates' => '',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $directorates = Directorate::orderBy('position')->paginate(15);
        return view('institutions.directorates.index', compact('page_title','breadcrumb','directorates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        $countries = Countries::where('status',  1)->pluck('name','id')->toArray();
        return view('institutions.directorates.create', compact('page_title','breadcrumb', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['title', 'description', 'country_id', 'sub_items', 'position','status', 'item_id', 'item_title', 'item_desc', 'item_position']);
        $itemIds = isset($input['item_id']) ? $input['item_id'] :  array();
        $itemsArray = array();
        if (!empty($itemIds)){
            foreach ($itemIds as $key => $id){
                $itemsArray[$key] = [
                    'id' => generateUniqueId('directorates'),
                    'title' => $input['item_title'][$key],
                    'description' => $input['item_desc'][$key],
                    'position' => $input['item_desc'][$key],
                ];
            }
        }
        $keys = array_column($itemsArray, 'position');
        array_multisort($keys, SORT_ASC, $itemsArray);
        $input['items'] = $itemsArray;
        $input['user_id'] = Auth::user()->id;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        Directorate::create($input);
        session()->flash('success', __('Added successfully'));
        return redirect()->route('institution.directorates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Directorate $directorate
     * @return Response
     */
    public function edit(Directorate $directorate)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                $directorate->title => '',
                'Edit' => ''
            ];
        $countries = Countries::where('status',  1)->pluck('name','id')->toArray();
        return view('institutions.directorates.create', compact('page_title','breadcrumb', 'directorate','countries'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Directorate $directorate
     * @return Response
     */
    public function update(Request $request, Directorate $directorate)
    {
        $input = $request->only(['title', 'description', 'country_id', 'sub_items', 'position','status', 'item_id', 'item_title', 'item_desc', 'item_position', 'removed_items']);
        $itemIds = isset($input['item_id']) ? $input['item_id'] :  array();
        $itemsArray = array();
        if (!empty($itemIds)){
            foreach ($itemIds as $key => $id){
                $itemsArray[$key] = [
                    'id' => $id,
                    'title' => $input['item_title'][$key],
                    'description' => $input['item_desc'][$key],
                    'position' => $input['item_desc'][$key],
                ];
            }
        }
        $keys = array_column($itemsArray, 'position');
        array_multisort($keys, SORT_ASC, $itemsArray);
        $input['items'] = $itemsArray;
        $input['user_id'] = Auth::user()->id;
        if(!empty($input['status'])){
            $status = 1;
        }else{
            $status = 0;
        }
        $input['status'] = $status;
        $directorate->update($input);
        session()->flash('success', __('Updated successfully'));
        return redirect()->route('institution.directorates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
