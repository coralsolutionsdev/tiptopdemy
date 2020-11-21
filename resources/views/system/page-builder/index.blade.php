<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
  <link rel="icon" href="{{asset_image('/assets/favicon/favicon.ico')}}" type="image/x-icon">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- THEME CSS -->

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="{{ asset('/js/jquery-3.3.1.min.js')}}"></script>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">{{--    <!--Semantic UI-->--}}
  <!--tailwindcss UI-->
  {{--    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">--}}
  <!--UiKit UI-->
  @if(getLanguage() == 'ar')
  <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit-rtl.min.css')}}"/>
  @else
  <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit.min.css')}}"/>
  @endif
  <!--site Css-->
  <link rel="stylesheet" href="{{url('themes/'.getFrontendThemeName().'/css/general.css?v=202010241400')}}">

  <!-- scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit-icons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.tiny.cloud/1/0disoxw0ri417kacpbbaufwzt6temhwubr87eejae2tyvpjy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

{{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.12.17/grapes.min.js">--}}
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.12.17/css/grapes.min.css"></script>--}}
  <script src="{{asset('plugins/page_builder/js/builder.js')}}"></script>
  <link rel="stylesheet" href="{{asset('plugins/page_builder/css/builder.css')}}">

</head>
<body>
{{--page-editor--}}
{{--<div>--}}
{{--  <div class="uk-child-width-1-1" uk-grid>--}}
{{--    <div>--}}
{{--      <div class="uk-inline uk-dark">--}}
{{--        <img src="https://getuikit.com/docs/images/light.jpg" alt="">--}}
{{--        <div>--}}
{{--          <a class="uk-position-absolute uk-transform-center pin" style="left: 20%; top: 30%; opacity: 0.8" href="#" uk-marker></a>--}}
{{--          <div uk-dropdown="mode: click">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</div>--}}
{{--        </div>--}}
{{--        <a class="uk-position-absolute uk-transform-center" style="left: 60%; top: 40%" href="#" uk-marker></a>--}}
{{--        <a class="uk-position-absolute uk-transform-center" style="left: 80%; top: 70%" href="#" uk-marker></a>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</div>--}}
<div class="uk-grid-collapse" uk-grid>
  <div id="pb-control" class="pb-control uk-width-1-5@m" style="background-color: #34383C; height: 100vh">
    <div class="pb-control-header">
      <div class="uk-grid-collapse uk-light uk-padding-small" uk-grid>
        <div class="uk-width-expand@m">
          <h5 class=""><b>PageBuilder</b></h5>
        </div>
        <div class="uk-width-auto@m">
            <span uk-icon="icon: thumbnails; ratio: 1"></span>
        </div>
      </div>
    </div>
    <div>
      <ul class="uk-padding-small" uk-accordion="multiple: true">
        <li class="uk-open">
          <a class="uk-accordion-title" href="#">Basic</a>
          <div class="uk-accordion-content">
            <div id="pb-items" class=" uk-grid-small uk-grid-match uk-child-width-1-2@s uk-text-center" uk-grid>
              <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="">
                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem" draggable="true">
                  <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><i class="fas fa-align-left fa-2x"></i></div>
                  <div class="pb-element-title-wrapper">Text editor</div>
                </div>
              </div>
              <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="">
                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem" draggable="true">
                  <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><span uk-icon="icon:image; ratio:1.5"></span></div>
                  <div class="pb-element-title-wrapper">Image</div>
                </div>
              </div>
              <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="">
                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem" draggable="true">
                  <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><span uk-icon="icon:play-circle; ratio:1.5"></span></div>
                  <div class="pb-element-title-wrapper">Video</div>
                </div>
              </div>
              <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="">
                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem" draggable="true">
                  <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><i class="far fa-images fa-2x"></i></div>
                  <div class="pb-element-title-wrapper">Hotspot</div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <div class="uk-width-expand@m">
    <div style="position: fixed; top: 50vh">
      <button class="uk-button uk-margin-small-right pb-control-toggle"><span class="" uk-icon="icon: chevron-left"></span></button>
    </div>
    <div class="uk-container">
      <div style="padding-top: 25px">
        <ul id="pb-content" class="pb-content-list-items uk-grid-collapse uk-child-width-1-1" uk-sortable="handle: .uk-sortable-handle" uk-grid>
        </ul>
      </div>
    </div>
  </div>
</div>

<div style="position: fixed; bottom: 5%; right: 3%">
  <button class="uk-button uk-button-secondary" style="border-radius: 50%; padding: 1px 10px"><span uk-icon="icon: plus"></span></button>
  <div class="uk-padding-remove" uk-dropdown="mode: click">
    <div class="uk-grid-small uk-child-width-1-1@s uk-text-center uk-padding-small" uk-grid>
      <div>
        <div class="uk-grid-collapse uk-child-width-1-1@s uk-text-center pb-draggable-item" pb-draggableType="column" pb-columns-count="1" draggable="true" uk-grid>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
        </div>
      </div>

      <div>
        <div class="uk-grid-collapse uk-child-width-1-2@s uk-text-center pb-draggable-item" pb-draggableType="column" pb-columns-count="2" draggable="true" uk-grid>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
        </div>
      </div>

      <div>
        <div class="uk-grid-collapse uk-child-width-1-3@s uk-text-center pb-draggable-item" pb-draggableType="column" pb-columns-count="3" draggable="true" uk-grid>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
@if(false)
  <li>
    <div class="pb-row uk-card bg-white uk-padding-remove">
      <!--row control bar-->
      <span class="pb-row-control-bar uk-background-primary uk-light uk-position-top-center" style="margin-top: -24px; padding:2px 5px; border-radius: 5px 5px 0 0">
                <span class=""><span uk-icon="icon: copy; ratio: 0.8"></span></span>
                <span class="uk-margin-small-right uk-margin-small-left"><span class="uk-sortable-handle" uk-icon="icon: table;  ratio: 0.8"></span></span>
                <span class=""><span uk-icon="icon: close; ratio: 0.8"></span></span>
              </span>
      <div class="pb-row-components">

      </div>
    </div>
  </li>
@endif
@include('system.page-builder._scripts')

</body>
</html>