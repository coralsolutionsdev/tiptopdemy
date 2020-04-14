<div class="page-header">
    <div class="uk-container uk-padding">
        <h1 class="uk-text-primary">{{$page_title}}</h1>
            <ul class="breadcrumb">
                <li>
                    <span uk-icon="home"></span>
                </li>
            @foreach($breadcrumb as $page => $link)
                    <li><a href="">{{$page}}</a></li>
                @endforeach
            </ul>
    </div>
</div>