<script>

    // toggle control panel //
    $('.pb-control-toggle').click(function (){
        var btn = $(this);
        $('#gjs-control').toggleClass('hidden-div');
    });

    addMinyTinyEditor('.textEditor-content');


    // functions
    function generateRandomString(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    var widgets = [
        {
        id: 'image', // id is mandatory
        label: '<b>textEditor</b>', // You can use HTML/SVG inside labels
        attributes: { class:'' },
        content: '<div class="pb-widget-wrapper uk-inline-clip uk-transition-toggle" tabindex="0">\n' +
            '  <img class="pb-widget-image" data-src="{{asset_image('assets/blank_image.png')}}"  sizes="(min-width: 650px) 650px, 100vw" width="650" uk-img>\n' +
            '</div>',
        },{
        id: 'textEditor', // id is mandatory
        label: '<b>textEditor</b>', // You can use HTML/SVG inside labels
        attributes: { class:'' },
        content: '<div class="pb-widget-wrapper pb-widget-text-editor">\n' +
            'Hello world!</br>\n' +
            'This is my initial text\n' +
            '</div>',
        },{
        id: 'video', // id is mandatory
        label: '<b>video</b>', // You can use HTML/SVG inside labels
        attributes: { class:'' },
            content: '<div class="pb-widget-wrapper uk-inline-clip uk-transition-toggle uk-responsive-height" tabindex="0">\n' +
                '  <video src="" class="uk-responsive-width" width="1920" height="1080" playsinline controls disablepictureinpicture controlsList="nodownload" uk-responsive></video>\n' +
                '</div>',
        },
        {
            id: 'hotspotImage', // id is mandatory
            label: '<b>hotspotImage</b>', // You can use HTML/SVG inside labels
            attributes: { class:'' },
            content: '<div class="pb-widget-wrapper uk-inline-clip uk-inline-clip-show-overflow uk-transition-toggle" tabindex="0">\n' +
                '  <img class="pb-widget-image" data-src="{{asset_image('assets/blank_image.png')}}"  sizes="(min-width: 650px) 650px, 100vw" width="650" uk-img>\n' +
                '  <div class="pb-hotspot-marker-items">\n' +
                '  </div>\n' +
                '</div>',
        },

    ];
    function getWidget(id){
        return widgets.find(x => x.id === id);
    }
    function resetOpenWidgetSettings(){
        $('.pb-widget-wrapper').map(function() {
            var element = $(this);
            var activeWidgetId = element.attr('id');
            tinymce.remove("#"+activeWidgetId);
        });
        $('.pb-widget-setting').map(function() {
            var element = $(this);
            element.hide();
        });

    }
    function openWidgetSettings(){
        $('.pb-widget-wrapper').dblclick(function (){
            resetOpenWidgetSettings();
            var activeWidget = $(this).closest('.pb-widget-wrapper');
            $('.pb-widgets-wrapper').slideUp();
            $('.pb-setting-wrapper').slideDown();
            var activeWidgetType = activeWidget.attr('pbWidgetType');
            var activeWidgetId = activeWidget.attr('id');
            if (activeWidgetType == 'textEditor'){
                addMinyTinyEditor('#'+activeWidgetId);
            }
            $('.'+activeWidgetType+'-setting').show();
            console.log(activeWidgetType);
            if (activeWidgetType == 'image' || activeWidgetType == 'hotspotImage'){
                var activeWidgetImageUrl = activeWidget.find('.pb-widget-image').attr('data-src');
                $('.image-setting-image-thump').attr('data-src', activeWidgetImageUrl);
            }
            openedWidgetSetting = activeWidget.attr('id');
        });
    }
    $('.pb-view-widgets-list').click(function (){
        $('.pb-setting-wrapper').slideUp();
        $('.pb-widgets-wrapper').slideDown();
    });

    function resetControlPanel(){
        $('.pb-widgets-wrapper').slideDown();
        $('.pb-setting-wrapper').slideUp();
    }

    function deleteContentItem(event){
        var item = event.closest('.pb-content-item');
        UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to remove this row?').then(function() {
            item.remove();
            resetControlPanel();
        }, function () {
            console.log('Rejected.')
        });
    }
    // templates
    var pbContentListItemTemplate = '' +
        '<li id="" class="pb-content-item">\n' +
        '  <div class="pb-row uk-card uk-padding-remove uk-container">\n' +
        '    <!--row control bar-->\n' +
        '    <span class="pb-row-control-bar uk-background-primary uk-light uk-position-top-center" style="margin-top: -24px; padding:2px 5px; border-radius: 5px 5px 0 0">\n' +
        '      <span class="uk-margin-small-right"><span class="uk-sortable-handle" uk-icon="icon: table;  ratio: 0.8"></span></span>\n' +
        '      <span class="pb-row-control-item"><span uk-icon="icon: copy; ratio: 0.8"></span></span>\n' +
        '      <span class="uk-margin-small-right uk-margin-small-left pb-row-control-item"><span uk-icon="icon: cog; ratio: 0.8"></span></span>\n' +
        '      <span class="pb-row-control-item" onclick="deleteContentItem(this)"><span uk-icon="icon: trash; ratio: 0.8"></span></span>\n' +
        '    </span>\n' +
        '    <div class="pb-row-components">\n' +
        '      <!-- grid -->\n' +
        '      <div class="pb-grid uk-grid-small uk-flex uk-flex-middle" uk-grid>\n' +
        '        \n' +
        '      </div>\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</li>';

    var draggable =  null;
    var draggableType =  null;
    var dragoverItem =  null;
    var dragIn =  null;
    var dragAfter =  null;
    var dragOver =  null;
    var columnsCount =  1;
    var elementType =  null;
    var currentHoveredRowId =  null;
    var currentHoveredColumnId =  null;
    var currentHoveredElementId =  null;
    var openedWidgetSetting =  null;

    function resetParameters(){
        draggableType = currentHoveredRowId = null;
    }

    /*
     *
     */
    function getHoveredRowId(){
        $('.pb-content-item').on({
            dragover: function (e){
                e.preventDefault();
                draggable = $(this);
                currentHoveredRowId = draggable.attr('id');
                if (draggableType == 'column'){
                    draggable.find('.pb-row').addClass('pg-hovered');
                }
            },
            dragleave: function (){
                draggable = $(this);
                draggable.find('.pb-row').removeClass('pg-hovered');

            }
        });
    }
    /*
    /
     */
    function getHoveredColumnId(){
        $('.pb-grid-column').on({
            dragover: function (e){
                e.preventDefault();
                dragOver = $(this);
                currentHoveredColumnId = dragOver.attr('id');
            },
        });
    }
    getHoveredColumnId();
    getHoveredRowId();

    $('.pb-draggable-item').on({
        dragstart: function (e){
            draggable = $(this);
            resetParameters();
            draggableType = draggable.attr('pb-draggableType');
            if (draggableType == 'column'){
                columnsCount = draggable.attr('pb-columns-count');
            }else if (draggableType == 'element'){
                elementType = draggable.attr('pb-elementType');
            }
        },
        dragend: function (){
            if (draggableType == 'column'){
                var newId = generateRandomString(6);
                var newRow = $(pbContentListItemTemplate);
                newRow.find('.pb-row').closest('li').attr('id', 'pbRow-'+newId);
                for (i = 1; i <= columnsCount; i++) {
                    var newColumnId = generateRandomString(6);
                    newRow.find('.pb-grid').append('' +
                        '<div id="pbColumn-'+newColumnId+'" class="pb-grid-column uk-width-1-1 uk-width-1-'+columnsCount+'@m">\n' +
                        '  <span class="pb-column-control-bar uk-light">\n' +
                        '     <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>\n' +
                        '  </span>\n' +
                        '  <div class="pb-column-content pb-empty-column uk-text-center">\n' +
                        '    +\n' +
                        '  </div>\n' +
                        '</div>');
                }
                if (currentHoveredRowId == null){
                    $('#pb-content').append(newRow);
                }else {
                    $( "#"+currentHoveredRowId).after(newRow);
                }
                draggable.find('.pb-row').removeClass('pg-hovered');
                getHoveredRowId();
                getHoveredColumnId();
                resetParameters();
            } else if (draggableType == 'element'){
                var newId = generateRandomString(6);
                var currentRowColumn = $('#'+currentHoveredColumnId).find('.pb-column-content');
                if (currentRowColumn.hasClass('pb-empty-column')){
                    currentRowColumn.removeClass('pb-empty-column');
                    currentRowColumn.html('');
                }
                var content = getWidget(elementType)
                var WidgetContent = $(content.content);
                WidgetContent.attr('pbWidgetType', content.id);
                WidgetContent.attr('id', 'pbWidget-'+newId);
                currentRowColumn.append(WidgetContent);
                if(content.id == 'hotspotImage'){
                    drawMarker(newId,26,21);
                };
                openWidgetSettings();
            }


        }
    });
    function drawMarker(id, topPercentage, leftPercentage){
        var widgetId = 'pbWidget-'+id;
        var widgetItem = $('#'+widgetId);
        var markersDiv = widgetItem.find('.pb-hotspot-marker-items');
        var newMarkerId = generateRandomString(6);

        markersDiv.append('' +
            '<div id="pbMarker-'+newMarkerId+'" class="pb-hotspot-marker uk-dark">\n' +
            '  <a class="uk-position-absolute uk-transform-center pin" style="left: '+leftPercentage+'%; top: '+topPercentage+'%; opacity: 0.8" href="#" uk-marker></a>\n' +
            '  <div uk-dropdown="mode: click" class="uk-padding-small">This is my Marker description</div>\n' +
            '</div>');

    };

    $('.pb-element').on({
        dragstart: function (e){
            draggable = $(this);
            draggableType = draggable.attr('pb-draggableType');
            elementType = draggable.attr('pb-elementType');
            currentHoveredRowId = null;
        },
        // dragend: function (){
        //     var newId = generateRandomString(6);
        //     var newRow = $(pbContentListItemTemplate);
        //     newRow.find('.pb-row').closest('li').attr('id', 'bgRow-'+newId);
        //     for (i = 1; i <= columnsCount; i++) {
        //         newRow.find('.pb-grid').append('' +
        //             '<div class="pb-grid-column uk-width-1-1 uk-width-1-'+columnsCount+'@m">\n' +
        //             '  <span class="pb-column-control-bar uk-light">\n' +
        //             '     <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>\n' +
        //             '  </span>\n' +
        //             '  <div class="pb-column-content uk-text-center">\n' +
        //             '    +\n' +
        //             '  </div>\n' +
        //             '</div>')
        //     }
        //     if (currentHoveredRowId == null){
        //         $('#pb-content').append(newRow);
        //     }else {
        //         $( "#"+currentHoveredRowId).after(newRow);
        //     }
        //     dr.find'.pb-rowaggable.removeClass('pg-hovered');
        //     getHoveredRowId();
        //     resetParameters();
        //
        // }
    });

    /**
     * js initials
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var selectedMediaItemId = null;

    // Dropzone uploader
    Dropzone.autoDiscover = false;

    // A quick way setup
    var myDropzone = new Dropzone("#dropzoneMediaForm", {
        // Files uploading
        acceptedFiles: "image/*,video/*",
        maxFiles: 1,
        // uploadMultiple: true,
        autoProcessQueue: true,
        // uploadMultiple: true,
        method: "POST",
        // Setup chunking
        chunking: true,
        maxFilesize: 400000000,
        chunkSize: 1000000,
        // If true, the individual chunks of a file are being uploaded simultaneously.
        parallelChunkUploads: true,
        init: function(){
            this.on("complete", function(file) {
                if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){
                    var _this = this;
                    setTimeout(
                        function()
                        {
                            _this.removeAllFiles();
                        }, 1500);
                }
                if (file.xhr.response){
                    var media = JSON.parse(file.xhr.response);
                    console.log(media.url);
                    drawMediaItem(media);
                }
            });
        }

    });

    function resetSelectedMedia()
    {
        $('.media-item').map(function() {
            var index = $(this);
            index.removeClass('selected-media-item');
        });
    }

    function activateSelectedMedia()
    {
        $('.media-item').off('click');
        $('.media-item').click(function (){
            resetSelectedMedia();
            var item = $(this);
            item.addClass('selected-media-item');

        });
    }
    function getSelectedMediaItemId()
    {
        $('.media-item-image').click(function (){
            var item = $(this).closest('.media-item')
            selectedMediaItemId = item.attr('id');
        });

    }

    $('.image-setting-image-thump').click(function (){
        UIkit.modal('#media-library-modal').show();

    });
    $('.replace-widget-image').click(function (){
        var widgetImage = $('#'+openedWidgetSetting);
        var selectedMediaImage = $('#'+selectedMediaItemId).find('.media-item-image').attr('data-src');
        widgetImage.find('.pb-widget-image').attr('data-src', selectedMediaImage);
        $('.image-setting-image-thump').attr('data-src', selectedMediaImage);
        UIkit.modal('#media-library-modal').hide();
    });

    function drawMediaItem(item)
    {
        $('#media-items').prepend('' +
            '<div id="mediaItem-'+item.id+'" class="media-item">\n' +
            '   <span class="uk-icon-button selected-media-icon" uk-icon="check"></span>\n' +
            '   <img class="uk-box-shadow-hover-medium media-item-image" data-src="'+item.url+'" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>\n' +
            '</div>');
        activateSelectedMedia();
        resetSelectedMedia();
        getSelectedMediaItemId();
    }


    $.get('{{ route('media.get.library.items')}}')
        .done(function (response) {
            response.map(function (item){
                drawMediaItem(item);
            });
        });



</script>
