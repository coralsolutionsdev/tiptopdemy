@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($group))
            {!! Form::open(['url' => route('store.groups.update', [$product->slug, $group->slug]),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('store.groups.store', $product->slug),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header-v2')
        <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('main.Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Title')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('title', !empty($group) ? $group->title : null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => __('main.Title')]) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',  !empty($group) ? $group->description : null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        @if(false)
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Parent Category')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
{{--                                {!! Form::select('parent_id', $categories,  !empty($group) ? $group->parent_id : null, ['class' => 'form-control']) !!}--}}
                            </div>
                        </div>
                        @endif
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Position')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('position', (!empty($group)) ? $group->position : 0, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('main.Status')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($group) || !empty($group->status) ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        @if(!empty($group))
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end">
                        <form id="delete-form" method="post" action="{{route('store.categories.destroy', $group->id)}}">
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
    @if(!empty($group))
    <script>
        var itemName = '{{$group->name}}';
        $('.btn-cat-delete').click(function () {
            if (!confirm('Are you sure you want to delete '+itemName+ '?')){
                return false;
            }
        });
    </script>
    @endif
@endsection
