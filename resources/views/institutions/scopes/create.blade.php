@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $page_title)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')
    <section>
        @if(!empty($scope))
            {!! Form::open(['url' => route('institution.scopes.update', $scope->slug),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @else
            {!! Form::open(['url' => route('institution.scopes.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        @endif
        @include('manage.partials._page-header')
        <div class="form-panel row">
            <div class="col-lg-12">
                <div class="card border-light">
                    <div class="card-body">
                        <p>{{__('Basic input')}}</p>
                        <hr>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Scope Title')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::text('title',!empty($scope) ? $scope->title : null,['class' => 'form-control name','required' => true,'placeholder' => 'Scope Title']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                {!! Form::textarea('description',!empty($scope->description) ? $scope->description : null,['class' => 'form-control','rows' => '5']) !!}
                            </div>
                        </div>
                        <div class="form-group row col-lg-12">
                            <div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
                            <div class="col-lg-10 padding-0 margin-0">
                                <input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($scope) || !empty($scope->status) ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}


        @if(!empty($scope))
            <div class="col-lg-12">
                <div class="row col-lg-12 padding-0 margin-0">
                    <div class="col-lg-12 padding-0 margin-0">
                        <div class="card border-light">
                            <div class="card-body">
                                <p>{{__('Scope Fields')}}</p>
                                <hr>
                                <div class="text-right" style="padding-bottom: 10px">
                                    <a href="{{Route('institution.fields.create', $scope->slug)}}" class="btn btn-primary"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span> Add Attribute</span></a>
                                </div>
                                <div class="form-group row col-lg-12 padding-0 margin-0">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('Title')}}</th>
                                            <th scope="col">{{__('Description')}}</th>
                                            <th scope="col" class="text-center">{{__('Options No.')}}</th>
                                            <th scope="col" class="text-center">{{__('Status')}}</th>
                                            <th scope="col" class="text-center" width="50">{{__('Position')}}</th>
                                            <th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($scope->fields as $field)
                                            <tr class="row-click">
                                                <td>{{$field->title}}</td>
                                                <td>{{$field->description}}</td>
                                                <td class="text-center">{{$field->options->count()}}</td>
                                                <td class="text-center">{!! getStatusIcon($field->status) !!}</td>
                                                <td class="text-center">{{ $field->position }}</td>
                                                <td>
                                                    <div class="action_btn text-right" style="padding-top: 10px">
                                                        <ul>
{{--                                                            <li class="">--}}
{{--                                                                <a target="_blank" href="" class="btn btn-light disabled"><i class="fas fa-link" aria-hidden="true"></i></a>--}}
{{--                                                            </li>--}}
                                                            <li class="">
                                                                <a href="{{route('institution.fields.edit', [$scope->slug, $field->slug])}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                                            </li>
                                                            <li>
                                                                <span id="{{$field->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                                <form id="delete-form" method="post" action="{{route('institution.fields.destroy',[$scope->slug, $field->slug])}}">
                                                                    {{csrf_field()}}
                                                                    {{method_field('DELETE')}}
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </section>

@endsection
@section('script')

@endsection
