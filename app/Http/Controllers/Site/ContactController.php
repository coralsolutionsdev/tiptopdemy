<?php

namespace App\Http\Controllers\Site;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\mail\Sendmail;
use DB;
use Mail;

class ContactController extends Controller
{
    protected $breadcrumb;
    protected $page_title;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['GetIndex','show']]);
        $this->page_title = 'Contacts';
        $this->breadcrumb = [
            
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title =  $this->page_title;
        $breadcrumb =  $this->breadcrumb;
        $contacts = Contact::latest()->paginate(15);
        return view('contacts.index', compact('page_title', 'breadcrumb', 'contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title =  $this->page_title . ' - ' .__('Create');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Create' => ''
            ];
        return view('contacts.create', compact('page_title','breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST')){
            $this->validate($request, [
                 'title'         => 'required',
                 'status'        => 'bool',
            ]);
                $items =  array();
            $input = $request->only(['title', 'content', 'map_coordinates', 'items', 'status', 'item-icon', 'item-title', 'item-text']);
                foreach ($input['item-icon'] as $key => $value){
                    $items[$key]['icon'] = $value;
                }
                foreach ($input['item-title'] as $key => $value){
                    $items[$key]['title'] = $value;
                }
                foreach ($input['item-text'] as $key => $value){
                    $items[$key]['text'] = $value;
                }
                if(!empty($request->input('status'))){
                    $status =1;
                }else{
                    $status =0;
                }
                $input['items'] = $items;
                $input['status'] = $status;

                Contact::create($input);
                session()->flash('success',__('Successfully added'));

                return redirect()->route('contacts.index');

        }
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
     * @param  int  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $page_title =  $this->page_title . ' - ' .__('Edit');
        $breadcrumb =  $this->breadcrumb;
        $breadcrumb = $breadcrumb + [
                'Edit' => ''
            ];
        return view('contacts.create', compact('page_title', 'breadcrumb', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
        if ($request->isMethod('PUT')){
            $this->validate($request, [
                'title'         => 'required',
                'status'        => 'bool',
            ]);
            $items =  array();
            $input = $request->only(['title', 'content', 'map_coordinates', 'items', 'status', 'item-icon', 'item-title', 'item-text']);
            foreach ($input['item-icon'] as $key => $value){
                $items[$key]['icon'] = $value;
            }
            foreach ($input['item-title'] as $key => $value){
                $items[$key]['title'] = $value;
            }
            foreach ($input['item-text'] as $key => $value){
                $items[$key]['text'] = $value;
            }
            if(!empty($request->input('status'))){
                $status =1;
            }else{
                $status =0;
            }
            $input['items'] = $items;
            $input['status'] = $status;

            $contact->update($input);
            session()->flash('success',__('Successfully updated'));

            return redirect()->route('contacts.index');
        }
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
        $contact = Contact::find($id);
        $contact->delete();
        session()->flash('success', trans('main._delete_msg'));
        return redirect()->route('contacts.index');
    }
    
    public function GetContact(){
        $contacts = DB::table('contacts')
                    ->where('status', '1')->get();
        return view('contacts.contact', compact('contacts'));
        
    }
    public function PostContact(){
        
        Mail::to('maestro.des@gmail.com')->send(new SendMail());
        session()->flash('success', 'mail sended');

        return redirect()->route('main');
        
    }

    /**
     * @param Contact $contact
     * @return array
     */
    public function getItemsStructure(Contact $contact)
    {
        return ['structure' => $contact->items];
    }
}
