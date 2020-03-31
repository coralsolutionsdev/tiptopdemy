<ul class="admin-sidebar">
    <li>
        <div class="menu-title">Main Menu</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="" href="{{route('admin.dashboard')}}">
            <i class="fas fa-tv"></i>
            <span class="">{{__('Dashboard')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{Route('users.index')}}">
            <i class="far fa-user-circle"></i>
            <span class="">{{__('Users')}}</span> {!! newBadge() !!}
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{route('pages.index')}}">
            <i class="far fa-file-alt"></i>
            <span class="">{{__('Pages')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{route('menus.index')}}">
            <i class="fas fa-bars"></i>
            <span class="">{{__('Menus')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{route('contacts.index')}}">
            <i class="far fa-map"></i>
            <span class="">{{__('Contact')}}</span>
        </a>
    </li>
    <li>
        <div class="menu-title">{{__('institutions')}}</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-institution" aria-expanded="false" aria-controls="nav-group-institution">
            <i class="fas fa-book"></i>
            <span class="">{{__('Institutions')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/institution*') ? 'show' :'')}}" id="nav-group-institution">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('institution.index')}}">{{__('All institutions')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('institution.scopes.index')}}">{{__('Institution Scopes')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{route('institution.directorates.index')}}">{{__('Directorates')}}</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{route('companies.index')}}">
            <i class="far fa-building"></i>
            <span class="">{{__('Academies')}}</span>
        </a>
    </li>
    <li>
        <div class="menu-title">Modules</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-1" aria-expanded="false" aria-controls="nav-group-1">
            <i class="fas fa-book"></i>
            <span class="">{{__('Blog')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/blog*') ? 'show' :'')}}" id="nav-group-1">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('posts.index')}}">{{__('Posts')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('blog.categories.index')}}">{{__('Category')}}</a>
                </li>
            </ul>
        </div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-2" aria-expanded="false" aria-controls="nav-group-2">
            <i class="far fa-image"></i>
            <span class="">{{__('Gallery')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/gallery*') ? 'show' :'')}}" id="nav-group-2">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('images.index')}}">{{__('Images')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('albums.index')}}">{{__('Albums')}}</a>
                </li>
            </ul>
        </div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="" href="{{route('banners.index')}}">
            <i class="fas fa-expand"></i>
            <span class="">{{__('Banners')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-store" aria-expanded="false" aria-controls="nav-group-store">
            <i class="fas fa-shopping-cart"></i>
            <span class="">{{__('Store')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/store*') ? 'show' :'')}}" id="nav-group-store">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('store.products.index')}}">{{__('Products')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.categories.index')}}">{{__('Categories')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.types.index')}}">{{__('Product Types')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.sets.index')}}">{{__('Attribute sets')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.tags.index')}}">{{__('Tags')}}</a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <div class="menu-title">Settings</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-3" aria-expanded="false" aria-controls="nav-group-3">
            <i class="menu-icon fas fa-cog"></i>
            <span class="">{{__('Settings')}}</span>
        </a>
        <div class="collapse {{ ((Request::is('manage/layouts*') || Request::is('manage/roles*') || Request::is('manage/setting*') || Request::is('manage/setting*')) ? 'show' :'')}}" id="nav-group-3">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('layouts.index')}}">{{__('Layouts')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('roles.index')}}">{{__('Roles')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('languages.index')}}">{{__('Languages')}}</a>
                </li>
                @if(Auth::user()->isSuperAdmin())
                    <li class="">
                        <a class="nav-link" href="{{Route('module.setting')}}">{{__('Modules')}}</a>
                    </li>
                @endif
                <li class="">
                    <a class="nav-link" href="{{Route('setting.index')}}">{{__('Settings')}}</a>
                </li>
            </ul>
        </div>
    </li>


</ul>