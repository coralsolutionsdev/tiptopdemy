<script>

        // toggle control panel //
        $('.pb-control-toggle').click(function (){
            var control = $('#pb-control');
            if (control.hasClass('hidden-control')){
                control.show();
                control.removeClass('hidden-control');
            }else{
                control.hide();
                control.addClass('hidden-control');
            }
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
            content: '<div class="pb-widget-wrapper uk-inline-clip uk-transition-toggle" tabindex="0" style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px">\n' +
                '  <img class="pb-widget-image" data-src="{{asset_image('assets/blank_image.png')}}"  sizes="(min-width: 650px) 650px, 100vw" width="650" uk-img>\n' +
                '</div>',
            },{
            id: 'textEditor', // id is mandatory
            label: '<b>textEditor</b>', // You can use HTML/SVG inside labels
            attributes: { class:'' },
            content: '<div class="pb-widget-wrapper pb-widget-text-editor" style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px">\n' +
                'Hello world!</br>\n' +
                'This is my initial text\n' +
                '</div>',
            },{
            id: 'video', // id is mandatory
            label: '<b>video</b>', // You can use HTML/SVG inside labels
            attributes: { class:'' },
                content: '<div class="pb-widget-wrapper uk-inline-clip uk-transition-toggle uk-responsive-height" video-type-value="internal" tabindex="0" style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px">\n' +
                    '  <video src="" class="uk-responsive-width pb-widget-video" width="1920" height="1080" playsinline controls disablepictureinpicture controlsList="nodownload" uk-responsive></video>\n' +
                    '</div>',
            },
            {
                id: 'hotspotImage', // id is mandatory
                label: '<b>hotspotImage</b>', // You can use HTML/SVG inside labels
                attributes: { class:'' },
                content: '<div class="pb-widget-wrapper uk-inline-clip uk-inline-clip-show-overflow uk-transition-toggle" tabindex="0" style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px">\n' +
                    '  <div class="pb-hotspot-marker-items">\n' +
                    '  <img class="pb-widget-image" data-src="{{asset_image('assets/blank_image.png')}}"  sizes="(min-width: 650px) 650px, 100vw" width="650" uk-img>\n' +
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
        function removeWidget()
        {
            $('.pb-remove-widget').off('click')
            $('.pb-remove-widget').click(function (){
                UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to remove this widget?').then(function() {
                    $('#'+openedWidgetSetting).remove();
                    resetControlPanel();
                }, function () {
                    console.log('Rejected.')
                });
            });
        }
        removeWidget();
        function openWidgetSettings(){
            $('.pb-widget-wrapper').dblclick(function (){
                resetOpenWidgetSettings();
                $('.pb-content-item-settings-wrapper').slideUp();

                var activeWidget = $(this).closest('.pb-widget-wrapper');
                $('.pb-widgets-wrapper').slideUp();
                $('.pb-setting-wrapper').slideDown();
                var activeWidgetType = activeWidget.attr('pbWidgetType');
                var activeWidgetId = activeWidget.attr('id');
                if (activeWidgetType == 'textEditor'){
                    addMinyTinyEditor('#'+activeWidgetId);
                }
                $('.'+activeWidgetType+'-setting').show();
                if (activeWidgetType == 'image' || activeWidgetType == 'hotspotImage'){
                    var activeWidgetImageUrl = activeWidget.find('.pb-widget-image').attr('data-src');
                    $('.image-setting-image-thump').attr('data-src', activeWidgetImageUrl);
                }
                openedWidgetSetting = activeWidget.attr('id');
                openedWidgetType = activeWidgetType;
                var marginTop = activeWidget.css('margin-top').replace('px','');
                $('.input-margin-value').val(marginTop);
                $('.current-margin-value').html(marginTop);
                if (openedWidgetType == 'video'){
                    var videoSource = activeWidget.attr('video-type-value');
                    $('.video-source-input').val(videoSource)
                    $('.video-source-setting').map(function (){
                       $(this).hide();
                    });
                    $('.video-source-setting-'+videoSource).show();
                }
                updateWidgetSettings();

            });
        }
        openWidgetSettings();

        $('.video-source-input').change(function (){
            var videoSource = $(this).val();
            var activeWidget = $('#'+openedWidgetSetting);
            activeWidget.attr('video-type-value', videoSource)
            $('.video-source-setting').map(function (){
                $(this).hide();
            });
            $('.video-source-setting-'+videoSource).show();
        });

        $('.pb-view-widgets-list').click(function (){
            $('.pb-setting-wrapper').slideUp();
            $('.pb-page-wrapper').slideUp();
            $('.pb-widgets-wrapper').slideDown();
            $('.pb-content-item-settings-wrapper').slideUp();
        });
        $('.pb-view-page-settings').click(function (){
            $('.pb-setting-wrapper').slideUp();
            $('.pb-widgets-wrapper').slideUp();
            $('.pb-page-wrapper').show();
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
                $('.pb-content-item-settings-wrapper').hide();

            }, function () {
                console.log('Rejected.')
            });
        }
        var activeContentItemId = null;

        function updateContentItemSettings()
        {
            var editableContentItem = $('#'+activeContentItemId);
            var inputTopValue, inputLeftValue, bgTransparencyValue, editableContentItemGrid;
            bgTransparencyValue = editableContentItem.attr('bg-transparency-value');
            editableContentItemGrid =  editableContentItem.find('.pb-grid');
            $(document).off('input');
            $(document).on('input', '.input-padding-value', function() {
                inputTopValue = $(this).val();
                editableContentItem.find('.pb-row-components').css('padding-left',inputTopValue+'px').css('padding-top',inputTopValue+'px').css('padding-right',inputTopValue+'px').css('padding-bottom',inputTopValue+'px');
                $('.current-padding-value').html(inputTopValue);
                // $('.pb-marker-pin-'+id).css("top", inputTopValue+"%");
                // marker.find('.pb-marker-pin').css("top", inputTopValue+"%");
                // marker.find('.pb-marker-pin').attr("top-value", inputTopValue);
            });
            // $(document).on('input', '.input-left-value', function() {
            //     inputLeftValue = $(this).val();
            //     $('.pb-marker-pin-'+id).css("left", inputLeftValue+"%");
            //     marker.find('.pb-marker-pin').css("left", inputLeftValue+"%");
            //     marker.find('.pb-marker-pin').attr("left-value", inputLeftValue);
            // });
            // $(document).on('change', '.hotspot-color', function() {
            //     inputLeftValue = $(this).val();
            //     console.log(inputLeftValue)
            //     editableMarker.attr('color-class-value', )
            //     if (inputLeftValue == 'uk-dark'){
            //         editableMarker.removeClass('uk-light');
            //         editableMarker.addClass('uk-dark');
            //         marker.removeClass('uk-light');
            //         marker.addClass('uk-dark');
            //     }else{
            //         editableMarker.removeClass('uk-dark');
            //         editableMarker.addClass('uk-light');
            //         marker.removeClass('uk-dark');
            //         marker.addClass('uk-light');
            //     }
            //     // marker.find('.pb-marker-pin').css("left", inputLeftValue+"%");
            //     // marker.find('.pb-marker-pin').attr("left-value", inputLeftValue);
            // });
        }

        function openContentItemSettings(event){
            $('.pb-widgets-wrapper').slideUp();
            $('.pb-setting-wrapper').slideUp();
            $('.pb-page-wrapper').slideUp();

            var item = $(event.closest('.pb-content-item'));
            var contentItemId = item.attr('id');
            activeContentItemId = contentItemId;
            $('.pb-content-item-settings-wrapper').show();
            updateContentItemSettings();

        }

        // templates
        var pbContentListItemTemplate = '' +
            '<li id="" class="pb-content-item" bg-transparency-value="1">\n' +
            '  <div class="pb-row uk-card uk-padding-remove uk-container">\n' +
            '    <!--row control bar-->\n' +
            '    <span class="pb-row-control-bar uk-background-primary uk-light uk-position-top-center" style="margin-top: -24px; padding:2px 5px; border-radius: 5px 5px 0 0">\n' +
            '      <span class="uk-margin-small-right"><span class="uk-sortable-handle" uk-icon="icon: table;  ratio: 0.8"></span></span>\n' +
            // '      <span class="pb-row-control-item"><span uk-icon="icon: copy; ratio: 0.8"></span></span>\n' +
            '      <span class="uk-margin-small-right pb-row-control-item" onclick="openContentItemSettings(this)"><span uk-icon="icon: cog; ratio: 0.8"></span></span>\n' +
            '      <span class="pb-row-control-item" onclick="deleteContentItem(this)"><span uk-icon="icon: trash; ratio: 0.8"></span></span>\n' +
            '    </span>\n' +
            '    <div class="pb-row-components" style="padding-left: 10px; padding-top: 10px; padding-right: 10px; padding-bottom: 10px">\n' +
            '      <!-- grid -->\n' +
            '      <div class="pb-grid uk-grid-collapse uk-flex uk-flex-middle" uk-grid style="">\n' +
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
        var openedWidgetType =  null;

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
                    newRow.find('.pb-row').closest('li').attr('id', 'pbContentItem-'+newId);
                    for (i = 1; i <= columnsCount; i++) {
                        var newColumnId = generateRandomString(6);
                        newRow.find('.pb-grid').append('' +
                            '<div id="pbColumn-'+newColumnId+'" class="pb-grid-column uk-width-1-1 uk-width-1-'+columnsCount+'@m" style="padding: 0px">\n' +
                            '  <span class="pb-column-control-bar uk-light">\n' +
                            // '     <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>\n' +
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
                        var widgetId = 'pbWidget-'+newId;
                        var markerId = generateRandomString(6);
                        drawMarker(widgetId,markerId,26,21);
                    };
                    openWidgetSettings();
                    removeWidget();
                }


            }
        });


        function updateWidgetSettings()
        {
            var inputTopValue, openWidgetWrapper;

            if (openedWidgetSetting != null){
                var openWidget = $('#'+openedWidgetSetting);
                $(document).off('input');
                $(document).on('input', '.input-margin-value', function() {
                    inputTopValue = $(this).val();
                    openWidget.css('margin-left',inputTopValue+'px').css('margin-top',inputTopValue+'px').css('margin-right',inputTopValue+'px').css('margin-bottom',inputTopValue+'px');
                    $('.current-margin-value').html(inputTopValue);
                });

            }
            // $(document).off('input');
            // $(document).on('input', '.input-top-value', function() {
            //     inputTopValue = $(this).val();
            //     $('.pb-marker-pin-'+id).css("top", inputTopValue+"%");
            //     marker.find('.pb-marker-pin').css("top", inputTopValue+"%");
            //     marker.find('.pb-marker-pin').attr("top-value", inputTopValue);
            // });
            // $(document).on('input', '.input-left-value', function() {
            //     inputLeftValue = $(this).val();
            //     $('.pb-marker-pin-'+id).css("left", inputLeftValue+"%");
            //     marker.find('.pb-marker-pin').css("left", inputLeftValue+"%");
            //     marker.find('.pb-marker-pin').attr("left-value", inputLeftValue);
            // });
            // $(document).off('change');
            // $(document).on('change', '.hotspot-color', function() {
            //     inputLeftValue = $(this).val();
            //     console.log(inputLeftValue)
            //     editableMarker.attr('color-class-value', )
            //     if (inputLeftValue == 'uk-dark'){
            //         editableMarker.removeClass('uk-light');
            //         editableMarker.addClass('uk-dark');
            //         marker.removeClass('uk-light');
            //         marker.addClass('uk-dark');
            //         marker.attr('color-class-value','uk-dark')
            //     }else{
            //         editableMarker.removeClass('uk-dark');
            //         editableMarker.addClass('uk-light');
            //         marker.removeClass('uk-dark');
            //         marker.addClass('uk-light');
            //         marker.attr('color-class-value','uk-light')
            //     }
            //     // marker.find('.pb-marker-pin').css("left", inputLeftValue+"%");
            //     // marker.find('.pb-marker-pin').attr("left-value", inputLeftValue);
            // });
            //
            // $('.save-hotspot-changes').click(function (){
            //     UIkit.modal('#hotspot-manager-modal').hide();
            //     tinymce.remove('.pb-marker-description-content-editor');
            //     resetMarkerEditor();
            // });


        }


        function drawMarker(widgetId, markerId, topPercentage, leftPercentage){
            var widgetItem = $('#'+widgetId);
            var markersDiv = widgetItem.find('.pb-hotspot-marker-items');
            markersDiv.append('' +
                '<div id="pbMarker-'+markerId+'" class="pb-hotspot-marker uk-dark" color-class-value="uk-dark">\n' +
                '  <a class="uk-position-absolute uk-transform-center pb-marker-pin pin" top-value="'+topPercentage+'" left-value="'+leftPercentage+'" style="left: '+leftPercentage+'%; top: '+topPercentage+'%; opacity: 0.8" href="#" uk-marker></a>\n' +
                '  <div uk-dropdown="mode: click" class="uk-padding-small pb-hotspot-marker-description">This is my Marker description</div>\n' +
                '</div>');
            updateWidgetSettings();
        };
        function drawEditableMarker(markerId, topPercentage, leftPercentage, markerColor){
            $('#pb-hotspot-markers-map').append('' +
                '<div id="pbMarkerEditable-'+markerId+'" class="pb-hotspot-marker pb-hotspot-marker-editable '+markerColor+'" color-class-value="'+markerColor+'">\n' +
                '  <a class="uk-position-absolute uk-transform-center pb-marker-pin-'+markerId+' pin" style="left: '+leftPercentage+'%; top: '+topPercentage+'%; opacity: 0.8" href="#" uk-marker></a>\n' +
                '</div>');
        };

        $('.pb-element').on({
            dragstart: function (e){
                draggable = $(this);
                draggableType = draggable.attr('pb-draggableType');
                elementType = draggable.attr('pb-elementType');
                currentHoveredRowId = null;
            },
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

        Dropzone.options.dropzoneForm = {
            // Setup chunking
            acceptedFiles: "image/*,video/*",
            maxFiles: 5,
            timeout: 3600000,
            autoProcessQueue: true,
            chunking: true,
            maxFilesize: 400000000,
            chunkSize: 1000000,
            // If true, the individual chunks of a file are being uploaded simultaneously.
            parallelChunkUploads: false,
            init: function() {

                var myDropZone = this;

                var cancelBtn = $('#dropZoneCancelUpload');
                $('.media-uploader-tab').click(function (){
                    if (myDropZone.files && myDropZone.files.length < 1){
                        $('.process-icon').html('')
                        $('.process-status').html('');
                    }
                });
                // cancel uploading
                cancelBtn.click(function (){
                    myDropZone.removeAllFiles(true);
                    $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: minus-circle"></span></span>')
                    $('.process-status').html('<span class="uk-text-danger"> Uploading canceled</span>');
                    cancelBtn.hide();
                });

                this.on("addedfile", function(file) {
                    // alert("Added file.");
                    cancelBtn.show();
                    $('.process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.6"></div></span>')
                });
                this.on("uploadprogress", function(file, progress, bytesSent) {
                    progress = bytesSent / file.size * 100;
                    $('.dz-upload').width(progress + "%");
                    if (progress > 99.9){
                        progress = 100
                    }
                    if (progress < 99.9){
                        $('.process-status').html('<span class="uk-text-success"> Processing: (Please keep this window opened)</span>');
                    }
                    $('.process-status').html('<span class="uk-text-primary"> Uploading: '+progress.toFixed(1)+'%</span>');
                });
                this.on("complete", function(file) {
                    if (file.xhr.response){
                        var item = JSON.parse(file.xhr.response)
                        drawMediaItem(item);
                    }


                    {{--if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){--}}
                    {{--    var _this = this;--}}
                    {{--    _this.removeAllFiles();--}}
                    {{--}--}}
                    {{--if (file.xhr.response){--}}
                    {{--    var media = JSON.parse(file.xhr.response);--}}
                    {{--    // console.log(media, media.path);--}}
                    {{--    submitBtn.attr('disabled', false);--}}
                    {{--    submitBtn.html("{{__('main.Start upload')}}");--}}
                    {{--    cancelBtn.hide();--}}
                    {{--    // $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')--}}
                    {{--    $('.process-status').html('<span class="uk-text-success"> Processing: (Please keep this window opened)</span>');--}}
                    {{--    drawMediaItem(media);--}}

                    {{--}--}}
                });
                this.on("success", function(event) {
                    if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0){
                        var _this = this;
                        setTimeout(
                            function()
                            {
                                _this.removeAllFiles();
                            }, 1500);
                    }
                    cancelBtn.hide();
                    $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')
                    $('.process-status').html('<span class="uk-text-success"> Completed: 100%</span>');
                    UIkit.notification("<span uk-icon='icon: check'></span> Uploading status: "+ event.status, {pos: 'top-center', status:'success'})

                });
                this.on("error", function(event) {
                    {{--console.log(event);--}}
                    {{--UIkit.notification("<span uk-icon='icon: warning'></span> " +event.status, {pos: 'top-center', status:'danger'});--}}
                    {{--submitBtn.html("{{__('main.Start upload')}}");--}}
                    {{--cancelBtn.hide();--}}
                    {{--submitBtn.attr('disabled', false);--}}
                    {{--submitBtn.html("{{__('main.Start upload')}}");--}}
                });
            }
        }


        function resetSelectedMedia()
        {
            $('.media-item').map(function() {
                var index = $(this);
                index.removeClass('selected-media-item');
                index.parent().hide()
                switch(openedWidgetType) {
                    case 'image':
                        console.log(openedWidgetType);
                        if (index.attr('type-value') == 'image'){
                            index.parent().show()
                        }
                        break;
                    case 'hotspotImage':
                        if (index.attr('type-value') == 'image'){
                            index.parent().show()
                        }
                        break;
                    case 'video':
                        if (index.attr('type-value') == 'video'){
                            index.parent().show()
                        }
                        break;
                }

            });
        }
        $('.open-media-library-modal, .image-setting-image-thump').off('click').click(function (){
            resetSelectedMedia();
        });

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
            $('.media-item-preview').click(function (){
                var item = $(this).closest('.media-item')
                selectedMediaItemId = item.attr('id');
            });

        }

        $('.image-setting-image-thump').click(function (){
            UIkit.modal('#media-library-modal').show();

        });
        $('.replace-widget-image').click(function (){
            var widgetImage = $('#'+openedWidgetSetting);
            if (openedWidgetType == 'video'){
                console.log(selectedMediaItemId)
                var mediaUrl = $('#'+selectedMediaItemId).find('.media-item-preview').attr('src');
                widgetImage.html('<video src="'+mediaUrl+'" class="uk-responsive-width pb-widget-video" width="1920" height="1080" playsinline controls disablepictureinpicture controlsList="nodownload" uk-responsive></video>');

            }else{
                var selectedMediaImage = $('#'+selectedMediaItemId).find('.media-item-preview').attr('data-src');
                widgetImage.find('.pb-widget-image').attr('data-src', selectedMediaImage);
                $('.image-setting-image-thump').attr('data-src', selectedMediaImage);
            }

            UIkit.modal('#media-library-modal').hide();
        });


        function updateMarkerValues(id)
        {
            var editableMarker = $('#pbMarkerEditable-'+id);
            var marker = $('#pbMarker-'+id);
            var inputTopValue, inputLeftValue;
            $(document).off('input');
            $(document).on('input', '.input-top-value', function() {
                inputTopValue = $(this).val();
               $('.pb-marker-pin-'+id).css("top", inputTopValue+"%");
                marker.find('.pb-marker-pin').css("top", inputTopValue+"%");
                marker.find('.pb-marker-pin').attr("top-value", inputTopValue);
            });
            $(document).on('input', '.input-left-value', function() {
                inputLeftValue = $(this).val();
                $('.pb-marker-pin-'+id).css("left", inputLeftValue+"%");
                marker.find('.pb-marker-pin').css("left", inputLeftValue+"%");
                marker.find('.pb-marker-pin').attr("left-value", inputLeftValue);
            });
            $(document).off('change');
            $(document).on('change', '.hotspot-color', function() {
                inputLeftValue = $(this).val();
                editableMarker.attr('color-class-value', )
                if (inputLeftValue == 'uk-dark'){
                    editableMarker.removeClass('uk-light');
                    editableMarker.addClass('uk-dark');
                    marker.removeClass('uk-light');
                    marker.addClass('uk-dark');
                    marker.attr('color-class-value','uk-dark')
                }else{
                    editableMarker.removeClass('uk-dark');
                    editableMarker.addClass('uk-light');
                    marker.removeClass('uk-dark');
                    marker.addClass('uk-light');
                    marker.attr('color-class-value','uk-light')
                }
                // marker.find('.pb-marker-pin').css("left", inputLeftValue+"%");
                // marker.find('.pb-marker-pin').attr("left-value", inputLeftValue);
            });

            $('.save-hotspot-changes').click(function (){
                UIkit.modal('#hotspot-manager-modal').hide();
                tinymce.remove('.pb-marker-description-content-editor');
                resetMarkerEditor();
            });


        }

        function resetMarkerEditor(){
            $('.marker-message').show();
            $('.marker-adding-mode').hide();
            $('.marker-editor').hide();
            $('#pb-hotspot-markers-map').html('');
            tinymce.remove('.pb-marker-description-content-editor');
            activeMarkerId = null;
        }

        var activeMarkerId = null;

        function openMarkerEditorSetting(itemId){
            tinymce.remove('.pb-marker-description-content-editor');
            var widgetItem = $('#pbMarker-'+itemId);
            var markerEditor = $('.marker-editor');
            markerEditor.show();
            var widgetItemTitle = '';
            var widgetItemDescription = widgetItem.find('.pb-hotspot-marker-description').html();
            var widgetItemTop = widgetItem.find('.pb-marker-pin').attr('top-value');
            var widgetItemLeft = widgetItem.find('.pb-marker-pin').attr('left-value');
            var widgetItemColor = widgetItem.attr('color-class-value');
            // temp
            if (widgetItemColor == 'uk-dark'){
                $('.hotspot-color-dark').prop('checked', true)
            }else{
                $('.hotspot-color-light').prop('checked', true)
            }

            // update marker editor
            $('.pb-marker-description-content-editor').val(widgetItemDescription);
            $('.hidden-textarea-input').val(widgetItemDescription);
            addMinyTinyEditor('.pb-marker-description-content-editor');
            $('.input-top-value').val(widgetItemTop);
            $('.input-left-value').val(widgetItemLeft);
            $('.input-left-value').val(widgetItemLeft);
            $('.marker-message').hide();
            updateMarkerValues(itemId);
        }

        function openMarkerEditor()
        {
            $('.pb-hotspot-marker-editable').off('click');
            $('.pb-hotspot-marker-editable').click(function (){
                var item = $(this);
                var itemId = item.attr('id').split('-')[1];
                if (activeMarkerId == itemId){
                    return false;
                }
                activeMarkerId = itemId;
                // $('.marker-adding-mode').hide();
                openMarkerEditorSetting(itemId);

            });
        }
        var addMarkerModeActivate =  false;

        $('.pb-add-hotspot').click(function (){
            addMarkerModeActivate = true;
            $('.marker-message').hide();
            $('.marker-editor').hide();
            $('.marker-adding-mode').show();

        });

        function addNewMarker(){
            $('#hotspotImage-setting-image').off( "click" ).click(function(e) {
                if (addMarkerModeActivate ==  true){
                    var offset = $(this).offset();
                    var x = Math.floor((e.pageX - offset.left) / $(this).width() * 10000)/100;
                    var y = Math.floor((e.pageY - offset.top) / $(this).height() * 10000)/100;
                    var markerPinLeft = parseInt(x);
                    var markerPinTop = parseInt(y);
                    var markerColor = 'uk-dark';
                    // console.log(markerPinTop)

                    var widgetId = openedWidgetSetting;
                    var markerId = generateRandomString(6);
                    drawMarker(widgetId,markerId,markerPinTop,markerPinLeft);
                    // and
                    drawEditableMarker(markerId, markerPinTop, markerPinLeft, markerColor)
                    addMarkerModeActivate = false;
                    openMarkerEditor();
                    openMarkerEditorSetting(markerId);
                    $('.marker-message').hide();
                    $('.marker-adding-mode').hide();
                }

            });
        }

        $('.pb-open-hotspot-marker-modal').click(function (){
            resetMarkerEditor();
            var widgetHotspotImage = $('#'+openedWidgetSetting);
            var imageSrc = widgetHotspotImage.find('.pb-widget-image').attr('data-src');
            $('#pb-hotspot-markers-map').append('<img id="hotspotImage-setting-image" class="hotspotImage-setting-image-thump" data-src="'+imageSrc+'" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>');

            var widgetMarkers = widgetHotspotImage.find('.pb-marker-pin');
            // pb-hotspot-markers-map
            widgetMarkers.map(function (){
                var markerPin = $(this);
                var markerPinId = markerPin.closest('.pb-hotspot-marker').attr('id').split('-')[1];
                var markerPinTop = markerPin.attr("top-value");
                var markerPinLeft = markerPin.attr("left-value");
                var markerColor = markerPin.closest('.pb-hotspot-marker').attr("color-class-value");
                $('.top-position').val(markerPinTop);
                $('.left-position').val(markerPinLeft);
                drawEditableMarker(markerPinId, markerPinTop, markerPinLeft, markerColor)

            });
            openMarkerEditor();
            addNewMarker();


        });

        // function drawMediaItem(item)
        // {
        //     $('#media-items').prepend('' +
        //         '<div id="mediaItem-'+item.id+'" class="media-item">\n' +
        //         '   <span class="uk-icon-button selected-media-icon" uk-icon="check"></span>\n' +
        //         '   <img class="uk-box-shadow-hover-medium media-item-preview" data-src="'+item.url+'" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>\n' +
        //         '</div>');
        //
        // }

        // function drawMediaItem(item)
        // {
        //     console.log(item);
        //     $('#media-items').prepend('');
        // }
        function drawMediaItem(item)
        {
            var imageUrl = item.url;
            var prevTag =  null;
            if (item.file_type == "image"){
                prevTag = '<img class="uk-box-shadow-hover-medium media-item-preview" data-src="'+imageUrl+'" sizes="(min-width: 650px) 650px, 100vw"  height="" alt="" uk-img>'
            } else if (item.file_type == "video"){
                prevTag = '<video class="uk-box-shadow-hover-medium media-item-preview" src="'+item.url+'" playsinline controls disablepictureinpicture controlsList="nodownload"></video>';
            }
            $('#media-items').prepend('' +
                '<div><div id="mediaItem-'+item.id+'" class="media-item inactive-div" type-value="'+item.file_type+'">\n' +
                '   <span class="uk-icon-button selected-media-icon" uk-icon="check"></span>\n' +
                    prevTag+
                '</div></div>');
            activateSelectedMedia();
            resetSelectedMedia();
            getSelectedMediaItemId();
        }


        $.get('{{ route('media.get.library.items')}}')
            .done(function (response) {
                $('#media-items').html('');
                response.map(function (media){
                    var item = {
                        id:media.id,
                        name:media.name,
                        url:media.url,
                        file_type:media.custom_properties.file_type,
                        file_size_string:media.custom_properties.file_size_string,
                        extension:media.custom_properties.extension,
                        creation_date:media.creation_date,
                    }
                    drawMediaItem(item);
                });
            });

        $('.submit-content-form').off('click').click(function (){
            $("input[name=content]").val($('#pb-content').html());
            $('#contentForm').submit();
        });


</script>


