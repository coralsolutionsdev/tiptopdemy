<div class="page-header">
    <div class="uk-container uk-padding">
        <h1 class="uk-text-primary">{{__($page_title)}}</h1>
            <ul class="breadcrumb">
                <li>
                    <span uk-icon="home"></span>
                </li>
            @foreach($breadcrumb as $page => $link)
                    <li><a href="">{{__($page)}}</a></li>
                @endforeach
            </ul>
    </div>
</div>