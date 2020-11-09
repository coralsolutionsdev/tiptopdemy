<!DOCTYPE html>
<html>
<head>
    <title>Title</title>
  <link rel="icon" href="{{asset_image('/assets/favicon/favicon.ico')}}" type="image/x-icon">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- THEME CSS -->

{{--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">--}}
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
  <link rel="stylesheet" href="//unpkg.com/grapesjs/dist/css/grapes.min.css">
  <script src="//unpkg.com/grapesjs"></script>

  <style>
    .uk-card-secondary-light{
      background-color: #2e2e2e;
    }
    #gjs {
      /*border: 3px solid #444;*/
    }

    /* Reset some default styling */
    .gjs-cv-canvas {
      top: 0;
      width: 100%;
      height: 100%;
    }
    .gjs-block {
      width: auto;
      height: auto;
      min-height: auto;
    }
    .editor-row {
      display: flex;
      justify-content: flex-start;
      align-items: stretch;
      flex-wrap: nowrap;
      height: 300px;
    }

    .editor-canvas {
      flex-grow: 1;
    }

    .panel__right {
      flex-basis: 230px;
      position: relative;
      overflow-y: auto;
    }
  </style>
</head>
<body>

<div class="panel__top">
  <div class="panel__basic-actions"></div>
</div>
<div class="editor-row">
  <div class="editor-canvas">
    <div id="gjs">
      
    </div>
  </div>
  <div class="panel__right">
    <div class="layers-container"></div>
  </div>
</div>
<div id="blocks"></div>






@if(false)


  <div style="position: fixed; top: 50vh">
    <button class="uk-button uk-button-secondary uk-margin-small-right" type="button" uk-toggle="target: #pageBuilderPanel" style="padding: 10px 5px; border-radius: 0 5px 5px 0; background-color: #222222"><span uk-icon="icon: settings"></span></button>
  </div>
  <div id="pageBuilderPanel" uk-offcanvas="mode: push; overlay: true">
    <div class="uk-offcanvas-bar uk-padding-small">
      <div class="uk-margin-small">
        <h5>Basic</h5>
      </div>

      @if(false)
        <div class="uk-grid-small uk-grid-match uk-child-width-1-2@s uk-text-center" uk-grid>
          <div>
            <div class="uk-card uk-card-secondary-light uk-card-body">
              <i class="fas fa-heading fa-3x"></i><br>
              <p>Heading</p>
            </div>
          </div>
          <div>
            <div class="uk-card uk-card-secondary-light uk-card-body">
              <i class="fas fa-align-left fa-3x"></i><br>
              <p>Text Editor</p>
            </div>
          </div>
          <div>
            <div class="uk-card uk-card-secondary-light uk-card-body">
              <i class="far fa-image fa-3x"></i><br>
              <p>Image</p>
            </div>
          </div>
          <div>
            <div class="uk-card uk-card-secondary-light uk-card-body">
              <i class="fab fa-youtube fa-3x"></i><br>
              <p>Video</p>
            </div>
          </div>

        </div>
      @endif
    </div>
  </div>
  <div class="uk-inline" style="position: fixed; right: 3%; bottom: 5%;z-index: 99">
    <button class="uk-button uk-button-secondary" type="button" style="border-radius: 50%; padding: 5px 15px"><span uk-icon="plus"></span></button>
    <div uk-dropdown>
      <ul class="uk-nav uk-dropdown-nav">
        <li class="uk-active"><a href="#">Active</a></li>
        <li><a href="#">Item</a></li>
        <li class="uk-nav-header">Header</li>
        <li><a href="#">Item</a></li>
        <li><a href="#">Item</a></li>
        <li class="uk-nav-divider"></li>
        <li><a href="#">Item</a></li>
      </ul>
    </div>
  </div>
@endif

<script>

  const editor = grapesjs.init({
    // Indicate where to init the editor. You can also pass an HTMLElement
    container: '#gjs',
    // Get the content for the canvas directly from the element
    // As an alternative we could use: `components: '<h1>Hello World Component!</h1>'`,
    fromElement: true,
    // Size of the editor
    height: '300px',
    width: 'auto',
    // Disable the storage manager for the moment
    storageManager: false,
    // Avoid any default panel
    blockManager: {
      appendTo: '#blocks',
      blocks: [
        {
          id: 'section', // id is mandatory
          label: '<b>Section</b>', // You can use HTML/SVG inside labels
          attributes: { class:'gjs-block-section' },
          content: `<section>
          <h1>This is a simple title</h1>
          <div>This is just a Lorem text: Lorem ipsum dolor sit amet</div>
        </section>`,
        }, {
          id: 'text',
          label: 'Text',
          content: '<div data-gjs-type="text">Insert your text here</div>',
        }, {
          id: 'image',
          label: 'Image',
          // Select the component once it's dropped
          select: true,
          // You can pass components as a JSON instead of a simple HTML string,
          // in this case we also use a defined component type `image`
          content: { type: 'image' },
          // This triggers `active` event on dropped components and the `image`
          // reacts by opening the AssetManager
          activate: true,
        }
      ]
    }, ///
    layerManager: {
      appendTo: '.layers-container'
    },
    // We define a default panel as a sidebar to contain layers
    panels: {
      defaults: [{
        id: 'layers',
        el: '.panel__right',
        // Make the panel resizable
        resizable: {
          maxDim: 350,
          minDim: 200,
          tc: 0, // Top handler
          cl: 1, // Left handler
          cr: 0, // Right handler
          bc: 0, // Bottom handler
          // Being a flex child we need to change `flex-basis` property
          // instead of the `width` (default)
          keyWidth: 'flex-basis',
        },
      }]
    }



  });
  const blockManager = editor.BlockManager;
  blockManager.add('h1-block', {
    label: 'Heading',
    content: '<h1>Put your title here</h1>',
    category: 'Basic',
    attributes: {
      title: 'Insert h1 block'
    }
  });
  blockManager.add('h1-blockww', {
    label: 'Headingwww',
    content: '<h1>Put your title here</h1>',
    category: 'Basic',
    attributes: {
      title: 'Insert h1 block'
    }
  });

</script>
</body>
</html>