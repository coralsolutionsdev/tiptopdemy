<div class="page-header">
    <div class="uk-container uk-padding uk-text-center">
        <h3 class="uk-text-primary">{{$page_title}}</h3>
            <ul class="breadcrumb" style="">
                <li>Home</li>
            @foreach($breadcrumb as $page => $link)
                    <li><a href="">{{$page}}</a></li>
                @endforeach
            </ul>
    </div>
</div>