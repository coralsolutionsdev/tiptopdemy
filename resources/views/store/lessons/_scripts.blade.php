<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    {{--$('.uploader-input').change(function (){--}}
    {{--    var file_names = $.map($(this).prop('files'), function(file)--}}
    {{--    {--}}
    {{--        return file.name;--}}
    {{--    });--}}
    {{--    var file_section = $('.uploader-items');--}}
    {{--    file_section.html('');--}}
    {{--    file_names.map(function(file_name)--}}
    {{--    {--}}
    {{--        file_section.append('<span><span uk-icon="icon: play-circle"></span> '+file_name+'</span>');--}}
    {{--    });--}}
    {{--});--}}

    function resetProgressBar(){
        var bar = $('#js-progressbar');
        bar.attr('value', 0)
    }
    {{--function resetUploadForm($resetType = true)--}}
    {{--{--}}
    {{--    $('#insertMediaModalForm').get(0).reset();--}}
    {{--    if ($resetType ==  true){--}}
    {{--        $("[name='type']").val({{\App\Modules\Media\Media::TYPE_YOUTUBE}});--}}
    {{--    }--}}
    {{--    $('.uploader-items').html('');--}}
    {{--}--}}
    {{--function resetInsertMediaModal()--}}
    {{--{--}}
    {{--    resetUploadForm();--}}
    {{--    resetProgressBar();--}}
    {{--    $('.process-icon').html('')--}}
    {{--    $('.process-status').html('');--}}

    {{--    UIkit.tab('.media-tabs').show(0);--}}
    {{--}--}}
    {{--$('.open-insert-media-modal').click(function (){--}}
    {{--    resetInsertMediaModal();--}}
    {{--});--}}

    {{--$('.media-tab-item').click(function (){--}}
    {{--    var btn = $(this);--}}
    {{--    var type = btn.attr('data-value');--}}
    {{--    resetInsertMediaModal();--}}
    {{--    resetUploadForm();--}}
    {{--    // $("[name='type']").val(type);--}}
    {{--});--}}

    /**
     * Attach medoa to lesson
     */
    Dropzone.autoDiscover = false;


    $(document).ready(function() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("div#mydropzone").dropzone({
            url: "{{route('store.media.attach')}}",
            timeout: 3600000,
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            acceptedFiles: "video/*",
            maxFiles: 5,
            uploadMultiple: false,
            addedfile: function addedfile(file) {
                var _this2 = this;
                if (this.element === this.previewsContainer) {
                    this.element.classList.add("dz-started");
                }

                if (this.previewsContainer) {
                    file.previewElement = Dropzone.createElement(this.options.previewTemplate.trim());
                    file.previewTemplate = file.previewElement; // Backwards compatibility

                    this.previewsContainer.appendChild(file.previewElement);
                    var _iteratorNormalCompletion3 = true;
                    var _didIteratorError3 = false;
                    var _iteratorError3 = undefined;

                    try {
                        for (var _iterator3 = file.previewElement.querySelectorAll("[data-dz-name]")[Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                            var node = _step3.value;
                            node.textContent = file.name;
                        }
                    } catch (err) {
                        _didIteratorError3 = true;
                        _iteratorError3 = err;
                    } finally {
                        try {
                            if (!_iteratorNormalCompletion3 && _iterator3["return"] != null) {
                                _iterator3["return"]();
                            }
                        } finally {
                            if (_didIteratorError3) {
                                throw _iteratorError3;
                            }
                        }
                    }

                    var _iteratorNormalCompletion4 = true;
                    var _didIteratorError4 = false;
                    var _iteratorError4 = undefined;

                    try {
                        for (var _iterator4 = file.previewElement.querySelectorAll("[data-dz-size]")[Symbol.iterator](), _step4; !(_iteratorNormalCompletion4 = (_step4 = _iterator4.next()).done); _iteratorNormalCompletion4 = true) {
                            node = _step4.value;
                            node.innerHTML = this.filesize(file.size);
                        }
                    } catch (err) {
                        _didIteratorError4 = true;
                        _iteratorError4 = err;
                    } finally {
                        try {
                            if (!_iteratorNormalCompletion4 && _iterator4["return"] != null) {
                                _iterator4["return"]();
                            }
                        } finally {
                            if (_didIteratorError4) {
                                throw _iteratorError4;
                            }
                        }
                    }

                    if (this.options.addRemoveLinks) {
                        file._removeLink = Dropzone.createElement("<a class=\"dz-remove\" href=\"javascript:undefined;\" data-dz-remove>".concat(this.options.dictRemoveFile, "</a>"));
                        file.previewElement.appendChild(file._removeLink);
                    }

                    var removeFileEvent = function removeFileEvent(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (file.status === Dropzone.UPLOADING) {
                            return Dropzone.confirm(_this2.options.dictCancelUploadConfirmation, function () {
                                return _this2.removeFile(file);
                            });
                        } else {
                            if (_this2.options.dictRemoveFileConfirmation) {
                                return Dropzone.confirm(_this2.options.dictRemoveFileConfirmation, function () {
                                    return _this2.removeFile(file);
                                });
                            } else {
                                return _this2.removeFile(file);
                            }
                        }
                    };

                    var _iteratorNormalCompletion5 = true;
                    var _didIteratorError5 = false;
                    var _iteratorError5 = undefined;

                    try {
                        for (var _iterator5 = file.previewElement.querySelectorAll("[data-dz-remove]")[Symbol.iterator](), _step5; !(_iteratorNormalCompletion5 = (_step5 = _iterator5.next()).done); _iteratorNormalCompletion5 = true) {
                            var removeLink = _step5.value;
                            removeLink.addEventListener("click", removeFileEvent);
                        }
                    } catch (err) {
                        _didIteratorError5 = true;
                        _iteratorError5 = err;
                    } finally {
                        try {
                            if (!_iteratorNormalCompletion5 && _iterator5["return"] != null) {
                                _iterator5["return"]();
                            }
                        } finally {
                            if (_didIteratorError5) {
                                throw _iteratorError5;
                            }
                        }
                    }
                }
            },
            success: function(file, response){
                // Look at the output in you browser console, if there is something interesting
                console.log(file.xhr.response);
                if (file.previewElement) {
                    return file.previewElement.classList.add("dz-success");
                }
            },
            uploadprogress: function ( file, progress){
                if (file.previewElement){
                    // $('#js-progressbar').attr('value', progress)
                    for (var _iterator8 = file.previewElement.querySelectorAll("[data-dz-uploadprogress]")[Symbol.iterator](), _step8; !(_iteratorNormalCompletion8 = (_step8 = _iterator8.next()).done); _iteratorNormalCompletion8 = true) {
                        var node = _step8.value;
                        node.nodeName === 'PROGRESS' ? node.value = progress : node.style.width = "".concat(progress, "%");
                    }
                }
            },

        });

    });
    @if(false)
{{--    @if(!empty($lesson))--}}
    $('.attach-media').click(function (){
        var btn = $(this);
        var bar = $('#js-progressbar');
        $('#js-progressbar').attr('value',0).hide();
        var form = $('#insertMediaModalForm')[0];
        var data = new FormData(form);
        var files = $('#upload_file')[0].files;
        if(files.length > 0 ){
            data.append('file',files[0]);
        }
        var itemId = "{{$lesson->id}}";
        var modelType = "{{addslashes($lesson->getClassName())}}";
        data.append('item_id',itemId);
        data.append('model_type',modelType);
       $('.process-icon').html('<span class="uk-text-primary"><div uk-spinner="ratio: 0.5"></div></span>')
        btn.attr('disabled', true);
        btn.html("{{__('main.Uploading')}}");
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "{{route('store.media.attach')}}",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            // xhr: function() {
            //     var xhr = new window.XMLHttpRequest();
            //     xhr.upload.addEventListener("progress", function(evt) {
            //         if (evt.lengthComputable) {
            //             var percentComplete = (evt.loaded / evt.total) * 100;
            //             var currentPercentage = percentComplete.toFixed(1);
            //             //Do something with upload progress here
            //             bar.show();
            //             bar.attr('value', percentComplete);
            //             if (percentComplete == 100){
            //                 currentPercentage = parseInt(percentComplete);
            //                 $('.process-status').html('<span class="uk-text-primary"> Processing: '+currentPercentage+'%</span>');
            //             }else {
            //                 $('.process-status').html('<span class="uk-text-primary"> Uploading: '+currentPercentage+'%</span>');
            //             }
            //
            //         }
            //     }, false);
            //     return xhr;
            // },
            complete: function (response){
                console.log(response)
                    {{--if (response.responseJSON != undefined){--}}
                    {{--    var resource = response.responseJSON;--}}
                    {{--    var status = resource.status;--}}
                    {{--    var type = resource.type;--}}
                    {{--    var url = resource.url;--}}
                    {{--    var id = resource.id;--}}
                    {{--    var video = null;--}}

                    {{--    if (status == {{\App\Modules\Media\Media::UPLOAD_TYPE_REFUSED}}){--}}
                    {{--        resetProgressBar();--}}
                    {{--        $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: ban"></span></span>')--}}
                    {{--        $('.process-status').html('<span class="uk-text-danger"> Canceled: 0%</span>');--}}
                    {{--        UIkit.notification("<span uk-icon='icon: warning'></span> "+ resource.message, {pos: 'top-center', status:'warning'})--}}
                    {{--    } else if(status = {{\App\Modules\Media\Media::UPLOAD_TYPE_COMPLETED}}){--}}
                    {{--        UIkit.notification("<span uk-icon='icon: check'></span> "+ resource.message, {pos: 'top-center', status:'success'})--}}
                    {{--        // insert media--}}
                    {{--        if (type == {{\App\Modules\Media\Media::TYPE_VIDEO}}){--}}
                    {{--            video = '<video src="'+url+'" muted playsinline controls disablepictureinpicture controlsList="nodownload"></video>';--}}
                    {{--        } else if (type == {{\App\Modules\Media\Media::TYPE_YOUTUBE}} || type == {{\App\Modules\Media\Media::TYPE_HTML_PAGE}}){--}}
                    {{--            video = '<iframe src="'+url+'" class="uk-responsive-width" width="1920" height="1080" controls controlsList="nodownload" frameborder="0" uk-responsive></iframe>';--}}
                    {{--        }--}}
                    {{--        $('.resource-items-list').append('' +--}}
                    {{--            '<li id="resource-'+id+'" class="resource-item" style="overflow: hidden">\n' +--}}
                    {{--            '    <div class="uk-card uk-card-default uk-card-body uk-padding-remove">\n' +--}}
                    {{--            '        <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger resource-delete" uk-icon="icon: trash"></span></div>\n' +--}}
                    {{--            '        <div>\n' +--}}
                    {{--            '           <input type="hidden" name="resourceId[]" value="'+id+'">\n' +--}}
                    {{--            '            '+video+'\n' +--}}
                    {{--            '        </div>\n' +--}}
                    {{--            '    </div>\n' +--}}
                    {{--            '</li>');--}}
                    {{--        deleteResourceItem();--}}
                    {{--        $('.process-icon').html('<span class="uk-text-success"><span uk-icon="icon: check"></span></span>')--}}
                    {{--        $('.process-status').html('<span class="uk-text-success"> Completed: 100%</span>');--}}

                    {{--    }--}}
                    {{--    resetUploadForm(false);--}}
                    {{--    btn.attr('disabled', false);--}}
                    {{--    btn.html("{{__('main.Start upload')}}");--}}
                    {{--}--}}
            },
            error: function (e) {
                resetProgressBar();
                console.log(e);
                UIkit.notification("<span uk-icon='icon: warning'></span> "+ e.statusText, {pos: 'top-center', status:'danger'})
                resetUploadForm();
                $('.process-icon').html('<span class="uk-text-danger"><span uk-icon="icon: ban"></span></span>')
                $('.process-status').html('<span class="uk-text-danger"> Canceled: 0%</span>');
                btn.attr('disabled', false);
                btn.html("{{__('main.Start upload')}}");
            }
        });
    });
    @endif
    function deleteResourceItem(){
        $('.resource-delete').click(function (){
            var btn = $(this);
            var resource =  btn.closest('.resource-item');
            var resourceId =  resource.attr('id').split('-')[1];
            if (!confirm("Are you sure that you want to delete this item?")){
                return false;
            }
            resource.remove();
            $('.removed-resources-items').append('<input type="hidden" name="removed-resources[]" value="'+resourceId+'">');
        });
    }
    deleteResourceItem();
</script>