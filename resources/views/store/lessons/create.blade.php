@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($lesson)? __('main.Save changes') : __('main.submit')}}</span></button>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
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
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',  !empty($lesson) ? $lesson->description : null, ['class' => 'form-control content-editor', 'rows' => '15']) !!}
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
            <div id="presentations" class="col-lg-12 {{(!empty($lesson) && $lesson->type != \App\Modules\Course\Lesson::TYPE_PRESENTATION) ? 'hidden-div' : ''}}">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Presentations and Multimedia')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Media items')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <div class="text-right">
                                    <div class="uk-inline">
                                        <button class="uk-button uk-button-default" type="button">{{__('main.Add Media Item')}}</button>
                                        <div uk-dropdown="mode: click">
                                            <ul class="uk-list uk-text-left">
                                                <li><a class="add-media-item" data-value="1"><span class="uk-text-primary"  uk-icon="icon: cloud-upload"></span>  Upload video</a></li>
                                                <li><a class="add-media-item" data-value="2"><span class="uk-text-danger" uk-icon="icon: youtube"></span>  YouTube video</a></li>
                                                <li><a class="add-media-item" data-value="3"><span class="" uk-icon="icon: code"></span>  HTML page</a></li>
                                            </ul>
                                        </div>
                                    </div>
{{--                                    <span class="btn btn-primary add-media-item"></span>--}}
                                </div>
                                <div class="media-items pt-2">
                                    @if(!empty($lesson) && !empty($lesson->media))
                                    @foreach($lesson->media as $media)
                                        <div class="row form-group media-item">
                                            <div class="col-7">
                                                <input type="text" name="media_url[{{$media->id}}]" value="{{$media->source}}" class="form-control">
                                            </div>
                                            <div class="col-4">
                                                <select class="form-control" name="media_type[{{$media->id}}]">
                                                    <option value="1" {{$media->type == 1 ? 'selected' : ''}}>Youtube</option>
                                                    <option value="2" {{$media->type == 2 ? 'selected' : ''}}>Html page</option>
                                                </select>
                                            </div>
                                            <div class="col-1">
                                                <span id="{{$media->id}}" class="btn btn-light btn-media-item-delete"><i class="far fa-trash-alt"></i></span>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

            <div id="quizzes" class="col-lg-12 {{empty($lesson) || (!empty($lesson) && $lesson->type != \App\Modules\Course\Lesson::TYPE_QUIZ) ? 'hidden-div' : ''}}">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Quizzes')}}</p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 text-right" style="padding: 10px">
                                @if(!empty($lesson))
                                    <!-- Button trigger modal -->
                                    <a href="{{route('store.get.form.templates', $lesson->slug)}}" class="uk-button uk-button-primary">
                                        {{__('main.Add Quiz')}}
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
                        <div class="uk-padding-small">
                            @if(!empty($lesson))
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{__('main.Quiz name')}}</th>
                                        <th scope="col">{{__('main.version')}}</th>
                                        <th scope="col">{{__('main.Items num.')}}</th>
                                        <th scope="col" width="150">{{__('main.Actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($lesson))
                                        @forelse($lesson->forms as $form)
                                            <tr>
                                                <td>{{$form->title}}</td>
                                                <td class="uk-text-success">{{$form->version}}.0</td>
                                                <td>{{$form->items->where('type', '!=', \App\Modules\Form\FormItem::TYPE_SECTION)->count()}}</td>
                                                <td>
                                                    <div class="action_btn">
                                                        <ul>
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
                                                <td colspan="4" class="uk-text-center">
                                                    {{__('main.There is no form items yet.')}}
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif
                                    </tbody>
                                </table>
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
            </div>
        </div>

        @if(!empty($lesson))
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="d-flex justify-content-end">--}}
{{--                        <form id="delete-form" method="post" action="{{route('store.categories.destroy', $lesson->id)}}">--}}
{{--                            {{csrf_field()}}--}}
{{--                            {{method_field('DELETE')}}--}}
{{--                            <button class="btn btn-danger btn-cat-delete"><i class="far fa-trash-alt"></i> {{__('Delete')}}</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        @endif

    </section>

@endsection
@section('script')
    @include('partial.scripts._tinyemc')
    <script>
        $('.lesson-type').change(function () {
            var item = $(this);
            var itemId = item.val();
            console.log(itemId);
            if(itemId == 1){
                $('#quizzes').slideUp();
                $('#presentations').slideDown();
            }else{
                $('#presentations').slideUp();
                $('#quizzes').slideDown();
            }
        });
        function deleteMediaItem(){
            $('.btn-media-item-delete').off('click');
            $('.btn-media-item-delete').click(function () {
                var item = $(this);
                if(!confirm('Are syou sure that you want to remove this item?')){
                    return false;
                }
                item.closest('.media-item').remove();
            });
        }
        deleteMediaItem();
        //
        $('.add-media-item').click(function () {

            var btn = $(this);
            var actionType = btn.attr('data-value');
            console.log(actionType);


            $('.media-items').append(
                '<div class="row form-group media-item">\n' +
                '<div class="col-7">\n' +
                '    <input type="text" name="new_media_url[]" class="form-control" placeholder="https://example.com/example_path">\n' +
                '</div>\n' +
                '<div class="col-4">\n' +
                '    <select class="form-control" name="new_media_type[]">\n' +
                '        <option value="1">Youtube</option>\n' +
                '        <option value="2">Html page</option>\n' +
                '    </select>\n' +
                '</div>\n' +
                '<div class="col-1">\n' +
                '    <span id="" class="btn btn-light btn-media-item-delete"><i class="far fa-trash-alt"></i></span>\n' +
                '</div>\n' +
                '</div>'
            );
            deleteMediaItem();
        });
    </script>
    @if(!empty($lesson))
    <script>
        var itemName = '{{$lesson->name}}';
        $('.btn-cat-delete').click(function () {
            if (!confirm('Are you sure you want to delete '+itemName+ '?')){
                return false;
            }
        });




    </script>
    @endif
@endsection
