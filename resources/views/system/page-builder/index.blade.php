<!DOCTYPE html>
<html lang="{{getLanguage()}}" dir="">
<head>
    <title>Page builder</title>
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
{{--  <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit-rtl.min.css')}}"/>--}}
  <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit.min.css')}}"/>
  @else
  <link rel="stylesheet" href="{{asset('libraries/uikit/css/uikit.min.css')}}"/>
  @endif

  <!--site Css-->

  <link rel="stylesheet" href="{{url('themes/'.getFrontendThemeName().'/css/general.css?v=202101292120')}}">
  <link rel="stylesheet" href="{{url('themes/general/modules/css/page_builder.css?v=202101292120')}}">
  <link rel="stylesheet" href="{{url('themes/general/modules/css/file-manager.css?v=202101292120')}}">

  <!-- scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.1.6/js/uikit-icons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.tiny.cloud/1/0disoxw0ri417kacpbbaufwzt6temhwubr87eejae2tyvpjy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

{{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.12.17/grapes.min.js">--}}
{{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/grapesjs/0.12.17/css/grapes.min.css"></script>--}}
  <script src="{{asset('plugins/page_builder/js/builder.js')}}"></script>
  <link rel="stylesheet" href="{{asset('plugins/page_builder/css/builder.css')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{asset('plugins/dropzone/dropzone.css')}}">
  <script src="{{asset('/plugins/dropzone/dropzone.js')}}"></script>
  <!-- MiniColors -->
  <link rel="stylesheet" href="{{asset('plugins/color_picker/jquery.minicolors.css')}}">
  <style>
    :root{
      --theme-secondary-bg-color: #F3F5F9;
      --theme-primary-color: {{getFrontEndColor()}};
      --theme-primary-font-color: #949494;
      --text-primary: {{getFrontEndColor()}};
      --text-secondary: #263655;
      --text-success: #17E5B4;
      --text-warning: #faa05a;
      --text-danger: #f0506e;
      --text-regular: #666666;
      --text-highlighted: #263655;
      --bg-secondary: #F9F8FD;
    }
  </style>
</head>
<body id="pb">
<div class="display-table">
  <div class="uk-grid-collapse display-table-row" uk-grid>
    @include('system.page-builder._control')
    <div class="uk-width-expand@m display-table-cell">
      <div style="position: fixed; top: 50vh; z-index: 999">
        <button class="uk-button uk-margin-small-right pb-control-toggle"><span class="" uk-icon="icon: chevron-left"></span></button>
      </div>
      <div class="">
        <div class="builder-container" style="padding-top: 25px">
          <ul id="pb-content" class="pb-editable-content pb-content-list-items uk-grid-collapse uk-child-width-1-1" uk-sortable="handle: .uk-sortable-handle" uk-grid>
            {!! $htmlContent !!}
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@if(false)
  <li>
    <div class="pb-row uk-card bg-white uk-padding-remove uk-container">
      <!--row control bar-->
      <span class="pb-row-control-bar uk-background-primary uk-light uk-position-top-center" style="margin-top: -24px; padding:2px 5px; border-radius: 5px 5px 0 0">
        <span class=""><span uk-icon="icon: copy; ratio: 0.8"></span></span>
        <span class="uk-margin-small-right uk-margin-small-left"><span class="uk-sortable-handle" uk-icon="icon: table;  ratio: 0.8"></span></span>
        <span class=""><span uk-icon="icon: close; ratio: 0.8"></span></span>
      </span>
      <div class="pb-row-components">
        <div class="pb-grid uk-grid-small"  uk-grid>
          <div class="pb-grid-column uk-width-1-1 uk-width-1-2@m"><span class="pb-column-control-bar uk-light">
                      <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>
                    </span>
            <div class="pb-column-content pb-empty-column uk-text-center">

              <div class="pb-widget-wrapperuk-inline-clip uk-inline-clip-show-overflow uk-transition-toggle" tabindex="0">
                <div class="">
                  <img src="https://getuikit.com/docs/images/light.jpg" alt="">
                  <div class="pb-hotspot-marker-items">
                    <div class="pb-hotspot-marker uk-dark">
                      <a class="uk-position-absolute uk-transform-center pin" style="left: 20%; top: 30%; opacity: 0.8" href="#" uk-marker></a>
                      <div uk-dropdown="mode: click" class="uk-padding-small">This is my Marker description</div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </li>
@endif

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

      <div>
        <div class="uk-grid-collapse uk-child-width-1-4@s uk-text-center pb-draggable-item" pb-draggableType="column" pb-columns-count="4" draggable="true" uk-grid>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
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

      <div>
        <div class="uk-grid-collapse uk-child-width-1-5@s uk-text-center pb-draggable-item" pb-draggableType="column" pb-columns-count="5" draggable="true" uk-grid>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
          <div>
            <div class="uk-padding-small" style="background-color: #e3e3e3; border: 2px solid white"></div>
          </div>
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
<script src="{{asset('js/app.js?v=202307170724')}}"></script>
<script src="{{asset('plugins/color_picker/jquery.minicolors.js')}}"></script>
<script>
    $('.color_picker').minicolors({
        control: 'wheel',
        theme: 'bootstrap'
    });
    $('.color_picker').change(function () {
        var input =  $(this);
        var new_color = input.val();
        input.val(new_color);
    });
</script>
@include('partial.scripts._tinyemc')
@include('system.page-builder._scripts')
{{--@include('system.file-manager._scripts')--}}
</body>
</html>