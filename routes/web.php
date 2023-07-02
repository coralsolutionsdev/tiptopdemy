<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* Inastallation */
Route::get('/template','HomeController@template')->name('temp');

Route::resource('/site','Site\SiteController', ['only' => ['create' , 'store' ,'show']]);


/*is installed ?*/
Route::group(['middleware'=>'installed'], function(){


/** Site Routes **/
Route::get('lang/{lang}','Site\LanguageController@GetLang');

Route::group(['middleware'=>'lang'], function(){
    Route::get('/contact','PagesController@contact')->name('page.contact');
    Route::post('/send/form/email','PagesController@sendFormEmail');
    Route::get('/offline','PagesController@Offline')->name('offline');
    /* Auth Routes */
    Auth::routes();
    Route::get('/get/registration/info', 'PagesController@getInfo');

    Route::get('/get/country/{countryId}/directorates', 'Auth\RegisterController@getCountryDirectorates');
    Route::get('/get/institution/scope/{scopeId}/fields', 'Auth\RegisterController@getInstitutionScopeFields');
    Route::get('/get/institution/scope/field/{fieldId}/options', 'Auth\RegisterController@getInstitutionScopeFieldOptions');
    Route::get('/get/institution/scope/field/{fieldId}/levels', 'Auth\RegisterController@getInstitutionScopeFieldLevels');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::post('/login/page', 'Admin\LoginController@login')->name('login.custom');
    Route::get('/suspended','HomeController@suspended')->name('suspended');
    Route::get('account/activate', ['as' => 'account.activate', 'uses' => 'Site\ProfileController@verifyEmail']);
    Route::post('account/resend_activation_mail', ['as' => 'account.resend.activation', 'uses' => 'Site\ProfileController@reSendActivationEmail']);

    Route::get('/verify/{email}/{verify_token}', 'HomeController@sendVerifyEmailDone')->name('sendverifyemail');
/* Socialite login*/
//        Route::get('/login/{driver}', 'Auth\LoginController@redirectToProvider')->name('login.socialite');
//        Route::get('/login/{driver}/callback', 'Auth\LoginController@handleProviderCallback');

/* Admin Routes */
    Route::group(['prefix' => 'manage', 'middleware' => 'role:superadministrator|administrator'], function () {

    Route::get('/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('error.log');

    Route::get('/','Admin\AdminController@GetDashboard')->name('admin.dashboard');
    Route::resource('/users','Site\UserController');
    Route::get('/user/password/{id}/update','Site\UserController@PassEdit')->name('password.edit');
//    Route::put('/user/password/{id}','Site\UserController@PassUpdate')->name('password.update');
    Route::get('/user/role/{id}/update','Site\UserController@RoleEdit')->name('role.edit');
    Route::put('/user/role/{id}','Site\UserController@RoleUpdate')->name('role.update');
    Route::resource('/setting','Admin\SettingController', ['only' => ['index' , 'update']]);

    /*Blog */
    Route::group(['prefix' => 'blog'], function () {
        Route::resource('/posts','Blog\PostController', ['except' => ['show']]);
        // movie this
        Route::resource('/categories','Blog\CategoryController', ['except' => ['show']])->names([
            'index' => 'blog.categories.index',
            'create' => 'blog.categories.create',
            'store' => 'blog.categories.store',
            'edit' => 'blog.categories.edit',
            'update' => 'blog.categories.update'
        ]);
        Route::get('/post/{post}/comments','Blog\PostController@viewComments')->name('blog.post.comments.show');
        Route::post('/post/image/upload','Blog\PostController@imageUpload')->name('blog.post.image.upload');
        Route::post('/post/{post}/attachment/{key}/delete','Blog\PostController@attachmentDelete')->name('blog.post.attachment.delete');

    });
    /* Attachments */
        Route::post('/attachments/image/upload','Admin\AttachmentController@imageUpload')->name('attachment.image.upload');


    /*Gallery*/
    Route::group(['prefix' => 'gallery'], function () {
        Route::resource('/albums','Gallery\AlbumController', ['except' => ['show']]);
        Route::resource('/images','Gallery\ImageController', ['except' => ['show']]);
    });

    Route::resource('/banners','Model\BannerController', ['except' => ['show']]);
    Route::get('/carousels','Model\BannerController@GetCarousel')->name('carousels.index');
    Route::get('/carousels/create','Model\BannerController@CreateCarousel')->name('carousels.create');
    /*Pages*/
    Route::resource('/pages','Site\PageController', ['except' => ['show']]);
    /*Menu*/
    Route::resource('/menus','Site\MenuController', ['except' => ['show']]);
    Route::get('/menus/get/structure/{layout}','Site\MenuController@getMenuItemsStructure')->name('menu.get.structure');
    /*Contacts*/
    Route::resource('/contacts','Site\ContactController', ['except' => ['show']]);
    Route::get('/contacts/{contact}/get/structure/','Site\ContactController@getItemsStructure')->name('contacts.get.items');


    /*Roles*/
    Route::resource('/roles','Site\RoleController');
    Route::get('/roles/edit/permissions/{id}','Site\RoleController@editRolePermissions')->name('assign.permissions');
    Route::put('/roles/update/permissions/{id}','Site\RoleController@updateRolePermissions')->name('assign.permissions.update');

    /*Languages*/
    Route::resource('/languages','Site\LanguageController');
    Route::post('/languages/update/keys','Site\LanguageController@updateKeys')->name('update.language.keys');

    /*Modules*/
    Route::get('/setting/modules','Admin\SettingController@getModules')->name('module.setting')->middleware('role:superadministrator');
    Route::put('/setting/modules/update','Admin\SettingController@updateModules')->name('module.setting.update')->middleware('role:superadministrator');

    /*Layout*/
    Route::resource('/layouts','Admin\LayoutController');
    Route::get('/layouts/get/structure/{layout}','Admin\LayoutController@getLayoutStructure')->name('layout.get.structure');
    Route::get('/layouts/get/banners/{group}','Admin\LayoutController@getGroupBanners')->name('get.group.banners');

    /*store*/
    Route::group(['prefix' => 'store', 'namespace' => 'Store', 'as' => 'store.'], function (){
        Route::resource('/categories','CategoryController',  ['except' => ['show']]);
        Route::resource('/products','ProductController',  ['except' => ['show']]);
        Route::resource('/types','ProductTypeController');
        Route::resource('/attribute/sets','ProductAttributeSetController');
        Route::resource('/attribute/sets/{set}/attributes','ProductAttributeController');
        Route::get('tags', 'ProductController@indexTags')->name('tags.index');
        Route::delete('tags/{tag}', 'ProductController@destroyTag')->name('tags.destroy');
        Route::resource('/product/{product}/groups','GroupController');
        Route::resource('/product/{product}/lessons','LessonController', ['except' => ['show']]);
        Route::resource('/lesson/{lesson}/form','FormController', ['except' => ['show']]);

        Route::resource('/lesson/{lesson}/memorize','MemorizeController', ['except' => ['show']]);
        Route::get('/lesson/memorize/get/items/','MemorizeController@getItems')->name('memorize.get.items');



        Route::get('/lesson/{lesson}/form/templates','FormController@templateIndex')->name('get.form.templates');
        Route::post('media/attach','LessonController@attachMedia')->name('media.attach');
        Route::post('lesson/{lesson}/add/resources/item','LessonController@addResourcesItem')->name('add.resources.item');
        Route::post('lesson/{lesson}/attachment/{key}/delete','LessonController@attachmentDelete')->name('attachment.delete');
        Route::post('lesson/{lesson}/attachment/{key}/delete','LessonController@attachmentDelete')->name('attachment.delete');
        // temp
        Route::get('/product/{product}/lessons/{lesson}/edit/content','LessonController@editContent')->name('lesson.edit.content');
        Route::put('/product/{product}/lessons/{lesson}/edit/content','LessonController@updateContent')->name('lesson.update.content');
        // d
        Route::get('/lesson/{lesson}/form/smart/create','FormController@smartCreate')->name('form.smart.create');
        Route::get('/lesson/{lesson}/form/smart/get/info','FormController@smartGetInfo')->name('form.smart.get.info');
        Route::post('/lesson/{lesson}/form/smart/get/items','FormController@smartGetItems')->name('form.smart.get.items');
        Route::post('/lesson/{lesson}/form/smart/store','FormController@smartStore')->name('form.smart.store');
        Route::post('/lesson/form/{form}/update/status','FormController@updateStatus')->name('form.update.status');


    });
    /*form*/
        Route::group(['prefix' => 'form', 'namespace' => 'Form', 'as' => 'form.'], function (){
            Route::resource('/','FormController',  ['except' => ['show']]);

            Route::resource('/templates','TemplateController',  ['except' => ['show']]);
            Route::post('/template/clone','TemplateController@clone')->name('template.clone');
            Route::get('/{form}/get/items/','FormController@getItems')->name('get.items');

            Route::resource('/categories','CategoryController',  ['except' => ['show']]);
            Route::get('/categories/type/{type}','CategoryController@create')->name('create.withType');

            Route::resource('/memorize','MemorizeController',  ['except' => ['show']]);


        });
    /*category*/
        Route::resource('/category','Category\CategoryController',  ['except' => ['show']]);
        Route::group(['prefix' => 'category', 'namespace' => 'Category', 'as' => 'category.'], function (){
            Route::get('/type/{type}/create','CategoryController@createType')->name('create.type');
            Route::get('/type/{type}/','CategoryController@indexType')->name('index.type');
        });

    /*companies*/
    Route::group(['prefix' => 'companies', 'namespace' => 'company', 'as' => 'companies.'], function (){
        Route::resource('/','CompanyController');
    });

    /*institutions*/
    Route::group(['prefix' => 'institution', 'namespace' => 'Institution', 'as' => 'institution.'], function (){
        Route::resource('/','InstitutionController');
        Route::resource('/scopes','InstitutionScopeController');
        Route::resource('/scope/{scope}/fields','InstitutionScopeFieldController');
        Route::resource('/directorates','DirectorateController');
    });
    /*
     * System routes
     */
    Route::group(['namespace' => 'System', 'prefix' => 'system', 'as' => 'system.'], function() {
        Route::resource('countries', 'CountryController');
        Route::resource('server', 'ServerController');
//            Route::resource('file-manager', 'FileManagerController');
        Route::post('group/ajax/create', 'GroupController@ajaxStore')->name('group.ajax.create');
        Route::get('group/ajax/get/type/{type}/groups', 'GroupController@ajaxGetIndex')->name('group.ajax.get.index');
        Route::post('group/ajax/update', 'GroupController@ajaxUpdate');
        Route::post('group/{group}/ajax/destroy/type/{type}', 'GroupController@ajaxDestroy');

//                Route::resource('errors', 'ErrorLogsController');
//                Route::resource('server', 'ServerController');
//                Route::get('cache/flush',['as' => 'cache.flush', 'uses' =>  'ServerController@flushCache']);
    });
    /*
     * MediaFile
     */
    Route::post('/media/attach','MediaFile\MediaController@ajaxStore')->name('ajax.media.attach');

    Route::group(['prefix' => 'media', 'namespace' => 'MediaFile', 'as' => 'media.'], function (){
        Route::resource('/','MediaController');
        Route::get('/get/library/items','MediaController@getMediaLibrary')->name('get.library.items');
        Route::get('/get/items','MediaController@getItems')->name('get.library.items');
        Route::post('/ajax/move/item','MediaController@ajaxMove')->name('ajax.move');
        Route::post('/ajax/delete/{media}','MediaController@ajaxDestroy')->name('ajax.destroy');
        Route::post('/ajax/image/upload','MediaController@editorImageUpload')->name('image.upload');

    });

    });
/* Admin Routes end */
/* User Routes */
    Route::group(['middleware'=>'active'], function(){

        if (isModuleEnabled('blog_posts')){
            /* Blog */
            Route::group(['prefix' => 'blog','namespace' => 'Blog', 'as' => 'blog.'], function () {
                Route::get('/' , 'PostController@GetIndex')->name('posts.main');
                Route::resource('/category','CategoryController', ['only' => ['show']]);
                Route::resource('/posts','PostController', ['only' => ['show']]);
                Route::get('/post/{post}/get/post', 'PostController@getPost');
                Route::get('/post/{post}/get/comments', 'PostController@getComments');
                Route::post('/post/{post}/react/{type}/toggle', 'PostController@updateReact');
                });
            }
            /* Comment */
            Route::group(['namespace' => 'Comment'], function (){
                Route::resource('/comment','CommentController');
                Route::get('/comments/get/items', 'CommentController@getItems');
                Route::post('/comment/{comment}/ajax/delete','CommentController@ajaxDestroy');
                Route::post('/comment/{comment}/ajax/update','CommentController@ajaxUpdate');
                Route::post('/comment/{comment}/react/{type}/toggle', 'CommentController@updateReact');
            });

        /* Gallery */
        Route::get('/gallery/album/{slug}','Gallery\AlbumController@show')->name('gallery.album.show');
        Route::get('/gallery','Gallery\AlbumController@GetIndex')->name('gallery.main');

        /* Profile */
        Route::resource('/profile', 'Site\ProfileController', ['only' => ['index' , 'update' ,'edit']])->middleware('active.account');
//        Route::put('/profile/update', 'Site\ProfileController@update')->name('profile.update')->middleware('active.account');
        Route::get('/profile/courses', 'Site\ProfileController@coursesIndex')->name('profile.courses.index');
        Route::get('/profile/orders', 'Site\ProfileController@ordersIndex')->name('profile.orders.index');
        Route::get('/profile/observers', 'Site\ProfileController@observersIndex')->name('profile.observers.index');

        /* pages Routes */
        Route::get('/','PagesController@GetIndex')->name('main'); // change to home
        Route::get('/about','PagesController@GetAbout');
//        Route::get('/contact','Site\ContactController@GetContact')->name('contact');
//        Route::post('/contact','Site\ContactController@PostContact')->name('post.contact');
        if (isModuleEnabled('products')){
        /* Store  */
        /*store*/
        Route::group(['prefix' => 'store', 'namespace' => 'Store', 'as' => 'store.'], function (){
            Route::get('/' , 'ProductController@GetIndex')->name('products.main'); // change to index
            Route::resource('/category','CategoryController',  ['only' => ['show']]);
            Route::resource('/product','ProductController',  ['only' => ['show']]);
            Route::resource('/product/{product}/lesson','LessonController', ['only' => ['show']]);
            Route::get('/lesson/{lesson}/form/{form}/get/items/','FormController@getItems')->name('form.get.items');
            Route::resource('/lesson/{lesson}/form','FormController', ['only' => ['show']]);
            Route::get('/products/items' , 'ProductController@GetItems'); // change to index
            Route::get('/sidebar/info' , 'ProductController@getSidebarInfo'); // change to index
            Route::get('/product/lesson/{lesson}/items','LessonController@getItems');
            Route::get('/product/lesson/{lesson}/groups/items','LessonController@getGroupsItems');
            Route::post('/lesson/{lesson}/react/{type}/toggle', 'LessonController@updateReact');


        });
        /* Cart */
            Route::group(['prefix' => 'cart', 'namespace' => 'Store', 'as' => 'cart.'], function (){
                Route::post('/add','CartController@add')->name('add');
                Route::post('/destroy/item','CartController@destroyItem')->name('destroy.item');
                Route::resource('/','CartController', ['only' => ['index']]);
                Route::post('/place/order','CartController@placeOrder')->name('place.order');
            });
        }
        /* Invoice */
        Route::group(['prefix' => 'invoice', 'namespace' => 'Store', 'as' => 'invoice.'], function (){
            Route::get('/show/{hashedId}','InvoiceController@show')->name('show');
        });

        /* Form */
        Route::group(['prefix' => 'form', 'namespace' => 'Form', 'as' => 'form.'], function (){
            Route::resource('/{form}/response','ResponseController', ['only' => ['store']]);
            Route::resource('/response','ResponseController', ['only' => ['show']]);
            Route::get('/{form}/get/item','FormController@getItem');
            Route::post('/{form}/send/response','ResponseController@ajaxStore');
        });

        /*pages*/
        Route::get('/{slug}','Site\PageController@getPage')->name('get.page');
            Route::get('/notifications','HomeController@notifications')->name('get.notifications');

            /*pages - Should be last route always*/
            Route::get('/{slug}','Site\PageController@getPage')->name('get.page');


        });
    });
    /* End of User Routes */


});
