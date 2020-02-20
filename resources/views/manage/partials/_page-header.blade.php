<div class="page-header">
    <div class="row">
        <div class="col-lg-6">
            <div class="page-title">{{__($page_title)}}</div>
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="fas fa-home"></i> </a>
                    </li>
                    @foreach($breadcrumb as $page => $link)
                        <li class="breadcrumb-item"><a href="#!">{{$page}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-3"></div>
        <div class="col-lg-3 text-right">
            @yield('page-header-button')
        </div>
    </div>
</div>