<?php

namespace App\Http\Controllers;

use App\Institution\Directorate;
use App\Institution\InstitutionScope;
use App\Institution\InstitutionScopeField;
use App\Jobs\SendValidationMail;
use App\Layout;
use Illuminate\Http\Request;
use DB;
use App\BlogPost;
use App\Banner;
use App\site;
use App\Contact;

class PagesController extends Controller
{
    //
    public function __construct()
    {
       // $this->middleware('');
    }

    public function GetIndex(){
        $layout = Layout::find(getSite()->layout_id);
        return view('welcome', compact('layout'));
    }
    public function Offline(){
        $contacts = Contact::latest()->paginate(5);

        $site = Site::all()->last();
        if($site->active == 0)
        {
            //return redirect()->route('offline');
            return view('offline',compact('contacts'));
            
        }   
        return redirect()->route('main');
        
    }
   
    public function GetAbout(){
        return view('about');
    }

    /**
     * get registration info
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getInfo(Request $request){
        $input = $request->only('country_id', 'scope_id', 'field_id', 'directorate_id');
        // Countries
        $countryId = $input['country_id'] ?? 368;
        $directorates = Directorate::orderBy('position')->where('country_id', $countryId)->where('status', 1)->select('id', 'title', 'default', 'items')->get();

        // directories
        $directorate_id = $input['directorate_id'] ?? null;
        if (is_null($directorate_id)){
            foreach ($directorates as $directorate){
                if ($directorate->default == 1){
                    $directorate_id = $directorate->id;
                    break;
                }
            }
        }

        // Scopes
        $scopes = getInstitutionScopes();
        $scopeId = $input['scope_id'] ?? null;
        if (is_null($scopeId)){ // get default
            if ($scopes){
                foreach ($scopes as $scope){
                    if ($scope->default == 1){
                        $scopeId = $scope->id;
                        break;
                    }
                }
            }
        }


        // Fields
        $fields = null;
        if (!empty($scopeId)){
            $scope = InstitutionScope::find($scopeId);
            if (!empty($scope)){
                $fields =  $scope->fields()->orderBy('position')->where('status', 1)->get();
            }
        }
        $fieldId = $input['field_id'] ?? null;
        if (is_null($fieldId)){
            foreach ($fields as $field){
                if ($field->default == 1){
                    $fieldId = $field->id;
                    break;
                }
            }
        }
        // field options
        $fieldOptions = $levels = array();
        $levelId = null;
        if ($fieldId && $fields){
//            $field = InstitutionScopeField::find($fieldId);
            $field = $fields->where('id', $fieldId)->first();
            if (!empty($field)){
                $fieldOptions =  $field->options()->orderBy('position')->where('status', 1)->get();
                $levels =  $field->levels;
                if (!empty($levels)){
                    foreach ($levels as $id => $level) {
                        if($level['default'] == 1){
                            $levelId = $id;
                        }
                    }
                }

            }

        }
        $fieldOptionId = null;
        if ($fieldOptions){
            foreach ($fieldOptions as $fieldOption){
                if ($fieldOption->default == 1){
                    $fieldOptionId = $fieldOption->id;
                    break;
                }
            }
        }
        $data = [
            'countries' => getCountries(),
            'country_id' => $countryId,
            'directorates' => $directorates,
            'directorate_id' => $directorate_id,
            'scopes' => $scopes,
            'scope_id' => $scopeId,
            'fields' => $fields,
            'field_id' => $fieldId,
            'field_options' => $fieldOptions,
            'field_option_id' => $fieldOptionId,
            'levels' => $levels,
            'level_id' => $levelId,
            '_token' => csrf_token(),
            'recaptcha_site_key' => getReCaptchaSiteKey(),
        ];
        return \response($data, 200);
    }
   
}
