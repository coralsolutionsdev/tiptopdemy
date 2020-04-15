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
		Route::get('/offline','PagesController@Offline')->name('offline');
	/* Auth Routes */
		Auth::routes();
		Route::get('/get/country/{countryId}/directorates', 'Auth\RegisterController@getCountryDirectorates');
		Route::get('/get/institution/scope/{scopeId}/fields', 'Auth\RegisterController@getInstitutionScopeFields');
		Route::get('/get/institution/scope/field/{fieldId}/options', 'Auth\RegisterController@getInstitutionScopeFieldOptions');
		Route::get('/get/institution/scope/field/{fieldId}/levels', 'Auth\RegisterController@getInstitutionScopeFieldLevels');
        Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
        Route::post('/login/page', 'Admin\LoginController@login')->name('login.custom');
		Route::get('/suspended','HomeController@suspended')->name('suspended');
        Route::get('account/activate', ['as' => 'account.activate', 'uses' => 'Site\ProfileController@verifyEmail']);
        Route::get('account/resend_activation_mail', ['as' => 'account.resend.activation', 'uses' => 'Site\ProfileController@reSendActivationEmail']);

        Route::get('/verify/{email}/{verify_token}', 'HomeController@sendVerifyEmailDone')->name('sendverifyemail');
    /* Socialite login*/
        Route::get('/login/{driver}', 'Auth\LoginController@redirectToProvider')->name('login.socialite');
        Route::get('/login/{driver}/callback', 'Auth\LoginController@handleProviderCallback');

    /* Admin Routes */
        Route::group(['prefix' => 'manage', 'middleware' => 'role:superadministrator|administrator'], function () {

        Route::get('/','Admin\AdminController@GetDashboard')->name('admin.dashboard');
        Route::resource('/users','Site\UserController');
        Route::get('/user/password/{id}/update','Site\UserController@PassEdit')->name('password.edit');
        Route::put('/user/password/{id}','Site\UserController@PassUpdate')->name('password.update');
        Route::get('/user/role/{id}/update','Site\UserController@RoleEdit')->name('role.edit');
        Route::put('/user/role/{id}','Site\UserController@RoleUpdate')->name('role.update');
        Route::resource('/setting','Admin\SettingController', ['only' => ['index' , 'update']]);



        /*Blog */
        Route::group(['prefix' => 'blog'], function () {
            Route::resource('/posts','Blog\PostController', ['except' => ['show']]);
            // movie this
            Route::resource('/comments','Blog\CommentController', ['except' => ['show']]);
            Route::resource('/categories','Blog\CategoryController', ['except' => ['show']])->names([
                'index' => 'blog.categories.index',
                'create' => 'blog.categories.create',
                'store' => 'blog.categories.store',
                'edit' => 'blog.categories.edit',
                'update' => 'blog.categories.update'
            ]);
            Route::get('/post/{post}/comments','Blog\PostController@viewComments')->name('blog.post.comments.show');

        });

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
            Route::resource('/categories','ProductCategoryController');
            Route::resource('/products','ProductController');
            Route::resource('/types','ProductTypeController');
            Route::resource('/attribute/sets','ProductAttributeSetController');
            Route::resource('/attribute/sets/{set}/attributes','ProductAttributeController');
            Route::get('tags', 'ProductController@indexTags')->name('tags.index');
            Route::delete('tags/{tag}', 'ProductController@destroyTag')->name('tags.destroy');
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
            /**
             * System routes
             */
            Route::group(['namespace' => 'System', 'prefix' => 'system', 'as' => 'system.'], function() {
                Route::resource('countries', 'CountryController');
//                Route::resource('errors', 'ErrorLogsController');
//                Route::resource('server', 'ServerController');
//                Route::get('cache/flush',['as' => 'cache.flush', 'uses' =>  'ServerController@flushCache']);
            });
    });
/* Admin Routes end */
/* User Routes */
        Route::group(['middleware'=>'active'], function(){

            if (isModuleEnabled('blog_posts')){
                /* Blog  */
                Route::group(['prefix' => 'blog','namespace' => 'Blog', 'as' => 'blog.'], function () {
                    Route::get('/' , 'PostController@GetIndex')->name('posts.main');
                    Route::resource('/category','CategoryController', ['only' => ['show']]);
//                    Route::get('/category/{slug}','Blog\CategoryController@show')->name('category.show');
                    Route::resource('/posts','PostController', ['only' => ['show']]);
                    Route::get('/post/{post}/get/comments', 'PostController@getComments');
                    Route::post('/post/comment/{comment}/delete', 'CommentController@deleteComments');
                    Route::post('/post/{post}/react/{type}/toggle', 'PostController@updateReact');
                    Route::post('/post/comment/{comment}/react/{type}/toggle', 'CommentController@updateReact'); // move to comment controller

                });
            }
            /* Gallery */
            Route::get('/gallery/album/{slug}','Gallery\AlbumController@show')->name('gallery.album.show');
            Route::get('/gallery','Gallery\AlbumController@GetIndex')->name('gallery.main');
            /* Profile */
            Route::resource('/profile', 'Site\ProfileController', ['only' => ['index' , 'show' ,'edit']])->middleware('active.account');;
            /* pages Routes */
            Route::get('/','PagesController@GetIndex')->name('main');
            Route::get('/about','PagesController@GetAbout');
            Route::get('/contact','Site\ContactController@GetContact')->name('contact');
            Route::post('/contact','Site\ContactController@PostContact')->name('post.contact');
            if (isModuleEnabled('products')){
                /* Store  */
                Route::group(['prefix' => 'store', 'as' => 'store.'], function () {
                    Route::get('/' , 'Store\ProductController@GetIndex')->name('store.main');
                    Route::get('/category/{slug}','Blog\CategoryController@show')->name('category.show');
                    Route::get('product/{slug}','Store\ProductController@show')->name('product.show');
                });
            }
            /*pages*/
            Route::get('/{slug}','Site\PageController@getPage')->name('get.page');
        });
    });
    /* End of User Routes */







});