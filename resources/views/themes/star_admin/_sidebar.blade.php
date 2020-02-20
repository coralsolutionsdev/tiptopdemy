<ul class="nav">
    @if(false)
    <li class="nav-item nav-profile">
        <div class="nav-link">
            <div class="user-wrapper">
                <div class="profile-image">
                    <img src="{{asset('themes/star_admin/images/faces/face1.jpg')}}" alt="profile image">
                </div>
                <div class="text-wrapper">
                    <p class="profile-name" style="color: #FFFFFF">{{auth()->user()->name}}</p>
                    <div>
                        <small class="designation text-muted">{{auth()->user()->getRole()->name}}</small>
                        <span class="status-indicator online"></span>
                    </div>
                </div>
            </div>
            {{--<button class="btn btn-success btn-block">New Project--}}
            {{--<i class="mdi mdi-plus"></i>--}}
            {{--</button>--}}
        </div>
    </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.dashboard')}}">
            <i class="menu-icon fas fa-tv"></i>
            <span class="menu-title">{{__('Dashboard')}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{Route('users.index')}}">
            <i class="menu-icon far fa-user-circle"></i>
            <span class="menu-title">{{__('Users')}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('pages.index')}}">
            <i class="menu-icon far fa-file-alt"></i>
            <span class="menu-title">{{__('Pages')}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('menus.index')}}">
            <i class="menu-icon fas fa-bars"></i>
            <span class="menu-title">{{__('Menus')}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('banners.index')}}">
            <i class="menu-icon fas fa-expand"></i>
            <span class="menu-title">{{__('Banners')}}</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#nav-group-blog" aria-expanded="false" aria-controls="nav-group-blog">
            <i class="menu-icon fab fa-blogger"></i>
            <span class="menu-title">{{__('Blog')}}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="nav-group-blog">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('posts.index')}}">{{__('Posts')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('blog.categories.index')}}">{{__('Category')}}</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#nav-group-gallery" aria-expanded="false" aria-controls="nav-group-gallery">
            <i class="menu-icon far fa-image"></i>
            <span class="menu-title">{{__('Gallery')}}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="nav-group-gallery">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('images.index')}}">{{__('Images')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('images.index')}}">{{__('Albums')}}</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#nav-group-setting" aria-expanded="false" aria-controls="nav-group-setting">
            <i class="menu-icon fas fa-cog"></i>
            <span class="menu-title">{{__('Settings')}}</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="nav-group-setting">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('layouts.index')}}">{{__('Layouts')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('roles.index')}}">{{__('Roles')}}</a>
                </li>
                @if(Auth::user()->isSuperAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{Route('module.setting')}}">{{__('Modules')}}</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{Route('setting.index')}}">{{__('Settings')}}</a>
                </li>
            </ul>
        </div>
    </li>
    {{--<li class="nav-item">--}}
        {{--<a class="nav-link" href="pages/forms/basic_elements.html">--}}
            {{--<i class="menu-icon mdi mdi-backup-restore"></i>--}}
            {{--<span class="menu-title">Form elements</span>--}}
        {{--</a>--}}
    {{--</li>--}}
</ul>
