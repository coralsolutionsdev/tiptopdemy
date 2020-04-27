@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{!empty($category)? __('main.Save changes') : __('main.submit')}}</span></button>

@endsection
@section('content')
    <section>
        @if(!empty($category))
            {!! Form::open(['url' => route('blog.categories.update', $category->slug),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('blog.categories.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
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
                                {!! Form::text('name', !empty($category) ? $category->name : null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('main.Title')]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',  !empty($category) ? $category->description : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Parent Category')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::select('parent_id', $categories,  !empty($category) ? $category->parent_id : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Position')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('position', (!empty($category)) ? $category->position : 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Status')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($category) || !empty($category->status) ? 'checked' : null}}>
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Show on menu')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="show_on_menu" class="toogle-switch" value="1" {{empty($category) || !empty($category->show_on_frontend) ? 'checked' : null}}>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Meta input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Meta Title')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('meta_title', !empty($category) ? $category->meta_title : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Meta Keywords')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('meta_keywords', !empty($category) ? $category->meta_keywords : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Meta Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('meta_description', !empty($category) ? $category->meta_description : null, ['class' => 'form-control', 'rows' => '4']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
            @if(!empty($category))
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end">
                        <form id="delete-form" method="post" action="{{route('store.categories.destroy', $category->id)}}">
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
    @if(!empty($category))
    <script>
        var catName = '{{$category->name}}';
        $('.btn-cat-delete').click(function () {
            if (!confirm('Are you sure you want to delete '+catName+ '?')){
                return false;
            }
        });
    </script>
    @endif
@endsection
