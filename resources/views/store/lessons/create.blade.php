@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
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
                                {!! Form::text('title', !empty($lesson) ? $lesson->title : null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('main.Title')]) !!}
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
                                {!! Form::select('type', \App\Modules\Course\Lesson::TYPES_ARRAY,  !empty($lesson) ? $lesson->parent_id : null, ['class' => 'form-control lesson-type']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="presentations" class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Presentations and Multimedia')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.video link')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('video', !empty($lesson) && !empty($lesson->getLessonFirstMedia()) ? $lesson->media->first()->source : null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'https://youtu.be/example']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="quizzes" class="col-lg-12" style="display: none">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Quizzes')}}</p>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 text-right" style="padding: 10px">
                                <a href="" class="btn btn-primary">{{__('main.Add Quiz')}}</a>
                            </div>
                        </div>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">{{__('main.Quiz name')}}</th>
                                <th scope="col">{{__('main.Quiz Type')}}</th>
                                <th scope="col" width="30">{{__('main.Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="4" class="attachment-message">
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        @if(!empty($lesson))
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end">
                        <form id="delete-form" method="post" action="{{route('store.categories.destroy', $lesson->id)}}">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <button class="btn btn-danger btn-cat-delete"><i class="far fa-trash-alt"></i> {{__('Delete')}}</button>
                        </form>
                    </div>
                </div>
            </div>
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
