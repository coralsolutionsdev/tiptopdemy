<ul class="admin-sidebar">
    <li>
        <div class="menu-title">{{__('admin.Main Menu')}}</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="" href="{{route('admin.dashboard')}}">
            <i class="fas fa-tv"></i>
            <span class="">{{__('admin.Dashboard')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{Route('users.index')}}">
            <i class="far fa-user-circle"></i>
            <span class="">{{__('admin.Users')}}</span> {!! newBadge() !!}
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{route('pages.index')}}">
            <i class="far fa-file-alt"></i>
            <span class="">{{__('admin.Pages')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{route('menus.index')}}">
            <i class="fas fa-bars"></i>
            <span class="">{{__('admin.Menus')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-link" href="{{route('contacts.index')}}">
            <i class="far fa-map"></i>
            <span class="">{{__('admin.Contact')}}</span>
        </a>
    </li>
    <li>
        <div class="menu-title">{{__('admin.Institutions')}}</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-institution" aria-expanded="false" aria-controls="nav-group-institution">
            <i class="fas fa-book"></i>
            <span class="">{{__('admin.Institutions')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/Institution*') ? 'show' :'')}}" id="nav-group-institution">
            <ul style="">
                @if(false)
                <li class="">
                    <a class="nav-link" href="{{Route('institution.index')}}">{{__('admin.All Institutions')}}</a>
                </li>
                @endif
                <li class="">
                    <a class="nav-link" href="{{Route('institution.scopes.index')}}">{{__('admin.Institution Scopes')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{route('institution.directorates.index')}}">{{__('admin.Directorates')}}</a>
                </li>
            </ul>
        </div>
    </li>
    @if(false)
    <li class="nav-group">
        <a class="nav-link" href="{{route('companies.index')}}">
            <i class="far fa-building"></i>
            <span class="">{{__('admin.Academies')}}</span>
        </a>
    </li>
    @endif
    <li>
        <div class="menu-title">{{__('admin.Modules')}}</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-1" aria-expanded="false" aria-controls="nav-group-1">
            <i class="fas fa-book"></i>
            <span class="">{{__('admin.Blog')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/blog*') ? 'show' :'')}}" id="nav-group-1">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('posts.index')}}">{{__('admin.Posts')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('blog.categories.index')}}">{{__('admin.Categories')}}</a>
                </li>
            </ul>
        </div>
    </li>
{{--List item--}}
    @if(false)
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
    @endif
{{--List item--}}
    <li class="nav-group">
        <a class="" href="{{route('banners.index')}}">
            <i class="fas fa-expand"></i>
            <span class="">{{__('admin.Banners')}}</span>
        </a>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-store" aria-expanded="false" aria-controls="nav-group-store">
            <i class="fas fa-shopping-cart"></i>
            <span class="">{{__('admin.Store')}}</span>
        </a>
        <div class="collapse {{ (Request::is('manage/store*') ? 'show' :'')}}" id="nav-group-store">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('store.products.index')}}">{{__('admin.Products')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.categories.index')}}">{{__('admin.Categories')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.types.index')}}">{{__('admin.Product Types')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.sets.index')}}">{{__('admin.Attribute sets')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('store.tags.index')}}">{{__('admin.Tags')}}</a>
                </li>
            </ul>
        </div>
    </li>
    <li>
        <div class="menu-title">{{__('admin.Settings')}}</div>
    </li>
{{--List item--}}
    <li class="nav-group">
        <a class="nav-group-header collapsed" data-toggle="collapse" data-target="#nav-group-3" aria-expanded="false" aria-controls="nav-group-3">
            <i class="menu-icon fas fa-cog"></i>
            <span class="">{{__('admin.Settings')}}</span>
        </a>
        <div class="collapse {{ ((Request::is('manage/layouts*') || Request::is('manage/roles*') || Request::is('manage/setting*') || Request::is('manage/languages*') || Request::is('manage/system*') || Request::is('manage/setting*')) ? 'show' :'')}}" id="nav-group-3">
            <ul style="">
                <li class="">
                    <a class="nav-link" href="{{Route('layouts.index')}}">{{__('admin.Layouts')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('roles.index')}}">{{__('admin.Roles')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('languages.index')}}">{{__('admin.Languages')}}</a>
                </li>
                <li class="">
                    <a class="nav-link" href="{{Route('system.countries.index')}}">{{__('admin.Countries')}}</a>
                </li>
                @if(Auth::user()->isSuperAdmin())
                    <li class="">
                        <a class="nav-link" href="{{Route('module.setting')}}">{{__('admin.Modules')}}</a>
                    </li>
                @endif
                <li class="">
                    <a class="nav-link" href="{{Route('setting.index')}}">{{__('admin.Settings')}}</a>
                </li>
            </ul>
        </div>
    </li>


</ul>