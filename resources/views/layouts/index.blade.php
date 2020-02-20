@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <a href="{{Route('layouts.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('content')

<section>
    {{--Page header--}}
    @include('manage.partials._page-header')

    {{--List of items--}}
    <div>
        <div class="card border-light table-card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" width="100">{{trans('main._title')}}</th>
                        <th scope="col">{{__('description')}}</th>
                        <th scope="col" class="text-center">{{trans('main._status')}}</th>
                        <th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($layouts as $layout)
                        <tr>
                            <td class="align-middle">{{$layout->title}}</td>
                            <td class="align-middle">{{$layout->description}}</td>
                            <td id="status" class="text-center align-middle">
                                {!! getStatusIcon($layout->status) !!}
                            </td>
                            <td>
                                <div class="action_btn text-right" style="padding-top: 10px">
                                    <ul>
                                        <li class="">
                                            <a target="_blank" href="\" class="btn btn-light disabled"><i class="fas fa-link" aria-hidden="true"></i></a>
                                        </li>
                                        <li class="">
                                            <a href="{{route('layouts.edit', $layout->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                        </li>
                                        <li class="">
                                            <span id="{{$layout->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                            <form id="delete-form" method="post" action="{{route('layouts.destroy', $layout->id)}}">
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
    <div>
        {{$layouts->links()}}
    </div>
</section>
@endsection
