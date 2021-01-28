<section>
    <div class="full-screen-spinner uk-flex uk-flex-center uk-flex-middle" style="position: fixed; top: 0px; z-index: 1000; width: 100%; height: 100vh;">
        <div style="padding: 15px; background-color: rgba(255, 255, 255, 0.7); border-radius: 50%">
            @if(!empty(getSite()->logo))
            <img src="{{asset_image(getSite()->logo)}}" style="height: 50px; position: absolute; margin: 20px" alt="">
            @endif
            <div class="uk-text-primary" uk-spinner="ratio: 3"></div>
        </div>
    </div>
</section>