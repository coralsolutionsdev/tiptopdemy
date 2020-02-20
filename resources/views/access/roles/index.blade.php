@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$pageTitle)
@section('page-header-button')
    <a href="{{Route('roles.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
                        <th scope="col" width="30">{{__('Name')}}</th>
                        <th scope="col">{{__('Description')}}</th>
                        <th scope="col" class="text-center" width="400">{{__('Actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td class="align-middle">{{$role->display_name}}</td>
                            <td class="align-middle">{{$role->description}}</td>
                            <td>
                                <div class="action_btn text-right" style="padding-top: 10px">
                                    <ul>
                                        <li>
                                            <a href="{{route('assign.permissions',$role->id)}}" class="btn btn-outline-dark">Edit Permissions</a>
                                        </li>
                                        <li class="">
                                            <a target="_blank" href="" class="btn btn-light disabled"><i class="fas fa-link" aria-hidden="true"></i></a>
                                        </li>
                                        <li class="">
                                            <a href="{{route('roles.edit', $role->id)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                        </li>
                                        <li class="">
                                            <span id="{{$role->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                            <form id="delete-form" method="post" action="{{route('roles.destroy', $role->id)}}">
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
</section>
@endsection