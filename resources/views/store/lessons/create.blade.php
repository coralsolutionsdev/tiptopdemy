@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')

    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($lesson)? __('main.Save changes') : __('main.submit')}}</span></button>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('plugins/dropzone/dropzone.css')}}">
    <script src="{{asset('/plugins/dropzone/dropzone.js')}}"></script>

@endsection
@section('content')
    <section>
        @if(!empty($lesson))
            {!! Form::open(['url' => route('store.lessons.update', [$product->slug, $lesson->slug]),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('store.lessons.store', $product->slug),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header')
        <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Title')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('title', !empty($lesson) ? $lesson->title : null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('main.Title'), 'required' => true]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Description')}}</div>
                            <div class="col-lg-10 uk-padding-remove margin-0 uk-text-center">
                                {!! Form::textarea('description',  !empty($lesson) ? $lesson->description : null, ['class' => 'form-control content-editor', 'rows' => '20']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Content')}}</div>
                            <div class="col-lg-10 uk-padding margin-0 uk-placeholder uk-text-center">
                                @if(!empty($lesson))
                                <a class="uk-button uk-button-primary" href="{{route('store.lesson.edit.content', [$product->slug, $lesson->slug])}}"><span uk-icon="icon: thumbnails"></span> edit content with page builder</a>
                                @else
                                    <div class="uk-alert-warning" uk-alert>
                                        <p>
                                            {{__('main.Please create a lesson first.')}}
                                        </p>
                                    </div>

                                @endif
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Parent Category')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('groups', $groups,  !empty($selectedGroups) ? $selectedGroups : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Position')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('position', (!empty($lesson)) ? $lesson->position : 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Status')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($lesson) || !empty($lesson->status) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Type')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('type', \App\Modules\Course\Lesson::TYPES_ARRAY,  !empty($lesson) ? $lesson->type : null, ['class' => 'form-control lesson-type']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="attachments" class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Attachments')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Add attachment')}}</div>
                            <div class="col-lg-5" style="padding: 10px 0 10px 10px; margin: 0px">
                                <div class="custom-file">
                                    <input type="file" name="attachments[]" multiple >
                                </div>
                            </div>
                        </div>

                        @if(!empty($attachments))
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('main.File name')}}</th>
                                    <th scope="col">{{__('main.File Type')}}</th>
                                    <th scope="col">{{__('main.Download link')}}</th>
                                    <th scope="col" width="30">{{__('main.Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attachments as $attachment)
                                    {{--                                {{dd($attachment)}}--}}
                                    <tr>
                                        <td>{{$attachment->filename}}</td>
                                        <td>{{$attachment->filetype}}</td>
                                        <td><a target="_blank" href="{{$attachment->getTemporaryUrl(\Carbon\Carbon::parse(date('y-m-d'))->addDay())}}">Download</a></td>
                                        <td><span id="{{$attachment->key}}" class="btn btn-light btn-delete delete-attachment"><i class="far fa-trash-alt"></i></span></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" class="attachment-message">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
            <div id="presentations" class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Presentations and Multimedia')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            @if(!empty($lesson))
                                <div class="col-lg-2 uk-padding">{{__('main.Media items')}}</div>
                                <div class="col-lg-10 padding-0 margin-0">
                                <div class="text-right">
                                    <a href="#insertMediaModal" class="uk-button uk-button-default open-insert-media-modal" uk-toggle><span uk-icon="plus-circle"></span> {{__('main.Add Media Item')}}</a>
                                </div>
                                <div class="media-items pt-2">
                                    <ul class="uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s resource-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid="masonry: true">
                                            @if(!empty($lesson->resources))
                                                @foreach($lesson->resources as $resource)
                                                <li id="resource-{{$resource['id']}}" class="resource-item" style="overflow: hidden">
                                                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                                                        <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger resource-delete" uk-icon="icon: trash"></span></div>
                                                        <div>
                                                            <input type="hidden" name="resourceId[]" value="{{$resource['id']}}">
                                                            @if($resource['type'] == \App\Modules\Media\Media::TYPE_VIDEO)
                                                                <video src="{{$resource['url']}}" loop muted playsinline controls disablepictureinpicture controlsList="nodownload"></video>
                                                            @elseif($resource['type'] == \App\Modules\Media\Media::TYPE_YOUTUBE || $resource['type'] == \App\Modules\Media\Media::TYPE_HTML_PAGE)
                                                                <iframe src="{{$resource['url']}}" class="uk-responsive-width" width="1920" height="1080" controls controlsList="nodownload" frameborder="0" uk-responsive></iframe>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                </div>
                            </div>
                            @else
                                <div class="col-lg-12 p-0 m-0">
                                    <div class="uk-placeholder uk-text-center">
                                        <div class="uk-alert-warning" uk-alert>
                                            <p>
                                                {{__('main.Please create a lesson first.')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="removed-resources-items">

                </div>
            </div>
            {!! Form::close() !!}

            <div id="quizzes" class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Quizzes')}}</p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 text-right" style="padding: 10px">
                                @if(!empty($lesson))
                                    <!-- Button trigger modal -->
                                    <a href="{{route('store.get.form.templates', $lesson->slug)}}" class="uk-button uk-button-default">
                                        <span uk-icon="plus-circle"></span> {{__('main.Add Quiz')}}
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add new Quiz</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="uk-flex uk-flex-center actions-section">
                                                        <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid style="padding:10px 20px; width: 60%">
                                                            <div>
                                                                <a href="{{route('store.form.create', $lesson->slug)}}">
                                                                    <div class="uk-card uk-card-default uk-card-body uk-text-primary border-primary uk-box-shadow-hover-large">
                                                                        <div class="uk-padding-small"><span uk-icon="icon: plus-circle; ratio: 3"></span></div>
                                                                        <label>Create new</label>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <div class="uk-card uk-card-default uk-card-body uk-text-primary border-primary uk-box-shadow-hover-large show-template-section">
                                                                    <div class="uk-padding-small"><span uk-icon="icon: copy; ratio: 3"></span></div>
                                                                    <label>Clone Template</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="templates-section hidden-div">
                                                        <div class="uk-grid-small uk-child-width-expand@s uk-text-left" uk-grid style="padding:0px 20px;">
                                                            <div class="uk-width-1-3">
                                                                {{drawInputTreeListItems($categories, 'categories[]',!empty($selectedCategories) ? $selectedCategories : array(), 'checktree')}}
                                                            </div>
                                                            <div class="uk-width-2-3">
                                                                <div class="uk-text-center">{{__('main.There is no form items yet.')}}</div>
                                                                <div class="uk-grid-collapse" uk-grid>
                                                                    <div>
                                                                        text
                                                                    </div>
                                                                    <div>
                                                                        <a class="uk-button uk-button-default" href="">Apply</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <script>
                                                        $('.show-template-section').click(function () {
                                                            $('.actions-section').slideUp(function () {
                                                                $('.templates-section').fadeIn();
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                @endif
                            </div>
                        </div>
                        @if(!empty($lesson))
                        <div class="uk-padding-small">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('main.Quiz name')}}</th>
                                    <th scope="col" class="uk-text-center">{{__('main.Display type')}}</th>
                                    <th scope="col" class="uk-text-center">{{__('main.version')}}</th>
                                    <th scope="col" class="uk-text-center">{{__('main.Items num.')}}</th>
                                    <th scope="col" class="uk-text-center">{{__('main.Status')}}</th>
                                    <th scope="col" width="200">{{__('main.Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($lesson))
                                    @forelse($lesson->getFormsWithType(\App\Modules\Form\Form::TYPE_FORM) as $form)
                                        <tr>
                                            <td>{{$form->title}}</td>
                                            <td class="uk-text-center">{{!empty($form->properties) && $form->properties['display_type'] == 1 ? 'Modern' : 'Classic'}}</td>
                                            <td class="uk-text-success uk-text-center">{{$form->version}}.0</td>
                                            <td class="uk-text-center">{{$form->items->where('type', '!=', \App\Modules\Form\FormItem::TYPE_SECTION)->count()}}</td>
                                            <td class="uk-text-center">{{\App\Modules\Form\Form::STATUS_ARRAY[$form->status]}}</td>
                                            <td>
                                                <div class="action_btn">
                                                    <ul>
                                                        <li class="">
                                                            <span onclick="copyLink(this)" date-link="{{route('store.form.show', [$lesson->slug, $form->hash_id])}}" class="btn btn-light hover-primary" uk-tooltip="Copy link"><i class="fas fa-link"></i></span>
                                                        </li>
                                                        <li class="">
                                                            <a href="{{route('store.form.edit', [$lesson->slug, $form->hash_id])}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                                        </li>
                                                        <li class="">
                                                            <span id="{{$form->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                            <form id="delete-form" method="post" action="{{route('store.form.destroy', [$lesson->slug, $form->hash_id])}}">
                                                                {{csrf_field()}}
                                                                {{method_field('DELETE')}}
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="uk-text-center">
                                                {{__('main.There is no form items yet.')}}
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="uk-placeholder uk-text-center">
                                <div class="uk-alert-warning" uk-alert>
                                    <p>
                                        {{__('main.Please create a lesson first.')}}
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            <div id="memorize" class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Memorizes')}}</p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 text-right" style="padding: 10px">
                            @if(!empty($lesson))
                                <!-- Button trigger modal -->
                                <a href="{{route('store.memorize.create', $lesson->slug)}}" class="uk-button uk-button-default">
                                    <span uk-icon="plus-circle"></span> {{__('main.Add Quiz')}}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(!empty($lesson))
                        <div class="uk-padding-small">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">{{__('main.Quiz name')}}</th>
                                    <th scope="col" class="uk-text-center">{{__('main.Items num.')}}</th>
                                    <th scope="col" class="uk-text-center">{{__('main.Status')}}</th>
                                    <th scope="col" width="150">{{__('main.Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($lesson))
                                    @forelse($lesson->getFormsWithType(\App\Modules\Form\Form::TYPE_MEMORIZE) as $form)
                                        <tr>
                                            <td>{{$form->title}}</td>
                                            <td class="uk-text-center">{{$form->items->where('type', '!=', \App\Modules\Form\FormItem::TYPE_SECTION)->count()}}</td>
                                            <td class="uk-text-center">{!! getStatusIcon($form->status) !!}</td>
                                            <td>
                                                <div class="action_btn">
                                                    <ul>
                                                        <li class="">
                                                            <a href="{{route('store.memorize.edit', [$lesson->slug, $form->hash_id])}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                                        </li>
                                                        <li class="">
                                                            <span id="{{$form->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                            <form id="delete-form" method="post" action="{{route('store.form.destroy', [$lesson->slug, $form->hash_id])}}">
                                                                {{csrf_field()}}
                                                                {{method_field('DELETE')}}
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="uk-text-center">
                                                {{__('main.There is no form items yet.')}}
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="uk-placeholder uk-text-center">
                            <div class="uk-alert-warning" uk-alert>
                                <p>
                                    {{__('main.Please create a lesson first.')}}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </section>

    <section>
        <div id="insertMediaModal" uk-modal="bg-close: false">
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h5 class="">{{__('main.Media items')}}</h5>
{{--                <form id="insertMediaModalForm" action="" method="POST" enctype="multipart/form-data">--}}
                    <div>
                        <ul uk-tab class="uk-flex-center media-tabs">
                            <li><a class="media-tab-item" href="#" data-value="{{\App\Modules\Media\Media::TYPE_VIDEO}}"><span class="uk-text-primary" uk-icon="icon: cloud-upload"></span> {{__('main.Upload a new video')}}</a></li>
                            <li><a class="media-tab-item" href="#" data-value="{{\App\Modules\Media\Media::TYPE_HTML_PAGE}}"><span class="uk-text-primary" uk-icon="icon: code"></span> {{__('main.Embed')}}</a></li>
                        </ul>
                        <ul class="uk-switcher uk-margin-small uk-margin-remove-bottom">
                            <li>
                                <div class="uk-margin-small">
                                    <label class="uk-form-label" for="form-stacked-text">{{__('main.Video upload')}}</label>
{{--                                    <div id="mydropzone" class="dropzone uk-placeholder uk-margin-remove">--}}
{{--                                    </div>--}}
                                    <div class="uk-placeholder uk-margin-remove uk-padding-remove uk-flex uk-flex-center">
                                        @if(!empty($lesson))
                                        <form id="dropzoneForm" action="{{route('store.media.attach')}}" class="dropzone uk-width-1-1 uk-flex uk-flex-center" id="myAwesomeDropzone" enctype="multipart/form-data">
                                            @csrf
                                        </form>
                                        @endif
                                    </div>
                                    <div class="uk-margin-small">
                                        <span class="process-icon"></span> <span class="process-status"></span>
                                    </div>
                                    <p class="uk-text-right">
                                        <button id="dropZoneCancelUpload" class="uk-button uk-button-danger" type="button" style="display: none">Cancel</button>
                                        <button id="dropZoneStartUpload" class="uk-button uk-button-primary" type="button">{{__('main.Start upload')}}</button>
                                    </p>
                                </div>
                            </li>
                            <li>
                                <div class="uk-margin-small">
                                    <div class="uk-form-label">Embed URL</div>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" name="media_type">
                                            <option value="{{\App\Modules\Media\Media::TYPE_YOUTUBE}}" selected>{{__('main.Youtube')}}</option>
                                            <option value="{{\App\Modules\Media\Media::TYPE_HTML_PAGE}}">{{__('main.HTML page')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <div class="uk-form-label">Embed link</div>
                                    <div class="uk-form-controls">
                                        <input class="uk-input" name="embed_url" type="text">
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <span class="process-icon"></span> <span class="process-status"></span>
                                </div>
                                <p class="uk-text-right">
                                    <button id="resourceCancelUpload" class="uk-button uk-button-danger" type="button" style="display: none">Cancel</button>
                                    <button id="resourceStartUpload" class="uk-button uk-button-primary" type="button">{{__('main.Start upload')}}</button>
                                </p>
                            </li>
                        </ul>
{{--                        <div>--}}
{{--                            <progress id="js-progressbar" class="uk-progress" value="0" max="100"></progress>--}}
{{--                        </div>--}}
                    </div>
{{--                </form>--}}
            </div>
        </div>
    </section>

@endsection
@section('script')
    @include('partial.scripts._tinyemc')
    @include('store.lessons._scripts')
    @if(!empty($lesson))
    <script>
        function copyLink(event) {
            var text = $(event).attr('date-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
            UIkit.notification("<span uk-icon='icon: check'></span> File url copied to clipboard.", {pos: 'top-center', status:'success'})
        }

        var itemName = '{{$lesson->name}}';
        $('.btn-cat-delete').click(function () {
            if (!confirm('Are you sure you want to delete '+itemName+ '?')){
                return false;
            }
        });
        function deleteAttachment()
        {
            $('.delete-attachment').click(function () {
                $('.attachment-message').html('<span class="uk-text-warning uk-flex uk-flex-middle"><span uk-spinner="ratio: 0.5" class="uk-margin-small-left uk-margin-small-right"></span> Deleting attachment .., Please wait</span>\n');
                var lessonId = '{{!empty($lesson->slug) ?  $lesson->slug : ''}}';
                var item = $(this);
                var key = item.attr('id');
                $.post('/manage/store/lesson/'+lessonId+'/attachment/'+key+'/delete').done(function (response) {
                    item.parent().parent().remove();
                    $('.attachment-message').html('<span class="text-success"><i class="far fa-check-circle"></i> attachment deleted</span>\n');
                });
            });
        }
        deleteAttachment();

    </script>
    @endif
@endsection
