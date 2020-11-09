<?php

use App\Category;
use App\Institution\Directorate;
use App\Institution\InstitutionScope;
use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Auth;
use App\Module;
use App\Site;
use App\Menu;
use App\Layout;
use App\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Webpatser\Countries\Countries;


/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 15/4/2018
 * Time: 11:08 AM
 */
const MONTHS = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July ',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
];

function isModuleEnabled($module){
    if (Schema::hasTable('modules')){ // to disable if during the migration and db:seed change to false
        $check_module = Module::where('name',$module)->first();
        if ($check_module->status == 1){
            return true;
        }
    }
    return false;

}
function getSite(){
    $site =  collect();
    if (Schema::hasTable('sites')){
        // TODO: use cache
        $site = Site::all()->last();
    }
    return $site;
}


/**
 * return current lang
 * TODO: improve the code
 * @return mixed
 */
function getLanguage()
{
    $lang = 'en';
    if (Schema::hasTable('sites')){
        $user = Auth()->user();
        if($user){
            if(empty($user->lang))
            {
                $lang = getSite()->lang;
            }
            else
            {
                $lang = $user->lang;
            }
        }
        else{
            if(session()->has('lang'))
            {
                $lang = session()->get('lang');
            }
            else
            {
                $lang = getSite()->lang;
            }
        }
    }
    return $lang;
}

function getLanguageFlagIcon($lang = null){
    $lang = getLanguage();
//    switch ($lang) {
//        case 0:
//            break;
//        case 1:
//            break;
//    }
    return asset_image('/flags/lang-ar-iq.png');
}

function getAdminThemeName()
{
    $theme_name = 'coral_admin';
    $site_theme =  getSite()->admin_theme;
    if (!empty($site_theme['theme_name'])){
        $theme_name = $site_theme['theme_name'];
    }
    return $theme_name;
}

function getFrontendThemeName()
{
    $theme_name = 'coral_light';
    $site_theme =  getSite()->theme;
    if (!empty($site_theme['theme_name'])){
        $theme_name = $site_theme['theme_name'];
    }
    return $theme_name;
}
function getAdminColor($color =  null)
{
    if (is_null($color)){
        $color = 'primary_color';
    }
    $selected_color = '#289cfa';
    $site_theme =  getSite()->admin_theme;
    if (!empty($site_theme[$color])){
        $selected_color = $site_theme[$color];
    }
    return $selected_color;
}
function getFrontEndColor($color =  null)
{
    if (is_null($color)){
        $color = 'primary_color';
    }
    $selected_color = '#289cfa';
    $site_theme =  getSite()->theme;
    if (!empty($site_theme[$color])){
        $selected_color = $site_theme[$color];
    }
    return $selected_color;
}
function getTopMenu()
{
    return Menu::where('status', '1')
        ->orderBy('order_id', 'asc')
        ->get();
}

function asset_image($image)
{
    return asset('/storage/'.$image);
}
function asset_attachment($path)
{
    return asset('/storage/'.ltrim($path,"public/"));
}
function date_html($datetime)
{
    if (is_string($datetime)) {
        $datetime = Carbon::parse($datetime);
    }
    return $datetime->format('jS M Y');
}
function subContent($content,$length)
{
        $dot = strlen($content) > $length ? "...": "";
    $sub_content =  substr(strip_tags($content),0,$length) .$dot;
    return $sub_content;
    dd('here');
}
function readMore($content)
{
    return substr($content, 0, strpos($content, '<p><!-- pagebreak --></p>'));
}
function getStatusIcon($status)
{
    $html = '<span class="far fa-check-circle text-success"></span>';
    if ($status != 1){
        $html = '<span class="far fa-times-circle text-danger"></span>';
    }
    return $html;
}
function soonBadge()
{
    return "<span class=\"badge badge-pill badge-success float-right mt-2\">Soon</span>";
}
function newBadge()
{
    return "<span class=\"badge badge-pill badge-danger float-right mt-2\">New</span>";
}
function getNavbarTopMenuItems()
{
    $items = null;
    $menu =  Menu::latest()->where('position', Menu::POSITION_TOP_NAV)->where('status', 1)->first();
    if (!empty($menu)){
        $items = $menu->items;
    }
    return $items;
}
function getWidgetName($item = null)
{
    $widget =  null;
    if (!is_null($item)){
        $model = $item['model'];
        if (!empty($model)){
            switch ($model) {
                case Layout::LAYOUT_MODEL_BANNERS:
                    $banner_group = $item['banner_group'];
                    switch ($banner_group) {
                        case Banner::GROUP_BASIC_BANNER:
                            $widget = 'banner_basic';
                        break;
                        case Banner::GROUP_SLIDE_SHOW_BANNER:
                            $widget = 'banner_slide_show';
                        break;
                        case Banner::GROUP_ICONIC_BANNER:
                            $widget = 'banner_iconic';
                        break;
                    }
                break;
                case Layout::LAYOUT_MODEL_BLOG:
//                    code to be executed if n=label1;
                break;
                case Layout::LAYOUT_MODEL_PRODUCTS:
//                    code to be executed if n=label1;
                break;
                case Layout::LAYOUT_MODEL_GALLERY:
//                    code to be executed if n=label1;
                break;


            }
        }
    }
    return $widget;
}
function getImageURL($path)
{
    if (!empty($path)){
        return asset_image($path);
    }
    return asset_image('temp/no-image.png');


}

function drawCategoryTreeList($items, $type, $class = '')
{
    echo '<ul class="'.$class.'">';


        if ($type == Category::TYPE_POST){
            $routePath = 'blog';
        }else{
            $routePath = 'store';
        }
        foreach ($items as $item){
            // Temporary solution for routing paths
            $showRoute = '';
            $editRoute = '';
            switch ($type) {
                case \App\Modules\Category\Category::TYPE_POST:
                    $showRoute = route('blog.category.show',$item->slug);
                    $editRoute = route('blog.categories.edit',$item->slug);
                    break;
                case \App\Modules\Category\Category::TYPE_PRODUCT:
                    $showRoute = route('store.category.show',$item->slug);
                    $editRoute = route('store.categories.edit',$item->slug);
                    break;
                case \App\Modules\Category\Category::TYPE_FORM:
                    $showRoute = route('category.show',$item->slug);
                    $editRoute = route('category.edit',$item->slug);
                    break;
                case \App\Modules\Category\Category::TYPE_FORM_TEMPLATE:
//                    $showRoute = route('category.show',$item->slug);
                    $editRoute = route('category.edit',$item->slug);
                    break;
                default:
                    $showRoute = route('category.show',$item->slug);
                    $editRoute = route('category.edit',$item->slug);
            }
            echo '<li class="cat-li uk-clearfix">';
//            .$item->items->count().
            echo '<a href="#" class="uk-button uk-button-default uk-button-small uk-text-capitalize uk-float-left">'.$item->name.' ('.$item->items()->count().')</a>   <span class="uk-button uk-button-default uk-button-small uk-float-left" style="margin: 0px 0px 0px 6px !important;">'.getStatusIcon($item->status).'</span><a href="'.$showRoute.'" class="uk-button uk-button-default uk-button-small ck-button-success" uk-tooltip="'.__('main.view').'" style="margin: 0px 3px 0px 6px !important;"><i class="far fa-eye"></i></a> <a href="'.$editRoute.'" class="uk-button uk-button-default uk-button-small ck-button-primary" uk-tooltip="'.__('main.edit').'"><i class="far fa-edit"></i></a>';
            $sub_menu =  Category::where('type', $type)->where('parent_id',$item->id)->get();
            $sub_menu =  $item->children;
            if (!empty($sub_menu)){
                drawCategoryTreeList($sub_menu, $type);
            }
            echo '</li>';
        }
    echo '</ul>';
}
function drawInputTreeListItems($items, $input_name, $selectedItems = array(), $root_class = '')
{
    $sub_menu = null;
    echo '<ul class="'.$root_class.'">';
    foreach ($items as $item){
        echo '<li>';
        if (!empty($selectedItems) && in_array($item->id,$selectedItems)){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        echo '<label><input name="'.$input_name.'"  id="tree_item-'.$item->id.'" class="tree-item tree_item-'.$item->id.'" value="'.$item->id.'" type="checkbox" '.$checked.' /> '.$item->name.'</label>';
        $sub_menu = \App\Category::where('type',$item->type)->where('parent_id',$item->id)->orderBy('position')->get();
        if (!empty($sub_menu)){ // Draw inner list if available
            drawInputTreeListItems($sub_menu, $input_name, $selectedItems);
        }
        echo '</li>';
    }
    echo '</ul>';
}
function drawCategoriesAccordionList($items, $classes = '')
{
    echo ' <ul class="'.$classes.'">';
    foreach ($items as $item){
        echo '<li>';
        $sub_menu = \App\Category::where('type',\App\Category::TYPE_PRODUCT)->where('parent_id',$item->id)->orderBy('position')->get();
        $link_class = $sub_menu->count() > 0 ? 'accordion-title' : '';
        echo '<a class="'.$link_class.'">'.$item->name.'</a>';
        if (!empty($sub_menu)){
         echo '<div class="">';
            drawCategoriesAccordionList($sub_menu);
         echo '</div>';
        }
        echo '</li>';
    }
    echo '</ul>';

}
function storeLastUrl()
{
//    session(['lastUrl' => url()->current()]);
}

function generateUniqueId($moduleName = null)
{
    $module = null;
    $moduleId = null;
    if (!empty($moduleName)){
        $module = Module::where('name', $moduleName)->first();
        if (!empty($module)){
            $moduleId = $module->id;
        }
    }
    $uniqueId = \App\UniqueId::firstOrCreate([
        'module_id' => $moduleId,
    ], [
        'unique_id' => 0
    ]);
    $uniqueId->unique_id =  $uniqueId->unique_id + 1;
    $uniqueId->save();
    return $uniqueId->unique_id;

}
function getFloatKey($position, $dirType = null)
{
    $start = 'right';
    $end = 'left';
    $siteLang = getLanguage();
    if ($position == 'start'){
        return $siteLang == 'en' ? $end : $start;
    } elseif ($position == 'end'){
        return $siteLang == 'en' ? $start : $end;
    }
}
/**
 * Get the current application brand name
 * @return Repository|string
 */
function getApplicationDomain()
{
    $domain = null;
    if (!empty(config('app.name'))){
        $domain = strtolower(config('app.name'));
    }
    return $domain;
}
/**
 * return app key from env settings
 * @return Repository|mixed|null
 */
function getApplicationKey()
{
    $key = null;
    if (!empty(config('app.key'))){
        $key = config('app.key');
    }
    return $key;
}
/**
 * Generate validation code based on email for account activation purpose
 * @param $email
 * @return string
 */
function generateValidationCode($email)
{
    // TODO: Add application key in env file to be used in generating the more secured validation code.
    // code generated by encoding a string combination based on base64_encode encoding, and return the first 6 characters of the generated key
    // TODO: method need to be improved for better encoding.
    $validationCombination = $email.getApplicationKey().getApplicationDomain();
    $validationCode = md5($validationCombination);
    return $validationCode;
}
function getCountryDirectorates($countryId){
    if (is_null($countryId)){
        $countryId = 368;
    }
    return  Directorate::where('status', 1)->where('country_id', $countryId)->orderBy('position')->get();
}
function getCountries(){
    return $countries = Countries::where('status',  1)->get();
}

function getInstitutionScopes(){
    return InstitutionScope::where('status', 1)->orderBy('position')->get();
}

function getAuthUser()
{
    $user = null;
    if (Auth::check()){
        $user = Auth::user();
    }
    return $user;
}
function isLoginIn()
{
    return Auth::user();
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAuthUserMediaStoragePath(){
    $user = getAuthUser();
    if (!empty($user)){
        return 'media/'.md5($user->getTenancyId()).'/'.md5($user->id).'/';
    }
    return 'media/guests';
}


