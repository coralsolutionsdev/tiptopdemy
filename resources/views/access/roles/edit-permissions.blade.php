@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$pageTitle)
@section('content')
    <form method="POST" action="{{route('assign.permissions.update', $role->id)}}" enctype="multipart/form-data" data-parsley-validate>
        {{csrf_field()}}
        {{method_field('PUT')}}
    <section class="page-header">
        <div class="row">
            <div class="col-md-6">
                <h2>@yield('title')</h2>
                <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._carousels')}}</p></small>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <div class="col-5">
                    <button type="submit" name="submit" class="btn btn-success btn-lg col-12" >{{trans('main._update')}}</button>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div>
            <h3 style="text-transform: capitalize">{{$role->name}}</h3>
        </div>
        <div class="row card border-light">
            <div class="">
                <table class="table table-hover" id="blog-table">
                    <thead>

                    <th width="20">#</th>
                    <th width="150">Name</th>
                    <th>Description</th>
                    <th class="text-center" width="100">{{trans('main._actions')}}</th>
                    </thead>
                    <tbody>
                    @foreach($permissions as $item)
                        <tr>
                            <td></td>
                            <td>{{$item->display_name}}</td>
                            <td>{{$item->description}}</td>
                            <td><input type="checkbox" name="permissions[{{$item->id}}]" class="toogle-switch" value="1" {{ $role->permissions->contains($item->id) ? 'checked' : '' }}>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>

                </table>


            </div>
        </div>
    </section>
    </form>
@endsection