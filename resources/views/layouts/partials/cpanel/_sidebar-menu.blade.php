<br>
<div id="sidebar-menu" data-children=".item">
  <div class="item">
    <a data-toggle="collapse" data-parent="#sidebar-menu" href="#sidebar-menu-item1" aria-expanded="true" aria-controls="sidebar-menu-item1">
      <span class="menu-title"><i class="fas fa-desktop"></i> {{__('Main Menu')}}</span>
    </a>
    <div id="sidebar-menu-item1" class="collapse {{Request::is('manage') ? "show" : ""}} {{Request::is('manage/users') ? "show" : ""}}  {{Request::is('manage/pages*') ? "show" : ""}} {{Request::is('manage/menus*') ? "show" : ""}} {{Request::is('manage/contacts*') ? "show" : ""}} {{Request::is('manage/banners*') ? "show" : ""}}{{Request::is('manage/layouts*') ? "show" : ""}} " role="tabpanel">
      	<ul>
	    	<li><a href="{{route('admin.dashboard')}}">{{trans('main._main')}}</a></li>
            <li><a href="{{Route('users.index')}}">{{trans('main._users')}}</a></li>
            <li><a href="{{Route('pages.index')}}">{{trans('main._pages')}}</a></li>
            <li><a href="{{Route('menus.index')}}">{{trans('main._menus')}}</a>
            <li><a href="{{Route('banners.index')}}">{{trans('main._banners')}}</a></li>
            <li><a href="{{Route('layouts.index')}}">{{__('Layouts')}}</a></li>
            <li><a href="{{Route('contacts.index')}}">{{trans('main._contact_info')}}</a></li>
	    </ul>
    </div>
  </div>
  <!-- menu item -->
  <div class="item">
    <a data-toggle="collapse" data-parent="#sidebar-menu" href="#sidebar-menu-item2" aria-expanded="false" aria-controls="sidebar-menu-item2">
      <span class="menu-title"><i class="far fa-newspaper"></i> </i> {{trans('main._blog')}}</span>
    </a>
    <div id="sidebar-menu-item2" class="collapse {{Request::is('manage/blog*') ? "show" : ""}}" role="tabpanel">
	    <ul>
	    	<li><a href="{{Route('posts.index')}}">{{trans('main._posts')}}</a></li>
			<li><a href="{{Route('blog.categories.index')}}">{{trans('main._categories')}}</a></li>
	    </ul>
    </div>
  </div>
  <!-- menu item -->
  <div class="item">
    <a data-toggle="collapse" data-parent="#sidebar-menu" href="#sidebar-menu-item3" aria-expanded="false" aria-controls="sidebar-menu-item3">
      <span class="menu-title"><i class="far fa-image"></i> {{trans('main._gallery')}}</span>
    </a>
    <div id="sidebar-menu-item3" class="collapse {{Request::is('manage/gallery*') ? "show" : ""}}" role="tabpanel">
      	<ul>
	    	<li><a href="{{Route('images.index')}}">{{trans('main._pictures')}}</a></li>
			<li><a href="{{Route('albums.index')}}">{{trans('main._albums')}}</a></li>
	    </ul>
    </div>
  </div>
<!-- menu item -->
<div class="item">
    <a data-toggle="collapse" data-parent="#sidebar-menu" href="#sidebar-menu-item-store" aria-expanded="false" aria-controls="sidebar-menu-item-store">
        <span class="menu-title"><i class="fas fa-store"></i> </i>Store</span>
    </a>
    <div id="sidebar-menu-item-store" class="collapse {{Request::is('manage/host*') ? "show" : ""}} {{Request::is('manage/store*') ? "show" : ""}}" role="tabpanel">
        <ul>
            <li><a href="{{Route('host.index')}}">Host Plans</a></li>
            <li><a href="{{Route('items.index')}}">Store Items</a></li>
            <li><a href="{{Route('categories.index')}}">Store Category</a></li>
        </ul>
    </div>
</div>
<div class="item">
    <a data-toggle="collapse" data-parent="#sidebar-menu" href="#sidebar-menu-item5" aria-expanded="true" aria-controls="sidebar-menu-item5">
        <span class="menu-title"><i class="fas fa-cog"> </i> {{__('Setting')}}</span>
    </a>
    <div id="sidebar-menu-item5" class="collapse {{Request::is('manage/setting') ? "show" : ""}} {{Request::is('manage/setting/modules') ? "show" : ""}} {{Request::is('manage/pages*') ? "show" : ""}} {{Request::is('manage/menus*') ? "show" : ""}} {{Request::is('manage/contacts*') ? "show" : ""}} {{Request::is('manage/roles*') ? "show" : ""}}" role="tabpanel">
        <ul>
            <li><a href="{{Route('roles.index')}}">Roles</a></li>
            <li><a href="{{Route('setting.index')}}">{{trans('main._setting')}}</a></li>
            {{--check if the user has super admin role--}}
            @if(auth::user()->isSuperAdmin())
                <li><a href="{{Route('module.setting')}}">Module {{trans('main._setting')}}</a></li>
            @endif
        </ul>
    </div>
</div>
</div>




